<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdMarcaAutoInCitaEntregaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cita_entrega', function (Blueprint $table) {
            $table->unsignedInteger('id_marca_auto')->nullable();
            $table->foreign('id_marca_auto')->references('id_marca_auto')->on('marca_auto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cita_entrega', function (Blueprint $table) {
            $table->dropColumn('id_marca_auto');
        });
    }
}
