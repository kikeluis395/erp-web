<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoOrdenCompraTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('orden_compra', function (Blueprint $table) {
         $table->string('codigo_orden_compra')->nulla()->after('id_orden_compra');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('orden_compra', function (Blueprint $table) {
         //
      });
   }
}
