<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsHojaInspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hoja_inspeccion', function (Blueprint $table) {
            $table->string('modelo')->nullable();
            $table->string('color')->nullable();
            $table->string('ano_modelo')->nullable();
            $table->string('vin')->nullable();
            $table->string('destino')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
