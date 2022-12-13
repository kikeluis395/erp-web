<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class CostoMEC extends Model
{
    protected $table = "costos_asociados_mec";
    protected $fillable = [
        'tipo_personal',
        'metodo_costo',
        'moneda',
        'valor_costo',
        'habilitado',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_costo_asociado_mec';

    public $timestamps = false;

    public function lineas()
    {
        return $this->hasMany('App\Modelos\Administracion\LineaCostoMEC', 'id_costo_asociado_mec', 'id_costo_asociado_mec');
    }
}
