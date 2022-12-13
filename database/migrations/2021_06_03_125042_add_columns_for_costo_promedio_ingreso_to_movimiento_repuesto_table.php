<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForCostoPromedioIngresoToMovimientoRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_repuesto', function (Blueprint $table) {
           
            $table->double('costo_promedio_ingreso', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimiento_repuesto', function (Blueprint $table) {
            
            $table->dropColumn('costo_promedio_ingreso');
        });
    }
}
