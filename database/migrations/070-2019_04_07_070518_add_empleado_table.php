<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->string('dni',15)->index()->nullable(false);
            $table->string('primer_nombre',16);
            $table->string('primer_apellido',16);
            $table->string('segundo_apellido',16);
            $table->date('fecha_nacimiento');
            $table->string('email',64);
            $table->string('telefono_contacto',16);
            $table->integer('id_local')->unsigned();
            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->dateTime('fecha_registro')->useCurrent();
        });

        $empleado=new App\Modelos\Empleado();
        $empleado->dni='77591264';
        $empleado->primer_nombre='Bruno';
        $empleado->primer_apellido='Espezua';
        $empleado->segundo_apellido='Zapana';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='bruno.espezua@pucp.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=1;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='1111';
        $empleado->primer_nombre='Manuel';
        $empleado->primer_apellido='Sánchez';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='msanchez@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=1;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='2222';
        $empleado->primer_nombre='Eduardo';
        $empleado->primer_apellido='Montenegro';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='emontenegro@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=1;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='3333';
        $empleado->primer_nombre='César';
        $empleado->primer_apellido='Morocho';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='cmorocho@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=4;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='4444';
        $empleado->primer_nombre='Manuel';
        $empleado->primer_apellido='Flores';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='mflores@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=4;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='5555';
        $empleado->primer_nombre='Enrique';
        $empleado->primer_apellido='Chocca';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='echocca@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=6;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='6666';
        $empleado->primer_nombre='Martín';
        $empleado->primer_apellido='Pérez';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='mperez@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=5;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='7777';
        $empleado->primer_nombre='Jorge';
        $empleado->primer_apellido='Goicochea';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='jgoicochea@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=2;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='8888';
        $empleado->primer_nombre='Óscar';
        $empleado->primer_apellido='Altamirano';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='oaltamirano@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=3;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='9999';
        $empleado->primer_nombre='Julio';
        $empleado->primer_apellido='Salcedo';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='jsalcedo@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=6;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='11111';
        $empleado->primer_nombre='Raúl';
        $empleado->primer_apellido='Noriega';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='rnoriega@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=1;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='22222';
        $empleado->primer_nombre='Luis';
        $empleado->primer_apellido='Ugarte';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='lugarte@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=6;
        $empleado->save();
        $empleado=new App\Modelos\Empleado();
        $empleado->dni='TECN_SM';
        $empleado->primer_nombre='Tecnicos';
        $empleado->primer_apellido='San Miguel';
        $empleado->segundo_apellido='';
        $empleado->fecha_nacimiento='1998-01-20';
        $empleado->email='tecnicos_san_miguel@autoland.pe';
        $empleado->telefono_contacto='926900948';
        $empleado->id_local=6;
        $empleado->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}
