<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescuentoUnitarioPorAprobarToLineaCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            $table->double('descuento_unitario_dealer_por_aprobar', 5)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('linea_cotizacion_meson', 'descuento_unitario_dealer_por_aprobar')) {
            Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
                $table->dropColumn('descuento_unitario_dealer_por_aprobar');
            });
        }
    }
}
