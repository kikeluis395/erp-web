<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Valuacion extends Model
{
    protected $table = "valuacion";

    protected $fillable =['id_recepcion_ot','fecha_valuacion','valor_mano_obra','valor_repuestos','valor_terceros','horas_mecanica','horas_carroceria','horas_panhos','es_perdida_total','fecha_aprobacion_seguro','fecha_registro_aprobacion_seguro','fecha_aprobacion_cliente','fecha_registro_aprobacion_cliente','id_usuario_valuador'];

    protected $primaryKey ="id_valuacion";

    public $timestamps = false;

    public function recepcionOT()
    {
    	return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }

    public function fechasPromesa()
    {
    	return $this->hasMany('App\Modelos\PromesaValuacion','id_valuacion');
    }

    public function ultFechaPromesa()
    {
        return $this->fechasPromesa()->orderBy('fecha_registro','desc')->first();
    }

    public function primeraFechaPromesa()
    {
        return $this->fechasPromesa()->orderBy('fecha_registro','asc')->first();
    }

    public function horasCarroceria()
    {
        $horas=$this->horas_carroceria;
        if ($horas) {
            return $horas;
        }
        else{
            return '-';
        }
    }

    public function horasMecanica()
    {
        $horas=$this->horas_mecanica;
        if ($horas) {
            return $horas;
        }
        else{
            return '-';
        }
    }

    public function horasPintura()
    {
        $horas=$this->horas_pintura;
        if ($horas) {
            return $horas;
        }
        else{
            return '-';
        }
    }

    public function reprogramacionesValuacion()
    {
        return $this->hasMany('App\Modelos\ReprogramacionValuacion','id_valuacion');
    }

    public function ultReprogramacionValuacion()
    {
        return $this->reprogramacionesValuacion()->orderBy('fecha_registro','desc')->first();
    }

    public function cotizacionesPreAsociadas()
    {
        return $this->hasMany('App\Modelos\Cotizacion', 'id_valuacion');
    }
}
