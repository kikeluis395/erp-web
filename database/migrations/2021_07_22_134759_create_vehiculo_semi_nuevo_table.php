<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoSemiNuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_seminuevo', function (Blueprint $table) {
            $table->bigIncrements('id_vehiculo_seminuevo');
            $table->string('placa',6)->nullable(false);
            $table->string('vin',17)->nullable(false);
            $table->string('motor',32)->nullable(true);
            $table->integer('anho_fabricacion')->nullable(true);
            $table->integer('anho_modelo')->nullable(true);
            $table->unsignedBigInteger('id_almacen');
            $table->foreign('id_almacen')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_modelo_auto_seminuevo');
            $table->foreign('id_modelo_auto_seminuevo')->references('id_modelo_auto_seminuevo')->on('modelo_auto_seminuevo');
            $table->string('version',50)->nullable(true);
            $table->integer('kilometraje')->nullable(true);
            $table->string('color',50)->nullable(true);
            $table->string('combustible',50)->nullable(true);
            $table->double('cilindrada',4)->nullable(true);
            $table->string('transmision',50)->nullable(true);
            $table->string('traccion',50)->nullable(true);
            $table->unsignedInteger('id_local');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->integer('id_usuario_registro')->unsigned()->nullable();
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->integer('id_usuario_modifico')->unsigned()->nullable();
            $table->foreign('id_usuario_modifico')->references('id_usuario')->on('usuario');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos_nuevos');
    }
}
