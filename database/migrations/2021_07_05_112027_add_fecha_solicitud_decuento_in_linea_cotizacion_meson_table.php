<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaSolicitudDecuentoInLineaCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            $table->dateTime('fecha_registro_aprobacion_rechazo_descuento');
        });
        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->dateTime('fecha_registro_aprobacion_rechazo_descuento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            $table->dropColumn('fecha_registro_aprobacion_rechazo_descuento');
        });

        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->dropColumn('fecha_registro_aprobacion_rechazo_descuento');
        });
    }
}
