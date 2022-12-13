<?php

namespace App\Http\Controllers\Repuestos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\CiaSeguro;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\NecesidadRepuestos;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\Repuesto;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\TipoCambio;
use Carbon\Carbon;
use Auth;
use DB;

class RepuestosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function repuestosOT(Request $request)
    {
        $recepciones = HojaTrabajo::all();
        $fechaInicioFormato=null;
        $fechaFinFormato=null;

        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = HojaTrabajo::with(['vehiculo.marcaAuto']);
        }
        else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;
            $id_marca = $request->marca;
            $id_seguro = $request->seguro;
            $seccion = $request->seccion;
            $estado = $request->estado;
            $fechaSolicitudIni = $request->fechaInicioSolicitud;
            $fechaSolicitudFin = $request->fechaFinSolicitud;
            $filtroTipoOT = $request->filtroTipoOT;

            $recepciones_ots_pre = new HojaTrabajo();

            if(isset($nroDoc) && $nroDoc){
                $recepciones_ots_pre=$recepciones_ots_pre->where('doc_cliente','LIKE',"$nroDoc%");
            }
            
            if(isset($placa) && $placa){
                $recepciones_ots_pre=$recepciones_ots_pre->where('placa_auto','LIKE',"%$placa%");
            }

            if(isset($nroOT) && $nroOT){
                $recepciones_ots_pre=$recepciones_ots_pre->where((new RecepcionOT)->getKeyName(),$nroOT);
            }

            if ($id_marca && $id_marca!='all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('vehiculo.marcaAuto' , function ($query) use($id_marca) {
                    $query->where('id_marca_auto','=',$id_marca);
                });
            }

            if($filtroTipoOT !=null){
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('recepcionOT' , function ($query) use($filtroTipoOT) {
                    $query->whereHas('tipoOT' , function ($query2) use($filtroTipoOT) {
                        $query2->where('id_tipo_ot',$filtroTipoOT);
                    });
                });
            }

            // if ($id_seguro!='all') {
            //     $recepciones_ots_pre=$recepciones_ots_pre->where('id_cia_seguro',$id_seguro);
            // }

            if(isset($seccion) && $seccion!='all'){
                if($seccion == 'DYP'){
                    $recepciones_ots_pre=$recepciones_ots_pre->where('tipo_trabajo',"DYP");
                }
                elseif($seccion == 'MEC'){
                    $recepciones_ots_pre=$recepciones_ots_pre->where('tipo_trabajo', '!=',"DYP");
                }
            }

            if($fechaSolicitudIni){
                $fechaInicioFormato=Carbon::createFromFormat('!d/m/Y',$fechaSolicitudIni);
            }
            if($fechaSolicitudFin){
                $fechaFinFormato=Carbon::createFromFormat('!d/m/Y',$fechaSolicitudFin)->addDay();
            }
        }

        // REMOVIDO EL 03/01
        // $recepciones_ots = $recepciones_ots_pre->whereHas('recepcionOT')->where(function($query){
        //     $query->whereHas('necesidadesRepuestos.itemsNecesidadRepuestos' , function ($query){
        //         $query->where('entregado',0)->orWhereNull('entregado');
        //     })/*->orWhereHas('necesidadesRepuestos', function ($query){
        //         $query->doesntHave('itemsNecesidadRepuestos');
        //     })*/;
        // })->get();

        $recepciones_ots=$recepciones_ots_pre->whereHas('recepcionOT')->whereHas('recepcionOT.estadosReparacion' , function ($query){
            // $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno',['espera_traslado','espera_valuacion','espera_aprobacion','entregado','entregado_pt','vehiculo_listo','vehiculo_listo_hotline'])
            // ->where('recepcion_ot_estado_reparacion.es_estado_actual',1);

            $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno',['espera_traslado','espera_valuacion','espera_aprobacion','entregado','entregado_pt','liquidado','liquidado_hotline'])
            ->where('recepcion_ot_estado_reparacion.es_estado_actual',1);
        })->whereHas('necesidadesRepuestos.itemsNecesidadRepuestos')->orderBy('id_recepcion_ot', 'asc')->get();

        $filtroEstado = isset($estado) ? $estado : false;
        switch ($filtroEstado) {
            case 'entregado':
                $filtroEstado = 'ENTREGADO';
                break;
            case 'en-solicitud':
                $filtroEstado = 'EN SOLICITUD';
                break;   
            case 'sin-atender':
                $filtroEstado = 'SIN ATENDER';
                break;         
            default:
                $filtroEstado = false;
                break;
        }
        if($filtroEstado || $fechaInicioFormato || $fechaFinFormato){
            $recepciones_ots = $recepciones_ots->filter(function ($value, $key) use($filtroEstado, $fechaInicioFormato, $fechaFinFormato){
                $necesidadRepuestos = $value->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();

                $mayorInicio = $fechaInicioFormato ? Carbon::parse($necesidadRepuestos->fecha_registro) >= $fechaInicioFormato : true;
                $menorFin = $fechaFinFormato ? Carbon::parse($necesidadRepuestos->fecha_registro) <= $fechaFinFormato : true;
                $igualEstado = $filtroEstado ? $necesidadRepuestos->getEstadoNecesidad() == $filtroEstado : true;

                return $mayorInicio && $menorFin && $igualEstado;
            });
        }

        $tiposOT = TipoOT::getAll('ALL');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno',['entregado','entregado_pt'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        return view('repuestos.solicitudesRepuestos',['listaRecepciones'=>$recepciones,
                                                      'listaRecepcionesOTs'=>$recepciones_ots,
                                                      'listaTiposOT'=>$tiposOT,
                                                      'listaMarcas'=>$marcasAuto,
                                                      'listaSeguros'=>$seguros,
                                                      'listaEstados'=>$estados]);
    }

    public function repuestosCot(Request $request)
    {
        $recepciones = HojaTrabajo::all();

        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = HojaTrabajo::with(['vehiculo.marcaAuto']);
        }
        else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroCotizacion = $request->nroCotizacion;
            $id_marca = $request->marca;
            $id_seguro = $request->seguro;
            $seccion = $request->seccion;
           
            $estado = $request->estado;
            $fechaInicioSolicitud = isset($request->fechaInicioSolicitud) ? Carbon::createFromFormat('d/m/Y', $request->fechaInicioSolicitud)->format('Y-m-d 00:00:00') : false;
            $fechaFinSolicitud = isset($request->fechaFinSolicitud) ? Carbon::createFromFormat('d/m/Y', $request->fechaFinSolicitud)->format('Y-m-d 23:59:59') : false;

            $recepciones_ots_pre = new HojaTrabajo();

            if(isset($nroDoc) && $nroDoc){
                $recepciones_ots_pre=$recepciones_ots_pre->where('doc_cliente','LIKE',"$nroDoc%");
            }
            
            if(isset($placa) && $placa){
                $recepciones_ots_pre=$recepciones_ots_pre->where('placa_auto','LIKE',"%$placa%");
            }

            if(isset($nroCotizacion) && $nroCotizacion){
                $recepciones_ots_pre=$recepciones_ots_pre->where('id_cotizacion',$nroCotizacion);
            }

            if(isset($nroCotizacion) && $nroCotizacion){
                $recepciones_ots_pre=$recepciones_ots_pre->where('id_cotizacion',$nroCotizacion);
            }

            
            if($fechaInicioSolicitud!= null){
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('necesidadesRepuestos' , function ($query) use($fechaInicioSolicitud) {
                    $query->where('fecha_registro','>=',$fechaInicioSolicitud);
                });
            }

            if($fechaFinSolicitud!= null){
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('necesidadesRepuestos' , function ($query) use($fechaFinSolicitud) {
                    $query->where('fecha_registro','<=',$fechaFinSolicitud);
                });
            }
            

            if (isset($seccion) && $seccion) {
                if ($seccion == 'DYP') {
                    $recepciones_ots_pre = $recepciones_ots_pre->where('tipo_trabajo', '=', 'DYP');
                } else {
                    $recepciones_ots_pre = $recepciones_ots_pre->where('tipo_trabajo', '!=', 'DYP');
                }
            }

            if ($id_marca && $id_marca!='all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('vehiculo.marcaAuto' , function ($query) use($id_marca) {
                    $query->where('id_marca_auto','=',$id_marca);
                });
            }
            
        }

        
      

        $recepciones_ots=$recepciones_ots_pre->whereHas('cotizacion' , function ($query){
            $query->where('es_habilitado',1);
        })->whereHas('necesidadesRepuestos', function ($query){
            $query->where('es_finalizado',0)->has('itemsNecesidadRepuestos');
        })->get();


        if(isset($estado) && $estado != null){
            
            $recepciones_ots = $recepciones_ots->filter(function ($value, $key) use($estado){
                
                $igualEstado = $value->necesidadesRepuestos()->first()->estadoParaUnaCotizacion() == $estado;
                return $igualEstado;
            });
        }


        $tiposOT = TipoOT::getAll('ALL');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno',['entregado','entregado_pt'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        return view('repuestos.solicitudesRepuestosCotizacion',['listaRecepciones'=>$recepciones,
                                                                'listaRecepcionesOTs'=>$recepciones_ots,
                                                                'listaTiposOT'=>$tiposOT,
                                                                'listaMarcas'=>$marcasAuto,
                                                                'listaSeguros'=>$seguros,
                                                                'listaEstados'=>$estados]);
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
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = HojaTrabajo::with(['vehiculo.marcaAuto']);
        }
        else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroOT = $request->nroOT;
            $id_marca = $request->marca;
            $id_seguro = $request->seguro;

            $recepciones_ots_pre = new RecepcionOT();
            
            if(isset($placa)){
                $recepciones_ots_pre=$recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query) use($placa) {
                    $query->where('placa_auto','LIKE',"%$placa%");
                });
            }

            if(isset($nroOT)){
                $recepciones_ots_pre=$recepciones_ots_pre->where((new RecepcionOT)->getKeyName(),$nroOT);
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

        $recepciones_ots = $recepciones_ots_pre->where(function($query){
            $query->whereHas('necesidadesRepuestos.itemsNecesidadRepuestos' , function ($query){
                $query->where('entregado',0)->orWhereNull('entregado');
            })/*->orWhereHas('necesidadesRepuestos', function ($query){
                $query->doesntHave('itemsNecesidadRepuestos');
            })*/;
        })->get();

        // DESCOMENTAR
        // $recepciones_ots=$recepciones_ots->whereHas('estadosReparacion' , function ($query){
        //     $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno',['entregado','entregado_pt'])
        //     ->where('recepcion_ot_estado_reparacion.es_estado_actual',1);
        // })->get();

        $tiposOT = TipoOT::getAll('ALL');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno',['entregado','entregado_pt'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        return view('repuestos.solicitudesRepuestos',['listaRecepciones'=>$recepciones,
                                                      'listaRecepcionesOTs'=>$recepciones_ots,
                                                      'listaTiposOT'=>$tiposOT,
                                                      'listaMarcas'=>$marcasAuto,
                                                      'listaSeguros'=>$seguros,
                                                      'listaEstados'=>$estados]);
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
        $hojaTrabajo = HojaTrabajo::find($request->idHojaTrabajo);
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro','desc')->first();
        if(!$necesidadRepuestos){
            $necesidadRepuestos = new NecesidadRepuestos();
            $necesidadRepuestos->setIdHojaTrabajo($hojaTrabajo->id_hoja_trabajo);
            $necesidadRepuestos->save();
        }
        if($necesidadRepuestos->es_finalizado){
            $necesidadRepuestos->es_finalizado = 0;
            $necesidadRepuestos->save();
        }

        $requests = $request->all();
        foreach ($requests as $key => $value) {
            $pos_input=strpos($key,"descripcionLineaSolRepuesto-");
            if($pos_input!==false && $pos_input>=0){
                $numRequest = substr($key,$pos_input + strlen('descripcionLineaSolRepuesto-'));
                $itemNecesidad = new ItemNecesidadRepuestos();
                $itemNecesidad->descripcion_item_necesidad_repuestos = $request->input($key);
                $itemNecesidad->cantidad_solicitada = $request->input("cantidadLineaSolRepuesto-" . $numRequest);
                $itemNecesidad->id_necesidad_repuestos = $necesidadRepuestos->id_necesidad_repuestos;
                $itemNecesidad->fecha_registro = Carbon::now();
                $itemNecesidad->save();
            }
        }

        return redirect()->back();
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

    public function buscarRepuestoID($id)
    {
        //return Repuesto::where((new Repuesto)->getKeyName(),$id)->first();
        $repuesto = Repuesto::where('codigo_repuesto',$id)->first();
        if($repuesto){
            $repuesto->stockLocales = $repuesto->getResumenStockLocales();
            $repuesto->moneda = $repuesto->getPrecio(Carbon::now()) ? $repuesto->getPrecio(Carbon::now())->moneda : '-';
            $repuesto->pvp = number_format($repuesto->getPrecioUnitario(Carbon::now()),2, '.', '');
            $repuesto->pvpGrupo = $repuesto->pvp*$repuesto->getCantidadUnidadesGrupo();
            $repuesto->nombreUnidadGrupo = $repuesto->getNombreUnidadGrupo();
            $repuesto->nombreUnidadMinima = $repuesto->getNombreUnidadMinima();
            $repuesto->abreviaUnidadGrupo = $repuesto->getAbreviaUnidadGrupo();
            $repuesto->abreviaUnidadMinima = $repuesto->getAbreviaUnidadMinima();
            $repuesto->tipoCambioSistema = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
            $repuesto->pvp_mayoreo = number_format($repuesto->getPrecioMayoreo(Carbon::now()),2, '.', '');
            $repuesto->modelos_tecnicos = $repuesto->repuestoAplicaModeloTecnico;
            $repuesto->aplicacion_ventas = $repuesto->aplicacion_ventas === 1;
        }
        return $repuesto;
    }

    public function getMovimientos(Request $request)
    {
        if(!$request->has('nroRepuesto') && !$request->has('fechaInicioMovimiento')) return collect([]);
        $repuestos = MovimientoRepuesto::getMovimientosBaseQuery()->where('le.id_local', Auth::user()->empleado->id_local)
                    ->whereIn('tipo_movimiento',['INGRESO','EGRESO'])
                    ->orderBy('codigo_repuesto')
                    ->orderBy('nombre_local')
                    ->orderBy('fecha_movimiento');

        if($request->nroRepuesto){
            $repuestos = $repuestos->where('r.codigo_repuesto', 'LIKE', "%$request->nroRepuesto%");
        }

        if($request->descripcion){
            $repuestos = $repuestos->where('r.descripcion', 'LIKE', "%$request->descripcion%");
        }

        if($request->fechaInicioMovimiento){
            $fechaIni = Carbon::createFromFormat('!d/m/Y', $request->fechaInicioMovimiento);
            $repuestos = $repuestos->where('mr.fecha_movimiento', '>=', $fechaIni);
        }

        $repuestos = $repuestos->get();
        return $repuestos;
    }

    public function movimientosIndex(Request $request)
    {
        $movimientos = $this->getMovimientos($request);

        return view('repuestos.repuestosMovimientos', ['listaRepuestos' => $movimientos]);
    }
    
    public function consultarStockLocal(Request $request)
    {
        $idLocal = $request->idLocal;
        $codigoRepuesto = $request->codigoRepuesto;
        $repuesto = Repuesto::where('codigo_repuesto', $codigoRepuesto)->first();

        if($repuesto){
            $stockVirtual = $repuesto->getStockVirtual($idLocal);
            $stockFisico = $repuesto->getStock($idLocal);

            if($stockVirtual > 0){
                return ['stockVirtual' => $stockVirtual,'stockFisico' => $stockFisico];
            }

            $saldos = $repuesto->getResumenStockLocales();

            $responseArray = [];
            foreach($saldos as $stockRepuestoLocal){
                if($stockRepuestoLocal->id_local == $idLocal) continue;
                $lineResponse = ['local'=>$stockRepuestoLocal->nombre_local,'saldo_fisico'=>$stockRepuestoLocal->saldo,'saldo_virtual'=>$stockRepuestoLocal->saldo_virtual];
                array_push($responseArray,$lineResponse);
            }

            return ['stockVirtual' => 0,'stockFisico' => $stockFisico, 'disponibilidadLocales'=>$responseArray];
        }

        return null;
    }
}
