<?php

// *************************************************************************************
// ************************ DESARROLLADOR - GIANCARLO MONTALVAN G. *********************
// *************************************************************************************

namespace App\Http\Controllers\ProductosOtros;

use App\Http\Controllers\Controller;
use App\Modelos\OtroProductoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class OtroProductoServicioController extends Controller
{

   public function datatables(Request $request)
   {

      $otro_producto_servicio = OtroProductoServicio::query();

      $cod_buscar  = $request->codproducto;
      $est_buscar  = $request->estproducto;
      $alm_buscar  = $request->almproducto;
      $resp_buscar = $request->resproducto;

      // *********** BUSQUEDAS UNITARIAS - CODIGO DEL PRODUCTO *****************
      if (!empty($request->codproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
            ->get();
      }

      if (!empty($request->codproducto) && !empty($request->estproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
            ->where('otro_producto_servicio.estado', $est_buscar)
            ->get();
      }

      if (!empty($request->codproducto) && !empty($request->almproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
            ->where('otro_producto_servicio.id_parametros', $alm_buscar)
            ->get();
      }

      if (!empty($request->codproducto) && !empty($request->resproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
            ->where('otro_producto_servicio.user_create', $resp_buscar)
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - ESTADOS *****************
      if (!empty($request->estproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.estado', $est_buscar)
            ->get();
      }

      if (!empty($request->estproducto) && !empty($request->resproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.estado', $est_buscar)
            ->where('otro_producto_servicio.user_create', $resp_buscar)
            ->get();
      }

      if (!empty($request->estproducto) && !empty($request->almproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.estado', $est_buscar)
            ->where('otro_producto_servicio.id_parametros', $alm_buscar)
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - ALMACENES *****************
      if (!empty($request->almproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.id_parametros', $alm_buscar)
            ->get();
      }

      if (!empty($request->almproducto) && !empty($request->resproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.id_parametros', $alm_buscar)
            ->where('otro_producto_servicio.user_create', $resp_buscar)
            ->get();
      }

      // *********** BUSQUEDAS UNITARIAS - RESPONSABLE *****************
      if (!empty($request->resproducto)) {

         $otro_producto_servicio
            ->where('otro_producto_servicio.user_create', $resp_buscar)
            ->get();
      }

      // ************* MOSTRANDO TODO LOS DATOS EN EL DATATABLE ******************
      $osproducto_final = $otro_producto_servicio->join('parametros', 'parametros.id', '=', 'otro_producto_servicio.id_parametros')
         ->join('usuario', 'usuario.id_usuario', '=', 'otro_producto_servicio.user_create')
         ->select('otro_producto_servicio.*', 'parametros.valor1 as parametro', 'usuario.username as usuario_creado')
         ->get();

      return DataTables::of($osproducto_final)
         ->addColumn('acciones', function ($osproducto) {
            return
            '<div>
               <button class="btn btn-info btn-accion edit mr-1" id="' . $osproducto->id_otro_producto_servicio . '" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </button>

               <button class="btn btn-danger btn-accion delete mr-1" id="' . $osproducto->id_otro_producto_servicio . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>
            </div>';
         })
         ->addColumn('usuario_update', function ($osproducto) {
            $user_update = DB::table('otro_producto_servicio')
               ->join('usuario', 'usuario.id_usuario', '=', 'otro_producto_servicio.user_update')
               ->select('usuario.username as usuario_update')
               ->where('otro_producto_servicio.id_otro_producto_servicio', $osproducto->id_otro_producto_servicio)
               ->pluck('usuario_update');

            return $user_update;
         })
         ->addIndexColumn()
         ->rawColumns(['acciones', 'checkbox-estado'])
         ->make(true);
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $parametros = DB::table('parametros')
         ->where([
            ['parametros.valor2', 'ALMACEN'],
            ['parametros.valor1', '!=','ALMACEN DE VEHICULOS SEMINUEVOS'],
            ['parametros.valor1', '!=','ALMACEN DE VEHICULOS NUEVOS'],
            ['parametros.estado', 1],
            
         ])
         ->orderBy('valor1', 'asc')
         ->get();

      $almacenes = DB::table('parametros')
         ->join('otro_producto_servicio', 'otro_producto_servicio.id_parametros', '=', 'parametros.id')
         ->select('parametros.*')
         ->where([
            ['parametros.valor2', 'ALMACEN'],
            ['parametros.valor1', '!=','ALMACEN DE VEHICULOS SEMINUEVOS'],
            ['parametros.valor1', '!=','ALMACEN DE VEHICULOS NUEVOS'],
            ['parametros.estado', '1']
         ])
         ->groupBy('parametros.valor1')
         ->get();

      // $parametros = Parametro::all();

      $usuarios = DB::table('otro_producto_servicio')
         ->join('usuario', 'usuario.id_usuario', '=', 'otro_producto_servicio.user_create')
         ->select('usuario.*')
         ->groupBy('usuario.username')
         ->get();

      // $usuarios = Usuario::pluck('username', 'id_usuario')->toArray();
      return view('otrosproductos.listar', compact('almacenes', 'usuarios', 'parametros'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $rules = [

         'cod_oproducto'     => 'required',
         'des_oproducto'     => 'required',
         'almacen_oproducto' => 'required'
         // 'estado_oproducto'  => 'required'
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }
      $verify_other_code = OtroProductoServicio::where('codigo',strtoupper($request->cod_oproducto))->first();
      if($verify_other_code!=null){
         return response()->json(['errors' => 'Duplicado']);
      }
      $osproducto                = new OtroProductoServicio();
      $osproducto->codigo        = strtoupper($request->cod_oproducto);
      $osproducto->descripcion   = strtoupper($request->des_oproducto);
      $osproducto->id_parametros = $request->almacen_oproducto;
      // Estado
      if ($request->estado_oproducto == null) {
         $osproducto->estado = '0';
      } else {
         $osproducto->estado = '1';
      }
      $osproducto->user_create = Auth::user()->id_usuario;
      $osproducto->user_update = Auth::user()->id_usuario;
      $osproducto->save();

      return response()->json(['success' => 'Registro agregado correctamente.']);

      // dd($$request->cod_oproducto);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      if (request()->ajax()) {
         $oproducto = OtroProductoServicio::findOrFail($id);
         return response()->json(['oproducto' => $oproducto]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, OtroProductoServicio $OtroProductoServicio)
   {
      $rules = [
         'cod_oproducto'     => 'required',
         'des_oproducto'     => 'required',
         'almacen_oproducto' => 'required'
         // 'estado_oproducto'  => 'required'
      ];

      $error = Validator::make($request->all(), $rules);

      if ($error->fails()) {
         return response()->json(['errors' => $error->errors()]);
      }

      $osproducto                = OtroProductoServicio::findOrFail($request->osproducto_id);
      $osproducto->codigo        = strtoupper($request->cod_oproducto);
      $osproducto->descripcion   = strtoupper($request->des_oproducto);
      $osproducto->id_parametros = $request->almacen_oproducto;
      // Estado
      if ($request->estado_oproducto == null) {
         $osproducto->estado = '0';
      } else {
         $osproducto->estado = '1';
      }
      $osproducto->user_update = Auth::user()->id_usuario;
      $osproducto->save();
      return response()->json(['success' => 'Registro actualizado correctamente.']);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $osproducto = OtroProductoServicio::findOrFail($id);
      $osproducto->delete();
   }
}
