<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLineaCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
            $table->boolean('es_grupo')->nullable()->after('es_entregado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('linea_cotizacion_meson', 'es_grupo')) {
            Schema::table('linea_cotizacion_meson', function (Blueprint $table) {
                $table->dropColumn('es_grupo');
            });
        }
    }
}
