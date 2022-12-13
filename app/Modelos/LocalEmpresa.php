<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalEmpresa extends Model
{
   use SoftDeletes;
   //
   protected $table      = "local_empresa";
   protected $fillable   = ['nombre_local', 'direccion_local', 'recibe_vehiculos', 'hace_traslado', 'habilitado'];
   protected $primaryKey = 'id_local';

   public $timestamps = false;

   public function recepcionOTs()
   {
      return $this->hasMany('App\Modelos\RecepcionOT', 'id_local');
   }

   public function empleados()
   {
      return $this->hasMany('App\Modelos\Empleado', 'id_local');
   }

   public function movimientosRepuesto()
   {
      return $this->hasMany('App\Modelos\MovimientoRepuesto', 'id_local_empresa', 'id_local');
   }
}
