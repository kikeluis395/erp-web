<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\OrdenCompra;

class LineaNotaIngreso extends Model
{
    protected $table ="linea_nota_ingreso";
    protected $fillable = ['cantidad_ingresada', 'id_nota_ingreso', 'id_linea_orden_compra'];
    protected $primaryKey='id_linea_nota_ingreso';

    public $timestamps = false;

    public function notaIngreso()
    {
        return $this->belongsTo('App\Modelos\NotaIngreso','id_nota_ingreso');
    }

    public function lineaOrdenCompra()
    {
        return $this->belongsTo('App\Modelos\LineaOrdenCompra', 'id_linea_orden_compra');
    }

    public function vehiculoNuevo()
    {
        return $this->lineaOrdenCompra->vehiculoNuevo;
    }

    public function vehiculoSeminuevo()
    {
        return $this->lineaOrdenCompra->vehiculoSeminuevo;
    }

    public function obtenerOCRelacionada(){
        $lineaOC = $this->lineaOrdenCompra;
        return $lineaOC->id_orden_compra;
    }

    public function movimientoIngreso()
    {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto','id_movimiento_ingreso');
    }

    public function obtenerOCRelacionadaObjeto(){
        $lineaOC = $this->lineaOrdenCompra;
        return $lineaOC->ordenCompra;
    }

    public function obtenerProveedorRelacionado(){
        $lineaOC = $this->lineaOrdenCompra;
        $orden_compra = OrdenCompra::find($lineaOC->id_orden_compra);
        return $orden_compra->getNombreProveedor();
    }

    public function obtenerRUCProveedorRelacionado(){
        $lineaOC = $this->lineaOrdenCompra;
        $orden_compra = OrdenCompra::find($lineaOC->id_orden_compra);
        return $orden_compra->getRUCProveedor();
    }

    public function getProveedor(){
        $lineaOC = $this->lineaOrdenCompra;
        $orden_compra = OrdenCompra::find($lineaOC->id_orden_compra);
        return $orden_compra->proveedor;
    }

    public function obtenerTotal(){
        return $this->cantidad_ingresada * $this->lineaOrdenCompra->precio;
    }

    public function getIdRepuesto()
    {
        return $this->lineaOrdenCompra->id_repuesto;
    }

    public function getIdOtroProductoServico()
    {
        return $this->lineaOrdenCompra->id_otro_producto_servicio;
    }

    public function getIdVehiculoNuevo()
    {
        return $this->lineaOrdenCompra->id_vehiculo_nuevo;
    }

    public function getIdVehiculoNuevoInstancia()
    {
      
        return $this->lineaOrdenCompra->id_vehiculo_nuevo_instancia;
    }

    public function getIdLocal()
    {
        return $this->notaIngreso->usuarioRegistro->empleado->id_local;
    }

    public function movimientoRepuesto(){
        return $this->morphOne(MovimientoRepuesto::class,'fuente'); 
    }

    public function fuente(){
        return 'NOTA INGRESO';
    }

    public function idFuente(){
        return $this->notaIngreso->id_nota_ingreso;
    }

    public function nroFactura(){
        return $this->notaIngreso->factura_asociada;
    }

    public function motivo(){
        return 'INGRESO';
    }

    public function usuarioNombre(){
        return $this->notaIngreso->usuarioRegistro->empleado->nombreCompleto();
    }

    /********************
     * Solo para lineas referente a vehiculos nuevos
     */

   
}
