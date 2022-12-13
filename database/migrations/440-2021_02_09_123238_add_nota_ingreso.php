<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotaIngreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_ingreso', function (Blueprint $table) {
            $table->increments('id_nota_ingreso');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_usuario_registro')->unsigned();
            $table->integer('id_factura')->nullable();

            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_ingreso');
    }
}
