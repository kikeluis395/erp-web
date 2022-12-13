<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ubigeo extends Model
{
    //
    protected $table = "ubigeo";
    protected $fillable = ['codigo','departamento','provincia','distrito'];
    protected $primaryKey='codigo';

    public $timestamps = false;
    public $incrementing = false;

    public function clientes()
    {
        return $this->hasMany('App\Modelos\Cliente','cod_ubigeo');
    }

    public static function departamentos()
    {
        return Self::select([DB::raw('substring(codigo,1,2) as codigo_departamento'),'departamento'])->distinct()->get();
    }

    public static function provincias()
    {
        return Self::select([DB::raw('substring(codigo,1,4) as codigo_provincia'),'provincia'])->distinct()->get();
    }

    public static function distritos()
    {
        return Self::select([DB::raw('substring(codigo,1,6) as codigo_distrito'),'distrito'])->get();
    }

    public static function provinciasCod($codDepartamento)
    {
        return Self::select([DB::raw('substring(codigo,3,2) as codigo_provincia'),'provincia'])->where(DB::raw('substring(codigo,1,2)'),$codDepartamento)->distinct()->get();
    }

    public static function distritosCod($codDepartamento,$codProvincia)
    {
        return Self::select([DB::raw('substring(codigo,5,2) as codigo_distrito'),'distrito'])->where(DB::raw('substring(codigo,1,2)'),$codDepartamento)->where(DB::raw('substring(codigo,3,2)'),$codProvincia)->distinct()->get();
    }

    public function getCodigoDepartamento()
    {
        return substr($this->codigo,0,2);
    }

    public function getCodigoProvincia()
    {
        return substr($this->codigo,2,2);
    }

    public function getCodigoDistrito()
    {
        return substr($this->codigo,4,2);
    }
}
