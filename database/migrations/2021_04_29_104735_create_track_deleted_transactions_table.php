<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackDeletedTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_deleted_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('origen');
            $table->integer('id_origen');
            $table->integer('id_contenedor_origen');
            $table->string('description');
            $table->text('data');
            $table->integer('id_usuario_eliminador')->unsigned()->nullable(true);
            $table->foreign('id_usuario_eliminador')->references('id_usuario')->on('usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_deleted_transactions');
    }
}
