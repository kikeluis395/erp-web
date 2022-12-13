<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\LocalEmpresa;
use App\Modelos\OrdenCompra;
use App\Modelos\Parametro;
use App\Modelos\VehiculoNuevoInstancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CrearOCController extends Controller
{

   public function empresa_local(Request $request)
   {
      if ($request->ajax()) {

         $empresaName = $request->input('empresaName');
         $empresa     = LocalEmpresa::where([
            ['nombre_empresa', '=', $empresaName]
         ])->get();
         return response()->json($empresa);
      }
   }

   public function buscar_repuesto(Request $request)
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

   public function buscar_vehiculo(Request $request)
   {
      $buscar = $request->get('campo_buscar');

      $vehiculo_buscado = DB::table('vehiculo_nuevo')
         ->join('marca_auto', 'marca_auto.id_marca_auto', '=', 'vehiculo_nuevo.id_marca_auto')
         ->select('vehiculo_nuevo.*', 'marca_auto.nombre_marca as vehiculo')
         ->where([
            ['vehiculo_nuevo.modelo_comercial', 'LIKE', '%' . $buscar . '%'],
            ['vehiculo_nuevo.habilitado', '1']
         ])
         ->groupBy('modelo')
         ->get();

      $modelos = [];
      foreach ($vehiculo_buscado as $buscado) {
         $modelos[] = [
            'idvehiculo' => $buscado->id_vehiculo_nuevo,
            'modelo'     => $buscado->modelo_comercial,
            'marca'      => $buscado->vehiculo
         ];
      }

      return response()->json($modelos);
   }

   public function buscar_otroproducto(Request $request)
   {
      $buscar       = $request->get('campo_buscar');
      $id_parametro = $request->get('id');

      $producto_buscado = DB::table('otro_producto_servicio as op')
         ->join('parametros as p', 'p.id', 'op.id_parametros')
         ->select('op.*')
         ->where([
            ['op.codigo', 'LIKE', '%' . $buscar . '%'],
            ['op.id_parametros', $id_parametro]
         ])
         ->groupBy('op.codigo')
         ->get();

      $productos = [];
      foreach ($producto_buscado as $buscado) {
         $productos[] = [
            'id_producto' => $buscado->id_otro_producto_servicio,
            'codigo'      => $buscado->codigo,
            'descripcion' => $buscado->descripcion
         ];
      }

      return response()->json($productos);
   }

   public function buscar_proveedor(Request $request)
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

   public function index(Request $request)
   {
      $year = date("Y");

      // OBTENER TODOS LOS ALMACENES
      $almacenes = DB::table('parametros')
         ->where([
            ['parametros.valor2', 'ALMACEN'],
            ['parametros.estado', '1'],
            ['parametros.valor1', '!=', 'ALMACÉN DE VEHICULOS NUEVOS'],
            ['parametros.valor1', '!=', 'ALMACÉN DE VEHICULOS SEMINUEVOS']
         ])
         ->pluck('valor1', 'id')
         ->toArray();

      $motivosOC = DB::table('parametros')
         ->where([
            ['parametros.valor2', 'REQUERIMIENTO'],
            ['parametros.estado', '1']
         ])
         ->pluck('valor1', 'id')
         ->toArray();

      // OBTENER LOS VALORES ENUM DEL CAMPO CONDICION DE PAGO
      $condicion_pago = OrdenCompra::obtenerCondicionPago();

      foreach ($condicion_pago as $condicion) {
         switch ($condicion) {
            case 'CONTADO':
               $valor[] = 'CONTADO';
               break;
            case 'CREDITO-15D':
               $valor[] = 'CREDITO 15 DIAS';
               break;
            case 'CREDITO-30D':
               $valor[] = 'CREDITO 30 DIAS';
               break;
            case 'CREDITO-45D':
               $valor[] = 'CREDITO 45 DIAS';
               break;
            case 'CREDITO-60D':
               $valor[] = 'CREDITO 60 DIAS';
               break;
         }
      }

      $condiciones = $valor;

      $empresa = DB::table('local_empresa')
         ->where('habilitado', 1)
         ->groupBy('nombre_empresa')
         ->pluck('nombre_empresa', 'id_local')
         ->toArray();

      $moneda = OrdenCompra::groupBy('tipo_moneda')->orderBy('tipo_moneda','desc')->pluck('tipo_moneda', 'tipo_moneda')->toArray();

      $usu_logueado = Auth::user()->username;

      $idOrdenCompra = OrdenCompra::latest('id_orden_compra')->first();

      $codigoOC = 'OC-' . date('Y') . '-' . ($idOrdenCompra->id_orden_compra + 1);

      return view('contabilidadv2.crearOC', compact('almacenes', 'usu_logueado', 'motivosOC', 'condiciones', 'empresa', 'moneda', 'year', 'codigoOC'));
   }

   public function indexVehiculoNuevo(Request $request)
   {
      $year = date("Y");

      // OBTENER TODOS LOS ALMACENES
      $almacenes = DB::table('parametros')
         ->where([
            ['parametros.valor2', 'ALMACEN'],
            ['parametros.estado', '1'],
            ['parametros.valor1', 'ALMACÉN DE VEHICULOS NUEVOS']
         ])
         ->pluck('valor1', 'id')
         ->toArray();

      $motivosOC = DB::table('parametros')
         ->where([
            ['parametros.valor2', 'REQUERIMIENTO'],
            ['parametros.estado', '1'],
            ['parametros.valor3', 'VEHICULO']
         ])
         ->pluck('valor1', 'id')
         ->toArray();

      // OBTENER LOS VALORES ENUM DEL CAMPO CONDICION DE PAGO
      $condicion_pago = OrdenCompra::obtenerCondicionPago();

      foreach ($condicion_pago as $condicion) {
         switch ($condicion) {
            case 'CONTADO':
               $valor[] = 'CONTADO';
               break;
            case 'CREDITO-15D':
               $valor[] = 'CREDITO 15 DIAS';
               break;
            case 'CREDITO-30D':
               $valor[] = 'CREDITO 30 DIAS';
               break;
            case 'CREDITO-45D':
               $valor[] = 'CREDITO 45 DIAS';
               break;
            case 'CREDITO-60D':
               $valor[] = 'CREDITO 60 DIAS';
               break;
         }
      }

      $condiciones = $valor;

      $empresa = DB::table('local_empresa')
         ->where('habilitado', 1)
         ->groupBy('nombre_empresa')
         ->pluck('nombre_empresa', 'id_local')
         ->toArray();

      $moneda = OrdenCompra::groupBy('tipo_moneda')->pluck('tipo_moneda', 'tipo_moneda')->toArray();

      $usu_logueado = Auth::user()->username;

      $idOrdenCompra = OrdenCompra::latest('id_orden_compra')->first();

      $codigoOC = 'OC-' . date('Y') . '-' . ($idOrdenCompra->id_orden_compra + 1);

      return view('contabilidadv2.crearOCVehiculoNuevo', compact('almacenes', 'usu_logueado', 'motivosOC', 'condiciones', 'empresa', 'moneda', 'year', 'codigoOC'));
   }

   public function store(Request $request)
   {

      if ($request->ajax()) {

         $rules = [
            'proveedor'         => 'required',
            'proveedorID'       => 'required',
            'sucursal'          => 'required',
            'almacen'           => 'required',
            'fec_emision'       => 'required',
            'moneda'            => 'required',
            'motivooc'          => 'required',
            'detalle_motivo'    => 'max:50',
            'condicion_pago'    => 'required',
            'observaciones'     => 'max:100',

            'id_repuesto.*'     => 'sometimes|required',
            'codigo.*'          => 'sometimes|required',
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
            'year_vn_fabrication.*'         => 'sometimes|required',
            'estado_stock.*'    => 'sometimes|required',
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

         $idOrdenCompra = OrdenCompra::latest('id_orden_compra')->first();

         $codigoOC = 'OC-' . date('Y') . '-' . ($idOrdenCompra->id_orden_compra + 1);

         $orden_compra                      = new OrdenCompra();
         $orden_compra->id_local_empresa    = $request->sucursal;
         $orden_compra->id_almacen          = $request->almacen;
         $orden_compra->codigo_orden_compra = $codigoOC;
         // $orden_compra->fecha_registro      = date('Y-m-d', strtotime($request->fec_emision));
         //$orden_compra->fecha_registro      = Carbon::parse($request->fec_emision);
         $orden_compra->fecha_registro      = Carbon::createFromFormat('d/m/Y', $request->fec_emision)->format('Y-m-d');
         $orden_compra->tipo_moneda         = $request->moneda;
         $orden_compra->id_usuario_registro = Auth::user()->id_usuario;
         $orden_compra->id_motivo           = $request->motivooc;
         $orden_compra->detalle_motivo      = strtoupper($request->detalle_motivo);

         $condicion = $request->condicion_pago;

         switch ($condicion) {
            case '0':
               $valor = 'CONTADO';
               break;
            case '1':
               $valor = 'CREDITO-15D';
               break;
            case '2':
               $valor = 'CREDITO-30D';
               break;
            case '3':
               $valor = 'CREDITO-45D';
               break;
            case '4':
               $valor = 'CREDITO-60D';
               break;
         }

         $estado = DB::table('parametros')
            ->select('parametros.*')
            ->where([
               ['parametros.valor1', 'PENDIENTE']
            ])
            ->first();

         $orden_compra->condicion_pago = $valor;
         $orden_compra->id_proveedor   = $request->proveedorID;
         $orden_compra->id_estado      = $estado->id;
         $orden_compra->observaciones  = strtoupper($request->observaciones);
         $orden_compra->save();

         // *****************************************************
         // ************** TABLA DE DETALLES *********************
         // *****************************************************

         $almacenVN  = $request->almacentext;
         $contienevn = strpos($almacenVN, 'VEHICULO');
         $contienerp = strpos($almacenVN, 'REPUESTO');

         if ($contienevn == true) {
            $orden_compra->tipo = 'VEHICULOS';
            $orden_compra->save();
            // ************** ALMACEN DE VEHICULOS NUEVOS *********************

            $contador = count(collect($request->idVehiculoN));

            for ($count = 0; $count < $contador; $count++) {

               $estado_stock = Parametro::where('valor1',$request->estado_stock[$count])->first();
               $estado_vehiculo = Parametro::where('valor1','DISPONIBLE')->first();
               
               
               if($request->estado_stock[$count]== 'COMODATO'){
                  $tipo_stock = Parametro::where('valor3',$request->estado_stock[$count])->first();
               }else{
                  $tipo_stock = Parametro::where('valor3','STOCK DEALER')->first();
               }

               $vehiculo_nuevo_instancia = new VehiculoNuevoInstancia();
               $vehiculo_nuevo_instancia->id_estado_stock = $estado_stock->id;
               $vehiculo_nuevo_instancia->id_estado_vehiculo = $estado_vehiculo->id;
               $vehiculo_nuevo_instancia->vin = strtoupper($request->vin_vn[$count]);
               $vehiculo_nuevo_instancia->numero_motor = strtoupper($request->numMotor_vn[$count]);
               $vehiculo_nuevo_instancia->anio = $request->year_vn[$count];
               $vehiculo_nuevo_instancia->anho_fabricacion = $request->year_vn_fabrication[$count];
               $vehiculo_nuevo_instancia->color = strtoupper($request->color_vn[$count]);
               $vehiculo_nuevo_instancia->habilitado = 1;
               $vehiculo_nuevo_instancia->creador = Auth::user()->id_usuario;
               $vehiculo_nuevo_instancia->editor =Auth::user()->id_usuario;
               $vehiculo_nuevo_instancia->id_local = 1;
               $vehiculo_nuevo_instancia->id_modelo_comercial_vn = $request->idVehiculoN[$count];
               $vehiculo_nuevo_instancia->id_tipo_stock = $tipo_stock->id;
               $vehiculo_nuevo_instancia->save();

               $lineaoc                    = new LineaOrdenCompra();
               $lineaoc->id_orden_compra   = $orden_compra->id_orden_compra;
               $lineaoc->id_vehiculo_nuevo = $request->idVehiculoN[$count];
               $lineaoc->vin               = strtoupper($request->vin_vn[$count]);
               $lineaoc->numero_motor      = strtoupper($request->numMotor_vn[$count]);
               $lineaoc->anio              = $request->year_vn[$count];
               $lineaoc->estado_stock      = $request->estado_stock[$count];
               $lineaoc->cantidad          = '1';
               $lineaoc->color             = strtoupper($request->color_vn[$count]);
               $lineaoc->precio            = $request->cosUnitario_vh[$count];
               $lineaoc->descuento         = $request->desUnitario_vn[$count];
               $lineaoc->sub_total         = round($request->subTotal_vn[$count], 2);
               $lineaoc->impuesto          = round($request->igv_vn[$count], 2);
               $lineaoc->total             = round($request->total_vn[$count], 2);
               $lineaoc->id_vehiculo_nuevo_instancia = $vehiculo_nuevo_instancia->id_vehiculo_nuevo_instancia;
               $lineaoc->save();

            }

         }
         if ($contienerp == true) {

            // ************** ALMACEN REPUESTO *********************

            $contador = count(collect($request->id_repuesto));

            for ($count = 0; $count < $contador; $count++) {

               $lineaoc                  = new LineaOrdenCompra();
               $lineaoc->id_orden_compra = $orden_compra->id_orden_compra;
               $lineaoc->id_repuesto     = $request->id_repuesto[$count];
               $lineaoc->cantidad        = $request->cantidad[$count];
               $lineaoc->precio          = $request->costo_unitario[$count];
               $lineaoc->descuento       = $request->des_unitario[$count];
               $lineaoc->sub_total       = round($request->sub_total[$count], 2);
               $lineaoc->impuesto        = round($request->impuesto[$count], 2);
               $lineaoc->total           = round($request->total[$count], 2);
               $lineaoc->save();

            }

         }

         // ************** OTROS ALMACENES *********************
         if ($contienevn == false and $contienerp == false) {

            $contador = count(collect($request->id_repuesto));

            for ($count = 0; $count < $contador; $count++) {

               $lineaoc                   = new LineaOrdenCompra();
               $lineaoc->id_orden_compra  = $orden_compra->id_orden_compra;
               $lineaoc->id_otro_producto_servicio = $request->id_repuesto[$count];
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
