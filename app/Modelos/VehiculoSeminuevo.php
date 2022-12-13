<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VehiculoSeminuevo extends Model
{
   protected $table      = 'vehiculo_seminuevo';
   protected $primaryKey = 'id_vehiculo_seminuevo';

   public function usuarioRegistro()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_registro');
   }

   public function usuarioModifico()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_modifico');
   }

   public function marcaAuto()
   {
      return $this->belongsTo('App\Modelos\MarcaAuto', 'id_marca_auto');
   }

   public function precio()
   {
      return $this->hasOne('App\Modelos\Ventas\PrecioVehiculoSeminuevo', 'id_vehiculo_seminuevo', 'id_vehiculo_seminuevo');
   }

   public function getUsuarioRegistro()
   {
      //dd($this->usuarioRegistro->empleado->nombreCompleto());
      return $this->usuarioRegistro->empleado->nombreCompleto();
   }

   public function getUsuarioModifico()
   {
      return $this->usuarioModifico->empleado->nombreCompleto();
   }

   public function lineaOrdenCompra(){
      return $this->hasOne('App\Modelos\LineaOrdenCompra', 'id_vehiculo_seminuevo','id_vehiculo_seminuevo');
   }

   public function tipoStock()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_tipo_stock');
   }

   public function tipoEstadoStock()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_tipo_estado_stock');
   }

   public function tipoEstadoVehiculo()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_tipo_estado_vehiculo');
   }

   public function ubicacion()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_ubicacion');
   }

   public function modeloAutoseminuevo()
   {
      return $this->belongsTo('App\Modelos\ModeloAutoSeminuevo', 'id_modelo_auto_seminuevo');
   }


}
