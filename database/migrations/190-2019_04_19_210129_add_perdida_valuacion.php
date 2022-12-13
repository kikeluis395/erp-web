<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerdidaValuacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perdida_valuacion', function (Blueprint $table) {
            $table->increments('id_perdida_valuacion');
            $table->integer('id_valuacion')->unsigned();
            $table->foreign('id_valuacion')->references('id_valuacion')->on('valuacion');
            $table->string('motivo_perdida',255)->nullable(true);
            $table->dateTime('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perdida_valuacion');
    }
}
