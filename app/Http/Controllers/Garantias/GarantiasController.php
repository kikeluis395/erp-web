<?php

namespace App\Http\Controllers\Garantias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\CiaSeguro;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Valuacion;
use App\Modelos\PromesaValuacion;
use App\Modelos\EntregadoReparacion;
use App\Modelos\CotizacionMeson;
use App\Modelos\TipoCambio;
use App\Helper\Helper;
use App\Http\Controllers\Reportes\ExportReporteGarantiasFacturadas;
use App\Http\Controllers\Reportes\ExportReporteKardexController;
use App\Http\Controllers\Reportes\ReportesController;
use App\Modelos\Cotizacion;
use App\Modelos\Garantias;
use App\Modelos\LineaGarantia;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\Repuesto;
use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GarantiasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if (count($request->all()) === 0) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto', 'ciaSeguro', 'linea_garantia']);
        } else {
            //aquí ya se presionó el boton buscar del filtro
            $vin = $request->vin;
            $placa = str_replace("-", "", $request->placa);
            $nroOT = $request->nroOT;
            $nroDoc = $request->nroDoc;

            $start_date =  $request->fecha_inicio;
            $end_date =  $request->fecha_inicio;


            $recepciones_ots_pre = new RecepcionOT();

            if (isset($nroDoc) && $nroDoc) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) use ($nroDoc) {
                    $query->where('doc_cliente', 'LIKE', "$nroDoc%");
                });
            }

            if (isset($placa) && $placa) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) use ($placa) {
                    $query->where('placa_auto', 'LIKE', "%$placa%");
                });
            }

            if (!is_null($vin)) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.vehiculo', function ($query) use ($vin) {
                    $query->where('vin', 'like', $vin);
                });
            }

            if (isset($nroOT) && $nroOT) {
                $recepciones_ots_pre = $recepciones_ots_pre->where((new RecepcionOT)->getKeyName(), $nroOT);
            }

            if (isset($start_date) && isset($end_date) && $start_date && $end_date) {
                $fecha_inicio = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d 00:00:00');
                $fecha_fin = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d 23:59:00');

                // $recepciones_ots_pre = $recepciones_ots_pre->whereBetween('fecha_nota_entrega', [$fecha_inicio, $fecha_fin]);
                $recepciones_ots_pre = $recepciones_ots_pre->where('fecha_nota_entrega', '>=', $fecha_inicio);
                $recepciones_ots_pre = $recepciones_ots_pre->where('fecha_nota_entrega', '<=', $fecha_fin);
                // return 'A';
            }

            $now = date('Y-m-d', time());

            if (isset($start_date) && $start_date && !$end_date) {
                $fecha_inicio = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d 00:00:00');
                // $recepciones_ots_pre = $recepciones_ots_pre->whereBetween('fecha_nota_entrega', [$fecha_inicio, $now]);
                $recepciones_ots_pre = $recepciones_ots_pre->where('fecha_nota_entrega', '>=', $fecha_inicio);
            }
            if (isset($end_date) && $end_date && !$start_date) {
                $fecha_fin = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d 23:59:00');
                $recepciones_ots_pre = $recepciones_ots_pre->where('fecha_nota_entrega', "<=", $fecha_fin);
            }
        }

        $tipo =  TipoOT::where("nombre_tipo_ot", "like", "GARANT%")->get()->first()->id_tipo_ot;

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('tipoOT', function ($query) use ($tipo) {
            $query->where('tipo_ot.id_tipo_ot', "=", $tipo);
        });

        $recepciones_ots = $recepciones_ots_pre->whereHas('estadosReparacion', function ($query) {
            $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno', ['garantia_cerrado'])
                ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1)
                ->orderBy('estado_reparacion.nombre_estado_reparacion');
        })
            ->get();

        // return $recepciones_ots->with([
        //     "hojaTrabajo.cliente.ubigeo",
        //     "hojaTrabajo.vehiculo.marcaAuto",
        //     "tipoOT"
        // ])->get();

        $recepciones_ots = $recepciones_ots->sortBy(function ($recepcion) {
            return $recepcion->getHojaTrabajo()->fecha_recepcion;
        });

        return view('garantias', [
            'listaRecepcionesOTs' => $recepciones_ots
        ]);
    }
    public function store(Request $request)
    {
        $id_recepcion_ot = $request->id_recepcion_ot;

        $ordenTrabajo = RecepcionOT::find($id_recepcion_ot);
        // $ordenTrabajo = RecepcionOT::with([
        //     "hojaTrabajo.cliente.ubigeo",
        //     "hojaTrabajo.vehiculo.marcaAuto",
        //     "tipoOT"
        // ])->find($id_recepcion_ot);


        if ($ordenTrabajo) {
            $fecha = date('Y-m-d');
            $observaciones_entrega =  $request->observaciones_entrega;

            $ordenTrabajo->observaciones_entrega = $observaciones_entrega;
            $ordenTrabajo->fecha_nota_entrega = $fecha;

            $ordenTrabajo->cambiarEstado('garantia_cerrado');
            $ordenTrabajo->save();

            //CREAR SEGUIMIENTO
            $linea = new LineaGarantia();
            $linea->estado = "0";
            //0 es pendiente de carga, 1 es garantia en proceso
            $linea->id_recepcion_ot = $id_recepcion_ot;
            $linea->save();

            return route('hojaEntrega', [
                'id_recepcion_ot' => $id_recepcion_ot,
            ]);
        }

        return redirect()->back();
    }
    public function basicTables(Request $request)
    {
        $id_recepcion_ot = $request->id_recepcion_ot;
        $id_seguimiento_garantia = $request->id_seguimiento_garantia;

        $ordenTrabajo = RecepcionOT::find($id_recepcion_ot);
        $lineaGarantia = LineaGarantia::find($id_seguimiento_garantia);

        if ($ordenTrabajo && $lineaGarantia) return (object)["ordenTrabajo" => $ordenTrabajo, "lineaGarantia" => $lineaGarantia];
        return false;
    }

    public function procesarCargaRegistro(Request $request)
    {
        $tables = $this->basicTables($request);
        if ($tables) {
            $ordenTrabajo = $tables->ordenTrabajo;
            $lineaGarantia = $tables->lineaGarantia;

            $fecha_carga = $request->fecha_carga_portal;
            $fecha_carga = Carbon::createFromFormat('d/m/Y', $fecha_carga)->format('Y-m-d');

            $codigo_registro = $request->codigo_registro_portal;

            $lineaGarantia->fecha_carga = $fecha_carga;
            $lineaGarantia->codigo_registro = $codigo_registro;
            $lineaGarantia->estado = 1;
            $lineaGarantia->save();

            return $lineaGarantia;
        }
        return redirect()->back();
    }

    public function procesarMotivo(Request $request)
    {
        $tables = $this->basicTables($request);
        if ($tables) {
            $ordenTrabajo = $tables->ordenTrabajo;
            $lineaGarantia = $tables->lineaGarantia;

            $es_rechazada = $request->garantia_rechazada;
            $motivo_rechazo = $request->motivo_rechazo;
            $codigo_registro = $request->codigo_registro_portal;
            $motivo = $request->motivo_garantia;

            if ((string)$es_rechazada === "on") {
                $lineaGarantia->es_rechazada = 1;
                $lineaGarantia->motivo_rechazo = $motivo_rechazo;

                $tipoOT = $ordenTrabajo->hojaTrabajo->tipo_trabajo == 'DYP' ? 'SINIESTRO' : 'CORRECTIVO';
                $ordenTrabajo->id_tipo_ot = TipoOT::where('nombre_tipo_ot', $tipoOT)->first()->id_tipo_ot;
                $ordenTrabajo->hojaTrabajo->observaciones = $motivo_rechazo;
                $ordenTrabajo->hojaTrabajo->save();

                $ordenTrabajo->cambiarEstado('liquidado');
                $ordenTrabajo->save();
            } else {
                $lineaGarantia->es_rechazada = 0;
                $fecha_reproceso = $request->fecha_reproceso_garantia;

                if ($fecha_reproceso) {
                    $fecha_reproceso = Carbon::createFromFormat('d/m/Y', $fecha_reproceso)->format('Y-m-d');
                    $lineaGarantia->fecha_reproceso = $fecha_reproceso;
                }

                $lineaGarantia->codigo_registro = $codigo_registro;
                $lineaGarantia->motivo = $motivo;
            }
            $lineaGarantia->save();
            return $lineaGarantia;
        }
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }

    public function generarHojaEntrega(Request $request)
    {
        $id_recepcion_ot = $request->input("id_recepcion_ot");
        $ordenTrabajo = RecepcionOT::with([
            "hojaTrabajo.cliente.ubigeo",
            "hojaTrabajo.vehiculo.marcaAuto",
            "tipoOT"
        ])->find($id_recepcion_ot);

        if ($ordenTrabajo) {
            $observaciones_entrega = $ordenTrabajo->observaciones_entrega;

            $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
            $comprador = $hojaTrabajo->cliente;

            $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
            $cliente = $comprador->getNombreCliente();
            $vehiculo = $hojaTrabajo->vehiculo;
            $marca = $vehiculo->marcaAuto->nombre_marca;
            $placa =  $vehiculo->placa;
            $modelo = $vehiculo->modelo;
            $kilometraje = $ordenTrabajo->kilometraje;
            $color = $vehiculo->color;
            $chasis = $vehiculo->vin;
            $motor = $vehiculo->motor;
            $doc = $comprador->num_doc;
            $tipo_ot = $ordenTrabajo->tipoOT->nombre_tipo_ot;
            $hora_salida = date('H:i:s', time());
            $observaciones = $observaciones_entrega;

            $nombreArchivo = "NOTA ENTREGA $id_recepcion_ot-$hojaTrabajo->placa_auto.pdf";

            $data = [
                'fecha' => date('Y-m-d'),
                'ot' => $id_recepcion_ot,
                'cliente' => $cliente,
                'marca' => $marca,
                'placa' => $placa,
                'modelo' => $modelo,
                'kilometraje' => $kilometraje,
                'color' => $color,
                'chasis' => $chasis,
                'motor' => $motor,
                'doc' => $doc,
                'tipo_ot' => $tipo_ot,
                'hora_salida' => $hora_salida,
                'observaciones' => $observaciones,
                'id' => $ordenTrabajo->linea_garantia->id_seguimiento_garantia
            ];

            $customPaper = array(0, 0, 418.5, 594.9);

            $pdf = app('dompdf.wrapper');
            $pdf->loadView('formatos.hojaEntrega', $data)->setPaper($customPaper, 'landscape');

            return $pdf->download($nombreArchivo);
        }
    }

    public function entregarfactura(Request $request)
    {

        $id = $request->id_recepcion_ot;
        $ordenTrabajo = RecepcionOT::find($id);
        if ($ordenTrabajo) {

            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha_factura)->format('Y-m-d');

            $estado_reparacion = new EntregadoReparacion();
            $estado_reparacion->fecha_entrega = $fecha;
            $estado_reparacion->id_recepcion_ot = $request->id_recepcion_ot;
            $estado_reparacion->nro_factura = $request->nro_factura;
            $estado_reparacion->save();

            $ordenTrabajo->cambiarEstado('garantia_facturada');
            $ordenTrabajo->save();

            // $last = EntregadoReparacion::where('id_recepcion_ot', '=', $id)->whereNull('nro_factura')->orderBy('id_entregado_reparacion', 'desc')->first();
            // $last->nro_factura = $request->nro_factura;
            // $last->save();
            $moneda = $request->coin;
            if ((string)$moneda === "on") $moneda = "DOLARES";
            else $moneda = "SOLES";

            $garantia = Garantias::create($request->all());
            $garantia->fecha_factura = $fecha;
            $garantia->moneda = $moneda;
            $garantia->tipo_cambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            $garantia->save();
        }
        return redirect()->route('garantia.index');
    }

    //in construction
    public function generarReporteGarantiasFacturadas(Request $request)
    {
        // SECCIÓN 		        hoja_trabajo.tipo_trabajo DYP=B&P || MEC
        // OT			        id_recepcion_ot
        // FECHA_APERTURA		hoja_trabajo.fecha_recepcion
        // FECHA_ENTREGA		entregas(entrega_reparacion).fecha_entrega
        // FECHA_FACTURACIÓN	garantias.fecha_facturacion
        // VIN			        hoja_trabajo.vehiculo.vin
        // PLACA			    hoja_trabajo.vehiculo.placa
        // DOCCLIENTE		    hoja_trabajo.cliente.num_doc
        // CLIENTE			    hoja_trabajo.cliente.nombres ? apellidos_pat?
        // TELEFONO		        hoja_trabajo.telefono_contacto
        // CORREO			    hoja_trabajo.email_contacto
        // DIRECCIÓN 		    hoja_trabajo.cliente.direccion
        // DESCRIPCIÓN	?
        // DOC_FACTURA		    $garantia.nro_factura
        // MONTO_REPUESTOS 	    $garantia.monto_repuestos
        // MONTO_INCENTIVO 	    $garantia.monto_incentivo
        // MONTO_TOTAL 		?

        // $initDate = $request->fecha_inicio;
        // $endDate = $request->fecha_fin;

        $initDate = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->format('Y-m-d 00:00:00');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->format('Y-m-d 23:59:00');

        $hT_relation = 'ordenTrabajo.hojaTrabajo';
        $resultados = [];

        $garantias = Garantias::with([
            $hT_relation . '.vehiculo',
            $hT_relation . '.cliente',
            "ordenTrabajo.entregas"
        ]);

        $garantias = $garantias->where('fecha_factura', '>=', $initDate);
        $garantias = $garantias->where('fecha_factura', '<=', $endDate);

        $garantias = $garantias->get();

        foreach ($garantias as $garantia) {
            $ordenTrabajo = $garantia->ordenTrabajo;
            $id = $ordenTrabajo->id_recepcion_ot;

            $ordenTrabajo = RecepcionOT::with([
                "hojaTrabajo.cliente.ubigeo",
                "hojaTrabajo.vehiculo.marcaAuto",
                "tipoOT",
                "linea_garantia"
            ])->find($id);

            $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
            $vehiculo = $hojaTrabajo->vehiculo;
            $comprador = $hojaTrabajo->cliente;
            $mano_obra = $hojaTrabajo->detallesTrabajo->first();

            $linea_garantia = $ordenTrabajo->linea_garantia;

            $fecha_carga = $linea_garantia->fecha_carga;
            $fecha_reproceso = $linea_garantia->fecha_reproceso;
            $gestion = is_null($fecha_reproceso) ? $fecha_carga : $fecha_reproceso;

            $cierre = $garantia->id_cierre_marca;
            $marca_cierre = is_null($cierre) ? '-' : $cierre;

            if ($hojaTrabajo->tipo_trabajo === 'DYP') $seccion = 'DYP';
            else $seccion = 'MEC';

            $moneda = $garantia->moneda;
            $tipo_cambio = $garantia->tipo_cambio;

            $ot = $ordenTrabajo->id_recepcion_ot;
            $fecha_apertura = $hojaTrabajo->fecha_recepcion;
            $fecha_entrega = $ordenTrabajo->entregas->last()->fecha_entrega;
            $fecha_gestion = $gestion;
            $fecha_facturacion = $garantia->fecha_factura;
            $vin = $vehiculo->vin;
            $placa = $vehiculo->placa;
            $doc = $comprador->num_doc;
            $cliente =  $comprador->getNombreCliente();
            $telefono = $hojaTrabajo->telefono_contacto;
            $correo = $hojaTrabajo->email_contacto;
            $direccion = $comprador->direccion;
            $descripcion = $mano_obra->operacionTrabajo->descripcion;
            $factura = $garantia->nro_factura;
            $id_cierre = $marca_cierre;

            $monto_obra = $this->getDolares($moneda, $tipo_cambio, $garantia->monto_mano_obra);
            $monto_repuestos = $this->getDolares($moneda, $tipo_cambio, $garantia->monto_repuestos);
            $monto_incentivo = $this->getDolares($moneda, $tipo_cambio, $garantia->monto_incentivo);
            $monto_total = $this->getDolares($moneda, $tipo_cambio, $this->getMontoTotal($ordenTrabajo));

            // $monto_obra = $garantia->monto_mano_obra;
            // $monto_repuestos = $garantia->monto_repuestos;
            // $monto_incentivo = $garantia->monto_incentivo;
            // $monto_total = number_format($this->getMontoTotal($ordenTrabajo), 2);

            array_push($resultados, [
                'seccion' => $seccion,
                'ot' => $ot,
                'vin' => $vin,
                'placa' => $placa,
                'doc' => $doc,
                'cliente' => $cliente,
                'telefono' => $telefono,
                'correo' => $correo,
                'direccion' => $direccion,
                'fecha_apertura' => $fecha_apertura,
                'fecha_entrega' => $fecha_entrega,
                'fecha_gestion' => $fecha_gestion,
                'fecha_facturacion' => $fecha_facturacion,
                'descripcion' => $descripcion,
                'factura' => $factura,
                'id_cierre' => $id_cierre,
                'monto_obra' => $monto_obra,
                'monto_repuestos' => $monto_repuestos,
                'monto_incentivo' => $monto_incentivo,
                'monto_total' => $monto_total,
            ]);
        }

        $nombreArchivo = "REPORTE_GARANTIAS_FACTURADAS_$initDate-$endDate.xlsx";
        return Excel::download(new ExportReporteGarantiasFacturadas($resultados), $nombreArchivo);
    }

    public function getDolares($moneda, $tc, $monto)
    {
        if ($moneda === "DOLARES") return number_format($monto, 2);
        else return number_format($monto / $tc, 2);
    }

    public function getMontoTotal(RecepcionOT $ordenTrabajo)
    {
        $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
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

        $serviciosTerceros = $ordenTrabajo->getServiciosTerceros();
        $totalServiciosTerceros = 0;
        $totalServiciosTercerosDescuento = 0;
        foreach ($serviciosTerceros as $key => $servicioTercero) {
            $totalServiciosTerceros += $servicioTercero->getSubTotal($monedaCalculos);
            $totalServiciosTercerosDescuento += $servicioTercero->getDescuento($monedaCalculos);
        }

        $totalDescuentos = $totalServiciosDescuento + $totalRepuestosDescuento + $totalServiciosTercerosDescuento;
        $totalCotizacion = $totalServicios + $totalRepuestos + $totalServiciosTerceros - $totalDescuentos;
        return $totalCotizacion;
    }
    public function getAll(Request $request)
    {
        $ordenTrabajo = RecepcionOT::with([
            "hojaTrabajo.vehiculo.marcaAuto",
            "hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos",
            "hojaTrabajo.empleado.local",
            "hojaTrabajo.cotizacion",
            "hojaTrabajo.cliente.ubigeo",
            "hojaTrabajo.detallesTrabajo.operacionTrabajo",
            "hojaTrabajo.descuentos",
            "hojaTrabajo.serviciosTerceros",
            "tipoOT",
            "ciaSeguro",
            "localEmpresa",
            "reingresoRepuestos",
            "estadosReparacion",
            "tecnicoReparacion",
            "hojasInventario",
            "entregas",
            "garantia"
        ])->find($request->id);

        return $ordenTrabajo;
    }

    public function taller(Request $request)
    {
        $cotizacion = Cotizacion::with([
            "hojaTrabajo.vehiculo.marcaAuto",
            "hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos",
            "hojaTrabajo.empleado.local",
            "hojaTrabajo.cotizacion",
            "hojaTrabajo.cliente.ubigeo",
            "hojaTrabajo.detallesTrabajo.operacionTrabajo",
            "hojaTrabajo.descuentos",
            "hojaTrabajo.serviciosTerceros",
            "ciaSeguro",
            // "tipoOT",
            // "localEmpresa",
            // "reingresoRepuestos",
            // "estadosReparacion",
            // "tecnicoReparacion",
            // "hojasInventario",
            // "entregas",
            // "garantia"
        ])->find($request->id);

        return $cotizacion;
    }
}
