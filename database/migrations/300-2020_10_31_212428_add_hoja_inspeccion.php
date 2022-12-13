<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHojaInspeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_inspeccion', function (Blueprint $table) {
            $table->increments('id_hoja_inspeccion');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_recepcion_ot')->unsigned();

            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoja_inspeccion');
    }
}
