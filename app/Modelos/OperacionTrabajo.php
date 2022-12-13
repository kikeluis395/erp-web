<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class OperacionTrabajo extends Model
{
    protected $table = "operacion_trabajo";
    protected $fillable = ['id_operacion_trabajo','cod_operacion_trabajo','descripcion','tipo_trabajo'];
    protected $primaryKey='id_operacion_trabajo';

    public $timestamps = false;

    public function codOperacionKeyName()
    {
        return 'cod_operacion_trabajo';
    }

    public function detallesTrabajo()
    {
        return $this->hasMany('App\Modelos\DetalleTrabajo','id_operacion_trabajo');
    }

    public function getUnidad()
    {
        switch ($this->tipo_trabajo) {
            case 'GLOBAL-HORAS-CARR':
            case 'CARROCERIA':
                $unidad = "HORAS CAR";
                break;
            case 'GLOBAL-HORAS-MEC':
            case 'MECANICA':
            case 'MECANICA Y COLISION':
                $unidad = "HORAS MEC";
                break;
            case 'SERVICIOS TERCEROS':
                $unidad = "S/";
                break;
            case 'GLOBAL-PANHOS':
            case 'PANHOS PINTURA':
                $unidad = "PAÑOS";
                break;
            default:
                $unidad = "";
                break;
        }
        
        return $unidad;
    }

    public function getPosicionUnidad()
    {
        return $this->getUnidad() == "S/" ? "PRE" : "POST";
    }
}
