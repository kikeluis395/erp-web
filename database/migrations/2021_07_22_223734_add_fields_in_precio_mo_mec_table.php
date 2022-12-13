<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInPrecioMoMecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('precio_mo_mec', function (Blueprint $table) {
            $table->unsignedInteger('creador')->nullable();
            $table->unsignedInteger('editor')->nullable();
            $table->dateTime('fecha_edicion')->nullable();
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
        Schema::table('precio_mo_mec', function (Blueprint $table) {
            //
        });
    }
}
