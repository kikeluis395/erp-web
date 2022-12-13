<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ModeloAutoSeminuevo extends Model
{
   protected $table      = 'modelo_auto_seminuevo';
   protected $primaryKey = 'id_modelo_auto_seminuevo';

   public function marca()
   {
      return $this->belongsTo('App\Modelos\MarcaAutoSeminuevo', 'id_marca_auto_seminuevo');
   }

   public static function modeloCod($marcaSeminuevoCod)
    {
        
        return Self::where('id_marca_auto_seminuevo',$marcaSeminuevoCod)->get();
    }
  


}
