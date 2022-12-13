<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PromesaReparacion extends Model
{
    protected $table = "promesas_reparacion";

    protected $fillable =['id_reparacion','fecha_promesa'];

    protected $primaryKey ="id_promesa_reparacion";

    public $timestamps = false;

    public function reparacion()
    {
    	return $this->belongsTo('App\Modelos\Reparacion','id_reparacion');
    }
}
