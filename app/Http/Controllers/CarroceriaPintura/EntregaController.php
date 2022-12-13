<?php

namespace App\Http\Controllers\CarroceriaPintura;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\CiaSeguro;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Valuacion;
use App\Modelos\PromesaValuacion;
use App\Modelos\EntregadoReparacion;
use App\Modelos\CotizacionMeson;
use App\Modelos\TipoCambio;
use App\Helper\Helper;
use Carbon\Carbon;
use Auth;
use Mail;

class EntregaController extends Controller
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

            if ($id_estado && $id_estado!='all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion' , function ($query) use($id_estado) {
                    //URGENTE: esta solucion solo debe ser temporal, no se debe usar el nombre absoluto de la tabla
                    $query->where('estado_reparacion.nombre_estado_reparacion_filtro','=',$id_estado)
                    ->where('recepcion_ot_estado_reparacion.es_estado_actual',1);
                });
            }

            if ($id_marca && $id_marca!='all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.vehiculo.marcaAuto' , function ($query) use($id_marca) {
                    $query->where('id_marca_auto','=',$id_marca);
                });
            }

            if ($id_seguro && $id_seguro!='all') {
                $recepciones_ots_pre=$recepciones_ots_pre->where('id_cia_seguro',$id_seguro);
            }
        }
        
        $recepciones_ots = $recepciones_ots_pre->whereHas('estadosReparacion' , function ($query){
                    $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno',['liquidado','liquidado_hotline'/*,'perdida_total'*/])
                    ->where('recepcion_ot_estado_reparacion.es_estado_actual',1)
                    ->orderBy('estado_reparacion.nombre_estado_reparacion');
                })->get();
        //$moneda=session('moneda');
        $recepciones_ots = $recepciones_ots->sortBy(function ($recepcion){
            return $recepcion->getHojaTrabajo()->fecha_recepcion;
        });
        $tasaIGV=config('app.tasa_igv');
        
        foreach ($recepciones_ots as $recepcion){
            $hojaTrabajo = $recepcion->getHojaTrabajo();
            $moneda = $hojaTrabajo->moneda;
            $monedaCalculo = Helper::obtenerUnidadMonedaCalculo($moneda);
            $precioHoja = 0;
            foreach($hojaTrabajo->detallesTrabajo as $detalleTrabajo){
                $precioHoja += $detalleTrabajo->getPrecioVentaFinal($monedaCalculo);
            }
            foreach($hojaTrabajo->necesidadesRepuestos as $necesidadRepuesto){
                foreach($necesidadRepuesto->itemsNecesidadRepuestos as $itemNecesidadRepuesto){
                    if($itemNecesidadRepuesto->id_repuesto) //solo se suman los codificados
                        $precioHoja += $itemNecesidadRepuesto->getMontoVentaTotal($itemNecesidadRepuesto->getFechaRegistroCarbon(),true);
                }
            }
            foreach($hojaTrabajo->serviciosTerceros as $servicioTercero){
                $precioHoja += $servicioTercero->getPrecioVenta($monedaCalculo);
            }
            $recepcion->precioVenta = number_format($precioHoja,2);
            $recepcion->valorVenta = number_format($precioHoja/(1+$tasaIGV),2);
        }

        $ventasMeson = CotizacionMeson::whereHas('ventasMeson', function ($query){
            $query->whereNull('fecha_venta')->whereNull('nro_factura');
        })->whereDoesntHave('lineasCotizacionMeson', function ($query){
            $query->where('es_atendido',0)->orWhereNull('es_atendido');
        })->orderBy('fecha_registro')->get();

        $recepciones_ots = $recepciones_ots->concat($ventasMeson);

        $tiposOT = TipoOT::getAll('ALL');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno',['entregado','entregado_pt'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        return view('entrega',['listaRecepciones'=>$recepciones,
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
        $recepcion_ot = RecepcionOT::find($request->id_recepcion_ot);
        $estado_ultimo = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;
        // if (!$request->id_valuacion) {
        //     $recepcion_ot->cambiarEstado('entregado');
        // }

        if(in_array($estado_ultimo,['liquidado','perdida_total','liquidado_hotline'])){
            //REGISTRAR LA ENTREGA EN LA TABLA ENTREGADO_REPARACION (FALTA)
            $entregado = new EntregadoReparacion();
            if($request->fechaEntrega)
                $entregado->fecha_entrega = Carbon::createFromFormat('d/m/Y',$request->fechaEntrega);
            $entregado->id_recepcion_ot = $recepcion_ot->id_recepcion_ot;
            $entregado->nro_factura = $request->nroFactura;
            $entregado->save();
            
            if ($estado_ultimo=='liquidado') {
                $recepcion_ot->cambiarEstado('entregado');
            }
            elseif($estado_ultimo=='perdida_total'){
                $recepcion_ot->cambiarEstado('entregado_pt');
            }
            elseif($estado_ultimo=='liquidado_hotline'){
                $recepcion_ot->cambiarEstado('entregado_hotline');
            }
            $hojaTrabajo = $recepcion_ot->hojaTrabajo;
            if(is_null($hojaTrabajo->tipo_cambio)){
                $hojaTrabajo->tipo_cambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
                $hojaTrabajo->save();
            }

            //DEFINIR SI CUANDO SE EDITA LA VALUACION SE VUELVE AL ESTADO DE VALUACION O SE QUEDA EN EL ESTADO QUE ESTABA
            return route('hojaNotaEntrega', ['id_recepcion_ot'=> $recepcion_ot->id_recepcion_ot,
                                             'id_entregado_reparacion' => $entregado->id_entregado_reparacion]);
        }
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
