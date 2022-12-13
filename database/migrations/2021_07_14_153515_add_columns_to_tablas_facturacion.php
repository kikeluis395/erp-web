<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTablasFacturacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entregado_reparacion', function (Blueprint $table) {
            $table->boolean('es_seguro')->nullable();
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->string('url_entrega')->nullable();
            $table->string('url_constancia')->nullable();
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->string('url_entrega')->nullable();
            $table->string('url_constancia')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entregado_reparacion', function (Blueprint $table) {
            $table->dropColumn('es_seguro');
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->dropColumn('url_entrega');
            $table->dropColumn('url_constancia');
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->dropColumn('url_entrega');
            $table->dropColumn('url_constancia');
        });
    }
}
