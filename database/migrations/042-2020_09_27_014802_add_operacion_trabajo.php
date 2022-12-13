<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOperacionTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operacion_trabajo', function (Blueprint $table) {
            $table->increments('id_operacion_trabajo');
            $table->string('cod_operacion_trabajo',16)->unique();
            $table->string('descripcion',48);
            $table->enum('tipo_trabajo',['MECANICA','CARROCERIA','PANHOS PINTURA','SERVICIOS TERCEROS','MECANICA Y COLISION', 'GLOBAL-HORAS']);
            $table->double('costo_unitario',12,3)->default(10);
        });
        DB::unprepared("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
        INSERT INTO operacion_trabajo(id_operacion_trabajo,cod_operacion_trabajo,descripcion,tipo_trabajo)
        VALUES (0,'9999','LIBRE','GLOBAL-HORAS')");

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='MC01';
        $operacion->descripcion='Alineamiento de llantas';
        $operacion->tipo_trabajo='MECANICA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='MC02';
        $operacion->descripcion='Cambio de aceite de motor';
        $operacion->tipo_trabajo='MECANICA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='MC03';
        $operacion->descripcion='Ajuste de suspensión delantera';
        $operacion->tipo_trabajo='MECANICA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='CA01';
        $operacion->descripcion='Extraccion de puerta delantera';
        $operacion->tipo_trabajo='CARROCERIA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='CA03';
        $operacion->descripcion='Cambio de asiento piloto';
        $operacion->tipo_trabajo='CARROCERIA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='CA04';
        $operacion->descripcion='Cambio de panel frontal';
        $operacion->tipo_trabajo='CARROCERIA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='PP01';
        $operacion->descripcion='Pintado de puerta';
        $operacion->tipo_trabajo='PANHOS PINTURA';
        $operacion->save();

        $operacion = new App\Modelos\OperacionTrabajo();
        $operacion->cod_operacion_trabajo='ST01';
        $operacion->descripcion='Servicios Terceros 01';
        $operacion->tipo_trabajo='SERVICIOS TERCEROS';
        $operacion->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operacion_trabajo');
    }
}
