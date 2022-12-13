<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprobanteAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_anticipo', function (Blueprint $table) {
            $table->bigIncrements('id_comprobante_anticipo');            
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
            $table->integer('sale_id');
            $table->unsignedInteger('id_recepcion_ot')->nullable();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
            $table->unsignedInteger('id_cotizacion_meson')->nullable();
            $table->foreign('id_cotizacion_meson')->references('id_cotizacion_meson')->on('cotizacion_meson');
            $table->string('tipo_operacion', 50);
            $table->string('tipo_venta', 50);
            $table->text('observaciones');
            $table->integer('condicion_pago');
            $table->date('fecha_vencimiento');
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
        Schema::dropIfExists('comprobante_anticipo');
    }
}
