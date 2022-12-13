<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdCotizacionMeson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->unsignedInteger('id_cotizacion_meson')->after('id_recepcion_ot')->nullable();
            $table->foreign('id_cotizacion_meson')->references('id_cotizacion_meson')->on('cotizacion_meson')  ;
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
            
            $table->dropForeign('comprobante_venta_id_cotizacion_meson_foreign');
            $table->dropColumn('id_cotizacion_meson');
        });
    }
}
