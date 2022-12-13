<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSunatToComprobantesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->string('sunat_code')->nullable();
            $table->string('sunat_description')->nullable();
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->string('sunat_code')->nullable();
            $table->string('sunat_description')->nullable();
            $table->unsignedInteger('id_advance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante_venta', function (Blueprint $table) {
            $table->dropColumn('sunat_code');
            $table->dropColumn('sunat_description');
        });

        Schema::table('comprobante_anticipo', function (Blueprint $table) {
            $table->dropColumn('sunat_code');
            $table->dropColumn('sunat_description');
            $table->dropColumn('id_advance');
        });
    }
}
