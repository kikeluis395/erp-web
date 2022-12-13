<?php

// *******************************************************************
// ********************* GIANCARLO MONTALVAN *************************
// *******************************************************************

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposLocalEmpresaTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('local_empresa', function (Blueprint $table) {
         $table->string('nombre_empresa', 50)->nullable()->after('id_local');
         $table->datetime('fechaEdicion')->useCurrent()->after('fechaRegistro');
         $table->softDeletes();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('local_empresa', function (Blueprint $table) {
         //
      });
   }
}
