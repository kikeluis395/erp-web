<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\ElementoInspeccion;
use App\Modelos\HojaInspeccion;
use App\Modelos\RecepcionOT;
use App\Modelos\Cotizacion;
use App\Modelos\HojaInventario;
use App\Modelos\ElementoInventario;
use App\Modelos\NecesidadRepuestos;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\CotizacionMeson;
use App\Modelos\NotaIngreso;
use App\Modelos\OrdenCompra;
use App\Modelos\OrdenServicio;
use App\Modelos\ServicioTerceroSolicitado;
use App\Modelos\Proveedor;
use App\Modelos\HojaTrabajo;
use App\Helper\Helper;
use Carbon\Carbon;
use DB;
use Auth;
use PDF;
use App\Http\Controllers\Repuestos\RepuestosController;
use App\Modelos\Devolucion;
use App\Modelos\LineaReingresoRepuestos;
use App\Modelos\ReingresoRepuestos;
use App\Modelos\ConsumoTaller;
use App\Modelos\LineaConsumoTaller;
use App\Http\Controllers\Repuestos\DetalleRepuestosController;

class DocumentosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cotizacion(Request $request)
    {
        $idCotizacion = $request->nro_cotizacion;
        $incluyeIGV = $request->incluyeIGV;
        $cotizacion = Cotizacion::find($idCotizacion);
        $hojaTrabajo = $cotizacion->hojaTrabajo;
        $moneda = $hojaTrabajo->moneda;
        $monedaSimbolo = Helper::obtenerUnidadMoneda($moneda);
        $monedaCalculo = Helper::obtenerUnidadMonedaCalculo($moneda);
        $nombreArchivo = "COT. $idCotizacion-$hojaTrabajo->placa_auto.pdf";

        $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
        $totalCarroceria = 0;
        $totalPanhos = 0;
        $totalMecanica = 0;
        $arregloCarroceria = [];
        $arregloPanhos = [];
        $arregloMecanica = [];
        foreach ($detallesTrabajo as $key => $detalleTrabajo) {
            if (in_array($detalleTrabajo->operacionTrabajo->tipo_trabajo, ["CARROCERIA", "GLOBAL-HORAS-CARR"])) {
                $totalCarroceria += $detalleTrabajo->getSubTotal($monedaCalculo, $incluyeIGV);
                array_push($arregloCarroceria, $detalleTrabajo);
            } elseif (in_array($detalleTrabajo->operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) {
                $totalPanhos += $detalleTrabajo->getSubTotal($monedaCalculo, $incluyeIGV);
                array_push($arregloPanhos, $detalleTrabajo);
            } else {
                //tipo_trabajo -> MECANICA DE COLISION y GLOBAL-HORAS-MEC
                $totalMecanica += $detalleTrabajo->getSubTotal($monedaCalculo, $incluyeIGV);
                array_push($arregloMecanica, $detalleTrabajo);
            }
        }
        $arregloCarroceria = collect($arregloCarroceria);
        $arregloPanhos = collect($arregloPanhos);
        $arregloMecanica = collect($arregloMecanica);

        $totalRepuestos = 0;
        $repuestosAprobados = collect([]);
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            if ($repuestosAprobados->count() == 0) $repuestos = [];
            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                $totalRepuestos += $repuestoAprobado->getMontoVentaTotal($repuestoAprobado->getFechaRegistroCarbon(), $incluyeIGV, $repuestoAprobado->descuento_unitario ?? 0, false, $repuestoAprobado->descuento_unitario_dealer ?? -1);
            }
        }

        $serviciosTerceros = $cotizacion->getServiciosTerceros();
        $totalServiciosTerceros = 0;
        foreach ($serviciosTerceros as $key => $servicioTercero) {
            $totalServiciosTerceros += $incluyeIGV ? $servicioTercero->getPrecioVenta($monedaCalculo) : $servicioTercero->getValorVenta($monedaCalculo);
        }

        $tasaIGV = config('app.tasa_igv');
        $total = $totalCarroceria + $totalPanhos + $totalMecanica + $totalRepuestos + $totalServiciosTerceros;
        $subtotal = $incluyeIGV ? $total / (1 + $tasaIGV) : 0;
        $igv = $incluyeIGV ? $subtotal * $tasaIGV : 0;

        $pdf = PDF::loadView('formatos.cotizacion', [
            'hojaTrabajo' => $hojaTrabajo,
            'moneda' => $moneda,
            'moneda_simbolo' => $monedaSimbolo,
            'monedaCalculo' => $monedaCalculo,
            'listaDetallesTrabajo' => $detallesTrabajo,
            'listaRepuestosAprobados' => $repuestosAprobados,
            'totalRepuestos' => number_format($totalRepuestos, 2),
            'listaServiciosTerceros' => $serviciosTerceros,
            'totalServiciosTerceros' => number_format($totalServiciosTerceros, 2),
            'subtotal' => number_format($subtotal, 2),
            'igv' => number_format($igv, 2),
            'total' => number_format($total, 2),
            'incluyeIGV' => $incluyeIGV,
            'totalCarroceria' => number_format($totalCarroceria, 2),
            'totalPanhos' => number_format($totalPanhos, 2),
            'totalMecanica' => number_format($totalMecanica, 2),
            'arregloCarroceria' => $arregloCarroceria,
            'arregloPanhos' => $arregloPanhos,
            'arregloMecanica' => $arregloMecanica,
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }



    public function ordenTrabajo(Request $request)
    {
        $idOT = $request->nro_ot;
        $ordenTrabajo = RecepcionOT::find($idOT);
        $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
        $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
        $serviciosTerceros = $hojaTrabajo->serviciosTerceros()->with('servicioTercero')->get();

        $elementosInventario = ElementoInventario::all();

        $hojaInventario = $ordenTrabajo->hojasInventario()->orderBy('fecha_registro', 'desc')->first();
        $hojaInventario = ($hojaInventario ? $hojaInventario : new HojaInventario());
        $nombreArchivo = "OT $idOT-$hojaTrabajo->placa_auto.pdf";

        $pdf = PDF::loadView('formatos.ordenTrabajoCompleta', [
            'datosRecepcionOT' => $ordenTrabajo,
            'hojaTrabajo' => $hojaTrabajo,
            'listaDetallesTrabajo' => $detallesTrabajo,
            'hojaInventario' => $hojaInventario,
            'listaServiciosTerceros' => $serviciosTerceros,
        ])
            ->setPaper('a4', 'portrait')->setOptions(['isRemoteEnabled' => true]);
        return $pdf->download($nombreArchivo);
    }


    public function liquidacion(Request $request)
    {
        $idOT = $request->nro_ot;
        $ordenTrabajo = RecepcionOT::find($idOT);
        $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
        $seguro = $hojaTrabajo->getSeguroNombreCiaSeguro();
        $moneda = $hojaTrabajo->moneda;
        $monedaSimbolo = Helper::obtenerUnidadMoneda($moneda);
        $monedaCalculo = Helper::obtenerUnidadMonedaCalculo($moneda);
        $nombreArchivo = isset($request->esPreliqui) ? "PRELIQ. OT $idOT-$hojaTrabajo->placa_auto.pdf" : "LIQ. OT $idOT-$hojaTrabajo->placa_auto.pdf";
        $estado_actual = $ordenTrabajo->estadoActual()[0]->nombre_estado_reparacion_interno;
        $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
        $totalServicios = 0;
        $totalCarroceria = 0;
        $totalPanhos = 0;
        $totalMecanica = 0;
        $arregloCarroceria = [];
        $arregloPanhos = [];
        $arregloMecanica = [];
        foreach ($detallesTrabajo as $key => $detalleTrabajo) {
            if (in_array($detalleTrabajo->operacionTrabajo->tipo_trabajo, ["CARROCERIA", "GLOBAL-HORAS-CARR"])) {
                $totalCarroceria += $detalleTrabajo->getSubTotal($monedaCalculo);
                array_push($arregloCarroceria, $detalleTrabajo);
            } elseif (in_array($detalleTrabajo->operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) {
                $totalPanhos += $detalleTrabajo->getSubTotal($monedaCalculo);
                array_push($arregloPanhos, $detalleTrabajo);
            } else {
                //tipo_trabajo -> MECANICA DE COLISION y GLOBAL-HORAS-MEC
                $totalMecanica += $detalleTrabajo->getSubTotal($monedaCalculo);
                array_push($arregloMecanica, $detalleTrabajo);
            }
        }
        $arregloCarroceria = collect($arregloCarroceria);
        $arregloPanhos = collect($arregloPanhos);
        $arregloMecanica = collect($arregloMecanica);
        $tasaIGV = config('app.tasa_igv');
        if (isset($request->costoColi)) $costoColi = $totalMecanica != 0 ? $request->costoColi * (1 + $tasaIGV) : 0;
        else $costoColi = $totalMecanica;
        if (isset($ordenTrabajo->liquidacion_hh_mec)) $costoColi = $ordenTrabajo->liquidacion_hh_mec;
        if (isset($request->costoCar)) $costoCar = $totalCarroceria != 0 ? $request->costoCar * (1 + $tasaIGV) : 0;
        else $costoCar = $totalCarroceria;
        if (isset($ordenTrabajo->liquidacion_hh_car)) $costoCar = $ordenTrabajo->liquidacion_hh_car;
        if (isset($request->costoPanhos)) $costoPanhos = $totalPanhos != 0 ? $request->costoPanhos * (1 + $tasaIGV) : 0;
        else $costoPanhos = $totalPanhos;
        if (isset($ordenTrabajo->liquidacion_pintura)) $costoPanhos = $ordenTrabajo->liquidacion_pintura;
        $hayFactor = false;
        $factor = 0;
        if (false) {
            if ($moneda != $hojaTrabajo->moneda) {
                $hayFactor = true;
                if ($moneda == "SOLES") {
                    $factor = 1 / $hojaTrabajo->tipo_cambio;
                } else if ($moneda == "DOLARES") {
                    $factor = $hojaTrabajo->tipo_cambio;
                }
                $costoCar = $costoCar * $factor;
                $costoPanhos = $costoPanhos * $factor;
                $costoColi = $costoColi * $factor;
            }
        }
        $factorCar = $totalCarroceria != 0 ? $costoCar / $totalCarroceria : 0;
        $factorColi = $totalMecanica != 0 ? $costoColi / $totalMecanica : 0;
        $factorPanhos = $totalPanhos != 0 ? $costoPanhos / $totalPanhos : 0;
        $totalServicios = $costoCar + $costoPanhos + $costoColi;
        if ($estado_actual == 'vehiculo_listo' || $estado_actual == 'vehiculo_listo_hotline') {
            foreach ($detallesTrabajo as $key => $detalleTrabajo) {
                $detalleTrabajo->valor_trabajo_pre_liquidacion = $detalleTrabajo->valor_trabajo_estimado;
                if (in_array($detalleTrabajo->operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) {
                    if (isset($request->costoPanhos)) $detalleTrabajo->valor_trabajo_estimado = $detalleTrabajo->valor_trabajo_estimado * $factorPanhos;
                } elseif (in_array($detalleTrabajo->operacionTrabajo->tipo_trabajo, ["CARROCERIA", "GLOBAL-HORAS-CARR"])) {
                    if (isset($request->costoCar)) $detalleTrabajo->valor_trabajo_estimado = $detalleTrabajo->valor_trabajo_estimado * $factorCar;
                } else {
                    if (isset($request->costoColi)) $detalleTrabajo->valor_trabajo_estimado = $detalleTrabajo->valor_trabajo_estimado * $factorColi;
                }
                $detalleTrabajo->save();
            }
        }
        $totalRepuestos = 0;
        $repuestosAprobados = collect([]);
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            if ($repuestosAprobados->count() == 0) $repuestos = [];
            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                #if (!$repuestoAprobado->entregado) return redirect()->back()->with('errorLiquidacion', 'Tienes repuestos sin entregar');
                $totalRepuestos += $repuestoAprobado->getMontoVentaTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario ?? 0, false, $repuestoAprobado->descuento_unitario_dealer ?? -1);
            }
        }

        $serviciosTerceros = $ordenTrabajo->getServiciosTerceros();
        $totalServiciosTerceros = 0;
        foreach ($serviciosTerceros as $key => $servicioTercero) {
            $totalServiciosTerceros += $servicioTercero->getPrecioVenta($monedaCalculo);
        }


        $total = $totalServicios + $totalRepuestos + $totalServiciosTerceros;
        $subtotal = $total / (1 + $tasaIGV);
        $igv = $subtotal * $tasaIGV;

        if (isset($ordenTrabajo->liquidacion_deducible)) {
            $deducible = $ordenTrabajo->liquidacion_deducible_es_porcentaje ? $total * $ordenTrabajo->liquidacion_deducible / 100 : ($hayFactor == true ? $ordenTrabajo->liquidacion_deducible * $factor * (1 + $tasaIGV) : $ordenTrabajo->liquidacion_deducible * (1 + $tasaIGV));
        } else $deducible = $request->esPorcentaje == "on" ? $total * $request->costoCliente / 100 : ($hayFactor == true ? $request->costoCliente * $factor * (1 + $tasaIGV) : $request->costoCliente * (1 + $tasaIGV));

        $ordenTrabajo->deducible = $deducible;
        $ordenTrabajo->save();

        if (!isset($request->esPreliqui)) {
            //pasar a liquidado
            if ($estado_actual == 'vehiculo_listo') {
                $ordenTrabajo->cambiarEstado('liquidado');
                $ordenTrabajo->fecha_liquidacion = Carbon::now();
                $ordenTrabajo->liquidacion_deducible = $request->costoCliente;
                $ordenTrabajo->liquidacion_deducible_es_porcentaje = $request->esPorcentaje == "on" ? true : false;
                $ordenTrabajo->liquidacion_pintura = $costoPanhos;
                $ordenTrabajo->liquidacion_hh_mec = $costoColi;
                $ordenTrabajo->liquidacion_hh_car = $costoCar;
                $ordenTrabajo->save();
            } elseif ($estado_actual == 'vehiculo_listo_hotline') {
                $ordenTrabajo->cambiarEstado('liquidado_hotline');
                $ordenTrabajo->fecha_liquidacion = Carbon::now();
                $ordenTrabajo->liquidacion_deducible = $request->costoCliente;
                $ordenTrabajo->liquidacion_deducible_es_porcentaje = $request->esPorcentaje == "on" ? true : false;
                $ordenTrabajo->liquidacion_pintura = $costoPanhos;
                $ordenTrabajo->liquidacion_hh_mec = $costoColi;
                $ordenTrabajo->liquidacion_hh_car = $costoCar;
                $ordenTrabajo->save();
            }
        }

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true])
            ->loadView('formatos.liquidacion', [
                'hojaTrabajo' => $hojaTrabajo,
                'moneda' => $moneda,
                'moneda_simbolo' => $monedaSimbolo,
                'listaDetallesTrabajo' => $detallesTrabajo,
                'monedaCalculo' => $monedaCalculo,
                'totalServicios' => number_format($totalServicios, 2),
                'listaRepuestosAprobados' => $repuestosAprobados,
                'totalRepuestos' => number_format($totalRepuestos, 2),
                'listaServiciosTerceros' => $serviciosTerceros,
                'totalServiciosTerceros' => number_format($totalServiciosTerceros, 2),
                'subtotal' => number_format($subtotal, 2),
                'igv' => number_format($igv, 2),
                'total' => number_format($total, 2),
                'deducible' => number_format($deducible, 2),
                'totalCarroceria' => number_format($costoCar, 2),
                'totalPanhos' => number_format($costoPanhos, 2),
                'totalMecanica' => number_format($costoColi, 2),
                'arregloCarroceria' => $arregloCarroceria,
                'arregloPanhos' => $arregloPanhos,
                'arregloMecanica' => $arregloMecanica,
                'seguro' => $seguro,
                'esPreliquidacion' => isset($request->esPreliqui) ? true : false,
            ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }

    public function hojaConstancia()
    {
        $seccion = request()->seccion;
        $documento = request()->documento;
        $cliente = '';
        $documento_cliente = '';
        $marca = '';
        $modelo = '';
        $placa = '';
        $seguro = '';
        $siniestro = '';
        $cotizacion = '';
        $correo = '';
        $telefono = '';
        $fecha = \Carbon\Carbon::now()->format('d/m/Y');
        $rptos_pendientes = [];

        if ($seccion == 'MESON') {
            $meson = CotizacionMeson::whereHas('ventasMeson', function ($q) use ($documento) {
                $q->where('id_venta_meson', $documento);
            })->first();

            $cliente = $meson->nombre_cliente;
            $documento_cliente = $meson->doc_cliente;
            $cotizacion = $meson->id_cotizacion;
            $correo = $meson->email_contacto;
            $telefono = $meson->telefono_contacto;

            $repuestos_pendientes = CotizacionMeson::whereHas('ventasMeson', function ($q) use ($documento) {
                $q->where('id_venta_meson', $documento);
            })->whereHas('lineasCotizacionMeson', function ($q2) {
                $q2->whereIn('es_importado', [1, 0])->where('es_entregado', '!=', 1);
            })->first();

            $items_repuestos = $repuestos_pendientes ? $repuestos_pendientes->lineasCotizacionMeson : [];

            if ($items_repuestos) {
                $items_repuestos = $items_repuestos->filter(function ($value) {
                    $disponibilidad = $value->getDisponibilidadFacturacion();
                    return  $disponibilidad == 'EN IMPORTACIÓN' || $disponibilidad == 'EN TRÁNSITO';
                });
            }

            foreach ($items_repuestos as $item) {
                $rptos_pendientes[] = (object) [
                    'codigo' => $item->getCodigoRepuesto(),
                    'descripcion' => $item->getDescripcionRepuesto(),
                    'fecha_pedido' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->fecha_registro)->format('d/m/Y'),
                    'fecha_promesa' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->fecha_registro)->addDays(45)->format('d/m/Y'),
                ];
            }
        } else {
            $ot = RecepcionOT::where('id_recepcion_ot', $documento)->first();

            $repuestos_pendientes = HojaTrabajo::where('id_recepcion_ot', $documento)->whereHas('necesidadesRepuestos', function ($q) {
                $q->whereHas('itemsNecesidadRepuestos', function ($q2) {
                    $q2->whereIn('es_importado', [1, 0])->where('entregado', '!=', 1);
                });
            })->first();

            $items_repuestos = $repuestos_pendientes ? $repuestos_pendientes->necesidadesRepuestos->first()->itemsNecesidadRepuestos : [];

            if ($items_repuestos) {
                $items_repuestos = $items_repuestos->filter(function ($value) {
                    $disponibilidad = $value->getDisponibilidad();
                    return  $disponibilidad == 'EN IMPORTACIÓN' || $disponibilidad == 'EN TRÁNSITO';
                });
            }

            foreach ($items_repuestos as $item) {
                $rptos_pendientes[] = (object) [
                    'codigo' => $item->getCodigoRepuesto(),
                    'descripcion' => $item->getDescripcionRepuestoTexto(),
                    'fecha_pedido' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->fecha_registro)->format('d/m/Y'),
                    'fecha_promesa' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->fecha_registro)->addDays(45)->format('d/m/Y')
                ];
            }


            $cliente = $ot->hojaTrabajo->contacto;
            $documento_cliente = $ot->hojaTrabajo->doc_cliente;
            $placa = $ot->hojaTrabajo->placa_auto;
            $marca = $ot->hojaTrabajo->vehiculo->getNombreMarca();
            $modelo = $ot->hojaTrabajo->getModeloVehiculo();
            $seguro = $ot->getNombreCiaSeguro();
            $correo = $ot->hojaTrabajo->email_contacto;
            $telefono = $ot->hojaTrabajo->telefono_contacto;
        }

        $pdf = PDF::loadView('formatos.hojaConstanciaLayout', [
            'seccion' => $seccion,
            'documento' => $documento,
            'cliente' => $cliente,
            'documento_cliente' => $documento_cliente,
            'marca' => $marca,
            'modelo' => $modelo,
            'placa' => $placa,
            'seguro' => $seguro,
            'siniestro' => $siniestro,
            'cotizacion' => $cotizacion,
            'correo' => $correo,
            'telefono' => $telefono,
            'fecha' => $fecha,
            'rptos_pendientes' => $rptos_pendientes
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->stream('FOR-GEN-002 Constancia de repuestos pendientes de entrega.pdf');
    }

    public function hojaInspeccion(Request $request)
    {
        $recepcionOT = RecepcionOT::find($request->nro_ot);
        $hojaInspeccion = $recepcionOT->hojasInspeccion()->orderBy('fecha_registro', 'desc')->first();
        $lineasHoja = $hojaInspeccion->lineasHojaInspeccion;

        $elementosInspeccion = ElementoInspeccion::all();
        $arrElementosInspeccion = [];
        foreach ($elementosInspeccion as $key => $elemento) {
            $lineaHoja = $lineasHoja->where('id_elemento_inspeccion', $elemento->id_elemento_inspeccion)->first();
            if ($lineaHoja)
                array_push($arrElementosInspeccion, (object)['color' => $lineaHoja->resultado, 'valor' => $lineaHoja->valor]);
            else
                array_push($arrElementosInspeccion, (object)['color' => '', 'valor' => '']);
        }

        $nroOT = $request->nro_ot;
        $tecnico = $recepcionOT->ultReparacion()->nombreEmpMecanica();
        $placa = $recepcionOT->hojaTrabajo->getPlacaAutoFormat();
        $marca = $recepcionOT->hojaTrabajo->vehiculo->getNombreMarca();
        $fecha = Carbon::parse($hojaInspeccion->fecha_registro)->format('d/m/Y H:i');
        $modelo = $recepcionOT->hojaTrabajo->vehiculo->modelo;
        $observaciones = trim($recepcionOT->hojaTrabajo->observaciones) ? trim($recepcionOT->hojaTrabajo->observaciones) : 'SIN OBSERVACIONES';

        $pdf = PDF::loadView('formatos.hojaInspeccion', [
            'listaElementosInspeccion' => $arrElementosInspeccion,
            'nroOT' => $nroOT,
            'tecnico' => $tecnico,
            'placa' => $placa,
            'fecha' => $fecha,
            'marca' => $marca,
            'modelo' => $modelo,
            'observaciones' => $observaciones,
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public static function actualizarEstado($request,$necesidadRepuestos){
        foreach($necesidadRepuestos->itemsNecesidadRepuestos as $row){
            if($row->id_repuesto == null){
                continue;
            }
// dd($row->getDisponibilidad());
            if($row->getDisponibilidad() == "EN STOCK"){
                
                $request['nroParte'] = $row->id_repuesto;
                $request['cantidad'] = $row->cantidad_solicitada;
                $id = $row->id_item_necesidad_repuestos;
                $request['fechaEntregaRepuesto'] = null;           
                DetalleRepuestosController::updateStatic($request, $row->id_item_necesidad_repuestos);
            }
        }
        
    }

    public function hojaPedidoRepuestos(Request $request)
    {
        $necesidadRepuestos = NecesidadRepuestos::find($request->idNecesidadRepuestos);
        
        if (!$necesidadRepuestos) {
            abort(400);
        }
        
        self::actualizarEstado($request, $necesidadRepuestos);


        $itemsNecesidadRepuestos = NecesidadRepuestos::find($request->idNecesidadRepuestos)->itemsNecesidadRepuestos->where('entregado', 1);
        $empleado = auth()->user()->empleado;
        $nombreUsuario = $empleado->nombreCompleto();

        $hojaTrabajo = $necesidadRepuestos->hojaTrabajo;
        $vehiculo = $hojaTrabajo->vehiculo;
        $asesorServicio = $hojaTrabajo->empleado->nombreCompleto();
        $idLocal = $necesidadRepuestos->getIdLocal();
        // $descuentoTotal = 0;
        foreach ($itemsNecesidadRepuestos as $key => $itemNecesidadRepuestos) {
            $repuesto = $itemNecesidadRepuestos->repuesto;
            $itemNecesidadRepuestos->stock = $repuesto->getStock($idLocal);
            // $descuentoTotal += $itemNecesidadRepuestos->getDescuento();
        }
        $lastItemNecesidad= ItemNecesidadRepuestos::where('id_necesidad_repuestos',$request->idNecesidadRepuestos)->whereNotNull('entregado_a')->orderBy('fecha_registro_entrega','desc')->first();
        
        $informacionGeneral = (object) [
            'sucursal' => 'Los Olivos',
            'cliente' => $hojaTrabajo->getNombreCliente(),
            'asesor' => $asesorServicio,
            'placa' => $hojaTrabajo->getPlacaAutoFormat(),
            'marca' => $vehiculo->getNombreMarca(),
            'modelo' => $vehiculo->getNombreModeloTecnico(),
            'usuario' => $nombreUsuario,
            'fecha_pr' => Carbon::parse($necesidadRepuestos->fecha_registro)->format('d/m/Y H:i'),
            'nro_ot' => $hojaTrabajo->id_recepcion_ot,
            'nro_necesidad' => $necesidadRepuestos->id_necesidad_repuestos,
            'fecha_impresion' => Carbon::now()->format('d/m/Y H:i'),
            'entregado_a' => $lastItemNecesidad!=null ?$lastItemNecesidad->entregado_a : '-',
        ];

        $idOT = $hojaTrabajo->id_recepcion_ot;
        $nombreArchivo = "P.R. OT $idOT-$hojaTrabajo->placa_auto.pdf";
        $pdf = PDF::loadView('formatos.hojaRepuestos', [
            'itemsNecesidadRepuestos' => $itemsNecesidadRepuestos,
            'infoGeneral' => $informacionGeneral,
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }

    public function notaVentaMeson(Request $request)
    {
        $idCotizacion = $request->idCotizacionMeson;
        $cotizacion = CotizacionMeson::find($idCotizacion);
        $notaVenta = $cotizacion->ventasMeson->first();
        $idNotaVenta = $notaVenta->id_venta_meson;
        $lineasCotizacion = $cotizacion->lineasCotizacionMeson;
        $simboloMoneda = $cotizacion->moneda == 'SOLES' ? 'S/' : 'US$';
        $pdf = PDF::loadView('formatos.notaVentaMeson', [
            'lineasCotizacion' => $lineasCotizacion,
            'cotizacion' => $cotizacion,
            'notaVenta' => $notaVenta,
            'simboloMoneda' => $simboloMoneda,
        ])
            ->setPaper('a4', 'portrait');

        $nombre = "N.V. MESON $idNotaVenta - COT. $idCotizacion.pdf";
        return $pdf->download($nombre);
    }

    public function cotizacionMeson(Request $request)
    {
        $idCotizacion = $request->idCotizacionMeson;
        $showCode = $request->dispcode == 'true' ? true : false;
        $cotizacion = CotizacionMeson::find($idCotizacion);
        $lineasCotizacion = $cotizacion->lineasCotizacionMeson;
        $simboloMoneda = $cotizacion->moneda == 'SOLES' ? 'S/' : 'US$';
        $pdf = PDF::loadView('formatos.cotizacionMeson', [
            'lineasCotizacion' => $lineasCotizacion,
            'cotizacion' => $cotizacion,
            'simboloMoneda' => $simboloMoneda,
            'showCode' => $showCode,
        ])
            ->setPaper('a4', 'portrait');
        $nombre = "COT. MESON $idCotizacion.pdf";
        return $pdf->download($nombre);
    }

    public function notaIngreso(Request $request)
    {
        $id_nota_ingreso = $request->input("id_nota_ingreso");
        $nota_ingreso = NotaIngreso::findOrFail($id_nota_ingreso);
        $lineas_nota_ingreso = $nota_ingreso->lineasNotaIngreso;
        $moneda = $nota_ingreso->obtenerOrdenCompraObjeto()->tipo_moneda;
     
        $nombreArchivo = "NI $nota_ingreso->id_nota_ingreso.pdf";
        $pdf = PDF::loadView('formatos.notaIngreso', [
            'nota_ingreso' => $nota_ingreso,
            'lineas_nota_ingreso' => $lineas_nota_ingreso,
            'moneda' => $moneda
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }

    public function notaIngresoVehiculoNuevo(Request $request)
    {
        $id_nota_ingreso = $request->input("id_nota_ingreso");
        $nota_ingreso = NotaIngreso::findOrFail($id_nota_ingreso);
        $lineas_nota_ingreso = $nota_ingreso->lineasNotaIngreso;
        $moneda = $nota_ingreso->obtenerOrdenCompraObjeto()->tipo_moneda;
     
        $nombreArchivo = "NI $nota_ingreso->id_nota_ingreso.pdf";
        $pdf = PDF::loadView('formatos.notaIngresoVehiculoNuevo', [
            'nota_ingreso' => $nota_ingreso,
            'lineas_nota_ingreso' => $lineas_nota_ingreso,
            'moneda' => $moneda
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }

    public function notaIngresoVehiculoSeminuevo(Request $request)
    {
        $id_nota_ingreso = $request->input("id_nota_ingreso");
        $nota_ingreso = NotaIngreso::findOrFail($id_nota_ingreso);
        $lineas_nota_ingreso = $nota_ingreso->lineasNotaIngreso;
        $moneda = $nota_ingreso->obtenerOrdenCompraObjeto()->tipo_moneda;
     
        $nombreArchivo = "NI $nota_ingreso->id_nota_ingreso.pdf";
        $pdf = PDF::loadView('formatos.notaIngresoVehiculoSeminuevo', [
            'nota_ingreso' => $nota_ingreso,
            'lineas_nota_ingreso' => $lineas_nota_ingreso,
            'moneda' => $moneda
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }

    public function devolucion(Request $request)
    {
        $id_devoluciones = $request->input("id_devoluciones");
        $devoluciones = Devolucion::findOrFail($id_devoluciones);
        $itemDevoluciones = $devoluciones->itemDevoluciones;
        $tasaIGV = config('app.tasa_igv');
        $montoIGV = $devoluciones->getCostoTotal() * $tasaIGV;
        $montoTotal = $montoIGV + $devoluciones->getCostoTotal();
        $moneda = $devoluciones->moneda;
        $fecha = Carbon::parse($devoluciones->fecha_devolucion);
        $correlativo = "$fecha->year$fecha->month-$devoluciones->id_devoluciones";
        $pdf = PDF::loadView('formatos.devolucion', [
            'devoluciones' => $devoluciones,
            'linea_devolucion' => $itemDevoluciones,
            'montoIGV' => $montoIGV,
            'total' => $montoTotal,
            'moneda' => $moneda,
            'correlativo' => $correlativo
        ])->setPaper('a4', 'portrait');

        $nombreArchivo = "Nota de devolución $id_devoluciones.pdf";
        return $pdf->download($nombreArchivo);
    }

    public function reingresoTaller(Request $request)
    {
        $reingresoRepuestos = ReingresoRepuestos::find($request->id_reingreso_repuestos);
        if (!$reingresoRepuestos) {
            abort(400);
        }
        $lineasReingresoRepuestos = $reingresoRepuestos->lineasReingresoRepuestos;
        $empleado = auth()->user()->empleado;
        $nombreUsuario = $empleado->nombreCompleto();

        $hojaTrabajo = $reingresoRepuestos->recepcionOT->hojaTrabajo;
        $vehiculo = $hojaTrabajo->vehiculo;
        $asesorServicio = $hojaTrabajo->empleado->nombreCompleto();
        $idLocal = auth()->user()->empleado->local->id_local;
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        // $descuentoTotal = 0;
        foreach ($lineasReingresoRepuestos as $key => $lineaReingresoRepuestos) {
            $repuesto = $lineaReingresoRepuestos->repuesto;
            $lineaReingresoRepuestos->stock = $repuesto->getStock($idLocal);
            // $descuentoTotal += $itemNecesidadRepuestos->getDescuento();
        }
        $informacionGeneral = (object) [
            'sucursal' => 'Los Olivos',
            'cliente' => $hojaTrabajo->getNombreCliente(),
            'asesor' => $asesorServicio,
            'placa' => $hojaTrabajo->getPlacaAutoFormat(),
            'marca' => $vehiculo->getNombreMarca(),
            'modelo' => $vehiculo->getNombreModeloTecnico(),
            'usuario' => $nombreUsuario,
            'fecha_pr' => Carbon::parse($necesidadRepuestos->fecha_registro)->format('d/m/Y H:i'),
            'nro_ot' => $hojaTrabajo->id_recepcion_ot,
            'nro_necesidad' => $necesidadRepuestos->id_necesidad_repuestos,
            'id_reingreso' => $request->id_reingreso_repuestos,
            'fecha_impresion' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $idOT = $hojaTrabajo->id_recepcion_ot;
        $nombreArchivo = "Nota de Re-Ingreso $reingresoRepuestos->id_reingreso_repuestos.pdf";
        $pdf = PDF::loadView('formatos.reingresoTaller', [
            'lineasReingresoRepuestos' => $lineasReingresoRepuestos,
            'infoGeneral' => $informacionGeneral,
        ])
            ->setPaper('a4', 'portrait');
        return $pdf->download($nombreArchivo);
    }

    public function ordenCompra(Request $request)
    {
        $id_orden_compra = $request->input("id_orden_compra");
        $orden_compra = OrdenCompra::find($id_orden_compra);
        $lineas_compra = $orden_compra->lineasCompra;
        $tasaIGV = config('app.tasa_igv');
        //dd($lineas_compra);
        $nombreUsuario = Auth::user()->empleado->nombreCompleto();
        $montoIGV = $orden_compra->getCostoTotal() * $tasaIGV;
        $montoTotal = $montoIGV + $orden_compra->getCostoTotal();
        $moneda = $orden_compra->tipo_moneda;
        //dd($nombreUsuario);
        $pdf = PDF::loadView('formatos.ordenCompra', [
            'orden_compra' => $orden_compra,
            'lineas_compra' => $lineas_compra,
            'nombreUsuario' => $nombreUsuario,
            'montoIGV' => $montoIGV,
            'total' => $montoTotal,
            'moneda' => $moneda
        ])
            ->setPaper('a4', 'portrait');
        $nombreArchivo = "OC $orden_compra->id_orden_compra.pdf";
        return $pdf->download($nombreArchivo);
    }

    public function ordenCompraSeminuevo(Request $request)
    {
        $id_orden_compra = $request->input("id_orden_compra");
        $orden_compra = OrdenCompra::find($id_orden_compra);
        $lineas_compra = $orden_compra->lineasCompra;
        $tasaIGV = config('app.tasa_igv');
        //dd($lineas_compra);
        $nombreUsuario = Auth::user()->empleado->nombreCompleto();
        $montoIGV = $orden_compra->getCostoTotal() * $tasaIGV;
        $montoTotal = $montoIGV + $orden_compra->getCostoTotal();
        $moneda = $orden_compra->tipo_moneda;
        //dd($nombreUsuario);
        $pdf = PDF::loadView('formatos.ordenCompraSeminuevo', [
            'orden_compra' => $orden_compra,
            'lineas_compra' => $lineas_compra,
            'nombreUsuario' => $nombreUsuario,
            'montoIGV' => $montoIGV,
            'total' => $montoTotal,
            'moneda' => $moneda
        ])
            ->setPaper('a4', 'portrait');
        $nombreArchivo = "OC $orden_compra->id_orden_compra.pdf";
        return $pdf->download($nombreArchivo);
    }

    public function ordenServicio(Request $request)
    {
        $id_proveedor = $request->id_proveedor;
        $id_hoja_trabajo = $request->id_hoja_trabajo;
        $id_recepcion_ot = $request->id_recepcion_ot;
        $placa = HojaTrabajo::find($request->id_hoja_trabajo)->placa_auto;
        $nombreUsuario = Auth::user()->empleado->nombreCompleto();
        $orden_servicio = OrdenServicio::find($request->id_orden_servicio);
        $serviciosTerceros = ServicioTerceroSolicitado::where('id_hoja_trabajo', $id_hoja_trabajo)->where('id_proveedor', $id_proveedor)->get();
        $proveedor = Proveedor::where('id_proveedor', $id_proveedor)->first();
        $arregloLineasOrdenesServicio = [];
        foreach ($serviciosTerceros as $servicioTercero) {
            $lineaOrdenServicio = $servicioTercero->lineaOrdenServicio;
            array_push($arregloLineasOrdenesServicio, $lineaOrdenServicio);
        }
        $lineasOrdenesServicio = collect($arregloLineasOrdenesServicio);
        $moneda = $orden_servicio->moneda == 'SOLES' ? 'PEN' : 'USD';
        $simboloMoneda = $moneda == 'PEN' ? 'S/ ' : '$ ';
        $pdf = PDF::loadView('formatos.ordenServicio', [
            'proveedor' => $proveedor,
            'lineasOrdenesServicio' => $lineasOrdenesServicio,
            'id_hoja_trabajo' => $id_hoja_trabajo,
            'orden_servicio' => $orden_servicio,
            'id_recepcion_ot' => $id_recepcion_ot,
            'nombreUsuario' => $nombreUsuario,
            'placa' => $placa,
            'moneda' => $moneda,
            'simboloMoneda' => $simboloMoneda
        ])
            ->setPaper('a4', 'portrait');
        $nombreArchivo = "OS $orden_servicio->id_orden_servicio.pdf";
        return $pdf->download($nombreArchivo);
    }

    public function notaEntrega(Request $request)
    {
        $id_recepcion_ot = $request->id_recepcion_ot;
        $recepcion_ot = RecepcionOT::find($request->id_recepcion_ot);
        $hoja_trabajo = $recepcion_ot->hojaTrabajo;
        $id_entregado_reparacion = $request->id_entregado_reparacion;
        $vehiculo = $hoja_trabajo->vehiculo;
        $hoja1 = view('formatos.layoutNotaEntrega', [
            'recepcion_ot' => $recepcion_ot,
            'hoja_trabajo' => $hoja_trabajo,
            'vehiculo' => $vehiculo,
            'id_entregado_reparacion' => $id_entregado_reparacion
        ]);

        //se duplica la hoja para que se pueda entregar una copia al cliente (workaround)
        $pdfMerge = PDF::loadHTML($hoja1)->setPaper('a5', 'landscape');
        $nombreArchivo = "NE $id_entregado_reparacion.pdf";
        return $pdfMerge->download($nombreArchivo);
    }

    public function consumoTaller(Request $request)
    {
        $id_consumo_taller = $request->input("id_consumo_taller");
        $consumo_taller = ConsumoTaller::findOrFail($id_consumo_taller);
        $lineasConsumoTaller = $consumo_taller->lineaConsumoTaller;
        $idLocal = auth()->user()->empleado->local->id_local;
        foreach ($lineasConsumoTaller as $key => $lineaConsumoTaller) {
            $repuesto = $lineaConsumoTaller->repuesto;
            $lineaConsumoTaller->stock = $repuesto->getStock($idLocal);
        }
        $fecha_entrega = Carbon::parse($consumo_taller->fecha_entrega)->format('d/m/Y H:i');
        $fecha_impresion = Carbon::now()->format('d/m/Y H:i');
        $pdf = PDF::loadView('formatos.consumoTaller', [
            'consumoTaller' => $consumo_taller,
            'lineasConsumoTaller' => $lineasConsumoTaller,
            'fecha_impresion' => $fecha_impresion,
            'fecha_entrega' => $fecha_entrega,
        ])->setPaper('a4', 'portrait');

        $nombreArchivo = "Consumo de Taller N $id_consumo_taller.pdf";
        return $pdf->download($nombreArchivo);
    }

    public function hojaEntrega(Request $request)
    {
        $id_recepcion_ot = $request->id_recepcion_ot;
        $recepcion_ot = RecepcionOT::find($id_recepcion_ot);
        $hoja_trabajo = $recepcion_ot->hojaTrabajo;
        
    }
}
