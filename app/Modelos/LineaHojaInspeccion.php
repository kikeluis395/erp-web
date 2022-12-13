<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaHojaInspeccion extends Model
{
    protected $table = "linea_resultado_inspeccion";
    protected $fillable = ['id_hoja_inspeccion','id_elemento_inspeccion','resultado'];
    protected $primaryKey='id_linea_resultado_inspeccion';

    public $timestamps = false;

    public function hojaInspeccion()
    {
        return $this->belongsTo('App\Modelos\HojaInspeccion','id_hoja_inspeccion');
    }
    
    public function elementoInspeccion()
    {
        return $this->belongsTo('App\Modelos\ElementoInspeccion','id_elemento_inspeccion');
    }
}
