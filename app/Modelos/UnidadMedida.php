<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table ="unidad_medida";
    protected $fillable = ['codigo_sunat','abreviacion','nombre_unidad'];
    protected $primaryKey='id_unidad_medida';

    public $timestamps = false;

}
