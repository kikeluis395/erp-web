<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table="modelo";
    protected $fillable=['nombre_modelo','habilitado', 'id_marca_auto'];
    protected $primaryKey='id_modelo';

    public $timestamps = false;

    public function marcaAuto()
    {
    	return $this->belongsTo('App\Modelos\MarcaAuto','id_marca_auto');
    }
}
