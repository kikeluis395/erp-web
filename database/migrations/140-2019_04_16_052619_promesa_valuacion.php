<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromesaValuacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promesa_valuacion', function (Blueprint $table) {
            $table->increments('id_promesa_valuacion');
            $table->integer('id_valuacion')->unsigned();
            $table->foreign('id_valuacion')->references('id_valuacion')->on('valuacion');
            $table->dateTime('fecha_promesa');
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
        Schema::dropIfExists('promesa_valuacion');
    }
}
