<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarcaAutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marca_auto', function (Blueprint $table) {
            $table->increments('id_marca_auto');
            $table->string('nombre_marca',16)->nullable(false);
            $table->integer('habilitado')->nullable(false);
        });

        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='NISSAN';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='KIA';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='MAZDA';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='SUZUKI';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='FORD';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='DFSK';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='CHEVROLET';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='TOYOTA';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='VOLKSWAGEN';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='RENAULT';
        $marca->habilitado=1;
        $marca->save();
        $marca = new App\Modelos\MarcaAuto();
        $marca->nombre_marca ='HYUNDAI';
        $marca->habilitado=1;
        $marca->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marca_auto');
    }
}
