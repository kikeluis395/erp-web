<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleTrabajo extends Model
{
    protected $table = "detalle_trabajo";
    protected $fillable = ['id_detalle_trabajo', 'valor_trabajo_estimado', 'id_operacion_trabajo', 'id_hoja_trabajo'];
    protected $primaryKey = 'id_detalle_trabajo';

    public $timestamps = false;

    public function hojaTrabajo()
    {
        return $this->belongsTo('App\Modelos\HojaTrabajo', 'id_hoja_trabajo');
    }

    public function operacionTrabajo()
    {
        return $this->belongsTo('App\Modelos\OperacionTrabajo', 'id_operacion_trabajo');
    }

    public function precio_dyp()
    {
        return $this->hasOne('App\Modelos\Administracion\PrecioDYP', 'id_precio_mo_dyp', 'id_precio_mo_dyp');
    }
    public function precio_mec()
    {
        return $this->hasOne('App\Modelos\Administracion\PrecioMEC', 'id_precio_mo_mec', 'id_precio_mo_mec');
    }

    public function getCodOperacionTrabajo()
    {
        $operacionTrabajo = $this->operacionTrabajo()->first();
        return $operacionTrabajo->codOperacionKeyName();
    }

    public function getValorTextoCompleto()
    {
        $operacionTrabajo = $this->operacionTrabajo()->first();
        $pos = $operacionTrabajo->getPosicionUnidad();
        $unidad = $operacionTrabajo->getUnidad();

        if ($pos == "PRE") {
            return $unidad . " " . $this->valor_trabajo_estimado;
        } elseif ($pos == "POST") {
            return $this->valor_trabajo_estimado . " " . $unidad;
        }
    }


    public function getDeletedTransactionsCot()
    {
        $id =  $this->hojaTrabajo->cotizacion->id_cotizacion;
        $sql = "SELECT * FROM track_deleted_transactions
                where (origen = 'ServicioTerceroSolicitadoCot' OR
                origen = 'DetalleTrabajoCot' OR
                origen = 'ItemNecesidadRepuestosCot')
                AND id_contenedor_origen = $id";
        $results = DB::select(DB::raw($sql));

        return $results;
    }
    public function getDeletedTransactionsOT()
    {
        $id =  $this->hojaTrabajo->recepcionOT->id_recepcion_ot;
        $sql = "SELECT * FROM track_deleted_transactions
                where (origen = 'ServicioTerceroSolicitadoOT' OR
                origen = 'DetalleTrabajoOT' OR
                origen = 'ItemNecesidadRepuestosOT')
                AND id_contenedor_origen = $id";
        $results = DB::select(DB::raw($sql));

        return $results;
    }

    public function firstOperacionTrabajo()
    {
        return $this->operacionTrabajo()->first()->descripcion;
    }

    public function getUnidad()
    {
        $operacionTrabajo = $this->operacionTrabajo()->first();
        $pos = $operacionTrabajo->getPosicionUnidad();
        $unidad = $operacionTrabajo->getUnidad();

        if ($pos == "PRE") {
            return $unidad . " ";
        } elseif ($pos == "POST") {
            return " " . $unidad;
        }
    }

    public function unidadPre()
    {
        $operacionTrabajo = $this->operacionTrabajo()->first();
        $pos = $operacionTrabajo->getPosicionUnidad();
        if ($pos == "PRE") {
            return true;
        }
        return false;
    }

    public function getNombreDetalleTrabajo()
    {
        $operacion = $this->operacionTrabajo;
        if (!is_null($operacion)) {
            if (in_array($operacion->tipo_trabajo, ["GLOBAL-HORAS-MEC", "GLOBAL-PANHOS", "GLOBAL-HORAS-CARR"])) {
                return $this->detalle_trabajo_libre;
            } else {
                return $operacion->descripcion;
            }
        }
        return "Sin operacion de trabajo"; ///PORQUE FALLA EL ID_OPERACION_TRABAJO
    }

    public function getPrecioListaUnitario($moneda = null, $incluyeIGV = true)
    {
        $monedaTarget = ($moneda == 'USD' ? 'DOLARES' : 'SOLES');
        $tasaIGV = config('app.tasa_igv');
        $requiereConversion = false;
        $precioVenta = 0;

        if ($this->hojaTrabajo->tipo_trabajo == 'DYP') {
            $elementoPrecio = $this->precio_dyp;
            $marca = $elementoPrecio->id_marca_auto;
            $cia = $elementoPrecio->id_cia_seguro;

            $idSeguro = ($this->hojaTrabajo->id_recepcion_ot ? $this->hojaTrabajo->recepcionOT->id_cia_seguro : $this->hojaTrabajo->cotizacion->id_cia_seguro);
            $idMarca = $this->hojaTrabajo->vehiculo->id_marca_auto;

            // if ($marca != $idMarca || $cia != $idSeguro) {
            //     // dd($this->hojaTrabajo->recepcionOT);
            //     if ($this->hojaTrabajo->id_recepcion_ot) {
            //         $this->hojaTrabajo->recepcionOT->updatePrecio();
            //         $this->updateEstimatedPrice();
            //     } else if ($this->hojaTrabajo->cotizacion) {
            //         $this->hojaTrabajo->cotizacion->updatePrecio();
            //         $this->updateEstimatedPrice();
            //     }
            // }


            $operacion = $this->operacionTrabajo;
            if (!is_null($operacion)) {
                if (in_array($this->operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) {
                    $tipoTrabajo = 'PANHOS';
                } else {
                    $tipoTrabajo = 'HH';
                }
            } else {
                $tipoTrabajo = '--'; ///PORQUE FALLA EL ID_OPERACION_TRABAJO
            }

            // $elementoPrecio = DB::table('precio_mo_dyp')->where('id_marca_auto', $idMarca)->where('id_cia_seguro', $idSeguro)->where('tipo', $tipoTrabajo)->first();


            if (!is_null($elementoPrecio)) {
                $requiereConversion = ($elementoPrecio->moneda != $monedaTarget);
                if ($incluyeIGV) {
                    $precioVenta = ($elementoPrecio->incluye_igv ? $elementoPrecio->precio_valor_venta : $elementoPrecio->precio_valor_venta * (1 + $tasaIGV));
                } else {
                    $precioVenta = ($elementoPrecio->incluye_igv ? $elementoPrecio->precio_valor_venta / (1 + $tasaIGV) : $elementoPrecio->precio_valor_venta);
                }
            }
        } else {
            $idLocal = $this->hojaTrabajo->empleado->id_local;
            $tipoTrabajo = 'MO';
            // $elementoPrecio = DB::table('precio_mo_mec')->where('id_local_empresa', $idLocal)->where('tipo', $tipoTrabajo)->first();
            $elementoPrecio = $this->precio_mec;

            if (!is_null($elementoPrecio)) {
                $requiereConversion = ($elementoPrecio->moneda != $monedaTarget);
                if ($incluyeIGV) {
                    $precioVenta = ($elementoPrecio->incluye_igv ? $elementoPrecio->precio_valor_venta : $elementoPrecio->precio_valor_venta * (1 + $tasaIGV));
                } else {
                    $precioVenta = ($elementoPrecio->incluye_igv ? $elementoPrecio->precio_valor_venta / (1 + $tasaIGV) : $elementoPrecio->precio_valor_venta);
                }
            }
        }

        if ($requiereConversion) {
            if (is_null($this->hojaTrabajo->tipo_cambio)) {
                $tipoCambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            } else {
                $tipoCambio = $this->hojaTrabajo->tipo_cambio;
            }

            $factorCambio = ($monedaTarget == 'DOLARES' ? 1 / $tipoCambio : $tipoCambio);
            $precioVenta = $precioVenta * $factorCambio;
        }
        return number_format($precioVenta, 2, '.', '');
    }

    public function getPrecioLista($moneda = null, $incluyeIGV = true)
    {
        return number_format($this->valor_trabajo_estimado * $this->getPrecioListaUnitario($moneda, $incluyeIGV), 2, '.', '');
    }

    public function getDescuentoUnitario($moneda = null, $incluyeIGV = true, $aprobado = true)
    {
        if ($aprobado) {
            $descuento = $this->hojaTrabajo->descuentos()->where('es_aprobado', 1)->orderBy('fecha_registro', 'desc')->first();
        } else {
            $descuento = $this->hojaTrabajo->descuentos()->orderBy('fecha_registro', 'desc')->first();
        }

        $tasaDescuento = 0;
        if ($descuento) {
            $tasaDescuento = $descuento->porcentaje_aplicado_mo / 100;
        }

        return number_format($this->getPrecioListaUnitario($moneda, $incluyeIGV) * $tasaDescuento, 2, '.', '');
    }

    public function getDescuento($moneda = null, $incluyeIGV = true, $aprobado = true)
    {
        return number_format($this->getDescuentoUnitario($moneda, $incluyeIGV, $aprobado) * $this->valor_trabajo_estimado, 2, '.', '');
    }

    public function getSubTotalUnitario($moneda = null, $incluyeIGV = true)
    {
        return number_format($this->getPrecioListaUnitario($moneda, $incluyeIGV) - $this->getDescuentoUnitario($moneda, $incluyeIGV), 2, '.', '');
    }

    public function getSubTotal($moneda = null, $incluyeIGV = true)
    {
        return number_format($this->getPrecioLista($moneda, $incluyeIGV) - $this->getDescuento($moneda, $incluyeIGV), 2, '.', '');
    }

    public function getPrecioVentaFinal($moneda = null, $incluyeIGV = true)
    {
        return number_format($this->getPrecioLista($moneda, $incluyeIGV) - $this->getDescuento($moneda, $incluyeIGV), 2, '.', '');
    }

    public function updateEstimatedPrice()
    {
        $tipoTrabajo = null;
        $hojaTrabajo = $this->hojaTrabajo;

        if (in_array($this->operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) $tipoTrabajo = 'PANHOS';
        else $tipoTrabajo = 'HH';

        $es_ot = $hojaTrabajo->id_recepcion_ot != null;
        $es_coti = $hojaTrabajo->id_cotizacion != null;

        $element = null;
        if ($es_ot) $element = $hojaTrabajo->recepcionOT;
        else if ($es_coti) $element = $hojaTrabajo->cotizacion;
        $price = null;
        if (($es_ot || $es_coti) && $element) $price = $element->precio_dyp;
        if ($price) $price = (array)json_decode($price);

        if ($price && $tipoTrabajo) $this->id_precio_mo_dyp = $price[$tipoTrabajo];
        $this->save();
    }
}
