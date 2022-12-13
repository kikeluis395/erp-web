<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostoAsociadoDypTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costos_asociados_dyp', function (Blueprint $table) {
            $table->unsignedInteger('id_costo_asociado_dyp')->autoIncrement();
            $table->enum('tipo_personal', ['PROPIO', 'TERCERO'])->nullable(false);
            $table->enum('metodo_costo_hh', ['MONEDA', 'PORCENTAJE'])->nullable();
            $table->enum('metodo_costo_panhos', ['MONEDA', 'PORCENTAJE'])->nullable();
            $table->enum('moneda_hh', ['SOLES', 'DOLARES'])->nullable();
            $table->enum('moneda_panhos', ['SOLES', 'DOLARES'])->nullable();
            $table->double('valor_costo_hh', 10, 2)->nullable();
            $table->double('valor_costo_panhos', 10, 2)->nullable();
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
        Schema::dropIfExists('costo_asociado_dyp');
    }
}
