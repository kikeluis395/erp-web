<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCitaEntrega extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_entrega', function (Blueprint $table) {
            $table->increments('id_cita_entrega');
            $table->string('placa_vehiculo',6)->nullable(false);
            $table->string('doc_cliente',12)->nullable(true);
            $table->enum('tipo_servicio', ['SINIESTRO', 'PREVENTIVO', 'CORRECTIVO', "PUESTA A PUNTO"]);
            $table->string('contacto',128)->nullable(true);
            $table->string('telefono_contacto',15)->nullable(true);
            $table->string('email_contacto',64)->nullable(true);
            $table->string('dni_empleado',8)->nullable(false);
            $table->dateTime('fecha_cita');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->boolean('asistio')->nullable(false)->default(0);

            // $table->foreign('placa_vehiculo')->references('placa')->on('vehiculo');
            // $table->foreign('doc_cliente')->references('num_doc')->on('cliente');
            $table->foreign('dni_empleado')->references('dni')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cita_entrega');
    }
}
