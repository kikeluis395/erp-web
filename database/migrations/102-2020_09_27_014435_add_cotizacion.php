<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCotizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion', function (Blueprint $table) {
            $table->increments('id_cotizacion');
            $table->string('observacion',256)->nullable(true);
            $table->dateTime('fecha_hora_ingreso')->nullable(true);
            $table->dateTime('fecha_hora_entrega')->nullable(true);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->integer('id_recepcion_ot')->unsigned()->nullable(true);
            $table->integer('id_valuacion')->unsigned()->nullable(true);
            $table->boolean('es_habilitado')->default(1);
            $table->string('razon_cierre', 128)->nullable(true);
            $table->integer('id_cia_seguro')->unsigned()->nullable(true);
            
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
            $table->foreign('id_valuacion')->references('id_valuacion')->on('valuacion');
            $table->foreign('id_cia_seguro')->references('id_cia_seguro')->on('cia_seguro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion');
    }
}
