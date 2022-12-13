<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class OtroProductoServicio extends Model
{
   protected $table    = 'otro_producto_servicio';
   protected $fillable = ['codigo', 'descripcion', 'estado', 'id_parametros'];
   protected $guarded  = ['id_otro_producto_servicio'];
   protected $primaryKey='id_otro_producto_servicio';
   

   public function parametro()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_parametros');
   }


   public function getAlmacen(){
      
      $this->parametro->valor1;
   }



}
