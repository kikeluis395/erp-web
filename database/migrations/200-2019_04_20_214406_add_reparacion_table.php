<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReparacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reparacion', function (Blueprint $table) {
            $table->increments('id_reparacion');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->dateTime('fecha_modificacion')->useCurrent();
            $table->dateTime('fecha_inicio_operativo')->nullable();
            $table->date('fecha_fin_operativo')->nullable();
            $table->dateTime('fecha_registro_fin_operativo')->nullable();
            $table->integer('id_recepcion_ot')->unsigned();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');

            $table->integer('id_tecnico_carroceria')->unsigned()->nullable();
            $table->foreign('id_tecnico_carroceria')->references('id_tecnico')->on('tecnico_reparacion');

            $table->integer('id_tecnico_preparado')->unsigned()->nullable();
            $table->foreign('id_tecnico_preparado')->references('id_tecnico')->on('tecnico_reparacion');

            $table->integer('id_tecnico_pintura')->unsigned()->nullable();
            $table->foreign('id_tecnico_pintura')->references('id_tecnico')->on('tecnico_reparacion');

            $table->integer('id_tecnico_armado')->unsigned()->nullable();
            $table->foreign('id_tecnico_armado')->references('id_tecnico')->on('tecnico_reparacion');

            $table->integer('id_tecnico_pulido')->unsigned()->nullable();
            $table->foreign('id_tecnico_pulido')->references('id_tecnico')->on('tecnico_reparacion');

            $table->integer('id_tecnico_mecanica')->unsigned()->nullable();
            $table->foreign('id_tecnico_mecanica')->references('id_tecnico')->on('tecnico_reparacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparacion');
    }
}
