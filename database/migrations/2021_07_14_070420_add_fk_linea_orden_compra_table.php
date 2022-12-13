<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkLineaOrdenCompraTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('linea_orden_compra', function (Blueprint $table) {
         $table->unsignedBigInteger('id_otro_producto_servicio')->nullable();
         $table->foreign('id_otro_producto_servicio')->references('id_otro_producto_servicio')->on('otro_producto_servicio');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('linea_orden_compra', function (Blueprint $table) {
         //
      });
   }
}
