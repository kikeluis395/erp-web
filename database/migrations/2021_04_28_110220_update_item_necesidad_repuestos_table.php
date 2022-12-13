<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemNecesidadRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
            $table->double('cantidad_pre_reingreso', 15, 3)->nullable()->after('cantidad_aprobada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('item_necesidad_repuestos', 'cantidad_pre_reingreso')) {
            Schema::table('item_necesidad_repuestos', function (Blueprint $table) {
                $table->dropColumn('cantidad_pre_reingreso');
            });
        }
    }
}
