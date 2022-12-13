<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ServicioTerceroSolicitado extends Model
{
    protected $table="servicio_tercero_solicitado";
    protected $fillable=['id_proveedor','id_hoja_trabajo','id_servicio_tercero','id_usuario_registro'];
    protected $primaryKey='id_servicio_tercero_solicitado';
    
    public $timestamps = false;

    public function hojaTrabajo()
    {
    	return $this->belongsTo('App\Modelos\HojaTrabajo','id_hoja_trabajo');
    }

    public function proveedor()
    {
    	return $this->belongsTo('App\Modelos\Proveedor','id_proveedor');
    }

    public function servicioTercero()
    {
        return $this->belongsTo('App\Modelos\ServicioTercero', 'id_servicio_tercero');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo('App\Modelos\Usuario','id_usuario_registro');
    }

    public function getCodigoServicioTercero()
    {
        return $this->servicioTercero->codigo_servicio_tercero;
    }

    public function getDescripcion()
    {
        return $this->servicioTercero->descripcion;
    }

    public function getNombreProveedor()
    {
        return $this->proveedor ? $this->proveedor->nombre_proveedor : null;
    }

    public function obtenerOC()
    {
        return '';
    }

    public function getSubTotal($moneda = null, $incluyeIGV = true)
    {
        $monedaTextInput = $moneda == 'USD' ? "DOLARES" : "SOLES";
        $monedaST = $this->servicioTercero->moneda;
        $response = 0;
        if($monedaTextInput == $monedaST){
            $response = number_format($this->servicioTercero->pvp, 2, '.','');
        } else {
            if(is_null($this->hojaTrabajo->tipo_cambio)){
                $tipoCambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            } else {
                $tipoCambio = $this->hojaTrabajo->tipo_cambio;
            }

            if($monedaST == "SOLES"){
                $response = number_format($this->servicioTercero->pvp / $tipoCambio, 2, '.','');
            } else {
                $response = number_format($this->servicioTercero->pvp * $tipoCambio, 2, '.','');
            }
        }

        if($incluyeIGV) {        
            return $response ;
        }

        $tasaIGV = config('app.tasa_igv');
        return $response / (1 + $tasaIGV);
    }

    public function getValorVenta($moneda = null)
    {
        $tasaIGV = config('app.tasa_igv');
        return number_format(($this->getSubTotal($moneda) - $this->getDescuento($moneda))/ (1+$tasaIGV), 2, '.','');
    }

    public function getIGV($moneda = null)
    {
        $tasaIGV = config('app.tasa_igv');
        return number_format($this->getValorVenta($moneda) * $tasaIGV,2, '.','');
    }

    public function getPrecioVenta($moneda = null)
    {
        return number_format($this->getSubTotal($moneda) - $this->getDescuento($moneda), 2, '.','');
    }

    public function getDescuentoUnitario($moneda = null,$incluyeIGV = true, $aprobado = true)
    {
        if($aprobado){
            $descuento = $this->hojaTrabajo->descuentos()->where('es_aprobado',1)->orderBy('fecha_registro','desc')->first();
        }else{
            $descuento = $this->hojaTrabajo->descuentos()->orderBy('fecha_registro','desc')->first();
        }

        $tasaDescuento = 0;
        if($descuento){
            $tasaDescuento = $descuento->porcentaje_aplicado_servicios_terceros/100;
        }
        #if($incluyeIGV){
            return number_format($this->getSubTotal($moneda,$incluyeIGV) * $tasaDescuento, 2, '.', '');
        #}
        return number_format($this->getValorVenta($moneda,$incluyeIGV), 2, '.', '');
    }

    
    public function getDescuento($moneda = null,$incluyeIGV = true, $aprobado = true)
    {
        return number_format($this->getDescuentoUnitario($moneda,$incluyeIGV, $aprobado), 2, '.', '');
    }

    public function lineaOrdenServicio(){
        return $this->hasOne('App\Modelos\LineaOrdenServicio','id_servicio_tercero_solicitado');
    }

    public function obtenerOrdenServicio(){
        if(is_null($this->lineaOrdenServicio)){
            return "-";
        } else {
            return $this->lineaOrdenServicio->ordenServicio->id_orden_servicio;
        }
        
    }
    public function tieneOrdenServicio(){
        if(is_null($this->lineaOrdenServicio)){
            return false;
        } else {
            return true;
        }
        
    }

    public function getLinkDetalleHTML()
    {
        $nombreRutaDetalleCotMeson = 'hojaOrdenServicio';

        $ruta = route($nombreRutaDetalleCotMeson, $this->lineaOrdenServicio->ordenServicio->id_orden_servicio);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->lineaOrdenServicio->ordenServicio->id_orden_servicio</a>";
    }
}
