<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\Internos\IDescuento;
use Carbon\Carbon;

class Descuento extends Model implements IDescuento
{
    protected $table = "descuento";
    protected $fillable = ['porcentaje_aplicado_mo', 'porcentaje_aplicado_rptos', 'monto_aplicado_mo', 'monto_aplicado_rptos', 'es_aprobado', 'id_hoja_trabajo', 'dni_solicitante', 'dni_aprobador', 'fecha_registro'];
    protected $primaryKey = 'id_descuento';

    public $timestamps = false;
    public $incrementing = false;

    public function empleadoAprobador()
    {
        return $this->belongsTo('App\Modelos\Empleado', 'dni_aprobador');
    }

    public function empleadoSolicitante()
    {
        return $this->belongsTo('App\Modelos\Empleado', 'dni_solicitante');
    }

    public function hojaTrabajo()
    {
        return $this->belongsTo('App\Modelos\HojaTrabajo', 'id_hoja_trabajo');
    }

    public function getPrecio($moneda = null)
    {
        $totalMO = 0;
        foreach ($this->hojaTrabajo->detallesTrabajo as $detalleTrabajo) {
            $totalMO += $detalleTrabajo->getPrecioLista($moneda);
        }
        $totalRptos = 0;
        $totalLubricantes = 0;
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos->first();
        if ($necesidadRepuestos) {
            foreach ($necesidadRepuestos->itemsNecesidadRepuestos as $itemsRepuestos) {
                if ($itemsRepuestos->id_repuesto && !$itemsRepuestos->esLubricante()) $totalRptos += $itemsRepuestos->getMontoTotal($itemsRepuestos->getFechaRegistroCarbon(), true);
                elseif ($itemsRepuestos->id_repuesto && $itemsRepuestos->esLubricante()) $totalLubricantes += $itemsRepuestos->getMontoTotal($itemsRepuestos->getFechaRegistroCarbon(), true);
            }
        }
        $totalST = 0;
        foreach ($this->hojaTrabajo->serviciosTerceros as $servicioTercero) {
            $totalST += $servicioTercero->getPrecioVenta($moneda);
        }
        return number_format($totalMO + $totalRptos + $totalLubricantes + $totalST, 2, '.', '');
    }

    //precio sin descunetos por aprobar, considerando los antiguos y con la marca
    public function getPrecioSinDescuentoPeroConMarca($moneda = null)
    {

        $totalRepuestos = 0;
        $totalDescuentoMarca = 0;

        if ($this->hojaTrabajo->necesidadesRepuestos() != null) {
            $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
            if ($necesidadRepuestos != null) {
                $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();


                if ($necesidadRepuestos) {
                    $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
                    if ($repuestosAprobados->count() == 0) $repuestos = [];

                    foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                        $totalRepuestos += $repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(), true);
                        //dd($totalRepuestos);
                        $totalDescuentoMarca += $repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), true, $repuestoAprobado->descuento_unitario, 0);
                    }
                }
            }
        }



        //MO
        $totalMO = 0;
        foreach ($this->hojaTrabajo->detallesTrabajo as $detalleTrabajo) {
            $totalMO += $detalleTrabajo->getPrecioLista($moneda);
        }
        //SERVICIO TERCERO
        $totalST = 0;
        foreach ($this->hojaTrabajo->recepcionOT->getServiciosTerceros() as $servicioTercero) {
            $totalST += $servicioTercero->getSubTotal($moneda);
        }

        $total = $totalST + $totalRepuestos + $totalMO - $totalDescuentoMarca;

        return $total;
    }

    public function getPrecioConDescuentosSiFueraAprobarse($moneda = null)
    {
        $totalMO = 0;
        foreach ($this->hojaTrabajo->detallesTrabajo as $detalleTrabajo) {
            $totalMO += ($detalleTrabajo->getPrecioLista($moneda) * (100 - $this->porcentaje_aplicado_mo) / 100);
        }

        $totalRepuestos = 0;
        $totalLubricantes = 0;
        $totalRepuestosDescuento = 0;
        $totalDescuentoMarca = 0;
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos->first();

        if ($necesidadRepuestos) {
            $repuestosAprobados = $necesidadRepuestos->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
            if ($repuestosAprobados->count() == 0) $repuestos = [];

            foreach ($repuestosAprobados as $key => $repuestoAprobado) {
                //$totalRepuestos += $repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(),true);
                $dscto_dealer = (100 - $repuestoAprobado->descuento_unitario_dealer_por_aprobar) / 100;
                $dscto_marca = (100 - $repuestoAprobado->descuento_unitario) / 100;

                $totalRepuestos += ($repuestoAprobado->getMontoTotal($repuestoAprobado->getFechaRegistroCarbon(), true) * ($dscto_marca  * $dscto_dealer));
                // dd($totalRepuestos);
            }
        }


        $totalST = 0;

        foreach ($this->hojaTrabajo->serviciosTerceros as $servicioTercero) {
            $totalST += ($servicioTercero->getSubTotal($moneda) * (100 - $this->porcentaje_aplicado_servicios_terceros) / 100);
        }

        return number_format($totalMO + $totalRepuestos + $totalST, 2, '.', '');
    }

    public function getPrecioConDescuento($moneda = null)
    {
        $totalMO = 0;
        foreach ($this->hojaTrabajo->detallesTrabajo as $detalleTrabajo) {
            $totalMO += $detalleTrabajo->getPrecioLista($moneda);
        }
        $totalRptos = 0;
        $totalLubricantes = 0;
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos->first();
        if ($necesidadRepuestos) {
            foreach ($necesidadRepuestos->itemsNecesidadRepuestos as $itemsRepuestos) {
                if ($itemsRepuestos->id_repuesto && !$itemsRepuestos->esLubricante()) $totalRptos += $itemsRepuestos->getMontoTotal($itemsRepuestos->getFechaRegistroCarbon(), true);
                elseif ($itemsRepuestos->id_repuesto && $itemsRepuestos->esLubricante()) $totalLubricantes += $itemsRepuestos->getMontoTotal($itemsRepuestos->getFechaRegistroCarbon(), true);
            }
        }
        $totalST = 0;
        foreach ($this->hojaTrabajo->recepcionOT->getServiciosTerceros() as $servicioTercero) {
            $totalST += $servicioTercero->getSubTotal($moneda);
        }
        $total = $totalMO * (1 - $this->porcentaje_aplicado_mo / 100) + $totalRptos * (1 - $this->porcentaje_aplicado_rptos / 100) + $totalLubricantes * (1 - $this->porcentaje_aplicado_lubricantes / 100) + $totalST * (1 - $this->porcentaje_aplicado_servicios_terceros / 100);

        return number_format($total, 2, '.', '');
    }

    public function getMontoDescuentoMO($moneda = null)
    {
        $total = 0;
        foreach ($this->hojaTrabajo->detallesTrabajo as $detalleTrabajo) {
            $total += $detalleTrabajo->getPrecioLista($moneda);
        }
        return number_format($total * $this->porcentaje_aplicado_mo / 100, 2, '.', '');
    }

    public function getMontoDescuentoRptos($moneda = null)
    {
        $total = 0;
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos->first();
        if ($necesidadRepuestos) {
            foreach ($necesidadRepuestos->itemsNecesidadRepuestos as $itemsRepuestos) {
                if ($itemsRepuestos->id_repuesto && !$itemsRepuestos->esLubricante()) $total += $itemsRepuestos->getMontoTotal($itemsRepuestos->getFechaRegistroCarbon(), true);
            }
        }
        return number_format($total * $this->porcentaje_aplicado_rptos / 100, 2, '.', '');
    }

    public function getMontoDescuentoLubricantes($moneda = null)
    {
        $total = 0;
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos->first();
        if ($necesidadRepuestos) {
            foreach ($necesidadRepuestos->itemsNecesidadRepuestos as $itemsRepuestos) {
                if ($itemsRepuestos->id_repuesto && $itemsRepuestos->esLubricante()) $total += $itemsRepuestos->getMontoTotal($itemsRepuestos->getFechaRegistroCarbon(), true);
            }
        }
        return number_format($total * $this->porcentaje_aplicado_lubricantes / 100, 2, '.', '');
    }

    public function getMontoDescuentoServiciosTerceros($moneda = null)
    {
        $total = 0;
        $serviciosTerceros = $this->hojaTrabajo->recepcionOT->getServiciosTerceros();
        if ($serviciosTerceros) {
            foreach ($serviciosTerceros as $servicioTercero) {
                $total += $servicioTercero->getSubTotal($moneda);
            }
        }
        return number_format($total * $this->porcentaje_aplicado_servicios_terceros / 100, 2, '.', '');
    }

    public function getMensajeAprobacion()
    {
        if ($this->es_aprobado === null) {
            return 'SOLICITUD DE DESCUENTO EN PROCESO';
        } elseif ($this->es_aprobado == 0) {
            return 'SOLICITUD DE DESCUENTOS RECHAZADA';
        } elseif ($this->es_aprobado == 1) {
            return 'SOLICITUD DE DESCUENTO APROBADA';
        }
    }

    // IDescuento Implementation
    public function getFuenteDescuento()
    {
        return 'OT';
    }


    public function getLocal()
    {
        return $this->hojaTrabajo->recepcionOT->localEmpresa->nombre_local;
    }

    public function getIDFuenteDescuento()
    {
        return $this->hojaTrabajo->getOTNroOT();
    }

    public function getIDClienteDescuento()
    {
        return $this->hojaTrabajo->getPlacaAuto();
    }

    public function getAsesorSolicitante()
    {
        return $this->empleadoSolicitante->nombreCompleto();
    }

    public function getFechaSolicitud()
    {
        return Carbon::parse($this->fecha_registro)->format('d/m/Y');
    }

    public function getPrecioSinDescuento($moneda = null)
    {
        return $this->getPrecio($moneda);
    }

    // getPrecioConDescuento ya esta utilizado e implementado

    public function getIdDescuento()
    {
        return $this->id_descuento;
    }

    public function getMontoLubricantes()
    {
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos;

        $precios_regulares = 0;
        $precios_cdescuento = 0;

        if ($necesidadRepuestos->count() > 0) {
            $descuentosUnitarios = $necesidadRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2);
            if ($descuentosUnitarios->count() > 0) {

                foreach ($descuentosUnitarios as $item) {
                    if ($item->repuesto->esLubricante()) {
                        $precios_regulares += (float) number_format($item->getMontoUnitario($item->getFechaRegistroCarbon(), true), 2);
                        $precios_cdescuento += (float) number_format($item->getMontoConDescMarcaDealer($item->getFechaRegistroCarbon(), true, $item->descuento_unitario, $item->descuento_unitario_dealer_por_aprobar), 2);
                    }
                }
            }
        }
        return $precios_regulares - $precios_cdescuento;
    }

    public function getMontoRepuestos()
    {
        $necesidadRepuestos = $this->hojaTrabajo->necesidadesRepuestos;

        $precios_regulares = 0;
        $precios_cdescuento = 0;

        if ($necesidadRepuestos->count() > 0) {
            $descuentosUnitarios = $necesidadRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2);
            if ($descuentosUnitarios->count() > 0) {

                foreach ($descuentosUnitarios as $item) {
                    if (!$item->repuesto->esLubricante()) {
                        $precios_regulares += (float) number_format($item->getMontoUnitario($item->getFechaRegistroCarbon(), true), 2);
                        $precios_cdescuento += (float) number_format($item->getMontoConDescMarcaDealer($item->getFechaRegistroCarbon(), true, $item->descuento_unitario, $item->descuento_unitario_dealer_por_aprobar), 2);
                    }
                }
            }
        }
        return $precios_regulares - $precios_cdescuento;
    }

    public function getPlaca()
    {
        $in = $this->hojaTrabajo;
        if (!is_null($in)) {
            $on = $in->placa_auto;
            if (!is_null($on)) return $on;
        }
        return '-';
    }
}
