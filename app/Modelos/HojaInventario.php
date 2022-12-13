<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\ElementoInventario;

class HojaInventario extends Model
{
    protected $table = "hoja_inventario";
    protected $fillable = ['id_recepcion_ot','fecha_creacion'];
    protected $primaryKey='id_hoja_inventario';

    public $timestamps = false;
    private $elementosInventario = null;

    public function recepcionOT()
    {
        return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }

    public function lineasHojaInventario()
    {
        return $this->hasMany('App\Modelos\LineaHojaInventario','id_hoja_inventario');
    }

    public function getHTMLResultByOrden($nroOrden)
    {
        if($this->id_hoja_inventario ===null){
            if(in_array($nroOrden,[2,20,22,24,26,28,32,34,36,]))
                return (object) ['rh' => '', 'lh' => ''];

            return '';
        }

        if(!$this->elementosInventario){
            $this->elementosInventario = ElementoInventario::all();
        }
        $elementoInventario = $this->elementosInventario->where('orden',$nroOrden)->first();
        $lineaHoja = $this->lineasHojaInventario->where('id_elemento_inventario', $elementoInventario->id_elemento_inventario)->first();

        if($elementoInventario->clase == 'no_cuantificable'){
            return $lineaHoja && $lineaHoja->resultado_inventario ? 'checked' : 'ticked';
        }
        elseif($elementoInventario->clase == 'cuantificable'){
            return $lineaHoja && $lineaHoja->cantidad ? $lineaHoja->cantidad : 0;
        }
        elseif ($elementoInventario->clase == 'rh-lh') {
            return (object) ['rh' => $lineaHoja && $lineaHoja->rh ? 'checked' : 'ticked',
                             'lh' => $lineaHoja && $lineaHoja->lh ? 'checked' : 'ticked'];
        }

    }
}
