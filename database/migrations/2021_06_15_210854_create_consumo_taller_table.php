<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumoTallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumo_taller', function (Blueprint $table) {
            $table->bigIncrements('id_consumo_taller');
            $table->string('usuario_solicitante', 48)->nullable(false);
            $table->dateTime('fecha_entrega')->nullable(true);
            $table->datetime('fecha_registro')->useCurrent();
            $table->unsignedInteger('id_usuario')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumo_taller');
    }
}
