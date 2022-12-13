<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\ServicioTerceroSolicitado;
use App\Modelos\Proveedor;
use App\Modelos\RecepcionOT;
use App\Modelos\OrdenServicio;
use App\Modelos\LineaOrdenServicio;
use Auth;
use Carbon\Carbon;
use DB;

class VisualizarServicioTerceroController extends Controller
{
    public function index(Request $request)
    {
        $id_proveedor = $request->id_proveedor;
        $id_recepcion_ot = $request->id_recepcion_ot;
        $estado = $request->estado;
        $orden_servicio = OrdenServicio::find($request->id_orden_servicio);
        
        $hojaTrabajo = RecepcionOT::find($id_recepcion_ot)->getHojaTrabajo();
        $id_hoja_trabajo = $hojaTrabajo->id_hoja_trabajo;
        $placa = $hojaTrabajo->placa_auto;
        
        $proveedor = Proveedor::where('id_proveedor',$id_proveedor)->first();
        if(is_null($orden_servicio)){
            //Primer caso, cuando no se ha generado la OS
            $serviciosTerceros = ServicioTerceroSolicitado::doesntHave('lineaOrdenServicio')->where('id_hoja_trabajo', $id_hoja_trabajo)->where('id_proveedor', $id_proveedor)->get();
            return view('administracion.visualizarServicioTercero', ['serviciosTerceros' => $serviciosTerceros,
                                                                    'id_hoja_trabajo' => $id_hoja_trabajo,
                                                                    'proveedor' => $proveedor,
                                                                    'estado' => $estado,
                                                                    'id_recepcion_ot' => $id_recepcion_ot,
                                                                    'placa' => $placa]);
        } else {
            //Para el segundo y tercer caso
            $query = DB::table('servicio_tercero_solicitado as st')->
                                        join('linea_orden_servicio as los','st.id_servicio_tercero_solicitado','los.id_servicio_tercero_solicitado')->
                                        join('orden_servicio as os','los.id_orden_servicio','os.id_orden_servicio')->
                                        where('st.id_hoja_trabajo', $id_hoja_trabajo)->
                                        where('st.id_proveedor', $id_proveedor)->
                                        where('os.id_orden_servicio', $orden_servicio->id_orden_servicio);
            if($estado == "generado"){
                //Segundo caso, cuando se ha generado la OS pero no se ha aprobado
                $serviciosTerceros = $query->whereNull('es_aprobado')->get();    
            } elseif($estado == "aprobado"){
                //Tercer caso, cuando ya se aprobó la OS
                $serviciosTerceros = $query->whereNotNull('es_aprobado')->get();
            }
            //A base de los servicios terceros solicitados encontrados, obtenemos sus respectivas lineas de órden de servicio
            $arregloIdsLineasOrdenesServicio = [];
            foreach($serviciosTerceros as $servicioTercero){
                array_push($arregloIdsLineasOrdenesServicio, $servicioTercero->id_servicio_tercero_solicitado);
            }
            $lineasOrdenesServicio = LineaOrdenServicio::whereIn('id_servicio_tercero_solicitado',$arregloIdsLineasOrdenesServicio)->get();
            return view('administracion.visualizarServicioTercero', ['lineasOrdenesServicio' => $lineasOrdenesServicio,
                                                                    'id_hoja_trabajo' => $id_hoja_trabajo,
                                                                    'estado' => $estado,
                                                                    'orden_servicio' => $orden_servicio,
                                                                    'proveedor' => $proveedor,
                                                                    'id_recepcion_ot' => $id_recepcion_ot,
                                                                    'placa' => $placa]);
        }
        //dd($orden_servicio);
        
        //dd($serviciosTerceros);
        
    }

    public function store(Request $request){
        
        if($request->estado == "sin_generar"){
            //dd($request->all());
            $requests = $request->all();
            $orden_servicio = new OrdenServicio();
            $orden_servicio->id_usuario_registro = Auth::user()->id_usuario;
            $orden_servicio->condicion_pago = $request->condicionPago;
            $orden_servicio->moneda = $request->moneda;
            $orden_servicio->observaciones = $request->observaciones;
            $orden_servicio->save();

            foreach ($requests as $key => $value) {
                $pos_input=strpos($key,"servicioTerceroSolicitado-");
                if($pos_input!==false && $pos_input>=0){
                    $numRequest=substr($key,$pos_input + strlen('servicioTerceroSolicitado-'));
                    $lineaOrdenServicio=new LineaOrdenServicio();
                    $lineaOrdenServicio->id_orden_servicio = $orden_servicio->id_orden_servicio;
                    $lineaOrdenServicio->id_servicio_tercero_solicitado = $request->input("servicioTerceroSolicitado-".$numRequest);
                    $lineaOrdenServicio->valor_costo = $request->input("costo-".$numRequest); 
                    $lineaOrdenServicio->save();
                }
            }

            
        } elseif($request->estado == "generado"){
            $orden_servicio = OrdenServicio::find($request->idOrdenServicio);
            $orden_servicio->es_aprobado = 1;
            $orden_servicio->id_usuario_respuesta = Auth::user()->id_usuario;
            $orden_servicio->fecha_respuesta = Carbon::now();
            $orden_servicio->save();
        }

        return redirect()->route('seguimientoServiciosTerceros');
    }

    public function ingresarFactura(Request $request){
        $orden_servicio = OrdenServicio::find($request->id_orden_servicio);
        $orden_servicio->factura_asociada = $request->facturaOS;
        $orden_servicio->save();
        return redirect()->back();
    }
}
