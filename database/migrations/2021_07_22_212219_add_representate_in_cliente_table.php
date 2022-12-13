<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepresentateInClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->integer('documento_rep_legal')->nullable(true);
            $table->string('nombre_rep_legal',17)->nullable(true);
            $table->string('apellido_pat_rep_legal',17)->nullable(true);
            $table->string('apellido_mat_rep_legal',17)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cliente', function (Blueprint $table) {
            //
        });
    }
}
