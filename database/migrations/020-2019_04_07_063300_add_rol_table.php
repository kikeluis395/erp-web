<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->increments('id_rol');
            $table->string('nombre_rol',64);
        });
        
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Administrador del Sistema';
        $rol->save();
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Asesor de Servicio';
        $rol->save();
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Asesor DYP';
        $rol->save();
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Supervisor';
        $rol->save();
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Asesor de Repuestos';
        $rol->save();
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Jefe';
        $rol->save();
        $rol=new App\Modelos\Rol();
        $rol->nombre_rol='Tecnico';
        $rol->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol');
    }
}
