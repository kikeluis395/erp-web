<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "rol";
    protected $fillable = ['nombre_rol', 'nombre_interno'];
    protected $primaryKey = 'id_rol';

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\Modelos\Usuario', 'id_rol');
    }

    public function permisos()
    {
        return $this->belongsToMany('App\Modelos\Permiso', 'rol_permiso', 'id_rol', 'id_permiso');
    }

    public function accesos()
    {
        return $this->hasMany('App\Modelos\Administracion\RolPermiso', 'id_rol', 'id_rol');
    }

    public function obtenerNombresInternosPermisos()
    {
        $permisos = $this->permisos;
        $arregloNombresInternos = [];
        foreach ($permisos as $permiso) {
            array_push($arregloNombresInternos, $permiso->nombre_interno);
        }
        return $arregloNombresInternos;
    }
}
