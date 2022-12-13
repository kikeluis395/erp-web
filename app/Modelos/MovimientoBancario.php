<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MovimientoBancario extends Model
{
    protected $table = 'movimiento_bancario';
    protected $primaryKey='id_movimiento_bancario';
    protected $fillable = ['tipo_movimiento', 'comentario', 'monto_movimiento','moneda_movimiento', 'id_cuenta_afectada','id_cuenta_externa', 'fecha_movimiento'];
    public $timestamps = false;

    public function cuentaAfectada()
    {
        return $this->belongsTo('App\Modelos\CuentaBancaria','id_cuenta_afectada');
    }

    public function cuentaExterna()
    {
        return $this->belongsTo('App\Modelos\CuentaBancaria','id_cuenta_externa');
    }
}
