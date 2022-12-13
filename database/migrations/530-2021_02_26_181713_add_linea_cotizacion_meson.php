<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaCotizacionMeson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_cotizacion_meson', function (Blueprint $table) {
            $table->increments('id_linea_cotizacion_meson');
            $table->integer('id_repuesto')->unsigned();
            $table->double('cantidad');
            $table->boolean('es_mayoreo')->nullable();
            $table->integer('id_cotizacion_meson')->unsigned();
            $table->boolean('es_atendido')->nullable();
            $table->dateTime('fecha_atencion')->nullable();
            $table->dateTime('fecha_pedido')->nullable();
            $table->date('fecha_promesa')->nullable();

            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
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
        Schema::dropIfExists('linea_cotizacion_meson');
    }
}
