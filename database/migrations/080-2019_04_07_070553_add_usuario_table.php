<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('username',16)->nullable(false);
            $table->string('password');
            $table->integer('id_rol')->unsigned();
            $table->foreign('id_rol')->references('id_rol')->on('rol');
            $table->string('dni',15)->nullable(true);
            $table->foreign('dni')->references('dni')->on('empleado');
            $table->integer('habilitado')->nullable(false);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->dateTime('fecha_modificacion')->useCurrent();
        });
        
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'admin';
        $usuario->password = bcrypt('admin');
        $usuario->id_rol= 1;
        $usuario->dni='77591264';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'asesor_servicios';
        $usuario->password = bcrypt('123');
        $usuario->id_rol= 2;
        $usuario->dni='77591264';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'asesor_dyp';
        $usuario->password = bcrypt('123');
        $usuario->id_rol= 3;
        $usuario->dni='77591264';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'supervisor';
        $usuario->password = bcrypt('123');
        $usuario->id_rol= 4;
        $usuario->dni='77591264';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'asesor_repuestos';
        $usuario->password = bcrypt('123');
        $usuario->id_rol= 5;
        $usuario->dni='77591264';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'jefe';
        $usuario->password = bcrypt('123');
        $usuario->id_rol= 6;
        $usuario->dni='77591264';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'msanchez';
        $usuario->password = bcrypt('msanchez');
        $usuario->id_rol= 2;
        $usuario->dni='1111';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'emontenegro';
        $usuario->password = bcrypt('emontenegro');
        $usuario->id_rol= 2;
        $usuario->dni='2222';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'cmorocho';
        $usuario->password = bcrypt('cmorocho');
        $usuario->id_rol= 2;
        $usuario->dni='3333';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'mflores';
        $usuario->password = bcrypt('mflores');
        $usuario->id_rol= 2;
        $usuario->dni='4444';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'echocca';
        $usuario->password = bcrypt('echocca');
        $usuario->id_rol= 2;
        $usuario->dni='5555';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'mperez';
        $usuario->password = bcrypt('mperez');
        $usuario->id_rol= 2;
        $usuario->dni='6666';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'jgoicochea';
        $usuario->password = bcrypt('jgoicochea');
        $usuario->id_rol= 2;
        $usuario->dni='7777';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'oaltamirano';
        $usuario->password = bcrypt('oaltamirano');
        $usuario->id_rol= 2;
        $usuario->dni='8888';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'jsalcedo';
        $usuario->password = bcrypt('jsalcedo');
        $usuario->id_rol= 2;
        $usuario->dni='9999';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'rnoriega';
        $usuario->password = bcrypt('rnoriega');
        $usuario->id_rol= 2;
        $usuario->dni='11111';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'lugarte';
        $usuario->password = bcrypt('lugarte');
        $usuario->id_rol= 2;
        $usuario->dni='22222';
        $usuario->habilitado=1;
        $usuario->save();
        $usuario=new App\Modelos\Usuario();
        $usuario->username = 'tecnico';
        $usuario->password = bcrypt('123');
        $usuario->id_rol= 7;
        $usuario->dni='TECN_SM';
        $usuario->habilitado=1;
        $usuario->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
