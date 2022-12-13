<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
   protected $table    = 'parametros';
   protected $guarded  = ['id'];
   protected $fillable = [];
   public $timestamps  = false;
}
