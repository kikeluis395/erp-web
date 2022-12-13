<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\Internos\Precio;

class PrecioRepuesto extends Precio
{
    protected $table = 'precio_repuesto';
    protected $primaryKey='id_precio_repuesto';
    protected $fillable = ['id_repuesto', 'monto', 'moneda', 'incluye_igv','id_local','fecha_inicio_aplicacion'];
    public $timestamps = false;

    public function repuesto()
    {
        return $this->belongsTo('App\Modelos\Repuesto','id_repuesto');
    }

    public function getMonto(){
        return $this->monto;
    }
    public function getIncluyeIGV(){
        return $this->incluye_igv;
    }
    public function getMoneda(){
        return $this->moneda;
    }
}
