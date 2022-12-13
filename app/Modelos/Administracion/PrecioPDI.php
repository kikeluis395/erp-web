<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class PrecioPDI extends Model
{
    protected $table = 'precio_mo_pdi';
    protected $fillable = [
        'tipo',
        'valor_costo',
        'moneda',
        'creador',
        'editor',
        'id_local',
        'habilitado',
        'fecha_edicion',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_precio_mo_pdi';
    public $timestamps = false;
}
