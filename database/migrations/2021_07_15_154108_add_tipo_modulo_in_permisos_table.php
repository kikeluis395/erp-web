<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoModuloInPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permiso', function (Blueprint $table) {
            $table->enum("tipo", ['modulo', 'submodulo'])->nullable(false)->default('modulo');
            $table->unsignedInteger("modulo")->nullable();
            $table->foreign('modulo')->references('id_permiso')->on('permiso');
            $table->enum("categoria", ['ADMIN', 'REPORTE'])->nullable(false)->default('ADMIN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permiso', function (Blueprint $table) {
            //
        });
    }
}
