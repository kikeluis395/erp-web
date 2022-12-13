<?php

// *******************************************************************
// ********************* GIANCARLO MONTALVAN *************************
// *******************************************************************

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposOrdenCompraTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('orden_compra', function (Blueprint $table) {
         // Relacion con la tabla local_empresa
         $table->unsignedInteger('id_local_empresa')->nullable()->after('id_proveedor');
         $table->foreign('id_local_empresa', 'fk_ordencompra_localempresa')->references('id_local')->on('local_empresa');

         // Relacion con la tabla parametros
         $table->unsignedBigInteger('id_almacen')->nullable()->after('id_proveedor');
         $table->foreign('id_almacen', 'fk_ordencompra_almacenes_parametros')->references('id')->on('parametros');

         $table->unsignedBigInteger('id_motivo')->nullable()->after('id_proveedor');
         $table->foreign('id_motivo', 'fk_ordencompra_motivo_parametros')->references('id')->on('parametros');

         $table->unsignedBigInteger('id_estado')->nullable()->after('id_proveedor');
         $table->foreign('id_estado', 'fk_ordencompra_estado_parametros')->references('id')->on('parametros');

         $table->string('detalle_motivo', 150)->nullable()->after('condicion_pago');
         $table->string('observaciones', 255)->nullable()->after('condicion_pago');
         $table->string('factura_proveedor', 30)->nullable()->after('condicion_pago');
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
      Schema::table('orden_compra', function (Blueprint $table) {
         //
      });
   }
}
