<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrasladoValuacionEvent extends Migration
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
        "SET GLOBAL event_scheduler=1;" .
        "CREATE EVENT actualizar_espera_valuacion
        ON SCHEDULE EVERY 3 HOUR DO 
        BEGIN
            INSERT INTO recepcion_ot_estado_reparacion
            SELECT A.id_recepcion_ot,2,1,NOW()
            FROM recepcion_ot_estado_reparacion A INNER JOIN recepcion_ot B ON A.id_recepcion_ot=B.id_recepcion_ot
            WHERE id_estado_reparacion=1 AND es_estado_actual=1 AND NOW()>=ADDTIME(B.fecha_traslado,'01:30:00');
            
            UPDATE recepcion_ot_estado_reparacion A INNER JOIN recepcion_ot B ON A.id_recepcion_ot=B.id_recepcion_ot
            SET A.es_estado_actual = 0
            WHERE id_estado_reparacion=1 AND es_estado_actual=1 AND NOW()>=ADDTIME(B.fecha_traslado,'01:30:00');
            
            CREATE TABLE IF NOT EXISTS prueba_eventos(fecha DATETIME);
            insert into prueba_eventos values(now());
        END
        ");

        DB::unprepared(
        "CREATE EVENT actualizar_espera_valuacion_minuto
        ON SCHEDULE EVERY 3 MINUTE DO 
        BEGIN
            INSERT INTO recepcion_ot_estado_reparacion
            SELECT A.id_recepcion_ot,2,1,NOW()
            FROM recepcion_ot_estado_reparacion A INNER JOIN recepcion_ot B ON A.id_recepcion_ot=B.id_recepcion_ot
            WHERE id_estado_reparacion=1 AND es_estado_actual=1 AND NOW()>=ADDTIME(B.fecha_traslado,'00:01:30');
            
            UPDATE recepcion_ot_estado_reparacion A INNER JOIN recepcion_ot B ON A.id_recepcion_ot=B.id_recepcion_ot
            SET A.es_estado_actual = 0
            WHERE id_estado_reparacion=1 AND es_estado_actual=1 AND NOW()>=ADDTIME(B.fecha_traslado,'00:01:30');
            
            CREATE TABLE IF NOT EXISTS prueba_eventos(fecha DATETIME);
            insert into prueba_eventos values(now());
        END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::unprepared("
        DROP EVENT actualizar_espera_valuacion;
        ");

        DB::unprepared("
        DROP EVENT actualizar_espera_valuacion_minuto;
        DROP TABLE prueba_eventos;
        ");
    }
}
