<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->increments('id_proveedor');
            $table->string('num_doc',12);
            $table->string('nombre_proveedor',128);
            $table->string('giro',100)->nullable();
            // $table->string('email',100);
            $table->string('direccion',100);
            $table->enum('tipo_proveedor',["DISTRIBUIDOR", "MAYORISTA", "MINORISTA", "SERVICIOS DE GRUAS", "TRANSPORTISTA"])->nullable();
            $table->boolean('activo')->nullable();
            $table->boolean('domiciliado')->nullable();
            $table->string('cod_ubigeo',6)->nullable(false);
            $table->string('contacto',100)->nullable();
            $table->string('telf_contacto', 20)->nullable();
            $table->string('email_contacto',100)->nullable();
            
            $table->foreign('cod_ubigeo')->references('codigo')->on('ubigeo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedor');
    }
}
