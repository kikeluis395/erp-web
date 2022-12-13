<?php

namespace App\Modelos\Ventas;

use Illuminate\Database\Eloquent\Model;

class LineaResultadoInspeccion extends Model
{
    protected $table = "linea_resultado_inspeccion";
    protected $fillable =['nombre_estado_repuesto'];
    protected $primaryKey ="id_linea_resultado_inspeccion";
    public $timestamps = false;

    public function elementoInspeccion()
    {
    	return $this->belongTo('App\Modelos\ElementoInspeccion','id_elemento_inspeccion');
    }

    public function hojaInspeccion()
    {
    	return $this->belongTo('App\Modelos\HojaInspeccion','id_hoja_inspeccion');
    }
}
