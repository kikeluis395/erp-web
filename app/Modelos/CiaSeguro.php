<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CiaSeguro extends Model
{
    protected $table="cia_seguro";
    protected $fillable=['nombre_cia_seguro','habilitado'];
    protected $primaryKey='id_cia_seguro';
    
    public $timestamps = false;

    public function ubicacion() {
        return $this->belongsTo('App\Modelos\Ubigeo', 'ubigeo', 'codigo');
    }

    public function recepcionOT()
    {
    	return $this->hasMany('App\Modelos\RecepcionOT','id_cia_seguro');
    }

    public function getNombreCiaSeguro()
    {
        return $this->nombre_cia_seguro;
    }
}
