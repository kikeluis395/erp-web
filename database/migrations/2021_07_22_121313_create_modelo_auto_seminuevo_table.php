<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeloAutoSeminuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_auto_seminuevo', function (Blueprint $table) {
            $table->bigIncrements('id_modelo_auto_seminuevo');
            $table->integer('id_marca_auto_seminuevo')->unsigned();
            //$table->index('id_marca_auto_seminuevo');
            //$table->foreign('id_marca_auto_seminuevo')->references('id_marca_auto_seminuevo')->on('marca_auto_seminuevo');
            $table->string('nombre');
            $table->softDeletes();
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
        Schema::dropIfExists('modelo_auto_seminuevo');
    }
}
