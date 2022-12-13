<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMovimientoRepuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_repuesto', function (Blueprint $table) {
            $table->increments('id_movimiento_repuesto');
            $table->integer('id_repuesto')->unsigned();
            $table->enum('tipo_movimiento', ['INGRESO','EGRESO', 'EGRESO VIRTUAL']);
            $table->double('cantidad_movimiento', 10, 5);
            $table->integer('id_local_empresa')->unsigned();
            $table->dateTime('fecha_movimiento');
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->foreign('id_local_empresa')->references('id_local')->on('local_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento_repuesto');
    }
}