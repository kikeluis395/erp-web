<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLineaOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linea_orden_compra', function (Blueprint $table) {
            $table->boolean('es_grupo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('linea_orden_compra', 'es_grupo')) {
            Schema::table('linea_orden_compra', function (Blueprint $table) {
                $table->dropColumn('es_grupo');
            });
        }
    }
}
