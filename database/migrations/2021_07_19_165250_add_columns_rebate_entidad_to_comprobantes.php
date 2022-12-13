<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsRebateEntidadToComprobantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entregado_reparacion', function (Blueprint $table) {
            $table->boolean('activado')->default(1);
        });

        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->unsignedInteger('id_entidad_financiera')->after('id_pago_metodo')->nullable();
            $table->unsignedInteger('id_tipo_tarjeta')->after('id_entidad_financiera')->nullable();
            $table->boolean('es_rebate')->nullable();
            $table->boolean('activado')->default(1);
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->unsignedInteger('id_entidad_financiera')->after('id_pago_metodo')->nullable();
            $table->unsignedInteger('id_tipo_tarjeta')->after('id_entidad_financiera')->nullable();
            $table->boolean('activado')->default(1);
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
            $table->dropColumn('id_entidad_financiera');
            $table->dropColumn('id_tipo_tarjeta');
            $table->dropColumn('es_rebate');
            $table->dropColumn('activado');
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->dropColumn('id_entidad_financiera');
            $table->dropColumn('id_tipo_tarjeta');
            $table->dropColumn('activado');
        });

        Schema::table('entregado_reparacion', function (Blueprint $table) {
            $table->dropColumn('activado');
        });
    }
}
