<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCiaSeguroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cia_seguro', function (Blueprint $table) {
            $table->increments('id_cia_seguro');
            $table->string('nombre_cia_seguro',64)->nullable(false);
            $table->integer('habilitado')->nullable(false);
        });
        
        $seguro = new App\Modelos\CiaSeguro();
        $seguro->nombre_cia_seguro='PARTICULAR';
        $seguro->habilitado=1;
        $seguro->save();
        $seguro = new App\Modelos\CiaSeguro();
        $seguro->nombre_cia_seguro='RIMAC';
        $seguro->habilitado=1;
        $seguro->save();
        $seguro = new App\Modelos\CiaSeguro();
        $seguro->nombre_cia_seguro='LA POSITIVA';
        $seguro->habilitado=1;
        $seguro->save();
        $seguro = new App\Modelos\CiaSeguro();
        $seguro->nombre_cia_seguro='PACÍFICO';
        $seguro->habilitado=1;
        $seguro->save();
        $seguro = new App\Modelos\CiaSeguro();
        $seguro->nombre_cia_seguro='MAPFRE';
        $seguro->habilitado=1;
        $seguro->save();
        $seguro = new App\Modelos\CiaSeguro();
        $seguro->nombre_cia_seguro='QUALITAS';
        $seguro->habilitado=1;
        $seguro->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cia_seguro');
    }
}
