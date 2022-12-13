<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsRucRsDirCiaSeguroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cia_seguro', function (Blueprint $table) {
            $table->string('ruc', 15)->nullable();
            $table->string('razon_social', 100)->nullable();
            $table->string('direccion', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cia_seguro', function (Blueprint $table) {
            $table->dropColumn('ruc', 15);
            $table->dropColumn('razon_social', 100);
            $table->dropColumn('direccion', 200);
        });
    }
}
