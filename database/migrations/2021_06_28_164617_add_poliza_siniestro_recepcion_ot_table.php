<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPolizaSiniestroRecepcionOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recepcion_ot', function (Blueprint $table) {
            $table->string('nro_poliza', 10)->nullable();
            $table->string('nro_siniestro', 10)->nullable();
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
            $table->dropColumn('nro_poliza');
            $table->dropColumn('nro_siniestro');
        });
    }
}
