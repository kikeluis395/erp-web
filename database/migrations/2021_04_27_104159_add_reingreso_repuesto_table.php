<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReingresoRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reingreso_repuestos', function (Blueprint $table) {
            $table->increments('id_reingreso_repuestos');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('usuario_registro')->unsigned();

            $table->foreign('usuario_registro')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reingreso_repuestos');
    }
}
