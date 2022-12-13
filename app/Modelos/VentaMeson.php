<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VentaMeson extends Model
{
    //
    protected $table = "venta_meson";
    protected $fillable = [];
    protected $primaryKey='id_venta_meson';

    public $timestamps = false;

    public function cotizacionMeson()
    {
        return $this->belongsTo('App\Modelos\CotizacionMeson','id_cotizacion_meson');
    }

    public function getLinkDetalleHTML($es_link = true) {
                
        $id_venta_meson = $this->id_venta_meson ?? false;
        $link = '-';

        if ($id_venta_meson) {
            $ruta = route('meson.show', ['id_cotizacion_meson' => $this->id_cotizacion_meson]);
            if ($es_link) $link = "<a class='id-link' href='{$ruta}' target='_blank'>NV {$id_venta_meson}</a>";
            else $link = "NV {$id_venta_meson}";
        }
        
        return $link;
    }
}
