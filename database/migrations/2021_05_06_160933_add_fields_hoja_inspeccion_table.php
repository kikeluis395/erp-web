<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsHojaInspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hoja_inspeccion', function (Blueprint $table) {
            $table->integer('id_usuario_savar')->nullable()->unsigned();
            $table->integer('id_usuario_dealer')->nullable()->unsigned();
            $table->foreign('id_usuario_savar')->references('id_usuario')->on('usuario');
            $table->foreign('id_usuario_dealer')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
