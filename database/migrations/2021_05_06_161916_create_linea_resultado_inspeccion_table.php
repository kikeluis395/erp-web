<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaResultadoInspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_resultado_inspeccion', function (Blueprint $table) {
            $table->bigIncrements('id_linea_resultado_inspeccion');
            $table->integer('id_hoja_inspeccion')->nullable()->unsigned();
            $table->foreign('id_hoja_inspeccion')->references('id_hoja_inspeccion')->on('hoja_inspeccion');
            $table->integer('id_elemento_inspeccion')->nullable()->unsigned();
            $table->foreign('id_elemento_inspeccion')->references('id_elemento_inspeccion')->on('elemento_inspeccion');
            $table->boolean('es_savar')->default(true);
            $table->boolean('es_dealer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_resultado_inspeccion');
    }
}
