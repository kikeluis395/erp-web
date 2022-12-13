<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHojaInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_inventario', function (Blueprint $table) {
            $table->increments('id_hoja_inventario');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_recepcion_ot')->unsigned();
            $table->enum('estado',['vacio','no_aplica','completo'])->default('vacio');

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
        Schema::dropIfExists('hoja_inventario');
    }
}
