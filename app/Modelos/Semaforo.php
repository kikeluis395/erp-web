<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Semaforo extends Model
{
    protected $table = "semaforo";
    protected $fillable=['color_css','tope_cantidad_dias'];
    protected $primaryKey='id_semaforo';

    public $timestamps = false;

    public function estadoReparacion()
    {
        return $this->belongsTo('App\Modelos\EstadoReparacion','id_estado_reparacion');
    }
}
