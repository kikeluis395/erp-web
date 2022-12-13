<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntregadoAInItemNecesidadRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->string('entregado_a',150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->dropColumn('entregado_a');
        });
    }
}
