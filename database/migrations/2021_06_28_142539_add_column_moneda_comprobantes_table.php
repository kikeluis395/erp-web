<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMonedaComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->string('moneda')->nullable();
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->string('moneda')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->dropColumn('moneda');
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->dropColumn('moneda');
        });
    }
}
