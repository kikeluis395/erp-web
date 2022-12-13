<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class EntregadoReparacion extends Model
{
    protected $table = "entregado_reparacion";
    protected $fillable=['fecha_entrega'];
    protected $primaryKey='id_entregado_reparacion';
    
    public $timestamps = false;

    public function recepcionOT()
    {
    	return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }
}
