<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCitaEntregaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cita_entrega', function (Blueprint $table) {
            $table->integer('id_usuario')->default(20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('cita_entrega', 'id_usuario')) {
            Schema::table('cita_entrega', function (Blueprint $table) {
                $table->dropColumn('id_usuario');
            });
        }
    }
}
