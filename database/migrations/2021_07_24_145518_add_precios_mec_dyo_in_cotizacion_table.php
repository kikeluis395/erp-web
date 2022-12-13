<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreciosMecDyoInCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion', function (Blueprint $table) {
            $table->unsignedInteger('precio_mec')->nullable();
            $table->json('precio_dyp')->nullable();

            $table->foreign('precio_mec')->references('id_precio_mo_mec')->on('precio_mo_mec');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacion', function (Blueprint $table) {
            //
        });
    }
}
