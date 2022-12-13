<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modelos\TipoCambio;

class AddTipoCambio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_cambio', function (Blueprint $table) {
            $table->increments('id_tipo_cambio');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->double('compra', 12, 3);
            $table->double('venta', 12, 3);
            $table->double('cobro', 12, 3);
            $table->integer('id_local')->unsigned()->nullable();
            $table->string('dni_empleado', 15)->nullable();

            $table->foreign('id_local')->references('id_local')->on('local_empresa');
            $table->foreign('dni_empleado')->references('dni')->on('empleado');
        });

        $tipoCambio = new TipoCambio();
        $tipoCambio->compra= 1;
        $tipoCambio->venta = 1;
        $tipoCambio->cobro = 1;
        $tipoCambio->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_cambio');
    }
}
