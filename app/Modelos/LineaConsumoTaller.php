<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaConsumoTaller extends Model
{
    protected $table = 'linea_consumo_taller';
    protected $fillable = ['id_consumo_taller','id_repuesto','id_repuesto','cantidad','id_movimiento_virtual','id_movimiento_salida'];
    public $timestamps = false;
    protected $primaryKey = 'id_linea_consumo_taller';

    public function repuesto() {
        return $this->belongsTo('App\Modelos\Repuesto', 'id_repuesto');
    }

    public function movimientoSalida() {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto', 'id_movimiento_salida');
    }

    public function getCodigoRepuesto()
    {
        return $this->repuesto->codigo_repuesto;
    }

    public function getCostoUnitario()
    {
        return $this->movimientoSalida->costo ? $this->movimientoSalida->costo : 0;
    }

    public function obtenerTotal(){
        return $this->cantidad * $this->getCostoUnitario();
    }
  
    public function consumoTaller() {
        return $this->belongsTo('App\Modelos\ConsumoTaller', 'id_consumo_taller');
    }

    public function movimientoRepuesto(){
        return $this->morphOne(MovimientoRepuesto::class,'fuente'); 
    }

    public function fuente(){
        return 'CONSUMO TALLER';
    }

    public function idFuente(){
        return $this->id_consumo_taller;
    }

    public function nroFactura(){
        return '-';
    }

    public function motivo(){
        return 'EGRESO POR CONSUMO';
    }

    public function usuarioNombre(){
        return $this->consumoTaller->getNombreCompletoUsuarioRegistro();
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
