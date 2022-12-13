<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class PrecioDYP extends Model
{
    protected $table = "precio_mo_dyp";
    protected $fillable = [
        'id_marca_auto',
        'id_cia_seguro',
        'id_local',
        'incluye_igv',
        'precio_valor_venta',
        'tipo',
        'moneda',
        'fecha_inicio_aplicacion',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_precio_mo_dyp';
    public $timestamps = false;
}
