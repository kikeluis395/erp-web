<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrdenServicio extends Model
{
    protected $table ="orden_servicio";
    protected $fillable = ['id_usuario_registro','es_aprobado','fecha_respuesta','id_usuario_respuesta','id_factura_compra'];
    protected $primaryKey='id_orden_servicio';

    public $timestamps = false;

    public function usuarioRegistro(){
        return $this->belongsTo('App\Modelos\Usuario','id_usuario_registro');
    }

    public function getNombreUsuarioRegistro(){
        return $this->usuarioRegistro->username;
    }

    public function lineasOrdenServicio()
    {
        return $this->hasMany('App\Modelos\LineaOrdenServicio','id_orden_servicio');
    }

    public function usuarioRespuesta()
    {
        return $this->belongsTo('App\Modelos\Usuario','id_usuario_registro');
    }

    public function getNombreUsuarioRespuesta(){
        return $this->usuarioRespuesta->username;
    }

    public function getCostoTotal($moneda = null)
    {
        $lineasOrdenServicio = $this->lineasOrdenServicio()->get();
        $total = 0;
        foreach ($lineasOrdenServicio as $key => $lineaOrdenServicio) {
            $total += $lineaOrdenServicio->getCosto($moneda);
        }
        return $total;
    }

    public function getMontoIGV($moneda = null)
    {
        $tasaIGV = config('app.tasa_igv');
        $monto = $this->getCostoTotal($moneda) * $tasaIGV;
        return $monto;
    }

    public function getPrecioTotal($moneda = null)
    {
        $precio = $this->getMontoIGV($moneda) + $this->getCostoTotal($moneda);
        return $precio;
    }

    public function getCantServicios()
    {
        $lineasOrdenServicio = $this->lineasOrdenServicio()->get();
        return $lineasOrdenServicio->count();
    }

    public function getFechaRegistroText()
    {
        return $this->fecha_registro ? Carbon::parse($this->fecha_registro)->format('d/m/Y') : null;
    }

    public function getFechaRespuestaText()
    {
        return $this->fecha_respuesta ? Carbon::parse($this->fecha_respuesta)->format('d/m/Y') : null;
    }

    public function getLinkDetalleHTML()
    {
        $nombreRutaDetalleCotMeson = 'hojaOrdenServicio';

        $ruta = route($nombreRutaDetalleCotMeson, $this->id_orden_servicio);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_orden_servicio</a>";
    }

    
}
