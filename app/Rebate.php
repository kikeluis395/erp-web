<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rebate extends Model
{
    protected $table="rebates";    
    protected $primaryKey='id_rebate';
    protected $dates = ['fecha_registro'];
    
    public $timestamps = false;    

    public function local() {
        return $this->belongsTo('App\Modelos\LocalEmpresa', 'id_local');
    }

    public function empleado() {
        return $this->belongsTo('App\Modelos\Empleado', 'dni');
    }

    public function proveedor() {
        return $this->belongsTo('App\Modelos\Proveedor', 'id_proveedor');
    }
}
