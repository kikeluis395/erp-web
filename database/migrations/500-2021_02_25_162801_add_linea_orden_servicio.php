<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaOrdenServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_orden_servicio', function (Blueprint $table) {
            $table->increments('id_linea_orden_servicio');
            $table->integer('id_orden_servicio')->unsigned();
            $table->integer('id_servicio_tercero_solicitado')->unsigned();
            $table->double('valor_costo');

            $table->foreign('id_orden_servicio')->references('id_orden_servicio')->on('orden_servicio');
            $table->foreign('id_servicio_tercero_solicitado')->references('id_servicio_tercero_solicitado')->on('servicio_tercero_solicitado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_orden_servicio');
    }
}
