<?php

namespace App\Modelos;

use App\Modelos\Administracion\PrecioDYP;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\RecepcionOT;
use Carbon\Carbon;

class Cotizacion extends Model
{
    //
    protected $table = "cotizacion";
    protected $fillable = ['id_cotizacion', 'observacion', 'fecha_hora_ingreso', 'fecha_hora_entrega', 'fecha_registro', 'id_recepcion_ot', 'id_valuacion', 'id_cia_seguro'];
    protected $primaryKey = 'id_cotizacion';

    public $timestamps = false;

    public static $nombreRutaDetalleCotDYP = 'detalle_trabajos.index';
    public static $nombreRutaDetalleCotMEC = 'mecanica.detalle_trabajos.index';
    public static $detalleCotRouteKey = 'id_cotizacion';

    public function hojaTrabajo()
    {
        return $this->hasOne('App\Modelos\HojaTrabajo', 'id_cotizacion');
    }

    public function getHojaTrabajo()
    {
        $hojaTrabajo = $this->hojaTrabajo;
        if ($hojaTrabajo) {
            return $hojaTrabajo;
        } else {
            return $this->hojaTrabajo()->get();
        }
    }

    public function recepcionOT()
    {
        return $this->belongsTo('App\Modelos\RecepcionOT', 'id_recepcion_ot');
    }

    public function getRecepcionOT()
    {
        $recepcionOT = $this->recepcionOT;
        if ($recepcionOT) {
            return $recepcionOT;
        } else {
            return $this->recepcionOT()->get();
        }
    }

    public function getDetallesTrabajoCompleto()
    {
        $detallesTrabajo = $this->getHojaTrabajo()->detallesTrabajo()->whereHas('operacionTrabajo', function ($query) {
            $query->where('tipo_trabajo', '!=', 'SERVICIOS TERCEROS');
        })->get()->all();

        return $detallesTrabajo;
    }

    public function getServiciosTerceros()
    {
        $serviciosTerceros = $this->getHojaTrabajo()->serviciosTerceros()->with('servicioTercero')->get()->all();

        return $serviciosTerceros;
    }

    public function OTsAsociables()
    {
        $hojaTrabajo = $this->getHojaTrabajo();
        $placa = $hojaTrabajo->getPlacaAuto();
        $operador = $hojaTrabajo->tipo_trabajo == 'DYP' ? '=' : '!=';
        $OTs = RecepcionOT::whereHas('hojaTrabajo', function ($query) use ($placa, $operador) {
            $query->where('placa_auto', $placa);
            $query->where('tipo_trabajo', $operador, 'DYP');
        })->with('hojaTrabajo')->get();

        $OTsPosibles = $OTs->filter(function (RecepcionOT $ot) {
            return !in_array($ot->estadoActual()[0]->nombre_estado_reparacion_interno, ['entregado', 'entregado_hotline', 'vehiculo_listo', 'cerrado', 'vehiculo_listo_hotline', 'liquidado_hotline', 'liquidado']);
        })->all();

        return $OTsPosibles;
    }

    public function asociarOT($nroOT)
    {
        $recepcionOT = RecepcionOT::where((new RecepcionOT)->getKeyName(), $nroOT)->first();
        $this->id_recepcion_ot = $recepcionOT->id_recepcion_ot;
        $this->es_habilitado = 0;
        return $this->save();
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

        return $listaItems;
    }

    public function valuacion()
    {
        return $this->belongsTo('App\Modelos\Valuacion', 'id_valuacion');
    }

    public function getLinkDetalleHTML()
    {
        $nombreRutaDetalleCot = $this->hojaTrabajo->tipo_trabajo == 'DYP' ? self::$nombreRutaDetalleCotDYP : self::$nombreRutaDetalleCotMEC;

        $ruta = route($nombreRutaDetalleCot, [self::$detalleCotRouteKey => $this->id_cotizacion]);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_cotizacion</a>";
    }

    public function ciaSeguro()
    {
        return $this->belongsTo('App\Modelos\CiaSeguro', 'id_cia_seguro');
    }

    public function getEstado()
    {
        $vendido = $this->es_habilitado;
        $recepcionOT = $this->recepcionOT()->get()->count();

        if ($recepcionOT === 0) {
            if ($vendido === 1) return 'PENDIENTE';
            else return 'CERRADA';
        }
        return 'VENDIDA';
    }
    public function getMotivoCierre()
    {
        $out = $this->razon_cierre;
        if (!is_null($out)) return $out;
        return '-';
    }

    public function getValorTotal()
    {
        $hojaTrabajo = $this->hojaTrabajo;
        $moneda = $hojaTrabajo->moneda;
        $detallesTrabajo = $hojaTrabajo->detallesTrabajo;

        $monedaCalculos = $moneda == "SOLES" ? "PEN" : "USD";
        $totalServicios = 0;
        $totalServiciosDescuento = 0;
        foreach ($detallesTrabajo as $key => $detalleTrabajo) {
            $totalServicios += $detalleTrabajo->getPrecioLista($monedaCalculos);
            $totalServiciosDescuento += $detalleTrabajo->getDescuento($monedaCalculos);
        }

        $totalRepuestos = 0;
        $totalRepuestosDescuento = 0;
        $totalDescuentoMarca = 0;
        $repuestosAprobados = collect([]);
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            if ($repuestosAprobados->count() == 0) $repuestos = [];
            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                $totalRepuestos += $repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(), true);
                $totalRepuestosDescuento += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, $repuestoAprobado->descuento_unitario_dealer ?? -1);
                $totalDescuentoMarca += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, 0);
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

    public function getMontoDolares()
    {
        $last_cambio = TipoCambio::where('fecha_registro', '<=', date('Y-m-d'))->orderBy('id_tipo_cambio', 'desc')->first()->cobro;
        $moneda = $this->hojaTrabajo->moneda;

        $cambio = $this->hojaTrabajo->tipo_cambio;
        if (is_null($cambio)) $cambio = $last_cambio;

        $valor_total = $this->getValorTotal();
        $sin_igv = $valor_total / 1.18;


        if ($moneda == 'DOLARES') return number_format($sin_igv, 2);
        return number_format($sin_igv / $cambio, 2);
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
                $id_marca_auto = $this->hojaTrabajo->vehiculo->id_marca_auto;
                $id_cia_seguro = $this->id_cia_seguro;
        
                $fecha_registro = Carbon::parse($this->fecha_registro);
                $id_marca_auto = $this->hojaTrabajo->vehiculo->id_marca_auto;
                $panhos = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $id_cia_seguro)->where('tipo', 'PANHOS')
                    ->where('fecha_inicio_aplicacion', '<', $fecha_registro)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();
                $hh = PrecioDYP::where('id_marca_auto', $id_marca_auto)->where('id_cia_seguro', $id_cia_seguro)->where('tipo', 'HH')
                    ->where('fecha_inicio_aplicacion', '<', $fecha_registro)->orderBy('fecha_inicio_aplicacion', 'asc')->get()->last();
        
                if ($panhos && $hh) {
                    $this->precio_dyp = json_encode(["PANHOS" => $panhos->id_precio_mo_dyp, "HH" => $hh->id_precio_mo_dyp]);
                    $this->save();
                }
            }
        }
    }
}
