<?php

namespace App\Modelos\Internos;

use Illuminate\Database\Eloquent\Model;

abstract class Precio extends Model
{
    abstract public function getMonto();
    abstract public function getIncluyeIGV();
    abstract public function getMoneda();
}