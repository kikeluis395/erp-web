<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecepcionOT_EstadoReparacion extends Pivot
{
    //
    protected $table = "recepcion_ot_estado_reparacion";
    protected $primaryKey='id_recepcion_ot_estado_reparacion';
    
    public $timestamps = false;

    public function estadosReparacion()
    {
        return $this->belongsTo('App\Modelos\EstadoReparacion','id_estado_reparacion');
    }
}
