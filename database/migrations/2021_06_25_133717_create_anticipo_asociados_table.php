<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticipoAsociadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipo_asociados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_comprobante_venta')->nullable();
            $table->integer('id_comprobante_anticipo')->nullable();
            $table->date('fecha_asociada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anticipo_asociados');
    }
}
