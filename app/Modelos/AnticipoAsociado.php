<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class AnticipoAsociado extends Model
{
    protected $table="anticipo_asociados";    
    protected $primaryKey='id';

    public $timestamps = false;
}
