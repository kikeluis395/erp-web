<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Detraccion extends Model
{
    protected $table = 'detraccion';
    protected $primaryKey='id_detraccion';
    protected $fillable = ['codigo_sunat', 'descripcion', 'porcentaje_detraccion', 'habilitado'];
    public $timestamps = false;

}
