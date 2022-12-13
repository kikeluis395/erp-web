<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDevolucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devoluciones', function (Blueprint $table) {
            $table->string('doc_referencia', 20)->nullable();
            if (!Schema::hasColumn('devoluciones', 'nro_nota_credito')) {
                $table->string('nro_nota_credito', 20)->nullable();
            }
            $table->enum('moneda', ['SOLES', 'DOLARES'])->default('SOLES');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('devoluciones', 'moneda')) {
            Schema::table('devoluciones', function (Blueprint $table) {
                $table->dropColumn('moneda');
            });
        }
        if (Schema::hasColumn('devoluciones', 'doc_referencia')) {
            Schema::table('devoluciones', function (Blueprint $table) {
                $table->dropColumn('doc_referencia');
            });
        }
        if (Schema::hasColumn('devoluciones', 'nro_nota_credito')) {
            Schema::table('devoluciones', function (Blueprint $table) {
                $table->dropColumn('nro_nota_credito');
            });
        }
    }
}
