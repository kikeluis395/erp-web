<?php

namespace App\Http\Controllers\Repuestos;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\CiaSeguro;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\HojaTrabajo;
use App\Modelos\Valuacion;
use App\Modelos\PromesaValuacion;
use App\Modelos\NecesidadRepuestos;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\Repuesto;
use App\Modelos\MovimientoRepuesto;
use Carbon\Carbon;
use Auth;
use App\Modelos\TrackDeletedTransactions;

class DetalleRepuestosController extends Controller
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
        // $recepcionOT=RecepcionOT::with('hojaTrabajo')->where((new RecepcionOT)->getKeyName(),$request->id_recepcion_ot)->get()->all();
        $hojaTrabajo=HojaTrabajo::find($request->id_hoja_trabajo);

        if ($hojaTrabajo) {
            // $recepcionOT=$recepcionOT[0];
            // CAMBIAR: UNA HOJATRABAJO PUEDE TENER MULTIPLES SOLICITUDES DE REPUESTOS
            $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro','desc')->first();

            $listaRepuestos = $necesidadRepuestos->itemsNecesidadRepuestos()->get();

            $total = 0;
            $esFinalizable = true;
            foreach($listaRepuestos as $repuesto){
                $total += $repuesto->getMontoTotal($repuesto->getFechaRegistroCarbon(),true);
                if(is_null($repuesto->id_repuesto)){
                    $esFinalizable = false;
                }
            }

            return view('repuestos.detalleSolicitudRepuestos',['listaRepuestos'     => $listaRepuestos,
                                                               'necesidadRepuestos' => $necesidadRepuestos,
                                                               'datosRecepcion'     => $hojaTrabajo,
                                                               'total' => number_format($total,2),
                                                               'esFinalizable' => $esFinalizable]);
        }
        else{
            return redirect()->route('repuestos.index');//a este punto no deberia ingresar casi nadie
        }
    }

    public function saveDescuento() {

        DB::beginTransaction();
        foreach (request()->all() as $index => $value) {
            if ($index != '_token') {
                $nameInput = explode('-', $index);
                #$data[] = [$nameInput[1], $value];

                if (isset($value) && !is_numeric($value)) {
                    return redirect()->back()->with('errorNumero', 'Ingrese solo número, porfavor');
                }

                $descuento = isset($value) && $value > 0 ? $value : 0;

                $itemNecesidadRepuesto = ItemNecesidadRepuestos::findOrFail($nameInput[1]);
                $itemNecesidadRepuesto->descuento_unitario = $descuento;
                $itemNecesidadRepuesto->save();
            }
        }
        DB::commit();

        return redirect()->back()->with('successDescuento', 'Descuentos aplicados con éxito 👍');
        
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
        if($request->tipoSubmit && $request->tipoSubmit=="registroRepuesto"){
            $recepcionOT=RecepcionOT::find($request->id_recepcion_ot);
        
            $necesidadRepuestos = NecesidadRepuestos::find($request->id_necesidad_repuestos);
            if(!$necesidadRepuestos)
                return redirect()->route('repuestos.index');

            $hojaTrabajo = $necesidadRepuestos->hojaTrabajo;

            $itemRepuesto = new ItemNecesidadRepuestos();
            $itemRepuesto->id_necesidad_repuestos = $request->id_necesidad_repuestos;

            $repuesto = Repuesto::where('codigo_repuesto', strtoupper($request->nroParte))->first();
            $itemRepuesto->id_repuesto = $repuesto->id_repuesto;
            $itemRepuesto->margen = $repuesto->margen;
            $itemRepuesto->descripcion_item_necesidad_repuestos = $request->descripcion;
            $itemRepuesto->cantidad_solicitada = $request->cantidad;
            $itemRepuesto->cantidad_aprobada = $request->cantidad;

            if($hojaTrabajo->id_cotizacion){
                $itemRepuesto->entregado = 0;
                $itemRepuesto->save();
                return redirect()->route('detalle_repuestos.index',['id_hoja_trabajo' => $hojaTrabajo->getKey()])->with('success','Repuesto registrado satisfactoriamente');
            }

            if($request->fechaPedido){
                $itemRepuesto->fecha_pedido = Carbon::createFromFormat('d/m/Y',$request->fechaPedido);
            }
            if($request->fechaPromesa){
                $itemRepuesto->fecha_promesa = Carbon::createFromFormat('d/m/Y',$request->fechaPromesa);
            }
            $itemRepuesto->es_importado = $request->esImportacion;
            
            if($itemRepuesto->es_importado){
                $recepcionOT->convertirAHotline();
                $itemRepuesto->entregado = 0;//ESTADO PENDIENTE
            }
            else{
                $itemRepuesto->entregado = 0;//ESTADO ENTREGADO
                //$itemRepuesto->fecha_entrega=Carbon::now();
                //$itemRepuesto->fecha_registro_entrega=Carbon::now();
            }

            //$itemRepuesto->id_estado_repuesto=1;//ESTADO PENDIENTE (DEPRECATED)
            $itemRepuesto->fecha_registro = Carbon::now();
            $itemRepuesto->save();
        }

        return redirect()->route('detalle_repuestos.index',['id_hoja_trabajo' => $request->id_hoja_trabajo])->with('success','Repuesto registrado satisfactoriamente');
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
    public function update(Request $request)
    {
        $id= $request->id_item_necesidad_repuestos;
        DB::beginTransaction();
        $itemNecesidad = ItemNecesidadRepuestos::find($id);
        if(!$itemNecesidad)
            return redirect()->route('repuestos.index');

        if( !$itemNecesidad->id_repuesto && (is_null($request->nroParte) || is_null($request->cantidad)) ){
            return redirect()->back()->with('errorDatos','Ha ocurrido un error al momento de realizar la codificación, intentar nuevamente');
        }

        $necesidadRepuestos = $itemNecesidad->necesidadRepuestos;
        //En caso se realice la codificación del repuesto
        $primeraAsignacion = $itemNecesidad->id_repuesto === null ? true : false;
        if($primeraAsignacion){
            $repuesto = Repuesto::where('codigo_repuesto', strtoupper($request->nroParte) )->first();
            $itemNecesidad->id_repuesto = $repuesto->id_repuesto;
            $itemNecesidad->margen = $repuesto->margen;
            $itemNecesidad->cantidad_aprobada = $request->cantidad;
            $itemNecesidad->fecha_codificacion = Carbon::now();
            $stockDisponible = $itemNecesidad->repuesto->getStockVirtual($itemNecesidad->getIdLocal());
            if($stockDisponible < $request->cantidad){
                $itemNecesidad->es_importado = 0;
            }
        }
        else{
            $repuesto = $itemNecesidad->repuesto;
        }
        //En caso nos encontremos en solicitud de repuestos para cotización
        if ($necesidadRepuestos->hojaTrabajo && $necesidadRepuestos->hojaTrabajo->id_cotizacion){
            // En caso se trate de una cotizacion, debemos asegurarnos que empiece con entregado=0
            $itemNecesidad->entregado = 0;
            $itemNecesidad->save();
            DB::commit();
            return redirect()->route('detalle_repuestos.index',['id_hoja_trabajo' => $necesidadRepuestos->getNecesidadRepuestosIdHojaTrabajo()])->with('success','Repuesto registrado satisfactoriamente');
        }
        //En caso nos encontremos en solicitud de repuestos para OT's
        $recepcionOT = $necesidadRepuestos->hojaTrabajo->recepcionOT;
        $stockDisponible = $itemNecesidad->repuesto->getStockVirtual($itemNecesidad->getIdLocal());
        $cantidadAprobada = $itemNecesidad->getCantidadAprobada();

        if($cantidadAprobada > $stockDisponible){
            if($request->fechaPedido){
                $itemNecesidad->fecha_pedido = Carbon::createFromFormat('d/m/Y',$request->fechaPedido);
            }
            if($request->fechaPromesa){
                $itemNecesidad->fecha_promesa = Carbon::createFromFormat('d/m/Y',$request->fechaPromesa);
            }
            
            $itemNecesidad->num_pedido = $request->numPedido;
            $itemNecesidad->es_importado = $request->esImportacion;

            if($itemNecesidad->es_importado)
                $recepcionOT->convertirAHotline();

            if($primeraAsignacion && $stockDisponible > 0){
                $itemNecesidad->egresoVirtualStockDisponible($cantidadAprobada, $stockDisponible);
            }
        }
        elseif($itemNecesidad->es_importado === null && $primeraAsignacion){
            //para el caso en el que se haya registrado el repuesto como disponible aun sin entregar
            // registro del movimiento virtual (aqui POR AHORA)
            $response = MovimientoRepuesto::generarEgresoVirtual($itemNecesidad->id_repuesto, $itemNecesidad->getIdLocal(), $itemNecesidad->getCantidadAprobada(), "App\Modelos\ItemNecesidadRepuestos", $itemNecesidad->id_item_necesidad_repuestos);
            if($response) $itemNecesidad->id_movimiento_salida_virtual = $response;
        }

        $itemNecesidad->realizarEntrega($request->fechaEntregaRepuesto, $recepcionOT);

        if($recepcionOT)
            $recepcionOT->reiniciarProcesoReparacionTecnicos();

        $countEntregados = 0;
        $countItems = 0;
        foreach ($necesidadRepuestos->itemsNecesidadRepuestos as $itemNecesidadRepuesto){
            if($itemNecesidadRepuesto->entregado){
                $countEntregados++;
            }
            $countItems++;
        }

        // if( $countEntregados == $countItems ){
        //     return redirect()->route('hojaRepuestos', ['idNecesidadRepuestos' => $necesidadRepuestos->id_necesidad_repuestos]);
        // }
        DB::commit();
        return redirect()->route('detalle_repuestos.index',['id_hoja_trabajo' => $necesidadRepuestos->getNecesidadRepuestosIdHojaTrabajo()])->with('success','Repuesto registrado satisfactoriamente');
    }
       
          

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $itemNecesidad = ItemNecesidadRepuestos::find($id);
        
        if($itemNecesidad->entregado !=1){
                $this->saveTrackingDelete($itemNecesidad);
            if($itemNecesidad){
                if(!is_null($idMovSalida = $itemNecesidad->id_movimiento_salida_virtual)){
                    $movimientoSalidaVirtual = MovimientoRepuesto::find($idMovSalida);
                    if(!is_null($movimientoSalidaVirtual)){
                        $movimientoSalidaVirtual->delete();
                    }
                }
                $itemNecesidad->delete();
            }
            DB::commit();
        }
        
        return redirect()->back();
    }

    private function saveTrackingDelete($transaction){
        $data = json_encode($transaction);
        $origen = "ItemNecesidadRepuestos";
        $id_cotizacion = $transaction->idCotizacion();
        $id_recepcion_ot = $transaction->idRecepcionOT();

        if($id_cotizacion==null){
            $origen = "ItemNecesidadRepuestosOT";
            $id_contenedor_origen = $id_recepcion_ot;
        }else{
            $origen = "ItemNecesidadRepuestosCot";
            $id_contenedor_origen = $id_cotizacion;
        }
        $id_origen = $transaction->id_item_necesidad_repuestos;
        
        $id_usuario_eliminador = Auth::user()->id_usuario;
        $name = Auth::user()->empleado->nombreCompleto();
        $description = "Repuesto con Nro de Parte ".$transaction->getRepuestoNroParteTexto()."(". $transaction->descripcion_item_necesidad_repuestos.")"." eliminado por ".$name;
        
        $t = new TrackDeletedTransactions();
        $t->data = $data;
        $t->id_origen = $id_origen;
        $t->id_contenedor_origen = $id_contenedor_origen;
        $t->origen = $origen;
        $t->description = $description;
        $t->id_usuario_eliminador = $id_usuario_eliminador;
        $t->save();
        
    }


    public function actualizarImportado(Request $request){
        $repuesto = ItemNecesidadRepuestos::find($request->id_item_repuesto);
        if($request->checked == "true"){
            $repuesto->es_importado = 1;
        } else {
            $repuesto->es_importado = 0;
        }
        $repuesto->save();
    }

    public function finalizarCotizacion(Request $request){
        $hojaTrabajo = HojaTrabajo::find($request->id_hoja_trabajo);
        $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro','desc')->first();
        $itemNecesidadRepuestos = $necesidadRepuestos->itemsNecesidadRepuestos;
        /*
        foreach($itemNecesidadRepuestos as $itemRepuesto){
            $stockDisponible = $itemRepuesto->repuesto->getStockVirtual($itemRepuesto->getIdLocal());
            if($stockDisponible > $itemRepuesto->cantidad_aprobada){
                $itemRepuesto->es_importado = null;
            }
        }
        */
        $necesidadRepuestos->es_finalizado = 1;
        $necesidadRepuestos->save();
        return redirect()->route('repuestosCot');
    }


    public static function updateStatic(Request $request, $id)
    {
        DB::beginTransaction();
        $itemNecesidad = ItemNecesidadRepuestos::find($id);
        

        $necesidadRepuestos = $itemNecesidad->necesidadRepuestos;
        //En caso se realice la codificación del repuesto
        $primeraAsignacion = $itemNecesidad->id_repuesto === null ? true : false;
        
        $repuesto = $itemNecesidad->repuesto;
        

        //En caso nos encontremos en solicitud de repuestos para OT's
        $recepcionOT = $necesidadRepuestos->hojaTrabajo->recepcionOT;
        $stockDisponible = $itemNecesidad->repuesto->getStockVirtual($itemNecesidad->getIdLocal());
        $cantidadAprobada = $itemNecesidad->getCantidadAprobada();
        
        $itemNecesidad->entregado_a = $request->entregado_a;
        
        if($cantidadAprobada > $stockDisponible){
            if($request->fechaPedido){
                $itemNecesidad->fecha_pedido = Carbon::createFromFormat('d/m/Y',$request->fechaPedido);
            }
            if($request->fechaPromesa){
                $itemNecesidad->fecha_promesa = Carbon::createFromFormat('d/m/Y',$request->fechaPromesa);
            }
            
            $itemNecesidad->es_importado = $request->esImportacion;

            if($itemNecesidad->es_importado)
                $recepcionOT->convertirAHotline();

            if($primeraAsignacion && $stockDisponible > 0){
                $itemNecesidad->egresoVirtualStockDisponible($cantidadAprobada, $stockDisponible);
            }
        }
        elseif($itemNecesidad->es_importado === null && $primeraAsignacion){
            //para el caso en el que se haya registrado el repuesto como disponible aun sin entregar
            // registro del movimiento virtual (aqui POR AHORA)
            $response = MovimientoRepuesto::generarEgresoVirtual($itemNecesidad->id_repuesto, $itemNecesidad->getIdLocal(), $itemNecesidad->getCantidadAprobada(), "App\Modelos\ItemNecesidadRepuestos", $itemNecesidad->id_item_necesidad_repuestos);
            if($response) $itemNecesidad->id_movimiento_salida_virtual = $response;
        }

        $itemNecesidad->realizarEntrega(Carbon::now()->format('d/m/Y'), $recepcionOT);

        if($recepcionOT)
            $recepcionOT->reiniciarProcesoReparacionTecnicos();

        $countEntregados = 0;
        $countItems = 0;


        foreach ($necesidadRepuestos->itemsNecesidadRepuestos as $itemNecesidadRepuesto){
            if($itemNecesidadRepuesto->entregado){
                $countEntregados++;
            }
            $countItems++;
        }

        // if( $countEntregados == $countItems ){
        //     return redirect()->route('hojaRepuestos', ['idNecesidadRepuestos' => $necesidadRepuestos->id_necesidad_repuestos]);
        // }
        DB::commit();
        return redirect()->route('detalle_repuestos.index',['id_hoja_trabajo' => $necesidadRepuestos->getNecesidadRepuestosIdHojaTrabajo()])->with('success','Repuesto registrado satisfactoriamente');
    }

}
