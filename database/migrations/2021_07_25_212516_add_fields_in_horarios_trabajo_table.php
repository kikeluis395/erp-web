<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInHorariosTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horarios_trabajo', function (Blueprint $table) {
            $table->unsignedInteger('creador')->nullable();
            $table->unsignedInteger('editor')->nullable();
            $table->unsignedInteger('id_local')->nullable();
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
        Schema::table('horarios_trabajo', function (Blueprint $table) {
            //
        });
    }
}
