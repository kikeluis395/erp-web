<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaNotaIngreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_nota_ingreso', function (Blueprint $table) {
            $table->increments('id_linea_nota_ingreso');
            $table->double('cantidad_ingresada');
            $table->integer('id_linea_orden_compra')->unsigned();
            $table->integer('id_nota_ingreso')->unsigned();

            $table->foreign('id_linea_orden_compra')->references('id_linea_orden_compra')->on('linea_orden_compra');
            $table->foreign('id_nota_ingreso')->references('id_nota_ingreso')->on('nota_ingreso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_nota_ingreso');
    }
}
