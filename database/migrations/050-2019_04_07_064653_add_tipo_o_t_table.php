<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoOTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_ot', function (Blueprint $table) {
            $table->increments('id_tipo_ot');
            $table->string('nombre_tipo_ot',32)->nullable(false);
            $table->enum('departamento', ['MEC', 'DYP', 'AMBOS'])->nullable(false);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->boolean('habilitado')->default(1);
        });

        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='CLIENTE';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='RECLAMO';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='GARANTÍA';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='ORDEN INTERNA';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();

        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='PREVENTIVO';
        $tipoOT->departamento='MEC';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='CORRECTIVO';
        $tipoOT->departamento='MEC';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='PUESTA A PUNTO';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='PDI';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();
        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='SINIESTRO';
        $tipoOT->departamento='DYP';
        $tipoOT->save();

        $tipoOT=new App\Modelos\TipoOT();
        $tipoOT->nombre_tipo_ot='CORTESIA';
        $tipoOT->departamento='AMBOS';
        $tipoOT->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_ot');
    }
}
