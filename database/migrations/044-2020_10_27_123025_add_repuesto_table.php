<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modelos\Repuesto;

class AddRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repuesto', function (Blueprint $table) {
            $table->increments('id_repuesto');
            $table->string('codigo_repuesto',20);
            $table->string('descripcion',64);
            $table->string('ubicacion', 32)->nullable();
            $table->double('costo_no_igv',12,3);
            $table->enum('moneda_costo',['SOLES','DOLARES']);
            $table->double('pvp',12,3);
            $table->enum('moneda_pvp',['SOLES','DOLARES']);
            $table->boolean('aplica_mayoreo');
            $table->double('pvp_mayoreo',12,3)->nullable();
            $table->integer('id_categoria_repuesto')->unsigned();
            $table->integer('id_marca')->unsigned()->nullable();
            $table->integer('id_unidad_medida')->unsigned()->default(58);
            // $table->enum('moneda_pvp_mayoreo',['SOLES','DOLARES']);
            $table->timestamps();

            $table->foreign('id_categoria_repuesto')->references('id_categoria_repuesto')->on('categoria_repuesto');
            $table->foreign('id_marca')->references('id_marca_auto')->on('marca_auto');
            $table->foreign('id_unidad_medida')->references('id_unidad_medida')->on('unidad_medida');
        });

        $repuesto = new Repuesto();
        $repuesto->codigo_repuesto = 'REP001';
        $repuesto->descripcion = 'Repuesto 1';
        $repuesto->pvp = 10.00;
        $repuesto->id_categoria_repuesto = 1;
        $repuesto->save();

        $repuesto = new Repuesto();
        $repuesto->codigo_repuesto = 'REP002';
        $repuesto->descripcion = 'Repuesto 2';
        $repuesto->pvp = 20.00;
        $repuesto->id_categoria_repuesto = 2;
        $repuesto->save();

        $repuesto = new Repuesto();
        $repuesto->codigo_repuesto = 'REP003';
        $repuesto->descripcion = 'Repuesto 3';
        $repuesto->pvp = 30.00;
        $repuesto->id_categoria_repuesto = 3;
        $repuesto->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repuesto');
    }
}
