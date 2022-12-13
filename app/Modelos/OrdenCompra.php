<?php

namespace App\Modelos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdenCompra extends Model
{
   protected $table    = "orden_compra";
   protected $fillable = ['id_proveedor', 'tipo_moneda', 'condicion_pago', 'id_usuario_registro', 'es_aprobado', 'fecha_aprobacion', 'id_usuario_aprobador', 'es_finalizado', 'fecha_finalizado', 'id_local_empresa'];

   protected $primaryKey = 'id_orden_compra';

   public $timestamps = true;

   public function proveedor()
   {
      return $this->belongsTo('App\Modelos\Proveedor', 'id_proveedor');
   }

   public function usuario()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_registro');
   }

   public function clienteProveedor()
   {
      return $this->belongsTo('App\Modelos\Cliente', 'doc_cliente_proveedor');
   }

   public function lineasCompra()
   {
      return $this->hasMany('App\Modelos\LineaOrdenCompra', 'id_orden_compra');
   }

   public function almacen()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_almacen');
   }

   public function motivo()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_motivo');
   }

   public function estado()
   {
      return $this->belongsTo('App\Modelos\Parametro', 'id_estado');
   }

   // *************************************
   public function sucursal()
   {
      return $this->belongsTo('App\Modelos\LocalEmpresa', 'id_local_empresa');
   }

   public function obtenerSubTotal()
   {
      $sumas = $this->lineasCompra()->get();
      // return $this->cantidad * ($this->precio - $this->descuento);
      $cantidad = 0;
      foreach ($sumas->total as $suma) {
         $cantidad += $suma;
      }
      return $this->cantidad;
   }

   public function getNombreUsuarioRegistro()
   {
      return $this->usuario->username;
   }

   public function getNombreCompletoUsuarioRegistro()
   {
      return $this->usuario->empleado->primer_nombre . ' ' . $this->usuario->empleado->primer_apellido;
   }

   public function getNombreProveedor()
   {
      return $this->proveedor->nombre_proveedor;
   }

   public function getNombreLocal()
   {
      return $this->sucursal->nombre_local; //  agregado por giancarlo montalvan
   }

   public function getRUCProveedor()
   {
      return $this->proveedor->num_doc;
   }

   public function usuarioRegistro()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_registro');
   }

   public function usuarioAprobador()
   {
      return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_aprobador');
   }

   public function getCostoTotal()
   {
      $lineasCompra = $this->lineasCompra()->get();
      $total        = 0;
      foreach ($lineasCompra as $key => $lineaCompra) {
         $total += $lineaCompra->precio * $lineaCompra->cantidad;
      }
      return $total;
   }

   public function getCostoSubTotalFinal()
   {
      $lineasCompra = $this->lineasCompra()->get();
      $total        = 0;
      foreach ($lineasCompra as $key => $lineaCompra) {
         $total += $lineaCompra->subtotal;
      }
      return $total;
   }

   public function getCostoTotalRestante()
   {
      $lineasCompra = $this->lineasCompra()->get();
      $total        = 0;
      foreach ($lineasCompra as $key => $lineaCompra) {
         $total += $lineaCompra->obtenerTotalRestante();
      }
      return $total;
   }

   public function getCantProductos()
   {
      $lineasCompra = $this->lineasCompra()->get();
      return $lineasCompra->count();
   }

   public function getFechaEntregaText()
   {
      return $this->fecha_registro ? Carbon::parse($this->fecha_registro)->format('d/m/Y H:i') : null;
   }

   public function flagAtentidoTotal()
   {
      $lineas_orden_compra = $this->lineasCompra()->get();
      foreach ($lineas_orden_compra as $key => $linea_orden_compra) {
         if (!$linea_orden_compra->flagLineaDespachada()) {
            return false;
         }
      }
      return true;
   }

   public function flagTieneNotasIngreso()
   {
      $lineasCompra = $this->lineasCompra()->get();
      foreach ($lineasCompra as $key => $linea_orden_compra) {
         if ($linea_orden_compra->lineasNotaIngreso()->get()->count()) {
            return true;
         }
      }
      return false;
   }

   public function listarNotasIngreso()
   {
      $arregloIDsNI        = [];
      $arregloNotasIngreso = [];
      $lineasCompra        = $this->lineasCompra()->get();
      foreach ($lineasCompra as $key => $linea_orden_compra) {
         $lineasNotaIngreso = $linea_orden_compra->lineasNotaIngreso()->get();
         foreach ($lineasNotaIngreso as $key => $lineaNotaIngreso) {
            $notaIngreso = $lineaNotaIngreso->notaIngreso;
            if (!$notaIngreso->id_factura) {
               if (!in_array($notaIngreso->id_nota_ingreso, $arregloIDsNI)) {
                  array_push($arregloIDsNI, $notaIngreso->id_nota_ingreso);
                  array_push($arregloNotasIngreso, $notaIngreso);
               }
            }
         }
      }
      return collect($arregloNotasIngreso);
   }

   public function aprobarOC()
   {
      $this->es_aprobado          = 1;
      $fecha_aprobacion           = Carbon::now();
      $this->fecha_aprobacion     = $fecha_aprobacion;
      $this->id_usuario_aprobador = Auth::user()->id_usuario;
      $this->save();
      return true;
   }

   // *******************************************************
   // ******* OBTENER VALORES DE LOS CAMPOS ENUM ************
   // *******************************************************

   public static function obtenerCondicionPago()
   {
      $type = DB::select(DB::raw('SHOW COLUMNS FROM orden_compra WHERE Field = "condicion_pago"'))[0]->Type;
      preg_match('/^enum\((.*)\)$/', $type, $matches);
      $values = array();
      foreach (explode(',', $matches[1]) as $value) {
         $values[] = trim($value, "'");
      }
      return $values;
   }

   public static function obtenerTipoCambio()
   {
      $type = DB::select(DB::raw('SHOW COLUMNS FROM orden_compra WHERE Field = "tipo_moneda"'))[0]->Type;
      preg_match('/^enum\((.*)\)$/', $type, $matches);
      $values = array();
      foreach (explode(',', $matches[1]) as $value) {
         $values[] = trim($value, "'");
      }
      return $values;
   }


   public function getNombreTransfiriente()
   {
      $cliente = $this->clienteProveedor;
      return $cliente->nombres.' '.$cliente->apellido_pat.' '.$cliente->apellido_mat;
   }

   public function getDireccionTransfiriente()
   {
      $cliente = $this->clienteProveedor;
      return $cliente->direccion.'/'.$cliente->getDepartamentoText().'/'.$cliente->getProvinciaText().'/'.$cliente->getDistritoText();
   }

   public function getTelefonoTransfiriente()
   {
      $cliente = $this->clienteProveedor;
      return $cliente->celular;
   }

   public function getCorreoTransfiriente()
   {
      $cliente = $this->clienteProveedor;
      return $cliente->email;
   }

   public function vehiculoSeminuevo()
   {
      return $this->lineasCompra->first()->vehiculoSeminuevo;

   }

   public function cantidadItemsPorAtender(){
      $lineas = $this->lineasCompra;
      $cantidad_restante = 0;
      foreach ($lineas as $key => $row) {
         $cantidad_restante+= $row->obtenerCantidadRestante();
      }
      return $cantidad_restante;
   }
   
}
