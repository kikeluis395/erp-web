<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrecioTotalAndTipoOperacionNcndTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
            $table->string('moneda',15);
            $table->double('tipo_cambio');
            $table->double('precio_total');
            $table->double('tipo_operacion');
            $table->unsignedInteger('id_comprobante_venta')->nullable();
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
            $table->unsignedInteger('id_comprobante_anticipo')->nullable();
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
        $table->dropColumn('moneda');
        $table->dropColumn('tipo_cambio');
        $table->dropColumn('tipo_operacion');
        $table->dropColumn('id_comprobante_venta');
        $table->dropColumn('id_comprobante_anticipo');

    }
}
