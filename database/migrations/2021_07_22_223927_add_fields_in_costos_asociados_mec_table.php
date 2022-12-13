<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInCostosAsociadosMecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costos_asociados_mec', function (Blueprint $table) {
            $table->unsignedInteger('id_local')->nullable();
            $table->unsignedInteger('creador')->nullable();
            $table->unsignedInteger('editor')->nullable();
            $table->dateTime('fecha_edicion')->nullable();
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->foreign('creador')->references('id_usuario')->on('usuario');
            $table->foreign('editor')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costos_asociados_mec', function (Blueprint $table) {
            //
        });
    }
}
