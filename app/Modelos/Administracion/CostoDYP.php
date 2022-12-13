<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class CostoDYP extends Model
{
    protected $table = "costos_asociados_dyp";
    protected $fillable = [
        'tipo_personal',
        'metodo_costo_hh',
        'metodo_costo_panhos',
        'moneda_hh',
        'moneda_panhos',
        'valor_costo_hh',
        'valor_costo_panhos',
        'habilitado',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_costo_asociado_dyp';

    public $timestamps = false;

    public function lineas()
    {
        return $this->hasMany('App\Modelos\Administracion\LineaCostoDYP', 'id_costo_asociado_dyp', 'id_costo_asociado_dyp');
    }
}
