<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Garantias extends Model
{
    protected $table = "garantias";
    protected $fillable = [
        'id_recepcion_ot',
        'nro_factura',
        'monto_mano_obra',
        'monto_repuestos',
        'monto_incentivo',
        'fecha_registro',
        'fecha_factura',
        'id_cierre_marca',
        'moneda',
    ];
    protected $primaryKey = 'id_garantia';

    public $timestamps = false;

    public function ordenTrabajo()
    {
        return $this->hasOne('App\Modelos\RecepcionOT', 'id_recepcion_ot', 'id_recepcion_ot');
    }

    public function hojaTrabajo()
    {
        return $this->ordenTrabajo->hojaTrabajo;
    }
    
}
