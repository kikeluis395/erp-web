<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForCostoToMovimientoRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_repuesto', function (Blueprint $table) {
            $table->unsignedInteger('fuente_id')->nullable();
            $table->string('fuente_type', 100)->nullable();
            $table->double('costo', 20, 10)->nullable();
            $table->double('saldo', 15, 4)->nullable();
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
            $table->dropColumn('fuente_id');
            $table->dropColumn('fuente_type');
            $table->dropColumn('costo');
            $table->dropColumn('saldo');
        });
    }
}
