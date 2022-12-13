<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoNuevoRealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_nuevo_instancia', function (Blueprint $table) {

            $table->bigIncrements('id_vehiculo_nuevo_instancia');
            $table->unsignedBigInteger('id_modelo_comercial_vn')->nullable();  
            // (*EN REALIDAD ES MODELO COMERCIAL)
            $table->foreign('id_modelo_comercial_vn')->references('id_vehiculo_nuevo')->on('vehiculo_nuevo');
            $table->string('vin', 20)->nullable();
            $table->string('numero_motor', 20);
            $table->integer('anio')->nullable();
            $table->string('color', 30)->nullable();
            $table->unsignedBigInteger('id_estado_stock')->nullable();
            $table->foreign('id_estado_stock')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_ubicacion')->nullable();
            $table->foreign('id_ubicacion')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_estado_vehiculo')->nullable();
            $table->foreign('id_estado_vehiculo')->references('id')->on('parametros');
            $table->unsignedBigInteger('id_tipo_stock')->nullable();
            $table->foreign('id_tipo_stock')->references('id')->on('parametros');
            $table->boolean('habilitado')->nullable(false)->default(true);
            $table->unsignedInteger('creador')->nullable(false);
            $table->unsignedInteger('editor')->nullable();
            $table->unsignedInteger('id_local')->nullable(false);
            $table->foreign('creador')->references('id_usuario')->on('usuario');
            $table->foreign('editor')->references('id_usuario')->on('usuario');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');        
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo_nuevo_real');
    }
}
