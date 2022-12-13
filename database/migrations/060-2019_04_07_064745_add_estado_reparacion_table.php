<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoReparacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_reparacion', function (Blueprint $table) {
            $table->increments('id_estado_reparacion');
            $table->string('nombre_estado_reparacion_interno',64)->nullable(false);
            $table->string('nombre_estado_reparacion_filtro',32)->nullable(false);
            $table->string('nombre_estado_reparacion',32)->nullable(false);
        });

        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA TRASLADO';
        $estadoOT->nombre_estado_reparacion_interno='espera_traslado';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA TRASLADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA VALUACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_valuacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA VALUACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA APROBACIÓN - C';
        $estadoOT->nombre_estado_reparacion_interno='espera_aprobacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA APROBACIÓN - C';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA ASIGNACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_asignacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA ASIGNACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA REPARACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_reparacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA REPARACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='VEHÍCULO LISTO';
        $estadoOT->nombre_estado_reparacion_interno='vehiculo_listo';
        $estadoOT->nombre_estado_reparacion_filtro='VEHÍCULO LISTO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ENTREGADO';
        $estadoOT->nombre_estado_reparacion_interno='entregado';
        $estadoOT->nombre_estado_reparacion_filtro='ENTREGADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='EN CARGO';
        $estadoOT->nombre_estado_reparacion_interno='rechazado';
        $estadoOT->nombre_estado_reparacion_filtro='EN CARGO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PÉRDIDA TOTAL';
        $estadoOT->nombre_estado_reparacion_interno='perdida_total';
        $estadoOT->nombre_estado_reparacion_filtro='PÉRDIDA TOTAL';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='HOTLINE';
        $estadoOT->nombre_estado_reparacion_interno='hotline';
        $estadoOT->nombre_estado_reparacion_filtro='HOTLINE';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ENTREGADO P.T';
        $estadoOT->nombre_estado_reparacion_interno='entregado_pt';
        $estadoOT->nombre_estado_reparacion_filtro='ENTREGADO P.T';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA REPARACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_reparacion_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA REPARACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='VEHICULO LISTO';
        $estadoOT->nombre_estado_reparacion_interno='vehiculo_listo_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='VEHICULO LISTO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ENTREGADO';
        $estadoOT->nombre_estado_reparacion_interno='entregado_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='ENTREGADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='AMPLIACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_valuacion_ampliacion';
        $estadoOT->nombre_estado_reparacion_filtro='AMPLIACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA APROBACIÓN - C';
        $estadoOT->nombre_estado_reparacion_interno='espera_aprobacion_ampliacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA APROBACIÓN - C';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA REPARACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_reparacion_ampliacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA REPARACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA REPARACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='espera_reparacion_ampliacion_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA REPARACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA APROBACIÓN - S';
        $estadoOT->nombre_estado_reparacion_interno='espera_aprobacion_seguro';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA APROBACIÓN - S';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='CONTROL CALIDAD';
        $estadoOT->nombre_estado_reparacion_interno='espera_control_calidad';
        $estadoOT->nombre_estado_reparacion_filtro='CONTROL CALIDAD';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ESPERA APROBACIÓN - S';
        $estadoOT->nombre_estado_reparacion_interno='espera_aprobacion_seguro_ampliacion';
        $estadoOT->nombre_estado_reparacion_filtro='ESPERA APROBACIÓN - S';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='MECÁNICA';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_mecanica';
        $estadoOT->nombre_estado_reparacion_filtro='MECÁNICA';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='CARROCERÍA';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_carroceria';
        $estadoOT->nombre_estado_reparacion_filtro='CARROCERÍA';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PREPARACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_preparacion';
        $estadoOT->nombre_estado_reparacion_filtro='PREPARACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PINTURA';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_pintura';
        $estadoOT->nombre_estado_reparacion_filtro='PINTURA';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ARMADO';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_armado';
        $estadoOT->nombre_estado_reparacion_filtro='ARMADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PULIDO';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_pulido';
        $estadoOT->nombre_estado_reparacion_filtro='PULIDO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='MECÁNICA';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_mecanica_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='MECÁNICA';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='CARROCERÍA';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_carroceria_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='CARROCERÍA';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PREPARACIÓN';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_preparacion_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='PREPARACIÓN';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PINTURA';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_pintura_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='PINTURA';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='ARMADO';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_armado_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='ARMADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PULIDO';
        $estadoOT->nombre_estado_reparacion_interno='reparacion_pulido_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='PULIDO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='CONTROL CALIDAD';
        $estadoOT->nombre_estado_reparacion_interno='espera_control_calidad_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='CONTROL CALIDAD';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PARALIZADO';
        $estadoOT->nombre_estado_reparacion_interno='paralizado';
        $estadoOT->nombre_estado_reparacion_filtro='PARALIZADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='PARALIZADO';
        $estadoOT->nombre_estado_reparacion_interno='paralizado_hotline';
        $estadoOT->nombre_estado_reparacion_filtro='PARALIZADO';
        $estadoOT->save();
        $estadoOT=new App\Modelos\EstadoReparacion();
        $estadoOT->nombre_estado_reparacion='CERRADO';
        $estadoOT->nombre_estado_reparacion_interno='cerrado';
        $estadoOT->nombre_estado_reparacion_filtro='CERRADO';
        $estadoOT->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_reparacion');
    }
}
