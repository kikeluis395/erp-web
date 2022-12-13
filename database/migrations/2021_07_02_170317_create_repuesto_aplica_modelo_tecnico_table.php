<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepuestoAplicaModeloTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repuesto_aplica_modelo_tecnico', function (Blueprint $table) {
            $table->bigIncrements('id_repuesto_aplica_modelo_tecnico');
            $table->integer('id_repuesto')->unsigned();
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->integer('id_modelo_tecnico')->unsigned();
            $table->foreign('id_modelo_tecnico')->references('id_modelo_tecnico')->on('modelo_tecnico');
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
        Schema::dropIfExists('repuesto_aplica_modelo_tecnico');
    }
}
