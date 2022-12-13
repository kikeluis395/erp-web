<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = "series";
    protected $primaryKey = 'id_serie';

    public $timestamps = false;
}
