<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $table = 'cuenta_bancaria';
    protected $primaryKey='id_cuenta_bancaria';
    protected $fillable = ['nro_cuenta', 'tipo_cuenta', 'moneda', 'id_banco'];
    public $timestamps = false;

    public function banco()
    {
        return $this->belongsTo('App\Modelos\Banco','id_banco');
    }

    public function movimientosBancarios()
    {
        return $this->hasMany('App\Modelos\MovimientoBancario','id_cuenta_afectada');
    }

    public function getIngresos()
    {
        return $this->movimientosBancarios()->where('tipo_movimiento','INGRESO')->get();
    }

    public function getEgresos()
    {
        return $this->movimientosBancarios()->where('tipo_movimiento','EGRESO')->get();
    }

    public function getSaldo()
    {
        return $this->getIngresos()->sum('monto_movimiento') - $this->getEgresos()->sum('monto_movimiento');
    }

    public function tercerosMovimientos()
    {
        return $this->hasMany('App\Modelos\MovimientoBancario','id_cuenta_externa');
    }

    public static function cuentasCod($codBanco)
    {
        return self::where('id_banco',$codBanco)->distinct()->get();
    }
}
