<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_trabajo', function (Blueprint $table) {
            $table->unsignedInteger('id_horario')->autoIncrement();

            $table->time('dom_in')->nullable(false);
            $table->time('dom_out')->nullable(false);
            $table->time('lun_in')->nullable(false);
            $table->time('lun_out')->nullable(false);
            $table->time('mar_in')->nullable(false);
            $table->time('mar_out')->nullable(false);
            $table->time('mie_in')->nullable(false);
            $table->time('mie_out')->nullable(false);
            $table->time('jue_in')->nullable(false);
            $table->time('jue_out')->nullable(false);
            $table->time('vie_in')->nullable(false);
            $table->time('vie_out')->nullable(false);
            $table->time('sab_in')->nullable(false);
            $table->time('sab_out')->nullable(false);
            $table->boolean('en_uso')->default(0);

            $table->date('aplica_desde')->nullable(false);
            $table->date('aplica_hasta')->nullable();
            $table->integer('intervalo_citas')->nullable(false);

            $table->dateTime('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios_trabajo');
    }
}
