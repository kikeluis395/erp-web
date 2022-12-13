<?php

namespace App\Http\Controllers\CarroceriaPintura;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Cotizacion;
use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\CiaSeguro;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Valuacion;
use App\Modelos\PromesaReparacion;
use App\Modelos\Semaforo;
use App\Modelos\ReprogramacionValuacion;
use Carbon\Carbon;
use Auth;
use Mail;


class ValuacionController extends Controller
{
    public static $lista_estancia = ["<15","15-30","30-60","60-90",">90"];

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
        $lista_estancia = self::$lista_estancia;
        $recepciones = HojaTrabajo::all();

        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto','ciaSeguro']);
        }
        else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;
            $id_estado = $request->estado;
            $id_marca = $request->marca;
            $id_seguro = $request->seguro;

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

            if ($id_estado!='all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion' , function ($query) use($id_estado) {
                    //URGENTE: esta solucion solo debe ser temporal, no se debe usar el nombre absoluto de la tabla
                    $query->where('estado_reparacion.nombre_estado_reparacion_filtro','=',$id_estado)
                    ->where('recepcion_ot_estado_reparacion.es_estado_actual',1);
                });
            }

            if ($id_marca!='all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.vehiculo.marcaAuto' , function ($query) use($id_marca) {
                    $query->where('id_marca_auto','=',$id_marca);
                });
            }

            if ($id_seguro!='all') {
                $recepciones_ots_pre=$recepciones_ots_pre->where('id_cia_seguro',$id_seguro);
            }
        }

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query){
            $query->where('tipo_trabajo','DYP');
        });
        
        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion' , function ($query)  {
            //URGENTE: esta solucion solo debe ser temporal, no se debe usar el nombre absoluto de la tabla
            $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno',['espera_valuacion','espera_aprobacion_seguro','espera_aprobacion','rechazado','espera_valuacion_ampliacion','espera_aprobacion_seguro_ampliacion','espera_aprobacion_ampliacion'])
            ->where('recepcion_ot_estado_reparacion.es_estado_actual',1)
            ;
        });

        $lista_recepciones_ots = $recepciones_ots_pre->get();

        /*Aquí las operaciones que ya no puedan realizarse con Eloquent */
        $color_filtro = $request->filtroSemaforo;
        if($color_filtro && $color_filtro!='all'){
            $lista_recepciones_ots= $lista_recepciones_ots->filter( function ($value,$key) use($color_filtro){
                return $value->colorSemaforo()==$color_filtro;
            });
        }

        $filtro_estancia = $request->filtroEstancia;
        if($filtro_estancia && $filtro_estancia!='all'){
            if(is_numeric($filtro_estancia) && $filtro_estancia>0 && $filtro_estancia < sizeof($lista_estancia) ){
                $rango_estancia = $lista_estancia[$filtro_estancia];
                $lista_recepciones_ots= $lista_recepciones_ots->filter( function ($value,$key) use($rango_estancia){
                    return $value->perteneceTiempoEstancia($rango_estancia);
                });
            }
        }
        
        $recepciones_ots = $lista_recepciones_ots->sortBy(function ($recepcion){
            return $recepcion->getHojaTrabajo()->fecha_registro;
        });

        $colores = array_unique(array_column(Semaforo::all('color_css')->toArray(),'color_css'));
        $tiposOT = TipoOT::getAll('DYP');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereIn('nombre_estado_reparacion_interno',['espera_valuacion','espera_aprobacion','espera_aprobacion_seguro','rechazado','espera_valuacion_ampliacion'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        return view('valuacion',['listaRecepciones'=>$recepciones,
                                 'listaRecepcionesOTs'=>$recepciones_ots,
                                 'listaTiposOT'=>$tiposOT,
                                 'listaMarcas'=>$marcasAuto,
                                 'listaSeguros'=>$seguros,
                                 'listaEstados'=>$estados,
                                 'listaColores'=>$colores,
                                 'listaEstancia'=>$lista_estancia]);
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
        $recepcion_ot = RecepcionOT::find($request->id_recepcion_ot);
        $valuacion = $recepcion_ot->ultValuacion();        

        if (!$valuacion){
            $first_time=true;
            $valuacion = new Valuacion();
            $es_ampliacion = false;
        }
        else{
            $first_time=false;
            $es_ampliacion = $recepcion_ot->esAmpliacion();
        }

        if(!$es_ampliacion){
            $valuacion->es_perdida_total = ($request->esPerdida=="on" ? 1:0);
    
            if($request->fechaValuacion){
                $valuacion->fecha_valuacion = Carbon::createFromFormat('d/m/Y',$request->fechaValuacion);
            }
    
            if ($request->fechaSeguro) {
                $valuacion->fecha_aprobacion_seguro = Carbon::createFromFormat('d/m/Y',$request->fechaSeguro);
                $valuacion->fecha_registro_aprobacion_seguro = Carbon::now();
            }
            
            if ($request->fechaCliente) {
                $valuacion->fecha_aprobacion_cliente = Carbon::createFromFormat('d/m/Y',$request->fechaCliente);
                $valuacion->fecha_registro_aprobacion_cliente = Carbon::now();
            }
            
            if(!$valuacion->id_recepcion_ot){
                $valuacion->id_recepcion_ot=$request->id_recepcion_ot;
            }
    
            $valuacion->id_usuario_valuador=Auth::user()->id_usuario;
    
            $valuacion->save();
    
            if ($first_time) {
                foreach($request->all() as $key=>$value){
                    if(strpos($key,"cotizacion-") === 0 && $value){
                        $cotizacion = Cotizacion::find($value);
                        $cotizacion->id_valuacion = $valuacion->id_valuacion;
                        $cotizacion->save();
                    }
                }
                //primera vez que se registra la valuacion
                if(!$recepcion_ot->ciaSeguro || $recepcion_ot->ciaSeguro()->first()->nombre_cia_seguro=='PARTICULAR'){
                    $recepcion_ot->cambiarEstado('espera_aprobacion');
                }
                else{
                    $recepcion_ot->cambiarEstado('espera_aprobacion_seguro');
                }
            }
    
            if($request->fechaSeguro && $valuacion->fecha_aprobacion_seguro){
                $estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;
                //el cliente ya lo aprobo
                if($estado_actual=='espera_aprobacion_seguro'){
                    $recepcion_ot->cambiarEstado('espera_aprobacion');
                }
            }
    
            if ($request->fechaCliente && $valuacion->fecha_aprobacion_cliente) {
                $estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;
                //el cliente ya lo aprobo
                if($estado_actual=='espera_aprobacion' || $estado_actual=='espera_aprobacion_seguro'){
                    $recepcion_ot->cambiarEstado('espera_asignacion');
                }
            }
    
            if($request->esRechazado=="on"){
                $recepcion_ot->cambiarEstado('rechazado');
            }
            else if($recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno=="rechazado"){
                $nombre_estado_previo_en_cargo=$recepcion_ot->ultEstadoNoEnCargo()->nombre_estado_reparacion_interno;
                if($nombre_estado_previo_en_cargo=='espera_aprobacion'){
                    $recepcion_ot->cambiarEstado('espera_aprobacion');
                }
                elseif($nombre_estado_previo_en_cargo=='espera_asignacion') {
                    $recepcion_ot->cambiarEstado('espera_asignacion');
                }
                elseif($nombre_estado_previo_en_cargo=='espera_aprobacion_ampliacion') {
                    $recepcion_ot->cambiarEstado('espera_aprobacion_ampliacion');
                }
            }
            
            if($valuacion->es_perdida_total==1){
                //se marco perdida total
                $recepcion_ot->cambiarEstado('perdida_total');
            }
        }
        else{
            $reprogramacion = $valuacion->ultReprogramacionValuacion();
            
            //COMENTADO 30-11-2020
            // $reprogramacion->valor_mano_obra_amp=$request->manoObra;
            // $reprogramacion->valor_repuestos_amp=$request->repuestos;
            // $reprogramacion->valor_terceros_amp=$request->terceros;
            // $reprogramacion->horas_mecanica_amp=$request->input("mecanica_" . $request->id_recepcion_ot);
            // $reprogramacion->horas_carroceria_amp=$request->input("carroceria_" . $request->id_recepcion_ot);
            // $reprogramacion->horas_panhos_amp=$request->input("panhos_" . $request->id_recepcion_ot);
            
            // $suma_horas = $reprogramacion->horas_mecanica_amp + $reprogramacion->horas_carroceria_amp + $reprogramacion->horas_panhos_amp;
            // if($reprogramacion->valor_mano_obra_amp>0 && $suma_horas<=0){
            //     return redirect()->route('valuacion.index')->with('error','Si ingresó una cantidad en mano de obra, debe ingresar una cantidad de horas de trabajo mayor a cero.');
            // }
            // FIN COMMENT 30-11-2020

            if ($request->fechaSeguro) {
                $reprogramacion->fecha_aprobacion_seguro_amp = Carbon::createFromFormat('d/m/Y',$request->fechaSeguro);
                $reprogramacion->fecha_registro_aprobacion_seguro_amp = Carbon::now();
            }
            
            if ($request->fechaCliente) {
                $reprogramacion->fecha_aprobacion_cliente_amp = Carbon::createFromFormat('d/m/Y',$request->fechaCliente);
                $reprogramacion->fecha_registro_aprobacion_cliente_amp = Carbon::now();
            }
            
            if(!$reprogramacion->id_valuacion){
                $reprogramacion->id_valuacion=$valuacion->id_valuacion;
            }

            $reprogramacion->save();
            
            $estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;
            if($estado_actual == 'espera_valuacion_ampliacion'){
                if(!$recepcion_ot->ciaSeguro || $recepcion_ot->ciaSeguro()->first()->nombre_cia_seguro=='PARTICULAR'){
                    $recepcion_ot->cambiarEstado('espera_aprobacion_ampliacion');
                }
                else{
                    $recepcion_ot->cambiarEstado('espera_aprobacion_seguro_ampliacion');
                }
            }

            if($request->fechaSeguro && $reprogramacion->fecha_aprobacion_seguro_amp){
                $estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;
                //el cliente ya lo aprobo
                if($estado_actual=='espera_aprobacion_seguro_ampliacion'){
                    $recepcion_ot->cambiarEstado('espera_aprobacion_ampliacion');
                }
            }

            if ($request->fechaCliente && $reprogramacion->fecha_aprobacion_cliente_amp) {
                //$estado_actual = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;
                //el cliente ya lo aprobo
                //se salta la espera de reparacion y pasa a EN PROCESO(AMPLIACION)
                //$recepcion_ot->cambiarEstado('espera_reparacion_ampliacion');
                $estado_retorno = $recepcion_ot->ultEstadoNoAmpliacion()->nombre_estado_reparacion_interno;
                $recepcion_ot->cambiarEstado($estado_retorno);
            }

        }

        if($valuacion->fecha_aprobacion_cliente){
            $cotizacionesPreAsociadas = $valuacion->cotizacionesPreAsociadas;
            if($cotizacionesPreAsociadas->count() > 0){
                session(['cotizacionesPreAsociadas'=>$cotizacionesPreAsociadas]);
                return redirect()->route('detalle_trabajos.index', ['id_cotizacion' => $cotizacionesPreAsociadas->first()])->with('asociarCotizacion', true);
            }
        }

        return redirect()->route('valuacion.index')->with('success','Valuacion registrada satisfactoriamente');
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
