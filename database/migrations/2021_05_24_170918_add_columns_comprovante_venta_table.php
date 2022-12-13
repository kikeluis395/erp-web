<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsComprovanteVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->integer('sale_id')->nullable();
            $table->unsignedInteger('id_recepcion_ot')->nullable();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
            $table->string('tipo_operacion', 50)->nullable();
            $table->string('tipo_venta', 50)->nullable();
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
            $table->dropColumn('sale_id');            
            $table->dropColumn('id_recepcion_ot');
            $table->dropColumn('tipo_operacion');
            $table->dropColumn('tipo_venta');
        });
    }
}
