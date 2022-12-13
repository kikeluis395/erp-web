<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Modelos\OrdenCompra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisualizarOCController extends Controller
{
   public function index(Request $request)
   {
      $id_orden_compra = $request->input("id_orden_compra");
      $ordenC          = OrdenCompra::find($id_orden_compra);

      $ordenPDF = DB::table('orden_compra as oc')
         ->leftJoin('local_empresa as le', 'le.id_local', 'oc.id_local_empresa')
         ->select('le.*', 'oc.*')
         ->where([
            ['oc.id_orden_compra', $ordenC->id_orden_compra]
         ])
         ->first();

      $estadoN = DB::table('parametros')
         ->join('orden_compra as oc', 'oc.id_estado', '=', 'parametros.id')
         ->select('parametros.*')
         ->where([
            ['parametros.id', $ordenC->id_estado]
         ])
         ->first();
// ***************************************************
      $empresa = DB::table('local_empresa')
         ->join('orden_compra as oc', 'oc.id_local_empresa', '=', 'local_empresa.id_local')
         ->select('local_empresa.*')
         ->where([
            ['local_empresa.id_local', $ordenC->id_local_empresa]
         ])
         ->first();

      $almacen = DB::table('parametros')
         ->join('orden_compra as oc', 'oc.id_almacen', '=', 'parametros.id')
         ->select('parametros.*')
         ->where([
            ['parametros.id', $ordenC->id_almacen]
         ])
         ->first();

      $estado = DB::table('parametros')
         ->join('orden_compra as oc', 'oc.id_estado', '=', 'parametros.id')
         ->select('parametros.*')
         ->where([
            ['parametros.id', $ordenC->id_estado]
         ])
         ->first();

      $motivo = DB::table('parametros')
         ->join('orden_compra as oc', 'oc.id_motivo', '=', 'parametros.id')
         ->select('parametros.*')
         ->where([
            ['parametros.id', $ordenC->id_motivo]
         ])
         ->first();

      $proveedor = DB::table('proveedor')
         ->join('orden_compra as oc', 'oc.id_proveedor', '=', 'proveedor.id_proveedor')
         ->join('ubigeo', 'ubigeo.codigo', '=', 'proveedor.cod_ubigeo')
         ->select('proveedor.*', 'ubigeo.*')
         ->where([
            ['proveedor.id_proveedor', $ordenC->id_proveedor]
         ])
         ->first();

      $usuario = DB::table('usuario')
         ->join('orden_compra as oc', 'oc.id_usuario_registro', '=', 'usuario.id_usuario')
         ->select('usuario.*')
         ->where([
            ['usuario.id_usuario', $ordenC->id_usuario_registro]
         ])
         ->first();

      $condicionPago = DB::table('orden_compra')
         ->select(
            DB::raw('(CASE
            WHEN orden_compra.condicion_pago = "CONTADO" THEN "CONTADO"
            WHEN orden_compra.condicion_pago = "CREDITO-15D" THEN "CREDITO A 15 DIAS"
            WHEN orden_compra.condicion_pago = "CREDITO-30D" THEN "CREDITO A 30 DIAS"
            WHEN orden_compra.condicion_pago = "CREDITO-45D" THEN "CREDITO A 45 DIAS"
            WHEN orden_compra.condicion_pago = "CREDITO-60D" THEN "CREDITO A 60 DIAS"
            END) AS pago')
         )
         ->where([
            ['orden_compra.id_orden_compra', $ordenC->id_orden_compra]
         ])
         ->first();

      $lineaOCompra = DB::table('linea_orden_compra as loc')
         ->leftJoin('orden_compra as oc', 'oc.id_orden_compra', '=', 'loc.id_orden_compra')
         ->leftJoin('repuesto as r', 'r.id_repuesto', '=', 'loc.id_repuesto')
         ->leftJoin('vehiculo_nuevo as vh', 'vh.id_vehiculo_nuevo', '=', 'loc.id_vehiculo_nuevo')
         ->leftJoin('otro_producto_servicio as op', 'op.id_otro_producto_servicio', '=', 'loc.id_otro_producto_servicio')
      // ->leftJoin('movimiento_repuesto as mr', 'mr.id_repuesto', '=', 'r.id_repuesto')
      // ->select('oc.*', 'loc.*', 'r.*', DB::raw("sum(CASE WHEN mr.tipo_movimiento='INGRESO' THEN mr.cantidad_movimiento WHEN tipo_movimiento='EGRESO' THEN -cantidad_movimiento ELSE 0 END) as saldo_actual"),
      // )
         ->select('oc.*', 'loc.*', 'r.*', 'r.descripcion as nom_repuesto', 'vh.*', 'op.*', 'op.descripcion as nom_producto')
         ->where([
            ['loc.id_orden_compra', $ordenC->id_orden_compra]
         ])
         ->get();

      $almacen_repuestos = DB::table('parametros as p')
         ->leftjoin('orden_compra as oc', 'oc.id_almacen', '=', 'p.id')
         ->select('p.valor1')
         ->where([
            ['p.valor2', 'ALMACEN'],
            ['oc.id_orden_compra', $ordenC->id_orden_compra]
         ])
         ->first();

      return view('contabilidadv2.visualizarOC', compact('ordenC', 'empresa', 'almacen', 'estado', 'usuario', 'motivo', 'condicionPago', 'proveedor', 'lineaOCompra', 'estadoN', 'almacen_repuestos', 'ordenPDF'));
   }

   public function cambiarEstado(Request $request)
   {
      $id_orden_compra = $request->id_oc;
      $ordenC          = OrdenCompra::find($id_orden_compra);

      // $descargarPDF = route('hojaOrdenCompra', ['id_orden_compra' => $id_orden_compra]);

      $nuevoEstado = $request->estado;

      $estado = DB::table('parametros')
         ->select('parametros.*')
         ->where([
            ['parametros.valor1', $nuevoEstado]
         ])
         ->first();

      $ordenC->es_aprobado          = '1';
      $ordenC->id_estado            = $estado->id;
      $fecha_aprobacion             = Carbon::now();
      $ordenC->fecha_aprobacion     = $fecha_aprobacion;
      $ordenC->id_usuario_aprobador = Auth::user()->id_usuario;
      $ordenC->save();

      return response()->json(['success' => $id_orden_compra]);
   }

   public function eliminarOC(Request $request)
   {
      $idOrdenCompra = $request->input('id_orden_compra');
      $ordenCompra   = OrdenCompra::find($idOrdenCompra);

      if ($ordenCompra) {
         //validacion de que ninguna linea de compra tenga nota de ingreso
         foreach ($ordenCompra->lineasCompra as $lineaOC) {
            if (count($lineaOC->lineasNotaIngreso) > 0) {
               return redirect()->back();
            }

         }

         DB::beginTransaction();
         foreach ($ordenCompra->lineasCompra as $lineaOC) {
            $lineaOC->delete();
         }

         $ordenCompra->delete();
         DB::commit();
      }
      return redirect()->route('contabilidad.seguimientoOC');
   }


   public function update(Request $request)
   {

      $id_orden_compra = $request->id_oc;
      $ordenC          = OrdenCompra::find($id_orden_compra);
      $ordenC->factura_proveedor         = $request->factura;
      $ordenC->save();

      // return redirect()->route('contabilidad.seguimientoOC');
      $request['id_orden_compra'] = $id_orden_compra ;
      return $this->index($request);
   }
}
