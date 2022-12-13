<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingDescuentoUnitarioItemNecesidadRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('item_necesidad_repuestos', 'descuento_unitario')) {
            Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
                $table->double('descuento_unitario', 10, 2)->nullable()->after('cantidad_aprobada');
            });
        }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('item_necesidad_repuestos', 'descuento_unitario')) {
            Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
                $table->dropColumn('descuento_unitario');
            });
        }
    }
}
