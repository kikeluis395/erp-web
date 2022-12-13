<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInCriterioDanhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('criterio_danho', function (Blueprint $table) {
            $table->unsignedInteger('id_local')->nullable();            
            $table->unsignedInteger('id_editor')->nullable();            
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->foreign('id_editor')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('criterio_danho', function (Blueprint $table) {
            //
        });
    }
}
