<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Valuacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valuacion', function (Blueprint $table) {
            $table->increments('id_valuacion');
            $table->double('valor_mano_obra',12,3)->nullable(true);
            $table->double('valor_repuestos',12,3)->nullable(true);
            $table->double('valor_terceros',12,3)->nullable(true);
            $table->double('horas_mecanica',12,3)->nullable(true);
            $table->double('horas_carroceria',12,3)->nullable(true);
            $table->double('horas_panhos',12,3)->nullable(true);
            $table->integer('es_perdida_total')->default(0);
            $table->date('fecha_valuacion')->useCurrent()->nullable(true);;
            $table->date('fecha_aprobacion_seguro')->nullable(true);
            $table->dateTime('fecha_registro_aprobacion_seguro')->nullable(true);
            $table->date('fecha_aprobacion_cliente')->nullable(true);
            $table->dateTime('fecha_registro_aprobacion_cliente')->nullable(true);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_recepcion_ot')->unsigned();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
            $table->integer('id_usuario_valuador')->unsigned();
            $table->foreign('id_usuario_valuador')->references('id_usuario')->on('usuario');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valuacion');
    }
}