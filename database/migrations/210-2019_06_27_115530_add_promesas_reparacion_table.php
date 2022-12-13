<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromesasReparacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promesas_reparacion', function (Blueprint $table) {
            $table->increments('id_promesa');
            $table->integer('id_reparacion')->unsigned();
            $table->foreign('id_reparacion')->references('id_reparacion')->on('reparacion');
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
        Schema::dropIfExists('promesas_reparacion');
    }
}
