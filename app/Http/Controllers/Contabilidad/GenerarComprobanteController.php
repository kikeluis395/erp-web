<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\RecepcionOT;
use App\Http\Controllers\Facturacion\FacturasController;

class GenerarComprobanteController extends Controller
{
    public function index(Request $request){
        if(session('pdf_link')){
            $pdf_link = session('pdf_link');
            echo "<script>window.open('https://$pdf_link', '_blank')</script>";
        }
        return view('contabilidadv2.generarComprobante');
    }

    public function store(Request $request){
        $tipoOperacion = $request->input('tipoOperacion');
        $id_ot = $request->input('inputOperacion');
        if($tipoOperacion === 'OC'){
            $recepcion_ot = RecepcionOT::find($id_ot);
            $estado_ultimo = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;

            $cliente = $recepcion_ot->hojaTrabajo->cliente;
            $listaItems = $recepcion_ot->generarDetallesFacturacion();
            if(is_null($request->input("incluyeDetraccion"))){
                $detraccion = false;
            } else {
                $detraccion = true;
            }
            $facturaResponse = (new FacturasController())->generarFactura($cliente, $listaItems, $detraccion);
            
            //dd($facturaResponse->url_pdf);
            //echo "<script>window.open('https://'+'$facturaResponse->url_pdf', '_blank')</script>";
            return redirect()->route('contabilidad.generarComprobante')->with('pdf_link', $facturaResponse->url_pdf);
        } else {
            return view('contabilidadv2.generarComprobante');
        }
        //dd($tipoOperacion);
        //return 0;
    }
}
