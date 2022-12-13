<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemNecesidadRepuestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_necesidad_repuestos', function (Blueprint $table) {
            $table->increments('id_item_necesidad_repuestos');
            $table->string('numero_parte',48)->nullable();
            $table->integer('id_repuesto')->unsigned()->nullable();
            $table->string('descripcion_item_necesidad_repuestos',64)->nullable();
            $table->double('cantidad_solicitada');
            $table->double('cantidad_aprobada')->nullable();
            // $table->double('precio_unitario',12,3)->default(0);
            $table->dateTime('fecha_pedido')->nullable();
            $table->dateTime('fecha_promesa')->nullable();
            $table->integer('es_importado')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            // $table->integer('id_estado_repuesto')->unsigned();
            // $table->foreign('id_estado_repuesto')->references('id_estado_repuesto')->on('estado_repuesto');
            $table->integer('entregado')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->dateTime('fecha_registro_entrega')->nullable();
            $table->integer('id_necesidad_repuestos')->unsigned();
            
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->foreign('id_necesidad_repuestos')->references('id_necesidad_repuestos')->on('necesidad_repuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_necesidad_repuestos');
    }
}
