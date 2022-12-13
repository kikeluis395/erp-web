<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Modelos\OrdenCompra;
use Illuminate\Http\Request;

class SeguimientoOCController extends Controller
{

   public function datatables(Request $request)
   {

      $otro_producto_servicio = Otrotro_producto_servicioervicio::query();

      // $cod_buscar  = $request->codproducto;
      // $est_buscar  = $request->estproducto;
      // $alm_buscar  = $request->almproducto;
      // $resp_buscar = $request->resproducto;

      // *********** BUSQUEDAS UNITARIAS - CODIGO DEL PRODUCTO *****************
      // if (!empty($request->codproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
      //       ->get();
      // }

      // if (!empty($request->codproducto) && !empty($request->estproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
      //       ->where('otro_producto_servicio.estado', $est_buscar)
      //       ->get();
      // }

      // if (!empty($request->codproducto) && !empty($request->almproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
      //       ->where('otro_producto_servicio.id_parametros', $alm_buscar)
      //       ->get();
      // }

      // if (!empty($request->codproducto) && !empty($request->resproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.codigo', 'LIKE', '%' . $cod_buscar . '%')
      //       ->where('otro_producto_servicio.user_create', $resp_buscar)
      //       ->get();
      // }

      // // *********** BUSQUEDAS UNITARIAS - ESTADOS *****************
      // if (!empty($request->estproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.estado', $est_buscar)
      //       ->get();
      // }

      // if (!empty($request->estproducto) && !empty($request->resproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.estado', $est_buscar)
      //       ->where('otro_producto_servicio.user_create', $resp_buscar)
      //       ->get();
      // }

      // if (!empty($request->estproducto) && !empty($request->almproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.estado', $est_buscar)
      //       ->where('otro_producto_servicio.id_parametros', $alm_buscar)
      //       ->get();
      // }

      // // *********** BUSQUEDAS UNITARIAS - ALMACENES *****************
      // if (!empty($request->almproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.id_parametros', $alm_buscar)
      //       ->get();
      // }

      // if (!empty($request->almproducto) && !empty($request->resproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.id_parametros', $alm_buscar)
      //       ->where('otro_producto_servicio.user_create', $resp_buscar)
      //       ->get();
      // }

      // // *********** BUSQUEDAS UNITARIAS - RESPONSABLE *****************
      // if (!empty($request->resproducto)) {

      //    $otro_producto_servicio
      //       ->where('otro_producto_servicio.user_create', $resp_buscar)
      //       ->get();
      // }

      // ************* MOSTRANDO TODO LOS DATOS EN EL DATATABLE ******************
      $osproducto_final = $otro_producto_servicio->join('parametros', 'parametros.id', '=', 'otro_producto_servicio.id_parametros')
         ->join('usuario', 'usuario.id_usuario', '=', 'otro_producto_servicio.user_create')
         ->select('otro_producto_servicio.*', 'parametros.valor1 as parametro', 'usuario.username as usuario_creado')
         ->get();

      return DataTables::of($osproducto_final)
         ->addColumn('acciones', function ($osproducto) {
            return
            '<div>
               <button class="btn btn-info btn-accion edit mr-1" id="' . $osproducto->id . '" data-toggle="tooltip" data-placement="top" title="Editar">
                  <span class="far fa-edit fa-xs"></span>
               </button>

               <button class="btn btn-danger btn-accion delete mr-1" id="' . $osproducto->id . '" data-toggle="tooltip" data-placement="top" title="Eliminar">
                  <span class="far fa-trash-alt fa-xs"></span>
               </button>
            </div>';
         })
         ->addColumn('usuario_update', function ($osproducto) {
            $user_update = DB::table('otro_producto_servicio')
               ->join('usuario', 'usuario.id_usuario', '=', 'otro_producto_servicio.user_update')
               ->select('usuario.username as usuario_update')
               ->where('otro_producto_servicio.id', $osproducto->id)
               ->pluck('usuario_update');

            return $user_update;
         })
         ->addIndexColumn()
         ->rawColumns(['acciones', 'checkbox-estado'])
         ->make(true);
   }

   public function index(Request $request)
   {

      $nroDoc       = trim($request->nroDoc) ? $request->nroDoc : false;
      $nroOC        = trim($request->nroOC) ? $request->nroOC : false;
      $userRegistro = trim($request->userRegistro) ? $request->userRegistro : false;
      $estado       = $request->estado;

      //Pendiente Opimización: En esta ocasión, se obtiene todas las Órdenes de Compra de la bd para que luego
      //se realice el filtrato escrito posteriormente. La idea para poder optimizar lo realizado sería
      //realizar una query en la que se realice el filtrado realizado en la misma.
      $ordenesCompra = OrdenCompra::orderBy('id_orden_compra', 'ASC');

      //Para obtener todos los usuarios
      $ordenesUsuarios = $ordenesCompra->get()->filter(function ($value) {
         return $value->flagAtentidoTotal() == false;
      });

      $usuarios = [];
      foreach ($ordenesUsuarios as $orden) {
         $usuarios[] = [
            $orden->getNombreUsuarioRegistro(),
            $orden->getNombreCompletoUsuarioRegistro()
         ];
      }

      $usuarios = array_map("unserialize", array_unique(array_map("serialize", $usuarios)));
      //Para obtener todos los usuarios

      if ($nroDoc) {
         $ordenesCompra = $ordenesCompra->whereHas('proveedor', function ($query) use ($nroDoc) {
            $query->where('num_doc', $nroDoc);
         });
      }

      if ($nroOC) {
         $ordenesCompra = $ordenesCompra->where('id_orden_compra', $nroOC);
      }

      if ($userRegistro && $userRegistro != 'all') {
         $ordenesCompra = $ordenesCompra->whereHas('usuario', function ($query) use ($userRegistro) {
            $query->where('username', '=', "$userRegistro");
         });
      }

      if ($estado != 'all') {
         if ($estado == 'atendido_total') {
            $ordenesCompra = $ordenesCompra->where('es_finalizado', 1);
         }

         if ($estado == 'atendido_parcial') {
            $ordenesCompra = $ordenesCompra->where('es_finalizado', 0)
               ->whereHas('lineasCompra', function ($query) {
                  $query->has('lineasNotaIngreso', '>', 0);
               });
         }

         if ($estado == 'aprobado') {
            $ordenesCompra = $ordenesCompra->where('es_finalizado', 0)
               ->where('es_aprobado', 1)
               ->whereHas('lineasCompra', function ($query) {
                  $query->has('lineasNotaIngreso', '=', 0);
               });
         }

         if ($estado == 'pendiente_aprobacion') {
            $ordenesCompra = $ordenesCompra->where('es_finalizado', 0)
               ->where('es_aprobado', 0)
               ->whereHas('lineasCompra', function ($query) {
                  $query->has('lineasNotaIngreso', '=', 0);
               });
         }
      }

      $ordenesCompra = $ordenesCompra->get()->filter(function ($value) {
         return $value->flagAtentidoTotal() == false;
      });

      return view('contabilidadv2.seguimientoOC', ['ordenesCompra' => $ordenesCompra, 'usuarios' => $usuarios]);
   }
}
