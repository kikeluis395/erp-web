<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('num_doc',12);
            $table->enum('tipo_cliente',['NATURAL','EMPRESA']);
            $table->enum('tipo_doc',['RUC','DNI','CE']);
            $table->string('nombres',100);
            $table->string('apellido_pat',12)->nullable();
            $table->string('apellido_mat',12)->nullable();
            $table->enum('sexo',['F','M'])->nullable();
            $table->enum('estado_civil',['S','C','V','D'])->nullable();
            $table->string('direccion',256);
            $table->string('celular',15);
            $table->string('email',64)->nullable(true);
            $table->string('cod_ubigeo',6)->nullable(false);
            $table->foreign('cod_ubigeo')->references('codigo')->on('ubigeo');

            $table->primary('num_doc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
