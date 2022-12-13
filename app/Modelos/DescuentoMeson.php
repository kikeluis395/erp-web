<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\Internos\IDescuento;
use Carbon\Carbon;

class DescuentoMeson extends Model implements IDescuento
{
    protected $table = "descuento_meson";
    protected $fillable=['porcentaje_aplicado_rptos','porcentaje_aplicado_lubricantes','id_cotizacion_meson','id_usuario_solicitante','id_usuario_aprobador','fecha_aprobacion','es_aprobado'];
    protected $primaryKey='id_descuento_meson';
    
    public $timestamps = false;
    public $incrementing=false;

    public function usuarioAprobador()
    {
    	return $this->belongsTo('App\Modelos\Usuario','id_usuario_aprobador');
    }

    public function usuarioSolicitante()
    {
    	return $this->belongsTo('App\Modelos\Usuario','id_usuario_solicitante');
    }

    public function cotizacionMeson()
    {
    	return $this->belongsTo('App\Modelos\CotizacionMeson','id_cotizacion_meson');
    }

    // IDescuento Implementation
    public function getFuenteDescuento(){
        return 'MESON';
    }

    public function getLocal(){
        return $this->cotizacionMeson->getIdLocal();
    }

    public function getIDFuenteDescuento(){
        return $this->id_cotizacion_meson;
    }

    public function getIDClienteDescuento(){
        return $this->cotizacionMeson->getNumDoc();
    }

    public function getAsesorSolicitante(){
        return $this->usuarioSolicitante->empleado->nombreCompleto();
    }

    public function getFechaSolicitud(){
        return Carbon::parse($this->fecha_registro)->format('d/m/Y');
    }

    public function getPrecioSinDescuento($moneda=null){
        $total = 0;
        foreach ($this->cotizacionMeson->lineasCotizacionMeson as $lineaCotizacion) {
            $total += $lineaCotizacion->getMontoTotal($lineaCotizacion->getFechaRegistroCarbon(),true);
        }
        return $total;
    }

    public function getPrecioConDescuento($moneda=null){
        $total = 0;
        foreach ($this->cotizacionMeson->lineasCotizacionMeson as $lineaCotizacion) {
            $total += $lineaCotizacion->getMontoTotal($lineaCotizacion->getFechaRegistroCarbon(),true) * (1 - ($lineaCotizacion->repuesto->esLubricante() ? $this->porcentaje_solicitado_lubricantes : $this->porcentaje_solicitado_rptos)/100 );
        }
        return $total;
    }

    public function getIdDescuento(){
        return $this->id_descuento_meson;
    }

    // END OF INTERFACE IMPLEMENTATION

    public function getPrecioSinDescuentoTxt($moneda)
    {
        return number_format($this->getPrecioSinDescuento($moneda),2,'.','');
    }

    public function getPrecioConDescuentoTxt($moneda)
    {
        return number_format($this->getPrecioConDescuento($moneda),2,'.','');
    }
}
