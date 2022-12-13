<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMovimientoBancario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_bancario', function (Blueprint $table) {
            $table->increments('id_movimiento_bancario');
            $table->enum('tipo_movimiento', ['INGRESO', 'EGRESO']);
            $table->string('comentario',64)->nullable();
            $table->double('monto_movimiento',12,2);
            $table->enum('moneda_movimiento', ['SOLES', 'DOLARES'])->nullable();
            $table->integer('id_cuenta_afectada')->unsigned();
            $table->integer('id_cuenta_externa')->unsigned()->nullable();
            $table->date('fecha_movimiento');
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
        Schema::dropIfExists('movimiento_bancario');
    }
}
