<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class FacturaCompra extends Model
{
    protected $table = "factura_compra";
    protected $fillable = ['periodo','nro_factura', 'fecha_emision', 'fecha_vencimiento', 'fecha_registro', 'id_usuario_registro','id_proveedor', 'moneda', 'glosa', 'forma_pago', 'tiene_detraccion','id_detraccion','valor_detraccion', 'regimen', 'base_imponible', 'impuestos', 'monto_inafecto', 'total', 'id_movimiento_bancario'];
    protected $primaryKey='id_factura';

    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo('App\Modelos\Proveedor','id_proveedor');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo('App\Modelos\Usuario','id_usuario_registro');
    }

    public function getNombreProveedor()
    {
        return $this->proveedor->nombre_proveedor;
    }

    public function getRUCProveedor()
    {
        return $this->proveedor->num_doc;
    }

    public function movimientoBancario()
    {
        return $this->belongsTo('App\Modelos\MovimientoBancario', 'id_movimiento_bancario');
    }

    public function detraccion()
    {
        return $this->belongsTo('App\Modelos\Detraccion', 'id_detraccion');
    }
}
