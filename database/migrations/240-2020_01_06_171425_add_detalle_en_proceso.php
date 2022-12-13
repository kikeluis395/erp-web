<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetalleEnProceso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_en_proceso', function (Blueprint $table) {
            $table->increments('id_detalle_proceso');

            $table->integer('id_reparacion')->unsigned();
            $table->foreign('id_reparacion')->references('id_reparacion')->on('reparacion');

            $table->string('etapa_proceso',64)->nullable(false);

            $table->dateTime('fecha_registro')->useCurrent();

            $table->integer('es_etapa_finalizada')->nullable();
            $table->dateTime('fecha_fin_etapa')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_en_proceso');
    }
}
