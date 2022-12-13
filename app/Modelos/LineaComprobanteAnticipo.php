<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaComprobanteAnticipo extends Model
{
    protected $table = "linea_comprobante_anticipo";
    protected $fillable = ['id_linea_comprobante_anticipo', 'id_comprobante_anticipo', 'cantidad', 'unidad_medida', 'codigo_producto', 'descripcion', 'tipo_igv', 'valor_unitario', 'valor_venta', 'igv', 'precio_venta'];
    protected $primaryKey = 'id_linea_comprobante_anticipo';

    public $timestamps = false;
}
