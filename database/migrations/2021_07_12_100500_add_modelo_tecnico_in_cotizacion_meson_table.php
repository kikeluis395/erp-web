<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeloTecnicoInCotizacionMesonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion_meson', function (Blueprint $table) {
            $table->unsignedInteger('id_modelo_tecnico')->nullable();
            $table->foreign('id_modelo_tecnico')->references('id_modelo_tecnico')->on('modelo_tecnico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacion_meson', function (Blueprint $table) {
            $table->dropColumn('id_modelo_tecnico');
            
        });
     
    }
}
