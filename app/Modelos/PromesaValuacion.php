<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PromesaValuacion extends Model
{
    protected $table = "promesa_valuacion";

    protected $fillable =['id_valuacion','fecha_promesa'];

    protected $primaryKey ="id_promesa_valuacion";

    public $timestamps = false;

    public function valuacion()
    {
    	return $this->belongsTo('App\Modelos\Valuacion','id_valuacion');
    }
}
