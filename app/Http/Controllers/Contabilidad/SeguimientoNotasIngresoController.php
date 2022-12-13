<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\NotaIngreso;

class SeguimientoNotasIngresoController extends Controller
{
    public function index(Request $request){
        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $notasIngreso = NotaIngreso::whereNull('factura_asociada')->get();
        }
        else {
            $notaIngreso = $request->nroNI;
            $oc = $request->nroOC;
            $rucProveeedor = $request->rucProveedor;
            $modalidad = $request->modalidad;
            $nroFacturaAsociada = $request->nroFacturaAsociada;
            
            $notasIngreso = new NotaIngreso();
            
            if(isset($notaIngreso) && $notaIngreso){
                $notasIngreso=$notasIngreso->where('id_nota_ingreso', $notaIngreso);
            }

            if(isset($nroFacturaAsociada)){
                
                $notasIngreso=$notasIngreso->where('factura_asociada', $nroFacturaAsociada);
                
            }

            if(isset($oc) && $oc){
                $notasIngreso=$notasIngreso->whereHas('lineasNotaIngreso.lineaOrdenCompra.ordenCompra' , function ($query) use($oc) {
                    $query->where('id_orden_compra',$oc);
                });
            }

            if(isset($rucProveeedor) && $rucProveeedor){
                $notasIngreso=$notasIngreso->whereHas('lineasNotaIngreso.lineaOrdenCompra.ordenCompra.proveedor' , function ($query) use($rucProveeedor) {
                    $query->where('num_doc',$rucProveeedor);
                });
            }
            // dd($modalidad);
            // dd($notasIngreso->get());
            if(isset($modalidad) && $modalidad!="" ){
                if($modalidad == "Facturados"){
                    $notasIngreso=$notasIngreso->whereNotNull('factura_asociada');
                } else {
                    $notasIngreso=$notasIngreso->whereNull('factura_asociada');
                }
            }

            $notasIngreso = $notasIngreso->get();
        }
        
        return view('contabilidadv2.seguimientoNotasIngreso',['notasIngreso'=>$notasIngreso]);
    }
}
