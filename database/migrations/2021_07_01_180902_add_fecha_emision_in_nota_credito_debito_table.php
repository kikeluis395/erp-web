<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaEmisionInNotaCreditoDebitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
            $table->date('fecha_emision');
        });

        if (!Schema::hasColumn('nota_credito_debito', 'id_local')) {
            Schema::table('nota_credito_debito', function (Blueprint $table) {
                $table->integer('id_local')->unsigned();
                $table->foreign('id_local')->references('id_local')->on('local_empresa');
            });
            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
            $table->dropColumn('fecha_emision');
        });

        
    }
}
