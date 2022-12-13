<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescuento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuento', function (Blueprint $table) {
            $table->bigIncrements('id_descuento');
            $table->double('porcentaje_aplicado_mo')->nullable();
            $table->double('porcentaje_aplicado_lubricantes')->nullable();
            $table->double('porcentaje_aplicado_rptos')->nullable();
            $table->double('monto_aplicado_mo')->nullable();
            $table->double('monto_aplicado_lubricantes')->nullable();
            $table->double('monto_aplicado_rptos')->nullable();
            $table->boolean('es_aprobado')->nullable();
            $table->integer('id_hoja_trabajo')->unsigned();
            $table->foreign('id_hoja_trabajo')->references('id_hoja_trabajo')->on('hoja_trabajo');
            $table->string('dni_aprobador', 15)->nullable();
            $table->foreign('dni_aprobador')->references('dni')->on('empleado');
            $table->string('dni_solicitante', 15);
            $table->foreign('dni_solicitante')->references('dni')->on('empleado');
            $table->dateTime('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descuento');
    }
}
