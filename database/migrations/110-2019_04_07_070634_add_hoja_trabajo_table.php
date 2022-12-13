<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHojaTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoja_trabajo', function (Blueprint $table) {
            $table->increments('id_hoja_trabajo');
            $table->string('placa_auto',6)->nullable(false);
            $table->string('doc_cliente',12)->nullable(false);
            $table->string('dni_empleado',15);
            $table->string('observaciones',256)->nullable(true);
            $table->enum('tipo_trabajo',['PREVENTIVO','CORRECTIVO','DYP'])->nullable(false);
            $table->string('contacto', 128)->nullable(true);
            $table->string('telefono_contacto', 15)->nullable(true);
            $table->string('email_contacto', 64)->nullable(true);
            $table->dateTime('fecha_recepcion')->useCurrent();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->dateTime('fecha_modificacion')->useCurrent();
            $table->integer('id_recepcion_ot')->unsigned()->nullable(true);
            $table->integer('id_cotizacion')->unsigned()->nullable(true);

            $table->foreign('dni_empleado')->references('dni')->on('empleado');
            $table->foreign('doc_cliente')->references('num_doc')->on('cliente');
            $table->foreign('placa_auto')->references('placa')->on('vehiculo');
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
            $table->foreign('id_cotizacion')->references('id_cotizacion')->on('cotizacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoja_trabajo');
    }
}
