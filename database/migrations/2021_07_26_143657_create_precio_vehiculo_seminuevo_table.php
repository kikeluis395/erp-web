<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioVehiculoSeminuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_vehiculo_seminuevo', function (Blueprint $table) {
            $table->unsignedInteger('id_precio_vehiculo_seminuevo')->autoIncrement();
            $table->unsignedBigInteger('id_vehiculo_seminuevo')->nullable(false);
            $table->double('precio', 10, 2)->nullable();

            $table->unsignedInteger('creador')->nullable(false);
            $table->unsignedInteger('editor')->nullable();
            $table->unsignedInteger('id_local')->nullable(false);
            $table->boolean('habilitado')->nullable(false);
            $table->dateTime('fecha_edicion')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_vehiculo_seminuevo')->references('id_vehiculo_seminuevo')->on('vehiculo_seminuevo');
            $table->foreign('creador')->references('id_usuario')->on('usuario');
            $table->foreign('editor')->references('id_usuario')->on('usuario');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precio_vehiculo_seminuevo');
    }
}
