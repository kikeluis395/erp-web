<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FacturasAnuladasPorNCND extends Model
{
    protected $table="facturas_anuladas_por_ncnd";
    protected $fillable=['nro_factura','fecha_entrega','id_recepcion_ot','id_cotizacion_meson'];
    protected $primaryKey='id_facturas_anuladas_por_ncnd';
    
    public function recepcionOT()
    {
    	return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }

    public function cotizacionMeson()
    {
        return $this->belongsTo('App\Modelos\CotizacionMeson','id_cotizacion_meson');
    }
}
