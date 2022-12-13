<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;


class Devolucion extends Model
{
    protected $table = 'devoluciones';
    public $timestamps = false;
    protected $fillable = ['id_proveedor','id_usuario','fecha_devolucion','fecha_registro','doc_referencia','moneda','nro_nota_credito'];
    public $primaryKey = 'id_devoluciones';

    public function usuario() {
        return $this->belongsTo('App\Modelos\Usuario', 'id_usuario');
    }

    public function itemDevoluciones() {
        return $this->hasMany('App\Modelos\ItemDevolucion', 'id_devoluciones');
    }

    public function proveedor() {
        return $this->belongsTo('App\Modelos\Proveedor', 'id_proveedor');
    }

    public function getNombreCompletoUsuarioRegistro() {
        return $this->usuario->empleado->primer_nombre . ' ' . $this->usuario->empleado->primer_apellido;
    }

    public function getNombreProveedor()
    {
        return $this->proveedor->nombre_proveedor;
    }

    public function getRUCProveedor()
    {
        return $this->proveedor->num_doc;
    }

    public function getCostoTotal()
    {
        $itemDevoluciones = $this->itemDevoluciones;
        $total = 0;
        foreach ($itemDevoluciones as $key => $itemDevolucion) {
            $total += $itemDevolucion->obtenerTotal();
        }
        return $total;
    }
}
