<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
   protected $table      = "proveedor";
   protected $fillable   = ['num_doc', 'nombre_proveedor', 'giro', 'email', 'direccion', 'tipo_proveedor', 'activo', 'domiciliado', 'contacto', 'email_contacto', 'telf_contacto', 'cod_ubigeo'];
   protected $primaryKey = 'id_proveedor';

   public $timestamps = false;

   public function compras()
   {
      return $this->hasMany('App\Modelos\Compra', 'id_proveedor');
   }

   public function serviciosTerceros()
   {
      return $this->hasMany('App\Modelos\ServicioTerceroSolicitado', 'id_proveedor');
   }

   public function getDepartamento()
   {
      return substr($this->cod_ubigeo, 0, 2);
   }

   public function ubigeoEjemplo()
   {
      return $this->belongsTo('App\Modelos\Ubigeo', 'cod_ubigeo');
   }

   public function ubigeo()
   {
      return $this->belongsTo('App\Modelos\Ubigeo', 'cod_ubigeo');
   }

   public function getDepartamentoText()
   {
      return $this->ubigeo ? $this->ubigeo->departamento : '-';
   }

   public function getDepartamentoNombre()
   {
      return $this->ubigeo->departamento;
   }

   public function getProvincia()
   {
      return substr($this->cod_ubigeo, 2, 2);
   }

   public function getProvinciaText()
   {
      return $this->ubigeo ? $this->ubigeo->provincia : '';
   }

   public function getDistrito()
   {
      return substr($this->cod_ubigeo, 4, 2);
   }

   public function getDistritoText()
   {
      return $this->ubigeo ? $this->ubigeo->distrito : '';
   }
}
