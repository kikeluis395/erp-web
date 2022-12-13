<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repuesto', function (Blueprint $table) {
            $table->unsignedInteger('id_unidad_grupo')->nullable();
            $table->integer('cantidad_unidades_grupo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('repuesto', 'id_unidad_grupo')) {
            Schema::table('repuesto', function (Blueprint $table) {
                $table->dropColumn('id_unidad_grupo');
            });
        }

        if (Schema::hasColumn('repuesto', 'id_unidad_grupo')) {
            Schema::table('repuesto', function (Blueprint $table) {
                $table->dropColumn('cantidad_unidades_grupo');
            });
        }
    }
}
