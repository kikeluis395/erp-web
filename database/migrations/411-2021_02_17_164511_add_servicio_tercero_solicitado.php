<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServicioTerceroSolicitado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_tercero_solicitado', function (Blueprint $table) {
            $table->increments('id_servicio_tercero_solicitado');
            $table->integer('id_hoja_trabajo')->unsigned();
            $table->integer('id_proveedor')->unsigned()->nullable();
            $table->integer('id_servicio_tercero')->unsigned();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_usuario_registro')->unsigned();

            $table->foreign('id_hoja_trabajo')->references('id_hoja_trabajo')->on('hoja_trabajo');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor');
            $table->foreign('id_servicio_tercero')->references('id_servicio_tercero')->on('servicio_tercero');
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_tercero_solicitado');
    }
}
