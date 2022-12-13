<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstadoRepuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('estado_repuesto', function (Blueprint $table) {
        //     $table->increments('id_estado_repuesto');
        //     $table->string('nombre_estado_repuesto',32)->nullable(false);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('estado_repuesto');
    }
}
