<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class LineaOrdenCompra extends Model
{
   protected $table      = "linea_orden_compra";
   protected $fillable   = ['id_orden_compra', 'id_repuesto', 'cantidad', 'precio'];
   protected $primaryKey = 'id_linea_orden_compra';

   public $timestamps = true;

   public function ordenCompra()
   {
      return $this->belongsTo('App\Modelos\OrdenCompra', 'id_orden_compra');
   }

   public function vehiculoSeminuevo()
   {
      return $this->belongsTo('App\Modelos\VehiculoSeminuevo', 'id_vehiculo_seminuevo');
   }

   public function getDescripcionRepuesto()
   {
      
      if($this->repuesto != null){
         return $this->repuesto->descripcion;
      }

      if($this->otroProductoServicio != null){
         return $this->otroProductoServicio->descripcion;
      }

      if($this->vehiculoNuevo != null){
         return $this->vehiculoNuevo->modelo_comercial;
      }

      return '-';
   }

   public function getUbicacionRepuesto()
   {
      return $this->repuesto->ubicacion;
   }

   public function getCodigoRepuesto()
   {
      if($this->repuesto != null){
         return $this->repuesto->codigo_repuesto;
      }

      if($this->otroProductoServicio != null){
         return $this->otroProductoServicio->codigo;
      }

      if($this->vehiculoNuevo != null){
         return $this->vehiculoNuevo->modelo_comercial;
      }

      return '-';
      
   }

   public function repuesto()
   {
      return $this->belongsTo('App\Modelos\Repuesto', 'id_repuesto');
   }

   public function vehiculoNuevo()
   {
      return $this->belongsTo('App\Modelos\VehiculoNuevo', 'id_vehiculo_nuevo');
   }  

   public function otroProductoServicio()
   {
      return $this->belongsTo('App\Modelos\OtroProductoServicio', 'id_otro_producto_servicio');
   }

   public function vehiculoNuevoInstancia()
   {
      return $this->belongsTo('App\Modelos\VehiculoNuevoInstancia', 'id_vehiculo_nuevo_instancia');
   }

   public function obtenerTotal()
   {
      return $this->cantidad * $this->precio;
   }

   public function lineasNotaIngreso()
   {
      return $this->hasMany('App\Modelos\LineaNotaIngreso', 'id_linea_orden_compra');
   }

   public function obtenerTotalRestante()
   {
      $cantidadRestante = $this->obtenerCantidadRestante();
      return $cantidadRestante * $this->precio;
   }

   public function flagLineaDespachada()
   {
      $lineasNotasIngresoRelacionadas = $this->lineasNotaIngreso()->get();
      $cantidad                       = 0;
      foreach ($lineasNotasIngresoRelacionadas as $key => $lineaNotaIngreso) {
         $cantidad += $lineaNotaIngreso->cantidad_ingresada;
      }
      if ($cantidad == $this->cantidad) {
         return true;
      } else {
         return false;
      }

   }

   public function obtenerCantidadRestante()
   {
      if ($this->cantidad == 0) {
         return 0;
      }

      $lineasNotasIngresoRelacionadas = $this->lineasNotaIngreso()->get();
      $cantidad                       = 0;
      foreach ($lineasNotasIngresoRelacionadas as $key => $lineaNotaIngreso) {
         $cantidad += $lineaNotaIngreso->cantidad_ingresada;
      }
      return $this->cantidad - $cantidad;
   }

   public function clienteProveedor(){
      return $this->belongsTo('App\Modelos\Cliente', 'doc_cliente');
   }
}
