<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ItemDevolucion extends Model
{
    protected $table = 'item_devoluciones';
    protected $fillable = ['cantidad_devolucion','id_movimiento_repuesto','id_repuesto','id_devoluciones','fecha_devolucion','fecha_registro','costo_unitario','id_movimiento_repuesto_virtual','descuento_unitario'];
    public $timestamps = false;
    protected $primaryKey = 'id_item_devoluciones';

    public function repuesto() {
        return $this->belongsTo('App\Modelos\Repuesto', 'id_repuesto');
    }

    public function getCodigoRepuesto()
    {
        return $this->repuesto->codigo_repuesto;
    }

    public function getDescripcionRepuesto()
    {
        return $this->repuesto->descripcion;
    }

    public function obtenerTotal(){
        return $this->cantidad_devolucion * ($this->costo_unitario - $this->descuento_unitario);
    }
  
    public function devolucion() {
        return $this->belongsTo('App\Modelos\Devolucion', 'id_devoluciones');
    }

    public function movimientoRepuesto(){
        return $this->morphOne(MovimientoRepuesto::class,'fuente'); 
    }

    public function fuente(){
        return 'NOTA DE DEVOLUCIÓN';
    }

    public function idFuente(){
        return $this->devolucion->id_devoluciones;
    }

    public function nroFactura(){
        return $this->devolucion->nro_nota_credito;
    }

    public function motivo(){
        return 'EGRESO POR DEVOLUCIÓN';
    }

    public function usuarioNombre(){
        return $this->devolucion->usuario->empleado->nombreCompleto();
    }
}
