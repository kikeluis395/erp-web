<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebates', function (Blueprint $table) {
            $table->bigIncrements('id_rebate');
            $table->unsignedInteger('id_local');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->string('dni');
            $table->foreign('dni')->references('dni')->on('empleado');
            $table->unsignedInteger('id_proveedor');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor');
            $table->string('factura');
            $table->string('descripcion');
            $table->string('fuente');
            $table->decimal('tipo_cambio', 15, 4);
            $table->decimal('venta_dolares', 15, 4);
            $table->decimal('venta_dscto_dolares', 15, 4);
            $table->decimal('margen_dolares', 15, 4);                     
            $table->date('fecha_venta');
            $table->dateTime('fecha_registro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rebates');
    }
}
