<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaHojaInventario extends Model
{
    protected $table = "linea_hoja_inventario";
    protected $fillable = ['id_hoja_inventario','id_elemento_inventario','resultado_inventario'];
    protected $primaryKey='id_linea_hoja_inventario';

    public $timestamps = false;

    public function hojaInventario()
    {
        return $this->belongsTo('App\Modelos\HojaInspeccion','id_hoja_inventario');
    }

    public function elementoInventario()
    {
        return $this->belongsTo('App\Modelos\ElementoInventario','id_elemento_inventario');
    }
}
