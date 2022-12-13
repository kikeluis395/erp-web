<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaHojaInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_hoja_inventario', function (Blueprint $table) {
            $table->increments('id_linea_hoja_inventario');
            $table->integer('id_hoja_inventario')->unsigned();
            $table->integer('id_elemento_inventario')->unsigned();
            $table->boolean('resultado_inventario')->nullable();
            $table->integer('cantidad')->nullable();
            $table->boolean('rh')->nullable();
            $table->boolean('lh')->nullable();
            $table->string('observacion','100')->nullable();

            $table->foreign('id_hoja_inventario')->references('id_hoja_inventario')->on('hoja_inventario');
            $table->foreign('id_elemento_inventario')->references('id_elemento_inventario')->on('elemento_inventario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_hoja_inventario');
    }
}
