<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProceduresReportes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared(
            "CREATE PROCEDURE PROC_REPORTE_ESTANCIA()
            SELECT 	round(avg(base2.tiempo_valuacion),1) TIEMPO_VALUACION_PROMEDIO,
                    round(avg(base2.tiempo_autorizacion),1) TIEMPO_AUTORIZACION_PROMEDIO,
                    round(avg(base2.tiempo_asignacion),1) TIEMPO_ASIGNACION_PROMEDIO,
                    round(avg(base2.tiempo_termino_operativo_local),1) TIEMPO_TERMINO_OPERATIVO_LOCAL_PROMEDIO,
                    round(avg(base2.tiempo_entrega_local),1) TIEMPO_ENTREGA_LOCAL_PROMEDIO,
                    round(avg(base2.tiempo_termino_operativo_global),1) TIEMPO_TERMINO_OPERATIVO_GLOBAL_PROMEDIO,
                    round(avg(base2.tiempo_entrega_global),1) TIEMPO_ENTREGA_GLOBAL_PROMEDIO,
                    round(avg(base2.tiempo_estancia),1) TIEMPO_ESTANCIA_PROMEDIO
            FROM(
                SELECT 	base.id_recepcion_ot, base.placa_auto,
                        abs(datediff(base.fecha_valuacion,base.fecha_ingreso)) tiempo_valuacion,
                        abs(datediff(base.fecha_aprobacion_cliente,base.fecha_valuacion)) tiempo_autorizacion,
                        abs(datediff(base.fecha_inicio_operativo,base.fecha_aprobacion_cliente)) tiempo_asignacion,
                        abs(datediff(base.fecha_fin_operativo,base.fecha_inicio_operativo)) tiempo_termino_operativo_local,
                        abs(datediff(base.fecha_entrega,base.fecha_fin_operativo)) tiempo_entrega_local,
                        abs(datediff(base.fecha_fin_operativo,base.fecha_ingreso)) tiempo_termino_operativo_global,
                        abs(datediff(base.fecha_entrega,base.fecha_ingreso)) tiempo_entrega_global,
                        abs(datediff(base.fecha_entrega,base.fecha_ingreso)) tiempo_estancia
                FROM (
                    SELECT a.*,
                        f.placa_auto,f.fecha_registro as fecha_ingreso,
                        c.id_valuacion,c.fecha_valuacion,c.fecha_aprobacion_seguro,c.fecha_aprobacion_cliente,c.id_usuario_valuador,
                        d.id_reparacion,d.fecha_inicio_operativo,d.fecha_fin_operativo,
                        e.id_entregado_reparacion,e.fecha_entrega
                    FROM recepcion_ot a
                        LEFT JOIN  (SELECT c1.*
                                    FROM valuacion c1 INNER JOIN (SELECT c21.id_recepcion_ot, max(c21.fecha_registro) fecha_ult
                                                                FROM valuacion c21
                                                                GROUP BY c21.id_recepcion_ot) c2
                                                        ON c1.id_recepcion_ot=c2.id_recepcion_ot
                                                        and c1.fecha_registro = c2.fecha_ult
                                    ) c
                                ON a.id_recepcion_ot = c.id_recepcion_ot
                        LEFT JOIN reparacion d
                                ON a.id_recepcion_ot = d.id_recepcion_ot
                        LEFT JOIN entregado_reparacion e
                                ON a.id_recepcion_ot = e.id_recepcion_ot
                        INNER JOIN hoja_trabajo f
                                ON a.id_recepcion_ot = f.id_recepcion_ot
                ) base
            ) base2"
        );

        DB::unprepared(
        "CREATE PROCEDURE PROC_REPORTE_PERFORMANCE()
        SELECT  resumen1.cumplimiento,
        resumen2.porc_ampliaciones,
        resumen2.porc_hotline,
        resumen2.porc_mec_colision,
        IFNULL(resumen2.perdidas_totales,0) perdidas_totales,
        IFNULL(resumen1.horas_mec,0) horas_mec,
        IFNULL(resumen1.horas_carr,0) horas_carr,
        IFNULL(resumen1.panhos,0) panhos
        FROM(
            SELECT  SUM(resumen1.horas_mecanica) horas_mec,
                    SUM(resumen1.horas_carroceria) horas_carr,
                    SUM(resumen1.horas_panhos) panhos,
                    SUM(resumen1.cumple)/COUNT(1) cumplimiento
            FROM(
                SELECT  recepcion_ot.id_recepcion_ot,
                        IFNULL(valuacion.horas_mecanica,0) + IFNULL(ampliacion.horas_mecanica_amp,0) horas_mecanica,
                        IFNULL(valuacion.horas_carroceria,0) + IFNULL(ampliacion.horas_carroceria_amp,0) horas_carroceria,
                        IFNULL(valuacion.horas_panhos,0) + IFNULL(ampliacion.horas_panhos_amp,0) horas_panhos,
                        CASE WHEN(entregado_reparacion.fecha_entrega > ult_promesa_reparacion.fecha_promesa) 
                                THEN 0
                            ELSE 1
                            END AS cumple
                FROM recepcion_ot 
                INNER JOIN hoja_trabajo ON recepcion_ot.id_recepcion_ot = hoja_trabajo.id_recepcion_ot
                INNER JOIN valuacion ON valuacion.id_recepcion_ot = recepcion_ot.id_recepcion_ot
                LEFT JOIN (SELECT id_valuacion, SUM(horas_mecanica_amp) horas_mecanica_amp, SUM(horas_carroceria_amp) horas_carroceria_amp, SUM(horas_panhos_amp) horas_panhos_amp
                            FROM reprogramacion_valuacion
                            GROUP BY id_valuacion) ampliacion ON ampliacion.id_valuacion=valuacion.id_valuacion
                INNER JOIN reparacion ON reparacion.id_recepcion_ot = recepcion_ot.id_recepcion_ot
                INNER JOIN (SELECT promesas_reparacion.id_reparacion,promesas_reparacion.fecha_promesa,max_promesa.max_fecha_registro
                            FROM promesas_reparacion 
                            INNER JOIN (SELECT id_reparacion, MAX(fecha_registro) AS max_fecha_registro
                                        FROM promesas_reparacion
                                        GROUP BY id_reparacion) max_promesa 
                                    ON promesas_reparacion.id_reparacion = max_promesa.id_reparacion
                                        AND promesas_reparacion.fecha_registro = max_promesa.max_fecha_registro
                            )AS ult_promesa_reparacion ON reparacion.id_reparacion = ult_promesa_reparacion.id_reparacion
                INNER JOIN entregado_reparacion ON entregado_reparacion.id_recepcion_ot = recepcion_ot.id_recepcion_ot) resumen1
        )resumen1
        JOIN(
            SELECT  SUM(resumen2.es_ampliacion)/COUNT(1) porc_ampliaciones,
                    SUM(resumen2.es_hotline)/COUNT(1) porc_hotline,
                    SUM(resumen2.es_mec_colision)/COUNT(1) porc_mec_colision,
                    SUM(resumen2.es_perdida_total) perdidas_totales
            FROM(
                SELECT  recepcion_ot.id_recepcion_ot,
                        CASE WHEN (IFNULL(ampliacion.id_valuacion,0) != 0) THEN 1 ELSE 0 END es_ampliacion,
                        CASE WHEN (IFNULL(item_necesidad.id_necesidad_repuestos,0) != 0) THEN 1 ELSE 0 END es_hotline,
                        CASE WHEN (IFNULL(valuacion.horas_mecanica,0) + IFNULL(ampliacion.horas_mecanica_amp,0) > 0) THEN 1 ELSE 0 END es_mec_colision,
                        CASE WHEN (IFNULL(recepciones_pt.id_recepcion_ot,0) != 0) THEN 1 ELSE 0 END es_perdida_total
                FROM recepcion_ot
                INNER JOIN hoja_trabajo on hoja_trabajo.id_recepcion_ot = recepcion_ot.id_recepcion_ot
                LEFT JOIN valuacion ON recepcion_ot.id_recepcion_ot = valuacion.id_recepcion_ot
                LEFT JOIN (SELECT id_valuacion, SUM(horas_mecanica_amp) horas_mecanica_amp
                            FROM reprogramacion_valuacion
                            GROUP BY id_valuacion) AS ampliacion ON valuacion.id_valuacion = ampliacion.id_valuacion
                LEFT JOIN necesidad_repuestos ON necesidad_repuestos.id_hoja_trabajo = hoja_trabajo.id_hoja_trabajo
                LEFT JOIN (SELECT id_necesidad_repuestos
                            FROM item_necesidad_repuestos
                            WHERE es_importado=1 AND entregado=0
                            GROUP BY id_necesidad_repuestos) AS item_necesidad ON necesidad_repuestos.id_necesidad_repuestos = item_necesidad.id_necesidad_repuestos
                LEFT JOIN (SELECT recepcion_ot_estado_reparacion.id_recepcion_ot
                            FROM recepcion_ot_estado_reparacion 
                                INNER JOIN estado_reparacion
                                ON recepcion_ot_estado_reparacion.id_estado_reparacion = estado_reparacion.id_estado_reparacion
                            WHERE nombre_estado_reparacion_interno IN ('entregado_pt','perdida_total') 
                                    AND es_estado_actual = 1
                            GROUP BY recepcion_ot_estado_reparacion.id_recepcion_ot) AS recepciones_pt ON recepcion_ot.id_recepcion_ot = recepciones_pt.id_recepcion_ot
                ) resumen2
        ) resumen2"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::unprepared("DROP PROCEDURE PROC_REPORTE_ESTANCIA;");

        DB::unprepared("DROP PROCEDURE PROC_REPORTE_PERFORMANCE;");
    }
}
