<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemNecesidadRepuestosDeletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_necesidad_repuestos_deleted', function (Blueprint $table) {
            $table->bigIncrements('id_item_necesidad_repuestos_deleted');
            $table->unsignedInteger('id_item_necesidad_repuestos')->nullable(false);
            $table->string('numero_parte', 48)->nullable(true);
            $table->unsignedInteger('id_repuesto')->nullable(true);
            $table->double('margen',10,2)->nullable(true);
            $table->string('descripcion_item_necesidad_repuestos',64)->nullable(true);
            $table->double('cantidad_solicitada')->nullable(false);
            $table->double('cantidad_aprobada')->nullable(true);
            $table->double('descuento_unitario',10,2)->nullable(true);
            $table->double('descuento_unitario_dealer',10,2)->nullable(true);
            $table->double('descuento_unitario_dealer_por_aprobar',10,2)->nullable(true);
            $table->tinyInteger('descuento_unitario_dealer_aprobado')->nullable(true);
            $table->double('cantidad_pre_ingreso',15,2)->nullable(true);
            $table->dateTime('fecha_pedido')->nullable(true);
            $table->dateTime('fecha_codificacion')->nullable(true);
            $table->dateTime('fecha_promesa')->nullable(true);
            $table->integer('es_importado')->nullable(true);
            $table->datetime('fecha_registro')->nullable(false);
            $table->integer('entregado')->nullable(true);
            $table->date('fecha_entrega')->nullable(false);
            $table->dateTime('fecha_registro_entrega')->nullable(true);
            $table->unsignedInteger('id_movimiento_salida_virtual')->nullable(true);
            $table->unsignedInteger('id_movimiento_salida')->nullable(true);
            $table->unsignedInteger('id_necesidad_repuestos')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_necesidad_repuestos_deleted');
    }
}
