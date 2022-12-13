<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Modelos\EstadoReparacion;
use App\Modelos\Cotizacion;
use App\Modelos\NecesidadRepuestos;
use App\Modelos\TecnicoReparacion;
use App\Modelos\Reparacion;
use App\Modelos\ItemNecesidadRepuestos;
use Carbon\Carbon;
use Mail;
use App\Helper\Helper;
use App\Modelos\Administracion\PrecioDYP;

class RecepcionOT extends Model
{
    protected $table = "recepcion_ot";
    protected $fillable = ['id_tipo_ot', 'id_cia_seguro', 'id_local', 'fecha_traslado', 'fecha_liquidacion', ''];
    protected $primaryKey = 'id_recepcion_ot';
    // para acceder al nombre del PK, se usa getKeyName en el resto de scripts

    public $timestamps = false;

    public static $nombreRutaDetalleOTDYP = 'detalle_trabajos.index';
    public static $nombreRutaDetalleOTMEC = 'mecanica.detalle_trabajos.index';
    public static $detalleOTRouteKey = 'id_recepcion_ot';

    public function getNroOT()
    {
        return $this->id_recepcion_ot;
    }

    public function hojaTrabajo()
    {
        return $this->hasOne('App\Modelos\HojaTrabajo', 'id_recepcion_ot');
    }

    public function getFechaLiquidacionFormat($formato = null)
    {
        if ($formato == null) $formato = 'd/m/Y';
        return Carbon::parse($this->fecha_liquidacion)->format($formato);
    }

    public function lineaReingresoRepuestos()
    {
        return $this->hasMany('App\Modelos\LineaReingresoRepuestos', 'id_reingreso_repuestos');
    }

    public function getHojaTrabajo()
    {
        $hojaTrabajo = $this->hojaTrabajo;
        if ($hojaTrabajo) {
            return $hojaTrabajo;
        } else {
            return $this->hojaTrabajo()->first();
        }
    }

    public function getHojaTrabajoUpdated()
    {
        $hojaTrabajo = $this->hojaTrabajo()->first();
        return $hojaTrabajo;
    }

    public function getDetallesTrabajoCompleto()
    {
        $detallesTrabajo = $this->getHojaTrabajo()->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->where('tipo_trabajo', '!=', 'SERVICIOS TERCEROS');
        })->get()->all();

        // if($this->cotizaciones()->count()){
        //     $cotizaciones = $this->cotizaciones()->with('hojaTrabajo.detallesTrabajo')->get()->all();
        //     foreach ($cotizaciones as $cotizacion) {
        //         $detallesTrabajo = array_merge($detallesTrabajo, $cotizacion->hojaTrabajo->detallesTrabajo->all());
        //     }
        // }

        return $detallesTrabajo;
    }

    public function getServiciosTerceros()
    {
        $serviciosTerceros = $this->getHojaTrabajo()->serviciosTerceros()->with('servicioTercero')->get()->all();

        return $serviciosTerceros;
    }

    public function tieneServiciosTercerosSinOrdenServicio()
    {
        $serviciosTerceros = $this->getHojaTrabajo()->serviciosTerceros()->get()->all();

        foreach ($serviciosTerceros as $row) {
            if (!$row->tieneOrdenServicio())
                return true;
        }
        return false;
    }

    public function cotizaciones()
    {
        return $this->hasMany('App\Modelos\Cotizacion', 'id_recepcion_ot');
    }

    public function linea_garantia()
    {
        return $this->hasOne('App\Modelos\LineaGarantia', 'id_recepcion_ot', 'id_recepcion_ot');
    }

    public function estado_garantia($literal = false)
    {
        $linea = $this->linea_garantia;
        if ($linea) {
            $estado = $linea->estado;
            if ($literal) return $estado;

            switch ($estado) {
                case '0':
                    return 'PENDIENTE DE CARGA';
                case '1':
                    return 'GARANTÍA EN PROCESO';
                default:
                    break;
            }
        }
        return '-';
    }

    public function claseGarantia()
    {
        $estado = $this->estado_garantia(true);
        switch ($estado) {
            case '0':
                return 'garantia_pendiente';
            case '1':
                return 'garantia_proceso';
            default:
                return '';
        }
    }

    public function gestionMarca()
    {
        $linea = $this->linea_garantia;
        $fecha = '-';
        if ($linea) {
            $fecha_carga = $linea->fecha_carga;
            $fecha_reproceso = $linea->fecha_reproceso;

            if (!is_null($fecha_carga)) $fecha = date("d/m/Y", strtotime($fecha_carga));
            if (!is_null($fecha_reproceso)) $fecha = date("d/m/Y", strtotime($fecha_reproceso));
        }
        return $fecha;
    }

    public function reproceso()
    {
        return !is_null($this->linea_garantia->codigo_registro);
    }

    public function retrabajo()
    {
        return !is_null($this->linea_garantia->fecha_reproceso);
    }


    public function getCotizaciones()
    {
        $cotizaciones = $this->cotizaciones;
        if ($cotizaciones) {
            return $cotizaciones->all();
        } else {
            return $this->cotizaciones()->get()->all();
        }
    }

    public function tipoOT()
    {
        return $this->belongsTo('App\Modelos\TipoOT', 'id_tipo_ot');
    }

    public function esGarantia()
    {
        $in = $this->tipoOT->nombre_tipo_ot;
        $in = $this->excludeAcent($in);
        if ($in === "garantia") return true;
        else return false;
    }

    public function fechaNotaEntrega()
    {
        $in = $this->fecha_nota_entrega;
        if (!is_null($in)) {
            return date("d/m/Y", strtotime($in));
        }
        return '-';
    }

    public function getNombreTipoOT()
    {
        $tipoOT = $this->tipoOT;
        return $tipoOT->nombre_tipo_ot;
    }

    public function ciaSeguro()
    {
        return $this->belongsTo('App\Modelos\CiaSeguro', 'id_cia_seguro');
    }

    public function comprobanteVenta()
    {
        return $this->hasOne('App\Modelos\ComprobanteVenta', 'id_recepcion_ot');
    }

    public function comprobanteAnticipo()
    {
        return $this->hasOne('App\Modelos\ComprobanteAnticipo', 'id_recepcion_ot');
    }

    public function getNombreCiaSeguro()
    {
        $ciaSeguro = $this->ciaSeguro;
        return is_null($ciaSeguro) ? "-" : $ciaSeguro->getNombreCiaSeguro();
    }

    public function garantia()
    {
        return $this->hasOne('App\Modelos\Garantias', 'id_recepcion_ot');
    }

    public function localEmpresa()
    {
        return $this->belongsTo('App\Modelos\LocalEmpresa', 'id_local');
    }

    public function reingresoRepuestos()
    {
        return $this->belongsTo('App\Modelos\ReingresoRepuestos', 'id_reingreso_repuestos');
    }

    public function estadosReparacion()
    {
        return $this->belongsToMany('App\Modelos\EstadoReparacion', 'recepcion_ot_estado_reparacion', 'id_recepcion_ot', 'id_estado_reparacion')
            ->using('App\Modelos\RecepcionOT_EstadoReparacion');
    }

    public function scopeEstados($query)
    {
        //se hace esto porque según la referencia, belongsToMany->get() siempre devuelve vacío
        return $query->with('estadosReparacion');
    }

    public function estadoActual()
    {
        //la idea es que haya solo un estadoActual con flag=1, pero puede devolver una lista
        return $this->estadosReparacion()->withPivot('es_estado_actual', 'fecha_registro')->wherePivot('es_estado_actual', 1)->get()->all();
    }

    public function valuaciones()
    {
        return $this->hasMany('App\Modelos\Valuacion', 'id_recepcion_ot');
    }

    public function ultValuacion()
    {
        return $this->valuaciones()->orderBy('fecha_registro', 'desc')->first();
    }

    public function otCerrada()
    {
        return $this->hasMany('App\Modelos\OTCerrada', 'id_recepcion_ot');
    }

    public function reparaciones()
    {
        return $this->hasMany('App\Modelos\Reparacion', 'id_recepcion_ot');
    }

    public function ultReparacion()
    {
        return $this->reparaciones()->orderBy('fecha_registro', 'desc')->first();
    }

    public function necesidadesRepuestos()
    {
        return $this->getHojaTrabajo()->necesidadesRepuestos();
    }

    public function getAllItemsNecesidadRepuestos()
    {
        $necesidadesRepuestos = $this->necesidadesRepuestos()->with('itemsNecesidadRepuestos')->get()->all();
        $listaItems = [];
        foreach ($necesidadesRepuestos as $key => $necesidadRepuestos) {
            $listaItems = array_merge($listaItems, $necesidadRepuestos->itemsNecesidadRepuestos->all());
        }

        // $cotizaciones = $this->cotizaciones()->with('hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos')->get()->all();
        // foreach ($cotizaciones as $key => $cotizacion) {
        //     $listaItems = array_merge($listaItems, $cotizacion->getAllItemsNecesidadRepuestos());
        // }

        return $listaItems;
    }

    public function detallesEnProceso()
    {
        return $this->ultReparacion()->detallesEnProceso();
    }

    public function hojasInspeccion()
    {
        return $this->hasMany('App\Modelos\HojaInspeccion', 'id_recepcion_ot');
    }

    public function hojasInventario()
    {
        return $this->hasMany('App\Modelos\HojaInventario', 'id_recepcion_ot');
    }

    public function esInspeccionable()
    {
        //return $this->hojasInspeccion()->count()==0;
        return true;
        $hojasInspeccion = $this->hojasInspeccion()->where(function ($query) {
            $query->lineasHojaInspecion()->havingRaw('COUNT(*) > ');
        })->get()->all();

        return $hojasInspeccion ? true : false;
    }

    public function tieneInspeccion()
    {
        $ultHojaInspeccion = $this->hojasInspeccion()->orderBy('fecha_registro', 'desc')->first();
        return $ultHojaInspeccion == true;
    }

    public function tieneInventario()
    {
        return $this->hojasInventario()->count() > 0;
    }

    public function esInventariable()
    {
        return $this->hojasInventario()->count() == 0;
        return true;
        //$this->hojasInventario()->where('');
    }

    public function entregas()
    {
        return $this->hasMany('App\Modelos\EntregadoReparacion', 'id_recepcion_ot');
    }

    public function ultEntrega()
    {
        return $this->entregas()->orderBy('fecha_registro', 'desc')->first();
    }

    public function fechaUltEntrega()
    {
        $ult = $this->entregas()->orderBy('fecha_registro', 'desc')->first();
        if (!is_null($ult)) {
            $formato = 'd/m/Y';
            return Carbon::parse($ult->fecha_entrega)->format($formato);
        }
    }

    public function fechaCierreFormat()
    {
        if ($this->esGarantia()) {
            $fecha = $this->fecha_nota_entrega;
            if (!is_null($fecha)) return (new Carbon($fecha))->format('d/m/Y');
            return '-';
        } else {
            $cierre = $this->otCerrada()->orderBy('fecha_registro', 'desc')->first();
            return $cierre != null ? (new Carbon($cierre->fecha_registro))->format('d/m/Y') : '-';
        }
    }

    public function tecnicoReparacion()
    {
        return $this->hasOne('App\Modelos\TecnicoReparacion', 'id_tecnico', 'id_tecnico_asignado');
    }

    public function getNombreTecnicoAsignado()
    {
        $tecnico = $this->tecnicoReparacion()->first();
        return $tecnico ? $tecnico->nombre_tecnico : '-';
    }

    public function actual()
    {
        return $this->estadosReparacion()->withPivot('es_estado_actual', 'fecha_registro')->wherePivot('es_estado_actual', 1)->get()->first();
    }

    public function getEstadoTrabajo()
    {
        $otCerrada = $this->otCerrada->first();
        $entrega = $this->entregas->first();

        $estado = $this->estadoActual()[0]->nombre_estado_reparacion_interno;

        if ($otCerrada) {
            return 'CERRADA';
        } elseif ($entrega) {
            return 'FACTURADA';
        } else {
            if ($estado === 'garantia_cerrado') {
                return 'CERRADA';
            }
            return 'ABIERTA';
        }
    }

    public function cambiarEstado($estado)
    {
        $envio_correo = 0;

        $estadoCompleto = EstadoReparacion::porNombreInterno($estado)->first();
        if (in_array($estado, [
            'espera_traslado', 'espera_valuacion', //registrado
            'espera_aprobacion', 'espera_aprobacion_ampliacion', //aprobado por seguro
            'espera_asignacion', //aprobado por cliente
            'espera_reparacion', 'espera_reparacion_hotline', 'espera_reparacion_ampliacion', 'espera_reparacion_ampliacion_hotline', //inicio operativo
            'vehiculo_listo', //se está descartando vehiculos listos en hotline
            'entregado', 'entregado_pt'
        ]))
            $envio_correo = 1;

        if ($estadoCompleto) {
            $id_estado = $estadoCompleto->id_estado_reparacion;
        } else {
            return;
        }

        //Se limpia el último estado
        DB::table('recepcion_ot_estado_reparacion')->where('id_recepcion_ot', $this->id_recepcion_ot)->update(['es_estado_actual' => 0]);
        //Se setea el nuevo estado
        $this->estadosReparacion()->attach($id_estado, ['es_estado_actual' => 1]);

        $fechaEntrega = null;
        $horaEntrega = null;
        $fechaVehiculoListo = null;
        $horaVehiculoListo = null;
        $fechaInicioOperativo = null;
        $horaInicioOperativo = null;
        $fechaAprobacionCliente = null;
        $horaAprobacionCliente = null;
        $fechaAprobacionSeguro = null;
        $horaAprobacionSeguro = null;
        $esParticular = $this->esParticular();
        $fechaIngreso = null;
        $horaIngreso = null;
        $fechaLiquidacion = null;

        switch ($estado) {
            case 'entregado':
            case 'entregado_pt':
                $entrega  = $this->ultEntrega();
                $fechaEntrega = date('d/m/y', strtotime($entrega->fecha_entrega));
                $fechaRegistroEntrega = strtotime($entrega->fecha_registro);

                if ($fechaEntrega == date('d/m/y', $fechaRegistroEntrega))
                    $horaEntrega = date('h:i a', $fechaRegistroEntrega);
            case 'vehiculo_listo':
                $reparacion = $this->ultReparacion();
                $fechaVehiculoListo = date('d/m/y', strtotime($reparacion->fecha_fin_operativo));
                $fechaRegistroVehiculoListo = strtotime($reparacion->fecha_registro_fin_operativo);

                if ($fechaVehiculoListo == date('d/m/y', $fechaRegistroVehiculoListo))
                    $horaVehiculoListo = date('h:i a', $fechaRegistroVehiculoListo);
            case 'espera_reparacion':
            case 'espera_reparacion_hotline':
            case 'espera_reparacion_ampliacion':
            case 'espera_reparacion_ampliacion_hotline':
                //En caso de ampliacion, igual se tiene la misma reparacion
                $reparacion = $this->ultReparacion();
                $fechaInicioOperativo = date('d/m/y', strtotime($reparacion->fecha_inicio_operativo));
                $fechaRegistroInicioOperativo = strtotime($reparacion->fecha_registro);

                if ($fechaInicioOperativo == date('d/m/y', $fechaRegistroInicioOperativo))
                    $horaInicioOperativo = date('h:i a', $fechaRegistroInicioOperativo);
                if (in_array($this->getHojaTrabajo()->tipo_trabajo, ['PREVENTIVO', 'CORRECTIVO']))
                    break;
            case 'espera_asignacion':
                if ($this->getHojaTrabajo()->tipo_trabajo == 'DYP') {
                    $valuacion = $this->ultValuacion();
                    $fechaAprobacionCliente = date('d/m/y', strtotime($valuacion->fecha_aprobacion_cliente));
                    $fechaRegistroAprobacionCliente = strtotime($valuacion->fecha_registro_aprobacion_cliente);

                    if ($fechaAprobacionCliente == date('d/m/y', $fechaRegistroAprobacionCliente))
                        $horaAprobacionCliente = date('h:i a', $fechaRegistroAprobacionCliente);
                }
            case 'reparacion_mecanica':
            case 'reparacion_carroceria':
            case 'reparacion_preparacion':
            case 'reparacion_pintura':
            case 'reparacion_armado':
            case 'reparacion_pulido':
            case 'espera_control_calidad':
                if ($this->ultAmpliacion()) {
                    $ampliacion = $this->ultAmpliacion();
                    $valuacion = $this->ultValuacion();
                    $fechaAprobacionCliente = date('d/m/y', strtotime($ampliacion->fecha_aprobacion_cliente_amp));
                    $fechaRegistroAprobacionCliente = strtotime($valuacion->fecha_registro_aprobacion_cliente);

                    if ($fechaAprobacionCliente == date('d/m/y', $fechaRegistroAprobacionCliente))
                        $horaAprobacionCliente = date('h:i a', $fechaRegistroAprobacionCliente);
                }

                if (in_array($this->getHojaTrabajo()->tipo_trabajo, ['PREVENTIVO', 'CORRECTIVO']))
                    break;
            case 'espera_aprobacion':
            case 'espera_aprobacion_ampliacion':
                $valuacion = $this->ultValuacion();
                if (!$esParticular) {
                    //falta considerar ampliacion
                    if ($this->esAmpliacion()) {
                        $ampliacion = $this->ultAmpliacion();
                        $fechaAprobacionSeguro = date('d/m/y', strtotime($ampliacion->fecha_aprobacion_seguro_amp));
                        $fechaRegistroAprobacionSeguro = strtotime($valuacion->fecha_registro_aprobacion_seguro_amp);
                    } else {
                        $fechaAprobacionSeguro = date('d/m/y', strtotime($valuacion->fecha_aprobacion_seguro));
                        $fechaRegistroAprobacionSeguro = strtotime($valuacion->fecha_registro_aprobacion_seguro);
                    }

                    if ($fechaAprobacionSeguro == date('d/m/y', $fechaRegistroAprobacionSeguro))
                        $horaAprobacionSeguro = date('h:i a', $fechaRegistroAprobacionSeguro);
                }
                # code...
            default:
                $recepcion = $this->getHojaTrabajoUpdated();
                $fechaIngreso = date('d/m/y', strtotime($recepcion->fecha_recepcion));
                $fechaRegistroIngreso = strtotime($recepcion->fecha_registro);
                if ($fechaIngreso == date('d/m/y', $fechaRegistroIngreso))
                    $horaIngreso = date('h:i a', $fechaRegistroIngreso);
                break;
        }
        if ($envio_correo) {
            //------------------------------ENVIO DE CORREO--------------------------------------------------
            // $fecha_registro = (new Carbon($this->hojaTrabajo->fecha_registro))->locale('es')->isoFormat('DD/MM/YYYY HH:mm:ss');
            // $fecha_estado = Carbon::now()->locale('es')->isoFormat('DD MMM YYYY hh:mm A');
            // $fecha_estado_corto = Carbon::now()->locale('es')->isoFormat('DD MMM YY');
            // $data = array(  'nombre_estado'=>(EstadoReparacion::find($id_estado)->nombre_estado_reparacion) , 
            //                 'nroOT' => ($this->getNroOT()) ,
            //                 'nro_placa' => ($this->placa_auto),
            //                 'modelo_auto' => ($this->hojaTrabajo->getModeloVehiculo()),
            //                 'fecha_registro' => ($fecha_registro),
            //                 'fecha_estado' => ($fecha_estado),
            //                 'fecha_estado_corto' => ($fecha_estado_corto)
            //             );

            $data = array(
                'fecIngreso'        => ($fechaIngreso),
                'horaIngreso'       => ($horaIngreso),
                'esParticular'      => ($esParticular),
                'fecAprSeguro'      => ($fechaAprobacionSeguro),
                'horaAprSeguro'     => ($horaAprobacionSeguro),
                'fecAprCliente'     => ($fechaAprobacionCliente),
                'horaAprCliente'    => ($horaAprobacionCliente),
                'fecIniRep'         => ($fechaInicioOperativo),
                'horaIniRep'        => ($horaInicioOperativo),
                'fecVehListo'       => ($fechaVehiculoListo),
                'fecEntrega'        => ($fechaEntrega),
                'horaEntrega'       => ($horaEntrega),
                'showLink'          => (true)
            );
            if (config('app.send_mail')) {
                Mail::send(['html' => 'emails.emailTrackingWeb'], $data, function ($message) {
                    $message->to($this->getHojaTrabajo()->getCorreoCliente())
                        ->subject('AUTOLAND: ACTUALIZACIÓN DE ESTADO');
                    $message->from(env('MAIL_USERNAME'), 'Autoland');
                });
            }

            //-----------------------------------------------------------------------------------------------
        }
    }

    public function reAbrirOT()
    {
        $estado = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if (in_array($estado, ['liquidado', 'liquidado_hotline'])) {

            if (in_array($estado, ['liquidado'])) $this->cambiarEstado('vehiculo_listo');
            else if (in_array($estado, ['liquidado_hotline'])) $this->cambiarEstado('vehiculo_listo_hotline');
            $this->liquidacion_hh_car = null;
            $this->liquidacion_hh_mec = null;
            $this->liquidacion_pintura = null;
            $this->liquidacion_deducible = null;
            $this->liquidacion_deducible_es_porcentaje = null;
            $this->fecha_liquidacion = null;
            $this->save();
            $detallesTrabajo = $this->getDetallesTrabajoCompleto();
            foreach ($detallesTrabajo as $key => $detalleTrabajo) {
                if ($detalleTrabajo->valor_trabajo_pre_liquidacion != null) {
                    $detalleTrabajo->valor_trabajo_estimado = $detalleTrabajo->valor_trabajo_pre_liquidacion;
                    $detalleTrabajo->valor_trabajo_pre_liquidacion = null;
                    $detalleTrabajo->save();
                }
            }
        }
        if (in_array($estado, ['garantia_cerrado'])) {
            $this->cambiarEstado('vehiculo_listo');
            $this->save();
        }
    }

    public function esEditableOt()
    {
        $estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if ($estado_actual === 'garantia_cerrado') return false;
        else {
            $noEstaLiquidado = $estado_actual != 'liquidado' && $estado_actual != 'liquidado_hotline';
            return is_null($this->ultEntrega()) && $this->otCerrada->isEmpty() && $noEstaLiquidado;
        }
    }

    public function sePuedeGenerarLiquidacion($esPreliquidacion = false)
    {
        if (in_array($this->estadoActual()[0]->nombre_estado_reparacion_interno, $esPreliquidacion ? ['vehiculo_listo', 'vehiculo_listo_hotline'] : ['vehiculo_listo', 'vehiculo_listo_hotline'])) {
            if ($this->tieneServiciosTercerosSinOrdenServicio()) return false;
            $necesidadRepuestos = $this->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
            if ($necesidadRepuestos) {
                $cantidadRepuestosSinCodigo = $necesidadRepuestos->getSinCodigo();
                if ($cantidadRepuestosSinCodigo > 0) return false;
                $cantidadRepuestosNoEntregados = $necesidadRepuestos->getNoEntregados();

                if ($cantidadRepuestosNoEntregados == 0) return true;
                $cantidadRepuestosEnTransito = $necesidadRepuestos->getEnTransito();
                $cantidadRepuestosImportados = $necesidadRepuestos->getImportados();
                if (($cantidadRepuestosEnTransito + $cantidadRepuestosImportados) == $cantidadRepuestosNoEntregados) return true;
            }
            return true;
        } else return false;
    }

    public function convertirAHotline()
    {
        if ($this->estadoActual()) {
            $estadoActual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
            if ($estadoActual == 'espera_asignacion') {
                $this->cambiarEstado('hotline');
            } elseif ($estadoActual == 'espera_reparacion') {
                $this->cambiarEstado('espera_reparacion_hotline');
            } elseif ($estadoActual == 'paralizado') {
                $this->cambiarEstado('paralizado_hotline');
            } elseif ($estadoActual == 'espera_control_calidad') {
                $this->cambiarEstado('espera_control_calidad_hotline');
            } elseif ($estadoActual == 'vehiculo_listo') {
                $this->cambiarEstado('vehiculo_listo_hotline');
            } elseif (strpos($estadoActual, "reparacion_") === 0) {
                $nombre_estado_nuevo = $estadoActual . "_hotline";
                $this->cambiarEstado($nombre_estado_nuevo);
            }
        }
    }

    public function revertirHotline()
    {
        if ($this->estadoActual()) {
            $nombre_estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
            if ($nombre_estado_actual == 'hotline') {
                $this->cambiarEstado('espera_asignacion');
            } elseif ($nombre_estado_actual == 'espera_reparacion_hotline') {
                $this->cambiarEstado('espera_reparacion');
            } elseif ($nombre_estado_actual == 'paralizado_hotline') {
                $this->cambiarEstado('paralizado');
            } elseif ($nombre_estado_actual == 'espera_control_calidad_hotline') {
                $this->cambiarEstado('espera_control_calidad');
            } elseif ($nombre_estado_actual == 'vehiculo_listo_hotline') {
                $this->cambiarEstado('vehiculo_listo');
            } elseif ($nombre_estado_actual == 'entregado_hotline') {
                $this->cambiarEstado('entregado');
            } elseif (
                strpos($nombre_estado_actual, "reparacion_") === 0
                && strpos($nombre_estado_actual, "_hotline") !== false
            ) {
                $nombre_estado_nuevo = str_replace("_hotline", "", $nombre_estado_actual);
                $this->cambiarEstado($nombre_estado_nuevo);
            }
        }
    }

    public function reiniciarProcesoReparacionTecnicos()
    {
        $estadoActual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if (strpos($estadoActual, "reparacion_") === false && strpos($estadoActual, "espera_control_calidad") === false)
            return null;

        // $this->detallesEnProceso()->where('es_etapa_finalizada',0)->update(['es_etapa_finalizada' => null]);

        // $finalizados = $this->detallesEnProceso()->where('es_etapa_finalizada',1)->get();
        // foreach ($finalizados as $key => $finalizado) {
        //     $nuevoDetalleEnProceso = $finalizado->replicate();
        //     unset($nuevoDetalleEnProceso->fecha_registro);
        //     $nuevoDetalleEnProceso->es_etapa_finalizada = null;
        //     $nuevoDetalleEnProceso->fecha_fin_etapa = null;
        //     $nuevoDetalleEnProceso->save();
        // }

        $this->id_tecnico_asignado = null;
        $this->save();

        // $reparacion = $this->ultReparacion();
        // $reparacion->fecha_fin_operativo = null;
        // $reparacion->save();

        $reparacion = new Reparacion();
        $reparacion->id_recepcion_ot = $this->id_recepcion_ot;
        $reparacion->save();

        if ($estadoActual == 'espera_control_calidad' || strpos($estadoActual, "reparacion_") === 0) {
            $this->cambiarEstado('espera_reparacion');
        } elseif (
            $estadoActual == 'espera_control_calidad_hotline' ||
            (strpos($estadoActual, "reparacion_") === 0 && strpos($estadoActual, "_hotline") !== false)
        ) {
            $this->cambiarEstado('espera_reparacion_hotline');
        }
    }

    public function montoTotal()
    {
        $aux = $this->ultValuacion();
        if ($aux) {
            if ($aux->valor_mano_obra || $aux->valor_repuestos || $aux->valor_terceros) {
                $total = 0;
                if ($aux->valor_mano_obra) {
                    $total += $aux->valor_mano_obra;
                }
                if ($aux->valor_repuestos) {
                    $total += $aux->valor_repuestos;
                }
                if ($aux->valor_terceros) {
                    $total += $aux->valor_terceros;
                }

                return $total;
            }
            return '-';
        }
        return '-';
    }

    public function fechaPromesa()
    {
        $aux1 = $this->ultReparacion();
        if ($aux1) {
            $aux2 = $aux1->ultFechaPromesa();
            if ($aux2) {
                return $aux2->fecha_promesa;
            }
            return '-';
        } elseif ($this->fecha_entregar) {
            return $this->fecha_entregar;
        }

        return '-';
    }

    public function fechaPromesaStr()
    {
        $aux1 = $this->ultReparacion();
        if ($aux1) {
            $aux2 = $aux1->ultFechaPromesa();
            if ($aux2) {
                return Carbon::createFromFormat('d/m/Y', $aux2->fecha_promesa);
            }
            return '-';
        }
        return '-';
    }

    public function fechaValuacion()
    {
        $aux1 = $this->ultValuacion();
        if ($aux1) {
            $aux2 = $aux1->fecha_valuacion;
            if ($aux2) {
                return $aux2;
            }
            return '-';
        }
        return '-';
    }

    public function primeraFechaPromesa()
    {
        //solo esta siendo utilizada en la vista Recepcion
        $aux1 = $this->ultReparacion();
        if ($aux1) {
            $aux2 = $aux1->primeraFechaPromesa();
            if ($aux2) {
                return $aux2->fecha_promesa;
            }
            return '-';
        }
        return '-';
    }

    public function primeraFechaStr()
    {
        $aux1 = $this->ultReparacion();
        if ($aux1) {
            $aux2 = $aux1->primeraFechaPromesa();
            if ($aux2) {
                return Carbon::createFromFormat('d/m/Y', $aux2->fecha_promesa);
            }
            return '-';
        }
        return '-';
    }


    public function excludeAcent($word)
    {
        $vocals = ["Á" => "a", "É" => "e", "Í" => "i", "Ó" => "o", "Ú" => "u"];
        foreach (array_keys($vocals) as $vocal) {
            $word = str_replace($vocal, $vocals[$vocal], $word);
        }
        return strtolower($word);
    }

    public function status_clase($name)
    {
        $name = $this->excludeAcent($name);
        // $vocals = ["Á" => "a", "É" => "e", "Í" => "i", "Ó" => "o", "Ú" => "u"];
        // foreach (array_keys($vocals) as $vocal) {
        //     $name = str_replace($vocal, $vocals[$vocal], $name);
        // }
        return 'estado-' . str_replace("_", "-", strtolower($name));
    }

    public function claseEstado()
    {
        $estado = $this->estadoActual();

        if ($estado) {
            $nombre_interno_estado = $estado[0]->nombre_estado_reparacion_interno;
            switch ($nombre_interno_estado) {
                case "espera_traslado":
                    return 'estado estado-borde estado-traslado';
                    break;
                case "espera_valuacion":
                    return 'estado estado-borde estado-esp-valuacion';
                    break;
                case "rechazado":
                    return 'estado estado-rechazado';
                    break;
                case "perdida_total":
                    return 'estado estado-perdida';
                    break;
                case "entregado_pt":
                    return 'estado estado-entregado';
                    break;
                case "espera_aprobacion_seguro":
                case "espera_aprobacion_seguro_ampliacion":
                case "espera_aprobacion":
                case "espera_aprobacion_ampliacion":
                    return 'estado estado-borde estado-esp-aprobacion';
                    break;
                case "espera_asignacion":
                    return 'estado estado-borde estado-esp-asignacion';
                    break;
                case "hotline":
                    return 'estado estado-hotline';
                    break;
                case "paralizado":
                case "paralizado_hotline":
                    return 'estado estado-paralizado';
                    break;
                case "espera_reparacion":
                case "espera_reparacion_hotline":
                    return 'estado estado-esp-reparacion';
                    break;
                case "espera_control_calidad":
                case "espera_control_calidad_hotline":
                    return "estado estado-borde estado-esp-control-calidad";
                    break;
                case "vehiculo_listo":
                case "vehiculo_listo_hotline":
                    return 'estado estado-listo';
                    break;
                case "liquidado":
                case "liquidado_hotline":
                    return 'estado estado-liquidado';
                    break;
                case "entregado":
                case "entregado_hotline":
                    return 'estado estado-entregado';
                    break;
                    //15
                case "espera_valuacion_ampliacion":
                    return 'estado estado-ampliacion';
                    break;
            }

            if (strpos($nombre_interno_estado, "reparacion_") === 0) {
                $nombre_etapa = str_replace("_hotline", "", str_replace("reparacion_", "", $nombre_interno_estado));
                if ($this->detalleEnProcesoEsActual($nombre_etapa)) {
                    if ($nombre_etapa === "mecanica") return "estado estado-etapa-reparacion-progreso-mecanica";
                    return "estado estado-etapa-reparacion-progreso";
                } elseif ($this->detalleEnProcesoEsFinalizado($nombre_etapa)) {
                    return "estado estado-etapa-reparacion-finalizado";
                }
            }
        } else {
            return '';
        }
    }

    public function esParticular()
    {
        return ($this->id_cia_seguro == 1 ? true : false);
    }

    public function getLinkDetalleHTML()
    {
        $nombreRutaDetalleOT = $this->hojaTrabajo->tipo_trabajo == 'DYP' ? self::$nombreRutaDetalleOTDYP : self::$nombreRutaDetalleOTMEC;

        $ruta = route($nombreRutaDetalleOT, [self::$detalleOTRouteKey => $this->id_recepcion_ot]);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_recepcion_ot</a>";
    }
    public function getLinkDetalleHTML2($es_link = true)
    {
        $nombreRutaDetalleOT = $this->hojaTrabajo->tipo_trabajo == 'DYP' ? self::$nombreRutaDetalleOTDYP : self::$nombreRutaDetalleOTMEC;

        $ruta = route($nombreRutaDetalleOT, [self::$detalleOTRouteKey => $this->id_recepcion_ot]);
        if ($es_link) $link = "<a class='id-link' href='$ruta' target='_blank'>OT $this->id_recepcion_ot</a>";
        else $link = "OT $this->id_recepcion_ot";

        return $link;
    }

    public function seccion()
    {
        $seccion = $this->hojaTrabajo->tipo_trabajo == 'DYP' ? 'B&P' : 'MEC';

        return $seccion;
    }

    public function esEsperaTraslado()
    {
        if ($this->estadoActual() != [])
            return $this->estadoActual()[0]->nombre_estado_reparacion_interno == "espera_traslado";
        return false;
    }

    public function fechaTraslado()
    {
        return $this->fecha_traslado;
    }

    public function fechaAprobacion()
    {
        $ampliacion = $this->ultAmpliacion();
        if ($ampliacion) {
            return $ampliacion->fecha_aprobacion_cliente_amp;
        } else {
            return $this->ultValuacion()->fecha_aprobacion_cliente;
        }
    }

    public function esHotLine()
    {
        if (!$this->estadoActual()) {
            //No hay un estado actual para la OT en cuestion
            return false;
        }
        return $this->estadoActual()[0]->nombre_estado_reparacion_interno == "hotline";
    }

    public function estiloEsHotline()
    {
        $estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if (strpos($estado_actual, "hotline") !== false) {
            return "hotline";
        } else {
            return "";
        }
    }

    public function esProcesoHotLine()
    {
        if (!$this->estadoActual()) {
            //No hay un estado actual para la OT en cuestion
            return false;
        }
        return $this->estadoActual()[0]->nombre_estado_reparacion_interno == "espera_reparacion_hotline";
    }


    public function getHistoriaClinica()
    {

        $hojaTrabajo = $this->getHojaTrabajo();

        $placa = $hojaTrabajo->placa_auto;

        $hojasTrabajo = HojaTrabajo::has('recepcionOT')->with([
            'recepcionOT',
            'detallesTrabajo'
        ])->where(
            'placa_auto',

            $placa
        )->where('fecha_registro', '<', $hojaTrabajo->fecha_registro)->get();
        $hojasTrabajo = $hojasTrabajo->filter(function ($value, $key) {

            $recepcionOT = $value->recepcionOT;

            return in_array(
                $recepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno,

                ["entregado", "entregado_pt", "entregado_hotline"]
            );
        });

        return $hojasTrabajo;
    }


    public function getHistoriaClinicaDoc()
    {

        $hojaTrabajo = $this->getHojaTrabajo();

        $nroDoc = $hojaTrabajo->doc_cliente;

        $hojasTrabajo = HojaTrabajo::has('recepcionOT')->with(['recepcionOT', 'detallesTrabajo'])->where(
            'doc_cliente',

            $nroDoc
        )->where('fecha_registro', '<', $hojaTrabajo->fecha_registro)->get();
        $hojasTrabajo = $hojasTrabajo->filter(function ($value, $key) {

            $recepcionOT = $value->recepcionOT;

            return in_array(
                $recepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno,

                ["entregado", "entregado_pt", "entregado_hotline"]
            );
        });

        return $hojasTrabajo;
    }


    public function getHistoriaClinicaDetallesTrabajo()
    {
        $placa = $this->getHojaTrabajo()->placa_auto;
        $detallesTrabajo = DetalleTrabajo::whereHas('hojaTrabajo', function ($query) use ($placa) {
            $query->where('placa_auto', $placa);
        })->has('hojaTrabajo.recepcionOT')->with(['hojaTrabajo.recepcionOT'])->get();

        return $detallesTrabajo;
    }

    public function ultEstadoNoHotline()
    {
        return $this->estadosReparacion()->where('estado_reparacion.nombre_estado_reparacion_interno', '!=', 'hotline')
            ->orderBy('fecha_registro', 'desc')->first();
    }

    public function ultEstadoNoEnCargo()
    {
        return $this->estadosReparacion()->where('estado_reparacion.nombre_estado_reparacion_interno', '!=', 'rechazado')
            ->orderBy('fecha_registro', 'desc')->first();
    }

    public function ultEstadoNoAmpliacion()
    {
        return $this->estadosReparacion()->where('nombre_estado_reparacion_interno', 'NOT LIKE', "%_ampliacion")
            ->orderBy('fecha_registro', 'desc')->first();
    }

    public function cantDiasSemaforo()
    {
        $estado = $this->estadoActual()[0];

        if ($estado && $estado->nombre_estado_reparacion_interno == 'espera_valuacion') {
            $fecha_registro_estado = $this->getHojaTrabajo()->fecha_recepcion;
        } elseif ($estado && $estado->nombre_estado_reparacion_interno == 'espera_aprobacion_seguro') {
            $fecha_registro_estado = $this->ultValuacion()->fecha_valuacion;
        } elseif ($estado && $estado->nombre_estado_reparacion_interno == 'espera_aprobacion') {
            if ($this->esParticular()) {
                $fecha_registro_estado = $this->ultValuacion()->fecha_valuacion;
            } else {
                $fecha_registro_estado = $this->ultValuacion()->fecha_aprobacion_seguro;
            }
        } elseif ($estado && $estado->nombre_estado_reparacion_interno == 'espera_asignacion') {
            $fecha_registro_estado = $this->ultValuacion()->fecha_aprobacion_cliente;
        } elseif ($estado && in_array($estado->nombre_estado_reparacion_interno, ['vehiculo_listo', 'vehiculo_listo_hotline'])) {
            $fecha_registro_estado = $this->ultReparacion()->fecha_fin_operativo;
        } else {
            $fecha_registro_estado = $estado->pivot->fecha_registro;
        }


        $cant_dias_dif = Carbon::now()->diffInDays($fecha_registro_estado);

        return $cant_dias_dif;
    }

    public function colorSemaforo()
    {
        $estado = $this->estadoActual()[0];

        $cant_dias_dif = $this->cantDiasSemaforo();
        $semaforo = $estado->semaforos()->where('tope_cantidad_dias', '>', $cant_dias_dif)->orderBy('tope_cantidad_dias')->first();

        if ($semaforo) {
            if ($semaforo->color_css == "green" || $semaforo->color_css == "red")
                return $semaforo->color_css . "; color:white";
            else
                return $semaforo->color_css;
        } else {
            return 'transparent';
        }
    }

    public function colorSemaforoTecnicos()
    {
        $cantHoras = 0;
        $ultReparacion = $this->ultReparacion();
        $departamento = ($this->hojaTrabajo->tipo_trabajo == 'DYP' ? 'DYP' : 'MEC');
        $ultDetalleProceso = $ultReparacion->detallesEnProceso()->orderBy('fecha_registro', 'desc')->first();
        $tecnico = TecnicoReparacion::find($this->id_tecnico_asignado);
        $cantTecnicoEnProceso = $tecnico ? $tecnico->reparacionesEnProceso()->count() : 0;

        if (!$ultDetalleProceso) {
            $horaInicio = Carbon::parse($ultReparacion->fecha_inicio_operativo);
            $tiempoTranscurrido = ($horaInicio->isOpen()) ? Carbon::now()->diffInBusinessHours($horaInicio) : Carbon::now()->diffInHours($horaInicio);

            if ($tiempoTranscurrido >= 1 && $cantTecnicoEnProceso == 0) {
                return 'yellow';
            } else {
                return 'transparent';
            }
        }

        $tiempoTranscurrido = $ultReparacion->getTiempoTranscurridoTecnicos();

        if ($departamento == 'DYP') {
            $horasTotal = $this->hojaTrabajo->getSumaHorasMecanicaColision() + $this->hojaTrabajo->getSumaHorasCarroceria() + $this->hojaTrabajo->getSumaPanhosPintura() * 2.5;
        } elseif ($departamento == 'MEC') {
            $horasTotal = $this->hojaTrabajo->getSumaHorasMecanica();
        } else {
            return 'transparent';
        }

        if ($tiempoTranscurrido > $horasTotal) {
            return 'red';
        } else {
            return 'green';
        }
    }

    public function tipoDanhoTemp()
    {
        $id_marca_auto = $this->getHojaTrabajo()->getIdMarcaAuto();
        $id_cia_seguro = $this->ciaSeguro ? $this->ciaSeguro()->first()->id_cia_seguro : null;

        if (!$id_cia_seguro)
            return '-';
        # code...
        $tipo_danho_rptos = DB::table('tipo_danho_temp')->where('id_marca_auto', 0)->where('id_cia_seguro', 0)->first();
        $tipo_danho = DB::table('tipo_danho_temp')->where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $id_cia_seguro)->first();
        $nombre_estado = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if ($this->ultValuacion() && !in_array($nombre_estado, ["rechazado", 'perdida_total', "espera_valuacion"]) && strpos($nombre_estado, "espera_aprobacion") === false) {
            $valor_repuestos = $this->ultValuacion()->valor_repuestos ? $this->ultValuacion()->valor_repuestos : 0;
            $valor_mo = ($this->ultValuacion()->valor_mano_obra ? $this->ultValuacion()->valor_mano_obra : 0) + ($this->ultValuacion()->valor_terceros ? $this->ultValuacion()->valor_terceros : 0);
            if ($valor_repuestos == 0) {
                //puede ser express
                if ($valor_mo <= $tipo_danho->limite_inf_leve)
                    return "EXPRESS";
                elseif ($valor_mo <= $tipo_danho->limite_inf_medio) {
                    return "LEVE";
                } elseif ($valor_mo <= $tipo_danho->limite_inf_fuerte) {
                    return "MEDIO";
                } elseif ($valor_mo > $tipo_danho->limite_inf_fuerte) {
                    return "FUERTE";
                }
            } elseif ($valor_repuestos > 0) {
                $total = $valor_mo + $valor_repuestos;
                if ($total <= ($tipo_danho->limite_inf_medio + $tipo_danho_rptos->limite_inf_medio)) {
                    return "LEVE";
                } elseif ($total <= ($tipo_danho->limite_inf_fuerte + $tipo_danho_rptos->limite_inf_fuerte)) {
                    return "MEDIO";
                } elseif ($total > ($tipo_danho->limite_inf_fuerte + $tipo_danho_rptos->limite_inf_fuerte)) {
                    return "FUERTE";
                }
            }
        }

        return "-";
    }

    public function claseCSSTipoDanhoTemp()
    {
        $tipoDanho = $this->tipoDanhoTemp();

        switch ($tipoDanho) {
            case 'EXPRESS':
                return 'tipo-danho tipo-danho-express font-weight-bold';
                break;
            case 'LEVE':
                return 'tipo-danho tipo-danho-leve font-weight-bold';
                break;
            case 'MEDIO':
                return 'tipo-danho tipo-danho-medio font-weight-bold';
                break;
            case 'FUERTE':
                return 'tipo-danho tipo-danho-fuerte font-weight-bold';
                break;
        }
    }

    public function nroRepuestosStock()
    {
        $necesidadesRptos = $this->necesidadesRepuestos()->get();
        $cantidad = 0;
        if ($necesidadesRptos) {
            foreach ($necesidadesRptos as $key => $necesidadRptos) {
                $cantidad += $necesidadRptos->itemsNecesidadRepuestos()->where('es_importado', 0)->count();
            }
            return $cantidad == 0 ? "-" : $cantidad;
        } else {
            return "-";
        }
    }

    public function nroRepuestosHotline()
    {
        $necesidadesRptos = $this->necesidadesRepuestos()->get();
        $cantidad = 0;
        if ($necesidadesRptos) {
            foreach ($necesidadesRptos as $key => $necesidadRptos) {
                $cantidad += $necesidadRptos->itemsNecesidadRepuestos()->where('es_importado', 1)->count();
            }
            return $cantidad == 0 ? "-" : $cantidad;
        } else {
            return "-";
        }
    }

    public function detalleEnProcesoDisponible($etapa)
    {
        //Este metodo indicará cuando todos los detalles estén pendientes (ninguno por finalizar)
        //y que el detalle en cuestion no este registrado
        if (
            $this->detallesEnProceso()->where('es_etapa_finalizada', 0)->count() == 0
            && $this->detallesEnProceso()->where('etapa_proceso', $etapa)->whereNotNull('es_etapa_finalizada')->count() == 0
        )
            return true;
        else
            return false;
    }

    public function detalleEnProcesoEsActual($etapa)
    {
        //Este metodo verifica que la etapa esté registrada y que sea la única que está pendiente
        $etapaEnProceso = $this->detallesEnProceso()->where('etapa_proceso', $etapa)->orderBy('fecha_registro', 'desc')->first();
        if (
            $etapaEnProceso
            //&& $this->detallesEnProceso()->where('es_etapa_finalizada',0)->count() == 1
            && $etapaEnProceso->es_etapa_finalizada == 0
        )
            return true;
        else
            return false;
    }

    public function detalleEnProcesoEsFinalizado($etapa)
    {
        //Este metodo verifica que la etapa esté registrada y que sea la única que está pendiente
        $etapaEnProceso = $this->detallesEnProceso()->where('etapa_proceso', $etapa)->orderBy('fecha_registro', 'desc')->first();
        if (
            $etapaEnProceso
            && $etapaEnProceso->es_etapa_finalizada == 1
        )
            return true;
        else
            return false;
    }

    public function detalleEnProcesoEsBloqueado($etapa)
    {
        //Si existe una etapa que está sin finalizar y además es diferente a la etapa en cuestión, está bloqueado
        $etapaEnProceso = $this->detallesEnProceso()->where('es_etapa_finalizada', 0)->orderBy('fecha_registro', 'desc')->first();
        if (
            $etapaEnProceso
            && $etapaEnProceso->etapa_proceso != $etapa
        )
            return true;
        else
            return false;
    }

    public function esEsperaControlCalidad()
    {
        if ($this->estadoActual()) {
            $estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
            return in_array($estado_actual, ['espera_control_calidad', 'espera_control_calidad_hotline']);
        } else {
            return false;
        }
    }

    public function ultAmpliacion()
    {
        $valuacion = $this->ultValuacion();
        if ($valuacion) {
            return $valuacion->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();
        } else {
            return null;
        }
    }

    public function esAmpliacion()
    {
        $estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        return in_array($estado_actual, ['espera_valuacion_ampliacion', 'espera_aprobacion_seguro_ampliacion', 'espera_aprobacion_ampliacion', 'espera_reparacion_ampliacion', 'espera_reparacion_ampliacion_hotline']);
    }

    public function fechaFinValuacionPopup()
    {
        $es_ampliacion = $this->esAmpliacion();
        if (!$es_ampliacion)
            return Carbon::parse($this->ultValuacion()->fecha_valuacion)->format('d/m/Y');
        else
            return Carbon::parse($this->ultValuacion()->ultReprogramacionValuacion()->fecha_ampliacion)->format('d/m/Y');
    }

    public function faltaFechaAprobacionSeguro()
    {
        $es_ampliacion = $this->esAmpliacion();
        if ($es_ampliacion) {
            if ($this->ultValuacion()->ultReprogramacionValuacion() && $this->ultValuacion()->ultReprogramacionValuacion()->fecha_aprobacion_seguro_amp)
                return false;
            else
                return true;
        } else {
            if (($this->ultValuacion() && !$this->ultValuacion()->fecha_aprobacion_seguro) || !$this->ultValuacion())
                return true;
            else
                return false;
        }
    }

    public function fechaAprobacionSeguroValuacionPopup()
    {
        $es_ampliacion = $this->esAmpliacion();
        if (!$es_ampliacion) {
            $fecha_aprobacion = $this->ultValuacion()->fecha_aprobacion_seguro;
            if (!$fecha_aprobacion) {
                $fecha_aprobacion = $this->ultValuacion()->fecha_valuacion;
            }
            return Carbon::parse($fecha_aprobacion)->format('d/m/Y');
        } else
            return Carbon::parse($this->ultValuacion()->ultReprogramacionValuacion()->fecha_aprobacion_seguro_amp)->format('d/m/Y');
    }

    public function faltaFechaAprobacionCliente()
    {
        $es_ampliacion = $this->esAmpliacion();
        if ($es_ampliacion) {
            if ($this->ultValuacion()->ultReprogramacionValuacion() && $this->ultValuacion()->ultReprogramacionValuacion()->fecha_aprobacion_cliente_amp)
                return false;
            else
                return true;
        } else {
            if (($this->ultValuacion() && !$this->ultValuacion()->fecha_aprobacion_cliente) || !$this->ultValuacion())
                return true;
            else
                return false;
        }
    }

    public function fechaAprobacionClienteValuacionPopup()
    {
        $es_ampliacion = $this->esAmpliacion();
        $valuacion = $this->ultValuacion();
        if (!$es_ampliacion) {
            $fecha_aprobacion_cliente = $valuacion->fecha_aprobacion_cliente;
            if (!$fecha_aprobacion_cliente) {
                $fecha_aprobacion_cliente = $valuacion->fecha_aprobacion_seguro;
                if (!$fecha_aprobacion_cliente) {
                    $fecha_aprobacion_cliente = $valuacion->fecha_valuacion;
                }
            }
            return Carbon::parse($fecha_aprobacion_cliente)->format('d/m/Y');
        } else
            return Carbon::parse($this->ultValuacion()->ultReprogramacionValuacion()->fecha_aprobacion_cliente_amp)->format('d/m/Y');
    }

    public function fechaRecepcionFormato()
    {
        $aux1 = $this->getHojaTrabajo()->first()->fecha_recepcion;
        if ($aux1) {
            return Carbon::parse($aux1)->format('d/m/Y');
        }
        return '-';
    }

    public function fechaInicioOperativoFormato()
    {
        $reparacion = $this->ultReparacion();

        if ($reparacion) {
            $fechaInicioOperativo = $reparacion->fecha_inicio_operativo;
            if ($fechaInicioOperativo) {
                return Carbon::parse($fechaInicioOperativo)->format('d/m/Y');
            } else {
                return '-';
            }
        } else {
            return '-';
        }
    }

    public function fechaTerminoOperativoFormato()
    {
        $reparacion = $this->ultReparacion();

        if ($reparacion) {
            $fechaFinOperativo = $reparacion->fecha_fin_operativo;
            if ($fechaFinOperativo) {
                return Carbon::parse($fechaFinOperativo)->format('d/m/Y');
            } else {
                return '-';
            }
        }

        return '-';
    }

    public function sumaHorasValuacion()
    {
        $valuacion = $this->ultValuacion();
        $horas_mec = $valuacion->horas_mecanica ? $valuacion->horas_mecanica : 0;
        $horas_car = $valuacion->horas_carroceria ? $valuacion->horas_carroceria : 0;
        $panhos = $valuacion->horas_panhos ? $valuacion->horas_panhos : 0;

        $suma = $horas_mec + $horas_car + $panhos;
        return $suma == 0 ? "-" : $suma;
    }

    public function tiempoEstancia()
    {
        return Carbon::now()->diffInDays($this->getHojaTrabajo()->fecha_recepcion);
    }

    public function perteneceTiempoEstancia($rango_estancia)
    {
        if (strpos($rango_estancia, "<") === 0) {
            $lim_superior = str_replace("<", "", $rango_estancia);
            return ($this->tiempoEstancia() < $lim_superior);
        }
        if (strpos($rango_estancia, ">") === 0) {
            $lim_inferior = str_replace(">", "", $rango_estancia);
            return ($this->tiempoEstancia() > $lim_inferior);
        }

        $pos_div = strpos($rango_estancia, "-");
        if ($pos_div !== false) {
            $lim_inferior = substr($rango_estancia, 0, $pos_div);
            $lim_superior = substr($rango_estancia, $pos_div + 1);

            $tiempo = $this->tiempoEstancia();
            return ($tiempo >= $lim_inferior && $tiempo <= $lim_superior);
        }
    }

    public function esProcesoReparacion()
    {
        $estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if (strpos("reparacion_", $estado_actual) === 0) {
            return true;
        } else return false;
    }

    public function preguntaInicioTecnico($proceso)
    {
        echo "¿Está seguro que desea INICIAR EL PROCESO de <span class='font-weight-bold'>$proceso</span>?";
    }

    public function preguntaFinTecnico($proceso)
    {
        echo "¿Está seguro que desea FINALIZAR EL PROCESO de <span class='font-weight-bold'>$proceso</span>?";
    }

    public function minFechaAprobacionSeguro()
    {
        $valuacion = $this->ultValuacion();
        $fechaMin = new Carbon();

        if ($valuacion) {
            $ampliacion = $valuacion->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();
            if (!$ampliacion) {
                $fechaMin = $valuacion->fecha_valuacion;
            } else {
                $fechaMin = $ampliacion->fecha_ampliacion;
            }
        }

        return Carbon::parse($fechaMin)->format('d/m/Y');
    }

    public function minFechaAprobacionCliente()
    {
        $valuacion = $this->ultValuacion();
        $fechaMin = new Carbon();
        if ($valuacion) {
            $ampliacion = $valuacion->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();
            if (!$ampliacion) {
                if ($valuacion->fecha_aprobacion_seguro) {
                    $fechaMin = $valuacion->fecha_aprobacion_seguro;
                } else {
                    $fechaMin = $valuacion->fecha_valuacion;
                }
            } else {
                if ($ampliacion->fecha_aprobacion_seguro_amp) {
                    $fechaMin = $ampliacion->fecha_aprobacion_seguro_amp;
                } else {
                    $fechaMin = $ampliacion->fecha_ampliacion;
                }
            }
        }

        return Carbon::parse($fechaMin)->format('d/m/Y');
    }

    public function minFechaCC()
    {
        $fechaMin = $this->fechaAprobacion();
        $detalleProceso = $this->detallesEnProceso()->where('etapa_proceso', 'pulido')->where('es_etapa_finalizada', 1)->first();
        if ($detalleProceso) {
            if ($detalleProceso->fecha_fin_etapa > $fechaMin) { //La fechaMinima sera el maximo entre la fechaAprobacion y la fecha de pulido
                $fechaMin = $detalleProceso->fecha_fin_etapa;
            }
        }
        return Carbon::parse($fechaMin)->format('d/m/Y');
    }

    public function minFechaEntrega()
    {
        $valuacion = $this->ultValuacion();
        if ($valuacion && $valuacion->es_perdida_total) {
            if ($valuacion->fecha_aprobacion_cliente) {
                $fechaMin = $valuacion->fecha_aprobacion_cliente;
            } elseif ($fechaMin = $valuacion->fecha_aprobacion_seguro) {
                $fechaMin = $valuacion->fecha_aprobacion_seguro;
            } else {
                $fechaMin = $valuacion->fecha_valuacion;
            }
            return Carbon::parse($fechaMin)->format('d/m/Y');;
        } else {
            return $this->fechaTerminoOperativoFormato();
        }
    }

    public function esObligatorioFechaAprobacionCliente()
    {
        $valuacion = $this->ultValuacion();

        if ($valuacion) {
            $ampliacion = $valuacion->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();
            if ($ampliacion) {
                if ($ampliacion->fecha_aprobacion_seguro_amp) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($valuacion->fecha_aprobacion_seguro || $this->esParticular()) {
                return true;
            }
        }
        return false;
    }

    public function ultimaFechaPromesa()
    {
        $aux = $this->ultReparacion();
        if ($aux) {
            $fechaPromesa = $aux->fechasPromesa()->orderBy('fecha_registro', 'desc')->first();
            if ($fechaPromesa) {
                return new Carbon($fechaPromesa->fecha_promesa);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function ultimaFechaPromesaFormat()
    {
        $ultFechaPromesa = $this->ultimaFechaPromesa();
        if ($ultFechaPromesa) {
            return $ultFechaPromesa->format('d/m/Y H:i');
        } else {
            return null;
        }
    }

    public function cotizacionesAsociables()
    {
        $hojaTrabajo = $this->getHojaTrabajo();
        $placa = $hojaTrabajo->getPlacaAuto();
        $operador = $hojaTrabajo->tipo_trabajo == 'DYP' ? '=' : '!=';
        $cotizaciones = Cotizacion::where('es_habilitado', 1)->whereHas('hojaTrabajo', function ($query) use ($placa, $operador) {
            $query->where('placa_auto', $placa);
            $query->where('tipo_trabajo', $operador, 'DYP');
        })->with('hojaTrabajo')->get()->all();

        return $cotizaciones;
    }

    public function asociarCotizacion($idCotizacion)
    {
        $cotizacion = Cotizacion::find($idCotizacion);
        if (!$cotizacion) return false;

        $cotizacion->id_recepcion_ot = $this->id_recepcion_ot;
        $cotizacion->es_habilitado = 0;
        $cotizacion->save();

        $reiniciarOT = false;
        //migrar los repuestos
        $hojaTrabajoOT = $this->hojaTrabajo;
        $necesidadesRepuestosCot = $cotizacion->hojaTrabajo->necesidadesRepuestos()->get();
        foreach ($necesidadesRepuestosCot as $key => $necesidadRptosCot) {
            // duplicar necesidad de repuestos (YA NO ES NECESARIO, SE CONSIDERARA LA MISMA DE LA OT)
            // $necesidadRepuestos = $necesidadRptosCot->replicate();
            // unset($necesidadRepuestos->fecha_registro);
            // $necesidadRepuestos->id_hoja_trabajo=$hojaTrabajoOT->id_hoja_trabajo;
            // $necesidadRepuestos->save();
            $necesidadRepuestos = $hojaTrabajoOT->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
            if (!$necesidadRepuestos) {
                $necesidadRepuestos = new NecesidadRepuestos();
                $necesidadRepuestos->id_hoja_trabajo = $hojaTrabajoOT->id_hoja_trabajo;
                $necesidadRepuestos->save();
            }

            $repuestosSolicitadosCot = $necesidadRptosCot->itemsNecesidadRepuestos()->get();
            foreach ($repuestosSolicitadosCot as $key => $repuestoSolicitadoCot) {
                $itemNecesidadRepuestos = $repuestoSolicitadoCot->replicate();
                unset($itemNecesidadRepuestos->fecha_registro);
                $itemNecesidadRepuestos->id_necesidad_repuestos = $necesidadRepuestos->id_necesidad_repuestos;
                $itemNecesidadRepuestos->generarMovimientosPaseAOT();
                if ($itemNecesidadRepuestos->id_repuesto) $reiniciarOT = true;
            }
        }

        //migrar los trabajos
        $detallesTrabajoCot = $cotizacion->hojaTrabajo->detallesTrabajo;
        foreach ($detallesTrabajoCot as $key => $detalleTrabajoCot) {
            $detalleTrabajo = $detalleTrabajoCot->replicate();
            $detalleTrabajo->id_hoja_trabajo = $hojaTrabajoOT->id_hoja_trabajo;
            $detalleTrabajo->save();

            $reiniciarOT = true;
        }

        $serviciosTercerosCot = $cotizacion->hojaTrabajo->serviciosTerceros;
        foreach ($serviciosTercerosCot as $key => $servicioTerceroCot) {
            $servicioTercero = $servicioTerceroCot->replicate();
            unset($servicioTercero->fecha_registro);
            $servicioTercero->id_hoja_trabajo = $hojaTrabajoOT->id_hoja_trabajo;
            $servicioTercero->save();

            //$reiniciarOT = true;
        }

        if ($reiniciarOT)
            $this->reiniciarProcesoReparacionTecnicos();

        return true;
    }

    public function generarDetallesFacturacion()
    {
        $result = [];
        $tasa_igv = config('app.tasa_igv');

        $detallesTrabajo = $this->getDetallesTrabajoCompleto();
        $totalValorManoObra = 0;
        foreach ($detallesTrabajo as $key => $detalleTrabajo) {
            $lineaPreFacturacion = [];
            $lineaPreFacturacion['cantidad'] = 1;
            $lineaPreFacturacion['tipo']='SERVICIO';
            $lineaPreFacturacion['unidad']='SERVICIO';
            $lineaPreFacturacion['codigo']= $detalleTrabajo->operacionTrabajo->cod_operacion_trabajo;
            $lineaPreFacturacion['descripcion']= $detalleTrabajo->getNombreDetalleTrabajo();
            $lineaPreFacturacion['valorUnitario']= $detalleTrabajo->getPrecioLista(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['valorVenta']= $detalleTrabajo->getPrecioLista(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['descuento']= $detalleTrabajo->getDescuento(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['descuentoConIgv']= $detalleTrabajo->getDescuento(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), true);
            $lineaPreFacturacion['subtotal']= $detalleTrabajo->getSubTotal(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['igv']= ($tasa_igv * $lineaPreFacturacion['subtotal']) ?? 0;
            $lineaPreFacturacion['igvSinDescuento']=$tasa_igv * $lineaPreFacturacion['valorVenta'];
            $lineaPreFacturacion['precioVenta']= ($lineaPreFacturacion['subtotal'] + $lineaPreFacturacion['igv']) ?? 0;
            array_push($result, (object) $lineaPreFacturacion);

            $totalValorManoObra += $detalleTrabajo->getPrecioLista();
        }

        // //MANO DE OBRA COMO UNA SOLA LINEA
        // $lineaPreFacturacion = [];
        // $lineaPreFacturacion['cantidad'] = 1;
        // $lineaPreFacturacion['tipo']='SERVICIO';
        // $lineaPreFacturacion['codigo']= 'MO';
        // $lineaPreFacturacion['descripcion']= "MANO DE OBRA";
        // $lineaPreFacturacion['valorUnitario']= $totalValorManoObra;
        // $lineaPreFacturacion['valorVenta']=$totalValorManoObra;
        // $lineaPreFacturacion['igv']=$tasa_igv * $totalValorManoObra;
        // $lineaPreFacturacion['precioVenta']=$lineaPreFacturacion['valorVenta'] + $lineaPreFacturacion['igv'];
        // array_unshift($result, (object) $lineaPreFacturacion);

        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                $lineaPreFacturacion = [];
                $lineaPreFacturacion['cantidad'] = $repuestoAprobado->getCantidad();
                $lineaPreFacturacion['tipo']='PRODUCTO';
                $lineaPreFacturacion['unidad']='PRODUCTO';
                $lineaPreFacturacion['codigo']= $repuestoAprobado->repuesto->codigo_repuesto;
                $lineaPreFacturacion['descripcion']= $repuestoAprobado->repuesto->descripcion;
                $lineaPreFacturacion['valorUnitario']= $repuestoAprobado->getMontoUnitario($repuestoAprobado->getFechaRegistroCarbon(),false);
                $lineaPreFacturacion['valorVenta']= $lineaPreFacturacion['cantidad'] * $lineaPreFacturacion['valorUnitario'];
                $lineaPreFacturacion['descuento']= $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(),false, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer ?? -1);
                $lineaPreFacturacion['descuentoConIgv']= $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(),true, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer ?? -1);
                $lineaPreFacturacion['subtotal']= $lineaPreFacturacion['valorVenta'] - $lineaPreFacturacion['descuento'];
                $lineaPreFacturacion['igv']=$tasa_igv * $lineaPreFacturacion['subtotal'];
                $lineaPreFacturacion['igvSinDescuento']=$tasa_igv * $lineaPreFacturacion['valorVenta'];
                $lineaPreFacturacion['precioVenta']=$lineaPreFacturacion['subtotal'] + $lineaPreFacturacion['igv'];
                array_push($result, (object) $lineaPreFacturacion);
            }
        }

        $serviciosTerceros = $this->getServiciosTerceros();
        foreach ($serviciosTerceros as $key => $servicioTercero) {
            $lineaPreFacturacion = [];
            $lineaPreFacturacion['cantidad'] = 1;
            $lineaPreFacturacion['tipo']='SERVICIO';
            $lineaPreFacturacion['unidad']='SERVICIO';
            $lineaPreFacturacion['codigo']= $servicioTercero->getCodigoServicioTercero();
            $lineaPreFacturacion['descripcion']= $servicioTercero->getDescripcion();
            $lineaPreFacturacion['valorUnitario']= $servicioTercero->getSubTotal(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['valorVenta']= $servicioTercero->getSubTotal(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['descuento']= $servicioTercero->getDescuento(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), false);
            $lineaPreFacturacion['descuentoConIgv']= $servicioTercero->getDescuento(Helper::obtenerUnidadMonedaCalculo($this->hojaTrabajo->moneda), true);
            $lineaPreFacturacion['subtotal']= $lineaPreFacturacion['valorVenta'] - $lineaPreFacturacion['descuento'];
            $lineaPreFacturacion['igv']=$tasa_igv * $lineaPreFacturacion['subtotal'];
            $lineaPreFacturacion['igvSinDescuento']=$tasa_igv * $lineaPreFacturacion['valorVenta'];
            $lineaPreFacturacion['precioVenta']=$lineaPreFacturacion['subtotal'] + $lineaPreFacturacion['igv'];
            array_push($result, (object) $lineaPreFacturacion);
        }

        return count($result) == 0 ? null : $result;
    }

    /*INICIO DE METODOS PARA REPORTE*/
    public function cumplimientoFechaEntrega()
    {
        $estado_actual = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if (in_array($estado_actual, ['entregado', 'entregado_hotline', 'entregado_pt'])) {
            return '';
        } else {
            $fechaPromesa = $this->ultimaFechaPromesa();
            if ($fechaPromesa) {
                $diferencia = $fechaPromesa->diff(Carbon::now())->format('%r%d');
                if ($diferencia > 0) {
                    return "Venció hace $diferencia día" . ($diferencia != 1 ? "s" : "");
                } elseif ($diferencia < 0) {
                    $diferencia *= -1;
                    return "Vence en $diferencia día" . ($diferencia != 1 ? "s" : "");
                } else {
                    return "Vence hoy";
                }
            } else {
                return '';
            }
        }
    }
    public function getMontConSinDescuentoSolesConIGV()
    {
        $hojaTrabajo = $this->getHojaTrabajo();
        if ($hojaTrabajo->moneda == "SOLES") {
            return $this->getMontoConSinDescuento();
        } else {
            return $this->getMontoConSinDescuento() * $hojaTrabajo->tipo_cambio;
        }
    }
    public function getMontConSinDescuentoDolaresConIGV()
    {

        $hojaTrabajo = $this->getHojaTrabajo();
        if ($hojaTrabajo->moneda = "DOLARES") {
            return $this->getMontoConSinDescuento();
        } else {
            return $this->getMontoConSinDescuento() / $hojaTrabajo->tipo_cambio;
        }
    }
    public function getMontoConSinDescuento()
    {

        $detallesTrabajo = $this->getDetallesTrabajoCompleto();
        $totalValorManoObra = 0;
        $totalServiciosDescuento = 0;
        $hojaTrabajo = $this->getHojaTrabajo();
        $moneda = $hojaTrabajo->moneda;

        $monedaCalculos = $moneda == "SOLES" ? "PEN" : "USD";
        $detallesTrabajo = $hojaTrabajo->detallesTrabajo;
        $totalServicios = 0;
        $totalServiciosDescuento = 0;
        foreach ($detallesTrabajo as $key => $detalleTrabajo) {
            $totalServicios += $detalleTrabajo->getPrecioLista($monedaCalculos);
            $totalServiciosDescuento += $detalleTrabajo->getDescuento($monedaCalculos);
        }


        $totalRepuestos = 0;
        $totalRepuestosDescuento = 0;
        $repuestosAprobados = collect([]);
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();

        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            if ($repuestosAprobados->count() == 0) $repuestos = [];

            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                $totalRepuestos += $repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(), true);
                #return $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(),true, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer);
                $totalRepuestosDescuento += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario ?? 0, $repuestoAprobado->descuento_unitario_dealer ?? -1);
            }
        }

        $serviciosTerceros = $this->getServiciosTerceros();
        $totalServiciosTerceros = 0;
        $totalServiciosTercerosDescuento = 0;
        foreach ($serviciosTerceros as $key => $servicioTercero) {
            $totalServiciosTerceros += $servicioTercero->getSubTotal($monedaCalculos);
            $totalServiciosTercerosDescuento += $servicioTercero->getDescuento($monedaCalculos);
        }

        $totalDescuentos = $totalServiciosDescuento + $totalRepuestosDescuento + $totalServiciosTercerosDescuento;
        $totalCotizacion = $totalServicios + $totalRepuestos + $totalServiciosTerceros - $totalDescuentos;
        return $totalCotizacion;
    }

    public function getMontoTotalDolares()
    {

        $last_cambio = TipoCambio::where('fecha_registro', '<=', date('Y-m-d'))->orderBy('id_tipo_cambio', 'desc')->first()->cobro;
        $moneda = $this->hojaTrabajo->moneda;

        $cambio = $this->hojaTrabajo->tipo_cambio;
        if (is_null($cambio)) $cambio = $last_cambio;

        $valor_total = $this->getMontoConSinDescuento();
        $sin_igv = $valor_total / 1.18;


        if ($moneda == 'DOLARES') return number_format($sin_igv, 2);
        return number_format($sin_igv / $cambio, 2);
    }

    public function asesorServicio()
    {
        return $this->getHojaTrabajo()->empleado->nombreCompleto();
    }

    public function fechaTrasladoCarbon()
    {
        $aux = $this->fechaTraslado();
        if ($aux) {
            return new Carbon($aux);
        } else {
            return "-";
        }
    }

    public function fechaValuacionCarbon()
    {
        $aux = $this->ultValuacion();
        if ($aux && $aux->fecha_valuacion) {
            return new Carbon($aux->fecha_valuacion);
        } else {
            return "-";
        }
    }

    public function fechaAprobacionSeguro()
    {
        $aux = $this->ultValuacion();
        if ($aux && $aux->fecha_aprobacion_seguro) {
            return new Carbon($aux->fecha_aprobacion_seguro);
        } else {
            return "-";
        }
    }

    public function fechaAprobacionCliente()
    {
        $aux = $this->ultValuacion();
        if ($aux && $aux->fecha_aprobacion_cliente) {
            return new Carbon($aux->fecha_aprobacion_cliente);
        } else {
            return "-";
        }
    }

    public function fechaValuacionAmpliacionCarbon()
    {
        $aux = $this->ultValuacion();
        if ($aux) {
            $aux2 = $aux->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();

            if ($aux2 && $aux2->fecha_ampliacion) {
                return new Carbon($aux->fecha_ampliacion);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function fechaAprobacionSeguroAmpliacion()
    {
        $aux = $this->ultValuacion();
        if ($aux) {
            $aux2 = $aux->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();

            if ($aux2 && $aux2->fecha_aprobacion_seguro_amp) {
                return new Carbon($aux->fecha_aprobacion_seguro_amp);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function fechaAprobacionClienteAmpliacion()
    {
        $aux = $this->ultValuacion();
        if ($aux) {
            $aux2 = $aux->reprogramacionesValuacion()->orderBy('fecha_registro', 'desc')->first();

            if ($aux2 && $aux2->fecha_aprobacion_cliente_amp) {
                return new Carbon($aux->fecha_aprobacion_cliente_amp);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function moAprobada()
    {
        $aux = $this->ultValuacion();

        if ($aux && $aux->fecha_aprobacion_cliente) {
            $total = $aux->valor_mano_obra;
            $total += $aux->reprogramacionesValuacion()->sum('valor_mano_obra_amp');
            return $total;
        } else {
            return "-";
        }
    }

    public function repuestosAprobados()
    {
        $aux = $this->ultValuacion();

        if ($aux && $aux->fecha_aprobacion_cliente) {
            $total = $aux->valor_mano_obra;
            $total += $aux->reprogramacionesValuacion()->sum('valor_repuestos_amp');
            return $total;
        } else {
            return "-";
        }
    }

    public function hhMecAprobados()
    {
        $aux = $this->ultValuacion();

        if ($aux && $aux->fecha_aprobacion_cliente) {
            $total = $aux->horas_mecanica;
            $total += $aux->reprogramacionesValuacion()->sum('horas_mecanica_amp');
            return $total;
        } else {
            return "-";
        }
    }

    public function hhCarrAprobados()
    {
        $aux = $this->ultValuacion();

        if ($aux && $aux->fecha_aprobacion_cliente) {
            $total = $aux->horas_carroceria;
            $total += $aux->reprogramacionesValuacion()->sum('horas_carroceria_amp');
            return $total;
        } else {
            return "-";
        }
    }

    public function panhosAprobados()
    {
        $aux = $this->ultValuacion();

        if ($aux && $aux->fecha_aprobacion_cliente) {
            $total = $aux->horas_panhos;
            $total += $aux->reprogramacionesValuacion()->sum('horas_panhos_amp');
            return $total;
        } else {
            return "-";
        }
    }

    /* nroRepuestosStock() YA EXISTE*/

    public function ultRepuestoStock()
    {
        $necesidadesRepuestos = $this->necesidadesRepuestos()->get();
        if ($necesidadesRepuestos) {
            $necesidadesRepuestos->sortByDesc(function ($necesidadRptos) {
                return $necesidadRptos->itemsNecesidadRepuestos()->where('es_importado', 0)->orderBy('fecha_registro', 'desc')->first()->fecha_registro;
            });
            $ultRptoStock = $necesidadesRepuestos->first()->itemsNecesidadRepuestos()->where('es_importado', 0)->orderBy('fecha_registro', 'desc')->first();
            return $ultRptoStock;
        } else {
            return null;
        }
    }

    public function ultRepuestoImportacion()
    {
        $necesidadesRepuestos = $this->necesidadesRepuestos()->get();
        if ($necesidadesRepuestos) {
            $necesidadesRepuestos->sortByDesc(function ($necesidadRptos) {
                return $necesidadRptos->itemsNecesidadRepuestos()->where('es_importado', 1)->orderBy('fecha_registro', 'desc')->first()->fecha_registro;
            });
            $ultRptoImportacion = $necesidadesRepuestos->first()->itemsNecesidadRepuestos()->where('es_importado', 1)->orderBy('fecha_registro', 'desc')->first();
            return $ultRptoImportacion;
        } else {
            return null;
        }
    }

    public function fechaPedidoRptoStock()
    {
        $ultRepuestoStock = $this->ultRepuestoStock();
        if ($ultRepuestoStock) {
            return new Carbon($ultRepuestoStock->fecha_pedido);
        } else {
            return "-";
        }
    }

    public function fechaLlegadaRptoStock()
    {
        $ultRepuestoStock = $this->ultRepuestoStock();
        if ($ultRepuestoStock) {
            return new Carbon($ultRepuestoStock->fecha_entrega);
        } else {
            return "-";
        }
    }

    /* nroRepuestosHotline() YA EXISTE*/

    public function fechaPedidoRptoImportacion()
    {
        $ultRepuestoImportacion = $this->ultRepuestoImportacion();
        if ($ultRepuestoImportacion) {
            return new Carbon($ultRepuestoImportacion->fecha_pedido);
        } else {
            return "-";
        }
    }

    public function fechaLlegadaRptoImportacion()
    {
        $ultRepuestoImportacion = $this->ultRepuestoImportacion();
        if ($ultRepuestoImportacion) {
            return new Carbon($ultRepuestoImportacion->fecha_pedido);
        } else {
            return "-";
        }
    }

    public function fechaInicioOperativo()
    {
        $aux = $this->ultReparacion();
        if ($aux)
            return new Carbon($aux->fecha_inicio_operativo);
        else
            return "-";
    }

    public function fechaPromesaEntregaCarbon()
    {
        $aux = $this->ultReparacion();
        if ($aux) {
            $fechaPromesa = $aux->primeraFechaPromesa();
            if ($fechaPromesa) {
                return new Carbon($fechaPromesa->fecha_promesa);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function fechaReprogramacion1Carbon()
    {
        $aux = $this->ultReparacion();
        if ($aux) {
            $fechaPromesa = $aux->fechasPromesa()->orderBy('fecha_registro', 'asc')->skip(1)->take(1)->get()->all();
            if ($fechaPromesa) {
                return new Carbon($fechaPromesa[0]->fecha_promesa);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function comentariosReprogramacion1()
    {
        $aux = $this->ultValuacion();
        if ($aux) {
            $reprogramacion = $aux->reprogramacionesValuacion()->orderBy('fecha_registro', 'asc')->first();
            if ($reprogramacion) {
                return $reprogramacion->explicacion_ampliacion;
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function fechaReprogramacion2Carbon()
    {
        $aux = $this->ultReparacion();
        if ($aux) {
            $fechaPromesa = $aux->fechasPromesa()->orderBy('fecha_registro', 'asc')->skip(2)->take(1)->get()->all();
            if ($fechaPromesa) {
                return new Carbon($fechaPromesa[0]->fecha_promesa);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function comentariosReprogramacion2()
    {
        $aux = $this->ultValuacion();
        if ($aux) {
            $reprogramacion = $aux->reprogramacionesValuacion()->orderBy('fecha_registro', 'asc')->skip(1)->take(1)->get()->all();
            if ($reprogramacion) {
                return $reprogramacion[0]->explicacion_ampliacion;
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function fechaTerminoOperativo()
    {
        $aux = $this->ultReparacion();
        if ($aux) {
            return new Carbon($aux->fecha_fin_operativo);
        } else {
            return "-";
        }
    }

    public function fechaTrasladoCC()
    {
        return "fechaTrasladoCC";
    }

    public function fechaEntregado()
    {
        $ultEntrega = $this->ultEntrega();
        if ($ultEntrega) {
            return new Carbon($ultEntrega->fecha_entrega);
        } else {
            return "-";
        }
    }

    public function fechaEntregadoFormat()
    {
        $ultEntrega = $this->ultEntrega();
        if ($ultEntrega) {
            return (new Carbon($ultEntrega->fecha_entrega))->format('d/m/Y');
        } else {
            return "-";
        }
    }

    public function tiempoPedidoImportacion()
    {
        $aux = $this->fechaPromesaEntregaCarbon();
        if ($aux && $aux != '-') {
            $entrega = $this->fechaEntregado();
            if ($entrega) {
                return $entrega->diffInDays($aux);
            } else {
                return "-";
            }
        } else {
            return "-";
        }
    }

    public function tiempoEsperaAsignacionCalendario()
    {
        if ($this->estadoActual()[0]->nombre_estado_reparacion_interno == "entregado")
            return $this->fechaInicioOperativo()->diffInDays($this->fechaAprobacionCliente());
        else
            return null;
    }

    public function tiempoValuacionCalendario()
    {
        if ($this->estadoActual()[0]->nombre_estado_reparacion_interno == "entregado")
            return $this->fechaValuacionCarbon()->diffInDays($this->fechaValuacionCarbon());
        else
            return null;
    }

    public function tiempoAprobacionCalendario()
    {
        if ($this->estadoActual()[0]->nombre_estado_reparacion_interno == "entregado")
            return $this->fechaAprobacionCliente()->diffInDays($this->getHojaTrabajo()->fecha_recepcion);
        else
            return null;
    }

    public function tiempoReparacionCalendario()
    {
        if ($this->estadoActual()[0]->nombre_estado_reparacion_interno == "entregado")
            return $this->fechaEntregado()->diffInDays($this->fechaInicioOperativo());
        else
            return null;
    }

    public function tiempoTerminoOperativoCalendario()
    {
        if ($this->estadoActual()[0]->nombre_estado_reparacion_interno == "entregado")
            return $this->fechaEntregado()->diffInDays($this->getHojaTrabajo()->fecha_recepcion);
        else
            return null;
    }

    public function tiempoEstanciaCalendario()
    {
        if ($this->estadoActual()[0]->nombre_estado_reparacion_interno == "entregado")
            return $this->fechaEntregado()->diffInDays($this->getHojaTrabajo()->fecha_recepcion);
        else
            return null;
    }
    /*FIN DE METODOS PARA REPORTE*/

    /* Metodos de Test */
    public static function testMailTarget($correo)
    {
        if (config('app.send_mail')) {
            Mail::send(['html' => 'emails.correoPrueba3'], [], function ($message) use ($correo) {
                $message->to($correo)
                    ->subject('AUTOLAND: ACTUALIZACIÓN DE ESTADO');
                $message->from(env('MAIL_USERNAME'), 'Autoland');
            });
        }
    }

    public static function testMail()
    {
        self::testMailTarget("bruno.espezua@pucp.pe");
    }

    public static function testMailAutoland()
    {
        self::testMailTarget("Steven.torrejonr@pucp.pe");
        self::testMailTarget("dtorrejon@autolandperu.com");
        self::testMailTarget("Renzo.benavente@pucp.pe");
        self::testMailTarget("bruno.espezua@pucp.pe");
    }

    public function updatePrecio()
    {
        $detallesTrabajo = $this->hojaTrabajo->detallesTrabajo;

        if ($this->hojaTrabajo->tipo_trabajo == 'DYP' && count($detallesTrabajo) > 0) {
            
            $elementoPrecio = $detallesTrabajo[0]->precio_dyp;
            $marca = $elementoPrecio->id_marca_auto;
            $cia = $elementoPrecio->id_cia_seguro;

            $idSeguro = $this->id_cia_seguro;
            $idMarca = $this->hojaTrabajo->vehiculo->id_marca_auto;

            if ($marca != $idMarca || $cia != $idSeguro) {
             
                $fecha_inicio = Carbon::parse($this->fecha_inicio);
                $id_marca_auto = $this->hojaTrabajo->vehiculo->id_marca_auto;
                $id_cia_seguro = $this->id_cia_seguro;
    
                $panhos = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $id_cia_seguro)->where('tipo', 'PANHOS')
                    ->where('fecha_inicio_aplicacion', '<', $fecha_inicio)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();
                $hh = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $id_cia_seguro)->where('tipo', 'HH')
                    ->where('fecha_inicio_aplicacion', '<', $fecha_inicio)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();
    
                if ($panhos && $hh) {
                    $this->precio_dyp = json_encode(["PANHOS" => $panhos->id_precio_mo_dyp, "HH" => $hh->id_precio_mo_dyp]);
                    $this->save();
                }
    
            }

        }
    }

    public function criterioCSS()
    {
        $tipoDanho = $this->criterioDanho();

        switch ($tipoDanho) {
            case 'EXPRESS':
                return 'tipo-danho tipo-danho-express font-weight-bold';
                break;
            case 'LEVE':
                return 'tipo-danho tipo-danho-leve font-weight-bold';
                break;
            case 'MEDIO':
                return 'tipo-danho tipo-danho-medio font-weight-bold';
                break;
            case 'FUERTE':
                return 'tipo-danho tipo-danho-fuerte font-weight-bold';
                break;
        }
    }

    public function criterioDanho()
    {
        // $id_marca_auto = $this->getHojaTrabajo()->getIdMarcaAuto();
        // $id_cia_seguro = $this->ciaSeguro ? $this->ciaSeguro()->first()->id_cia_seguro : null;

        // if (!$id_cia_seguro)
        //     return '-';
        // # code...
        // $tipo_danho_rptos = DB::table('tipo_danho_temp')->where('id_marca_auto', 0)->where('id_cia_seguro', 0)->first();
        // $tipo_danho = DB::table('tipo_danho_temp')->where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $id_cia_seguro)->first();
        $nombre_estado = $this->estadoActual()[0]->nombre_estado_reparacion_interno;
        if ($this->ultValuacion() && !in_array($nombre_estado, ["rechazado", 'perdida_total', "espera_valuacion"]) && strpos($nombre_estado, "espera_aprobacion") === false) {
            
            return (new \App\Http\Controllers\Administracion\CarroceriaMOController)->danho_inOT('', false, $this);
        }

        return "-";
    }
}
