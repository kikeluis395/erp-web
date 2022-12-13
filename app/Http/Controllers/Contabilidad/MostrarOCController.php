<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Modelos\OrdenCompra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables;

class MostrarOCController extends Controller
{

    public function mostrar_sucursal(Request $request)
    {
        if ($request->ajax()) {

            $empresaName = $request->input('empresaName');
            $empresa = DB::table('local_empresa as le')
                ->join('orden_compra as oc', 'oc.id_local_empresa', '=', 'le.id_local')
                ->groupBy('le.nombre_local')
                ->where([
                    ['le.nombre_empresa', '=', $empresaName],
                ])->get();
            return response()->json($empresa);
        }
    }

    public function mostrar_proveedor(Request $request)
    {
        $buscar = $request->get('campo_buscar');

        $proveedor_buscado = DB::table('proveedor')
            ->join('orden_compra', 'orden_compra.id_proveedor', '=', 'proveedor.id_proveedor')
            ->select('proveedor.*', 'orden_compra.*')
            ->where('num_doc', 'LIKE', '%' . $buscar . '%')
            ->groupBy('num_doc')
            ->get();

        $proveedores = [];
        foreach ($proveedor_buscado as $buscado) {
            $proveedores[] = [
                'provedorID' => $buscado->id_proveedor,
                'ruc' => $buscado->num_doc,
                'nombre' => $buscado->nombre_proveedor,
            ];
        }

        return response()->json($proveedores);

    }

    public function datatables(Request $request)
    {
        $ordenC = OrdenCompra::query();
        // dd($request->all());
        // *********** BUSQUEDAS UNITARIAS - CODIGO DEL PRODUCTO *****************
        if (!empty($request->alm_buscar)) {
            $almacen_buscar = $request->alm_buscar;

            $ordenC
                ->where('orden_compra.id_almacen', $almacen_buscar)
                ->get();
        }

        if (!empty($request->suc_buscar)) {
            $sucursalBuscar = $request->suc_buscar;

            $ordenC
                ->where('orden_compra.id_local_empresa', 'LIKE', '%' . $sucursalBuscar . '%')
                ->get();
        }

        if (!empty($request->est_buscar)) {
            $estadoBuscar = $request->est_buscar;

            $ordenC
                ->where('orden_compra.id_estado', 'LIKE', '%' . $estadoBuscar . '%')
                ->get();
        }

        if (!empty($request->doc_buscar)) {
            $docBuscar = $request->doc_buscar;

            $ordenC
                ->where('orden_compra.codigo_orden_compra', 'LIKE', '%' . $docBuscar . '%')
                ->orWhere('orden_compra.id_orden_compra', 'LIKE', '%' . $docBuscar . '%')
                ->get();
        }

        if (!empty($request->docni_buscar)) {
            $docBuscar = $request->docni_buscar;

            $ordenC
                ->where('orden_compra.codigo_orden_compra', 'LIKE', '%' . $docBuscar . '%')
                ->orWhere('orden_compra.id_orden_compra', 'LIKE', '%' . $docBuscar . '%')
                ->get();
        }

        if (!empty($request->prov_buscar)) {
            $provBuscar = $request->prov_buscar;

            $ordenC
                ->where('orden_compra.id_proveedor', $provBuscar)
                ->get();
        }

        if (!empty($request->fecInicial_buscar)) {

// dd($request->all());
            $fInicialBuscar = Carbon::createFromFormat('d/m/Y', $request->fecInicial_buscar)->format('Y-m-d 00:00:00');
            $fFifnalBuscar = Carbon::createFromFormat('d/m/Y', $request->fecFinal_buscar)->format('Y-m-d 23:59:00');

            //$fInicialBuscar = date('Y-m-d', strtotime($request->fecInicial_buscar));
            //$fFifnalBuscar = date('Y-m-d', strtotime($request->fecFinal_buscar));

            $ordenC->whereRaw("date(orden_compra.fecha_registro) >= '" . $fInicialBuscar . "' AND date(orden_compra.fecha_registro) <= '" . $fFifnalBuscar . "'");

        }

        $ordenC_final = $ordenC->leftjoin('local_empresa as empresa', 'empresa.id_local', '=', 'orden_compra.id_local_empresa')
            ->leftjoin('parametros as almacen', 'almacen.id', '=', 'orden_compra.id_almacen')
            ->leftjoin('parametros as motivo', 'motivo.id', '=', 'orden_compra.id_motivo')
            ->leftjoin('parametros as estado', 'estado.id', '=', 'orden_compra.id_estado')
            ->leftjoin('proveedor as prov', 'prov.id_proveedor', '=', 'orden_compra.id_proveedor')
            ->leftjoin('linea_orden_compra as loc', 'loc.id_orden_compra', '=', 'orden_compra.id_orden_compra')
            ->select('orden_compra.*', 'orden_compra.fecha_registro as fechaCreacion', 'empresa.nombre_local as local', 'almacen.valor1 as almacen', 'motivo.valor1 as motivo', 'estado.valor1 as estado', 'prov.num_doc as rucProveedor', 'prov.nombre_proveedor as nomProveedor', 'prov.id_proveedor as idProveedor', DB::raw('SUM(loc.sub_total) as sumatotal'))
            ->groupBy('loc.id_orden_compra')
            ->orderBy('orden_compra.id_orden_compra', 'asc')
            ->get();

        return DataTables::of($ordenC_final)
            ->addColumn('acciones2', function ($orcenC) {
                $id_orden_compra = $orcenC->id_orden_compra;
                $orden_compra = OrdenCompra::find($id_orden_compra);
                $lineasCompra = $orden_compra->lineasCompra;
                $notasIngreso = [];
                foreach ($lineasCompra as $row) {
                    $lineasNotaIngreso = $row->lineasNotaIngreso;
                    foreach ($lineasNotaIngreso as $r) {
                        array_push($notasIngreso, $r->notaIngreso);
                        $notasIngreso = array_unique($notasIngreso);
                    }
                }
                if ($orcenC->estado == 'APROBADO' && $orcenC->sumatotal != '') {
                    $button = '<div class="col-6"><button id="btnShowModal-' . $orcenC->id_orden_compra . '"
                           type="button"
                           class="btn btn-success"
                           data-toggle="modal"
                           data-target="#modalIngresoNI-' . $orcenC->id_orden_compra . '"
                           data-backdrop="static"
                           style="margin-left: 8px"><i class="fas fa-info-circle icono-btn-tabla"></i></button></div>';
                    $row_table = '';

                    foreach ($notasIngreso as $row) {
                        $row_table = $row_table . '<tr>';
                        $row_table = $row_table . '<td>';
                        $row_table = $row_table . $row->fecha_registro;
                        $row_table = $row_table . '</td>';
                        $row_table = $row_table . '<td>';
                        $row_table = $row_table . 'NI-2021-' . $row->id_nota_ingreso;
                        $row_table = $row_table . '</td>';
                        $row_table = $row_table . '<td>' .
                        '<a href="/showIngresoregular/' . $row->id_nota_ingreso . '" class="btn btn-info font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Ingresar" style="color:black">
                         <span class="far fa-send fa-xs"></span></a>'

                            . '</td>';
                        $row_table = $row_table . '</tr>';
                    }
                    if ($orcenC->cantidadItemsPorAtender() > 0) {
                        $link_crear_nota_ingreso = '<a href="/ingresoregular/' . $orcenC->id_orden_compra . '">Agregar Nota de Ingreso<i class="fas fa-edit"></i></a>';
                    } else {
                        $link_crear_nota_ingreso = '';
                    }

                    $modal = '<div id="modalIngresoNI-' . $orcenC->id_orden_compra . '" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Seguimiento de notas de ingreso</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                           <table class="table text-center table-striped table-sm">
                           <thead>
                              <tr>
                                 <th scope="col">FECHA CREACIÓN NI</th>
                                 <th scope="col">NOTA DE INGRESO</th>
                                 <th scope="col"></th>
                              </tr>
                           </thead>
                           <tbody>' .

                        $row_table .
                        '</tbody>
                     </table>
                           </div>
                           <div class="modal-footer">'
                        . $link_crear_nota_ingreso .
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                           </div>
                        </div>
                        </div>
                     </div>';

                    $mostrar = '';

                    return $button . $modal;

                } else {
                    return "<p></p>";
                }

            })
            ->addColumn('acciones', function ($orcenC) {

                if ($orcenC->estado == 'PENDIENTE' && $orcenC->sumatotal != '') {
                    if ($orcenC->tipo == "VEHICULOS SEMINUEVOS") {
                        $mostrar =
                        '<div>
                         <a href="' . route("vehiculo_seminuevo.show", ['id_orden_compra' => $orcenC->id_orden_compra]) . '" class="btn btn-warning font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Revisar" style="color:black">
                            <span class="far fa-edit fa-xs"></span>
                         </a>
                      </div>';
                    } else {
                        $mostrar =
                        '<div>
                     <a href="' . route("contabilidad.visualizarOC", ['id_orden_compra' => $orcenC->id_orden_compra]) . '" class="btn btn-warning font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Revisar" style="color:black">
                        <span class="far fa-edit fa-xs"></span>
                     </a>
                  </div>';
                    }

                } elseif ($orcenC->estado == 'APROBADO' && $orcenC->sumatotal != '') {

                    if ($orcenC->tipo == "VEHICULOS SEMINUEVOS") {
                        $mostrar =
                        '<div>
                         <a href="' . route("vehiculo_seminuevo.show", ['id_orden_compra' => $orcenC->id_orden_compra]) . '" class="btn btn-warning font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Revisar" style="color:black">
                            <span class="far fa-edit fa-xs"></span>
                         </a>
                      </div>';
                    } else {
                        $mostrar =
                        '<div>
                     <a href="' . route("contabilidad.visualizarOC", ['id_orden_compra' => $orcenC->id_orden_compra]) . '" class="btn btn-warning font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Revisar" style="color:black">
                        <span class="far fa-edit fa-xs"></span>
                     </a>
                  </div>';
                    }

                    return $mostrar;

                } elseif ($orcenC->estado == 'RECHAZADO' && $orcenC->sumatotal != '') {
                    $mostrar =
                    '<div>
                     <a href="' . route("contabilidad.actualizarOC", ['id_orden_compra' => $orcenC->id_orden_compra]) . '" class="btn btn-warning font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Revisar" style="color:black">
                        <span class="far fa-edit fa-xs"></span>
                     </a>
                  </div>';
                } else {
                    $mostrar =
                        '<div>
                  <button type="button" class="btn btn-danger tooltip_up font-weight-bold mr-1" data-toggle="tooltip" data-placement="right" title="Revisar" style="color:black">
                     <span class="fas fa-times fa-xs"></span>
                  </button>
               </div>';
                }
                return $mostrar;

            })
            ->addIndexColumn()
            ->rawColumns(['acciones', 'acciones2'])
            ->make(true);
    }

    public function index()
    {

        $sucursal = DB::table('orden_compra')
            ->join('parametros', 'parametros.id', '=', 'orden_compra.id_almacen')
            ->select('orden_compra.*', 'parametros.valor1 as sucursal', 'parametros.id as id_parametro')
            ->pluck('sucursal', 'id_parametro')
            ->toArray();

        // OBTENER TODOS LOS ALMACENES
        $almacenes = DB::table('parametros')
            ->join('orden_compra', 'orden_compra.id_almacen', '=', 'parametros.id')
            ->where([
                ['parametros.valor2', 'ALMACEN'],
                ['parametros.estado', '1'],
            ])
            ->pluck('valor1', 'id')
            ->toArray();

        $estados = DB::table('parametros')
            ->join('orden_compra', 'orden_compra.id_estado', '=', 'parametros.id')
            ->where([
                ['parametros.valor2', 'ESTADO'],
                ['parametros.estado', '1'],
            ])
            ->pluck('valor1', 'id')
            ->toArray();

        $empresa = DB::table('local_empresa')
            ->where('habilitado', 1)
            ->groupBy('nombre_empresa')
            ->pluck('nombre_empresa', 'id_local')
            ->toArray();
        // ->first();

        return view('contabilidadv2.mostraroc', compact('sucursal', 'almacenes', 'empresa', 'estados'));

    }

//
}
