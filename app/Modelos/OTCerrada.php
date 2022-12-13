<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class OTCerrada extends Model
{
    protected $table="ot_cerrada";
    protected $fillable=['razon_cierre', 'id_recepcion_ot'];
    protected $primaryKey='id_ot_cerrada';
    
    public $timestamps = false;

    public function recepcionOT()
    {
    	return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }
}
