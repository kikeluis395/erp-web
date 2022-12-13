<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('parametros', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->string('codigo', 15);
         $table->string('valor1', 100);
         $table->string('valor2', 100);
         $table->string('valor3', 100)->nullable();
         $table->string('comentario', 255)->nullable();
         $table->boolean('estado');
         $table->integer('creado_por')->nullable();
         $table->integer('editado_por')->nullable();
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
      Schema::dropIfExists('parametros');
   }
}
