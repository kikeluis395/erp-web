<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\LineaNotaIngreso;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\Repuesto;
use App\Modelos\VentaMeson;
use App\Modelos\ItemDevolucion;
use App\Modelos\LineaReingresoRepuestos;
use App\Modelos\RecepcionOT;
use App\Modelos\ItemNecesidadRepuestosDeleted;
use App\Modelos\LocalEmpresa;
use App\Modelos\LineaConsumoTaller;

use Carbon\Carbon;

// use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Modelos\TipoCambio;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::select("CALL PROC_REPORTE_ESTANCIA()");
        $queryPerformance = DB::select("CALL PROC_REPORTE_PERFORMANCE()");
        if ($query) {
            return view('reporte', [
                "data_presente" => true,
                "tiempo_valuacion" => $query[0]->TIEMPO_VALUACION_PROMEDIO,
                "tiempo_autorizacion" => $query[0]->TIEMPO_AUTORIZACION_PROMEDIO,
                "tiempo_asignacion" => $query[0]->TIEMPO_ASIGNACION_PROMEDIO,
                "tiempo_termino_local" => $query[0]->TIEMPO_TERMINO_OPERATIVO_LOCAL_PROMEDIO,
                "tiempo_entrega_local" => $query[0]->TIEMPO_ENTREGA_LOCAL_PROMEDIO,
                "tiempo_termino_global" => $query[0]->TIEMPO_TERMINO_OPERATIVO_GLOBAL_PROMEDIO,
                "tiempo_entrega_global" => $query[0]->TIEMPO_ENTREGA_GLOBAL_PROMEDIO,
                "tiempo_estancia" => $query[0]->TIEMPO_ESTANCIA_PROMEDIO,
                "cumplimiento_fpe" => $queryPerformance[0]->cumplimiento * 100 . "%",
                "porc_ampliaciones" => $queryPerformance[0]->porc_ampliaciones * 100 . "%",
                "porc_hl" => $queryPerformance[0]->porc_hotline * 100 . "%",
                "porc_mec_colision" => $queryPerformance[0]->porc_mec_colision * 100 . "%",
                "perdidas_totales" => $queryPerformance[0]->perdidas_totales,
                "horas_mec" => $queryPerformance[0]->horas_mec,
                "horas_car" => $queryPerformance[0]->horas_carr,
                "panhos" => $queryPerformance[0]->panhos
            ]);
        } else {
            return view('reporte', ["data_presente" => false]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    public function reporteCitas(Request $request)
    {
        return (new ExportController)->citasExcel($request);
    }

    public function reporteMovimientoRepuestos(Request $request)
    {
        return view('reportes.citasExcel');
    }

    public function reporteProductividad(Request $request)
    {
        return view('reportes.citasExcel');
    }

    public function informaRepuestosObsoletos()
    {
        $locales = LocalEmpresa::orderBy('nombre_local')->get();
        $anio_filtro = request()->anio ?? Carbon::now()->year;
        $id_local_filtro = request()->local ?? auth()->user()->empleado->id_local;
        $moneda = request()->moneda ?? 'dolares';
        $simbolo = $moneda == 'soles' ? 'S/' : '$';

        $anio_actual = Carbon::now()->year;
        $mes_actual = Carbon::now()->month;
        $dia_actual = Carbon::now()->day;

        $array_icc = ['F', 'G', 'H', 'I', 'J', 'TOTAL'];

        $parametros = [
            'locales' => $locales,
            'anio_filtro' => $anio_filtro,
            'id_local_filtro' => $id_local_filtro,
            'moneda' => $moneda,
            'simbolo' => $simbolo,
            'anio_actual' => $anio_actual,
            'mes_actual' => $mes_actual,
            'dia_actual' => $dia_actual,
            'array_icc' => $array_icc,
        ];

        $obsolescencias = DB::select("CALL sp_reporte_obsolescencia_v2(?, ?)", [$id_local_filtro, $anio_filtro]);

        $separar = function ($q) use (&$icc) {
            if ($q->icc == $icc) {
                return $q;
            }
        };

        $dividr = function ($q) use (&$array_to_map) {
            $object = (object) [
                'mes' => $q->mes,
                'porc_soles' => 0,
                'porc_dolares' => 0,
            ];

            foreach ($array_to_map as $value) {
                if ($q->mes == $value->mes) {
                    $object = (object) [
                        'mes' => $q->mes,
                        'porc_soles' => number_format(($value->soles / $q->soles) * 100, 0),
                        'porc_dolares' => number_format(($value->dolares / $q->dolares) * 100, 0),
                    ];
                }
            }
            return $object;
        };

        foreach ($array_icc as $value) {
            $icc = $value;
            $nombre_icc = "icc_{$icc}";
            $$nombre_icc = array_filter($obsolescencias, $separar);
            $parametros[$nombre_icc] = $$nombre_icc;
        }

        foreach ($array_icc as $value) {
            if ($value != 'TOTAL') {
                $nombre_porc = "porc_icc_{$value}";
                $nombre_array = "icc_{$value}";
                $array_to_map = $$nombre_array;
                $$nombre_porc = array_map($dividr, $icc_TOTAL);
                $parametros[$nombre_porc] = $$nombre_porc;
            }
        }

        return view('reportes.informaRepuestosObsoletos', $parametros);
    }

    public function seguimientoGeneral()
    {
        $cont = count(request()->all());
        $anio_actual = Carbon::now()->year;
        $mes_actual = Carbon::now()->month;
        $dia_actual = Carbon::now()->day;
        $anio_filtro = request()->anio ?? Carbon::now()->year;
        $byp_filtro = $cont == 0 ? 'DYP' : (request()->byp ?? 'null');
        $mec_filtro = $cont == 0 ? 'PREVENTIVO' : (request()->mec ?? 'null');
        $meson_filtro = $cont == 0 ? 'meson' : (request()->meson ?? 'null');
        $proyeccion = request()->proyeccion ? true : false;
        $moneda = request()->moneda ?? 'dolares';
        $simbolo = $moneda == 'soles' ? 'S/' : '$';

        $diasUtiles = \App\Helper\Helper::getDiasHabiles("$anio_filtro-$mes_actual-01", "$anio_filtro-$mes_actual-" . \App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $mes_actual, $mes_actual, $dia_actual), \App\Helper\Helper::getFeriados($anio_filtro, $mes_actual));
        $diasTotales = \App\Helper\Helper::getDiasHabiles("$anio_filtro-$mes_actual-01", "$anio_filtro-$mes_actual-" . cal_days_in_month(CAL_GREGORIAN, $mes_actual, $anio_filtro), \App\Helper\Helper::getFeriados($anio_filtro, $mes_actual));

        $ordenes_trabajo = DB::select("
        SELECT MONTH(er.fecha_entrega) AS mes, count(*) AS total FROM recepcion_ot ot
        INNER JOIN hoja_trabajo ht ON ot.id_recepcion_ot = ht.id_recepcion_ot
        INNER JOIN entregado_reparacion er ON ot.id_recepcion_ot = er.id_recepcion_ot
        WHERE er.fecha_entrega IS NOT NULL AND er.nro_factura IS NOT NULL
        AND YEAR(er.fecha_entrega) = ?
        AND ht.tipo_trabajo IN (?, ?)
        GROUP BY DATE_FORMAT(er.fecha_entrega,'%Y%m')
        ", [$anio_filtro, $byp_filtro, $mec_filtro]);

        $facturacion = DB::select("
        CALL sp_tmp_reporte_ventas_meson(?, ?, ?, ?)      
        ", [$anio_filtro, $byp_filtro ?? 'null', $mec_filtro == 'PREVENTIVO' ? 'MEC' : 'null', $meson_filtro]);

        $tickets = DB::select("
        SELECT MONTH(fecha_fact) mes, SUM(vventa_descto_soles) soles, SUM(vventa_descto_dolares) dolares, count(DISTINCT num_ot) total_ot FROM tmp_reporte_ventas_taller_v2
        WHERE fecha_fact IS NOT NULL AND YEAR(fecha_fact) = ?
        AND seccion IN (?, ?)
        GROUP BY MONTH(fecha_fact)
        ", [$anio_filtro, $byp_filtro, $mec_filtro == 'PREVENTIVO' ? 'MEC' : '']);

        return view('reportes.seguimientoGeneral', [
            'ordenes_trabajo' => $ordenes_trabajo,
            'facturacion' => $facturacion,
            'tickets' => $tickets,
            'anio_filtro' => $anio_filtro,
            'anio_actual' => $anio_actual,
            'mes_actual' => $mes_actual,
            'dia_actual' => $dia_actual,
            'moneda' => $moneda,
            'simbolo' => $simbolo,
            'proyeccion' => $proyeccion,
            'diasUtiles' => $diasUtiles,
            'diasTotales' => $diasTotales,
        ]);
    }

    public function seguimientoVentasRepuestos()
    {
        $locales = LocalEmpresa::orderBy('nombre_local')->get();
        $anio_filtro = request()->anio ?? Carbon::now()->year;
        $id_local_filtro = request()->local ?? auth()->user()->empleado->id_local;
        $proyeccion = request()->proyeccion ? true : false;
        $moneda = request()->moneda ?? 'dolares';
        $simbolo = $moneda == 'soles' ? 'S/' : '$';

        $anio_actual = Carbon::now()->year;
        $mes_actual = Carbon::now()->month;
        $dia_actual = Carbon::now()->day;

        $diasUtiles = \App\Helper\Helper::getDiasHabiles("$anio_filtro-$mes_actual-01", "$anio_filtro-$mes_actual-" . \App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $mes_actual, $mes_actual, $dia_actual), \App\Helper\Helper::getFeriados($anio_filtro, $mes_actual));
        $diasTotales = \App\Helper\Helper::getDiasHabiles("$anio_filtro-$mes_actual-01", "$anio_filtro-$mes_actual-" . cal_days_in_month(CAL_GREGORIAN, $mes_actual, $anio_filtro), \App\Helper\Helper::getFeriados($anio_filtro, $mes_actual));

        $repuetos = DB::select('CALL sp_tmp_reporte_ventas_rptos(?, ?);', [$id_local_filtro, $anio_filtro]);
        $inventario = DB::select('CALL sp_consultar_inventario_v2(?, ?);', [$id_local_filtro, $anio_filtro]);

        $separar = function ($q) use (&$seccion) {
            if ($q->seccion == $seccion) {
                return $q;
            }
        };

        $sumar = function ($q) use (&$array_to_map) {
            foreach ($array_to_map as $value) {
                if ($q->mes == $value->mes) {
                    $object = (object) [
                        'mes' => $q->mes,
                        'soles' => $q->soles + $value->soles,
                        'dolares' => $q->dolares + $value->dolares,
                        'margen_soles' => $q->margen_soles + $value->margen_soles,
                        'margen_dolares' => $q->margen_dolares + $value->margen_dolares,
                    ];
                }
            }
            return $object;
        };

        $mos_call = function ($q) use (&$array_to_map, &$mes_actual, &$anio_filtro, &$anio_actual, &$proyeccion, &$diasUtiles, &$diasTotales) {
            $object = (object) [
                'mes' => $q->mes,
                'soles' => 0,
                'dolares' => 0,
            ];

            foreach ($array_to_map as $value) {

                $aplica_proyeccion = (int) $q->mes == (int) $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? true : false;

                if ($q->mes == $value->mes) {
                    $costo_soles = $value->soles - $value->margen_soles;
                    $costo_dolares = $value->dolares - $value->margen_dolares;

                    $costo_soles = $aplica_proyeccion ? ($costo_soles / $diasUtiles) * $diasTotales : $costo_soles;
                    $costo_dolares = $aplica_proyeccion ? ($costo_dolares / $diasUtiles) * $diasTotales : $costo_dolares;

                    $result_soles = $q->soles / $costo_soles;
                    $result_dolares = $q->dolares / $costo_dolares;
                    $object = (object) [
                        'mes' => $q->mes,
                        'soles' => $result_soles,
                        'dolares' => $result_dolares,
                    ];
                }
            }
            return $object;
        };

        $seccion = 'DYP';
        $byp = array_filter($repuetos, $separar);

        $seccion = 'MEC';
        $mec = array_filter($repuetos, $separar);

        $seccion = 'MESON';
        $meson = array_filter($repuetos, $separar);

        $array_to_map = $byp;
        $byp_mec = array_map($sumar, $mec);

        $array_to_map = $meson;
        $total = array_map($sumar, $byp_mec);

        $array_to_map = $total;
        $mos = array_map($mos_call, $inventario);

        return view('reportes.seguimientoVentasRepuestos', [
            'anio_filtro' => $anio_filtro,
            'id_local_filtro' => $id_local_filtro,
            'proyeccion' => $proyeccion,
            'moneda' => $moneda,
            'simbolo' => $simbolo,
            'anio_actual' => $anio_actual,
            'mes_actual' => $mes_actual,
            'dia_actual' => $dia_actual,
            'locales' => $locales,
            'byp' => $byp,
            'mec' => $mec,
            'meson' => $meson,
            'total' => $total,
            'diasUtiles' => $diasUtiles,
            'diasTotales' => $diasTotales,
            'inventario' => $inventario,
            'mos' => $mos,
        ]);
    }

    public function seguimientoVentasTaller()
    {
        $locales = LocalEmpresa::orderBy('nombre_local')->get();
        $anio_filtro = request()->anio ?? Carbon::now()->year;
        $id_local_filtro = request()->local ?? auth()->user()->empleado->id_local;
        $proyeccion = request()->proyeccion ? true : false;
        $moneda = request()->moneda ?? 'dolares';
        $simbolo = $moneda == 'soles' ? 'S/' : '$';

        $anio_actual = Carbon::now()->year;
        $mes_actual = Carbon::now()->month;
        $dia_actual = Carbon::now()->day;

        $diasUtiles = \App\Helper\Helper::getDiasHabiles("$anio_filtro-$mes_actual-01", "$anio_filtro-$mes_actual-" . \App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $mes_actual, $mes_actual, $dia_actual), \App\Helper\Helper::getFeriados($anio_filtro, $mes_actual));
        $diasTotales = \App\Helper\Helper::getDiasHabiles("$anio_filtro-$mes_actual-01", "$anio_filtro-$mes_actual-" . cal_days_in_month(CAL_GREGORIAN, $mes_actual, $anio_filtro), \App\Helper\Helper::getFeriados($anio_filtro, $mes_actual));

        $mec_mo = DB::select("CALL sp_tmp_reporte_ventas_taller(?, ?, 'MEC', null, 'mo', null, 'st')", [$id_local_filtro, $anio_filtro]);
        $mec_rptos = DB::select("CALL sp_tmp_reporte_ventas_taller(?, ?, 'MEC', null, null, 'rptos', null)", [$id_local_filtro, $anio_filtro]);
        $mec_total = DB::select("CALL sp_tmp_reporte_ventas_taller(?, ?, 'MEC', null, 'mo', 'rptos', 'st')", [$id_local_filtro, $anio_filtro]);

        $byp_mo = DB::select("CALL sp_tmp_reporte_ventas_taller(?, ?, null, 'DYP', 'mo', null, 'st')", [$id_local_filtro, $anio_filtro]);
        $byp_rptos = DB::select("CALL sp_tmp_reporte_ventas_taller(?, ?, null, 'DYP', null, 'rptos', null)", [$id_local_filtro, $anio_filtro]);
        $byp_total = DB::select("CALL sp_tmp_reporte_ventas_taller(?, ?, null, 'DYP', 'mo', 'rptos', 'st')", [$id_local_filtro, $anio_filtro]);

        $map = function ($q) use (&$array_to_map) {
            foreach ($array_to_map as $value) {
                if ($q->mes == $value->mes) {
                    $object = (object) [
                        'mes' => $q->mes,
                        'soles' => $q->soles + $value->soles,
                        'dolares' => $q->dolares + $value->dolares,
                        'margen_soles' => $q->margen_soles + $value->margen_soles,
                        'margen_dolares' => $q->margen_dolares + $value->margen_dolares,
                    ];
                }
            }
            return $object;
        };

        $array_to_map = $byp_mo;
        $total_mo = array_map($map, $mec_mo);

        $array_to_map = $byp_rptos;
        $total_rptos = array_map($map, $mec_rptos);

        $array_to_map = $byp_total;
        $total_total = array_map($map, $mec_total);


        return view('reportes.seguimientoVentasTaller', [
            'anio_filtro' => $anio_filtro,
            'id_local_filtro' => $id_local_filtro,
            'proyeccion' => $proyeccion,
            'moneda' => $moneda,
            'simbolo' => $simbolo,
            'anio_actual' => $anio_actual,
            'mes_actual' => $mes_actual,
            'dia_actual' => $dia_actual,
            'locales' => $locales,
            'mec_mo' => $mec_mo,
            'mec_rptos' => $mec_rptos,
            'mec_total' => $mec_total,
            'byp_mo' => $byp_mo,
            'byp_rptos' => $byp_rptos,
            'byp_total' => $byp_total,
            'total_mo' => $total_mo,
            'total_rptos' => $total_rptos,
            'total_total' => $total_total,
            'diasUtiles' => $diasUtiles,
            'diasTotales' => $diasTotales,
        ]);
    }

    public function reporteGeneral(Request $request)
    {
        return view('reportes.reporteGeneral');
    }

    public function reporteOTsFacturadasAsesor(Request $request)
    {
        return view('reportes.reporteGeneral');
    }

    public function reporteKardex(Request $request)
    {
        return (new ExportController)->kardexExcel($request);
    }

    public function reportes0327(Request $request)
    {
        $queryFacturacion = DB::select(
            "
            select SECCION,
                    sum(case when tipo_ot='CORRECTIVO' then venta_total - dscto_total else 0 end) CORRECTIVO,
                    sum(case when tipo_ot='PREVENTIVO' then venta_total - dscto_total else 0 end) PREVENTIVO,
                    sum(case when tipo_ot='RECLAMO' then venta_total - dscto_total else 0 end) RECLAMO,
                    sum(case when tipo_ot='GARANTIA' then venta_total - dscto_total else 0 end) GARANTIA,
                    sum(case when tipo_ot='PDI' then venta_total - dscto_total else 0 end) PDI,
                    sum(case when tipo_ot='SINIESTRO' then venta_total - dscto_total else 0 end) SINIESTRO,
                    sum(case when tipo_ot='CORTESIA' then venta_total - dscto_total else 0 end) CORTESIA,
                    sum(case when tipo_ot='ACCESORIOS' then venta_total - dscto_total else 0 end) ACCESORIOS
            from tmp_consultas_ots
            where estado_ot='ENTREGADO'
            group by SECCION"
        );

        $queryCantidades = DB::select("
            select SECCION,
                    sum(case when tipo_ot='CORRECTIVO' then 1 else 0 end) CORRECTIVO,
                    sum(case when tipo_ot='PREVENTIVO' then 1 else 0 end) PREVENTIVO,
                    sum(case when tipo_ot='RECLAMO' then 1 else 0 end) RECLAMO,
                    sum(case when tipo_ot='GARANTIA' then 1 else 0 end) GARANTIA,
                    sum(case when tipo_ot='PDI' then 1 else 0 end) PDI,
                    sum(case when tipo_ot='SINIESTRO' then 1 else 0 end) SINIESTRO,
                    sum(case when tipo_ot='CORTESIA' then 1 else 0 end) CORTESIA,
                    sum(case when tipo_ot='ACCESORIOS' then 1 else 0 end) ACCESORIOS
            from tmp_consultas_ots
            group by SECCION
        ");

        $queryVentaRepuestos = DB::select("
            select tipo_venta,
                    sum(costo_dolares) costo,
                    sum(venta_dolares) venta,
                    sum(descuento) dscto,
                    sum(margen) margen
            from tmp_reporte_venta_repuestos
            group by tipo_venta
        ");
    }

    public function reporteVentaRepuestos(Request $request)
    {
        return (new ExportController)->ventaRepuestosExcel($request);
    }

    public function reporteOts(Request $request)
    {
        return (new ExportController)->otsExcel($request);
    }

    public function reporteVentas(Request $request)
    {
        return view('reportes.consultaReporteVentas');
    }

    public function reporteVentasMeson(Request $request)
    {
        return view('reportes.consultaReporteVentasMeson');
    }

    public function consultaStock(Request $request)
    {
        return (new ExportController)->stockExcel($request);
    }

    public static function generateKardexPerSpareCalculated($id_repuesto,  $initDate, $endDate)
    {
        $movimiento_repuesto = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->where('fecha_movimiento', '>=', $initDate)->where('fecha_movimiento', '<=', $endDate)->get();
        // dd($movimiento_repuesto);
        $resultados = [];


        $saldo_dolares = 0;
        foreach ($movimiento_repuesto as $row) {


            if ($row->motivo == "REINGRESO") {
                $fuente = LineaReingresoRepuestos::where('id_movimiento_reingreso', $row->id_movimiento_repuesto)->first();
            } else if ($row->fuente_type == "App\Modelos\ItemNecesidadRepuestosDeleted") {
                //$fuente = ItemNecesidadRepuestosDeleted::find('id_item_necesidad_repuestos_deleted', $row->fuente_id)->first();
                $fuente = ItemNecesidadRepuestosDeleted::where('id_movimiento_salida', $row->id_movimiento_repuesto)->first();
                //dd($fuente);
            } else {
                $fuente = $row->fuente;
            }

            if ($fuente != null) {

                $cantidad_ingreso = 0;
                $cantidad_salida = 0;
                $cantidad_saldo = $row->saldo;
                $costo_dolares = $row->costo;
                $ingreso_dolares = 0;
                $salida_dolares = 0;
                $saldo_dolares = $row->saldo_dolares;
                $precio_de_compra = 0;
                $motivo = $fuente->motivo();

                if ($row->tipo_movimiento == "INGRESO") {
                    $cantidad_ingreso = round($row->cantidad_movimiento, 4);
                    $costo_dolares = $row->costo_promedio_ingreso;
                    $ingreso_dolares = round($cantidad_ingreso * $costo_dolares, 4);
                    $precio_de_compra = $row->costo;
                } else {
                    $cantidad_salida = round($row->cantidad_movimiento, 4);
                    $salida_dolares = round($cantidad_salida * $costo_dolares, 4);
                    $costo_dolares = $row->costo;
                }


                $resultado = [
                    'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                    'descripcion' => $row->repuesto->descripcion,
                    'fecha_movimiento' => $row->fecha_movimiento,
                    'usuario' => $fuente->usuarioNombre(),
                    'fuente' => $fuente->fuente(),
                    'nro_fuente' => $fuente->idFuente(),
                    'nro_factura' => $fuente->nroFactura(),
                    'motivo' => $motivo,
                    'ubicacion' => $row->repuesto->ubicacion,
                    'cantidad_ingreso' => $cantidad_ingreso,
                    'cantidad_salida' => $cantidad_salida,
                    'cantidad_saldo' => $cantidad_saldo,
                    'costo_dolares' => $costo_dolares,
                    'ingreso_dolares' => $ingreso_dolares,
                    'salida_dolares' => $salida_dolares,
                    'saldo_dolares' => $saldo_dolares,
                    'precio_de_compra' => $precio_de_compra,

                ];
            } else {
                $saldo_dolares = $row->saldo_dolares;

                if($row->fuente_type=="App\Modelos\ItemNecesidadRepuestos"){
                    $resultado = [
                        'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                        'descripcion' => $row->repuesto->descripcion,
                        'fecha_movimiento' => $row->fecha_movimiento,
                        'usuario' => '',
                        'fuente' => 'OT',
                        'nro_fuente' => 'ANULADO',
                        'nro_factura' => 'ANULADO',
                        'motivo' => 'EGRESO',
                        'ubicacion' => '',
                        'cantidad_ingreso' => 0,
                        'cantidad_salida' => $row->cantidad_movimiento,
                        'cantidad_saldo' => $row->saldo,
                        'costo_dolares' => $row->repuesto->costo_no_igv,
                        'ingreso_dolares' => 0,
                        'salida_dolares' => round($row->repuesto->costo_no_igv * $row->cantidad_movimiento, 4),
                        'saldo_dolares' => $saldo_dolares,
                        'precio_de_compra' => ''
                    ];
                }else{
                    $resultado = [
                        'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                        'descripcion' => $row->repuesto->descripcion,
                        'fecha_movimiento' => $row->fecha_movimiento,
                        'usuario' => '',
                        'fuente' => '',
                        'nro_fuente' => '',
                        'nro_factura' => '',
                        'motivo' => 'S.I.',
                        'ubicacion' => '',
                        'cantidad_ingreso' => $row->cantidad_movimiento,
                        'cantidad_salida' => 0,
                        'cantidad_saldo' => $row->cantidad_movimiento,
                        'costo_dolares' => $row->repuesto->costo_no_igv,
                        'ingreso_dolares' => round($row->repuesto->costo_no_igv * $row->cantidad_movimiento, 4),
                        'salida_dolares' => 0,
                        'saldo_dolares' => $saldo_dolares,
                        'precio_de_compra' => ''
                    ];
                }

                
            }

            array_push($resultados, (object) $resultado);
        }
        // dd($resultados);
        return $resultados;
    }
    public static function generateKardexPerSpare($id_repuesto)
    {
        // $request = $request->all();
        // dd($request);
        $initDate = "2020-03-01 00:00:00";
        $endDate = "2021-05-27 00:00:00";

        // $codeSpare = $request['nroRepuesto'];
        // $codeSpare = "265405EE0A";

        $lineasCotizacionMeson = [];

        $listLineaNotaIngreso = LineaNotaIngreso::whereHas('lineaOrdenCompra', function ($q1) use ($id_repuesto) {
            $q1->where('id_repuesto', $id_repuesto);
        })->get();

        $ventasMeson = VentaMeson::whereHas('cotizacionMeson', function ($q1) use ($id_repuesto) {
            $q1->whereHas('lineasCotizacionMeson', function ($q2) use ($id_repuesto) {
                $q2->where('id_repuesto', $id_repuesto)->where('es_entregado', 1);
            });
        })->get();

        $repuestosEntregadosOT = ItemNecesidadRepuestos::where('entregado', 1)->where('id_repuesto', $id_repuesto)->get();




        $resultados = [];
        // ESTO ES INGRESOS
        foreach ($listLineaNotaIngreso as $row) {
            //$ordenCompra = OrdenCompra::where('id_repuesto',$repuesto->id_repuesto)->first();
            // if($row->movimientoIngreso==null){
            //     dd($row);
            // }
            $moneda = $row->lineaOrdenCompra->ordenCompra->tipo_moneda;
            $price = $row->lineaOrdenCompra->precio;

            $date_register = $row->notaIngreso->fecha_registro;

            $date = strtotime("+1 day", strtotime($date_register));
            $date = date("Y-m-d 00:00:00", $date);

            $cobro = TipoCambio::where('fecha_registro', '<', $date)->orderBy('fecha_registro', 'desc')->first();
            $cobro = $cobro->cobro;

            if ($moneda == "SOLES") {
                $price = $price / $cobro;
            }

            $ingresos = [
                'id_movimiento' => $row->movimientoIngreso->id_movimiento_repuesto,
                'codigo_repuesto' => $row->lineaOrdenCompra->getCodigoRepuesto(),
                'descripcion' => $row->lineaOrdenCompra->getDescripcionRepuesto(),
                'fecha_movimiento' => $row->movimientoIngreso->fecha_movimiento,
                //'fecha_movimiento' => $row->notaIngreso->fecha_registro,
                'usuario' => $row->notaIngreso->usuarioRegistro->empleado->nombreCompleto(),
                'fuente' => 'NOTA INGRESO',
                'nro_fuente' => $row->notaIngreso->id_nota_ingreso,
                'nro_factura' => $row->notaIngreso->factura_asociada,
                'motivo' => 'INGRESO',
                'ubicacion' => $row->lineaOrdenCompra->getUbicacionRepuesto(),
                //'cantidad_ingreso' => $row->lineaOrdenCompra->cantidad,
                'cantidad_ingreso' => $row->cantidad_ingresada,
                'cantidad_salida' => 0,
                'cantidad_saldo' => 0,
                'costo_dolares' => round($price, 4),
                'ingreso_dolares' => round($price * $row->cantidad_ingresada, 4),
                //'ingreso_dolares' => round($price * $row->lineaOrdenCompra->cantidad, 4),
                'salida_dolares' => 0,
                'saldo_dolares' => 0,
                'precio_de_compra' => round($price, 4),

            ];

            array_push($resultados, (object) $ingresos);
        }


        //////////////////////////////
        // ESTO ES EGRESOS POR MESON///
        /////////////////////////////

        foreach ($ventasMeson as $rowVentasMeson) {
            $lineasCotizacionMeson = $rowVentasMeson->cotizacionMeson->lineasCotizacionMeson;

            //dd($lineasCotizacionMeson);
            foreach ($lineasCotizacionMeson as $row) {
                if ($row->movimientoSalida == null) {
                    dd($row);
                }

                $egresosMeson = [
                    'id_movimiento' => $row->movimientoSalida->id_movimiento_repuesto,
                    'codigo_repuesto' => $row->getCodigoRepuesto(),
                    'descripcion' => $row->getDescripcionRepuesto(),
                    'fecha_movimiento' => $row->movimientoSalida->fecha_movimiento,
                    'usuario' => $row->cotizacionMeson->getNombrevendedor(),
                    'fuente' => 'MESON',
                    'nro_fuente' => $row->cotizacionMeson->ventasMeson->first()->id_venta_meson,
                    'nro_factura' => $row->cotizacionMeson->ventasMeson->first()->nro_factura,
                    'motivo' => 'EGRESO',
                    'ubicacion' => $row->getUbicacionRepuesto(),
                    'cantidad_ingreso' => 0,
                    'cantidad_salida' => $row->cantidad,
                    'cantidad_saldo' => 0,
                    'costo_dolares' => 0,
                    'ingreso_dolares' => 0,
                    'salida_dolares' => 0,
                    'saldo_dolares' => 0,
                    'precio_de_compra' => '',
                ];

                if ($id_repuesto == $row->id_repuesto) {
                    array_push($resultados, (object) $egresosMeson);
                }
            }
        }

        /////////////////////////////////
        // ESTO ES EGRESOS POR TALLER V2///
        ///////////////////////////////

        //dd($repuestosEntregadosOT);
        foreach ($repuestosEntregadosOT as $row) {
            $egresoOT = [
                'id_movimiento' => $row->movimientoSalida->id_movimiento_repuesto,
                'codigo_repuesto' => $row->getCodigoRepuesto(),
                'descripcion' => $row->getDescripcionRepuestoTexto(),
                'fecha_movimiento' => $row->movimientoSalida->fecha_movimiento,
                'usuario' => $row->necesidadRepuestos->hojaTrabajo->empleado->nombreCompleto(),
                'fuente' => 'OT',
                'nro_fuente' => $row->idRecepcionOT(),
                'nro_factura' => $row->getDocumentoGenerado(),
                'motivo' => 'EGRESO',
                'ubicacion' => $row->getUbicacionRepuestoAprobado(),
                'cantidad_ingreso' => 0,
                // 'cantidad_salida' => $row->cantidad_aprobada,
                'cantidad_salida' => $row->movimientoSalida->cantidad_movimiento,
                'cantidad_saldo' => 0,
                'costo_dolares' => 'x',
                'ingreso_dolares' => 0,
                'salida_dolares' => 0,
                'saldo_dolares' => 0,
                'precio_de_compra' => '',
            ];

            array_push($resultados, (object) $egresoOT);
        }
        //dd($resultados);

        ///////////////////////////////////////////
        ///Calculo de STOCK INICIAL //////////7///
        //////////////////////////////////////////

        $stock_inicial = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('fecha_movimiento', '<=', date("2021-03-01 00:00:00"))->where('tipo_movimiento', 'INGRESO')->first();

        if ($stock_inicial != null) {
            $saldo_inicial = [
                'id_movimiento' => $stock_inicial->id_movimiento_repuesto,
                'codigo_repuesto' => $stock_inicial->repuesto->codigo_repuesto,
                'descripcion' => $stock_inicial->repuesto->descripcion,
                'fecha_movimiento' => $stock_inicial->fecha_movimiento,
                'usuario' => '',
                'fuente' => '',
                'nro_fuente' => '',
                'nro_factura' => '',
                'motivo' => 'S.I.',
                'ubicacion' => '',
                'cantidad_ingreso' => $stock_inicial->cantidad_movimiento,
                'cantidad_salida' => 0,
                'cantidad_saldo' => $stock_inicial->cantidad_movimiento,
                'costo_dolares' => $stock_inicial->repuesto->costo_no_igv,
                'ingreso_dolares' => round($stock_inicial->repuesto->costo_no_igv * $stock_inicial->cantidad_movimiento, 4),
                'salida_dolares' => 0,
                'saldo_dolares' => 0,
                'precio_de_compra' => '',
            ];

            array_push($resultados, (object) $saldo_inicial);
        }



        ///////////////////////////////////////////
        ///Calculo de REINGRESOS (INGRESO POR DEVOLUCIÓN) //////////7///
        //////////////////////////////////////////

        $total_reingresos = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('motivo', 'REINGRESO')->get();

        if ($total_reingresos != null) {
            foreach ($total_reingresos as $row) {
                $linea_reingreso_repuesto = LineaReingresoRepuestos::where('id_movimiento_reingreso', $row->id_movimiento_repuesto)->first();
                if ($linea_reingreso_repuesto == null) {
                    // dd($row->id_movimiento_repuesto);
                }
                if ($row->repuesto != null) {
                    $reingreso = [
                        'id_movimiento' => $row->id_movimiento_repuesto,
                        'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                        'descripcion' => $row->repuesto->descripcion,
                        'fecha_movimiento' => $row->fecha_movimiento, //esta nomas dificil sacar de tabla movimientos
                        'usuario' => $linea_reingreso_repuesto != null ? $linea_reingreso_repuesto->reingresoRepuestos->usuario->empleado->nombreCompleto() : '-',
                        'fuente' => 'DEVOLUCION ALMACEN',
                        // 'nro_fuente' => $linea_reingreso_repuesto != null ? $linea_reingreso_repuesto->itemNecesidadRepuestos->necesidadRepuestos->hojaTrabajo->recepcionOT->id_recepcion_ot:'-',
                        'nro_fuente' => $linea_reingreso_repuesto != null ? $linea_reingreso_repuesto->reingresoRepuestos->id_reingreso_repuestos : '-',
                        'nro_factura' => '-',
                        'motivo' => 'INGRESO POR DEVOLUCIÓN',
                        'ubicacion' => $row->repuesto->ubicacion,
                        'cantidad_ingreso' => $row->cantidad_movimiento,
                        'cantidad_salida' => 0,
                        'cantidad_saldo' => 0,
                        'costo_dolares' => 0,
                        'ingreso_dolares' => 0,
                        'salida_dolares' => 0,
                        'saldo_dolares' => 0,
                        'precio_de_compra' => 0,
                    ];

                    array_push($resultados, (object) $reingreso);
                }
            }
        }


        ///////////////////////////////////////////////////
        ///Calculo de EGRESOS QUE TUBIERON DEVOLUCION /////
        //////////////////////////////////////////////////
        $itemNecesidadRepuestosDeleted = ItemNecesidadRepuestosDeleted::where('id_repuesto', $id_repuesto)->get();

        if ($itemNecesidadRepuestosDeleted != null) {
            foreach ($itemNecesidadRepuestosDeleted as $row) {
                $rowItemNecesidadRepuestosDeleted = [
                    'id_movimiento' => $row->movimientoSalida->id_movimiento_repuesto,
                    'codigo_repuesto' => $row->getCodigoRepuesto(),
                    'descripcion' => $row->getDescripcionRepuestoTexto(),
                    'fecha_movimiento' => $row->movimientoSalida->fecha_movimiento,
                    'usuario' => $row->necesidadRepuestos->hojaTrabajo->empleado->nombreCompleto(),
                    'fuente' => 'OT',
                    'nro_fuente' => $row->idRecepcionOT(),
                    'nro_factura' => $row->getDocumentoGenerado(),
                    'motivo' => 'EGRESO',
                    'ubicacion' => $row->getUbicacionRepuestoAprobado(),
                    'cantidad_ingreso' => 0,
                    // 'cantidad_salida' => $row->cantidad_aprobada,
                    'cantidad_salida' => $row->movimientoSalida->cantidad_movimiento,
                    'cantidad_saldo' => 0,
                    'costo_dolares' => 'x',
                    'ingreso_dolares' => 0,
                    'salida_dolares' => 0,
                    'saldo_dolares' => 0,
                    'precio_de_compra' => '',
                ];

                array_push($resultados, (object) $rowItemNecesidadRepuestosDeleted);
            }
        }


        ///////////////////////////////////////////////////
        ///Calculo de EGRESOS POR COSUMO TALLER /////
        //////////////////////////////////////////////////
        $lineasConsumoTaller = LineaConsumoTaller::where('id_repuesto', $id_repuesto)->get();

        if ($lineasConsumoTaller != null) {
            foreach ($lineasConsumoTaller as $row) {
                $rowItemNecesidadRepuestosDeleted = [
                    'id_movimiento' => $row->movimientoSalida->id_movimiento_repuesto,
                    'codigo_repuesto' => $row->getCodigoRepuesto(),
                    'descripcion' => $row->getDescripcionRepuesto(),
                    'fecha_movimiento' => $row->movimientoSalida->fecha_movimiento,
                    'usuario' => $row->consumoTaller->usuario_solicitante,
                    'fuente' => 'CONSUMO TALLER',
                    'nro_fuente' => $row->id_consumo_taller,
                    'nro_factura' => '-',
                    'motivo' => 'EGRESO POR CONSUMO',
                    'ubicacion' => $row->repuesto->ubicacion,
                    'cantidad_ingreso' => 0,
                    'cantidad_salida' => $row->movimientoSalida->cantidad_movimiento,
                    'cantidad_saldo' => 0,
                    'costo_dolares' => 'x',
                    'ingreso_dolares' => 0,
                    'salida_dolares' => 0,
                    'saldo_dolares' => 0,
                    'precio_de_compra' => '',
                ];

                array_push($resultados, (object) $rowItemNecesidadRepuestosDeleted);
            }
        }

        ///////////////////////////////////////////
        ///Calculo de DEVOLUCIONES //////////7///
        //////////////////////////////////////////

        $total_reingresos = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('motivo', 'DEVOLUCION')->where('tipo_movimiento', 'EGRESO')->get();

        if ($total_reingresos != null) {
            foreach ($total_reingresos as $row) {

                $item_devoluciones = ItemDevolucion::where('id_movimiento_repuesto', $row->id_movimiento_repuesto)->first();

                if ($row->repuesto != null) {
                    $reingreso = [
                        'id_movimiento' => $row->id_movimiento_repuesto,
                        'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                        'descripcion' => $row->repuesto->descripcion,
                        'fecha_movimiento' => $row->fecha_movimiento,
                        'usuario' => $item_devoluciones != null ? $item_devoluciones->devolucion->usuario->empleado->nombreCompleto() : '-',
                        'fuente' => 'NOTA DE DEVOLUCIÓN',
                        'nro_fuente' =>  $item_devoluciones != null ? $item_devoluciones->devolucion->id_devoluciones : '-',
                        'nro_factura' => $item_devoluciones != null ? $item_devoluciones->devolucion->nro_nota_credito : '-',
                        'motivo' => 'EGRESO POR DEVOLUCIÓN',
                        'ubicacion' => $row->repuesto->ubicacion,
                        'cantidad_ingreso' => 0,
                        'cantidad_salida' => $row->cantidad_movimiento,
                        'cantidad_saldo' => 0,
                        'costo_dolares' => 0,
                        'ingreso_dolares' => 0,
                        'salida_dolares' => 0,
                        'saldo_dolares' => 0,
                        'precio_de_compra' => 0,
                    ];

                    array_push($resultados, (object) $reingreso);
                }
            }
        }

        usort($resultados, function ($a, $b) {
            return strtotime($a->fecha_movimiento) - strtotime($b->fecha_movimiento);
        });


        if ($resultados != null) {
            $cantidad_inicial = $resultados[0]->cantidad_saldo;
            $costo_inicial = $resultados[0]->costo_dolares;
        } else {
            $cantidad_inicial = 0;
            $costo_inicial = 0;
        }

        // foreach($resultados as $row){
        for ($i = 0; $i < count($resultados); $i++) {
            $row = $resultados[$i];

            if ($row->motivo == "S.I") {
                $cantidad_inicial = $row->cantidad_ingreso;
                $costo_dolares = $row->costo_dolares;
            }
            if ($row->motivo == "EGRESO") {
                $cantidad_inicial = $cantidad_inicial - $row->cantidad_salida;
                $row->costo_dolares = round($costo_inicial, 4);
                $row->salida_dolares = round($row->costo_dolares * $row->cantidad_salida, 4);
            }

            if ($row->motivo == "INGRESO" || $row->motivo == "INGRESO POR NC-ND") {
                $tmp = $cantidad_inicial;
                $cantidad_inicial = $cantidad_inicial + $row->cantidad_ingreso;
                $costo_dolares = $row->costo_dolares;
                $ci = $row->cantidad_ingreso;
                if (!is_numeric($costo_inicial)) {
                    $costo_inicial = 0.0000001;
                }
                if ($cantidad_inicial == 0) {
                    $cantidad_inicial = 0.0000001;
                }
                $row->costo_dolares = round((($tmp * $costo_inicial) + ($ci * $row->precio_de_compra)) / $cantidad_inicial, 4);
                $t = ($tmp + $ci) == 0 ? 1 : $tmp + $ci;

                // calculo de costo promedio
                $costo_inicial = (($costo_inicial * $tmp) + ($ci * $costo_dolares)) / ($t);
            }
            if ($row->motivo == "INGRESO POR DEVOLUCIÓN") { //INGRESO POR DEVOLUCION ALIAS REINGRESO

                $tmp = $cantidad_inicial;
                $cantidad_inicial = $cantidad_inicial + $row->cantidad_ingreso;
                $row->precio_de_compra = round($costo_inicial, 4);
                $row->costo_dolares = round($costo_inicial, 4);
                // $row->salida_dolares = round($row->costo_dolares * $row->cantidad_salida, 4);
                $row->ingreso_dolares = $row->precio_de_compra * $row->cantidad_ingreso;
                $ci = $row->cantidad_ingreso;
                if (!is_numeric($costo_inicial)) {
                    $costo_inicial = 0.0000001;
                }
            }


            if ($row->motivo == "EGRESO POR DEVOLUCIÓN" || $row->motivo == "EGRESO POR CONSUMO") {
                $tmp = $cantidad_inicial;
                $cantidad_inicial = $cantidad_inicial - $row->cantidad_salida;
                $row->costo_dolares = round($costo_inicial, 4);
                $row->salida_dolares = $row->costo_dolares * $row->cantidad_salida;

                $ci = $row->cantidad_salida;
                if (!is_numeric($costo_inicial)) {
                    $costo_inicial = 0.0000001;
                }
            }

            // dd($row->salida_dolares);
            $row->cantidad_saldo = round($cantidad_inicial, 4);
            $row->saldo_dolares = round($row->cantidad_saldo * $row->costo_dolares, 4);
        }
        //dd($resultados);
        return $resultados;
    }
    //metodo original con calculos hechos en el instante
    public function generateKardexReport(Request $request)
    {
        ini_set('max_execution_time', 360);
        $tmp = $request->all();
        $initDate = $tmp['fechaInicial'];
        $endDate = $tmp['fechaFinal'];

        $initDate = Carbon::createFromFormat('d/m/Y', $request['fechaInicial'])->format('Y-m-d 00:00:00');
        $endDate = Carbon::createFromFormat('d/m/Y', $request['fechaFinal'])->format('Y-m-d 23:59:00');

        $listRepuestos = [];
        $resultados = [];
        //$tmp['nroRepuesto'] ="21503F4100";
        if ($tmp['nroRepuesto'] != null) {
            $repuesto = Repuesto::where('codigo_repuesto', $tmp['nroRepuesto'])->first();
            $repuestos = MovimientoRepuesto::groupBy('id_repuesto')->where('id_repuesto', $repuesto->id_repuesto)->get();
        } else {
            $repuestos = MovimientoRepuesto::groupBy('id_repuesto')->get();
        }

        foreach ($repuestos as $row) {
            $id_repuesto = $row->id_repuesto;
            //$resultado = $this->generateKardexPerSpare($id_repuesto);
            $resultado = $this->generateKardexPerSpare($id_repuesto);

            //dd($resultado);
            $total_SI_cantidad_ingreso = 0;
            $total_SI_cantidad_salida = 0;
            $total_SI_saldo = 0;
            $total_SI_ingreso_dolar = 0;
            $total_SI_salida_dolar = 0;
            $total_SI_saldo_dolar = 0;
            $contador_movimientos = 0;
            $total_cantidad_ingreso = 0;
            $total_cantidad_salida = 0;
            $total_saldo = 0;
            $total_ingreso_dolar = 0;
            $total_salida_dolar = 0;
            $total_saldo_dolar = 0;
            $SI_agregado = false;
            $costito = 0; //yanose que nombre ponerle a esta variable
            foreach ($resultado as $r) {

                //calculo de SI

                if ($r->fecha_movimiento < $initDate) {
                    $total_SI_saldo = $r->cantidad_saldo;
                    $total_SI_ingreso_dolar += $r->ingreso_dolares;
                    $total_SI_salida_dolar += $r->salida_dolares;
                    $total_SI_saldo_dolar = $r->saldo_dolares;
                    if ($r->ingreso_dolares > 0) {
                        $costito = $r->costo_dolares;
                    }
                    if ($r->salida_dolares > 0) {
                        $costito = $r->costo_dolares;
                    }
                }

                // si el registro corresponde a la fecha
                if ($r->fecha_movimiento >= $initDate && $r->fecha_movimiento <= $endDate) {
                    // Si es el inicio se ejecuta esta seccion y solo una vez
                    if (!$SI_agregado) {
                        $total_SI = [
                            'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                            'descripcion' => 'SALDO INICIAL',
                            'fecha_movimiento' => '',
                            'usuario' => '',
                            'fuente' => '',
                            'nro_fuente' => '',
                            'nro_factura' => '',
                            'motivo' => 'S.I.',
                            'ubicacion' => '',
                            'cantidad_ingreso' => '',
                            'cantidad_salida' => 0,
                            'cantidad_saldo' => $total_SI_saldo,
                            'costo_dolares' => $total_SI_saldo > 0 ? round($total_SI_saldo_dolar / $total_SI_saldo, 4) : 0, //verificar

                            'ingreso_dolares' => $total_SI_ingreso_dolar,
                            'salida_dolares' => $total_SI_salida_dolar,
                            'saldo_dolares' => $total_SI_saldo_dolar,
                            'precio_de_compra' => '',
                        ];
                        array_push($resultados, (object) $total_SI);
                        $total_cantidad_ingreso = $total_SI_saldo;
                        $SI_agregado = true;
                    }
                    array_push($resultados, (object) $r);
                    $contador_movimientos++;

                    $total_cantidad_ingreso = $total_cantidad_ingreso + $r->cantidad_ingreso;
                    $total_cantidad_salida = $total_cantidad_salida + $r->cantidad_salida;
                }
                if ($r->fecha_movimiento <= $endDate) {
                    $total_ingreso_dolar = $total_ingreso_dolar + $r->ingreso_dolares;
                    $total_salida_dolar = $total_salida_dolar + $r->salida_dolares;
                }


                if ($r->fecha_movimiento > $endDate) {
                    break;
                } else {
                    $total_saldo = $r->cantidad_saldo;

                    $total_saldo_dolar = $r->saldo_dolares;
                }
            }

            if (!$SI_agregado) {
                $total_SI = [
                    'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                    'descripcion' => 'SALDO INICIAL',
                    'fecha_movimiento' => '',
                    'usuario' => '',
                    'fuente' => '',
                    'nro_fuente' => '',
                    'nro_factura' => '',
                    'motivo' => 'S.I.',
                    'ubicacion' => '',
                    'cantidad_ingreso' => '',
                    'cantidad_salida' => 0,
                    'cantidad_saldo' => $total_SI_saldo,
                    'costo_dolares' => $costito,
                    'ingreso_dolares' => $total_SI_ingreso_dolar,
                    'salida_dolares' => $total_SI_salida_dolar,
                    'saldo_dolares' => $total_SI_saldo_dolar,
                    'precio_de_compra' => '',
                ];
                array_push($resultados, (object) $total_SI);
            }

            $total = [
                'codigo_repuesto' => 'TOTAL ' . $row->repuesto->codigo_repuesto,
                'descripcion' => $row->repuesto->descripcion,
                'fecha_movimiento' => '',
                'usuario' => '',
                'fuente' => '',
                'nro_fuente' => '',
                'nro_factura' => '',
                'motivo' => 'TOTAL',
                'ubicacion' => '',
                'cantidad_ingreso' => $total_cantidad_ingreso,
                'cantidad_salida' => $total_cantidad_salida,
                'cantidad_saldo' => $total_saldo,
                'costo_dolares' => '',
                'ingreso_dolares' => $total_ingreso_dolar - $total_SI_ingreso_dolar,
                'salida_dolares' => $total_salida_dolar - $total_SI_salida_dolar,
                'saldo_dolares' => $total_saldo_dolar,
                'precio_de_compra' => '',
            ];

            // if($contador_movimientos > 0 || $total_SI_saldo>0){

            //     array_push($resultados, (object) $total);
            // }else{
            //      array_pop($resultados);
            // }

            array_push($resultados, (object) $total);

            //dd($resultados );
        }

        $nombreArchivo = "REPORTE_KARDEX.xlsx";
        return $resultados;
        // return Excel::download(new ExportReporteKardexController($resultados), $nombreArchivo);
    }



    public function generateKardexReport2(Request $request)
    {
        ini_set('max_execution_time', 360);
        $tmp = $request->all();
        $initDate = $tmp['fechaInicial'];
        $endDate = $tmp['fechaFinal'];

        $initDate = Carbon::createFromFormat('d/m/Y', $request['fechaInicial'])->format('Y-m-d 00:00:00');
        $endDate = Carbon::createFromFormat('d/m/Y', $request['fechaFinal'])->format('Y-m-d 23:59:00');

        $listRepuestos = [];
        $resultados = [];
        //$tmp['nroRepuesto'] ="21503F4100";
        if ($tmp['nroRepuesto'] != null) {
            $repuesto = Repuesto::where('codigo_repuesto', $tmp['nroRepuesto'])->first();
            $repuestos = MovimientoRepuesto::groupBy('id_repuesto')->where('id_repuesto', $repuesto->id_repuesto)->get();
        } else {
            $repuestos = MovimientoRepuesto::groupBy('id_repuesto')->get();
        }

        foreach ($repuestos as $row) {

            $id_repuesto = $row->id_repuesto;
            //$resultado = $this->generateKardexPerSpare($id_repuesto);
            $resultado = $this->generateKardexPerSpareCalculated($id_repuesto, $initDate, $endDate);
            $penultimo_movimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->where('fecha_movimiento', '<', $initDate)->orderBy('id_movimiento_repuesto', 'DESC')->first();
            //dd($penultimo_movimiento);
            $saldo_dolares_final = $penultimo_movimiento != null ? $penultimo_movimiento->saldo_dolares:0;
            usort($resultado, function ($a, $b) {
                return strtotime($a->fecha_movimiento) - strtotime($b->fecha_movimiento);
            });
            if ($penultimo_movimiento == null) {
                $total_SI = [
                    'codigo_repuesto' => $row->repuesto->codigo_repuesto,
                    'descripcion' => 'SALDO INICIAL',
                    'fecha_movimiento' => '',
                    'usuario' => '',
                    'fuente' => '',
                    'nro_fuente' => '',
                    'nro_factura' => '',
                    'motivo' => 'S.I.',
                    'ubicacion' => '',
                    'cantidad_ingreso' => '',
                    'cantidad_salida' => 0,
                    'cantidad_saldo' => 0,
                    'costo_dolares' => 0,
                    'ingreso_dolares' => 0,
                    'salida_dolares' => 0,
                    'saldo_dolares' => 0,
                    'precio_de_compra' => 0,
                ];
            } else {
                if ($penultimo_movimiento->tipo_movimiento == 'INGRESO') {
                    $costoxd = $penultimo_movimiento->costo_promedio_ingreso;
                } else {
                    $costoxd = $penultimo_movimiento->costo;
                }
                $total_SI = [
                    'codigo_repuesto' => $penultimo_movimiento->repuesto->codigo_repuesto,
                    'descripcion' => 'SALDO INICIAL',
                    'fecha_movimiento' => '',
                    'usuario' => '',
                    'fuente' => '',
                    'nro_fuente' => '',
                    'nro_factura' => '',
                    'motivo' => 'S.I.',
                    'ubicacion' => '',
                    'cantidad_ingreso' => '',
                    'cantidad_salida' => 0,
                    'cantidad_saldo' => $penultimo_movimiento->saldo,
                    'costo_dolares' => $costoxd,
                    'ingreso_dolares' => 0,
                    'salida_dolares' => 0,
                    'saldo_dolares' => $penultimo_movimiento->saldo_dolares,
                    'precio_de_compra' => '',
                ];
            }




            $contador_movimientos = 0;
            $total_cantidad_ingreso = 0;
            $total_cantidad_salida = 0;
            $total_saldo = $penultimo_movimiento!=null? $penultimo_movimiento->saldo:0;
            $total_ingreso_dolar = 0;
            $total_salida_dolar = 0;
            $total_saldo_dolar = $penultimo_movimiento!=null? $penultimo_movimiento->saldo_dolares:0;
            $SI_agregado = false;
            $costito = 0;

            array_push($resultados, (object) $total_SI);

            foreach ($resultado as $r) {
                array_push($resultados, (object) $r);
                $contador_movimientos++;
                $total_cantidad_ingreso = $total_cantidad_ingreso + $r->cantidad_ingreso;
                $total_cantidad_salida = $total_cantidad_salida + $r->cantidad_salida;
                $total_saldo = $r->cantidad_saldo;
                $saldo_dolares_final = $r->saldo_dolares;
            }

            //dd($resultados);   



            $total = [
                'codigo_repuesto' => 'TOTAL ' . $row->repuesto->codigo_repuesto,
                'descripcion' => $row->repuesto->descripcion,
                'fecha_movimiento' => '',
                'usuario' => '',
                'fuente' => '',
                'nro_fuente' => '',
                'nro_factura' => '',
                'motivo' => 'TOTAL',
                'ubicacion' => '',
                'cantidad_ingreso' => $total_cantidad_ingreso,
                'cantidad_salida' => $total_cantidad_salida,
                'cantidad_saldo' => $total_saldo,
                'costo_dolares' => '',
                'ingreso_dolares' => 0,
                'salida_dolares' => 0,
                'saldo_dolares' =>  $saldo_dolares_final,
                'precio_de_compra' => '',
            ];


            array_push($resultados, (object) $total);
            //dd($resultados );
        }

        $nombreArchivo = "REPORTE_KARDEX.xlsx";
        // return $resultados;
        return Excel::download(new ExportReporteKardexController($resultados), $nombreArchivo);
    }
}
