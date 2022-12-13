<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToComprobantesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entregado_reparacion', function (Blueprint $table) {
            $table->unsignedInteger('id_comprobante_venta')->nullable();
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
        });

        Schema::table('venta_meson', function (Blueprint $table) {
            $table->unsignedInteger('id_comprobante_venta')->nullable();
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->decimal('tipo_cambio')->nullable();
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->decimal('tipo_cambio')->nullable();
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
            $table->dropColumn('email');
            $table->dropColumn('telefono');
            $table->dropColumn('tipo_cambio');
        });
        
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('telefono');
            $table->dropColumn('tipo_cambio');
        });

        Schema::table('venta_meson', function (Blueprint $table) {
            $table->unsignedInteger('id_comprobante_venta')->nullable();
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
        });
        Schema::table('entregado_reparacion', function (Blueprint $table) {
            $table->unsignedInteger('id_comprobante_venta')->nullable();
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
        });
    }
}
