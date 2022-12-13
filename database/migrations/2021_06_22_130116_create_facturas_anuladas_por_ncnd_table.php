<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasAnuladasPorNcndTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_anuladas_por_ncnd', function (Blueprint $table) {
            $table->bigIncrements('id_facturas_anuladas_por_ncnd');
            $table->string('nro_factura',15);
            $table->date('fecha_entrega');
            $table->unsignedInteger('id_cotizacion_meson')->nullable();
            $table->foreign('id_cotizacion_meson')->references('id_cotizacion_meson')->on('cotizacion_meson')  ;
            $table->unsignedInteger('id_recepcion_ot')->nullable();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot') ;
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
        Schema::dropIfExists('facturas_anuladas_por_ncnd');
    }
}
