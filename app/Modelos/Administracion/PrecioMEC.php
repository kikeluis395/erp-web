<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class PrecioMEC extends Model
{
    protected $table = "precio_mo_mec";
    protected $fillable = [
        'id_local_empresa',
        'tipo',
        'incluye_igv',
        'precio_valor_venta',
        'moneda',
        'fecha_inicio_aplicacion',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_precio_mo_mec';
    public $timestamps = false;
}
