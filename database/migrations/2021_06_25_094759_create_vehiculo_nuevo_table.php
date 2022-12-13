<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoNuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_nuevo', function (Blueprint $table) {
            $table->bigIncrements('id_vehiculo_nuevo');
            $table->string('modelo');
            $table->unsignedInteger('id_marca_auto');
            $table->foreign('id_marca_auto')->references('id_marca_auto')->on('marca_auto');
            $table->string('version');
            $table->string('modelo_comercial')->nullablle('true');
            $table->string('carroceria');
            $table->string('tipo');
            $table->string('combustible');
            $table->double('cilindrada',4);
            $table->double('num_cilindros',4);
            $table->string('transmision',50);
            $table->string('traccion',50);
            $table->double('potencia',4);
            $table->integer('num_ruedas');
            $table->integer('num_ejes');
            $table->double('distancia_entre_ejes',4);
            $table->integer('num_puertas');
            $table->integer('num_asientos');
            $table->integer('cap_pasajeros');
            $table->float('peso_bruto');
            $table->float('peso_neto');
            $table->float('carga_util');
            $table->float('alto');
            $table->float('largo');
            $table->float('ancho');
            $table->unsignedInteger('id_local');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->integer('id_usuario_registro')->unsigned()->nullable();
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->integer('id_usuario_modifico')->unsigned()->nullable();
            $table->foreign('id_usuario_modifico')->references('id_usuario')->on('usuario');
            $table->boolean('habilitado')->default(true);
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
