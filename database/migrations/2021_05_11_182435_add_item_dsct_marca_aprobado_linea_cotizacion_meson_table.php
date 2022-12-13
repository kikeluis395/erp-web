<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemDsctMarcaAprobadoLineaCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            
            $table->boolean('descuento_marca_aprobado')->nullable()->after('descuento_marca');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('linea_cotizacion_meson', 'descuento_marca_aprobado')) {
            Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
                $table->dropColumn('descuento_marca_aprobado');
            });
        }
       
    }
}
