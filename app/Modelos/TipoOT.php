<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TipoOT extends Model
{
    protected $table = "tipo_ot";
    protected $fillable = ['nombre_tipo_ot'];
    protected $primaryKey='id_tipo_ot';

    public $timestamps = false;

    static function getAll($type)
    {
        $tiposOTPre = self::where('habilitado', 1);
        if($type == 'DYP'){
            $tiposOTPre->whereIn('departamento', ['AMBOS', 'DYP']);
        }
        elseif($type == 'MEC'){
            $tiposOTPre->whereIn('departamento', ['AMBOS', 'MEC']);
        }
        elseif($type != 'ALL'){
            return null;
        }
        return $tiposOTPre->orderBy('nombre_tipo_ot')->get();
    }

    public function recepcion_OTs()
    {
    	return $this->hasMany('App\Modelos\RecepcionOT','id_tipo_ot');
    }
}
