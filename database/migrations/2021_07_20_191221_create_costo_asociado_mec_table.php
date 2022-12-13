<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostoAsociadoMecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costos_asociados_mec', function (Blueprint $table) {
            $table->unsignedInteger('id_costo_asociado_mec')->autoIncrement();
            $table->enum('tipo_personal', ['PROPIO', 'TERCERO'])->nullable(false);
            $table->enum('metodo_costo', ['MONEDA', 'PORCENTAJE'])->nullable();
            $table->enum('moneda', ['SOLES', 'DOLARES'])->nullable();
            $table->double('valor_costo', 10, 2)->nullable();
            $table->boolean('habilitado')->nullable(false);
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
        Schema::dropIfExists('costo_asociado_mec');
    }
}
