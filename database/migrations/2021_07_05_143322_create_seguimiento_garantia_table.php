<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientoGarantiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimiento_garantia', function (Blueprint $table) {
            $table->unsignedInteger('id_seguimiento_garantia')->autoIncrement();
            $table->tinyInteger('estado');
            $table->date('fecha_carga')->nullable();
            $table->string('codigo_registro', 30)->nullable();
            $table->date('fecha_reproceso')->nullable();
            $table->string('motivo', 100)->nullable();
            $table->boolean('es_rechazada')->nullable();
            $table->string('motivo_rechazo', 100)->nullable();
            $table->unsignedInteger('id_recepcion_ot')->nullable();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
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
        Schema::dropIfExists('seguimiento_garantia');
    }
}
