<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUbicacionEstadoInVehiculoSeminuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehiculo_seminuevo', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado_stock')->nullable();
            $table->foreign('id_estado_stock')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_ubicacion')->nullable();
            $table->foreign('id_ubicacion')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_estado_vehiculo')->nullable();
            $table->foreign('id_estado_vehiculo')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_tipo_stock')->nullable();
            $table->foreign('id_tipo_stock')->references('id')->on('parametros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehiculo_nuevo', function (Blueprint $table) {
            //
        });
    }
}
