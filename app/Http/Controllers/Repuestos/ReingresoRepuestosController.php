<?php

namespace App\Http\Controllers\Repuestos;

use App\Modelos\Devolucion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\ItemDevolucion;
use Carbon\Carbon;
use App\Modelos\OrdenCompra;
use App\Modelos\NotaIngreso;
use App\Modelos\LineaNotaIngreso;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\Proveedor;
use App\Modelos\RecepcionOT;
use App\Modelos\EntregadoReparacion;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\ReingresoRepuestos;
use App\Modelos\LineaReingresoRepuestos;
use App\Modelos\Repuesto;
use App\Modelos\ItemNecesidadRepuestosDeleted;
use App\Modelos\ConsumoTaller;
use App\Modelos\LineaConsumoTaller;
use DB;
use Auth;
use PDF;
use App\Modelos\TipoCambio;

class ReingresoRepuestosController extends Controller
{
    public function index(Request $request)
    {

        $rutaDescarga = "";
        if (session('rutaDescarga')) {
            $rutaDescarga = session('rutaDescarga');
        }
        $fecha_emision = Carbon::now();
        $fecha_emision = $fecha_emision->format('d/m/Y');
        // return $request->all();
        if ($request->all() == []) {
            return view('repuestos.reingresoRepuestos', [
                'fecha_emision' => $fecha_emision,
                'rutaDescarga' => $rutaDescarga
            ]);
        } else {
            $motivo = $request->motivoSol;
            $funciones_disponibles = ['COMPRAS', 'TALLER', 'DEVOLUCION', 'CTALLER'];

            if (!in_array($motivo, $funciones_disponibles)) {
                return redirect()->route('reingresoRepuestos.index')->with('noDisponible', 'Función no disponible aún');
            }
            if ($motivo == "COMPRAS") {
                $OCRelacionada = $request->input('docRelacionado');
                $orden_compra = OrdenCompra::find($OCRelacionada);
                if (is_null($orden_compra)) {
                    return redirect()->back()->with('oCNoExiste', 'La OC ingresada no existe')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                } else if (!$orden_compra->es_aprobado) {
                    return redirect()->back()->with('oCNoAprobada', 'La OC ingresada no se encuentra aprobada')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                } else if ($orden_compra->es_finalizado) {
                    return redirect()->back()->with('oCAtendida', 'La OC ingresada ya ha sido atendida')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                }
                $numOrdenCompra = $orden_compra->id_orden_compra;
                $moneda = $orden_compra->tipo_moneda;
                $proveedor = Proveedor::find($orden_compra->id_proveedor);
                $rucProveedor = $proveedor->num_doc;
                $nombreProveedor = $proveedor->nombre_proveedor;
                $lineasRepuesto = $orden_compra->lineasCompra;
                return view('repuestos.reingresoRepuestos', [
                    'fecha_emision' => $fecha_emision,
                    'documento' => $orden_compra,
                    'numDocumento' => $numOrdenCompra,
                    'moneda' => $moneda,
                    'tipoCambio' => "-",
                    'rucProveedor' => $rucProveedor,
                    'nombreProveedor' => $nombreProveedor,
                    'lineasRepuesto' => $lineasRepuesto,
                    'rutaDescarga' => $rutaDescarga,
                    'motivo' => $motivo
                ]);
            } elseif ($motivo == "CTALLER") {
                return view('repuestos.reingresoRepuestos', [
                    'fecha_emision' => $fecha_emision,
                    'rutaDescarga' => $rutaDescarga,
                    'motivo' => $motivo
                ]);
            } elseif ($motivo == "TALLER") {
                $OTRelacionada = $request->input('docRelacionado');
                $ot = RecepcionOT::find($OTRelacionada);
                if (is_null($ot)) {
                    return redirect()->back()->with('oTNoExiste', 'La OT ingresada no existe')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                }
                if (!is_null(EntregadoReparacion::where('id_recepcion_ot', $ot->id_recepcion_ot)->first())) {
                    return redirect()->back()->with('oTFacturada', 'La OT ingresada se encuentra facturada')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                }
                if (!is_null($ot->otCerrada->first())) {
                    return redirect()->back()->with('oTCerrada', 'La OT ingresada se encuentra cerrada')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                }
                $hojaTrabajo = $ot->hojaTrabajo;
                $numOT = $ot->id_recepcion_ot;
                $moneda = $hojaTrabajo->moneda;
                $tipoCambio = $hojaTrabajo->tipo_cambio;
                $necesidadRepuestos = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
                if (is_null($necesidadRepuestos)) {
                    return redirect()->back()->with('oTSinRepuestos', 'La OT ingresada no cuenta con repuestos entregados')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                }
                $repuestos = $necesidadRepuestos->itemsNecesidadRepuestos()->where('entregado', 1)->get();
                if (!$repuestos->count()) {
                    return redirect()->back()->with('oTSinRepuestos', 'La OT ingresada no cuenta con repuestos entregados')
                        ->with('tipoTransaccion', $request->tipoTransaccion)
                        ->with('motivoSol', $request->motivoSol);
                }

                return view('repuestos.reingresoRepuestos', [
                    'fecha_emision' => $fecha_emision,
                    'documento' => $ot,
                    'numDocumento' => $numOT,
                    'moneda' => $moneda,
                    'tipoCambio' => $tipoCambio,
                    'rucProveedor' => "-",
                    'nombreProveedor' => "-",
                    'lineasRepuesto' => $repuestos,
                    'motivo' => $motivo
                ]);
            } elseif ($motivo == "DEVOLUCION") {

                if (!$request->docProveedorSol) {
                    return redirect()->route('reingresoRepuestos.index')->with('errorDocProveedor', 'Ingrese un documento del proveedor');
                }


                $proveedor = Proveedor::where("num_doc", $request->docProveedorSol)->first();
                $rucProveedor = $proveedor->num_doc;
                $nombreProveedor = $proveedor->nombre_proveedor;
                return view('repuestos.reingresoRepuestos', [
                    'fecha_emision' => $fecha_emision,
                    'rutaDescarga' => $rutaDescarga,
                    'rucProveedor' => $rucProveedor,
                    'nombreProveedor' => $nombreProveedor,
                    'motivo' => $motivo
                ]);
            }
        }
    }


    public function store(Request $request)
    {
        $requests = $request->all();
        if ($request->motivoRelacionado == "COMPRAS") {
            DB::beginTransaction();
            $fecha_recepcion = Carbon::now();
            $nota_ingreso = new NotaIngreso();
            $nota_ingreso->id_usuario_registro = Auth::user()->id_usuario;

            if ($request->guiaRemisionSol != "") {
                $nota_ingreso->guia_remision = $request->guiaRemisionSol;
            }
            if ($request->facturaSol != "") {
                $nota_ingreso->factura_asociada = $request->facturaSol;
            }

            $nota_ingreso->save();

            $id_nota_ingreso = $nota_ingreso->id_nota_ingreso;

            foreach ($requests as $key => $value) {
                //Obtenemos la posición del string ingresado para ver si existe el registro
                $pos_input = strpos($key, "cant-");
                //Si es que lo encuentra, entonces también deben estar los demas campos relacionados a ese número de fila
                if ($pos_input !== false && $pos_input >= 0) {
                    //Obtenemos el número de registro
                    $numRequest = substr($key, $pos_input + strlen('cant-'));
                    $lineaNotaIngreso = new LineaNotaIngreso();
                    $lineaNotaIngreso->id_nota_ingreso = $id_nota_ingreso;
                    $lineaNotaIngreso->cantidad_ingresada = $request->input("cant-" . $numRequest);
                    $lineaNotaIngreso->id_linea_orden_compra = $numRequest;
                    $lineaNotaIngreso->save();

                    //El repuesto viene en presentacion diferente caso Cilindro y se vende por litro
                    $repuesto = Repuesto::find($lineaNotaIngreso->getIdRepuesto());

                    $cantidad_unidades_grupo = 0;
                    $costo_unitario = $this->getCosto($lineaNotaIngreso);

                    $cantidad_ingresada = $request->input("cant-" . $numRequest);
                    if ($repuesto->cantidad_unidades_grupo != null) {

                        $cantidad_ingresada = $cantidad_ingresada * $repuesto->cantidad_unidades_grupo;
                        $costo_unitario = $costo_unitario / $cantidad_ingresada;
                    }
                    $lineaNotaIngreso->cantidad_ingresada = $cantidad_ingresada;

                    $lineaNotaIngreso->id_linea_orden_compra = $numRequest;
                    $lineaNotaIngreso->save();




                    //se registra como ingreso de repuestos FISICO (no existe el concepto de ingresos virtuales aun) (aqui POR AHORA) (bvez)
                    $movimiento = new MovimientoRepuesto();
                    $movimiento->id_repuesto = $lineaNotaIngreso->getIdRepuesto();
                    $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
                    $movimiento->cantidad_movimiento = $cantidad_ingresada;
                    $movimiento->tipo_movimiento = 'INGRESO';
                    $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
                    $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;

                    $costoPromedioOnlyIngreso = $this->getCostoPromedioOnlyIngreso($lineaNotaIngreso->getIdRepuesto(), $cantidad_ingresada, $costo_unitario);

                    $saldo = ($this->getStock($lineaNotaIngreso->getIdRepuesto()) + $cantidad_ingresada);
                    $movimiento->saldo = $saldo;
                    $movimiento->saldo_dolares = $this->getSaldoDolaresIngreso($lineaNotaIngreso->getIdRepuesto(), $cantidad_ingresada * $costo_unitario);
                    $movimiento->costo = $costo_unitario;
                    $movimiento->costo_promedio_ingreso = $costoPromedioOnlyIngreso > 0 ? $costoPromedioOnlyIngreso : $costo_unitario;
                    $movimiento->motivo = 'COMPRAS';

                    $movimiento->fecha_movimiento = Carbon::now();
                    $movimiento->save();

                    $lineaNotaIngreso->id_movimiento_ingreso = $movimiento->id_movimiento_repuesto;
                    $lineaNotaIngreso->save();
                }
            }

            $oc_relacionada = $request->input('documentoRelacionado');
            $orden_compra = OrdenCompra::find($oc_relacionada);
            if ($orden_compra->flagAtentidoTotal()) {
                $orden_compra->es_finalizado = 1;
                $orden_compra->fecha_finalizado = Carbon::now();
                $orden_compra->save();
            }
            DB::commit();
            return route('hojaNotaIngreso', ['id_nota_ingreso' => $id_nota_ingreso]);
            //$rutaDescarga = route('hojaNotaIngreso', ['id_nota_ingreso' => $id_nota_ingreso]);
            //return redirect()->route('reingresoRepuestos.index')->with(['rutaDescarga' => $rutaDescarga])->with('finalizado', 'COMPRA GENERADA');
        } elseif ($request->motivoRelacionado == "TALLER") {

            DB::beginTransaction();
            $ot = RecepcionOT::find($request->documentoRelacionado);

            $reingresoRepuestos = new ReingresoRepuestos();
            $reingresoRepuestos->usuario_registro = Auth::user()->id_usuario;
            $reingresoRepuestos->motivo = $request->motivo;
            $reingresoRepuestos->fecha_reingreso = Carbon::createFromFormat('d/m/Y', $request->fechaMovimiento);
            $reingresoRepuestos->id_recepcion_ot = $ot->id_recepcion_ot;
            $reingresoRepuestos->save();
            foreach ($requests as $key => $value) {
                //Obtenemos la posición del string ingresado para ver si existe el registro
                $pos_input = strpos($key, "cant-");
                //Si es que lo encuentra, entonces también deben estar los demas campos relacionados a ese número de fila
                if ($pos_input !== false && $pos_input >= 0) {
                    //Obtenemos el número de registro
                    $numRequest = substr($key, $pos_input + strlen('cant-'));
                    if ($request->input("cant-" . $numRequest) > 0) {
                        $itemNecesidad = ItemNecesidadRepuestos::find($numRequest);

                        //Generamos el movimiento 
                        $movimiento = new MovimientoRepuesto();
                        $movimiento->id_repuesto = $itemNecesidad->repuesto->id_repuesto;
                        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
                        $movimiento->cantidad_movimiento = $request->input("cant-" . $numRequest);
                        $movimiento->tipo_movimiento = 'INGRESO';
                        $movimiento->motivo = 'REINGRESO';
                        $movimiento->fecha_movimiento = Carbon::now();

                        //aqui 
                        $movimiento->fuente_type = "App\Modelos\LineaReingresoRepuestos";

                        $movimiento->saldo_dolares = $this->getSaldoDolaresIngreso($itemNecesidad->repuesto->id_repuesto, $request->input("cant-" . $numRequest) * $this->getCostWithDevolucion($itemNecesidad->repuesto->id_repuesto));
                        $movimiento->saldo = $this->balanceWithReEntry($itemNecesidad->repuesto->id_repuesto, $request->input("cant-" . $numRequest));
                        $movimiento->costo = $this->getCostWithDevolucion($itemNecesidad->repuesto->id_repuesto);
                        $movimiento->costo_promedio_ingreso =  $this->getCostWithDevolucion($itemNecesidad->repuesto->id_repuesto);
                        $movimiento->save();

                        $lineaReingresoRepuestos = new LineaReingresoRepuestos();
                        $lineaReingresoRepuestos->id_reingreso_repuestos = $reingresoRepuestos->id_reingreso_repuestos;
                        $lineaReingresoRepuestos->id_repuesto = $itemNecesidad->id_repuesto;
                        $lineaReingresoRepuestos->cantidad_reingreso = $request->input("cant-" . $numRequest);
                        $lineaReingresoRepuestos->fecha_entrega = Carbon::createFromFormat('d/m/Y', $request->fechaMovimiento);
                        $lineaReingresoRepuestos->id_movimiento_reingreso = $movimiento->id_movimiento_repuesto;
                        $lineaReingresoRepuestos->id_item_necesidad_repuestos = $itemNecesidad->id_item_necesidad_repuestos;
                        $lineaReingresoRepuestos->save();

                        //dd($lineaReingresoRepuestos->id_linea_reingreso_repuestos);
                        $movimiento->fuente_id = $lineaReingresoRepuestos->id_linea_reingreso_repuestos;
                        $movimiento->save();

                        if ($request->input("cant-" . $numRequest) < $itemNecesidad->getCantidadAprobada()) {
                            if (is_null($itemNecesidad->cantidad_pre_reingreso)) {
                                $itemNecesidad->cantidad_pre_reingreso = $itemNecesidad->getCantidadAprobada();
                            }
                            $itemNecesidad->cantidad_aprobada = $itemNecesidad->cantidad_aprobada - $request->input("cant-" . $numRequest);
                            $itemNecesidad->save();
                        } elseif ($request->input("cant-" . $numRequest) == $itemNecesidad->getCantidadAprobada()) {
                            $itemNecesidadRepuestosDeleted = new ItemNecesidadRepuestosDeleted();
                            $itemNecesidadRepuestosDeleted->id_item_necesidad_repuestos = $itemNecesidad->id_item_necesidad_repuestos;
                            $itemNecesidadRepuestosDeleted->numero_parte = $itemNecesidad->numero_parte;
                            $itemNecesidadRepuestosDeleted->id_repuesto = $itemNecesidad->id_repuesto;
                            $itemNecesidadRepuestosDeleted->margen = $itemNecesidad->margen;
                            $itemNecesidadRepuestosDeleted->descripcion_item_necesidad_repuestos = $itemNecesidad->descripcion_item_necesidad_repuestos;
                            $itemNecesidadRepuestosDeleted->cantidad_solicitada = $itemNecesidad->cantidad_solicitada;
                            $itemNecesidadRepuestosDeleted->cantidad_aprobada = $itemNecesidad->cantidad_aprobada;
                            $itemNecesidadRepuestosDeleted->descuento_unitario = $itemNecesidad->descuento_unitario;
                            $itemNecesidadRepuestosDeleted->descuento_unitario_dealer = $itemNecesidad->descuento_unitario_dealer;
                            $itemNecesidadRepuestosDeleted->descuento_unitario_dealer_por_aprobar = $itemNecesidad->descuento_unitario_dealer_por_aprobar;
                            $itemNecesidadRepuestosDeleted->descuento_unitario_dealer_aprobado = $itemNecesidad->descuento_unitario_dealer_aprobado;
                            $itemNecesidadRepuestosDeleted->cantidad_pre_ingreso = $itemNecesidad->cantidad_pre_ingreso;
                            $itemNecesidadRepuestosDeleted->fecha_pedido = $itemNecesidad->fecha_pedido;
                            $itemNecesidadRepuestosDeleted->fecha_codificacion = $itemNecesidad->fecha_codificacion;
                            $itemNecesidadRepuestosDeleted->fecha_promesa = $itemNecesidad->fecha_promesa;
                            $itemNecesidadRepuestosDeleted->es_importado = $itemNecesidad->es_importado;
                            $itemNecesidadRepuestosDeleted->fecha_registro = $itemNecesidad->fecha_registro;
                            $itemNecesidadRepuestosDeleted->entregado = $itemNecesidad->entregado;
                            $itemNecesidadRepuestosDeleted->fecha_entrega = $itemNecesidad->fecha_entrega;
                            $itemNecesidadRepuestosDeleted->fecha_registro_entrega = $itemNecesidad->fecha_registro_entrega;
                            $itemNecesidadRepuestosDeleted->id_movimiento_salida_virtual = $itemNecesidad->id_movimiento_salida_virtual;
                            $itemNecesidadRepuestosDeleted->id_movimiento_salida = $itemNecesidad->id_movimiento_salida;
                            $itemNecesidadRepuestosDeleted->id_necesidad_repuestos = $itemNecesidad->id_necesidad_repuestos;
                            $itemNecesidadRepuestosDeleted->save();
                            $itemNecesidad->delete();
                        }
                    }
                }
            }
            DB::commit();
            return route('hojaReingresoTaller', ['id_reingreso_repuestos' => $reingresoRepuestos->id_reingreso_repuestos]);
        } elseif ($request->motivoRelacionado == "DEVOLUCION") {

            DB::beginTransaction();
            $devolucion = new Devolucion();
            $devolucion->id_proveedor = Proveedor::where('num_doc', $request->input('rucProveedorSol'))->firstOrFail(['id_proveedor'])->id_proveedor;
            $devolucion->id_usuario = auth()->user()->id_usuario;
            $devolucion->nro_nota_credito = $request->nroNotaCredito;
            $devolucion->doc_referencia = $request->docReferencia;
            $devolucion->moneda = $request->moneda;
            $devolucion->fecha_devolucion = Carbon::createFromFormat('d/m/Y', $request->fechaMovimiento);
            $devolucion->motivo = $request->motivo;
            $devolucion->save();

            foreach ($requests as $key => $value) {
                //Obtenemos la posición del string ingresado para ver si existe el registro
                $pos_input = strpos($key, "descripcionLineaSolRep-");
                //Si es que lo encuentra, entonces también deben estar los demas campos relacionados a ese número de fila
                if ($pos_input !== false && $pos_input >= 0) {
                    //Obtenemos el número de registro
                    $numRequest = substr($key, $pos_input + strlen('descripcionLineaSolRep-'));
                    $codigoRepuesto = $request->input("descripcionLineaSolRep-" . $numRequest);
                    if (!is_null($repuesto = Repuesto::where('codigo_repuesto', $codigoRepuesto)->first())) {
                        $cantidad_movimiento = $request->input("cantidadLineaSolRep-" . $numRequest);
                        $movimiento = new MovimientoRepuesto();
                        $movimiento->id_repuesto = $repuesto->id_repuesto;
                        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
                        $movimiento->cantidad_movimiento = $cantidad_movimiento;
                        $movimiento->tipo_movimiento = 'EGRESO';
                        $movimiento->fuente_type = "App\Modelos\ItemDevolucion";

                        $movimiento->saldo = $this->balanceWithDevolution($repuesto->id_repuesto, $cantidad_movimiento);
                        $movimiento->costo = $this->getCostWithDevolucion($repuesto->id_repuesto);
                        $movimiento->saldo_dolares = $this->getSaldoDolaresEgreso($repuesto->id_repuesto, $cantidad_movimiento * $this->getCostWithDevolucion($repuesto->id_repuesto));

                        // $movimiento->motivo = 'DEVOLUCION';
                        $movimiento->motivo = 'DEVOLUCION';
                        $movimiento->fecha_movimiento = Carbon::now();
                        $movimiento->save();

                        $movimientoVirtual = new MovimientoRepuesto();
                        $movimientoVirtual->id_repuesto = $repuesto->id_repuesto;
                        $movimientoVirtual->id_local_empresa = Auth::user()->empleado->id_local;
                        $movimientoVirtual->cantidad_movimiento = $request->input("cantidadLineaSolRep-" . $numRequest);
                        $movimientoVirtual->tipo_movimiento = 'EGRESO VIRTUAL';
                        $movimientoVirtual->motivo = 'DEVOLUCION';
                        $movimientoVirtual->fecha_movimiento = Carbon::now();
                        $movimientoVirtual->save();

                        $item_devolucion = new ItemDevolucion();
                        $item_devolucion->cantidad_devolucion = $request->input("cantidadLineaSolRep-" . $numRequest);
                        $item_devolucion->id_movimiento_repuesto = $movimiento->id_movimiento_repuesto;
                        $item_devolucion->id_repuesto = $repuesto->id_repuesto;
                        $item_devolucion->id_devoluciones = $devolucion->id_devoluciones;
                        $item_devolucion->fecha_devolucion = Carbon::createFromFormat('d/m/Y', $request->fechaMovimiento);
                        $item_devolucion->costo_unitario = $request->input("costoUniLineaSolRep-" . $numRequest);
                        $item_devolucion->descuento_unitario = $request->input("descUniLineaSolRep-" . $numRequest);
                        $item_devolucion->id_movimiento_repuesto_virtual = $movimientoVirtual->id_movimiento_repuesto;
                        $item_devolucion->save();

                        $movimiento->fuente_id = $item_devolucion->id_item_devoluciones;
                        $movimiento->save();
                    }
                }
            }
            DB::commit();
            /* $rutaDescarga = route('hojaDevolucion', ['id_devoluciones' => $devolucion->id_devoluciones]); */
            return route('hojaDevolucion', ['id_devoluciones' => $devolucion->id_devoluciones]);
            /* ->with('rutaDescarga', $rutaDescarga)
            ->with('finalizado', 'DEVOLUCIÓN GENERADA'); */
        } elseif ($request->motivoRelacionado == "CTALLER") {
            DB::beginTransaction();
            $consumoTaller = new ConsumoTaller();
            $consumoTaller->usuario_solicitante = $request->usuarioSol;
            $consumoTaller->observaciones = $request->observaciones;
            $consumoTaller->fecha_registro = Carbon::createFromFormat('d/m/Y', $request->fechaMovimiento);
            $consumoTaller->id_usuario = auth()->user()->id_usuario;
            $consumoTaller->save();

            foreach ($requests as $key => $value) {
                //Obtenemos la posición del string ingresado para ver si existe el registro
                $pos_input = strpos($key, "descripcionLineaSolRep-");
                //Si es que lo encuentra, entonces también deben estar los demas campos relacionados a ese número de fila
                if ($pos_input !== false && $pos_input >= 0) {
                    //Obtenemos el número de registro
                    $numRequest = substr($key, $pos_input + strlen('descripcionLineaSolRep-'));
                    $codigoRepuesto = $request->input("descripcionLineaSolRep-" . $numRequest);
                    if (!is_null($repuesto = Repuesto::where('codigo_repuesto', $codigoRepuesto)->first())) {
                        $cantidad = $request->input("cantidadLineaSolRep-" . $numRequest);

                        $movimiento = new MovimientoRepuesto();
                        $movimiento->id_repuesto = $repuesto->id_repuesto;
                        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
                        $movimiento->cantidad_movimiento = $cantidad;
                        $movimiento->tipo_movimiento = 'EGRESO';
                        $movimiento->fuente_type = "App\Modelos\LineaConsumoTaller";
                        $movimiento->saldo = $this->balanceWithDevolution($repuesto->id_repuesto, $cantidad);
                        $movimiento->costo = $this->getCostWithDevolucion($repuesto->id_repuesto);
                        $movimiento->motivo = 'CONSUMO TALLER';
                        $movimiento->fecha_movimiento = Carbon::now();
                        $movimiento->saldo_dolares = $this->getSaldoDolaresEgreso($repuesto->id_repuesto, $cantidad * $this->getCostWithDevolucion($repuesto->id_repuesto));
                        $movimiento->save();

                        $movimientoVirtual = new MovimientoRepuesto();
                        $movimientoVirtual->id_repuesto = $repuesto->id_repuesto;
                        $movimientoVirtual->id_local_empresa = Auth::user()->empleado->id_local;
                        $movimientoVirtual->cantidad_movimiento = $cantidad;
                        $movimientoVirtual->tipo_movimiento = 'EGRESO VIRTUAL';
                        $movimientoVirtual->motivo = 'CONSUMO TALLER';
                        $movimientoVirtual->fecha_movimiento = Carbon::now();
                        $movimientoVirtual->save();

                        $linea_consumo_taller = new LineaConsumoTaller();
                        $linea_consumo_taller->cantidad = $cantidad;
                        $linea_consumo_taller->id_consumo_taller = $consumoTaller->id_consumo_taller;
                        $linea_consumo_taller->id_movimiento_salida = $movimiento->id_movimiento_repuesto;
                        $linea_consumo_taller->id_repuesto = $repuesto->id_repuesto;
                        $linea_consumo_taller->id_movimiento_virtual = $movimientoVirtual->id_movimiento_repuesto;
                        $linea_consumo_taller->save();

                        $movimiento->fuente_id = $linea_consumo_taller->id_linea_consumo_taller;
                        $movimiento->save();
                    }
                }
            }
            DB::commit();
            /* $rutaDescarga = route('hojaDevolucion', ['id_devoluciones' => $devolucion->id_devoluciones]); */
            return route('hojaConsumoTaller', ['id_consumo_taller' => $consumoTaller->id_consumo_taller]);
        }
    }


    public function downloadPDF()
    {

        $motivo = isset(request()->motivo) ? request()->motivo : false;

        $pdf = PDF::loadView('formatos.reingresos', [
            'motivo' => $motivo
        ])->setPaper('a4', 'portrait');

        return $pdf->stream();
    }

    private function getStock($id_repuesto)
    {
        $last_movimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento', '!=', "EGRESO VIRTUAL")->orderBy('fecha_movimiento', 'DESC')->first();

        return $last_movimiento != null ? $last_movimiento->saldo : 0;
    }

    private function getCosto($lineaNotaIngreso)
    {

        $date_register = $lineaNotaIngreso->notaIngreso->fecha_registro;

        $date = strtotime("+1 day", strtotime($date_register));
        $date = date("Y-m-d 00:00:00", $date);

        $cobro = TipoCambio::where('fecha_registro', '<', $date)->orderBy('fecha_registro', 'desc')->first();
        $cobro = $cobro->cobro;
        $current = $lineaNotaIngreso->lineaOrdenCompra->ordenCompra->tipo_moneda;
        //dd($current);
        if ($current == "DOLARES") {
            $costo_dolar = $lineaNotaIngreso->lineaOrdenCompra->precio;
            $costo_sol = $costo_dolar * $cobro;
        } else {

            $costo_sol = $lineaNotaIngreso->lineaOrdenCompra->precio;
            $costo_dolar = $costo_sol / $cobro;
        }

        return $costo_dolar;
    }

    private static function getCostoPromedioOnlyIngreso($id_repuesto, $ingreso, $costo_ingreso)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();

        if ($lastMovimiento == null) {
            return $costo_ingreso;
        } else if ($lastMovimiento->tipo_movimiento == "EGRESO") {
            $costo = (($ingreso * $costo_ingreso) + ($lastMovimiento->saldo * $lastMovimiento->costo)) / ($ingreso + $lastMovimiento->saldo);
            return round($costo, 4);
        } else if ($lastMovimiento->tipo_movimiento == "INGRESO") {
            $costo = (($ingreso * $costo_ingreso) + ($lastMovimiento->saldo * $lastMovimiento->costo_promedio_ingreso)) / ($ingreso + $lastMovimiento->saldo);
            return round($costo, 4);
        }
    }
    private static function balanceWithDevolution($id_repuesto, $cantidad_movimiento)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo - $cantidad_movimiento;
    }

    private static function balanceWithReEntry($id_repuesto, $cantidad_movimiento)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo + $cantidad_movimiento;
    }

    private static function getSaldoDolaresIngreso($id_repuesto, $ingreso_dolares)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();

        if ($lastMovimiento != null) {
            return $lastMovimiento->saldo_dolares + $ingreso_dolares;
        } else {
            return $ingreso_dolares;
        }
    }

    private static function getSaldoDolaresEgreso($id_repuesto, $egreso_dolares)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo_dolares - $egreso_dolares;
    }

    private static function getCostWithDevolucion($id_repuesto)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        if ($lastMovimiento->tipo_movimiento == "INGRESO") {
            return $lastMovimiento->costo_promedio_ingreso;
        } else {
            return $lastMovimiento->costo;
        }
    }
    public static function test()
    {
        return 212416524;
    }
}
