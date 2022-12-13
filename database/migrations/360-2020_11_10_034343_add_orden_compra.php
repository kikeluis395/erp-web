<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrdenCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->increments('id_orden_compra');
            $table->enum('tipo',["REPUESTOS","SERVICIOS TERCEROS"])->default('REPUESTOS');
            $table->integer("id_proveedor")->unsigned();
            $table->enum('tipo_moneda', ["SOLES","DOLARES"]);
            $table->enum('condicion_pago', ["CONTADO","CREDITO-15D","CREDITO-30D","CREDITO-45D","CREDITO-60D"]);
            $table->date("fecha_registro")->useCurrent();
            $table->integer('id_usuario_registro')->unsigned();
            $table->boolean('es_aprobado')->default(0);
            $table->dateTime('fecha_aprobacion')->nullable();
            $table->integer('id_usuario_aprobador')->unsigned()->nullable();
            $table->boolean('es_finalizado')->default(0);
            $table->dateTime('fecha_finalizado')->nullable();

            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor');
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->foreign('id_usuario_aprobador')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra');
    }
}
