<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NecesidadRepuestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('necesidad_repuestos', function (Blueprint $table) {
            $table->increments('id_necesidad_repuestos');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_hoja_trabajo')->unsigned();
            $table->foreign('id_hoja_trabajo')->references('id_hoja_trabajo')->on('hoja_trabajo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('necesidad_repuestos');
    }
}
