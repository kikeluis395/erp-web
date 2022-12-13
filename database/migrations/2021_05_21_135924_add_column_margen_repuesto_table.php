<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMargenRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuesto', function (Blueprint $table) {
            $table->double('margen', 10, 2)->nullable()->after('pvp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('repuesto', 'margen')) {
            Schema::table('repuesto', function (Blueprint $table) {
                $table->dropColumn('margen');
            });
        }
    }
}
