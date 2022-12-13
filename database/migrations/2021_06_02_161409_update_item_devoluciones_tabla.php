<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemDevolucionesTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_devoluciones', function (Blueprint $table) {
            if (!Schema::hasColumn('item_devoluciones', 'costo_unitario')) {
                $table->double('costo_unitario');
            }
            
            $table->double('descuento_unitario');
            if (!Schema::hasColumn('item_devoluciones', 'id_movimiento_repuesto_virtual')) {
                $table->unsignedInteger('id_movimiento_repuesto_virtual');
            }
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('item_devoluciones', 'costo_unitario')) {
            Schema::table('item_devoluciones', function (Blueprint $table) {
                $table->dropColumn('costo_unitario');
            });
        }
        if (Schema::hasColumn('item_devoluciones', 'id_movimiento_repuesto_virtual')) {
            Schema::table('item_devoluciones', function (Blueprint $table) {
                $table->dropColumn('id_movimiento_repuesto_virtual');
            });
        }
        if (Schema::hasColumn('item_devoluciones', 'descuento_unitario')) {
            Schema::table('item_devoluciones', function (Blueprint $table) {
                $table->dropColumn('descuento_unitario');
            });
        }
    }
}
