<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoOtroProductoServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_otro_producto_servicio', function (Blueprint $table) {
            $table->bigIncrements('id_movimiento_otro_producto_servicio');
            $table->integer('id_otro_producto_servicio')->unsigned();
            $table->enum('tipo_movimiento', ['INGRESO','EGRESO', 'EGRESO VIRTUAL']);
            $table->double('cantidad_movimiento', 10, 5);
            $table->integer('id_local_empresa')->unsigned();
            $table->dateTime('fecha_movimiento');
            //$table->foreign('id_otro_producto_servicio','fk_otro_movi_otro_p_s')->references('id_otro_producto_servicio')->on('otro_producto_servicio');
            $table->foreign('id_local_empresa')->references('id_local')->on('local_empresa');
            $table->string('motivo', 30)->nullable();
            $table->unsignedInteger('fuente_id')->nullable();
            $table->string('fuente_type', 100)->nullable();
            $table->double('costo', 20, 10)->nullable();
            $table->double('saldo', 15, 4)->nullable();
            $table->double('costo_promedio_ingreso', 15, 4)->nullable();
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
        Schema::dropIfExists('movimiento_otros_productos_servicios');
    }
}
