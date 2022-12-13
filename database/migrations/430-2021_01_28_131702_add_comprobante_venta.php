<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComprobanteVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_venta', function (Blueprint $table) {
            $table->increments('id_comprobante_venta');
            $table->enum('tipo_comprobante', ['BOLETA','FACTURA']);
            $table->string('serie', 4);
            $table->string('nro_comprobante', 6);
            $table->string('nrodoc_cliente', 15);
            $table->string('nombre_cliente', 128);
            $table->string('direccion_cliente', 256);
            $table->date('fecha_emision');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->enum('formato_impresion', ['A4', 'TICKET']);
            $table->double('tasa_detraccion',4,2)->nullable();
            $table->integer('id_detraccion')->unsigned()->nullable();
            $table->double('total_descuento');
            $table->double('total_venta');
            $table->double('monto_sujeto_igv');
            $table->double('monto_inafecto');
            $table->double('monto_exonerado');
            $table->double('total_igv');
            $table->string('url_pdf', 256)->nullable();

            $table->foreign('id_detraccion')->references('id_detraccion')->on('detraccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobante_venta');
    }
}
