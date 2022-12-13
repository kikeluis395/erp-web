<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeLineaResultadoInspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('linea_resultado_inspeccion');
        Schema::create('linea_resultado_inspeccion', function (Blueprint $table) {
            $table->bigIncrements('id_linea_resultado_inspeccion');
            $table->unsignedBigInteger('id_hoja_inspeccion');
            $table->integer('id_elemento_inspeccion')->unsigned();
            $table->tinyInteger('es_savar');
            $table->tinyInteger('es_dealer');

            $table->foreign('id_hoja_inspeccion')->references('id_hoja_inspeccion')->on('hoja_inspeccion');
            $table->foreign('id_elemento_inspeccion')->references('id_elemento_inspeccion')->on('elemento_inspeccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
