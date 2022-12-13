<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstadoToServicioTercero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicio_tercero', function (Blueprint $table) {
            $table->unsignedBigInteger('estado')->nullable();
            $table->foreign('estado')->references('id')->on('parametros');
            $table->dateTime('f_creacion')->nullable();
            $table->dateTime('f_edicion')->nullable();
            $table->integer('creado_por')->unsigned()->nullable();
            $table->foreign('creado_por')->references('id_usuario')->on('usuario');
            $table->integer('editado_por')->unsigned()->nullable();
            $table->foreign('editado_por')->references('id_usuario')->on('usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicio_tercero', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('f_creacion');
            $table->dropColumn('f_edicion');
            $table->dropForeign('creado_por_foreign');
            $table->dropForeign('editado_por_foreign');
            $table->dropColumn('creado_por');
            $table->dropColumn('editado_por');


        });
    }
}
