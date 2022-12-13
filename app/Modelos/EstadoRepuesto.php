<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class EstadoRepuesto extends Model
{
    protected $table = "estado_repuesto";
    protected $fillable =['nombre_estado_repuesto'];
    protected $primaryKey ="id_estado_repuesto";
    public $timestamps = false;

    public function items_necesidad_repuestos()
    {
    	return $this->hasMany('App\Modelos\ItemNecesidadRepuestos','id_item_necesidad_repuestos');
    }
}
