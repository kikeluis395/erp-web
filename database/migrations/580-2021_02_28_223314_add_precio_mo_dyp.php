<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrecioMoDyp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_mo_dyp', function (Blueprint $table) {
            $table->increments('id_precio_mo_dyp');
            $table->integer('id_marca_auto')->unsigned();
            $table->integer('id_cia_seguro')->unsigned();
            $table->integer('id_local')->unsigned();
            $table->boolean('incluye_igv');
            $table->double('precio_valor_venta');
            $table->enum('tipo', ['HH','PANHOS']);
            $table->enum('moneda', ['SOLES','DOLARES']);
            $table->dateTime('fecha_inicio_aplicacion');
            $table->dateTime('fecha_registro')->useCurrent();

            $table->foreign('id_marca_auto')->references('id_marca_auto')->on('marca_auto');
            $table->foreign('id_cia_seguro')->references('id_cia_seguro')->on('cia_seguro');
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
        });

        DB::insert("INSERT INTO precio_mo_dyp(id_marca_auto,id_cia_seguro,id_local,incluye_igv,precio_valor_venta,tipo,moneda,fecha_inicio_aplicacion)
        VALUES (1,1,1,1,20,'HH','DOLARES', now()),
        (1,2,1,1,15,'HH','DOLARES', now()),
        (1,3,1,1,15,'HH','DOLARES', now()),
        (1,4,1,1,16,'HH','DOLARES', now()),
        (1,5,1,1,12,'HH','DOLARES', now()),
        (1,6,1,1,20,'HH','DOLARES', now()),

        (1,1,1,1,80,'PANHOS','DOLARES', now()),
        (1,2,1,1,60,'PANHOS','DOLARES', now()),
        (1,3,1,1,60,'PANHOS','DOLARES', now()),
        (1,4,1,1,60,'PANHOS','DOLARES', now()),
        (1,5,1,1,60,'PANHOS','DOLARES', now()),
        (1,6,1,1,80,'PANHOS','DOLARES', now())
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precio_mo_dyp');
    }
}
