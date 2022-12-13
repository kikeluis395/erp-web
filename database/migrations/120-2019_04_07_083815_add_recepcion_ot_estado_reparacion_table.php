<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecepcionOtEstadoReparacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcion_ot_estado_reparacion', function (Blueprint $table) {
            $table->increments('id_recepcion_ot_estado_reparacion');
            $table->integer('id_recepcion_ot');
            $table->integer('id_estado_reparacion');
            $table->integer('es_estado_actual')->default(0);
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
        Schema::dropIfExists('recepcion_ot_estado_reparacion');
    }
}