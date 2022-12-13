<?php

namespace App\Http\Controllers\Mecanica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\CiaSeguro;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Valuacion;
use App\Modelos\PromesaValuacion;
use App\Modelos\PromesaReparacion;
use App\Modelos\Empleado;
use App\Modelos\Reparacion;
use App\Modelos\TecnicoReparacion;
use App\Modelos\Semaforo;
use App\Modelos\ReprogramacionValuacion;
use Carbon\Carbon;
use Auth;

class ReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recepciones = HojaTrabajo::all();

        $placa ="";
        $nroOT ="";
        $fechaInicioPromesa ="";
        $fechaFinPromesa="";

        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto']);
        }
        else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;
            $fechaInicioPromesa = $request->fechaInicioPromesa;
            $fechaFinPromesa= $request->fechaFinPromesa;
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

            if(isset($fechaInicioPromesa) && $fechaInicioPromesa){
                $fechaInicioFormato=Carbon::createFromFormat('!d/m/Y',$fechaInicioPromesa);
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('reparaciones.fechasPromesa' , function ($query) use($fechaInicioFormato) {
                    $query->where('fecha_promesa','>=',"$fechaInicioFormato");
                });
            }

            if(isset($fechaFinPromesa) && $fechaFinPromesa){
                $fechaFinFormato=Carbon::createFromFormat('!d/m/Y',$fechaFinPromesa);
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('reparaciones.fechasPromesa' , function ($query) use($fechaFinFormato) {
                    $query->where('fecha_promesa','<=',"$fechaFinFormato");
                });
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
            $query->whereIn('tipo_trabajo',['PREVENTIVO','CORRECTIVO']);
        });

        $lista_recepciones_ots = $recepciones_ots_pre
            ->whereHas('estadosReparacion' , function ($query){
                $query->where(function($query){
                        $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno',
                        ['espera_asignacion','espera_reparacion','espera_reparacion_hotline',
                        'hotline','espera_control_calidad','espera_control_calidad_hotline',
                        'paralizado','paralizado_hotline'])
                        ->orWhere('estado_reparacion.nombre_estado_reparacion_interno','LIKE',"reparacion_%");
                    })->where('recepcion_ot_estado_reparacion.es_estado_actual',1);
                })->get();

        /*Aquí las operaciones que ya no puedan realizarse con Eloquent */
        // $color_filtro = $request->filtroSemaforo;
        // if($color_filtro && $color_filtro!='all'){
        //     $lista_recepciones_ots= $lista_recepciones_ots->filter( function ($value,$key) use($color_filtro){
        //         return $value->colorSemaforo()==$color_filtro;
        //     });
        // }
        $recepciones_ots = $lista_recepciones_ots->sortBy(function ($recepcion){
            return $recepcion->getHojaTrabajo()->fecha_recepcion;
        });

        $colores = array_unique(array_column(Semaforo::all('color_css')->toArray(),'color_css'));
        $tiposOT = TipoOT::getAll('MEC');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereIn('nombre_estado_reparacion_interno',['espera_reparacion', 'reparacion_mecanica','espera_reparacion_hotline','espera_reparacion_ampliacion','espera_reparacion_ampliacion_hotline','hotline','paralizado','paralizado_hotline','espera_control_calidad','espera_control_calidad_hotline'])
                   ->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        $empleados = Empleado::orderBy('primer_apellido')->get();
        $tecnicos = TecnicoReparacion::orderBy('nombre_tecnico')->get();
        return view('mecanica.reparacion',['listaRecepciones'=>$recepciones,
                                           'listaRecepcionesOTs'=>$recepciones_ots,
                                           'listaTiposOT'=>$tiposOT,
                                           'listaMarcas'=>$marcasAuto,
                                           'listaSeguros'=>$seguros,
                                           'listaEstados'=>$estados,
                                           'listaEmpleados'=>$empleados,
                                           'listaTecnicos'=>$tecnicos,
                                           'placaFiltro'=>$placa,
                                           'otFiltro'=>$nroOT,
                                           'fechaInicioPromesaFiltro'=>$fechaInicioPromesa,
                                           'fechaFinPromesaFiltro'=>$fechaFinPromesa,
                                           'listaColores'=>$colores]);
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
        if ($request->tipoSubmit=='inicioOperativo') {
            $recepcionOT = RecepcionOT::find($request->idRecepcionOT);
            $reparacion = $recepcionOT->ultReparacion();
            // $reparacion = new Reparacion();
            // $reparacion->id_recepcion_ot=$request->idRecepcionOT;
            $reparacion->fecha_inicio_operativo=Carbon::now();
            // $reparacion->fecha_registro_fin_operativo = null;
            $reparacion->save();

            if ($request->fechaPromesaReparacion) {
                $nueva_fecha = new PromesaReparacion();
                $nueva_fecha->id_reparacion = $reparacion->id_reparacion;
                $nueva_fecha->fecha_promesa = Carbon::createFromFormat('d/m/Y H:i', "$request->fechaPromesaReparacion $request->horaPromesaReparacion");
                $nueva_fecha->save();
            }

            if ($request->empleadoMec) {
                $reparacion->id_tecnico_mecanica = $request->empleadoMec;
                $reparacion->save();
                $recepcionOT->id_tecnico_asignado = $request->empleadoMec;
                $recepcionOT->save();
            }

            //pasar a en proceso
            if($recepcionOT->esHotLine()){
                $recepcionOT->cambiarEstado('espera_reparacion_hotline');
            }
            else{
                $recepcionOT->cambiarEstado('espera_reparacion');
            }

        }
        elseif ($request->tipoSubmit=='ampliacion') {
            $recepcionOT = RecepcionOT::find($request->idRecepcionOT);
            $reparacion = $recepcionOT->ultReparacion();

            if ($request->fechaReprogramacion) {
                $nueva_fecha = new PromesaReparacion();
                $nueva_fecha->id_reparacion = $reparacion->id_reparacion;
                $nueva_fecha->fecha_promesa = Carbon::createFromFormat('d/m/Y H:i', "$request->fechaReprogramacion $request->horaReprogramacion");
                $nueva_fecha->save();
            }

            if(in_array($request->razon,["falta_repuestos",'priorizacion','rechazo_cliente',"otros"])){
                $estado_actual = $recepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno;
                if( in_array($estado_actual,["espera_reparacion","espera_control_calidad"]) 
                    || (strpos($estado_actual,"reparacion_")===0 && strpos($estado_actual,"_hotline")===false) ){
                    $recepcionOT->cambiarEstado('paralizado');
                }
                elseif( in_array($estado_actual,["espera_reparacion_hotline","espera_control_calidad_hotline"]) 
                        || (strpos($estado_actual,"reparacion_")===0 && strpos($estado_actual,"_hotline")) ){
                    $recepcionOT->cambiarEstado('paralizado_hotline');
                }
            }

        }
        elseif ($request->tipoSubmit=='terminoOperativo') {
            $recepcionOT = RecepcionOT::find($request->idRecepcionOT);
            $reparacion = $recepcionOT->ultReparacion();
            $reparacion->fecha_fin_operativo = Carbon::createFromFormat('d/m/Y',$request->fechaTerminoOperativo);
            $reparacion->fecha_registro_fin_operativo = Carbon::now();
            $reparacion->save();

            $estado_actual = $recepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno;
            //pasar a listo
            if($estado_actual=='espera_control_calidad'){
                $recepcionOT->cambiarEstado('vehiculo_listo');
            }
            elseif($estado_actual=='espera_control_calidad_hotline'){
                $recepcionOT->cambiarEstado('vehiculo_listo_hotline');
            }
        }

        return redirect()->route('mecanica.reparacion.index')->with('success','Reparacion registrada satisfactoriamente');
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
