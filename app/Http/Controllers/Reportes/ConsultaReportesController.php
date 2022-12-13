<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Modelos\LocalEmpresa;
use App\Modelos\RecepcionOT;
use App\Modelos\Repuesto;
use App\Modelos\TipoOT;
use Carbon\Carbon;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class ConsultaReportesController extends Controller
{
    public function consultaKardex(Request $request)
    {
        if ($request->fechaFinal && $request->fechaInicial) {
            $fechaInicial = Carbon::createFromFormat('d/m/Y', $request->fechaInicial);
            $fechaInicial = Carbon::parse($fechaInicial)->format('Y-m-d');
            $fechaFinal = Carbon::createFromFormat('d/m/Y', $request->fechaFinal);
            $fechaFinal = Carbon::parse($fechaFinal)->format('Y-m-d');
            $idRepuesto = null;
            if (!is_null($request->nroRepuesto)) {
                $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();
                $idRepuesto = $repuesto->id_repuesto;
            }
            //dd($request->all());
            $query = is_null($idRepuesto) ? DB::select("CALL tmp_reporte_kardex_v2(null,'$fechaInicial','$fechaFinal')") : DB::select("CALL tmp_reporte_kardex_v2($idRepuesto,'$fechaInicial','$fechaFinal')");

            return view('reportes.consultaReporteKardex', [
                'resultados' => $query,
                'fechaInicial' => $fechaInicial,
                'fechaFinal' => $fechaFinal,
                'idRepuesto' => $idRepuesto
            ]);
        }
        return view('reportes.consultaReporteKardex', ['resultados' => []]);
    }

    public function consultaVentaRepuestos(Request $request)
    {
        if ($request->fechaFinal && $request->fechaInicial) {
            $fechaInicial = Carbon::createFromFormat('d/m/Y', $request->fechaInicial);
            $fechaInicial = Carbon::parse($fechaInicial)->format('Y-m-d');
            $fechaFinal = Carbon::createFromFormat('d/m/Y', $request->fechaFinal);
            $fechaFinal = Carbon::parse($fechaFinal)->format('Y-m-d');
            $query = DB::select("select * from tmp_reporte_venta_repuestos where fecha_factura BETWEEN '$fechaInicial' and '$fechaFinal'");
            return view('reportes.consultaReporteVentaRepuestos', [
                'resultados' => $query,
                'fechaInicial' => $fechaInicial,
                'fechaFinal' => $fechaFinal
            ]);
        }
        return view('reportes.consultaReporteVentaRepuestos', ['resultados' => []]);
    }

    public function consultaOts(Request $request)
    {
        if ($request->fechaFinal && $request->fechaInicial) {
            $fechaInicial = Carbon::createFromFormat('d/m/Y', $request->fechaInicial);
            $fechaInicial = Carbon::parse($fechaInicial)->format('Y-m-d');
            $fechaFinal = Carbon::createFromFormat('d/m/Y', $request->fechaFinal);
            $fechaFinal = Carbon::parse($fechaFinal)->format('Y-m-d');
            $query = DB::select("select * from tmp_consultas_ots where fecha_apertura BETWEEN '$fechaInicial' and '$fechaFinal'");
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
                where fecha_apertura BETWEEN '$fechaInicial' and '$fechaFinal'
                group by SECCION
            ");

            $queryFacturacion = DB::select(
                "
                select SECCION,
                        sum(case when tipo_ot= 'CORRECTIVO' then venta_total - dscto_total else 0 end) CORRECTIVO,
                        sum(case when tipo_ot= 'PREVENTIVO' then venta_total - dscto_total else 0 end) PREVENTIVO,
                        sum(case when tipo_ot= 'RECLAMO' then venta_total - dscto_total else 0 end) RECLAMO,
                        sum(case when tipo_ot= 'GARANTIA' then venta_total - dscto_total else 0 end) GARANTIA,
                        sum(case when tipo_ot= 'PDI' then venta_total - dscto_total else 0 end) PDI,
                        sum(case when tipo_ot= 'SINIESTRO' then venta_total - dscto_total else 0 end) SINIESTRO,
                        sum(case when tipo_ot= 'CORTESIA' then venta_total - dscto_total else 0 end) CORTESIA,
                        sum(case when tipo_ot= 'ACCESORIOS' then venta_total - dscto_total else 0 end) ACCESORIOS
                from tmp_consultas_ots
                where BINARY estado_ot= BINARY 'ENTREGADO' and fecha_apertura BETWEEN '$fechaInicial' and '$fechaFinal'
                group by SECCION"
            );

            return view('reportes.consultaReporteOts', [
                'resultados' => $query,
                'resultadosCantidad' => $queryCantidades,
                'resultadosFacturacion' => $queryFacturacion,
                'fechaInicial' => $fechaInicial,
                'fechaFinal' => $fechaFinal
            ]);
        }
        return view('reportes.consultaReporteOts', ['resultados' => []]);
    }

    ############################################ OTV INICIO 01/06/2021 ###############################################
    public function consultacantidadOts(Request $request)
    {

        $locales = LocalEmpresa::orderBy('nombre_local')->get();

        $secc_1 = $request->seccion_1;
        $secc_2 = $request->seccion_2;
        $local_t = $request->local_ot;
        $anio_ot = $request->anio_ot;
        $year = $anio_ot;

        $anio_ot = $request->anio_ot ?? Carbon::now()->year;

        $est_ot = $request->estado_ot;

        $today = Carbon::now();
        $anio_actual = Carbon::now()->year;
        $mes_actual = Carbon::now()->month;
        $dia_actual = Carbon::now()->day;

        $fechaActual = $today->format('d/m/Y');

        $date = $today->format('H:i:s');

        $proyeccion = request()->proyeccion ? true : false;

        $diasUtiles = \App\Helper\Helper::getDiasHabiles("$anio_ot-$mes_actual-01", "$anio_ot-$mes_actual-" . \App\Helper\Helper::getDayForDiasHabiles($anio_ot, $anio_actual, $mes_actual, $mes_actual, $dia_actual), \App\Helper\Helper::getFeriados($anio_ot, $mes_actual));

        $diasTotales = \App\Helper\Helper::getDiasHabiles("$anio_ot-$mes_actual-01", "$anio_ot-$mes_actual-" . cal_days_in_month(CAL_GREGORIAN, $mes_actual, $anio_ot), \App\Helper\Helper::getFeriados($anio_ot, $mes_actual));

        $filt_sec = '';
        $filt_tip = '';

        if ($secc_1 == 'DYP') {
            $filt_sec = "AND htr.tipo_trabajo = '$secc_1'";
            $activo1 = 'checked';
            $activo2 = '';
        }

        if ($secc_2 == 'PREVENTIVO') {
            $filt_sec = "AND htr.tipo_trabajo = '$secc_2'";
            $activo2 = 'checked';
            $activo1 = '';
        }

        if ($secc_1 === 'DYP' && $secc_2 === 'PREVENTIVO') {
            $filt_sec = "AND (htr.tipo_trabajo = '$secc_1' OR htr.tipo_trabajo = '$secc_2' )";
            $activo1 = 'checked';
            $activo2 = 'checked';
        }

        //**************************************************
        if ($est_ot == 'TOTALES') {
            $filt_tip = " ";
            $est_act4 = 'checked';
            $est_act1 = '';
            $est_act2 = '';
            $est_act3 = '';
        } else if ($est_ot == 'FACTURADAS') {
            $filt_tip = " AND er.id_recepcion_ot IS NOT NULL";
            $est_act1 = 'checked';
            $est_act2 = '';
            $est_act3 = '';
            $est_act4 = '';
        } else if ($est_ot == 'CERRADAS') {
            $filt_tip = " AND oc.id_recepcion_ot IS NOT NULL";
            $est_act2 = 'checked';
            $est_act1 = '';
            $est_act3 = '';
            $est_act4 = '';
        } else if ($est_ot == 'ABIERTAS') {
            $filt_tip = "";
            $est_act3 = 'checked';
            $est_act1 = '';
            $est_act2 = '';
            $est_act4 = '';
        }



        if ($est_ot == "TOTALES") {

            $queryCantidades =
                DB::select("SELECT  query1.TIPO_OT , 
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 1 THEN 1 ELSE 0 END) AS ENE,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 2 THEN 1 ELSE 0 END) AS FEB,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 3 THEN 1 ELSE 0 END) AS MAR,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 4 THEN 1 ELSE 0 END) AS ABR,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 5 THEN 1 ELSE 0 END) AS MAY,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 6 THEN 1 ELSE 0 END) AS JUN,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 7 THEN 1 ELSE 0 END) AS JUL,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 8 THEN 1 ELSE 0 END) AS AGO,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 9 THEN 1 ELSE 0 END) AS SEP,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 10 THEN 1 ELSE 0 END) AS OCT,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 11 THEN 1 ELSE 0 END) AS NOV,
                                    SUM(CASE WHEN MONTH(query1.fecha_registro) = 12 THEN 1 ELSE 0 END) AS DIC
                            FROM 
                            
                            (
                                select tot.nombre_tipo_ot  AS TIPO_OT, htr.fecha_recepcion AS fecha_registro
                    FROM recepcion_ot rot 
										LEFT JOIN entregado_reparacion er ON er.id_recepcion_ot = rot.id_recepcion_ot
                        LEFT JOIN ot_cerrada oc ON oc.id_recepcion_ot = rot.id_recepcion_ot 
         
                    INNER JOIN tipo_ot tot ON tot.id_tipo_ot = rot.id_tipo_ot
                    INNER JOIN local_empresa lem ON lem.id_local = rot.id_local
                    INNER JOIN hoja_trabajo htr ON htr.id_recepcion_ot = rot.id_recepcion_ot                   
                    WHERE 
                       

                    er.id_recepcion_ot is Null and oc.id_recepcion_ot is Null  $filt_sec
                    
                    AND tot.habilitado = 1 AND lem.habilitado = 1
                            
                            UNION ALL
                            
                            select tot.nombre_tipo_ot  AS TIPO_OT, oc.fecha_registro AS fecha_registro
                            FROM ot_cerrada oc 
                            INNER JOIN recepcion_ot rot ON rot.id_recepcion_ot = oc.id_recepcion_ot 
                            INNER JOIN tipo_ot tot ON tot.id_tipo_ot = rot.id_tipo_ot
                            INNER JOIN local_empresa lem ON lem.id_local = rot.id_local
                            INNER JOIN hoja_trabajo htr ON htr.id_recepcion_ot = rot.id_recepcion_ot
                            
    
                            
                            UNION ALL
                            
                            select tot.nombre_tipo_ot  AS TIPO_OT, er.fecha_entrega AS fecha_registro
                            FROM entregado_reparacion er 
                            INNER JOIN recepcion_ot rot ON rot.id_recepcion_ot = er.id_recepcion_ot 
                            INNER JOIN tipo_ot tot ON tot.id_tipo_ot = rot.id_tipo_ot
                            INNER JOIN local_empresa lem ON lem.id_local = rot.id_local
                            INNER JOIN hoja_trabajo htr ON htr.id_recepcion_ot = rot.id_recepcion_ot
                            
                            WHERE lem.id_local = ? AND YEAR(htr.fecha_registro) = ?
                            $filt_sec
                           
                            AND tot.habilitado = 1 AND lem.habilitado = 1
                            
                            ) as query1 GROUP BY TIPO_OT ORDER BY TIPO_OT
     
                        ", [$local_t, $anio_ot]);
        } elseif ($est_ot == "FACTURADAS") {
            $queryCantidades =
                DB::select("SELECT  query1.TIPO_OT ,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 1 THEN 1 ELSE 0 END) AS ENE,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 2 THEN 1 ELSE 0 END) AS FEB,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 3 THEN 1 ELSE 0 END) AS MAR,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 4 THEN 1 ELSE 0 END) AS ABR,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 5 THEN 1 ELSE 0 END) AS MAY,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 6 THEN 1 ELSE 0 END) AS JUN,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 7 THEN 1 ELSE 0 END) AS JUL,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 8 THEN 1 ELSE 0 END) AS AGO,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 9 THEN 1 ELSE 0 END) AS SEP,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 10 THEN 1 ELSE 0 END) AS OCT,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 11 THEN 1 ELSE 0 END) AS NOV,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 12 THEN 1 ELSE 0 END) AS DIC
                        FROM
                        (
                        select tot.nombre_tipo_ot  AS TIPO_OT, er.fecha_entrega AS fecha_registro
                        FROM entregado_reparacion er
                        INNER JOIN recepcion_ot rot ON rot.id_recepcion_ot = er.id_recepcion_ot
                        INNER JOIN tipo_ot tot ON tot.id_tipo_ot = rot.id_tipo_ot
                        INNER JOIN local_empresa lem ON lem.id_local = rot.id_local
                        INNER JOIN hoja_trabajo htr ON htr.id_recepcion_ot = rot.id_recepcion_ot
                        WHERE lem.id_local = ? AND YEAR(htr.fecha_registro) = ?
                        $filt_sec
                        
                        AND tot.habilitado = 1 AND lem.habilitado = 1
                        ) as query1 GROUP BY TIPO_OT ORDER BY TIPO_OT


            ", [$local_t, $anio_ot]);
        } elseif ($est_ot == "ABIERTAS") {

            $queryCantidades =
                DB::select(" SELECT  query1.TIPO_OT , 
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 1 THEN 1 ELSE 0 END) AS ENE,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 2 THEN 1 ELSE 0 END) AS FEB,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 3 THEN 1 ELSE 0 END) AS MAR,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 4 THEN 1 ELSE 0 END) AS ABR,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 5 THEN 1 ELSE 0 END) AS MAY,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 6 THEN 1 ELSE 0 END) AS JUN,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 7 THEN 1 ELSE 0 END) AS JUL,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 8 THEN 1 ELSE 0 END) AS AGO,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 9 THEN 1 ELSE 0 END) AS SEP,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 10 THEN 1 ELSE 0 END) AS OCT,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 11 THEN 1 ELSE 0 END) AS NOV,
                            SUM(CASE WHEN MONTH(query1.fecha_registro) = 12 THEN 1 ELSE 0 END) AS DIC
                    FROM 
                    
                    (
                        select tot.nombre_tipo_ot  AS TIPO_OT, htr.fecha_recepcion AS fecha_registro
                    FROM recepcion_ot rot 
										LEFT JOIN entregado_reparacion er ON er.id_recepcion_ot = rot.id_recepcion_ot
                        LEFT JOIN ot_cerrada oc ON oc.id_recepcion_ot = rot.id_recepcion_ot 
         
                    INNER JOIN tipo_ot tot ON tot.id_tipo_ot = rot.id_tipo_ot
                    INNER JOIN local_empresa lem ON lem.id_local = rot.id_local
                    INNER JOIN hoja_trabajo htr ON htr.id_recepcion_ot = rot.id_recepcion_ot                   
                    WHERE lem.id_local = ? AND YEAR(htr.fecha_registro) = ?
                        $filt_sec

                    AND  er.id_recepcion_ot is Null and oc.id_recepcion_ot is Null
                    
                    AND tot.habilitado = 1 AND lem.habilitado = 1
                    ) as query1 GROUP BY TIPO_OT ORDER BY TIPO_OT
            ", [$local_t, $anio_ot]);
        } elseif ($est_ot == "CERRADAS") {

            $garantia = TipoOT::where('nombre_tipo_ot', 'LIKE', 'GARANT%')->get()->first()->nombre_tipo_ot;

            $garantiasCerradas =  RecepcionOT::selectRaw("id_tipo_ot AS TIPO_OT, 
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 1 THEN 1 ELSE 0 END) AS ENE,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 2 THEN 1 ELSE 0 END) AS FEB,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 3 THEN 1 ELSE 0 END) AS MAR,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 4 THEN 1 ELSE 0 END) AS ABR,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 5 THEN 1 ELSE 0 END) AS MAY,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 6 THEN 1 ELSE 0 END) AS JUN,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 7 THEN 1 ELSE 0 END) AS JUL,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 8 THEN 1 ELSE 0 END) AS AGO,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 9 THEN 1 ELSE 0 END) AS SEP,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 10 THEN 1 ELSE 0 END) AS OCT,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 11 THEN 1 ELSE 0 END) AS NOV,
                                SUM(CASE WHEN MONTH(fecha_nota_entrega) = 12 THEN 1 ELSE 0 END) AS DIC
            ")->whereHas('estadosReparacion', function ($query) {
                $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno', ['garantia_cerrado'])
                    ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1)
                    ->orderBy('estado_reparacion.nombre_estado_reparacion');
            })
                ->get()->first();

            $garantiasCerradas->TIPO_OT = $garantia;

            $queryCantidades =
                DB::select("SELECT  query1.TIPO_OT , 
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 1 THEN 1 ELSE 0 END) AS ENE,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 2 THEN 1 ELSE 0 END) AS FEB,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 3 THEN 1 ELSE 0 END) AS MAR,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 4 THEN 1 ELSE 0 END) AS ABR,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 5 THEN 1 ELSE 0 END) AS MAY,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 6 THEN 1 ELSE 0 END) AS JUN,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 7 THEN 1 ELSE 0 END) AS JUL,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 8 THEN 1 ELSE 0 END) AS AGO,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 9 THEN 1 ELSE 0 END) AS SEP,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 10 THEN 1 ELSE 0 END) AS OCT,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 11 THEN 1 ELSE 0 END) AS NOV,
                                SUM(CASE WHEN MONTH(query1.fecha_registro) = 12 THEN 1 ELSE 0 END) AS DIC
                        FROM 
                        
                        (
                        select tot.nombre_tipo_ot  AS TIPO_OT, oc.fecha_registro AS fecha_registro
                        FROM ot_cerrada oc 
                        INNER JOIN recepcion_ot rot ON rot.id_recepcion_ot = oc.id_recepcion_ot 
                        INNER JOIN tipo_ot tot ON tot.id_tipo_ot = rot.id_tipo_ot
                        INNER JOIN local_empresa lem ON lem.id_local = rot.id_local
                        INNER JOIN hoja_trabajo htr ON htr.id_recepcion_ot = rot.id_recepcion_ot
                        WHERE lem.id_local = ? AND YEAR(htr.fecha_registro) = ?
                        $filt_sec
                        
                        AND tot.habilitado = 1 AND lem.habilitado = 1
                        ) as query1 GROUP BY TIPO_OT ORDER BY TIPO_OT


            ", [$local_t, $anio_ot]);

            array_push($queryCantidades, $garantiasCerradas);
            // return $queryCantidades;
        }

        if ($local_t && $anio_ot && $secc_1 || $secc_2 && $est_ot) {

            $total_ene = 0;
            $total_feb = 0;
            $total_mar = 0;
            $total_abr = 0;
            $total_may = 0;
            $total_jun = 0;
            $total_jul = 0;
            $total_ago = 0;
            $total_sep = 0;
            $total_oct = 0;
            $total_nov = 0;
            $total_dic = 0;
            foreach ($queryCantidades as $row) {

                $total_ene += $row->ENE;
                $total_feb += $row->FEB;
                $total_mar += $row->MAR;
                $total_abr += $row->ABR;
                $total_may += $row->MAY;
                $total_jun += $row->JUN;
                $total_jul += $row->JUL;
                $total_ago += $row->AGO;
                $total_sep += $row->SEP;
                $total_oct += $row->OCT;
                $total_nov += $row->NOV;
                $total_dic += $row->DIC;
            }

            $resultadoTotal = (object)[
                "TIPO_OT" => "TOTAL",
                "T_ENE" => $total_ene,
                'T_FEB' => $total_feb,
                'T_MAR' => $total_mar,
                'T_ABR' => $total_abr,
                'T_MAY' => $total_may,
                'T_JUN' => $total_jun,
                'T_JUL' => $total_jul,
                'T_AGO' => $total_ago,
                'T_SEP' => $total_sep,
                'T_OCT' => $total_oct,
                'T_NOV' => $total_nov,
                'T_DIC' => $total_dic,

            ];



            $queryTotal = [];
            array_push($queryTotal, $resultadoTotal);


            return view('reportes.consultaReporteCantidadOts', [
                'resultadoCantidad' => $queryCantidades,
                'resultadoTotal' => $queryTotal,
                'local_t' => $local_t,
                'anio_ot' => $anio_ot,
                'dia_actual' => $dia_actual,
                'mes_actual' => $mes_actual,
                'anio_actual' => $anio_actual,
                'proyeccion' => $proyeccion,
                'date' => $date,
                'fechaActual' => $fechaActual,
                'diasUtiles' => $diasUtiles,
                'diasTotales' => $diasTotales,
                'seccion_1' => $secc_1,
                'seccion_2' => $secc_2,
                'est_ot' => $est_ot,
                'activo1' => $activo1,
                'activo2' => $activo2,
                'est_act1' => $est_act1,
                'est_act2' => $est_act2,
                'est_act3' => $est_act3,
                'est_act4' => $est_act4,
                'locales' => $locales
            ]);
        }

        return view('reportes.consultaReporteCantidadOts', ['locales' => $locales, 'resultados' => []]);
    }
    ############################################ OTV FIN 01/06/2021 ###############################################

    ############################################ OTV INICIO 04/06/2021 ###############################################
    public function reporteCitas(Request $request)
    {

        $locales = LocalEmpresa::orderBy('nombre_local')->get();

        $local_t = $request->local_ot;
        $anio_ot = $request->anio_ot;

        $today = Carbon::now();
        $fechaActual = $today->format('d/m/Y');

        $date = $today->format('H:i:s');

        $mes_actual = Carbon::now()->month;

        if ($local_t && $anio_ot) {

            //CANTIDAD CITAS AGENDADAS
            $CantCitAgen = DB::select("CALL sp_cantidadCitasAgendadas(?, ?)", [$local_t, $anio_ot]);
            //TOTAL CITAS AGENDADAS
            $CantCitAgenTotal = DB::select("CALL sp_cantidadCitasAgendadasTotal(?, ?)", [$local_t, $anio_ot]);

            //CANTIDAD CITAS AGENDADAS EFECTIVAS
            $CantCitAgenEfec = DB::select("CALL sp_cantidadCitasAgendadasEfectivas(?, ?)", [$local_t, $anio_ot]);
            //TOTAL CITAS AGENDADAS EFECTIVAS
            $CantCitAgenEfecTotal = DB::select("CALL sp_cantidadCitasAgendadasEfectivasTotal(?, ?)", [$local_t, $anio_ot]);

            //% CANTIDA EFECTIVIDAD
            $CantEfectividad = DB::select("CALL sp_cantidadPorcentajeEfectividad(?, ?)", [$local_t, $anio_ot]);
            //% TOTAL EFECTIVIDAD
            $CantEfectividadTotal = DB::select("CALL sp_cantidadPorcentajeEfectividadTotal(?, ?)", [$local_t, $anio_ot]);
            //CANTIDA CLIENTES CON Y SIN CITA
            $CantCliConySinCita = DB::select("CALL sp_clientesConySinCitaTotal(?, ?)", [$local_t, $anio_ot]);
            //CANTIDA CLIENTES SIN CITA
            $CantCliSinCita = DB::select("CALL sp_cantidadClientesSinCita(?, ?)", [$local_t, $anio_ot]);
            //% CLIENTES CON CITA
            $CantCliConCitaTotal = DB::select("CALL sp_cantidadPorcentajeClientesConCita(?, ?)", [$local_t, $anio_ot]);
            //% CLIENTES SIN CITA
            $CantCliSinCitaTotal = DB::select("CALL sp_cantidadPorcentajeClientesSinCita(?, ?)", [$local_t, $anio_ot]);

            return view('reportes.consultaReporteCitas', [
                'CantCitAgen' => $CantCitAgen,
                'CantCitAgenTotal' => $CantCitAgenTotal,
                'CantCitAgenEfec' => $CantCitAgenEfec,
                'CantCitAgenEfecTotal' => $CantCitAgenEfecTotal,
                'CantEfectividad' => $CantEfectividad,
                'CantEfectividadTotal' => $CantEfectividadTotal,
                'CantCliSinCita' => $CantCliSinCita,
                'CantCliConySinCita' => $CantCliConySinCita,
                'CantCliConCitaTotal' => $CantCliConCitaTotal,
                'CantCliSinCitaTotal' => $CantCliSinCitaTotal,
                'local_t' => $local_t,
                'anio_ot' => $anio_ot,
                'date' => $date,
                'mes_actual' => $mes_actual,
                'fechaActual' => $fechaActual,
                'locales' => $locales
            ]);
        }

        return view('reportes.consultaReporteCitas', [
            'locales' => $locales,
            'mes_actual' => $mes_actual,
            'resultados' => []
        ]);
    }
    ############################################ OTV FIN 01/06/2021 ###############################################

    ############################################ OTV INICIO 04/06/2021 ###############################################
    public function reporteModelos(Request $request)
    {

        $locales = LocalEmpresa::orderBy('nombre_local')->get();

        $local_t = $request->local_ot;
        $anio_ot = $request->anio_ot;

        $today = Carbon::now();
        $fechaActual = $today->format('d/m/Y');

        $date = $today->format('H:i:s');

        $mes_actual = Carbon::now()->month;

        if ($local_t && $anio_ot) {

            $CantCitAgen = DB::select("CALL sp_cantidadCitasAgendadas(?, ?)", [$local_t, $anio_ot]);

            $CantCitAgenTotal = DB::select("CALL sp_cantidadCitasAgendadasTotal(?, ?)", [$local_t, $anio_ot]);

            return view('reportes.consultaModelos', [
                'CantCitAgen' => $CantCitAgen,
                'CantCitAgenTotal' => $CantCitAgenTotal,
                'local_t' => $local_t,
                'anio_ot' => $anio_ot,
                'date' => $date,
                'mes_actual' => $mes_actual,
                'fechaActual' => $fechaActual,
                'locales' => $locales
            ]);
        }

        return view('reportes.consultaModelos', [
            'locales' => $locales,
            'mes_actual' => $mes_actual,
            'resultados' => []
        ]);
    }
    ############################################ OTV FIN 01/06/2021 ###############################################

    public function consultaStock(Request $request)
    {

        $local_t = $request->local_ot;
        $fechaInicial = $request->fechaInicial;

        if ($fechaInicial) {

            $fechaInicial = Carbon::createFromFormat('d/m/Y', $fechaInicial);

            $fechaInicial = Carbon::parse($fechaInicial)->format('Y-m-d');

            $query = DB::select("CALL sp_ConsultaStock(?, ?)", [$local_t, $fechaInicial]);

            return view('reportes.consultaReporteStock', [
                'resultados' => $query,
                'fechaInicial' => $fechaInicial
            ]);
        }

        return view('reportes.consultaReporteStock', ['resultados' => []]);
    }
}
