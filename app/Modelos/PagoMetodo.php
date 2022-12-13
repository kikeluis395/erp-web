<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PagoMetodo extends Model
{    
    protected $table="pago_metodos";
    protected $fillable=['id_pago_metodo', 'metodo_nombre', 'metodo_nombre_mostrar'];
    protected $primaryKey='id_pago_metodo';
}
