<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCuentaBancaria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_bancaria', function (Blueprint $table) {
            $table->increments('id_cuenta_bancaria');
            $table->string('nro_cuenta', 32);
            $table->string('tipo_cuenta', 64)->nullable();
            $table->enum('moneda', ['SOLES', 'DOLARES']);
            $table->integer('id_banco')->unsigned();

            $table->foreign('id_banco')->references('id_banco')->on('banco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuenta_bancaria');
    }
}
