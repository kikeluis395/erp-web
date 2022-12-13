<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreciosIdInDetalleTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_trabajo', function (Blueprint $table) {
            $table->unsignedInteger('id_precio_mo_dyp')->nullable();
            $table->foreign('id_precio_mo_dyp')->references('id_precio_mo_dyp')->on('precio_mo_dyp');
            $table->unsignedInteger('id_precio_mo_mec')->nullable();
            $table->foreign('id_precio_mo_mec')->references('id_precio_mo_mec')->on('precio_mo_mec');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_trabajo', function (Blueprint $table) {
            //
        });
    }
}
