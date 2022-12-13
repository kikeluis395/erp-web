<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    protected $table = 'reparacion';
    protected $primaryKey='id_reparacion';
    protected $fillable = ['id_tecnico_carroceria','id_tecnico_preparado','id_tecnico_pintura','id_tecnico_armado','id_tecnico_pulido','id_tecnico_mecanica','fecha_inicio_operativo','fecha_fin_operativo','fecha_registro_fin_operativo'];

    public $timestamps = false;

    public function tecnicoCarroceria()
    {
    	return $this->belongsTo('App\Modelos\TecnicoReparacion','id_tecnico_carroceria');
    }

    public function tecnicoPreparado()
    {
    	return $this->belongsTo('App\Modelos\TecnicoReparacion','id_tecnico_preparado');
    }

    public function tecnicoPintura()
    {
    	return $this->belongsTo('App\Modelos\TecnicoReparacion','id_tecnico_pintura');
    }

    public function tecnicoArmado()
    {
    	return $this->belongsTo('App\Modelos\TecnicoReparacion','id_tecnico_armado');
    }

    public function tecnicoPulido()
    {
    	return $this->belongsTo('App\Modelos\TecnicoReparacion','id_tecnico_pulido');
    }

    public function tecnicoMecanica()
    {
    	return $this->belongsTo('App\Modelos\TecnicoReparacion','id_tecnico_mecanica');
    }

    public function detallesEnProceso()
    {
        return $this->hasMany('App\Modelos\DetalleEnProceso','id_reparacion');
    }

    public function esTerminado()
    {
        return isset($this->fecha_fin_operativo);
    }

    public function nombreEmpCarroceria()
    {
        $empleado=$this->tecnicoCarroceria;
        if ($empleado) {
            return $empleado->nombre_tecnico;
        }
        return '';
    }

    public function nombreEmpPreparado()
    {
        $empleado=$this->tecnicoPreparado;
        if ($empleado) {
            return $empleado->nombre_tecnico;
        }
        return '';
    }

    public function nombreEmpPintura()
    {
        $empleado=$this->tecnicoPintura;
        if ($empleado) {
            return $empleado->nombre_tecnico;
        }
        return '';
    }

    public function nombreEmpArmado()
    {
        $empleado=$this->tecnicoArmado;
        if ($empleado) {
            return $empleado->nombre_tecnico;
        }
        return '';
    }

    public function nombreEmpPulido()
    {
        $empleado=$this->tecnicoPulido;
        if ($empleado) {
            return $empleado->nombre_tecnico;
        }
        return '';
    }

    public function nombreEmpMecanica()
    {
        $empleado=$this->tecnicoMecanica;
        if ($empleado) {
            return $empleado->nombre_tecnico;
        }
        return '';
    }

    public function fechasPromesa()
    {
        return $this->hasMany('App\Modelos\PromesaReparacion','id_reparacion');
    }

    public function ultFechaPromesa()
    {
        return $this->fechasPromesa()->orderBy('fecha_registro','desc')->first();
    }

    public function primeraFechaPromesa()
    {
        return $this->fechasPromesa()->orderBy('fecha_registro','asc')->first();
    }

    public function getTiempoTranscurridoTecnicos()
    {
        $detallesEnProceso = $this->detallesEnProceso;
        $tiempoTotal = 0;

        foreach ($detallesEnProceso as $key => $detalle) {
            $tiempoProceso = $detalle->getDuracionHoras();
            $tiempoTotal += $tiempoProceso;
        }

        return $tiempoTotal;
    }
}
