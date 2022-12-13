<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrecioRepuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_repuesto', function (Blueprint $table) {
            $table->increments('id_precio_repuesto');
            $table->integer('id_repuesto')->unsigned();
            $table->double('monto', 12,3);
            $table->enum('moneda',['SOLES','DOLARES']);
            $table->boolean('incluye_igv');
            $table->integer('id_local')->unsigned();
            $table->dateTime('fecha_inicio_aplicacion');
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precio_repuesto');
    }
}
