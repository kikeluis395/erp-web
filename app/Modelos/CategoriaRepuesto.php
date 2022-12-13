<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CategoriaRepuesto extends Model
{
    protected $table = 'categoria_repuesto';
    protected $primaryKey='id_categoria_repuesto';
    protected $fillable = ['nombre_categoria'];
    public $timestamps = false;

    public function repuestos()
    {
        return $this->hasMany('App\Modelos\Repuesto','id_categoria_repuesto');
    }
}
