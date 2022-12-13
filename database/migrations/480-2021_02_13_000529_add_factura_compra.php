<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturaCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_compra', function (Blueprint $table) {
            $table->increments('id_factura_compra');
            $table->string('periodo', 6)->nullable();
            $table->string('nro_factura', 16)->nullable();
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->integer('id_usuario_registro')->unsigned()->nullable();
            $table->integer('id_proveedor')->unsigned()->nullable();
            $table->enum('moneda', ['SOLES', 'DOLARES'])->nullable();
            $table->string('glosa', 128)->nullable();
            $table->string('forma_pago', 45)->nullable();
            $table->boolean('tiene_detraccion')->nullable();
            $table->integer('id_detraccion')->unsigned()->nullable();
            $table->double('valor_detraccion')->nullable();
            $table->string('regimen', 45)->nullable();
            $table->double('base_imponible')->nullable();
            $table->double('impuestos')->nullable();
            $table->double('monto_inafecto')->nullable();
            $table->double('total')->nullable();
            $table->integer('id_movimiento_bancario')->unsigned()->nullable();

            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor');
            $table->foreign('id_detraccion')->references('id_detraccion')->on('detraccion');
            $table->foreign('id_movimiento_bancario')->references('id_movimiento_bancario')->on('movimiento_bancario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura_compra');
    }
}
