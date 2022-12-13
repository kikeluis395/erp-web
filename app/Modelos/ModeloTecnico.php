<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ModeloTecnico extends Model
{
    protected $table="modelo_tecnico";
    protected $fillable=['nombre_modelo','habilitado', 'id_marca_auto'];
    protected $primaryKey='id_modelo_tecnico';

    public $timestamps = false;

    public function marcaAuto()
    {
    	return $this->belongsTo('App\Modelos\MarcaAuto','id_marca_auto');
    }
}
