<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class RepuestoAplicaModeloTecnico extends Model
{
    protected $table="repuesto_aplica_modelo_tecnico";
    protected $fillable=[];
    protected $primaryKey='id_repuesto_aplica_modelo_tecnico';


    public function repuesto()
    {
    	return $this->belongsTo('App\Modelos\Repuesto','id_repuesto');
    }

    public function modeloTecnico()
    {
    	return $this->belongsTo('App\Modelos\ModeloTecnico','id_modelo_tecnico');
    }
}
