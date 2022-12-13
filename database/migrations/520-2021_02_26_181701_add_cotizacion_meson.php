<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCotizacionMeson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_meson', function (Blueprint $table) {
            $table->increments('id_cotizacion_meson');
            $table->string('doc_cliente',12)->nullable();
            $table->string('nombre_cliente',128)->nullable(); // quizas temporal
            $table->string('observaciones')->nullable();
            $table->enum('moneda',['SOLES','DOLARES']);
            $table->boolean('es_mayoreo');
            $table->string('telefono_contacto',15)->nullable();
            $table->string('email_contacto',128)->nullable();
            $table->string('direccion_contacto',128)->nullable();
            $table->string('cod_ubigeo',6)->nullable();
            $table->integer('id_usuario_registro')->unsigned();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->boolean('es_cerrada')->default(0);
            $table->string('razon_cierre', 128)->nullable();
            $table->dateTime('fecha_cierre')->nullable();

            // $table->foreign('doc_cliente')->references('num_doc')->on('cliente');
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion_meson');
    }
}
