<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecepcionOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcion_ot', function (Blueprint $table) {
            $table->increments('id_recepcion_ot');
            $table->integer('id_tipo_ot')->unsigned();
            $table->foreign('id_tipo_ot')->references('id_tipo_ot')->on('tipo_ot');
            $table->integer('id_cia_seguro')->unsigned()->nullable(true);
            $table->foreign('id_cia_seguro')->references('id_cia_seguro')->on('cia_seguro');
            $table->integer('id_local')->unsigned();
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->integer('id_tecnico_asignado')->unsigned()->nullable(true);
            $table->foreign('id_tecnico_asignado')->references('id_tecnico')->on('tecnico_reparacion');
            $table->double('kilometraje');
            $table->dateTime('fecha_inicio')->nullable(true);
            $table->dateTime('fecha_entregar')->nullable(true);
            $table->dateTime('fecha_traslado')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcion_ot');
    }
}
