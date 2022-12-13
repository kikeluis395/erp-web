<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_ventas', function (Blueprint $table) {
            $table->bigIncrements('id_tipo_venta');
            $table->string('nombre_venta');
            $table->unsignedBigInteger('id_serie')->nullable();
            $table->foreign('id_serie')->references('id_serie')->on('series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_ventas');
    }
}
