<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClienteInNotaCreditoDebitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
            $table->string('nrodoc_cliente', 15);
            $table->string('nombre_cliente', 128);
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_credito_debito', function (Blueprint $table) {
            $table->dropColumn('nrodoc_cliente');
            $table->dropColumn('nombre_cliente');
        });

        
    }
}
