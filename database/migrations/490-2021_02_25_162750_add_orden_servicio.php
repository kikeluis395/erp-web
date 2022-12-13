<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrdenServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicio', function (Blueprint $table) {
            $table->increments('id_orden_servicio');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_usuario_registro')->unsigned();
            $table->boolean('es_aprobado')->nullable();
            $table->dateTime('fecha_respuesta')->nullable();
            $table->integer('id_usuario_respuesta')->unsigned()->nullable();
            $table->integer('id_factura_compra')->unsigned()->nullable();

            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->foreign('id_usuario_respuesta')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_servicio');
    }
}
