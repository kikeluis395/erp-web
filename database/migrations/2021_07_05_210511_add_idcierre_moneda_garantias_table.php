<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdcierreMonedaGarantiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garantias', function (Blueprint $table) {
            $table->string('id_cierre_marca')->nullable();
            $table->enum('moneda', ['SOLES','DOLARES'])->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garantias', function (Blueprint $table) {
            $table->dropColumn('id_cierre_marca');
            $table->dropColumn('moneda');            
        });
    }
}
