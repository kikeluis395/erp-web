<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVehiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->string('placa',6);
            $table->string('vin',17);
            $table->string('motor',32);
            $table->integer('id_marca_auto')->unsigned();
            $table->foreign('id_marca_auto')->references('id_marca_auto')->on('marca_auto');
            $table->integer('id_modelo_tecnico')->unsigned()->nullable();
            $table->foreign('id_modelo_tecnico')->references('id_modelo_tecnico')->on('modelo_tecnico');
            $table->string('modelo',32);
            $table->enum('tipo_transmision',['mecanico','automatico']);
            $table->integer('anho_vehiculo')->unsigned();
            $table->string('color',32);
            $table->enum('tipo_combustible',['gasolina', 'gnv-glp','petroleo']);

            $table->primary('placa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
}
