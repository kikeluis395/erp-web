<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmail2Phone2HojaTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hoja_trabajo', function (Blueprint $table) {
            
            $table->string('telefono_contacto2', 15)->nullable(true);
            $table->string('email_contacto2', 64)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('hoja_trabajo', 'telefono_contacto2')) {
            Schema::table('hoja_trabajo', function (Blueprint $table) {
                $table->dropColumn('telefono_contacto2');
            });
        }
        if (Schema::hasColumn('hoja_trabajo', 'email_contacto2')) {
            Schema::table('hoja_trabajo', function (Blueprint $table) {
                $table->dropColumn('email_contacto2');
            });
        }
    }
}
