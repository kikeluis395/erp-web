<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComprobanteMeson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_meson', function (Blueprint $table) {
            $table->increments('id_comprobante_meson');
            $table->integer('id_venta_meson')->unsigned();
            $table->integer('id_anticipo')->unsigned()->nullable();
            $table->integer('id_comprobante_venta')->unsigned()->nullable();
            $table->string('nro_comprobante_externo')->nullable();
            $table->date('fecha_comprobante_externo')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_venta_meson')->references('id_venta_meson')->on('venta_meson');
            $table->foreign('id_anticipo')->references('id_anticipo')->on('anticipo');
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobante_meson');
    }
}
