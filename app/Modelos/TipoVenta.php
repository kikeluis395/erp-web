<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TipoVenta extends Model
{
    protected $table = "tipo_ventas";
    protected $primaryKey = 'id_tipo_venta';

    public $timestamps = false;

    public function serie() {
        return $this->belongsTo('App\Modelos\Serie', 'id_serie');
    }
}
