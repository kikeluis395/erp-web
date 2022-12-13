<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdVehiculoSeminuevoInLineaOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_orden_compra', function (Blueprint $table) {
            $table->unsignedBigInteger('id_vehiculo_seminuevo');
            //$table->foreign('id_vehiculo_seminuevo')->references('id_vehiculo_seminuevo')->on('vehiculo_seminuevo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linea_orden_compra', function (Blueprint $table) {
            //
        });
    }
}
