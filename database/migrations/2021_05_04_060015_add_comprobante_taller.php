<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComprobanteTaller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_taller', function (Blueprint $table) {
            $table->increments('id_comprobante_taller');
            $table->integer('id_recepcion_ot')->unsigned();
            $table->integer('id_comprobante_venta')->unsigned();
            $table->integer('id_anticipo')->unsigned();
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
            $table->foreign('id_anticipo')->references('id_anticipo')->on('anticipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobante_taller');
    }
}
