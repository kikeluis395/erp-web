<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaReingresoRepuestos extends Model
{
    protected $table="linea_reingreso_repuestos";
    protected $fillable=['id_reingreso_repuestos ', 'id_repuesto', 'fecha_pedido', 'fecha_promesa', 'es_importado', 'fecha_registro', 'fecha_entrega', 'id_movimiento_salida', 'id_necesidad_repuestos'];
    protected $primaryKey='id_linea_reingreso_repuestos ';

    public $timestamps = false;

    public function itemNecesidadRepuestos() {
        return $this->belongsTo('App\Modelos\ItemNecesidadRepuestos', 'id_necesidad_repuestos', 'id_necesidad_repuestos');
    }

    public function repuesto() {
        return $this->belongsTo('App\Modelos\Repuesto', 'id_repuesto');
    }

    public function reingresoRepuestos() {
        return $this->belongsTo('App\Modelos\ReingresoRepuestos', 'id_reingreso_repuestos', 'id_reingreso_repuestos');
    }

    public function movimientoRepuesto(){
        return $this->morphOne(MovimientoRepuesto::class,'fuente'); 
    }

    public function fuente(){
        return 'DEVOLUCION ALMACEN';
    }

    public function idFuente(){
        return $this->reingresoRepuestos->id_reingreso_repuestos;
    }

    public function nroFactura(){
        return '-';
    }

    public function motivo(){
        return 'INGRESO POR DEVOLUCIÓN';
    }

    public function usuarioNombre(){
        return $this->reingresoRepuestos->usuario->empleado->nombreCompleto();
    }
    
    public function getRepuestoNroParte()
    {
        return $this->id_repuesto ? $this->repuesto->getNroParte() : null;
    }

    public function getDescripcionRepuesto()
    {
        return $this->id_repuesto ? $this->repuesto->descripcion : null;
    }
    
}
