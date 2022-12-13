<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaGarantia extends Model
{
    protected $table = "seguimiento_garantia";
    protected $fillable = [
        'estado',
        'fecha_carga',
        'codigo_registro',
        'fecha_reproceso',
        'motivo',
        'es_rechazada',
        'motivo_rechazo',
        'id_recepcion_ot',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_seguimiento_garantia';

    public $timestamps = false;

    public function ordenTrabajo()
    {
        return $this->hasOne('App\Modelos\RecepcionOT', 'id_recepcion_ot', 'id_recepcion_ot');
    }

    public function hojaTrabajo()
    {
        return $this->ordenTrabajo->hojaTrabajo;
    }
}
