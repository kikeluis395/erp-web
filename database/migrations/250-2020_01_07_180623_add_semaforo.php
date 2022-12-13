<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSemaforo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semaforo', function (Blueprint $table) {
            $table->increments('id_semaforo');
            $table->string('color_css',32)->nullable(false);
            $table->decimal('tope_cantidad_dias',8,4)->nullable(false);

            $table->integer('id_estado_reparacion')->unsigned();
            $table->foreign('id_estado_reparacion')->references('id_estado_reparacion')->on('estado_reparacion');
        });

        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 2;
        $semaforo->tope_cantidad_dias = 2;
        $semaforo->color_css = 'green';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 2;
        $semaforo->tope_cantidad_dias = 5;
        $semaforo->color_css = 'yellow';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 2;
        $semaforo->tope_cantidad_dias = 9999;
        $semaforo->color_css = 'red';
        $semaforo->save();

        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 3;
        $semaforo->tope_cantidad_dias = 2;
        $semaforo->color_css = 'green';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 3;
        $semaforo->tope_cantidad_dias = 5;
        $semaforo->color_css = 'yellow';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 3;
        $semaforo->tope_cantidad_dias = 9999;
        $semaforo->color_css = 'red';
        $semaforo->save();

        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 4;
        $semaforo->tope_cantidad_dias = 2;
        $semaforo->color_css = 'green';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 4;
        $semaforo->tope_cantidad_dias = 5;
        $semaforo->color_css = 'yellow';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 4;
        $semaforo->tope_cantidad_dias = 9999;
        $semaforo->color_css = 'red';
        $semaforo->save();

        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 6;
        $semaforo->tope_cantidad_dias = 2;
        $semaforo->color_css = 'green';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 6;
        $semaforo->tope_cantidad_dias = 5;
        $semaforo->color_css = 'yellow';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 6;
        $semaforo->tope_cantidad_dias = 9999;
        $semaforo->color_css = 'red';
        $semaforo->save();

        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 13;
        $semaforo->tope_cantidad_dias = 2;
        $semaforo->color_css = 'green';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 13;
        $semaforo->tope_cantidad_dias = 5;
        $semaforo->color_css = 'yellow';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 13;
        $semaforo->tope_cantidad_dias = 9999;
        $semaforo->color_css = 'red';
        $semaforo->save();
        
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 19;
        $semaforo->tope_cantidad_dias = 2;
        $semaforo->color_css = 'green';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 19;
        $semaforo->tope_cantidad_dias = 5;
        $semaforo->color_css = 'yellow';
        $semaforo->save();
        $semaforo = new App\Modelos\Semaforo();
        $semaforo->id_estado_reparacion = 19;
        $semaforo->tope_cantidad_dias = 9999;
        $semaforo->color_css = 'red';
        $semaforo->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semaforo');
    }
}
