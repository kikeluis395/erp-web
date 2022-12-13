<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtCerrada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_cerrada', function (Blueprint $table) {
            $table->increments('id_ot_cerrada');
            $table->integer('id_recepcion_ot')->unsigned();
            $table->string('razon_cierre', 64)->nullable();
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ot_cerrada');
    }
}
