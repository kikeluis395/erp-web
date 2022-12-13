<?php

namespace App\Modelos\Ventas;

use Illuminate\Database\Eloquent\Model;

class EstadoHojaInspeccion extends Model
{
    protected $table = 'estado_hoja_inspeccion';
    protected $primaryKey ="id";
    public $timestamps = false;

    public function getId(){ return $this->id; }
    public function getNombre(){ return $this->nombre; }

    static function inspeccionSavar(){
        $model = new self();
        $model->id = 1;
        $model->nombre = 'Inspección savar';
        return $model;
    }
    
    static function inspeccionDealer(){
        $model = new self();
        $model->id = 2;
        $model->nombre = 'Inspección Dealer';
        return $model;
    }

    static function completado(){
        $model = new self();
        $model->id = 3;
        $model->nombre = 'Completado';
        return $model;
    }

    static function fromId($estado_id)
    {
        switch ($estado_id) {
            case self::inspeccionSavar()->getId():
                return self::inspeccionSavar();
            case self::inspeccionDealer()->getId():
                return self::inspeccionDealer();
            case self::completado()->getId():
                return self::completado();
            default:
                return null;
        }
    }

    static function isSavar($estadoNombre): bool {
        return self::inspeccionSavar()->getNombre() === $estadoNombre;
    }

    static function isDealer($estadoNombre): bool {
        return self::inspeccionDealer()->getNombre() === $estadoNombre;
    }

    static function isCompletado($estadoNombre): bool {
        return self::completado()->getNombre() === $estadoNombre;
    }

    static function isNotCompletado($estadoNombre){
        return !self::isCompletado($estadoNombre);
    }
}
