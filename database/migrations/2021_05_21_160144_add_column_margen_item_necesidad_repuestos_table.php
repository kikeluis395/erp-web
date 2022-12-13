<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMargenItemNecesidadRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->double('margen', 10, 2)->nullable()->after('id_repuesto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('item_necesidad_repuestos', 'margen')) {
            Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
                $table->dropColumn('margen');
            });
        }
    }
}
