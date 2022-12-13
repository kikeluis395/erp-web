<?php

namespace App\Modelos;

use App\Modelos\Internos\GrupoTransaccionMonetaria;
use Carbon\Carbon;

class HojaTrabajo extends GrupoTransaccionMonetaria
{
    protected $table = "hoja_trabajo";
    protected $fillable = ['placa_auto', 'doc_cliente', 'dni_empleado', 'observaciones', 'fecha_recepcion', 'fecha_registro', 'id_cotizacion', 'id_recepcion_ot'];
    protected $primaryKey = 'id_hoja_trabajo';

    public static $nombreRutaDetalleCotDYP = 'detalle_trabajos.index';
    public static $nombreRutaDetalleCotMEC = 'mecanica.detalle_trabajos.index';
    public static $detalleCotRouteKey = 'id_cotizacion';

    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo('App\Modelos\Empleado', 'dni_empleado');
    }

    public function recepcionOT()
    {
        return $this->belongsTo('App\Modelos\RecepcionOT', 'id_recepcion_ot');
    }

    public function cotizacion()
    {
        return $this->belongsTo('App\Modelos\Cotizacion', 'id_cotizacion');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Cliente', 'doc_cliente');
    }

    public function vehiculo()
    {
        return $this->belongsTo('App\Modelos\Vehiculo', 'placa_auto');
    }

    public function car()
    {
        return $this->belongsTo('App\Modelos\Vehiculo', 'placa_auto', 'placa');
    }

    public function vin()
    {
        return $this->belongsTo('App\Modelos\Vehiculo', 'vin');
    }

    public function detallesTrabajo()
    {
        return $this->hasMany('App\Modelos\DetalleTrabajo', 'id_hoja_trabajo');
    }

    public function marcaAuto()
    {
        return $this->vehiculo->marcaAuto();
    }

    public function necesidadesRepuestos()
    {
        return $this->hasMany('App\Modelos\NecesidadRepuestos', 'id_hoja_trabajo');
    }

    public function descuentos()
    {
        return $this->hasMany('App\Modelos\Descuento', 'id_hoja_trabajo');
    }

    public function serviciosTerceros()
    {
        return $this->hasMany('App\Modelos\ServicioTerceroSolicitado', 'id_hoja_trabajo');
    }

    // Vehiculo

    public function setPlacaAuto($placa)
    {
        if ($this->placa_auto != $placa) {
            $this->placa_auto = $placa;
            $this->load('vehiculo');
        }
    }

    public function getPlacaAuto()
    {
        return $this->placa_auto;
    }

    public function getTipoTrabajo()
    {
        return $this->tipo_trabajo;
    }

    public function getPlacaAutoFormat()
    {
        return substr($this->placa_auto, 0, 3) . '-' . substr($this->placa_auto, 3, 3);
    }

    public function getIdMarcaAuto()
    {
        return $this->vehiculo ? $this->vehiculo->getIdMarca() : null;
    }

    public function getModeloVehiculo()
    {
        return $this->vehiculo ? $this->vehiculo->getModelo() : null;
    }

    public function getColor()
    {
        return $this->vehiculo ? $this->vehiculo->getColor() : null;
    }

    public static function saveVehiculo($placa, $idMarca, $modelo, $color)
    {
        $vehiculo = new Vehiculo();
        $vehiculo->setPlaca($placa);
        $vehiculo->vin = 'xxxxx';
        $vehiculo->tipo_transmision = 'automatico';
        $vehiculo->kilometraje = 666.666;
        $vehiculo->anho_vehiculo = 2010;
        $vehiculo->tipo_combustible = 'petroleo';
        $vehiculo->setIdMarca($idMarca);
        $vehiculo->setModelo($modelo);
        $vehiculo->setColor($color);
        $vehiculo->save();
    }

    // Cliente

    public function setNumDocCliente($numdoc)
    {
        if ($this->doc_cliente != $numdoc) {
            $this->doc_cliente = $numdoc;
            $this->load('cliente');
        }
    }

    public function getNumDocCliente()
    {
        return $this->doc_cliente;
    }

    public function getNombreCliente()
    {
        return $this->cliente->getNombreCliente();
    }

    public function getCorreoCliente()
    {
        return $this->cliente->getCorreoCliente();
    }

    public function getTelefonoCliente()
    {
        return $this->cliente->getTelefonoCliente();
    }

    public function getDireccionCliente()
    {
        return $this->cliente->getDireccionCliente();
    }

    public static function saveCliente($numDoc, $nombres, $apellidoPat, $apellidoMat, $direccion, $telefono, $email, $ubigeo)
    {
        $cliente = new Cliente();
        $cliente->setNumDocCliente($numDoc);
        $cliente->setNombres($nombres);
        $cliente->setApellidoPat($apellidoPat);
        $cliente->setApellidoMat($apellidoMat);
        $cliente->setDireccionCliente($direccion);
        $cliente->setTelefonoCliente($telefono);
        $cliente->setCorreoCliente($email);
        $cliente->setUbigeoCliente($ubigeo);
        $cliente->save();
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

    public function getOTNroOT()
    {
        $recepcionOT = $this->recepcionOT;
        return is_null($recepcionOT) ? "-" : $recepcionOT->getNroOT();
    }

    public function getSeguroNombreCiaSeguro()
    {
        $recepcionOT = $this->recepcionOT;
        return is_null($recepcionOT) ? "-" : $recepcionOT->getNombreCiaSeguro();
    }

    public function getFechaAprobacionCliente()
    {
        $recepcionOT = $this->recepcionOT;
        if (!is_null($recepcionOT) && !is_null($valuacion = $recepcionOT->ultValuacion()) && $valuacion->fecha_aprobacion_cliente) {
            return Carbon::parse($valuacion->fecha_aprobacion_cliente)->format('d/m/Y');
        } else {
            return "-";
        }
    }

    public function getPlacaPartida()
    {
        return substr($this->placa_auto, 0, 3) . '-' . substr($this->placa_auto, 3, 3);
    }

    public function getFechaRecepcionFormat($formato = null)
    {
        if ($formato == null) $formato = 'd/m/Y';
        return Carbon::parse($this->fecha_recepcion)->format($formato);
    }

    public function getSumaHorasMecanica()
    {
        return $this->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->where('tipo_trabajo', 'MECANICA');
        })->sum('valor_trabajo_estimado');
    }

    public function getSumaHorasMecanicaColision()
    {
        return $this->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->whereIn('tipo_trabajo', ['MECANICA Y COLISION', 'GLOBAL-HORAS-MEC', 'MECANICA']);
        })->sum('valor_trabajo_estimado');
    }

    public function getSumaHorasCarroceria()
    {
        return $this->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->whereIn('tipo_trabajo', ['CARROCERIA', 'GLOBAL-HORAS-CARR']);
        })->sum('valor_trabajo_estimado');
    }

    public function getSumaPanhosPintura()
    {
        return $this->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->where('tipo_trabajo', ['PANHOS PINTURA', 'GLOBAL-PANHOS']);
        })->sum('valor_trabajo_estimado');
    }

    public function getSumaServiciosTerceros()
    {
        return $this->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->where('tipo_trabajo', 'SERVICIOS TERCEROS');
        })->sum('valor_trabajo_estimado');
    }

    public function getPrimerTrabajoPreventivoOptional()
    {
        $trabajoPreventivo = $this->detallesTrabajo()->with('operacionTrabajo')->whereHas('operacionTrabajo', function ($query) {
            $query->where('descripcion', 'LIKE', '%PREVENTIVO%');
        })->first();

        if ($trabajoPreventivo) {
            return $trabajoPreventivo->getNombreDetalleTrabajo();
        } else {
            $detalleTrabajo = $this->detallesTrabajo()->with('operacionTrabajo')->first();
            return $detalleTrabajo ? $detalleTrabajo->getNombreDetalleTrabajo() : null;
        }

        return null;
    }

    public function getValorTotalRepuestos($moneda = null)
    {
        $tasaIGV = config('app.tasa_igv');
        $totalRepuestos = 0;
        $repuestosAprobados = collect([]);
        $necesidadRepuestos = $this->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            if ($repuestosAprobados->count() == 0) $repuestos = [];
            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                $totalRepuestos += $repuestoAprobado->getMontoVentaTotal($repuestoAprobado->getFechaRegistroCarbon(), true);
            }
        }

        return $totalRepuestos / (1 + $tasaIGV);
    }

    public function getValorTotalRepuestosIGV($moneda = null)
    {
        $valor = $this->getValorTotalRepuestos();
        $igv = config('app.tasa_igv');

        return $valor * (1 + $igv);
    }

    public function getValorTotalManoObra($moneda = null)
    {
        $detallesTrabajo = $this->detallesTrabajo;
        $tasaIGV = config('app.tasa_igv');
        $totalServicios = 0;
        foreach ($detallesTrabajo as $key => $detalleTrabajo) {
            $totalServicios += $detalleTrabajo->getPrecioVentaFinal($moneda);
        }

        return $totalServicios / (1 + $tasaIGV);
    }

    public function getValorTotalManoObraIGV($moneda = null)
    {
        $valor = $this->getValorTotalManoObra($moneda);
        $igv = config('app.tasa_igv');

        return $valor * (1 + $igv);
    }

    public function getValorTotalTerceros($moneda = null)
    {
        $igv = config('app.tasa_igv');
        $serviciosTerceros = $this->serviciosTerceros()->with('servicioTercero')->get()->all();
        $totalServiciosTerceros = 0;
        foreach ($serviciosTerceros as $key => $servicioTercero) {
            $totalServiciosTerceros += $servicioTercero->getPrecioVenta($moneda);
        }

        return $totalServiciosTerceros / (1 + $igv);
    }

    public function getValorTotalTercerosIGV($moneda = null)
    {
        $valor = $this->getValorTotalTerceros($moneda);
        $igv = config('app.tasa_igv');

        return $valor * (1 + $igv);
    }

    public function getValorTotal($moneda = null)
    {
        return $this->getValorTotalManoObra($moneda) + $this->getValorTotalRepuestos($moneda) + $this->getValorTotalTerceros($moneda);
    }

    public function getValorTotalText($moneda = null)
    {
        return number_format($this->getValorTotal($moneda), 2, '.', '');
    }

    // public function getServiciosTerceros()
    // {
    //     $serviciosTerceros = $this->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
    //         $query->where('tipo_trabajo', 'SERVICIOS TERCEROS');
    //     })->get();

    //     if($serviciosTerceros && $serviciosTerceros->count() == 0) return [];

    //     return $serviciosTerceros;
    // }

    public function getEstadoDescuento()
    {
        $descuentos = $this->descuentos;
        $ultDescuento = $descuentos ? $descuentos->sortBy('fecha_registro')->last() : null;

        return $ultDescuento ? $ultDescuento->getMensajeAprobacion() : '';
    }

    public function isVisibleMessageDiscountRequest()
    {

        $lineas = $this->getLineasTransaccion();
        if ($lineas == null) {
            return false;
        }

        if ($lineas != null && count($lineas)) {
            $last_item_necesidad = $lineas[0];
            $today = Carbon::now();

            $last_time = Carbon::parse($last_item_necesidad->fecha_registro_aprobacion_rechazo_descuento);

            if ($today->diffInHours($last_time) > 1) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getMoneda()
    {
        return $this->moneda;
    }
    public function getTipoCambio()
    {
        return $this->tipo_cambio;
    }
    public function getTC()
    {
        $last_cambio = TipoCambio::where('fecha_registro', '<=', date('Y-m-d'))->orderBy('id_tipo_cambio', 'desc')->first()->cobro;
        $cambio = $this->tipo_cambio;
        if (is_null($cambio)) $cambio = $last_cambio;
        return $cambio;
    }

    public function getLineasTransaccion()
    {
        $necesidadRepuestos = $this->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        if ($necesidadRepuestos) return $necesidadRepuestos->itemsNecesidadRepuestos;
        else return [];
    }

    public function getLinkDetalleHTML()
    {
        $nombreRutaDetalleCot = $this->tipo_trabajo == 'DYP' ? self::$nombreRutaDetalleCotDYP : self::$nombreRutaDetalleCotMEC;

        $ruta = route($nombreRutaDetalleCot, [self::$detalleCotRouteKey => $this->id_cotizacion]);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_cotizacion</a>";
    }

    public function getCuttedString($len, $word)
    {
        $long = strlen($word);
        $final = substr($word, 0, $len);
        if ($long > $len) return $final . '...';
        return $final;
    }


    public function nroRepuestosEnStock()
    {
        $necesidadesRptos = $this->necesidadesRepuestos()->first();
        $cantidad = 0;
        if ($necesidadesRptos) {
            foreach ($necesidadesRptos->itemsNecesidadRepuestos as $itemNecesidadRepuestos) {
                if ($itemNecesidadRepuestos->getDisponibilidad() == "EN STOCK") {
                    $cantidad += 1;
                }
            }
            return $cantidad == 0 ? "-" : $cantidad;
        } else {
            return "-";
        }
    }

    public function nroRepuestosEnImportacion()
    {
        $necesidadesRptos = $this->necesidadesRepuestos()->first();
        $cantidad = 0;
        if ($necesidadesRptos) {
            foreach ($necesidadesRptos->itemsNecesidadRepuestos as $itemNecesidadRepuestos) {
                if ($itemNecesidadRepuestos->getDisponibilidad() == "EN IMPORTACIÓN") {
                    $cantidad += 1;
                }
            }
            return $cantidad == 0 ? "-" : $cantidad;
        } else {
            return "-";
        }
    }

    public function nroRepuestosEnTransito()
    {
        $necesidadesRptos = $this->necesidadesRepuestos()->first();
        $cantidad = 0;
        if ($necesidadesRptos) {
            foreach ($necesidadesRptos->itemsNecesidadRepuestos as  $itemNecesidadRepuestos) {
                if ($itemNecesidadRepuestos->getDisponibilidad() == "EN TRÁNSITO") {
                    $cantidad += 1;
                }
            }
            return $cantidad == 0 ? "-" : $cantidad;
        } else {
            return "-";
        }
    }

    public function nroRepuestosSinStock()
    {
        $necesidadesRptos = $this->necesidadesRepuestos()->first();
        $cantidad = 0;
        if ($necesidadesRptos) {
            foreach ($necesidadesRptos->itemsNecesidadRepuestos as  $itemNecesidadRepuestos) {
                if ($itemNecesidadRepuestos->getDisponibilidad() == "SIN STOCK") {
                    $cantidad += 1;
                }
            }
            return $cantidad == 0 ? "-" : $cantidad;
        } else {
            return "-";
        }
    }

}
