<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServicioTercero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_tercero', function (Blueprint $table) {
            $table->increments('id_servicio_tercero');
            $table->string('codigo_servicio_tercero',10);
            $table->string('descripcion', 64);
            $table->double('pvp',12,3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_tercero');
    }
}
