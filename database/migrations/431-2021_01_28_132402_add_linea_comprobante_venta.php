<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineaComprobanteVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_comprobante_venta', function (Blueprint $table) {
            $table->increments('id_linea_comprobante_venta');
            $table->integer('id_comprobante_venta')->unsigned();
            $table->double('cantidad');
            $table->string('unidad_medida',6);
            $table->string('codigo_producto',20);
            $table->string('descripcion',128);
            $table->enum('tipo_igv', ['GRAVADO', 'INAFECTO', 'EXONERADO']);
            $table->double('valor_unitario');
            $table->double('valor_venta');
            $table->double('igv');
            $table->double('precio_venta');

            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_comprobante_venta');
    }
}
