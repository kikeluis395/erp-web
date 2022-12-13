<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNroOperacionComprobantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->string('nro_operacion')->after('id_pago_metodo')->nullable();
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->string('nro_operacion')->after('id_pago_metodo')->nullable();
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
            $table->dropColumn('nro_operacion');
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->dropColumn('nro_operacion');
        });
    }
}
