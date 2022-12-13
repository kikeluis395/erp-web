<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriosDanhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterio_danho', function (Blueprint $table) {
            $table->unsignedInteger('id_criterio')->autoIncrement();
            $table->string("codigo", 11)->nullable(false);
            $table->double("valor", 10, 2)->nullable(false);
            $table->boolean("editable")->nullable(false);
            $table->boolean("habilitado")->nullable(false);
            $table->enum("before", [">", "<"])->nullable();
            $table->unsignedInteger('id_usuario')->nullable(false);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->dateTime('fecha_edicion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterios_danho');
    }
}
