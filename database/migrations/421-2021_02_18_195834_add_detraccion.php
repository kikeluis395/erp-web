<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetraccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detraccion', function (Blueprint $table) {
            $table->increments('id_detraccion');
            $table->string('codigo_sunat',5);
            $table->string('descripcion',64);
            $table->double('porcentaje_detraccion',4,2);
            $table->boolean('habilitado');
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
        Schema::dropIfExists('detraccion');
    }
}
