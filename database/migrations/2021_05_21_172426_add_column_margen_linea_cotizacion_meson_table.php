<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMargenLineaCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            $table->double('margen', 10, 2)->nullable()->after('id_repuesto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('linea_cotizacion_meson', 'margen')) {
            Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
                $table->dropColumn('margen');
            });
        }
    }
}
