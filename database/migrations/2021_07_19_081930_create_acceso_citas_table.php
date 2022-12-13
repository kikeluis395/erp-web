<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesoCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceso_citas', function (Blueprint $table) {
            $table->unsignedInteger('id_acceso')->autoIncrement();
            $table->unsignedInteger('id_usuario')->nullable(false);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            $table->boolean('habilitado')->nullable(false);
            $table->dateTime('fecha_edicion')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acceso_citas');
    }
}
