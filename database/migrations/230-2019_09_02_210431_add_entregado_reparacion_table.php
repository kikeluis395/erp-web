<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntregadoReparacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregado_reparacion', function (Blueprint $table) {
            $table->increments('id_entregado_reparacion');
            $table->date('fecha_entrega')->useCurrent()->nullable();
            $table->string('nro_factura', 32)->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_recepcion_ot')->unsigned();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entregado_reparacion');
    }
}
