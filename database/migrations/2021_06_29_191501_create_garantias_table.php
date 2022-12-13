<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantias', function (Blueprint $table) {
            $table->unsignedInteger('id_garantia')->autoIncrement();
            $table->date('fecha_factura');
            $table->string('nro_factura', 30);
            $table->double('monto_mano_obra', 10, 2);
            $table->double('monto_repuestos', 10, 2);
            $table->double('monto_incentivo', 10, 2);
            $table->unsignedInteger('id_recepcion_ot')->nullable();
            $table->foreign('id_recepcion_ot')->references('id_recepcion_ot')->on('recepcion_ot');
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
        Schema::dropIfExists('garantias');
    }
}
