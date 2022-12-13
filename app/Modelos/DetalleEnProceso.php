<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DetalleEnProceso extends Model
{
    protected $table = "detalle_en_proceso";
    protected $fillable=['id_reparacion','etapa_proceso','es_etapa_finalizada','fecha_fin_etapa'];
    protected $primaryKey='id_detalle_proceso';
    
    public $timestamps = false;

    public function recepcionOT_estadoReparacion()
    {
    	return $this->belongsTo('App\Modelos\Reparacion','id_reparacion');
    }

    public function getDuracionHoras()
    {
        $fechaInicio = $this->fecha_registro ? Carbon::parse($this->fecha_registro) : null;
        $fechaFin = $this->fecha_fin_etapa ? Carbon::parse($this->fecha_fin_etapa) : null;

        if( $fechaFin ){
            if( $fechaFin->diffInDays($fechaInicio) < 1 )
                return $fechaFin->diffInHours($fechaInicio);
            
            if( $fechaInicio->isClosed() && $fechaFin->diffInHours($fechaFin->previousClose()) <= 1 ){
                $fechaAux = new Carbon($fechaInicio);
                $fechaAux->setHour(18);
                $fechaAux->setMinute(30);
                $tiempoExtra = $fechaAux->diffInHours($fechaInicio);

                return $fechaFin->diffInBusinessHours($fechaInicio) + $tiempoExtra;
            }

            return $fechaFin->diffInBusinessHours($fechaInicio);
        }
        elseif($fechaInicio->isOpen()){
            return Carbon::now()->diffInBusinessHours($fechaInicio);
        }
        else{
            return Carbon::now()->diffInBusinessHours($fechaInicio);
        }
    }
}
