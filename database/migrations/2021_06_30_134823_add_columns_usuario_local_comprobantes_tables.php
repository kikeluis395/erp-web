<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsuarioLocalComprobantesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->unsignedInteger('id_usuario_registro')->nullable();
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->string('estado')->nullable();
            $table->unsignedInteger('id_local')->nullable();
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->unsignedInteger('id_usuario_registro')->nullable();
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->string('estado')->nullable();
            $table->unsignedInteger('id_local')->nullable();
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->dropColumn('id_usuario_registro');            
            $table->dropColumn('estado');
            $table->dropColumn('id_local');            
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->dropColumn('id_usuario_registro');            
            $table->dropColumn('estado');
            $table->dropColumn('id_local');            
        });
        
    }
}
