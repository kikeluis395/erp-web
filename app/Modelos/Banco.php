<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'banco';
    protected $primaryKey='id_banco';
    protected $fillable = ['codigo_banco', 'nombre_banco', 'nombre_sunat'];
    public $timestamps = false;

    public function cuentasBancarias()
    {
        return $this->hasMany('App\Modelos\CuentaBancaria','id_banco');
    }
}
