<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TecnicoReparacion extends Model
{
    protected $table="tecnico_reparacion";
    protected $fillable=['nombre_tecnico'];
    protected $primaryKey='id_tecnico';

    public $timestamps=false;

    public function reparacionesCarroceria()
    {
        return $this->hasMany('App\Modelos\Reparacion','id_tecnico_carroceria');
    }
    
    public function reparacionesPreparado()
    {
        return $this->hasMany('App\Modelos\Reparacion','id_tecnico_preparado');
    }

    public function reparacionesPintura()
    {
        return $this->hasMany('App\Modelos\Reparacion','id_tecnico_pintura');
    }

    public function reparacionesArmado()
    {
        return $this->hasMany('App\Modelos\Reparacion','id_tecnico_armado');
    }

    public function reparacionesPulido()
    {
        return $this->hasMany('App\Modelos\Reparacion','id_tecnico_pulido');
    }

    public function reparacionesMecanica()
    {
        return $this->hasMany('App\Modelos\Reparacion','id_tecnico_mecanica');
    }

    public function reparacionesEnProceso()
    {
        $reparaciones = [];
        $carroceriaPendientes = $this->reparacionesCarroceria()->whereHas('detallesEnProceso', function ($query){
            $query->where('etapa_proceso', 'carroceria')->where('es_etapa_finalizada', 0);
        })->get();
        $carroceriaPendientes->count() > 0 ? array_push($reparaciones, $carroceriaPendientes) : null;

        $preparadoPendientes = $this->reparacionesPreparado()->whereHas('detallesEnProceso', function ($query){
            $query->where('etapa_proceso', 'preparado')->where('es_etapa_finalizada', 0);
        })->get();
        $preparadoPendientes->count() > 0 ? array_push($reparaciones, $preparadoPendientes) : null;

        $pinturaPendientes = $this->reparacionesPintura()->whereHas('detallesEnProceso', function ($query){
            $query->where('etapa_proceso', 'pintura')->where('es_etapa_finalizada', 0);
        })->get();
        $pinturaPendientes->count() > 0 ? array_push($reparaciones, $pinturaPendientes) : null;

        $armadoPendientes = $this->reparacionesArmado()->whereHas('detallesEnProceso', function ($query){
            $query->where('etapa_proceso', 'armado')->where('es_etapa_finalizada', 0);
        })->get();
        $armadoPendientes->count() > 0 ? array_push($reparaciones, $armadoPendientes) : null;

        $pulidoPendientes = $this->reparacionesPulido()->whereHas('detallesEnProceso', function ($query){
            $query->where('etapa_proceso', 'pulido')->where('es_etapa_finalizada', 0);
        })->get();
        $pulidoPendientes->count() > 0 ? array_push($reparaciones, $pulidoPendientes) : null;

        $mecanicaPendientes = $this->reparacionesMecanica()->whereHas('detallesEnProceso', function ($query){
            $query->where('etapa_proceso', 'mecanica')->where('es_etapa_finalizada', 0);
        })->get();
        $mecanicaPendientes->count() > 0 ? array_push($reparaciones, $mecanicaPendientes) : null;

        return collect($reparaciones);
    }
}
