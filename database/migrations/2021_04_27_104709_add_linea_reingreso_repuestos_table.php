<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaReingresoRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_reingreso_repuestos', function (Blueprint $table) {
            $table->increments('id_linea_reingreso_repuestos');
            $table->integer('id_reingreso_repuestos')->unsigned();
            $table->integer('id_repuesto')->unsigned();
            $table->double('cantidad_reingreso', 12, 3);
            $table->dateTime('fecha_pedido')->nullable();
            $table->dateTime('fecha_promesa')->nullable();
            $table->integer('es_importado')->unsigned()->nullable();
            $table->dateTime('fecha_registro')->nullable();
            $table->dateTime('fecha_entrega')->useCurrent();
            $table->integer('id_movimiento_salida')->unsigned();
            $table->integer('id_necesidad_repuestos')->unsigned();

            $table->foreign('id_reingreso_repuestos')->references('id_reingreso_repuestos')->on('reingreso_repuestos');
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->foreign('id_movimiento_salida')->references('id_movimiento_repuesto')->on('movimiento_repuesto');
            $table->foreign('id_necesidad_repuestos')->references('id_necesidad_repuestos')->on('necesidad_repuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_reingreso_repuestos');
    }
}
