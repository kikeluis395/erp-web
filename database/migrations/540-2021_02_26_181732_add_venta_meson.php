<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVentaMeson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_meson', function (Blueprint $table) {
            $table->increments('id_venta_meson');
            $table->integer('id_cotizacion_meson')->unsigned();
            $table->date('fecha_venta')->nullable();
            $table->string('nro_factura',128)->nullable();
            $table->dateTime('fecha_registro')->useCurrent();

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
        Schema::dropIfExists('venta_meson');
    }
}
