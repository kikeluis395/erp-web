<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdLocalNotaCreditoDebitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
           
            $table->unsignedInteger('id_local');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->double('precio_total');
            $table->string('moneda',15)->nullable(true);
            $table->double('tipo_cambio')->nullable(true);
            $table->string('tipo_operacion',50)->nullable(true);
            $table->unsignedInteger('id_comprobante_venta')->nullable(true);
            $table->foreign('id_comprobante_venta')->references('id_comprobante_venta')->on('comprobante_venta');
            $table->unsignedInteger('id_comprobante_anticipo')->nullable(true);
            //$table->foreign('id_comprobante_anticipo')->references('id_comprobante_anticipo')->on('comprobante_anticipo');
      

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
            $table->dropColumn('id_local');
        });
        
    }
}
