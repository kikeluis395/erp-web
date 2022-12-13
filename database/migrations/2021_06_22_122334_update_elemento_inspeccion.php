<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateElementoInspeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elemento_inspeccion', function (Blueprint $table) {
            $table->unsignedBigInteger('grupo_elemento_id');
            $table->foreign('grupo_elemento_id')->references('id')->on('grupo_elemento_inspeccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('elemento_inspeccion', 'grupo_elemento_id')) {
            Schema::table('elemento_inspeccion', function (Blueprint $table) {
                $table->dropColumn('grupo_elemento_id');
            });
        }
    }
}
