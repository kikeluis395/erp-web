<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumeroPedidoInItemNecesidadRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->string('num_pedido',50)->nullable();
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
            $table->dropColumn('num_pedido');
        });
    }
}
