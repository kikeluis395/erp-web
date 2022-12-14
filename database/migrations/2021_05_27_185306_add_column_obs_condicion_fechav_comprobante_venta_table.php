<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnObsCondicionFechavComprobanteVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
           $table->text('observaciones')->nullable();
           $table->integer('condicion_pago')->nullable();
           $table->date('fecha_vencimiento')->nullable(); 
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
            $table->dropColumn('observaciones');
            $table->dropColumn('condicion_pago');
            $table->dropColumn('fecha_vencimiento'); 
         });
    }
}
