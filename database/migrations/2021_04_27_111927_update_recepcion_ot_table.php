<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRecepcionOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recepcion_ot', function (Blueprint $table) {
            $table->integer('id_reingreso_repuestos')->nullable()->unsigned();
            $table->foreign('id_reingreso_repuestos')->references('id_reingreso_repuestos')->on('reingreso_repuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('recepcion_ot', 'id_reingreso_repuestos')) {
            Schema::table('recepcion_ot', function (Blueprint $table) {
                $table->dropColumn('id_reingreso_repuestos');
            });
        }
    }
}
