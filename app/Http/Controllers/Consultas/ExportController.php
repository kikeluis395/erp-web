<?php
namespace App\Http\Controllers\Consultas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Modelos\HojaTrabajo;
use App\Modelos\Vehiculo;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use PDF;

class ExportController extends Controller
{
    public function historiaClinicaExcel(Request $request)
    {
        $placa = $request->nroPlaca;
        $nombreArchivo = "HISTORIA_CLINICA_${placa}.xlsx";
        return Excel::download(new ExportFromViewController($placa), $nombreArchivo);
    }

    public function historiaClinicaPDF(Request $request)
    {        
        $placa = $request->nroPlaca;
        $docum = $request->nroDoc;
        $vin = $request->nroVin;                

        /*if ($placa) {
            $detallesTrabajo = (new ConsultasController)->($placa);

            $datosHistoria = 
            HojaTrabajo::where('placa_auto', $placa)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
            $nombreArchivo = "HISTORIA_CLINICA_{$placa}.pdf";
        } 

        else if ($docum) {
            $detallesTrabajo = (new ConsultasController)->getHistoriaClinicaDetallesTrabajoDoc($docum);

            $datosHistoria = 
            HojaTrabajo::where('doc_cliente', $docum)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
            $placa = $datosHistoria->getPlacaAuto();
            $nombreArchivo = "HISTORIA_CLINICA_{$placa}.pdf"; 
        }
        else if ($vin) {
            $detallesTrabajo = (new ConsultasController)->getHistoriaClinicaDetalleTrabajoVin($vin);
            
            $datosHistoria =
            HojaTrabajo::whereHas('vehiculo', function($q) use ($vin){
                $q->where('vin',$vin);
            }
            )->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
            $placa = $datosHistoria->getPlacaAuto();
            $nombreArchivo = "HISTORIA_CLINICA_{$placa}.pdf"; 
        }*/

        if ($placa){
            $hojasTrabajo = (new ConsultasController)->getHistoriaClinica($placa);
            $placa=trim($placa);
            $datosHistoria = 
             HojaTrabajo::where('placa_auto', $placa)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
             $nombreArchivo = "HISTORIA_CLINICA_{$placa}.pdf";
        }

        else if ($docum){
            $hojasTrabajo = (new ConsultasController)->getHistoriaClinicaDoc($docum);

            $datosHistoria = 
             HojaTrabajo::where('doc_cliente', $docum)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
             $placa = trim($datosHistoria->getPlacaAuto());
             $nombreArchivo = "HISTORIA_CLINICA_{$placa}.pdf";
        }

        else if ($vin){  
            $varPlaca = Vehiculo::where('vin', $vin)->first()->placa;
            $hojasTrabajo = (new ConsultasController)->getHistoriaClinica($varPlaca);          
            $datosHistoria = 
            HojaTrabajo::where('placa_auto', $varPlaca)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
            $placa = trim($datosHistoria->getPlacaAuto());
            $nombreArchivo = "HISTORIA_CLINICA_{$placa}.pdf";
        }


        //dd($hojasTrabajo);
        return PDF::loadView('consultas.historiaClinicaExport', ["listaHojasTrabajo" => $hojasTrabajo,
                                                            "datosHistoria" => $datosHistoria])->download($nombreArchivo);
    }

    public function ordenesTrabajoExcel(Request $request)
    {
        $fecha = date('YmdHi');
        $nombreArchivo = "CONSULTA_OTS_$fecha.xlsx";
        $ordenesTrabajo = (new ConsultasController)->getOrdenesTrabajo($request);

        return Excel::download(new ExportOrdenesTrabajoFromViewController($ordenesTrabajo), $nombreArchivo);
    }

    public function cotizacionesExcel(Request $request)
    {
        $nombreArchivo = "CONSULTA_COTIZACIONES_".date("Y-m-d").".xlsx";
        $cotizaciones = (new ConsultasController)->getCotizaciones($request);

        return Excel::download(new ExportCotizacionesFromViewController($cotizaciones), $nombreArchivo);
    }

    public function cotizacionesMesonExcel(Request $request)
    {
        $nombreArchivo = "CONSULTA_COTIZACIONES_MESON_".date("Y-m-d").".xlsx";
        $cotizaciones = (new ConsultasController)->getConsultaMeson($request);

        return Excel::download(new ExportCotizacionesMesonFromViewController($cotizaciones), $nombreArchivo);
    }

    public function repuestosExcel(Request $request)
    {
        $nombreArchivo = "CONSULTA_REPUESTOS_".date("Y-m-d").".xlsx";
        $repuestos = (new ConsultasController)->getRepuestos($request);

        return Excel::download(new ExportRepuestosFromViewController($repuestos), $nombreArchivo);
    }
}