<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaHojaInspeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_hoja_inspeccion', function (Blueprint $table) {
            $table->increments('id_linea_resultado_inspeccion');
            $table->integer('id_hoja_inspeccion')->unsigned();
            $table->integer('id_elemento_inspeccion')->unsigned();
            $table->enum('resultado',['green', 'yellow', 'red']);
            $table->double('valor',12,3)->nullable();

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
        Schema::dropIfExists('linea_hoja_inspeccion');
    }
}
