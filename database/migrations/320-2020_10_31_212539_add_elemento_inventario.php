<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddElementoInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elemento_inventario', function (Blueprint $table) {
            $table->increments('id_elemento_inventario');
            $table->string('nombre_elemento_inventario',100);
            $table->string('categoria',64);
            $table->enum('clase',['cuantificable','no_cuantificable','rh-lh']);
            $table->dateTime('fecha_registro')->useCurrent();
        });

        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'CENICERO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'ENCENDEDOR';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'MASCARA DE RADIO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'ANTENA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TARJETA PROPIEDAD';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'MANUALES MANTENIMIENTO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'SEGURO DE RUEDA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'CLAXON';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LUCES ALTAS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LUCES BAJAS / POSICION';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'NEBLINEROS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LUCES DE FRENO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LUZ DE PLACA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TERCERA LUZ FRENO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LUNAS PTA. DELANT';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LUNAS PTA. POST';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'ESPEJOS EXTERIORES';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();

        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'PISOS - JEBE';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'PISOS - ALFOMBRA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'cuantificable';
        $elementoInventario->save();

        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'CORTE CORRIENTE';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();


        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'SISTEMA A/FORZADO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'SISTEMA A/ACOND';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();


        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPASOLES';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'rh-lh';
        $elementoInventario->save();


        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'PLUMILLAS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'INYECTOR LIMPIAPARABRISAS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();

        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'ESCARPINES';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'VASOS / COPAS RUEDAS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'cuantificable';
        $elementoInventario->save();


        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'EMBLEMA DELANTERO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DEP. LIMPIAPARABRISAS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DE ACEITE';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA TANQUE ACEITE';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA TANQUE COMB.';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DE RADIADOR';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DE DEP. REFRIG.';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DEP. LIQ. FRENO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DEP. LIQ. EMBRAG.';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TAPA DE BORNE DE BATERIA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LLANTA DE REPUESTO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'GATA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'PALANCA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LLAVE DE RUEDA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'EMBLEMA POSTERIOR';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'HERRAMIENTAS';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'VEHICULO PULVERIZADO';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'ALARMA';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'CONTROLES';
        $elementoInventario->categoria = '';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();


        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'BOTIQUIN';
        $elementoInventario->categoria = 'ACCESORIOS ADICIONALES';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'EXTINTOR';
        $elementoInventario->categoria = 'ACCESORIOS ADICIONALES';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'TRIANGULO';
        $elementoInventario->categoria = 'ACCESORIOS ADICIONALES';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'CABLE BATERIA';
        $elementoInventario->categoria = 'ACCESORIOS ADICIONALES';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'CABLE REMOLQUE';
        $elementoInventario->categoria = 'ACCESORIOS ADICIONALES';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();
        $elementoInventario = new App\Modelos\ElementoInventario();
        $elementoInventario->nombre_elemento_inventario = 'LLAVEROS';
        $elementoInventario->categoria = 'ACCESORIOS ADICIONALES';
        $elementoInventario->clase = 'no_cuantificable';
        $elementoInventario->save();

        //update elemento_inventario set orden = id_elemento_inventario + id_elemento_inventario - 1 where categoria = '' and id_elemento_inventario<23
        //update elemento_inventario set orden = (id_elemento_inventario + id_elemento_inventario + 1) %47 + 2 where categoria = '' and id_elemento_inventario>=23
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elemento_inventario');
    }
}
