<?php

namespace App\Http\Controllers\Mecanica;

use Illuminate\Http\Request;
use App\Http\Controllers\HojaInspeccionController;
use App\Http\Controllers\Controller;
use App\Modelos\HojaTrabajo;
use App\Modelos\RecepcionOT;
use App\Modelos\DetalleEnProceso;
use App\Modelos\RecepcionOT_EstadoReparacion;
use App\Modelos\TecnicoReparacion;
use Carbon\Carbon;
use Auth;

class TecnicosEnProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recepciones = HojaTrabajo::all();

        if ($request->all() ==[]) {
            $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto']);
        }
        else{
             //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;
            $idTecnico = $request->tecnico;

            $recepciones_ots_pre = new RecepcionOT();

            if(isset($nroDoc) && $nroDoc){
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query) use($nroDoc) {
                    $query->where('doc_cliente','LIKE',"$nroDoc%");
                });
            }

            if(isset($placa) && $placa){
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query) use($placa) {
                    $query->where('placa_auto','LIKE',"%$placa%");
                });
            }

            if(isset($nroOT) && $nroOT){
                $recepciones_ots_pre=$recepciones_ots_pre->where((new RecepcionOT)->getKeyName(),$nroOT);
            }
        }

        $listaTecnicos = TecnicoReparacion::all();

        $recepciones_ots_pre=$recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query){
            $query->whereIn('tipo_trabajo',['PREVENTIVO','CORRECTIVO']);
        });

        $filtroTecnico = isset($idTecnico) && $idTecnico!='all' ? $idTecnico : false;
        $recepciones_ots = $recepciones_ots_pre
            ->whereHas('estadosReparacion' , function ($query){
                $query->where(function($query){
                        $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno',
                        ['espera_reparacion','espera_reparacion_hotline',
                        'paralizado','paralizado_hotline'])
                        ->orWhere('estado_reparacion.nombre_estado_reparacion_interno','LIKE',"reparacion_%");
                })->where('recepcion_ot_estado_reparacion.es_estado_actual',1);
            })->whereHas('tecnicoReparacion', function ($query) use($filtroTecnico){
                if($filtroTecnico){
                    $query->where('id_tecnico', $filtroTecnico);
                }
                else{
                    return true;
                }
            })->get();
        

        /*Aquí las operaciones que ya no puedan realizarse con Eloquent */
        // $tipo_danho_filtro = $request->tipoDanho;
        // if($tipo_danho_filtro && $tipo_danho_filtro!='all'){
        //     $recepciones_ots= $recepciones_ots->filter( function ($value,$key) use($tipo_danho_filtro){
        //         return $value->tipoDanhoTemp()==$tipo_danho_filtro;
        //     });
        // }

        $colores = ['green', 'yellow', 'red'];
        
        return view('mecanica.tecnicosEnProceso',['listaRecepciones'=>$recepciones,
                                                  'listaRecepcionesOTs'=>$recepciones_ots,
                                                  'listaTecnicos'=>$listaTecnicos,
                                                  'listaColores'=>$colores,
                                                ]);
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
        //
        $id_recepcion_ot = $request->id_recepcion_ot;
        $nombre_etapa = $request->nombre_etapa;
        $recepcion_ot = RecepcionOT::find($id_recepcion_ot);
        $detalleEnProceso = new DetalleEnProceso();

        if(!in_array($nombre_etapa,["mecanica"])){
            return redirect()->route('mecanica.tecnicos.index')->with('error','Etapa no registrada, intente nuevamente. Si el problema persiste, contacte a servicio técnico.');
        }

        $reparacion = $recepcion_ot->ultReparacion();
        $id_reparacion = $reparacion->id_reparacion;
        $estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno; //BORRABLE DESPUES DE empezarTrabajoTecnico
        $listaDetallesEnProcesoNotNull = $recepcion_ot->detallesEnProceso()->whereNotNull('es_etapa_finalizada')->orderBy('fecha_registro','desc')->get();
        $listaDetallesEnProceso = $recepcion_ot->detallesEnProceso()->orderBy('fecha_registro','desc')->get();
        $estados=[];

        if(!$listaDetallesEnProcesoNotNull->pluck('etapa_proceso')->contains($nombre_etapa)){
            //etapa por iniciar
            $reparacion->fecha_inicio_operativo = Carbon::now();
            $reparacion->save();
            $detalleEnProceso->id_reparacion = $id_reparacion;
            $detalleEnProceso->etapa_proceso = $nombre_etapa;
            $detalleEnProceso->es_etapa_finalizada = 0;
            $detalleEnProceso->save();

            // $recepcionOT->empezarTrabajoTecnico($nombre_etapa,"MEC");
            if(strpos($estado_actual,"_hotline") !== false || $estado_actual == "paralizado_hotline"){
                $recepcion_ot->cambiarEstado("reparacion_".$nombre_etapa."_hotline");
            }
            elseif(strpos($estado_actual,"_hotline") === false || $estado_actual == "paralizado"){
                $recepcion_ot->cambiarEstado("reparacion_".$nombre_etapa);
            }
        }
        elseif ($listaDetallesEnProceso->pluck('etapa_proceso')->contains($nombre_etapa) 
                && !$listaDetallesEnProceso->where('etapa_proceso',$nombre_etapa)->first()->es_etapa_finalizada) {
            //etapa ya iniciada pero no terminada
            $detalleEnProceso = $listaDetallesEnProceso->where('etapa_proceso',$nombre_etapa)->first();
            $detalleEnProceso->es_etapa_finalizada = 1;
            $detalleEnProceso->fecha_fin_etapa = Carbon::now();

            //$detalleEnProceso->save();

            // $recepcionOT->empezarTrabajoTecnico($nombre_etapa,"DYP");
            if($nombre_etapa=="mecanica" && strpos($estado_actual,"_hotline") === false){
                if($estado_actual == 'paralizado'){
                    array_push($estados, "reparacion_mecanica");
                }
                array_push($estados, "espera_control_calidad");
            }
            elseif($nombre_etapa == "mecanica" && strpos($estado_actual,"_hotline") !== false){
                if($estado_actual=='paralizado_hotline'){
                    array_push($estados, "reparacion_mecanica_hotline");
                }
                array_push($estados, "espera_control_calidad_hotline");
            }
            elseif($estado_actual == 'paralizado'){
                array_push($estados, "reparacion_".$nombre_etapa);
            }
            elseif($estado_actual == 'paralizado_hotline'){
                array_push($estados, "reparacion_".$nombre_etapa."_hotline");
            }

            session(["detalleEnProceso" => $detalleEnProceso, "recepcionOT" => $recepcion_ot, "estados" => $estados]);

            $newRequest = new Request();
            $newRequest->replace(['ignore' => true]);
            return (new HojaInspeccionController)->store($newRequest);
            //return redirect()->route('inspeccionVehiculo.index', ['id_recepcion_ot' => $recepcion_ot->id_recepcion_ot]);
        }

        return redirect()->route('mecanica.tecnicos.index')->with('success','Reparacion registrada satisfactoriamente');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
