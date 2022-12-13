<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToComprobanteAnticipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->unsignedInteger('id_comprobante_venta')->nullable();
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
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
            $table->dropColumn('id_comprobante_venta');
        });
    }
}
