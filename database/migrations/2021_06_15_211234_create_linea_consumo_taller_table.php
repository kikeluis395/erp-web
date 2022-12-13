<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaConsumoTallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_consumo_taller', function (Blueprint $table) {
            $table->bigIncrements('id_linea_consumo_taller');
            $table->unsignedInteger('id_consumo_taller')->nullable(false);
            $table->unsignedInteger('id_repuesto')->nullable(false);
            $table->double('cantidad', 12, 3)->nullable(false);
            $table->unsignedInteger('id_movimiento_virtual')->nullable(false);
            $table->unsignedInteger('id_movimiento_salida')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_consumo_taller');
    }
}
