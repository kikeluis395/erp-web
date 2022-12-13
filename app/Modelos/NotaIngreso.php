<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\OrdenCompra;
use App\Modelos\OtroProductoServicio;
use Carbon\Carbon;

class NotaIngreso extends Model
{
    protected $table ="nota_ingreso";
    protected $fillable = ['id_usuario_registro', 'id_factura'];
    protected $primaryKey='id_nota_ingreso';

    public $timestamps = false;

    public function lineasNotaIngreso()
    {
        return $this->hasMany('App\Modelos\LineaNotaIngreso','id_nota_ingreso');
    }

    public function lineaOrdenCompra()
    {
        return $this->belongsTo('App\Modelos\LineaOrdenCompra','id_linea_orden_compra');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo('App\Modelos\Usuario','id_usuario_registro');
    }

    public function facturaCompra()
    {
        return $this->belongsTo('App\Modelos\FacturaCompra','id_factura');
    }

    public function obtenerOrdenCompraRelacionada(){
        $lineasNI = $this->lineasNotaIngreso()->get();
        return $lineasNI[0]->obtenerOCRelacionada();
    }

    public function obtenerOrdenCompraObjeto(){
        $lineasNI = $this->lineasNotaIngreso()->get();
        return $lineasNI[0]->obtenerOCRelacionadaObjeto();
    }

    public function obtenerNombreProveedorRelacionado(){
        $lineasNI = $this->lineasNotaIngreso()->get();
        return $lineasNI[0]->obtenerProveedorRelacionado();
    }

    public function getProveedorProveedorRelacionado(){
        $lineasNI = $this->lineasNotaIngreso()->get();
        return $lineasNI[0]->getProveedor();
    }

    public function obtenerRUCProveedorRelacionado(){
        $lineasNI = $this->lineasNotaIngreso()->get();
        return $lineasNI[0]->obtenerRUCProveedorRelacionado();
    }

    public function getCostoTotal()
    {
        $lineasNotaIngreso = $this->lineasNotaIngreso()->get();
        $total = 0;
        foreach ($lineasNotaIngreso as $key => $lineaNotaIngreso) {
            $lineOCRelacionada = $lineaNotaIngreso->lineaOrdenCompra;
            $total += $lineaNotaIngreso->cantidad_ingresada * $lineOCRelacionada->precio;
        }
        return $total;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro ? Carbon::parse($this->fecha_registro)->format('d/m/Y H:i') : null;
    }

    public function getNombreUsuarioRegistro(){
        return $this->usuarioRegistro->username;
    }

    public function obtenerFactura(){
        if(!is_null($this->id_factura)){
            return $this->facturaCompra->nro_factura;
        }
        if(!is_null($this->factura_asociada)){
            return $this->factura_asociada;
        }
        return "-";
    }

    public function getAlmacen(){
        $lineaNI = $this->lineasNotaIngreso()->first();
       $lineaOC = $lineaNI->lineaOrdenCompra;
       if($lineaOC->id_repuesto != null){
           return 'ALMACÉN DE REPUESTOS';
       }else if($lineaOC->id_otro_producto_servicio != null){
            $otro_producto_servicio = OtroProductoServicio::find($lineaOC->id_otro_producto_servicio);
            return $otro_producto_servicio->getAlmacen();
       }else{
           return 'ALMACÉN DE VEHICULOS NUEVOS';
       }
    }

}
