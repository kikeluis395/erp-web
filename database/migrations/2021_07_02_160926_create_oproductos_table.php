<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOproductosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('oproductos', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->string('codigo', 10);
         $table->string('descripcion', 50);
         $table->boolean('estado', 10);
         $table->integer('user_create')->nullable();
         $table->integer('user_update')->nullable();

         $table->unsignedBigInteger('id_parametros');
         $table->foreign('id_parametros', 'fk_oproductos_parametros')->references('id')->on('parametros');
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
      Schema::dropIfExists('oproductos');
   }
}
