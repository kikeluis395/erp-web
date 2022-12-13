<?php

namespace App\Http\Controllers\CarroceriaPintura;

// use DB;
use Auth;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Modelos\TipoOT;
use App\Modelos\Ubigeo;
use App\Modelos\CiaSeguro;
use App\Modelos\Descuento;
use App\Modelos\MarcaAuto;
use App\Modelos\Proveedor;
use App\Modelos\Cotizacion;
use App\Modelos\TipoCambio;
use App\Modelos\CitaEntrega;
use App\Modelos\HojaTrabajo;
use App\Modelos\RecepcionOT;
use Illuminate\Http\Request;
use App\Modelos\ModeloTecnico;
use App\Modelos\DetalleTrabajo;
use App\Modelos\ServicioTercero;
use App\Modelos\OperacionTrabajo;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\PrecioDYP;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\Modelo;
use App\Modelos\TrackDeletedTransactions;
use App\Modelos\ServicioTerceroSolicitado;
use Illuminate\Support\Facades\DB;

class DetalleTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departamentos = Ubigeo::departamentos();
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $modelosTecnicos = ModeloTecnico::all();
        $modelos = Modelo::orderBy('nombre_modelo')->get();
        //$modelos = [];

        if ($request->id_recepcion_ot) {
            session()->forget(['hojaTrabajo', 'recepcionOT', 'cotizacion']);

            $id_hoja_trabajo = HojaTrabajo::select('id_hoja_trabajo')->where('id_recepcion_ot', $request->id_recepcion_ot)->first()->id_hoja_trabajo;
            $cant_descuentos = Descuento::where('id_hoja_trabajo', $id_hoja_trabajo)->get()->count();

            if ($cant_descuentos == 0) {
                # SE GENERA ESTE DESCUENTO INICIAL DE 0 PARA QUE SE PUEDAN APLICAR DESCUENTOS UNITARIOS
                # NO AFECTARÁ EN NADA DADO A QUE ES UN DESCUENTO DE 0
                $descuento = new Descuento();
                $descuento->porcentaje_aplicado_mo = 0;
                $descuento->porcentaje_aplicado_lubricantes = 0;
                $descuento->porcentaje_aplicado_rptos = 0;
                $descuento->porcentaje_aplicado_servicios_terceros = 0;
                $descuento->es_aprobado = 3;
                $descuento->id_hoja_trabajo = $id_hoja_trabajo;
                $descuento->dni_solicitante = '1';
                $descuento->fecha_registro = Carbon::now();
                $descuento->save();
            }

            $recepcionOT = RecepcionOT::with('hojaTrabajo.detallesTrabajo.operacionTrabajo')
                ->where((new RecepcionOT)->getKeyName(), $request->id_recepcion_ot)
                ->first();
            // $recepcionOT->updatePrecio();
            $detallesTrabajo = $recepcionOT->getDetallesTrabajoCompleto(); //getHojaTrabajo()->detallesTrabajo;
            //dd($

            $estadoOT = $recepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno;
            if (RecepcionOT::has('entregas')->where('id_recepcion_ot', $request->id_recepcion_ot)->get()->count() > 0) {
                $estadoOT = 'facturado';
            }

            $cotizacionesAsociablesPre = $recepcionOT->cotizacionesAsociables();
            $cotizacionesAsociables = [];
            foreach ($cotizacionesAsociablesPre as $key => $cotizacion) {
                $id_cotizacion = $cotizacion->id_cotizacion;
                $fecha_registro = $cotizacion->getHojaTrabajo()->fecha_registro;
                $objeto_entrega = (object)[
                    'nroCotizacion' => $id_cotizacion,
                    'fecha_registro' => Carbon::parse($fecha_registro)->format('d/m/Y H:i')
                ];
                array_push($cotizacionesAsociables, $objeto_entrega);
            }

            $proveedores = Proveedor::all();
            //$moneda = session('moneda');
            $itemsNecesidadRepuestos = $recepcionOT->getAllItemsNecesidadRepuestos();
            $serviciosTerceros = $recepcionOT->getServiciosTerceros();
            $tiposOT = TipoOT::getAll('DYP');
            $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();

            //TOTALES
            $hojaTrabajo = $recepcionOT->hojaTrabajo;
            $moneda = $hojaTrabajo->moneda;
            $monedaCalculos = $moneda == "SOLES" ? "PEN" : "USD";
            $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
            $totalServicios = 0;
            $totalServiciosDescuento = 0;
            foreach ($detallesTrabajo as $key => $detalleTrabajo) {
                $totalServicios += $detalleTrabajo->getPrecioLista($monedaCalculos);
                $totalServiciosDescuento += $detalleTrabajo->getDescuento($monedaCalculos);
            }

            $totalRepuestos = 0;
            $totalRepuestosDescuento = 0;
            $totalDescuentoMarca = 0;
            $totalDescuentoDealer = 0;
            $repuestosAprobados = collect([]);
            $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();

            if ($necesidadRepuestos) {
                $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
                if ($repuestosAprobados->count() == 0) $repuestos = [];

                foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                    $totalRepuestos += $repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(), true);
                    #return $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(),true, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer);
                    $totalRepuestosDescuento += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer ?? -1);
                    $totalDescuentoMarca += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, 0);
                }
            }

            $serviciosTerceros = $recepcionOT->getServiciosTerceros();
            $totalServiciosTerceros = 0;
            $totalServiciosTercerosDescuento = 0;
            foreach ($serviciosTerceros as $key => $servicioTercero) {
                $totalServiciosTerceros += $servicioTercero->getSubTotal($monedaCalculos);
                $totalServiciosTercerosDescuento += $servicioTercero->getDescuento($monedaCalculos);
            }

            $totalDescuentos = $totalServiciosDescuento + $totalRepuestosDescuento + $totalServiciosTercerosDescuento;
            $totalCotizacion = $totalServicios + $totalRepuestos + $totalServiciosTerceros - $totalDescuentos;

            $desc_alerta = 3;

            $desc_desaprobados = RecepcionOT::whereHas('hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos', function ($q) {
                $q->where('descuento_unitario_dealer_aprobado', '=', 0);
            })->where('id_recepcion_ot', $request->id_recepcion_ot)->get();
            $desc_aprobados = RecepcionOT::whereHas('hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos', function ($q) {
                $q->where('descuento_unitario_dealer_aprobado', '=', 1);
            })->where('id_recepcion_ot', $request->id_recepcion_ot)->get();
            $desc_pendientes = RecepcionOT::whereHas('hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos', function ($q) {
                $q->where('descuento_unitario_dealer_aprobado', '=', 2);
            })->where('id_recepcion_ot', $request->id_recepcion_ot)->get();

            if ($desc_desaprobados->count() > 0) $desc_alerta = 0;
            if ($desc_aprobados->count() > 0) $desc_alerta = 1;
            if ($desc_pendientes->count() > 0) $desc_alerta = 2;

            // return $recepcionOT->tipoOT();
            $esEditableOT = Auth::user()->puedeEditarDetalleTrabajo() && $recepcionOT->esEditableOt();
            $det = $detallesTrabajo->first();
            return view('detalleTrabajo', [
                'id_recepcion_ot' => $recepcionOT->id_recepcion_ot,
                'datosRecepcionOT' => $recepcionOT,
                'desc_alerta' => $desc_alerta,
                'datosHojaTrabajo' => $recepcionOT->hojaTrabajo,
                'listaMarcas' => $marcasAuto,
                'listaEliminados' => $det != null ? $det->getDeletedTransactionsOT() : null,
                'listaDepartamentos' => $departamentos,
                'listaModelosTecnicos' => $modelosTecnicos,
                'listaModelos' => $modelos,
                'listaDetallesTrabajo' => $detallesTrabajo,
                'listaCotizacionesAsociables' => $cotizacionesAsociables,
                'listaRepuestosSolicitados' => $itemsNecesidadRepuestos,
                'listaServiciosTerceros' => $serviciosTerceros,
                'listaProveedores' => $proveedores,
                'listaTiposOT' => $tiposOT,
                'listaSeguros' => $seguros,
                'moneda' => $moneda,
                'monedaCalculos' => $monedaCalculos,
                'nombreCiaSeguro' => $recepcionOT->ciaSeguro ? $recepcionOT->getNombreCiaSeguro() : '---',
                'valorRepuestos' => $recepcionOT->ultValuacion() ? number_format($recepcionOT->ultValuacion()->valor_repuestos, 2) : '---',
                'fechaAprobacion' => $recepcionOT->ultValuacion() ? Carbon::parse($recepcionOT->ultValuacion()->fecha_aprobacion_cliente)->format('d/m/Y') : '---',
                'refreshable' => false,
                'totalServicios' => number_format($totalServicios, 2),
                'totalRepuestos' => number_format($totalRepuestos, 2),
                'totalServiciosTerceros' => number_format($totalServiciosTerceros, 2),
                'totalDescuentoMarca' => number_format($totalDescuentoMarca, 2),
                'totalDescuentoDealer' => number_format($totalDescuentos - $totalDescuentoMarca, 2),
                'totalDescuentos' => number_format($totalDescuentos, 2),
                'totalCotizacion' => number_format($totalCotizacion, 2),
                'esEditableOT' => $esEditableOT,
                'estadoOT' => $estadoOT
            ]);
        }

        if ($request->id_cotizacion) {
            session()->forget(['hojaTrabajo', 'recepcionOT', 'cotizacion']);
            $cotizacion = Cotizacion::with('hojaTrabajo.detallesTrabajo.operacionTrabajo')
                ->where('id_cotizacion', $request->id_cotizacion)
                ->first();
            // $cotizacion->updatePrecio();
            $detallesTrabajo = $cotizacion->getDetallesTrabajoCompleto();
            $OTsAsociablesPre = $cotizacion->OTsAsociables();
            $OTsAsociables = [];
            foreach ($OTsAsociablesPre as $key => $otAsociable) {
                $nroOT = $otAsociable->getNroOT();
                $fecha_registro = $otAsociable->getHojaTrabajo()->fecha_registro;
                $objeto_entrega = (object)[
                    'id_recepcion_ot' => $otAsociable->id_recepcion_ot,
                    'nroOT' => $nroOT,
                    'fecha_registro' => Carbon::parse($fecha_registro)->format('d/m/Y H:i')
                ];
                array_push($OTsAsociables, $objeto_entrega);
            }

            $proveedores = Proveedor::all();
            //$moneda = session('moneda');
            $itemsNecesidadRepuestos = $cotizacion->getAllItemsNecesidadRepuestos();
            $serviciosTerceros = $cotizacion->getServiciosTerceros();
            $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();

            //ACA OWO
            $hojaTrabajo = $cotizacion->hojaTrabajo;
            $moneda = $hojaTrabajo->moneda;
            $monedaCalculos = $moneda == "SOLES" ? "PEN" : "USD";
            $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
            $totalServicios = 0;
            $totalServiciosDescuento = 0;
            foreach ($detallesTrabajo as $key => $detalleTrabajo) {
                $totalServicios += $detalleTrabajo->getPrecioLista($monedaCalculos);
                $totalServiciosDescuento += $detalleTrabajo->getDescuento($monedaCalculos);
            }

            $totalRepuestos = 0;
            $totalRepuestosDescuento = 0;
            $totalDescuentoMarca = 0;
            $totalDescuentoDealer = 0;
            $repuestosAprobados = collect([]);
            $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
            if ($necesidadRepuestos) {
                $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
                if ($repuestosAprobados->count() == 0) $repuestos = [];
                foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                    $totalRepuestos += $repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(), true);
                    $totalRepuestosDescuento += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer ?? -1);
                    $totalDescuentoMarca += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, 0);
                }
            }

            $serviciosTerceros = $cotizacion->getServiciosTerceros();
            $totalServiciosTerceros = 0;
            $totalServiciosTercerosDescuento = 0;
            foreach ($serviciosTerceros as $key => $servicioTercero) {
                $totalServiciosTerceros += $servicioTercero->getSubTotal($monedaCalculos);
                $totalServiciosTercerosDescuento += $servicioTercero->getDescuento($monedaCalculos);
            }

            $totalDescuentos = $totalServiciosDescuento + $totalRepuestosDescuento + $totalServiciosTercerosDescuento;
            $totalCotizacion = $totalServicios + $totalRepuestos + $totalServiciosTerceros - $totalDescuentos;

            $esEditableCot = Auth::user()->puedeEditarDetalleTrabajo() && $cotizacion->es_habilitado === 1 && $cotizacion->doesntHave('recepcionOT');

            $det = $detallesTrabajo->first();
            return view('detalleTrabajo', [
                'id_cotizacion' => $cotizacion->id_cotizacion,
                'datosRecepcion' => $cotizacion,
                'datosHojaTrabajo' => $cotizacion->hojaTrabajo,
                'listaEliminados' => $det != null ? $det->getDeletedTransactionsCot() : null,
                'listaDetallesTrabajo' => $detallesTrabajo,
                'listaMarcas' => $marcasAuto,
                'listaDepartamentos' => $departamentos,
                'listaModelosTecnicos' => $modelosTecnicos,
                'listaModelos' => $modelos,
                'listaOTsAsociables' => $OTsAsociables,
                'listaRepuestosSolicitados' => $itemsNecesidadRepuestos,
                'listaServiciosTerceros' => $serviciosTerceros,
                'listaProveedores' => $proveedores,
                'listaSeguros' => $seguros,
                'moneda' => $moneda,
                'monedaCalculos' => $monedaCalculos,
                'nombreCiaSeguro' => $cotizacion->ciaSeguro ? $cotizacion->ciaSeguro->nombre_cia_seguro : '-',
                'valorRepuestos' => '---',
                'fechaAprobacion' => '---',
                'refreshable' => false,
                'totalServicios' => number_format($totalServicios, 2),
                'totalRepuestos' => number_format($totalRepuestos, 2),
                'totalServiciosTerceros' => number_format($totalServiciosTerceros, 2),
                'totalDescuentos' => number_format($totalDescuentos, 2),
                'totalDescuentoMarca' => number_format($totalDescuentoMarca, 2),
                'totalDescuentoDealer' => number_format($totalDescuentos - $totalDescuentoMarca, 2),
                'totalCotizacion' => number_format($totalCotizacion, 2),
                'esEditableCot' => $esEditableCot,
                'estadoOT' => ''
            ]);
        }

        // Para segundos pasos
        if (session('recepcionOT')) {
            $recepcionOT = session('recepcionOT');
            $hojaTrabajo = session('hojaTrabajo');
            //$moneda = session('moneda');
            $moneda = $hojaTrabajo->moneda;
            $monedaCalculos = $moneda == "SOLES" ? "PEN" : "USD";
            $nombreCiaSeguro = CiaSeguro::find($recepcionOT->id_cia_seguro)->nombre_cia_seguro;
            $tiposOT = TipoOT::getAll('DYP');
            $esEditableOT = true;
            $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
            // session()->forget('hojaTrabajo');
            // session()->forget('recepcionOT');
            return view('detalleTrabajo', [
                'datosRecepcionOT' => $recepcionOT,
                'datosHojaTrabajo' => $hojaTrabajo,
                'listaDetallesTrabajo' => [],
                'listaRepuestosSolicitados' => [],
                'listaServiciosTerceros' => [],
                'listaTiposOT' => $tiposOT,
                'listaDepartamentos' => $departamentos,
                'listaMarcas' => $marcasAuto,
                'listaModelosTecnicos' => $modelosTecnicos,
                'listaModelos' => $modelos,
                'listaSeguros' => $seguros,
                'moneda' => $moneda,
                'monedaCalculos' => $monedaCalculos,
                'nombreCiaSeguro' => $nombreCiaSeguro,
                'valorRepuestos' => '',
                'fechaAprobacion' => '',
                'refreshable' => false,
                'esEditableOT' => $esEditableOT,
                'estadoOT' => ''
            ]);
        }

        if (session('cotizacion')) {
            $cotizacion = session('cotizacion');
            $hojaTrabajo = session('hojaTrabajo');
            //$moneda = session('moneda');
            $moneda = $hojaTrabajo->moneda;
            $monedaCalculos = $moneda == "SOLES" ? "PEN" : "USD";
            $nombreCiaSeguro = CiaSeguro::find($cotizacion->id_cia_seguro)->nombre_cia_seguro;
            $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
            $esEditableCot = true;
            // session()->forget('hojaTrabajo');
            // session()->forget('cotizacion');
            return view('detalleTrabajo', [
                'datosRecepcion' => $cotizacion,
                'datosHojaTrabajo' => $hojaTrabajo,
                'listaDetallesTrabajo' => [],
                'listaRepuestosSolicitados' => [],
                'listaServiciosTerceros' => [],
                'listaDepartamentos' => $departamentos,
                'listaMarcas' => $marcasAuto,
                'listaModelosTecnicos' => $modelosTecnicos,
                'listaModelos' => $modelos,
                'listaSeguros' => $seguros,
                'moneda' => $moneda,
                'monedaCalculos' => $monedaCalculos,
                'nombreCiaSeguro' => $nombreCiaSeguro,
                'valorRepuestos' => '---',
                'fechaAprobacion' => '---',
                'refreshable' => false,
                'esEditableCot' => $esEditableCot,
                'estadoOT' => ''
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function solicitarDescuentoDealerUnitario()
    {

        $data = [];

        foreach (request()->all() as $index => $value) {
            if (substr($index, 0, 11) === 'desc_dealer') {
                $data[$index] = $value;
            }
        }

        $cotizacion = isset(request()->cotizacion) && request()->cotizacion ? true : false;

        DB::beginTransaction();
        foreach ($data as $index => $input) {
            $id = explode("-", $index);
            $itemsNecesidadRepuestos = ItemNecesidadRepuestos::findOrFail($id[1]);
            $id_repuesto = $itemsNecesidadRepuestos->id_repuesto;
            $desc_dealer = $itemsNecesidadRepuestos->descuento_unitario_dealer;
            $desc_dealer_por_aprobar = $itemsNecesidadRepuestos->descuento_unitario_dealer_por_aprobar;

            if ($cotizacion) {

                $itemsNecesidadRepuestos->descuento_unitario_dealer = $input;
                $itemsNecesidadRepuestos->descuento_unitario_dealer_aprobado = 1;
                $itemsNecesidadRepuestos->save();
            } else if (($id_repuesto && $desc_dealer != $input) || !is_null($desc_dealer_por_aprobar)) {

                $itemsNecesidadRepuestos->descuento_unitario_dealer_por_aprobar = $input;
                $itemsNecesidadRepuestos->descuento_unitario_dealer_aprobado = 2;
                $itemsNecesidadRepuestos->save();
            }
        }
        DB::commit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $strRequest = '';
        $valueRequest = '';
        if (session('hojaTrabajo')) {
            $hojaTrabajo = session('hojaTrabajo');
            $hojaTrabajo->contacto = $request->contacto;
            $hojaTrabajo->telefono_contacto = $request->telfContacto;
            $hojaTrabajo->email_contacto = $request->correoContacto;
            $hojaTrabajo->telefono_contacto2 = $request->telfContacto2;
            $hojaTrabajo->email_contacto2 = $request->correoContacto2;
            $request->tipoCambio = isset($request->tipoCambio) ? $request->tipoCambio : TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            if (session('cotizacion')) {
                $cotizacion = session('cotizacion');
                $cotizacion->id_cia_seguro = $request->seguroSelect;
                $cotizacion->save();
                session()->forget('cotizacion');
                $hojaTrabajo->id_cotizacion = $cotizacion->id_cotizacion;
                $hojaTrabajo->observaciones = $request->observaciones;
                $hojaTrabajo->moneda = $request->monedaHT;
                $hojaTrabajo->save();
                $strRequest = 'id_cotizacion';
                $valueRequest = $cotizacion->id_cotizacion;
            } elseif (session('recepcionOT')) {
                $recepcionOT = session('recepcionOT');
                $recepcionOT->id_tipo_ot = $request->tipoOT;
                $recepcionOT->id_cia_seguro = $request->seguroSelect;
                $recepcionOT->factura_para = $request->facturara;
                $recepcionOT->num_doc = $request->numDoc != null ? $request->numDoc : '';
                $recepcionOT->direccion = $request->direccion;

                // $recepcionOT->nro_poliza = $request->nro_poliza;
                // $recepcionOT->nro_siniestro = $request->nro_siniestro;               

                $recepcionOT->save();
                $hojaTrabajo->id_recepcion_ot = $recepcionOT->id_recepcion_ot;
                $hojaTrabajo->observaciones = $request->observaciones;
                $hojaTrabajo->moneda = $request->monedaHT;
                $hojaTrabajo->tipo_cambio = $request->tipoCambio;
                $hojaTrabajo->save();

                $fecha_registro = new Carbon($hojaTrabajo->fecha_registro);
                $fechaMin = $fecha_registro->copy()->subHours(2);
                $fechaMax = $fecha_registro->copy()->addHours(2);
                $placa = $hojaTrabajo->placa_auto;
                $citas = CitaEntrega::where('placa_vehiculo', $placa)->where('habilitado', 1)->whereBetween('fecha_cita', [$fechaMin, $fechaMax])->get();
                foreach ($citas as $cita) {
                    $cita->asistio = 1;
                    $cita->id_hoja_trabajo = $hojaTrabajo->id_hoja_trabajo;
                    $cita->save();
                }

                if ($recepcionOT->fecha_traslado) {
                    $recepcionOT->cambiarEstado('espera_traslado');
                } else {
                    $recepcionOT->cambiarEstado('espera_valuacion');
                }
                // $recepcionOT->save();
                session()->forget('recepcionOT');
                $strRequest = 'id_recepcion_ot';
                $valueRequest = $recepcionOT->id_recepcion_ot;
            }
            session()->forget('hojaTrabajo');
        } else {
            if ($request->id_cotizacion) {
                $cotizacion = Cotizacion::find($request->id_cotizacion);
                $hojaTrabajo = $cotizacion->hojaTrabajo;
                $strRequest = 'id_cotizacion';
                $valueRequest = $cotizacion->id_cotizacion;
                if ($cotizacion->id_cia_seguro != $request->seguroSelect) {
                    $cotizacion->id_cia_seguro = $request->seguroSelect;

                    $fecha_registro = Carbon::parse($cotizacion->fecha_registro);
                    $id_marca_auto = $cotizacion->hojaTrabajo->vehiculo->id_marca_auto;
                    $panhos = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $request->seguroSelect)->where('tipo', 'PANHOS')
                        ->where('fecha_inicio_aplicacion', '<', $fecha_registro)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();
                    $hh = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $request->seguroSelect)->where('tipo', 'HH')
                        ->where('fecha_inicio_aplicacion', '<', $fecha_registro)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();

                    if ($panhos && $hh) {
                        $cotizacion->precio_dyp = json_encode(["PANHOS" => $panhos->id_precio_mo_dyp, "HH" => $hh->id_precio_mo_dyp]);
                    }
                }
                $cotizacion->updatePrecio();
                $cotizacion->save();
            } elseif ($request->id_recepcion_ot) {
                $recepcionOT = RecepcionOT::find($request->id_recepcion_ot);
                if ($recepcionOT->id_tipo_ot != $request->tipoOT) {
                    $recepcionOT->id_tipo_ot = $request->tipoOT;
                }
                if ($recepcionOT->direccion != $request->direccion) {
                    $recepcionOT->direccion = $request->direccion;
                    $recepcionOT->save();
                }
                if ($recepcionOT->factura_para != $request->facturara) {
                    $recepcionOT->factura_para = $request->facturara;
                    $recepcionOT->save();
                }
                if ($recepcionOT->num_doc != $request->numDoc) {
                    $recepcionOT->num_doc = $request->numDoc;
                    $recepcionOT->save();
                }
                if ($recepcionOT->id_cia_seguro != $request->seguroSelect) {
                    $recepcionOT->id_cia_seguro = $request->seguroSelect;

                    $fecha_inicio = Carbon::parse($recepcionOT->fecha_inicio);
                    $id_marca_auto = $recepcionOT->hojaTrabajo->vehiculo->id_marca_auto;
                    $panhos = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $request->seguroSelect)->where('tipo', 'PANHOS')
                        ->where('fecha_inicio_aplicacion', '<', $fecha_inicio)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();
                    $hh = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $request->seguroSelect)->where('tipo', 'HH')
                        ->where('fecha_inicio_aplicacion', '<', $fecha_inicio)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();

                    if ($panhos && $hh) {
                        $recepcionOT->precio_dyp = json_encode(["PANHOS" => $panhos->id_precio_mo_dyp, "HH" => $hh->id_precio_mo_dyp]);
                    }
                }

                if ($recepcionOT->nro_poliza != $request->nro_poliza) {
                    $recepcionOT->nro_poliza = $request->nro_poliza;
                }
                if ($recepcionOT->nro_siniestro != $request->nro_siniestro) {
                    $recepcionOT->nro_siniestro = $request->nro_siniestro;
                }

                $recepcionOT->updatePrecio();
                $recepcionOT->save();
                $hojaTrabajo = $recepcionOT->hojaTrabajo;
                $strRequest = 'id_recepcion_ot';
                $valueRequest = $recepcionOT->id_recepcion_ot;
            }
            if ($hojaTrabajo->contacto != $request->contacto) {
                $hojaTrabajo->contacto = $request->contacto;
            }
            if ($hojaTrabajo->telefono_contacto != $request->telfContacto) {
                $hojaTrabajo->telefono_contacto = $request->telfContacto;
            }
            if ($hojaTrabajo->email_contacto != $request->correoContacto) {
                $hojaTrabajo->email_contacto = $request->correoContacto;
            }
            if ($hojaTrabajo->telefono_contacto2 != $request->telfContacto2) {
                $hojaTrabajo->telefono_contacto2 = $request->telfContacto2;
            }
            if ($hojaTrabajo->email_contacto2 != $request->correoContacto2) {
                $hojaTrabajo->email_contacto2 = $request->correoContacto2;
            }
            $hojaTrabajo->observaciones = $request->observaciones;
            if ($hojaTrabajo->moneda != $request->monedaHT) {
                $hojaTrabajo->moneda = $request->monedaHT;
            }
            $request->tipoCambio = isset($request->tipoCambio) ? $request->tipoCambio : TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            if ($hojaTrabajo->tipo_cambio != $request->tipoCambio) {
                $hojaTrabajo->tipo_cambio = $request->tipoCambio;
            }
            $hojaTrabajo->save();
        }

        $requests = $request->all();

        foreach ($requests as $key => $value) {
            //INGRESO DE NUEVA LINEA DEMANO DE OBRA
            $pos_input = strpos($key, "newDetalleTrabajoCodOp-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numRequest = substr($key, $pos_input + strlen('newDetalleTrabajoCodOp-'));
                $detalleTrabajo = new DetalleTrabajo();
                $detalleTrabajo->id_hoja_trabajo = $hojaTrabajo->id_hoja_trabajo;
                $operacionTrabajo = OperacionTrabajo::where((new OperacionTrabajo)->codOperacionKeyName(), $value)->first();
                $detalleTrabajo->id_operacion_trabajo = $operacionTrabajo->getKey();
                if (in_array($operacionTrabajo->tipo_trabajo, ["GLOBAL-HORAS-CARR", "GLOBAL-HORAS-MEC", "GLOBAL-PANHOS"])) {
                    $detalleTrabajo->detalle_trabajo_libre = $request->input("inputNewDetalleTrabajoDescripcion-" . $numRequest);
                }
                $detalleTrabajo->valor_trabajo_estimado = $request->input("newDetalleTrabajoValor-" . $numRequest);
                //PRECIO REFERENCIAL SEGUN MODIFICACION

                // $idSeguro = ($hojaTrabajo->id_recepcion_ot ? $recepcionOT->id_cia_seguro : $cotizacion->id_cia_seguro);
                // $idMarca = $hojaTrabajo->vehiculo->id_marca_auto;    
                $tipoTrabajo = null;

                if (in_array($operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) $tipoTrabajo = 'PANHOS';
                else $tipoTrabajo = 'HH';

                $es_ot = $hojaTrabajo->id_recepcion_ot != null;
                $es_coti = $hojaTrabajo->id_cotizacion != null;

                $element = null;
                if ($es_ot) $element = $recepcionOT;
                else if ($es_coti) $element = $cotizacion;
                $price = null;
                if (($es_ot || $es_coti) && $element) $price = $element->precio_dyp;
                if ($price) $price = (array)json_decode($price);

                if ($price && $tipoTrabajo) $detalleTrabajo->id_precio_mo_dyp = $price[$tipoTrabajo];
                $detalleTrabajo->save();
            }

            //INGRESO DE NUEVA LINEA DE CODIGO TERCERO
            $pos_input2 = strpos($key, "codigoLineaServicioTercero-");
            if ($pos_input2 !== false && $pos_input2 >= 0) {
                $numRequest = substr($key, $pos_input2 + strlen('codigoLineaServicioTercero-'));
                $servicioTerceroSolicitado = new ServicioTerceroSolicitado();
                $codigo_servicio_tercero = $request->input("codigoLineaServicioTercero-" . $numRequest);
                //dd($codigo_servicio_tercero);
                $servicioTercero = ServicioTercero::where('codigo_servicio_tercero', $codigo_servicio_tercero)->first();
                if ($servicioTercero) {
                    $id_servicio_tercero = $servicioTercero->id_servicio_tercero;
                    //dd($auxiliar);
                    $servicioTerceroSolicitado->id_servicio_tercero = $id_servicio_tercero;
                    if ($request->id_recepcion_ot) {
                        if (!is_null($nro_doc_proveedor = $request->input("numDocLineaServicioTercero-" . $numRequest))) {
                            $servicioTerceroSolicitado->id_proveedor = Proveedor::where('num_doc', $nro_doc_proveedor)->first()->id_proveedor;
                        }
                    }
                    $servicioTerceroSolicitado->id_hoja_trabajo = $hojaTrabajo->id_hoja_trabajo;
                    $servicioTerceroSolicitado->id_usuario_registro = Auth::user()->id_usuario;
                    $servicioTerceroSolicitado->save();
                }
            }

            //INGRESO DE PVP EN LINEA DE SERVICIO TERCERO DONDE NO SE ESPECIFICÓ PVP
            $pos_input3 = strpos($key, "inputActualizarPVP-");
            if ($pos_input3 !== false && $pos_input3 >= 0) {
                $numRequest = substr($key, $pos_input3 + strlen('inputActualizarPVP-'));
                if (!is_null($pvp_libre = $request->input("inputActualizarPVP-" . $numRequest))) {
                    $servicioTercero = ServicioTerceroSolicitado::find($numRequest);
                    $servicioTercero->pvp_libre = $pvp_libre;
                    $servicioTercero->save();
                }
            }

            //INGRESO DE PROVEEDOR EN LINEA DE SERVICIO TERCERO DONDE NO SE ESPECIFICÓ PROVEEDOR
            $pos_input4 = strpos($key, "inputActualizarProveedor-");
            if ($pos_input4 !== false && $pos_input4 >= 0) {
                $numRequest = substr($key, $pos_input4 + strlen('inputActualizarProveedor-'));
                if (!is_null($ruc = $request->input("inputActualizarProveedor-" . $numRequest))) {
                    $servicioTercero = ServicioTerceroSolicitado::find($numRequest);
                    $id_proveedor = Proveedor::where('num_doc', $ruc)->first()->id_proveedor;
                    $servicioTercero->id_proveedor = $id_proveedor;
                    $servicioTercero->save();
                }
            }

            //ACTUALIZACIÓN DEL VALOR TRABAJO EN MANO DE OBRA
            $pos_input5 = strpos($key, "inputActualizarDetalleTrabajoValor-");
            if ($pos_input5 !== false && $pos_input5 >= 0) {
                $numRequest = substr($key, $pos_input5 + strlen('inputActualizarDetalleTrabajoValor-'));
                if (!is_null($valorTrabajo = $request->input("inputActualizarDetalleTrabajoValor-" . $numRequest))) {
                    $detalleTrabajo = DetalleTrabajo::find($numRequest);
                    $detalleTrabajo->valor_trabajo_estimado = $valorTrabajo;
                    $detalleTrabajo->save();
                }
            }

            $pos_input6 = strpos($key, "seguroSelect");
            if ($pos_input6 !== false && $pos_input6 >= 0) {
                $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
                if (count($detallesTrabajo) > 0) {
                    foreach ($detallesTrabajo as $det) {
                        $det->updateEstimatedPrice();
                    }
                }
            }
        }

        //$this->solicitarDescuentoDealerUnitario();

        if (isset($recepcionOT) && $recepcionOT)
            $recepcionOT->reiniciarProcesoReparacionTecnicos();

        return redirect()->route('detalle_trabajos.index', [$strRequest => $valueRequest]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detalleTrabajo = DetalleTrabajo::find($id);
        $this->saveTrackingDelete($detalleTrabajo);
        $detalleTrabajo->delete();

        return redirect()->back();
    }

    private function saveTrackingDelete($transaction)
    {
        $data = json_encode($transaction);
        $origen = "DetalleTrabajo";
        $id_cotizacion = $transaction->hojaTrabajo->id_cotizacion;
        $id_recepcion_ot = $transaction->hojaTrabajo->id_recepcion_ot;

        if ($id_cotizacion == null) {
            $origen = "DetalleTrabajoOT";
            $id_contenedor_origen = $id_recepcion_ot;
        } else {
            $origen = "DetalleTrabajoCot";
            $id_contenedor_origen = $id_cotizacion;
        }

        $id_origen = $transaction->id_detalle_trabajo;
        $id_usuario_eliminador = Auth::user()->id_usuario;
        $name = Auth::user()->empleado->nombreCompleto();

        if ($transaction->detalle_trabajo_libre != null) {
            $description = $transaction->detalle_trabajo_libre . ", fue eliminado por " . $name;
        } else {
            $description = $transaction->firstOperacionTrabajo() . ", fue eliminado por " . $name;
        }

        //$description = $transaction->firstOperacionTrabajo();
        $t = new TrackDeletedTransactions();
        $t->data = $data;
        $t->id_contenedor_origen = $id_contenedor_origen;
        $t->id_origen = $id_origen;
        $t->origen = $origen;
        $t->description = $description;
        $t->id_usuario_eliminador = $id_usuario_eliminador;
        $t->save();
    }

    public function asociarOTCotizacion(Request $request)
    {
        $recepcionOT = RecepcionOT::find($request->idRecepcionOT);
        $recepcionOT->asociarCotizacion($request->idCotizacion);

        $cotizacionesPendientes = session('cotizacionesPreAsociadas');
        if ($cotizacionesPendientes) {
            $cotizacionesPendientes = $cotizacionesPendientes->whereNotIn('id_cotizacion', [$request->idCotizacion]);

            session(['cotizacionesPreAsociadas' => $cotizacionesPendientes]);
            if ($cotizacionesPendientes->count() === 0) {
                session()->forget('cotizacionesPreAsociadas');
            }
        }

        if ($request->actionPost == 'goto_OT') {
            $nombreRuta = $recepcionOT->hojaTrabajo->tipo_trabajo == 'DYP' ? 'detalle_trabajos.index' : 'mecanica.detalle_trabajos.index';
            return redirect()->route($nombreRuta, ['id_recepcion_ot' => $recepcionOT->id_recepcion_ot]);
        }

        return redirect()->back();
    }

    public function cerrarCotizacion(Request $request)
    {
        //dd($request->all());
        $cotizacion = Cotizacion::find($request->nro_cot);

        if ($cotizacion) {
            $cotizacion->es_habilitado = 0;
            $cotizacion->razon_cierre = $request->input("razonCierre");
            $cotizacion->save();

            //$cotizacion->cambiarEstado('cerrado');

            if ($cotizacion->hojaTrabajo->tipo_trabajo == 'DYP') {
                return redirect()->route('cotizaciones.index');
            } else {
                return redirect()->route('mecanica.cotizaciones.index');
            }
        }

        return redirect()->back();
    }
}
