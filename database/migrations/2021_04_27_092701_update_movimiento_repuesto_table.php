<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMovimientoRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_repuesto', function (Blueprint $table) {
            $table->string('motivo', 30)->nullable()->after('tipo_movimiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('movimiento_repuesto', 'motivo')) {
            Schema::table('movimiento_repuesto', function (Blueprint $table) {
                $table->dropColumn('motivo');
            });
        }
    }
}
