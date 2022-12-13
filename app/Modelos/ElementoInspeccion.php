<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ElementoInspeccion extends Model
{
    protected $table = "elemento_inspeccion";
    protected $fillable = ['nombre_elemento_inspeccion'];
    protected $primaryKey='id_elemento_inspeccion';

    public $timestamps = false;

    public function lineasHojaInspeccion()
    {
        return $this->hasMany('App\Modelos\LineaHojaInspeccion','id_elemento_inspeccion');
    }

    public function getNombre()
    {
        return $this->nombre_elemento_inspeccion;
    }
}
