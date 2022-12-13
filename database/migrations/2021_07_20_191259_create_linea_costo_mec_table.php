<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaCostoMecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_costo_mec', function (Blueprint $table) {
            $table->unsignedInteger('id_linea_costo_mec')->autoIncrement();
            $table->integer('anho')->nullable(false);
            $table->enum('mes', ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SET', 'OCT', 'NOV', 'DIC'])->nullable(false);
            $table->double('valor_costo', 10, 2)->nullable(false);
            $table->enum('moneda', ['SOLES', 'DOLARES'])->nullable(false);
            $table->boolean('habilitado')->nullable(false);
            
            $table->unsignedInteger('id_costo_asociado_mec');
            $table->foreign('id_costo_asociado_mec')->references('id_costo_asociado_mec')->on('costos_asociados_mec');
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
        Schema::dropIfExists('linea_costo_mec');
    }
}
