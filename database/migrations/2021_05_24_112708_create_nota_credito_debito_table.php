<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaCreditoDebitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito_debito', function (Blueprint $table) {
            $table->bigIncrements('id_nota_credito_debito');
            $table->string('tipo_documento', 2)->nullable(false);
            $table->string('serie', 8)->nullable(true);
            $table->string('num_doc', 8)->nullable(true);
            $table->string('doc_referencia', 15)->nullable(false);
            $table->dateTime('fecha_vencimiento')->nullable(true);
            $table->string('condicion_pago',20)->nullable(true);
            $table->string('motivo_emision',2)->nullable(false);         
            $table->string('observaciones', 15)->nullable(true);
            $table->string('estado',20)->nullable(true);
            $table->integer('id_sibi_credit_notes')->nullable(true);
            $table->double('taxable_operations')->nullable(true);
            $table->integer('id_usuario_registro')->unsigned()->nullable();
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_credito_debito');
    }
}
