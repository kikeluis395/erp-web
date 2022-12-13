<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescuentoMeson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuento_meson', function (Blueprint $table) {
            $table->increments('id_descuento_meson');
            $table->double('porcentaje_solicitado_rptos')->nullable();
            $table->double('porcentaje_solicitado_lubricantes')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_usuario_solicitante')->unsigned();
            $table->boolean('es_aprobado')->nullable();
            $table->integer('id_usuario_respuesta')->unsigned()->nullable();
            $table->dateTime('fecha_respuesta')->nullable();
            $table->integer('id_cotizacion_meson')->unsigned();
            
            $table->foreign('id_cotizacion_meson')->references('id_cotizacion_meson')->on('cotizacion_meson');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descuento_meson');
    }
}
