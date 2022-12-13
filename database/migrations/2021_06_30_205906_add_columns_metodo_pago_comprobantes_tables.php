<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsMetodoPagoComprobantesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pago_metodo')->nullable();
            $table->foreign('id_pago_metodo')->references('id_pago_metodo')->on('pago_metodos');
            $table->boolean('es_seguro')->nullable();
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pago_metodo')->nullable();
            $table->foreign('id_pago_metodo')->references('id_pago_metodo')->on('pago_metodos');            
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
            $table->dropColumn('id_pago_metodo');                      
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->dropColumn('id_pago_metodo');            
            $table->dropColumn('es_seguro');
        });
    }
}
