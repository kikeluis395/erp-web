<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaOrdenServicio extends Model
{
    protected $table ="linea_orden_servicio";
    protected $fillable = ['id_orden_servicio','id_servicio_tercero_solicitado','valor_costo'];
    protected $primaryKey='id_linea_orden_servicio';

    public $timestamps = false;

    public function ordenServicio()
    {
        return $this->belongsTo('App\Modelos\OrdenServicio','id_orden_servicio');
    }

    public function getDescripcionServicio()
    {
        return $this->servicioTerceroSolicitado->servicioTercero->descripcion;
    }

    public function getCodigoServicioTercero()
    {
        return $this->servicioTerceroSolicitado->servicioTercero->codigo_servicio_tercero;
    }

    public function servicioTerceroSolicitado()
    {
        return $this->belongsTo('App\Modelos\ServicioTerceroSolicitado','id_servicio_tercero_solicitado');
    }

    public function getCosto($moneda = null)
    {
        $monedaTarget = ($moneda == 'USD' ? 'DOLARES' : 'SOLES');
        $costo = $this->valor_costo ? $this->valor_costo : 0;
        if($this->ordenServicio->moneda != $monedaTarget){
            $tipoCambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            $factorCambio = ($monedaTarget == 'DOLARES' ? 1/$tipoCambio : $tipoCambio);
            $costo = $costo * $factorCambio;
        }
        return $costo;
    }
}
