<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\ServicioTerceroSolicitado;
use App\Modelos\RecepcionOT;
use DB;

class SeguimientoServiciosTercerosController extends Controller
{
    public function index(Request $request)
    {
        $bindings = [];
        $queryAdd = '';

        $nroPlaca = trim($request->nroPlaca) != '' ? $request->nroPlaca : false;
        $nroDoc = trim($request->nroDoc) != '' ? $request->nroDoc : false;
        $nroOT = trim($request->nroOT) != '' ? $request->nroOT : false;
        $estado = isset($request->estado) ? $request->estado : false;
        
        if($nroPlaca) { 
            $bindings[] = $nroPlaca;
            $queryAdd .= 'WHERE D.placa_auto = ? ';
        }

        if($nroDoc) {            
            $andOrWhere = count($bindings) > 0 ? ' AND' : 'WHERE';

            $bindings[] = $nroDoc;
            $queryAdd .= "{$andOrWhere} C.num_doc = ? ";
        }

        if($nroOT) {            
            $andOrWhere = count($bindings) > 0 ? ' AND' : 'WHERE';

            $bindings[] = $nroOT;
            $queryAdd .= "{$andOrWhere} A.id_recepcion_ot = ? ";
        }

        if($estado != 'all' && $estado) {            
            $andOrWhere = count($bindings) > 0 ? ' AND' : 'WHERE';

            $bindings[] = $estado;
            $queryAdd .= "{$andOrWhere} (case when A.id_orden_servicio is null then 'sin_generar' 
            when A.id_orden_servicio is not null and B.es_aprobado is null then 'generado'
            when B.es_aprobado = 1 then 'aprobado' end) = ? ";
        }

        $solicitudServiciosTerceros = DB::select("SELECT A.*, 
                            B.es_aprobado, 
                            case when A.id_orden_servicio is null then 'sin_generar' 
                                when A.id_orden_servicio is not null and B.es_aprobado is null then 'generado'
                                when B.es_aprobado = 1 then 'aprobado' end estado,
                            C.nombre_proveedor, C.num_doc, B.moneda
                    from (select C.id_recepcion_ot, A.id_proveedor, B.id_orden_servicio, SUM(B.valor_costo) as costo_total
                        from servicio_tercero_solicitado A 
                        left JOIN linea_orden_servicio B on A.id_servicio_tercero_solicitado = B.id_servicio_tercero_solicitado 
                        inner join hoja_trabajo C on A.id_hoja_trabajo = C.id_hoja_trabajo 
                        where C.id_recepcion_ot is not null 
                        group by C.id_recepcion_ot, A.id_proveedor, B.id_orden_servicio) A 
                    left JOIN orden_servicio B on A.id_orden_servicio = B.id_orden_servicio
                    inner JOIN proveedor C on C.id_proveedor = A.id_proveedor
                    left JOIN hoja_trabajo D on A.id_recepcion_ot = D.id_recepcion_ot
                    {$queryAdd}
                    ORDER BY A.id_recepcion_ot ASC;", $bindings);
        //dd($solicitudServiciosTerceros);
        foreach ($solicitudServiciosTerceros as $solicitud){
            $solicitud->recepcion_ot = RecepcionOT::find($solicitud->id_recepcion_ot);
        }

        return view('administracion.seguimientoServiciosTerceros', ['solicitudServiciosTerceros' => $solicitudServiciosTerceros]);
    }

}
