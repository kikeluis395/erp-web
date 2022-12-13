<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeHojaInspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('linea_resultado_inspeccion');
        Schema::dropIfExists('linea_hoja_inspeccion');
        Schema::dropIfExists('hoja_inspeccion');

        Schema::create('hoja_inspeccion', function (Blueprint $table) {
            $table->bigIncrements('id_hoja_inspeccion');
            $table->timestamp('fecha_registro')->nullable();
            $table->integer('id_recepcion_ot')->nullable();
            $table->integer('id_usuario_savar')->unsigned();
            $table->integer('id_usuario_dealer')->nullable();
            $table->string('modelo', 200)->nullable();
            $table->string('color', 200)->nullable();
            $table->year('ano_modelo', 200);
            $table->string('vin', 200)->nullable();
            $table->string('destino', 200)->nullable();
            $table->bigInteger('estado_id')->unsigned();

            $table->foreign('id_usuario_savar')->references('id_usuario')->on('usuario');
            $table->foreign('estado_id')->references('id')->on('estado_hoja_inspeccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
