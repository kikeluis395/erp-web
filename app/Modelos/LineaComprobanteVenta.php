<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaComprobanteVenta extends Model
{
    protected $table="linea_comprobante_venta";
    protected $fillable=['cantidad','unidad_medida','codigo_producto','descripcion','tipo_igv','precio_venta','valor_unitario','valor_venta','igv'];
    protected $primaryKey='id_linea_comprobante_venta';
    
    public $timestamps = false;

    public function comprobanteVenta()
    {
    	return $this->belongsTo('App\Modelos\ComprobanteVenta','id_comprobante_venta');
    }

    public function estaCompleto()
    {
        if( $this->cantidad &&
            $this->unidad_medida &&
            $this->codigo_producto &&
            $this->descripcion &&
            $this->tipo_igv &&
            $this->precio_venta >= 0 &&
            $this->monto_sujeto_igv >= 0 &&
            $this->monto_inafecto >= 0 &&
            $this->monto_exonerado >= 0 &&
            $this->total_igv >= 0 )
            return true;
        else
            return false;
    }

    public function getNombreCiaSeguro()
    {
        return $this->nombre_cia_seguro;
    }
}
