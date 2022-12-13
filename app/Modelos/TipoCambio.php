<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = "tipo_cambio";
    protected $fillable = ['compra', 'venta', 'cobro', 'dni_empleado', 'id_local', 'fecha_registro'];
    protected $primaryKey='id_tipo_cambio';

    public $timestamps = false;

    public static function getTipoCambioCobroActual()
    {
        return self::orderBy('fecha_registro','desc')->first()->cobro;
    }
    
    public static function getTipoCambioPorFecha($fecha)
    {
        $response = self::orderBy('fecha_registro','desc');

        if ($fecha) 
            $response = $response->where('fecha_registro', '<=', $fecha);

        $response = $response->first()->cobro;

        return $response;
    }

    public function empleado()
    {
    	return $this->belongsTo('App\Modelos\Empleado', 'dni_empleado');
    }

    public function local()
    {
        return $this->belongsTo('App\Modelos\Local', 'id_local');
    }
}
