<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class EstadoReparacion extends Model
{
    protected $table = "estado_reparacion";
    protected $fillable=['nombre_estado_reparacion','nombre_estado_reparacion_interno','nombre_estado_reparacion_filtro'];
    protected $primaryKey='id_estado_reparacion';

    public $timestamps = false;

    public function recepcionOTs()
    {
    	return $this->belongsToMany('App\Modelos\RecepcionOT','recepcion_ot_estado_reparacion','id_estado_reparacion','id_recepcion_ot');
    }

    public function scopePorNombreInterno($query, $nombre_interno)
    {
        return $query->where('nombre_estado_reparacion_interno',$nombre_interno);
    }

    public function semaforos()
    {
        return $this->hasMany('App\Modelos\Semaforo','id_estado_reparacion');
    }
}
