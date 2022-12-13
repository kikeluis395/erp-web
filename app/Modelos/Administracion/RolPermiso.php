<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    protected $table = "rol_permiso";
    protected $fillable = ['id_rol', 'id_permiso'];
    protected $primaryKey = 'id_rol_permiso';

    public $timestamps = false;

    public function rol()
    {
        return $this->hasOne('App\Modelos\Rol', 'id_rol', 'id_rol');
    }

    public function permiso()
    {
        return $this->hasOne('App\Modelos\Permiso', 'id_permiso', 'id_permiso');
    }
}
