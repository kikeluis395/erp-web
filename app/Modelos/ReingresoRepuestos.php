<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ReingresoRepuestos extends Model
{
    protected $table="reingreso_repuestos";
    protected $fillable=['id_recepcion_ot ', 'fecha_registro', 'usuario_registro'];
    protected $primaryKey='id_reingreso_repuestos';

    public $timestamps = false;

    public function lineasReingresoRepuestos()
    {
        return $this->hasMany('App\Modelos\LineaReingresoRepuestos','id_reingreso_repuestos');
    }

    public function recepcionOT()
    {
        return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }

    public function usuario() {
        return $this->belongsTo('App\Modelos\Usuario', 'usuario_registro');
    }
}
