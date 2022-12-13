<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReprogramacionValuacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reprogramacion_valuacion', function (Blueprint $table) {
            $table->increments('id_reprogramacion_valuacion');
            $table->string('razon_ampliacion',32)->nullable(false);
            $table->string('explicacion_ampliacion',256)->nullable(true);
            $table->double('valor_mano_obra_amp',12,3)->nullable(true);
            $table->double('valor_repuestos_amp',12,3)->nullable(true);
            $table->double('valor_terceros_amp',12,3)->nullable(true);
            $table->double('horas_mecanica_amp',12,3)->nullable(true);
            $table->double('horas_carroceria_amp',12,3)->nullable(true);
            $table->double('horas_panhos_amp',12,3)->nullable(true);
            $table->date('fecha_ampliacion')->useCurrent()->nullable(true);
            $table->date('fecha_aprobacion_seguro_amp')->nullable(true);
            $table->dateTime('fecha_registro_aprobacion_seguro_amp')->nullable(true);
            $table->date('fecha_aprobacion_cliente_amp')->nullable(true);
            $table->dateTime('fecha_registro_aprobacion_cliente_amp')->nullable(true);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_valuacion')->unsigned();
            $table->foreign('id_valuacion')->references('id_valuacion')->on('valuacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reprogramacion_valuacion');
    }
}
