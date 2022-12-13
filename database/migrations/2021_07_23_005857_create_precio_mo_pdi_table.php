<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioMoPdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_mo_pdi', function (Blueprint $table) {
            $table->unsignedInteger('id_precio_mo_pdi')->autoIncrement();
            $table->enum('tipo', ['MEC', 'CAR', 'PANHO', 'TYP'])->nullable(false);        
            $table->double('valor_costo', 10, 2)->nullable(false);
            $table->enum('moneda', ['SOLES', 'DOLARES'])->nullable(false);
            
            $table->unsignedInteger('creador')->nullable(false);        
            $table->unsignedInteger('editor')->nullable();
            $table->unsignedInteger('id_local')->nullable(false);
            $table->boolean('habilitado')->nullable(false);
            $table->dateTime('fecha_edicion')->nullable();           
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('creador')->references('id_usuario')->on('usuario');
            $table->foreign('editor')->references('id_usuario')->on('usuario');
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
        Schema::dropIfExists('precio_mo_pdi');
    }
}
