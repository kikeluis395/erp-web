<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemDsctMarcaLineaCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            
            $table->boolean('descuento_unitario_aprobado', 10, 2)->nullable();
            
            $table->double('descuento_marca', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('linea_cotizacion_meson', 'descuento_unitario_aprobado')) {
            Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
                $table->dropColumn('descuento_unitario_aprobado');
            });
        }
        if (Schema::hasColumn('linea_cotizacion_meson', 'descuento_marca')) {
            Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
                $table->dropColumn('descuento_marca');
            });
        }
    }
}
