<?php

namespace App\Http\Controllers\Facturacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Administracion\UsuarioController;
use App\Modelos\NotaCreditoDebito;
use App\Modelos\LineaCotizacionMeson;
use App\Modelos\EntregadoReparacion;
use App\Modelos\VentaMeson;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\FacturasAnuladasPorNCND;
use App\Modelos\HojaTrabajo;
use App\Modelos\RecepcionOT_EstadoReparacion;
use App\Modelos\ComprobanteAnticipo;
use App\Modelos\ComprobanteVenta;
use App\Modelos\LocalEmpresa;
use App\Modelos\RecepcionOT;
use App\Modelos\CotizacionMeson;
use App\Helper\Helper;
use Carbon\Carbon;
use DB;
use Auth;
use Excel;

class NotaCreditoDebitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comprobante_ventas = \App\Modelos\ComprobanteVenta::whereNull('sunat_code');
        $comprobante_anticipos = \App\Modelos\ComprobanteAnticipo::whereNull('sunat_code');
        
        foreach ($comprobante_ventas as $comprobante) {
            self::actualizarEstados($comprobante);
        }

        foreach ($comprobante_anticipos as $comprobante) {
            self::actualizarEstados($comprobante);
        }

        $locales = LocalEmpresa::all();
        $porFacturar = $this->getPorFacturar();

        $result = self::obtenerComprobantes($request);        
                
        return view('contabilidadv2.listadoFacturas', ['listaNotas' => $result,
                                                    'locales' => $locales,
                                                    'pendientesPorFacturar' => $porFacturar,
                                                    "refreshable" => false]);
    }

    private function getPorFacturar(){
        $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto','ciaSeguro']);
        $recepciones_ots = $recepciones_ots_pre->whereHas('estadosReparacion' , function ($query){
            $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno',['liquidado','liquidado_hotline'/*,'perdida_total'*/])
            ->where('recepcion_ot_estado_reparacion.es_estado_actual',1)
            ->orderBy('estado_reparacion.nombre_estado_reparacion');
        })->get();

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

        return $recepciones_ots;
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
        $requestsCode = $request->all();
       // dd($request->all());
        $requests= $requestsCode['data'];
        $nota = new NotaCreditoDebito();
        
        $nota->tipo_documento = $requests['selectTipoDocumento'];
        $nota->serie = substr($requests['numDocRef'],0,1).$requests['numSerie'];
        $nota->num_doc = null;
        $nota->doc_referencia = $requests['numDocRef'];
        //$nota->fecha_vencimiento = Carbon::createFromFormat('d/m/Y',$requests['fechaVencimiento']);
        $nota->fecha_vencimiento = Carbon::now();
        //$nota->condicion_pago = $requests['condicionPago'];
        $nota->condicion_pago = '';
        $nota->motivo_emision = $requests['reason'];
        $nota->observaciones = $requests['observaciones'];
        $nota->estado = "Enviado";
        $nota->id_sibi_credit_notes = null;
        $nota->taxable_operations = $requests['taxable_operations'];;
        $nota->id_usuario_registro = Auth::user()->id_usuario;
        $nota->id_local = 1;
        $nota->precio_total = $requests['precio_total'];
        $nota->moneda = $requests['moneda'];
        $nota->tipo_cambio = $requests['tipo_cambio'];
        $nota->tipo_operacion = $requests['tipo_operacion'];
        $nota->id_comprobante_venta = $requests['id_comprobante_venta'];
        $nota->id_comprobante_anticipo = $requests['id_comprobante_anticipo'];
        $nota->fecha_emision = date('Y-m-d');
        $sale_id = $requests['sale_id'];

        $fuente_meson = VentaMeson::where( 'nro_factura',$requests['numDocRef'])->where('id_comprobante_venta',$requests['id_comprobante_venta'])->first();
        $fuente_taller = EntregadoReparacion::where( 'nro_factura',$requests['numDocRef'])->where('id_comprobante_venta',$requests['id_comprobante_venta'])->first();
        $fuente_anticipo = ComprobanteAnticipo::where(DB::raw("CONCAT(serie,'-',nro_comprobante)"), 'LIKE', $requests['numDocRef'])->first();
        // dd($requests['id_comprobante_venta']);
        $nota->save();
        
        if($fuente_meson!=null){
            $this->returnItemsToStock('MESON',  $fuente_meson->id_cotizacion_meson, $fuente_meson->nro_factura, $fuente_meson->fecha_venta, $nota->id_nota_credito_debito );
            $fuente_meson->delete();
            $fuentes_duplicadas = VentaMeson::where('id_cotizacion_meson',$fuente_meson->id_cotizacion_meson)->get();
            foreach($fuentes_duplicadas as $r){
                $r->delete();
            }
            
        }else if($fuente_taller!=null){
            $this->returnItemsToStock('TALLER',  $fuente_taller->id_recepcion_ot, $fuente_taller->nro_factura, $fuente_taller->fecha_entrega, $nota->id_nota_credito_debito );
            $fuente_taller->delete();
            $fuentes_duplicadas = EntregadoReparacion::where('id_cotizacion_meson',$fuente_taller->id_recepcion_ot)->get();
            foreach($fuentes_duplicadas as $r){
                $r->delete();
            }
        }else if($fuente_anticipo!=null){
            $fuente_anticipo->estado = "Anulado NC/ND";
            $fuente_anticipo->save();
        }


        return $nota->id_nota_credito_debito;
        return response()->json([
            'id'=>$nota->id_nota_credito_debito,
            'status' => "Succes",
            'code' => 201
        ], 404);
        
    }

    private function returnItemsToStock($fuente, $id_fuente, $nro_fac, $fecha_entrega, $id_nota_credito_debito){
        $factura_anulada = new FacturasAnuladasPorNCND();
        $factura_anulada->fecha_entrega = $fecha_entrega;
        if($fuente=="MESON"){
            $factura_anulada->id_cotizacion_meson = $id_fuente;
            $lineasCotizacionMeson = LineaCotizacionMeson::where('id_cotizacion_meson', $id_fuente)->get();
            
            
            foreach($lineasCotizacionMeson as $row){
                //cambio el id de la salida anterior a hun egreso anulado
                //dd($row->id_movimiento_salida); 8245
                $movimiento = MovimientoRepuesto::find($row->id_movimiento_salida)->first();
                // dd($movimiento);
                if($movimiento!=null){
                    $movimiento->motivo = "EGRESO ANULADO";
                    $movimiento->save();
                }

                //elimino las reserva tambien
                $movimiento_virtual = MovimientoRepuesto::find($row->id_movimiento_salida_virtual)->first();
                $movimiento_virtual->delete();
                //dd('as');

                $row->es_atendido = 0;
                $row->es_entregado = 0;
                $row->id_movimiento_salida = null;
                $row->id_movimiento_salida_virtual = null;
                $row->save();

                $movimientoRepuesto = new MovimientoRepuesto();
                $movimientoRepuesto->id_repuesto = $row->id_repuesto;
                $movimientoRepuesto->tipo_movimiento = 'INGRESO';
                $movimientoRepuesto->motivo = 'INGRESO POR NC-ND';
                $movimientoRepuesto->cantidad_movimiento = $row->cantidad;
                $movimientoRepuesto->id_local_empresa= Auth::user()->empleado->id_local;
                $movimientoRepuesto->fecha_movimiento = Carbon::now();
                $movimientoRepuesto->fuente_type = "App\Modelos\NotaCreditoDebito";
                $movimientoRepuesto->fuente_id = $id_nota_credito_debito;
                $movimientoRepuesto->costo = $this->getCostWithDevolucion($row->id_repuesto);
                $movimientoRepuesto->saldo = $this->balanceWithDevolution($row->id_repuesto,$row->cantidad);
                $movimientoRepuesto->costo_promedio_ingreso = $this->getCostWithDevolucion($row->id_repuesto);
                $ingreso_dolares = $this->getCostWithDevolucion($row->id_repuesto) * $row->cantidad;
                $movimientoRepuesto->saldo_dolares = $this->balanceDollar($id_repuesto, $ingreso_dolares);
                $movimientoRepuesto->save();
            }
         
        }else{
            // si es talller
            $factura_anulada->id_recepcion_ot = $id_fuente;
            $hojaTrabajo = Hojatrabajo::where('id_recepcion_ot',$id_fuente)->first();
            
            $itemNecesidadRepuestos = $hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos();
            
            $estado_Actual= RecepcionOT_EstadoReparacion::where('id_recepcion_ot',$id_fuente)->where('es_estado_actual',1)->first();
            $estado_Actual->es_estado_actual= 0;
            $estado_Actual->save();

            $recepcionOT_EstadoReparacion = new RecepcionOT_EstadoReparacion();
            $recepcionOT_EstadoReparacion->id_recepcion_ot = $id_fuente;
            $recepcionOT_EstadoReparacion->id_estado_reparacion = 6;
            $recepcionOT_EstadoReparacion->es_estado_actual = 1;
            $recepcionOT_EstadoReparacion->fecha_registro = Carbon::now();
            
            $recepcionOT_EstadoReparacion->save();


            foreach($itemNecesidadRepuestos as $row){
                //cambio el id de la salida anterior a hun egreso anulado
                $movimiento = MovimientoRepuesto::find($row->id_movimiento_salida)->get();
                $movimiento->motivo = "EGRESO ANULADO";
                //$movimiento->save();

                //elimino las reserva tambien
                // $movimiento_virtual = MovimientoRepuesto::find($row->id_movimiento_salida_virtual)->first();
                // $movimiento_virtual->delete();

                // $row->entregado = 0;
                // $row->id_movimiento_salida = null;
                // $row->id_movimiento_salida_virtual = null;
                // $row->save();
                
 
                $movimientoRepuesto = new MovimientoRepuesto();
                $movimientoRepuesto->id_repuesto = $row->id_repuesto;
                $movimientoRepuesto->tipo_movimiento = 'INGRESO';
                $movimientoRepuesto->motivo = 'INGRESO POR NC-ND';
                $movimientoRepuesto->cantidad_movimiento = $row->cantidad;
                $movimientoRepuesto->id_local_empresa= Auth::user()->empleado->id_local;
                $movimientoRepuesto->fecha_movimiento = Carbon::now();
                $movimientoRepuesto->fuente_type = "App\Modelos\NotaCreditoDebito";
                $movimientoRepuesto->fuente_id = $id_nota_credito_debito;
                $movimientoRepuesto->costo = $this->getCostWithDevolucion($row->id_repuesto);
                $movimientoRepuesto->saldo = $this->balanceWithDevolution($row->id_repuesto,$row->cantidad);
                $movimientoRepuesto->costo_promedio_ingreso = $this->getCostWithDevolucion($row->id_repuesto);
                
                //$movimientoRepuesto->save();

            }
 
        }
        $factura_anulada->nro_factura = $nro_fac;
        $factura_anulada->fecha_entrega =  $fecha_entrega;
        $factura_anulada->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        


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
        $requestsCode = $request->all();
       
        $requests= $requestsCode['data'];
        
        $nota = NotaCreditoDebito::find($requests['id']);
               
        $num_doc = substr(1000000+$requests['num_doc'],1,6);
        $nota->num_doc = $num_doc;
        $nota->id_sibi_credit_notes =  $requests['id_sibi_credit_notes'];
        $nota->tipo_documento = $nota->tipo_documento;
        $nota->serie = $nota->serie;
        $nota->doc_referencia = strtoupper($nota->doc_referencia);
        $nota->fecha_vencimiento = $nota->fecha_vencimiento;
        $nota->condicion_pago = $nota->condicion_pago;
        $nota->motivo_emision = $nota->motivo_emision;
        $nota->observaciones = $nota->observaciones;
        $nota->estado =$nota->estado;
        $nota->taxable_operations = $nota->taxable_operations;
        $nota->id_usuario_registro = $nota->id_usuario_registro;
        $nota->save();
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


    private static function balanceWithDevolution($id_repuesto, $cantidad_movimiento){
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento','desc')->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo + $cantidad_movimiento;
    }

    private static function balanceDollar($id_repuesto, $ingreso_dolares){
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento','desc')->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo_dolares + $ingreso_dolares;
    }


    private static function getCostWithDevolucion($id_repuesto){
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento','desc')->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->first();
        if($lastMovimiento->tipo_movimiento == "INGRESO"){
            return $lastMovimiento->costo_promedio_ingreso;
        }else{
            return $lastMovimiento->costo;
        }
    }

    private static function getCondicionPagoTexto($id)
    {
        $condicion = '';
        switch ($id) {
            case 0:
                $condicion = 'Contado';
                break;
            case 15:
                $condicion = 'Crédito a 15 días';
                break;
            case 30:
                $condicion = 'Crédito a 30 días';
                break;
            case 45:
                $condicion = 'Crédito a 45 días';
                break;
            case 60:
                $condicion = 'Crédito a 60 días';
                break;
            default:
                # code...
                break;
        }

        return $condicion;
    }

    private static function getSemaforo($fecha_vencimiento, $aplica = false) {
        $semaforo = '';
                
        if($aplica) {
            $fecha_emision = \Carbon\Carbon::now();
            $diffDays = $fecha_emision->diffInDays($fecha_vencimiento, false);            

            if ($diffDays > 10) $semaforo = "bg-success";
            elseif ($diffDays > 0 && $diffDays <= 10) $semaforo = "bg-warning";
            elseif ($diffDays <= 0) $semaforo = "bg-danger";
        }

        return $semaforo;
    }

    private static function getEstadoCredito($fecha_vencimiento) {
        $fecha_emision = \Carbon\Carbon::now();
        $diffDays = $fecha_emision->diffInDays($fecha_vencimiento, false);
        $absoluteDiffDays = abs($diffDays);
        $estado = '';

        if ($diffDays > 0) $estado = "Por vencer en {$absoluteDiffDays} día(s)";
        elseif ($diffDays == 0) $estado = "Vence hoy";
        elseif ($diffDays < 0) $estado = "Vencido hace {$absoluteDiffDays} día(s)";
                
        return $estado;
    }

    private static function actualizarEstados($comprobante)
    {
        $httpClient = new \GuzzleHttp\Client();

        $token = env('SIBI_TOKEN');

        $header = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'token-type' => 'Bearer',
            'Authorization' => "Bearer $token",
        ];

        $query = '
         query {
            sales(id:' . $comprobante->sale_id . ') {
            id
            sunat_code,
            sunat_description,
            }
         }
         ';

        $response = $httpClient->post(env('SIBI_URL'), ['headers' => $header, 'body' => json_encode([
            'query' => $query
        ])]);

        $bodyResponse = $response->getBody();

        $json = json_decode($bodyResponse->read(1024), true);
        $json = $json['data']['sales'][0];

        $comprobante->sunat_code = $json['sunat_code'];
        $comprobante->sunat_description = $json['sunat_description'];
        $comprobante->save();
    }

    public static function obtenerComprobantes($request) {
        $notasCreditoDebito = new NotaCreditoDebito();
        $comprobantesVenta = new ComprobanteVenta();
        $comprobantesAnticipo = new ComprobanteAnticipo();
     
        $fechaInicioEntrega = $request['fechaInicioEntrega'] ?? null;
        $fechaFinEntrega = $request['fechaFinEntrega'] ?? null;
        if($fechaInicioEntrega!=null){
            $fechaInicioEntrega = Carbon::createFromFormat('d/m/Y', $request['fechaInicioEntrega']);
        }
        if($fechaFinEntrega !=null){
            $fechaFinEntrega = Carbon::createFromFormat('d/m/Y', $request['fechaFinEntrega']);
        }
        

        $idLocal = $request['filtroLocal'] ?? null;
        $filtroEstadoSunat = $request['filtroEstadoSunat'] ?? null;
        $filtroSerieLetra = $request['filtroSerieLetra'] ?? null;
        $numSerie= $request['numSerie'] ?? null;
        $numDoc= $request['numDoc'] ?? null;
        $documento =$filtroSerieLetra.$numSerie.'-'.$numDoc;
        $filtroCentroCosto= $request['filtroCentroCosto'] ?? null;
        $docCliente= $request['docCliente'] ?? null;
        $filtroTipoOperacion= $request['filtroTipoOperacion'] ?? null;
        $filtroTipoVenta= $request['filtroTipoVenta'] ?? null;
        $filtroTipoDocumento= $request['filtroTipoDocumento'] ?? null;
        $filtroCondicionPago= $request['filtroCondicionPago'] ?? null;

        if($fechaInicioEntrega != null){
            $notasCreditoDebito = $notasCreditoDebito->where('fecha_emision','>=',$fechaInicioEntrega);
            $comprobantesVenta = $comprobantesVenta->where('fecha_emision','>=',$fechaInicioEntrega);
            $comprobantesAnticipo = $comprobantesAnticipo->where('fecha_emision','>=',$fechaInicioEntrega);
        }
        if($fechaFinEntrega!=null){
            $notasCreditoDebito = $notasCreditoDebito->where('fecha_emision','<=',$fechaFinEntrega);
            $comprobantesVenta = $comprobantesVenta->where('fecha_emision','<=',$fechaFinEntrega);
            $comprobantesAnticipo = $comprobantesAnticipo->where('fecha_emision','<=',$fechaFinEntrega);
        }
        if($idLocal!=null){
            $notasCreditoDebito = $notasCreditoDebito->where('id_local',$idLocal);
            $comprobantesVenta = $comprobantesVenta->where('id_local',$idLocal);
            $comprobantesAnticipo = $comprobantesAnticipo->where('id_local',$idLocal);
        }
        
        if($filtroEstadoSunat!=null){
            $notasCreditoDebito = $notasCreditoDebito->where('fecha_emision',$estado);
            $comprobantesVenta = $comprobantesVenta->where('fecha_emision','>=',$estado);
            $comprobantesAnticipo = $comprobantesAnticipo->where('fecha_emision','>=',$estado);
        }
        if($documento != null &&  strlen($documento) > 8 ){
            $notasCreditoDebito = $notasCreditoDebito->where(DB::raw("CONCAT(serie,'-',num_doc)"), 'LIKE', $documento);
            $comprobantesVenta = $comprobantesVenta->where(DB::raw("CONCAT(serie,'-',nro_comprobante)"), 'LIKE', $documento);
            $comprobantesAnticipo = $comprobantesAnticipo->where(DB::raw("CONCAT(serie,'-',nro_comprobante)"), 'LIKE', $documento);
        }
        if($filtroCentroCosto !=null){
            $notasCreditoDebito = $notasCreditoDebito->where('serie', 'LIKE', '%'.$filtroCentroCosto);
            $comprobantesVenta = $comprobantesVenta->where('serie', 'LIKE', '%'.$filtroCentroCosto);
            $comprobantesAnticipo = $comprobantesAnticipo->where('serie', 'LIKE', '%'.$filtroCentroCosto);
        }
        if($docCliente!=null){
            $notasCreditoDebito = $notasCreditoDebito->where('nrodoc_cliente',$docCliente);
            $comprobantesVenta = $comprobantesVenta->where('nrodoc_cliente',$docCliente);
            $comprobantesAnticipo = $comprobantesAnticipo->where('nrodoc_cliente',$docCliente);
        }
        if($filtroTipoOperacion!=null){
            $notasCreditoDebito = [];
            $comprobantesVenta = $comprobantesVenta->where('tipo_operacion',$filtroTipoOperacion);
            $comprobantesAnticipo = $comprobantesAnticipo->where('tipo_operacion',$filtroTipoOperacion);
        }
        if ($filtroTipoVenta!=null) {
            $notasCreditoDebito = [];
            $comprobantesVenta = $comprobantesVenta->where('tipo_venta', $filtroTipoVenta);
            $comprobantesAnticipo = $comprobantesAnticipo->where('tipo_venta', $filtroTipoVenta);
        }
        if($filtroTipoDocumento!=null){
            if($filtroTipoDocumento == "FACTURA" || $filtroTipoDocumento == "BOLETA"){
                if($filtroTipoDocumento == "FACTURA"){
                    $comprobantesVenta = $comprobantesVenta->where('tipo_comprobante', "FACTURA" );
                    $comprobantesAnticipo = $comprobantesAnticipo->where('tipo_comprobante', "FACTURA" );
                }else{
                    $comprobantesVenta = $comprobantesVenta->where('tipo_comprobante', "BOLETA" );
                    $comprobantesAnticipo = $comprobantesAnticipo->where('tipo_comprobante', "BOLETA" );
                }
               
                $notasCreditoDebito = [];
            }else{
                if($notasCreditoDebito!= []){
                    if($filtroTipoDocumento == "NC" && $notasCreditoDebito){
                        $notasCreditoDebito = $notasCreditoDebito->where('tipo_documento','NC');
                    }else{
                        $notasCreditoDebito = $notasCreditoDebito->where('tipo_documento','ND');
                    }
                }
                $comprobantesVenta = [];
                $comprobantesAnticipo = [];
            }    
        }
        
        
        if($filtroCondicionPago!=null){
            $notasCreditoDebito =[];
            
            if( $comprobantesVenta!=[] ){
                $comprobantesVenta = $comprobantesVenta->where('condicion_pago',$filtroCondicionPago);
                
            }
            if($comprobantesAnticipo!=[]){
                $comprobantesAnticipo = $comprobantesAnticipo->where('condicion_pago',$filtroCondicionPago);
            }
            
           
        }
       

        $result = [];        
        
        $notasCreditoDebito = $notasCreditoDebito!=[] ? $notasCreditoDebito->get():[];
        $comprobantesVenta = $comprobantesVenta!=[] ? $comprobantesVenta->get():[];
        $comprobantesAnticipo = $comprobantesAnticipo!=[] ? $comprobantesAnticipo->get():[];
      
        foreach($comprobantesVenta  as $row){
            $aplica = false;
            if($row->condicion_pago > 0) $aplica = true;
            
            $semaforo = self::getSemaforo($row->fecha_vencimiento, $aplica);

            $row_data = [
                'semaforo' => $semaforo,
                'local'=> $row->getLocal(),
                'registrado_por'=> $row->usuarioNombre(),
                'fecha_registro'=> $row->getFecha(),
                'centro_costo'=> $row->getCentroCosto(),
                'tipo_documento'=> $row->tipo_comprobante,
                'documento'=> $row->nroFactura(),
                'doc_cliente'=> $row->nrodoc_cliente,
                'cliente'=> $row->nombre_cliente,
                'condicion_pago'=> $row->condicion_pago,
                'condicion_pago_texto'=> self::getCondicionPagoTexto($row->condicion_pago),
                'metodo_pago' => $row->metodoPago->metodo_nombre_mostrar,
                'nro_operacion' => $row->nro_operacion,
                'estado_credito'=> self::getEstadoCredito($row->fecha_vencimiento),
                'tipo_operacion'=> $row->tipo_operacion,
                'doc_referencia'=> $row->docReferencia(true),                
                'doc_referencia_sin_link'=> $row->docReferencia(false),                
                'moneda'=> $row->moneda,
                'detraccion'=> $row->tasa_detraccion == 0.12 ? 'SI':'NO',
                'subtotal'=> number_format($row->total_venta/ 1.18,2),
                'impuesto'=> number_format($row->total_venta/1.18*0.18,2),
                'total'=> number_format($row->total_venta,2),
                'estado'=> $row->estado,
                'url' => $row->getLinkDetalleHTML(),
                'url_nota_entrega' => $row->getLinkNotaEntregaHTML(),
                'url_constancia' => $row->getLinkConstanciaHTML(),
                'sunat_code' => $row->sunat_code,
                'sunat_description' => $row->sunat_description,
                'entidadFinanciera' => $row->entidadFinanciera ? $row->entidadFinanciera->valor1 : '',
                'tipoTarjeta' => $row->tipoTarjeta ? $row->tipoTarjeta->valor1 : '',
                'observaciones' => $row->observaciones,
            ];
            array_push($result,(object)$row_data);
        }


        foreach($notasCreditoDebito  as $row){
            $aplica = false;
            if($row->condicion_pago > 0) $aplica = true;
            
            $semaforo = self::getSemaforo($row->fecha_vencimiento, $aplica);

            $row_data = [
                'semaforo' => $semaforo,
                'local'=> $row->getLocal(),
                'registrado_por'=> $row->usuarioNombre(),
                'fecha_registro'=> $row->getFecha(),
                'centro_costo'=> $row->getCentroCosto(),
                'tipo_documento'=> $row->tipo_documento,
                'documento'=> $row->num_doc,
                'doc_cliente'=> $row->getDocCliente(),
                'cliente'=> $row->getNombreCliente(),
                'condicion_pago'=> $row->condicion_pago,
                'condicion_pago_texto'=> self::getCondicionPagoTexto($row->condicion_pago),
                'metodo_pago' => '',
                'nro_operacion' => '',
                'estado_credito'=> self::getEstadoCredito($row->fecha_vencimiento),
                'tipo_operacion'=> '',
                'doc_referencia'=> $row->doc_referencia,
                'doc_referencia_sin_link'=> $row->doc_referencia,
                'moneda'=> $row->moneda,
                'detraccion'=> '',
                'subtotal'=> number_format($row->precio_total/ 1.18,2),
                'impuesto'=>number_format( $row->precio_total/1.18*0.18,2),
                'total'=> number_format($row->precio_total,2),
                'estado'=> $row->estado,
                'url' => $row->getLinkDetalleHTML(),
                'url_nota_entrega' => null,
                'url_constancia' => null,
                'sunat_code' => '',
                'sunat_description' => null,
                'entidadFinanciera' => '',
                'tipoTarjeta' => '',
                'observaciones' => $row->observaciones,
            ];
            array_push($result,(object)$row_data);
        }

        foreach($comprobantesAnticipo  as $row){

            $aplica = false;
            if($row->condicion_pago > 0) $aplica = true;
            
            $semaforo = self::getSemaforo($row->fecha_vencimiento, $aplica);

            $row_data = [
                'semaforo' => $semaforo,
                'local'=> $row->getLocal(),
                'registrado_por'=> $row->usuarioNombre(),
                'fecha_registro'=> $row->getFecha(),
                'centro_costo'=> $row->getCentroCosto(),
                'tipo_documento'=> $row->tipo_comprobante,
                'documento'=> $row->nroFactura(),
                'doc_cliente'=> $row->nrodoc_cliente,
                'cliente'=> $row->nombre_cliente,
                'condicion_pago'=> $row->condicion_pago,
                'condicion_pago_texto'=> self::getCondicionPagoTexto($row->condicion_pago),
                'metodo_pago' => $row->metodoPago->metodo_nombre_mostrar,
                'nro_operacion' => $row->nro_operacion,
                'estado_credito'=> self::getEstadoCredito($row->fecha_vencimiento),
                'tipo_operacion'=> $row->tipo_operacion,
                'doc_referencia'=> $row->docReferencia(true),                
                'doc_referencia_sin_link'=> $row->docReferencia(false),  
                'moneda'=> $row->moneda,
                'detraccion'=> 'NO',
                'subtotal'=> number_format($row->total_venta/ 1.18,2),
                'impuesto'=> number_format($row->total_venta/1.18*0.18,2),
                'total'=> number_format($row->total_venta,2),
                'estado'=> $row->estado,
                'url' => $row->getLinkDetalleHTML(),
                'url_nota_entrega' => $row->getLinkNotaEntregaHTML(),
                'url_constancia' => $row->getLinkConstanciaHTML(),
                'sunat_code' => $row->sunat_code,
                'sunat_description' => $row->sunat_description,
                'entidadFinanciera' => $row->entidadFinanciera ? $row->entidadFinanciera->valor1 : '',
                'tipoTarjeta' => $row->tipoTarjeta ? $row->tipoTarjeta->valor1 : '',
                'observaciones' => $row->observaciones,
            ];
            array_push($result,(object)$row_data);
        }

        return $result;
    }

}
