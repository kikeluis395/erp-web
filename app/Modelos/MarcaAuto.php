<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MarcaAuto extends Model
{
    protected $table="marca_auto";
    protected $fillable=['nombre_marca','habilitado'];
    protected $primaryKey='id_marca_auto';

    public $timestamps = false;

    public function hojaTrabajo()
    {
    	return $this->hasMany('App\Modelos\HojaTrabajo','id_marca_auto');
    }

    public function getIdMarcaAuto()
    {
        return $this->id_marca_auto;
    }

    public function getNombreMarca()
    {
        return $this->nombre_marca;
    }
}
