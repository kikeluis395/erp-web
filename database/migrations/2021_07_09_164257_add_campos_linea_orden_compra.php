<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposLineaOrdenCompra extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('linea_orden_compra', function (Blueprint $table) {

         $table->unsignedBigInteger('id_vehiculo_nuevo')->nullable();
         $table->foreign('id_vehiculo_nuevo')->references('id_vehiculo_nuevo')->on('vehiculo_nuevo');

         $table->double('descuento')->nullable();
         $table->double('sub_total')->nullable();
         $table->double('impuesto')->nullable();
         $table->double('total')->nullable();

         $table->string('vin', 20)->nullable();
         $table->string('numero_motor', 20);
         $table->integer('anio')->nullable();
         $table->string('color', 30)->nullable();

         $table->softDeletes();
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
      Schema::table('linea_orden_compra', function (Blueprint $table) {
         //
      });
   }
}
