<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrecioMoMec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_mo_mec', function (Blueprint $table) {
            $table->increments('id_precio_mo_mec');
            $table->integer('id_local_empresa')->unsigned();
            $table->enum('tipo',['MO','MATERIALES']);
            $table->boolean('incluye_igv');
            $table->double('precio_valor_venta');
            $table->enum('moneda',['SOLES','DOLARES']);
            $table->dateTime('fecha_inicio_aplicacion');
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_local_empresa')->references('id_local')->on('local_empresa');
        });

        DB::insert("INSERT INTO precio_mo_mec(id_local_empresa,tipo,incluye_igv,precio_valor_venta,moneda,fecha_inicio_aplicacion)
        VALUES  (1,'MO',1,50,'SOLES',now()),
                (1,'MATERIALES',1,50,'SOLES',now())
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precio_mo_mec');
    }
}
