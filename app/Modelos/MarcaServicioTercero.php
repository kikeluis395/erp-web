<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MarcaServicioTercero extends Model
{
    protected $table="marca_servicio_tercero";
    protected $fillable=['marca_id','servicio_tercero_id'];
    public $timestamps = false;

    public function datosMarca()
    {
       return $this->belongsTo(MarcaAuto::class,'marca_id');
    }
}
