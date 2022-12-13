<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ReprogramacionValuacion extends Model
{
    protected $table = 'reprogramacion_valuacion';
    protected $primaryKey='id_reprogramacion_valuacion';
    protected $fillable = ['razon_ampliacion','explicacion_ampliacion','valor_mano_obra_amp','valor_repuestos_amp','valor_terceros_amp','horas_mecanica_amp','horas_carroceria_amp','horas_panhos_amp','fecha_ampliacion','fecha_aprobacion_seguro_amp','fecha_registro_aprobacion_seguro_amp','fecha_aprobacion_cliente_amp','fecha_registro_aprobacion_cliente_amp','id_valuacion'];

    public $timestamps = false;

    public function valuacion()
    {
        return $this->belongsTo('App\Modelos\Valuacion','id_valuacion');
    }
}
