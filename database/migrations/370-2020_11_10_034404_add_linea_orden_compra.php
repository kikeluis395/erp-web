<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaOrdenCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_orden_compra', function (Blueprint $table) {
            $table->increments('id_linea_orden_compra');
            $table->integer('id_orden_compra')->unsigned();
            $table->integer('id_repuesto')->unsigned();
            $table->integer('cantidad')->unsigned();
            $table->double('precio',12,3);

            $table->foreign('id_orden_compra')->references('id_orden_compra')->on('orden_compra');
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_orden_compra');
    }
}
