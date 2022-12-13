<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\NotaIngreso;

class VisualizarNIController extends Controller
{
    public function index(Request $request){
        $id_nota_ingreso = $request->input("id_nota_ingreso");
        $nota_ingreso = NotaIngreso::find($id_nota_ingreso);
        $lineas_nota_ingreso = $nota_ingreso->lineasNotaIngreso;
        $moneda = $nota_ingreso->obtenerOrdenCompraObjeto()->tipo_moneda;
        return view('contabilidadv2.visualizarNI',['nota_ingreso' => $nota_ingreso,
                                                    'lineas_nota_ingreso' => $lineas_nota_ingreso,
                                                    'moneda' => $moneda]);
    }

    public function ingresarFactura(Request $request){
        $nota_ingreso = NotaIngreso::find($request->id_nota_ingreso);
        $nota_ingreso->factura_asociada = $request->facturaNI;
        $nota_ingreso->save();
        return redirect()->back();

    }
}
