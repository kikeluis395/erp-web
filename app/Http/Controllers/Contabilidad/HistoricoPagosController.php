<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\FacturaCompra;

class HistoricoPagosController extends Controller
{
    public function index(Request $request){
        $facturas = FacturaCompra::whereNotNull('id_movimiento_bancario')->orderBy('fecha_vencimiento', 'ASC')->get();
        return view('contabilidadv2.historicoPagos',['facturas' => $facturas]);
        /* return view('contabilidadv2.historicoPagos',['facturas' => $facturas,
                                                      'arregloBancos' => $arregloBancos,
                                                      'cuentas' => []]); */
    }
}
