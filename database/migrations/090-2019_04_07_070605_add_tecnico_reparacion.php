<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTecnicoReparacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tecnico_reparacion', function (Blueprint $table) {
            $table->increments('id_tecnico');
            $table->string('nombre_tecnico',128);
            $table->dateTime('fecha_registro')->useCurrent();
        });

        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 1';
        $tecnico->save();
        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 2';
        $tecnico->save();
        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 3';
        $tecnico->save();
        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 4';
        $tecnico->save();
        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 5';
        $tecnico->save();
        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 6';
        $tecnico->save();
        $tecnico=new App\Modelos\TecnicoReparacion();
        $tecnico->nombre_tecnico='Tecnico 7';
        $tecnico->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tecnico_reparacion');
    }
}
