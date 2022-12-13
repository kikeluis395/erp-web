<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnidadMedida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_medida', function (Blueprint $table) {
            $table->increments('id_unidad_medida');
            $table->string('codigo_sunat', 10);
            $table->string('abreviacion', 10);
            $table->string('nombre_unidad', 100);
        });

        DB::insert("INSERT INTO unidad_medida(codigo_sunat, abreviacion, nombre_unidad) VALUES
            ('4A', 'BOB', 'BOBINAS'),
            ('BJ', 'BLD', 'BALDE'),
            ('BLL', 'BRR', 'BARRILES'),
            ('BG', 'BLS', 'BOLSA'),
            ('BO', 'BTL', 'BOTELLAS'),
            ('BX', 'CAJ', 'CAJA'),
            ('CT', 'CART', 'CARTONES'),
            ('CMK', 'CCUA', 'CENTIMETRO CUADRADO'),
            ('CMQ', 'CC', 'CENTIMETRO CUBICO'),
            ('CMT', 'CM', 'CENTIMETRO LINEAL'),
            ('CEN', 'CENT', 'CIENTO DE UNIDADES'),
            ('CY', 'CIL', 'CILINDRO'),
            ('CJ', 'CON', 'CONOS'),
            ('DZN', 'DZN', 'DOCENA'),
            ('DZP', 'DZP', 'DOCENA POR 10**6'),
            ('BE', 'FAR', 'FARDO'),
            ('GLI', 'GALI', 'GALON INGLES (4,545956L)'),
            ('GRM', 'GR', 'GRAMO'),
            ('GRO', 'GRO', 'GRUESA'),
            ('HLT', 'HLT', 'HECTOLITRO'),
            ('LEF', 'HOJA', 'HOJA'),
            ('SET', 'JG', 'JUEGO'),
            ('KGM', 'KG', 'KILOGRAMO'),
            ('KTM', 'KM', 'KILOMETRO'),
            ('KWH', 'KWH', 'KILOVATIO HORA'),
            ('KT', 'KIT', 'KIT'),
            ('CA', 'LAT', 'LATAS'),
            ('LBR', 'LBR', 'LIBRAS'),
            ('LTR', 'LT', 'LITRO'),
            ('MWH', 'MWH', 'MEGAWATT HORA'),
            ('MTR', 'M', 'METRO'),
            ('MTK', 'MCUA', 'METRO CUADRADO'),
            ('MTQ', 'MCUB', 'METRO CUBICO'),
            ('MGM', 'MG', 'MILIGRAMOS'),
            ('MLT', 'MLT', 'MILILITRO'),
            ('MMT', 'MM', 'MILIMETRO'),
            ('MMK', 'MMCUA', 'MILIMETRO CUADRADO'),
            ('MMQ', 'MMCUB', 'MILIMETRO CUBICO'),
            ('MLL', 'MLL', 'MILLARES'),
            ('UM', 'UM', 'MILLON DE UNIDADES'),
            ('ONZ', 'OZ', 'ONZAS'),
            ('PF', 'PF', 'PALETAS'),
            ('PK', 'PQT', 'PAQUETE'),
            ('PR', 'PAR', 'PAR'),
            ('FOT', 'PIE', 'PIES'),
            ('FTK', 'PCUA', 'PIES CUADRADOS'),
            ('FTQ', 'PCUB', 'PIES CUBICOS'),
            ('C62', 'PZ', 'PIEZAS'),
            ('PG', 'PLA', 'PLACAS'),
            ('ST', 'PLI', 'PLIEGO'),
            ('INH', 'PUL', 'PULGADAS'),
            ('RM', 'RM', 'RESMA'),
            ('DR', 'TAM', 'TAMBOR'),
            ('STN', 'TNC', 'TONELADA CORTA'),
            ('LTN', 'TNL', 'TONELADA LARGA'),
            ('TNE', 'TN', 'TONELADAS'),
            ('TU', 'TUB', 'TUBOS'),
            ('NIU', 'NIU', 'UNIDAD (BIENES)'),
            ('ZZ', 'ZZ', 'UNIDAD (SERVICIOS)'),
            ('GLL', 'GALA', 'US GALON (3,7843 L)'),
            ('YRD', 'YRD', 'YARDA'),
            ('YDK', 'YDK', 'YARDA CUADRADA')
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidad_medida');
    }
}
