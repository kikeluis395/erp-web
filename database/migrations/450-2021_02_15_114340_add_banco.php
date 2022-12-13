<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banco', function (Blueprint $table) {
            $table->increments('id_banco');
            $table->string('codigo_banco', 6);
            $table->string('nombre_banco', 100);
            $table->string('nombre_sunat', 100);
        });

        DB::insert("INSERT INTO banco (id_banco, codigo_banco, nombre_banco, nombre_sunat) VALUES
            (1, '01', 'BCR', 'CENTRAL RESERVA DEL PERU'),
            (2, '02', 'BCP', 'DE CREDITO DEL PERU'),
            (3, '03', 'INTERBANK', 'INTERNACIONAL DEL PERU'),
            (4, '05', 'BANCO LATINO', 'LATINO'),
            (5, '07', 'CITIBANK', 'CITIBANK DEL PERU S.A.'),
            (6, '08', 'BANCO STANDARD CHARTERED', 'STANDARD CHARTERED'),
            (7, '09', 'SCOTIABANK', 'SCOTIABANK PERU'),
            (8, '11', 'BBVA', 'CONTINENTAL'),
            (9, '12', 'BANCO DE LIMA', 'DE LIMA'),
            (10, '16', 'BANCO MERCANTIL', 'MERCANTIL'),
            (11, '18', 'BANCO DE LA NACION', 'NACION'),
            (12, '22', 'SANTANDER CENTRAL HISPANO', 'SANTANDER CENTRAL HISPANO'),
            (13, '23', 'BANCO DE COMERCIO', 'DE COMERCIO'),
            (14, '25', 'BANCO REPUBLICA', 'REPUBLICA'),
            (15, '26', 'NBK', 'NBK BANK '),
            (16, '29', 'BANCOSUR', 'BANCOSUR'),
            (17, '35', 'BANCO FINANCIERO', 'FINANCIERO DEL PERU'),
            (18, '37', 'BANCO DEL PROGRESO', 'DEL PROGRESO'),
            (19, '38', 'BANBIF', 'INTERAMERICANO FINANZAS'),
            (20, '39', 'BANEX', 'BANEX'),
            (21, '40', 'BANCO NUEVO MUNDO', 'NUEVO MUNDO'),
            (22, '41', 'BANCO SUDAMERICANO', 'SUDAMERICANO'),
            (23, '42', 'BANCO DEL LIBERTADOR', 'DEL LIBERTADOR'),
            (24, '43', 'BANCO DEL TRABAJO', 'DEL TRABAJO'),
            (25, '44', 'BANCO SOLVENTA', 'SOLVENTA'),
            (26, '45', 'SERBANCO', 'SERBANCO SA.'),
            (27, '46', 'BANK OF BOSTON', 'BANK OF BOSTON'),
            (28, '47', 'BANCO ORION ', 'ORION'),
            (29, '48', 'BANCO DEL PAIS', 'DEL PAIS'),
            (30, '49', 'MIBANCO', 'MI BANCO'),
            (31, '50', 'BNP PARIBAS', 'BNP PARIBAS'),
            (32, '51', 'AGROBANCO', 'AGROBANCO'),
            (33, '53', 'HSBC', 'HSBC BANK PERU S.A.'),
            (34, '54', 'BANCO FALABELLA', 'BANCO FALABELLA S.A.'),
            (35, '55', 'BANCO RIPLEY', 'BANCO RIPLEY'),
            (36, '56', 'BANCO SANTANDER PERU', 'BANCO SANTANDER PERU S.A.'),
            (37, '58', 'BANCO AZTECA', 'BANCO AZTECA DEL PERU'),
            (38, '99', 'OTRO BANCO', 'OTROS');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banco');
    }
}
