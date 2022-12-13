<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ElementoInventario extends Model
{
    protected $table = "elemento_inventario";
    protected $fillable = ['nombre_elemento_inventario','categoria','fecha_registro'];
    protected $primaryKey='id_elemento_inventario';

    public $timestamps = false;

    public function lineaHojaInventario()
    {
        return $this->hasMany('App\Modelos\LineaHojaInventario','id_elemento_inventario');
    }

    public function getNombre()
    {
        return $this->nombre_elemento_inventario;
    }
}
