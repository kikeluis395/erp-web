<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\OrdenCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActualizarOCController extends Controller
{

   public function empresa_local(Request $request)
   {
      if ($request->ajax()) {

         $empresaName = $request->input('empresaName');
         $empresa     = DB::table('local_empresa as le')
            ->join('orden_compra as oc', 'oc.id_local_empresa', '=', 'le.id_local')
            ->groupBy('le.nombre_local')
            ->where([
               ['le.nombre_empresa', '=', $empresaName]
            ])->get();
         return response()->json($empresa);
      }
   }

   public function actualizar_proveedor(Request $request)
   {
      $buscar = $request->get('campo_buscar');

      $proveedor_buscado = DB::table('proveedor')
         ->join('ubigeo', 'ubigeo.codigo', '=', 'proveedor.cod_ubigeo')
         ->select('proveedor.*', 'ubigeo.departamento as depart', 'ubigeo.provincia as provinc', 'ubigeo.distrito as distric')
         ->where('num_doc', 'LIKE', '%' . $buscar . '%')
         ->get();

      $proveedores = [];
      foreach ($proveedor_buscado as $buscado) {
         $proveedores[] = [
            'provedorID'     => $buscado->id_proveedor,
            'ruc'            => $buscado->num_doc,
            'nombre'         => $buscado->nombre_proveedor,
            'nom_contacto'   => $buscado->contacto,
            'telf_contacto'  => $buscado->telf_contacto,
            'email_contacto' => $buscado->email_contacto,
            'direccion'      => $buscado->direccion,
            'departamento'   => $buscado->depart,
            'provincia'      => $buscado->provinc,
            'distrito'       => $buscado->distric

         ];
      }

      return response()->json($proveedores);

   }

   public function actualizar_repuesto(Request $request)
   {
      $buscar = $request->get('campo_buscar');

      $respuesto_buscado = DB::table('repuesto')
         ->leftJoin('movimiento_repuesto', 'movimiento_repuesto.id_repuesto', '=', 'repuesto.id_repuesto')
         ->select(
            'repuesto.id_repuesto as idRepuesto',
            'codigo_repuesto',
            'descripcion',
            DB::raw("sum(CASE WHEN tipo_movimiento='INGRESO' THEN cantidad_movimiento WHEN tipo_movimiento='EGRESO' THEN -cantidad_movimiento ELSE 0 END) as saldo_actual")
         )
         ->where('codigo_repuesto', 'LIKE', '%' . $buscar . '%')
         ->groupBy('codigo_repuesto', 'descripcion')
         ->get();

      $respuestos = [];
      foreach ($respuesto_buscado as $buscado) {
         $respuestos[] = [
            'idrepuesto'   => $buscado->idRepuesto,
            'cod_repuesto' => $buscado->codigo_repuesto,
            'nom_repuesto' => $buscado->descripcion,
            'stock'        => $buscado->saldo_actual
         ];
      }

      return response()->json($respuestos);
   }

   public function actualizar_vehiculo(Request $request)
   {
      $buscar = $request->get('campo_buscar');

      $vehiculo_buscado = DB::table('vehiculo_nuevo')
         ->join('marca_auto', 'marca_auto.id_marca_auto', '=', 'vehiculo_nuevo.id_marca_auto')
         ->select('vehiculo_nuevo.*', 'marca_auto.nombre_marca as vehiculo')
         ->where('modelo', 'LIKE', '%' . $buscar . '%')
         ->groupBy('modelo')
         ->get();

      $modelos = [];
      foreach ($vehiculo_buscado as $buscado) {
         $modelos[] = [
            'idvehiculo' => $buscado->id_vehiculo_nuevo,
            'modelo'     => $buscado->modelo,
            'marca'      => $buscado->vehiculo
         ];
      }

      return response()->json($modelos);

   }

   public function actualizar_producto(Request $request)
   {
      $buscar       = $request->get('campo_buscar');
      $id_parametro = $request->get('id');

      $producto_buscado = DB::table('otro_producto_servicio as op')
         ->join('parametros as p', 'p.id', 'op.id_parametros')
         ->select('op.id_otro_producto_servicio as idProducto', 'op.codigo as codProducto', 'op.descripcion as desProducto')
         ->where([
            ['op.codigo', 'LIKE', '%' . $buscar . '%'],
            ['op.id_parametros', $id_parametro]
         ])
         ->groupBy('op.codigo')
         ->get();

      $productos = [];
      foreach ($producto_buscado as $buscado) {
         $productos[] = [
            'id_producto' => $buscado->idProducto,
            'codigo'      => $buscado->codProducto,
            'descripcion' => $buscado->desProducto
         ];
      }

      return response()->json($productos);
   }

   public function index(Request $request)
   {

      $orden_compra = $request->id_orden_compra;
      $ordenC       = OrdenCompra::find($orden_compra);

      $empresa = DB::table('local_empresa')
         ->where('habilitado', 1)
      // ->groupBy('nombre_empresa')
         ->pluck('nombre_empresa', 'id_local')
         ->toArray();

      $almacen = DB::table('parametros as p')
         ->select('p.*')
         ->groupBy('p.valor1')
         ->where([
            ['p.valor2', 'ALMACEN']
         ])
         ->pluck('p.valor1', 'p.id')
         ->toArray();

      // $almacen = DB::table('parametros')
      //    ->join('orden_compra as oc', 'oc.id_almacen', '=', 'parametros.id')
      //    ->select('parametros.*')
      //    ->where([
      //       ['parametros.id', $ordenC->id_almacen]
      //    ])
      //    ->first();

      $sucursal = DB::table('local_empresa')
         ->where('habilitado', 1)
         ->groupBy('nombre_empresa')
         ->pluck('nombre_local', 'id_local')
         ->toArray();

      $moneda = OrdenCompra::groupBy('tipo_moneda')
         ->pluck('tipo_moneda', 'tipo_moneda')
         ->toArray();

      $estadoN = DB::table('parametros')
         ->join('orden_compra as oc', 'oc.id_estado', '=', 'parametros.id')
         ->select('parametros.*')
         ->where([
            ['parametros.id', $ordenC->id_estado]
         ])
         ->first();

      $usuario = DB::table('usuario')
         ->join('orden_compra as oc', 'oc.id_usuario_registro', '=', 'usuario.id_usuario')
         ->select('usuario.*')
         ->where([
            ['usuario.id_usuario', $ordenC->id_usuario_registro]
         ])
         ->first();

      $motivosOC = DB::table('parametros')
         ->where([
            ['parametros.valor2', 'REQUERIMIENTO'],
            ['parametros.estado', '1']
         ])
         ->pluck('valor1', 'id')
         ->toArray();

      $proveedor = DB::table('proveedor')
         ->join('orden_compra as oc', 'oc.id_proveedor', '=', 'proveedor.id_proveedor')
         ->join('ubigeo', 'ubigeo.codigo', '=', 'proveedor.cod_ubigeo')
         ->select('proveedor.*', 'ubigeo.*')
         ->where([
            ['proveedor.id_proveedor', $ordenC->id_proveedor]
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
            // ['mr.fuente_id', '4012']
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

      return view('contabilidadv2.actualizaroc', compact('ordenC', 'empresa', 'almacen', 'sucursal', 'moneda', 'estadoN', 'usuario', 'motivosOC', 'proveedor', 'lineaOCompra', 'almacen_repuestos'));
   }

   public function update(Request $request, OrdenCompra $ordencompra)
   {

      if ($request->ajax()) {

         $rules = [
            'proveedor'         => 'required',
            'proveedorID'       => 'required',
            'sucursal'          => 'required',
            // 'almacen'           => 'required',
            'fec_emision'       => 'required',
            'moneda'            => 'required',
            'motivooc'          => 'required',
            'detalle_motivo'    => 'max:50',
            'condicion_pago'    => 'required',
            'observaciones'     => 'max:100',

            'codigo.*'          => 'sometimes|required',
            'id_repuesto.*'     => 'sometimes|required',
            'cantidad.*'        => 'sometimes|required',
            'costo_unitario.*'  => 'sometimes|required|numeric',
            'des_unitario.*'    => 'sometimes|required|numeric',
            'sub_total.*'       => 'sometimes|required',
            'impuesto.*'        => 'sometimes|required',
            'total.*'           => 'sometimes|required',

            'modComercial_vn.*' => 'sometimes|required',
            'idVehiculoN.*'     => 'sometimes|required',
            'vin_vn.*'          => 'sometimes|required',
            'numMotor_vn.*'     => 'sometimes|required',
            'year_vn.*'         => 'sometimes|required',
            'color_vn.*'        => 'sometimes|required',
            'cosUnitario_vh.*'  => 'sometimes|required|numeric',
            'desUnitario_vn.*'  => 'sometimes|required|numeric',
            'subTotal_vn.*'     => 'sometimes|required',
            'igv_vn.*'          => 'sometimes|required',
            'total_vn.*'        => 'sometimes|required'
         ];

         $error = Validator::make($request->all(), $rules);

         if ($error->fails()) {
            return response()->json(['errors' => $error->errors()]);
         }

         $id_orden_compra                   = $request->id_orden_compra;
         $orden_compra                      = OrdenCompra::find($id_orden_compra);
         $orden_compra->id_local_empresa    = $request->sucursal;
         $orden_compra->id_almacen          = $orden_compra->id_almacen;
         $orden_compra->fecha_registro      = date('Y-m-d', strtotime($request->fec_emision));
         $orden_compra->tipo_moneda         = $request->moneda;
         $orden_compra->id_usuario_registro = Auth::user()->id_usuario;
         $orden_compra->id_motivo           = $request->motivooc;
         $orden_compra->detalle_motivo      = strtoupper($request->detalle_motivo);

         $orden_compra->condicion_pago = $request->condicion_pago;
         $orden_compra->id_proveedor   = $request->proveedorID;

         $estado = DB::table('parametros')
            ->select('parametros.*')
            ->where([
               ['parametros.valor1', 'PENDIENTE']
            ])
            ->first();

         $orden_compra->id_estado     = $estado->id;
         $orden_compra->observaciones = strtoupper($request->observaciones);
         $orden_compra->save();

         // *****************************************************
         // ************** TABLA DE DETALLES *********************
         // *****************************************************

         $almacenVN  = $request->almacentext;
         $contienevn = strpos($almacenVN, 'VEHICULO');
         $contienerp = strpos($almacenVN, 'REPUESTO');

         if ($contienevn == true) {

            // ************** ALMACEN DE VEHICULOS NUEVOS *********************
            $contador = count(collect($request->idVehiculoN));

            for ($count = 0; $count < $contador; $count++) {

               $lineaoc                    = LineaOrdenCompra::findOrFail($request->id_lineaoc[$count]);
               $lineaoc->id_orden_compra   = $orden_compra->id_orden_compra;
               $lineaoc->id_vehiculo_nuevo = $request->idVehiculoN[$count];
               $lineaoc->vin               = strtoupper($request->vin_vn[$count]);
               $lineaoc->numero_motor      = strtoupper($request->numMotor_vn[$count]);
               $lineaoc->anio              = $request->year_vn[$count];
               $lineaoc->color             = strtoupper($request->color_vn[$count]);
               $lineaoc->precio            = $request->cosUnitario_vh[$count];
               $lineaoc->descuento         = $request->desUnitario_vn[$count];
               $lineaoc->sub_total         = round($request->subTotal_vn[$count], 2);
               $lineaoc->impuesto          = round($request->igv_vn[$count], 2);
               $lineaoc->total             = round($request->total_vn[$count], 2);
               $lineaoc->save();

            }

         }

         if ($contienerp == true) {
            // ************** ALMACEN DE REPUESTOS *********************
            $contador = count(collect($request->id_repuesto));

            for ($count = 0; $count < $contador; $count++) {

               $lineaoc              = LineaOrdenCompra::findOrFail($request->id_lineaoc[$count]);
               $lineaoc->id_repuesto = $request->id_repuesto[$count];
               $lineaoc->cantidad    = $request->cantidad[$count];
               $lineaoc->precio      = $request->costo_unitario[$count];
               $lineaoc->descuento   = $request->des_unitario[$count];
               $lineaoc->sub_total   = round($request->sub_total[$count], 2);
               $lineaoc->impuesto    = round($request->impuesto[$count], 2);
               $lineaoc->total       = round($request->total[$count], 2);
               $lineaoc->save();

            }

         }

         if ($contienevn == false and $contienerp == false) {

            // ************** ALMACEN DE REPUESTOS *********************
            $contador = count(collect($request->id_otro_producto));

            for ($count = 0; $count < $contador; $count++) {

               $lineaoc                   = LineaOrdenCompra::findOrFail($request->id_lineaoc[$count]);
               $lineaoc->id_otro_producto_servicio = $request->id_otro_producto[$count];
               $lineaoc->cantidad         = $request->cantidad[$count];
               $lineaoc->precio           = $request->costo_unitario[$count];
               $lineaoc->descuento        = $request->des_unitario[$count];
               $lineaoc->sub_total        = round($request->sub_total[$count], 2);
               $lineaoc->impuesto         = round($request->impuesto[$count], 2);
               $lineaoc->total            = round($request->total[$count], 2);
               $lineaoc->save();

            }

         }

         return response()->json(['success' => 'Registro actualizado correctamente.']);

      }

   }
}
