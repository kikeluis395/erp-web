<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoVehiculoSeminuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_vehiculo_seminuevo', function (Blueprint $table) {
            $table->bigIncrements('id_movimiento_vehiculo_nuevo');
            $table->unsignedBigInteger('id_vehiculo_seminuevo')->nullable();  
            $table->foreign('id_vehiculo_seminuevo')->references('id_vehiculo_seminuevo')->on('vehiculo_seminuevo');
            $table->enum('tipo_movimiento', ['INGRESO','EGRESO', 'EGRESO VIRTUAL']);
            $table->double('cantidad_movimiento', 10, 5);
            $table->integer('id_local_empresa')->unsigned();
            $table->dateTime('fecha_movimiento');
            $table->string('motivo', 30)->nullable();
            $table->unsignedInteger('fuente_id')->nullable();
            $table->string('fuente_type', 100)->nullable();
            $table->double('costo', 20, 10)->nullable();
            $table->double('saldo', 15, 4)->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('movimiento_vehiculo_seminuevo');
    }
}
