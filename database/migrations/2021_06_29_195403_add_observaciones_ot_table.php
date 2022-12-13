<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObservacionesOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recepcion_ot', function (Blueprint $table) {
            $table->string('observaciones_entrega', 200)->nullable();
            // $table->string('fecha_entrega_garantia', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recepcion_ot', function (Blueprint $table) {
            $table->dropColumn('observaciones_entrega');
        });
    }
}
