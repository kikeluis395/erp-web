<?php

namespace App\Http\Controllers\CarroceriaPintura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\HojaTrabajo;
use App\Modelos\RecepcionOT;
use App\Modelos\DetalleEnProceso;
use App\Modelos\RecepcionOT_EstadoReparacion;
use Carbon\Carbon;
use Auth;

class TecnicosEnProcesoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recepciones = HojaTrabajo::all();

        if ($request->all() ==[]) {
            $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto','ciaSeguro']);
        }
        else{
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;

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

        $recepciones_ots_pre=$recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query){
            $query->whereIn('tipo_trabajo',['DYP']);
        });

        $recepciones_ots = $recepciones_ots_pre->whereHas('estadosReparacion' , function ($query){
            $query->where(function($query){
                $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno',['espera_reparacion','espera_reparacion_hotline','paralizado','paralizado_hotline'])
                ->orWhere('estado_reparacion.nombre_estado_reparacion_interno','LIKE',"reparacion_%");
            })
            ->where('recepcion_ot_estado_reparacion.es_estado_actual',1)
            ;
        })/*->whereHas('valuaciones', function ($query){
            $query->where('valuacion.valor_mano_obra','>',0);
        })*/->get();

        /*Aquí las operaciones que ya no puedan realizarse con Eloquent */
        $tipo_danho_filtro = $request->tipoDanho;
        if ($tipo_danho_filtro && $tipo_danho_filtro!='all') {
            $recepciones_ots= $recepciones_ots->filter( function ($value,$key) use($tipo_danho_filtro){
                return $value->tipoDanhoTemp()==$tipo_danho_filtro;
            });
        }

        $colores = ['green', 'yellow', 'red'];

        return view('tecnicosEnProceso',['listaRecepciones'=>$recepciones,
                                        'listaRecepcionesOTs'=>$recepciones_ots,
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

        if(!in_array($nombre_etapa,["mecanica","carroceria","preparacion","pintura","armado","pulido"])){
            return redirect()->route('tecnicos.index')->with('error','Etapa no registrada, intente nuevamente. Si el problema persiste, contacte a servicio técnico.');
        }

        $id_reparacion = $recepcion_ot->ultReparacion()->id_reparacion;
        $estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;

        if(!$recepcion_ot->detallesEnProceso()->whereNotNull('es_etapa_finalizada')->get()->pluck('etapa_proceso')->contains($nombre_etapa)){
            $detalleEnProceso->id_reparacion=$id_reparacion;
            $detalleEnProceso->etapa_proceso=$nombre_etapa;
            $detalleEnProceso->es_etapa_finalizada=0;
            $detalleEnProceso->save();

            if(strpos($estado_actual,"_hotline") !== false || $estado_actual == "paralizado_hotline"){
                $recepcion_ot->cambiarEstado("reparacion_".$nombre_etapa."_hotline");
            }
            elseif(strpos($estado_actual,"_hotline") === false || $estado_actual == "paralizado"){
                $recepcion_ot->cambiarEstado("reparacion_".$nombre_etapa);
            }
        }
        elseif ($recepcion_ot->detallesEnProceso()->whereNotNull('es_etapa_finalizada')->get()->pluck('etapa_proceso')->contains($nombre_etapa) 
                && !$recepcion_ot->detallesEnProceso()->whereNotNull('es_etapa_finalizada')
                    ->orderBy('fecha_registro','desc')->get()->where('etapa_proceso',$nombre_etapa)
                    ->first()->es_etapa_finalizada) {
            $detalleEnProceso = $recepcion_ot->detallesEnProceso()->get()->where('etapa_proceso',$nombre_etapa)->first();
            $detalleEnProceso->es_etapa_finalizada=1;
            $detalleEnProceso->fecha_fin_etapa=Carbon::now();

            $detalleEnProceso->save();

            if($nombre_etapa=="pulido" && strpos($estado_actual,"_hotline") === false){
                if($estado_actual=='paralizado'){
                    $recepcion_ot->cambiarEstado("reparacion_pulido");
                }
                $recepcion_ot->cambiarEstado("espera_control_calidad");
            }
            elseif($nombre_etapa=="pulido" && strpos($estado_actual,"_hotline") !== false){
                if($estado_actual=='paralizado_hotline'){
                    $recepcion_ot->cambiarEstado("reparacion_pulido_hotline");
                }
                $recepcion_ot->cambiarEstado("espera_control_calidad_hotline");
            }
            elseif($estado_actual=='paralizado'){
                $recepcion_ot->cambiarEstado("reparacion_".$nombre_etapa);
            }
            elseif($estado_actual=='paralizado_hotline'){
                $recepcion_ot->cambiarEstado("reparacion_".$nombre_etapa."_hotline");
            }
        }

        return redirect()->route('tecnicos.index')->with('success','Reparacion registrada satisfactoriamente');
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
