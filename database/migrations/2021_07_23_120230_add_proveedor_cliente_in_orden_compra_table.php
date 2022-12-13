<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProveedorClienteInOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_compra', function (Blueprint $table) {
            $table->string('doc_cliente_proveedor',12)->nullable(true);
            $table->foreign('doc_cliente_proveedor')->references('num_doc')->on('cliente');
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
