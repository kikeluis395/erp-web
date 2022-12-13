<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturaRecepcionOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recepcion_ot', function (Blueprint $table) {
            $table->boolean('es_factura')->default(true);
            $table->string('factura_para', 64)->nullable(true);
            $table->string('num_doc', 15)->nullable(false);
            $table->string('direccion',64)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('recepcion_ot', 'es_factura')) {
            Schema::table('recepcion_ot', function (Blueprint $table) {
                $table->dropColumn('es_factura');
            });
        }
        if (Schema::hasColumn('recepcion_ot', 'factura_para')) {
            Schema::table('recepcion_ot', function (Blueprint $table) {
                $table->dropColumn('factura_para');
            });
        }
        if (Schema::hasColumn('recepcion_ot', 'num_doc')) {
            Schema::table('recepcion_ot', function (Blueprint $table) {
                $table->dropColumn('num_doc');
            });
        }
        if (Schema::hasColumn('recepcion_ot', 'direccion')) {
            Schema::table('recepcion_ot', function (Blueprint $table) {
                $table->dropColumn('direccion');
            });
        }
    }
}
