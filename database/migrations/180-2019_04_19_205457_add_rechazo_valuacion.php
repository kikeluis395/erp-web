<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRechazoValuacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rechazo_valuacion', function (Blueprint $table) {
            $table->increments('id_rechazo_valuacion');
            $table->integer('id_valuacion')->unsigned();
            $table->foreign('id_valuacion')->references('id_valuacion')->on('valuacion');
            $table->string('motivo_rechazo',255)->nullable(true);
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
        Schema::dropIfExists('rechazo_valuacion');
    }
}
