<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddElementoInspeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elemento_inspeccion', function (Blueprint $table) {
            $table->increments('id_elemento_inspeccion');
            $table->string('nombre_elemento_inspeccion',100);
            // $table->string('categoria',64);
            // $table->dateTime('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elemento_inspeccion');
    }
}
