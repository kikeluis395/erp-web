<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VehiculoNuevoInstancia extends Model
{
   protected $table      = 'vehiculo_nuevo_instancia';
   protected $primaryKey = 'id_vehiculo_nuevo_instancia';

   public function usuarioRegistro()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'creador');
   }

   public function usuarioModifico()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'editor');
   }

   public function modeloComercial()
   {
      return $this->belongsTo('App\Modelos\VehiculoNuevo', 'id_modelo_comercial_vn');
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
   
   public function getUsuarioRegistro()
   {
      //dd($this->usuarioRegistro->empleado->nombreCompleto());
      return $this->usuarioRegistro->empleado->nombreCompleto();
   }

   public function getUsuarioModifico()
   {
      return $this->usuarioModifico->empleado->nombreCompleto();
   }
}
