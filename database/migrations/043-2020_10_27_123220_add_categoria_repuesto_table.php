<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modelos\CategoriaRepuesto;

class AddCategoriaRepuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_repuesto', function (Blueprint $table) {
            $table->increments('id_categoria_repuesto');
            $table->string('nombre_categoria',48);
            $table->timestamps();
        });

        $categoriaRepuesto = new CategoriaRepuesto();
        $categoriaRepuesto->nombre_categoria='CATEGORIA 1';
        $categoriaRepuesto->save();

        $categoriaRepuesto = new CategoriaRepuesto();
        $categoriaRepuesto->nombre_categoria='CATEGORIA 2';
        $categoriaRepuesto->save();

        $categoriaRepuesto = new CategoriaRepuesto();
        $categoriaRepuesto->nombre_categoria='CATEGORIA 3';
        $categoriaRepuesto->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_repuesto');
    }
}
