<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnticipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipo', function (Blueprint $table) {
            $table->increments('id_anticipo');
            $table->integer('id_comprobante_venta')->unsigned();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->double('total_anticipo');

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
        Schema::dropIfExists('anticipo');
    }
}
