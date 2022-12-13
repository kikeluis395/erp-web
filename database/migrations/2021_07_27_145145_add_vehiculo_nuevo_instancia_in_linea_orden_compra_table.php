<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVehiculoNuevoInstanciaInLineaOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_orden_compra', function (Blueprint $table) {
            $table->unsignedBigInteger('id_vehiculo_nuevo_instancia')->nullable();  
            $table->foreign('id_vehiculo_nuevo_instancia')->references('id_vehiculo_nuevo_instancia')->on('vehiculo_nuevo_instancia');
        });

        Schema::table('movimiento_vehiculo_nuevo', function (Blueprint $table) {
            $table->unsignedBigInteger('id_vehiculo_nuevo_instancia')->nullable();  
            $table->foreign('id_vehiculo_nuevo_instancia')->references('id_vehiculo_nuevo_instancia')->on('vehiculo_nuevo_instancia');
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
