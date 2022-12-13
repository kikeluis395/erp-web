<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcaServicioTercerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marca_servicio_tercero', function (Blueprint $table) {
            $table->integer('servicio_tercero_id')->unsigned();
            $table->foreign('servicio_tercero_id')->references('id_servicio_tercero')->on('servicio_tercero');
            $table->integer('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id_marca_auto')->on('marca_auto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marca_servicio_tercero');
    }
}
