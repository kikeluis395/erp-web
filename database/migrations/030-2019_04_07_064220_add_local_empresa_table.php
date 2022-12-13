<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocalEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_empresa', function (Blueprint $table) {
            $table->increments('id_local');
            $table->string('nombre_local',64)->nullable(false);
            $table->string('direccion_local',128);
            $table->integer('habilitado')->nullable(false);
            $table->integer('recibe_vehiculos')->nullable(false);
            $table->integer('hace_traslado')->nullable(false);
            $table->dateTime('fechaRegistro')->useCurrent();
        });

        $localEmpresa=new App\Modelos\LocalEmpresa();
        $localEmpresa->nombre_local='DyP Nissan San Miguel';
        $localEmpresa->direccion_local='Calle de san miguel 123';
        $localEmpresa->recibe_vehiculos=1;
        $localEmpresa->hace_traslado=1;
        $localEmpresa->habilitado=1;
        $localEmpresa->save();
        $localEmpresa=new App\Modelos\LocalEmpresa();
        $localEmpresa->nombre_local='DyP Miraflores';
        $localEmpresa->direccion_local='Calle de miraflores 123';
        $localEmpresa->recibe_vehiculos=1;
        $localEmpresa->hace_traslado=1;
        $localEmpresa->habilitado=1;
        $localEmpresa->save();
        $localEmpresa=new App\Modelos\LocalEmpresa();
        $localEmpresa->nombre_local='DyP Surquillo';
        $localEmpresa->direccion_local='Calle de san isidro 123';
        $localEmpresa->recibe_vehiculos=1;
        $localEmpresa->hace_traslado=1;
        $localEmpresa->habilitado=1;
        $localEmpresa->save();
        $localEmpresa=new App\Modelos\LocalEmpresa();
        $localEmpresa->nombre_local='DyP Surco';
        $localEmpresa->direccion_local='Calle de surco 123';
        $localEmpresa->recibe_vehiculos=1;
        $localEmpresa->hace_traslado=1;
        $localEmpresa->habilitado=1;
        $localEmpresa->save();
        $localEmpresa=new App\Modelos\LocalEmpresa();
        $localEmpresa->nombre_local='DyP Nissan Los Olivos';
        $localEmpresa->direccion_local='Calle de los olivos 123';
        $localEmpresa->recibe_vehiculos=1;
        $localEmpresa->hace_traslado=0;
        $localEmpresa->habilitado=1;
        $localEmpresa->save();
        $localEmpresa=new App\Modelos\LocalEmpresa();
        $localEmpresa->nombre_local='DyP ATE';
        $localEmpresa->direccion_local='Calle de ate 123';
        $localEmpresa->recibe_vehiculos=1;
        $localEmpresa->hace_traslado=0;
        $localEmpresa->habilitado=1;
        $localEmpresa->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_empresa');
    }
}
