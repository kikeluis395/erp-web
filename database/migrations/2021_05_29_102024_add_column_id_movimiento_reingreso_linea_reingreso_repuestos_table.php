<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdMovimientoReingresoLineaReingresoRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_reingreso_repuestos', function (Blueprint $table) {
            $table->integer('id_movimiento_reingreso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linea_reingreso_repuestos', function (Blueprint $table) {
            $table->dropColumn('id_movimiento_reingreso');
        });
    }
}
