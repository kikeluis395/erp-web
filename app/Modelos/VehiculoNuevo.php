<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class VehiculoNuevo extends Model
{
   protected $table      = 'vehiculo_nuevo';
   protected $primaryKey = 'id_vehiculo_nuevo';

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
      return $this->hasOne('App\Modelos\Ventas\PrecioVehiculoNuevo', 'id_vehiculo_nuevo', 'id_vehiculo_nuevo');
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
