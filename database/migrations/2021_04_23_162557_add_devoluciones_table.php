<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDevolucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->increments('id_devoluciones');            
            $table->double('cantidad_devolucion');
            $table->integer('id_movimiento_repuesto')->unsigned();
            $table->integer('id_repuesto')->unsigned();
            $table->integer('id_proveedor')->unsigned();
            $table->foreign('id_movimiento_repuesto')->references('id_movimiento_repuesto')->on('movimiento_repuesto');
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor');
            $table->dateTime('fecha_devolucion');
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
        //
    }
}
