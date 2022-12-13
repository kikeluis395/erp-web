<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeloTecnico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_tecnico', function (Blueprint $table) {
            $table->increments('id_modelo_tecnico');
            $table->string('nombre_modelo', 100);
            $table->integer('id_marca_auto')->unsigned();
            $table->boolean('habilitado');
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_marca_auto')->references('id_marca_auto')->on('marca_auto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelo_tecnico');
    }
}
