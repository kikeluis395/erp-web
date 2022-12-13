<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table ="permiso";
    protected $fillable = ['descripcion','nombre_interno','habilitado'];
    protected $primaryKey='id_permiso';

    public $timestamps = false;

    public function roles(){
        return $this->belongsToMany('App\Modelos\Rol','rol_permiso','id_permiso','id_rol');
    }

    public function submodulos(){
        return $this->hasMany('App\Modelos\Permiso', 'modulo', 'id_permiso');
    }
}
