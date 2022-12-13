<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetalleTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_trabajo', function (Blueprint $table) {
            $table->bigIncrements('id_detalle_trabajo');
            $table->integer('id_operacion_trabajo')->unsigned();
            $table->string('detalle_trabajo_libre', 128)->nullable();
            $table->double('valor_trabajo_estimado');
            $table->integer('id_hoja_trabajo')->unsigned();

            $table->foreign('id_operacion_trabajo')->references('id_operacion_trabajo')->on('operacion_trabajo');
            $table->foreign('id_hoja_trabajo')->references('id_hoja_trabajo')->on('hoja_trabajo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_trabajo');
    }
}
