<?php

namespace App\Http\Controllers\Repuestos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Modelos\Cliente;
use App\Modelos\Repuesto;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\CotizacionMeson;
use App\Modelos\LineaCotizacionMeson;
use App\Modelos\VentaMeson;
use App\Modelos\DescuentoMeson;
use App\Modelos\HojaTrabajo;
use App\Modelos\Ubigeo;
use App\Modelos\TipoCambio;
use App\Modelos\TrackDeletedTransactions;
use App\Modelos\ModeloTecnico;
use Auth;
use DB;

class MesonController extends Controller
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
        $estado = $request->estado;
        $nroCOT = isset($request->nroCOT) ? $request->nroCOT : false;
        $nroNV = isset($request->nroNV) ? $request->nroNV : false;
        $numDoc = isset($request->numDoc) ? $request->numDoc : false;
        $fechaInicioSolicitud = isset($request->fechaInicioSolicitud) ? Carbon::createFromFormat('d/m/Y', $request->fechaInicioSolicitud)->format('Y-m-d 00:00:00') : false;
        $fechaFinSolicitud = isset($request->fechaFinSolicitud) ? Carbon::createFromFormat('d/m/Y', $request->fechaFinSolicitud)->format('Y-m-d 23:59:59') : false;

        $cotizaciones = CotizacionMeson::where('es_cerrada', '!=', 1)->where(function ($query) {
            $query->whereDoesntHave('ventasMeson', function ($query) {
                $query->whereNotNull('fecha_venta')->whereNotNull('nro_factura');
            })->orWhere(function ($query) {
                $query->whereHas('ventasMeson', function ($query) {
                    $query->whereNotNull('fecha_venta')->whereNotNull('nro_factura');
                })->whereHas('lineasCotizacionMeson', function ($query) {
                    $query->where('es_atendido', 0)->where('es_entregado', 0);
                });
            });
        });

        if ($nroCOT) {
            $cotizaciones = $cotizaciones->where('id_cotizacion_meson', $nroCOT);
        }

        if ($nroNV) {
            $cotizaciones = $cotizaciones->whereHas('ventasMeson', function ($query) use ($nroNV) {
                $query->where('id_venta_meson', $nroNV);
            });
        }

        if ($numDoc) {
            $cotizaciones = $cotizaciones->whereHas('cliente', function ($query) use ($numDoc) {
                $query->where('num_doc', $numDoc);
            });
        }

        if ($fechaInicioSolicitud && $fechaFinSolicitud) {
            $cotizaciones = $cotizaciones->where('fecha_registro', '>=', $fechaInicioSolicitud);
            $cotizaciones = $cotizaciones->where('fecha_registro', '<=', $fechaFinSolicitud);
        } else if ($fechaInicioSolicitud) {
            $cotizaciones = $cotizaciones->where('fecha_registro', '>=', $fechaInicioSolicitud);
        } else if ($fechaFinSolicitud) {
            $cotizaciones = $cotizaciones->where('fecha_registro', '<=', $fechaFinSolicitud);
        }

        $cotizaciones = $cotizaciones->get();

        if ($estado != 'all' && $estado != null) {
            $cotizaciones = $cotizaciones->filter(function ($item) use ($estado) {
                return $item->getEstado() == $estado;
            });
        }

        return view('repuestos.mesonCotizaciones', ['listaCotizaciones' => $cotizaciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Ubigeo::departamentos();
        $modelosTecnicos = ModeloTecnico::all();
        return view('repuestos.mesonCrearCotizacion', [
            'refreshable' => false,
            'listaModelosTecnicos' => $modelosTecnicos,
            'listaDepartamentos' => $departamentos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $cliente = Cliente::find($request->nroDoc);
        // if(!$cliente){
        //     redirect()->back();
        // }
        if ($request->action == 'edit') {
            $cotizacion = CotizacionMeson::find($request->idCotizacionMeson);
        } else {
            $cotizacion = new CotizacionMeson();
            $cotizacion->tipo_cambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
        }
        $cotizacion->doc_cliente = $request->nroDoc;
        $cotizacion->nombre_cliente = $request->nombreCliente;
        $cotizacion->observaciones = $request->observaciones;
        $cotizacion->moneda = $request->moneda;
        $cotizacion->telefono_contacto = $request->telefono;
        $cotizacion->email_contacto = $request->correo;
        $cotizacion->direccion_contacto = $request->direccion;
        $cotizacion->id_modelo_tecnico = $request->modeloTecnico;

        if ($request->departamento && $request->provincia && $request->distrito) {
            $cotizacion->cod_ubigeo = $request->departamento . $request->provincia . $request->distrito;
        } else {
            $cotizacion->cod_ubigeo = null;
        }

        $cotizacion->id_usuario_registro = auth()->user()->id_usuario;
        $cotizacion->save();

        if ($cotizacion->doc_cliente && $cotizacion->nombre_cliente) {
            // $tipoDoc = strlen($cotizacion->doc_cliente) > 8 ? 'RUC' : 'DNI';
            $nombres = '';
            $apellido_pat = null;
            $apellido_mat = null;

            $tipoDoc = $request->modal_tipo_doc;
            if ($tipoDoc === 'RUC') {
                $nombres = $request->modal_cliente;
            } else {
                $nombres = $request->modal_nombres;
                $apellido_pat = $request->modal_apellido_pat;
                $apellido_mat = $request->modal_apellido_mat;
            }

            Cliente::saveCliente(
                $cotizacion->doc_cliente,
                $tipoDoc,
                $tipoDoc == 'RUC' ? 'EMPRESA' : 'NATURAL',
                $nombres,
                $apellido_pat,
                $apellido_mat,
                null,
                null,
                $cotizacion->direccion_contacto,
                $cotizacion->telefono_contacto,
                $cotizacion->email_contacto,
                $cotizacion->cod_ubigeo
            );
        }

        $requests = $request->all();


        if (isset($requests['descuento_unitario'])) {
            $array = $requests['descuento_unitario'];
            foreach ($array as $key => $row) {
                $lineaCot = LineaCotizacionMeson::find($key);
                if ($lineaCot->descuento_unitario != (float)$row['descuento_unitario']) {
                    $lineaCot->descuento_unitario_aprobado = null;
                }
                $lineaCot->descuento_unitario = $row['descuento_unitario'];

                $lineaCot->save();
            }
        }

        if (isset($requests['descuento_marca'])) {
            $array = $requests['descuento_marca'];
            foreach ($array as $key => $row) {
                $lineaCot = LineaCotizacionMeson::find($key);
                if ($lineaCot->descuento_marca != (float)$row['descuento_marca']) {
                    $lineaCot->descuento_marca_aprobado = null;
                }

                $lineaCot->descuento_marca = $row['descuento_marca'];

                $lineaCot->save();
            }
        }
        foreach ($requests as $key => $value) {
            $pos_input = strpos($key, "codigoRepuesto-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numRequest = substr($key, $pos_input + strlen('codigoRepuesto-'));
                $codigoRepuesto = $request->input("codigoRepuesto-" . $numRequest);

                $repuesto = Repuesto::where('codigo_repuesto', $codigoRepuesto)->first();

                $cantidadRepuesto = $request->input("cantidadLineaRepuesto-" . $numRequest) && $request->input("cantidadLineaRepuesto-" . $numRequest) > 0 ? $request->input("cantidadLineaRepuesto-" . $numRequest) : false;

                if ($repuesto) {

                    if (!$cantidadRepuesto) {
                        return redirect()->back()->with('errorCantidad', 'Ingrese una cantidad');
                    }

                    $idLocal = $cotizacion->getIdLocal();
                    $stockVirtual = $repuesto->getStockVirtual($idLocal);
                    $lineaCotizacion = new LineaCotizacionMeson();
                    $lineaCotizacion->margen = $repuesto->margen;
                    $lineaCotizacion->id_repuesto = $repuesto->id_repuesto;
                    $lineaCotizacion->cantidad = $request->input("cantidadLineaRepuesto-" . $numRequest);
                    if ($stockVirtual < $lineaCotizacion->cantidad) {
                        $lineaCotizacion->es_importado = 0;
                    }
                    $lineaCotizacion->id_cotizacion_meson = $cotizacion->id_cotizacion_meson;
                    $lineaCotizacion->es_mayoreo = $request->input("aplicaMayoreoLineaRepuesto-" . $numRequest) == 'on' ? 1 : 0;
                    $lineaCotizacion->es_importado = $request->input("esImportado-" . $numRequest) == 'on' ? 1 : 0;
                    //$lineaCotizacion->precio_unitario = $request->input("cantidadLineaRepuesto-".$numRequest);
                    if ($cotizacion->esVendido()) $lineaCotizacion->es_atendido = 0;
                    $lineaCotizacion->es_grupo = $repuesto->unidadGrupo ? 1 : 0;
                    $lineaCotizacion->save();
                }
            }


            $pos_input = strpos($key, "fechaPedido-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numLineaCot = substr($key, $pos_input + strlen('fechaPedido-'));
                $fechaInput = $request->input('fechaPedido-' . $numLineaCot);
                $fecha = null;
                if ($fechaInput && strlen($fechaInput) == 10) {
                    $fecha = Carbon::createFromFormat('!d/m/Y', $fechaInput);
                }
                $lineaCot = LineaCotizacionMeson::find($numLineaCot);
                $lineaCot->fecha_pedido = $fecha;
                $lineaCot->save();
            }

            $pos_input = strpos($key, "fechaPromesa-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numLineaCot = substr($key, $pos_input + strlen('fechaPromesa-'));
                $fechaInput = $request->input('fechaPromesa-' . $numLineaCot);
                $fecha = null;
                if ($fechaInput && strlen($fechaInput) == 10) {
                    $fecha = Carbon::createFromFormat('!d/m/Y', $fechaInput);
                }
                $lineaCot = LineaCotizacionMeson::find($numLineaCot);
                $lineaCot->fecha_promesa = $fecha;
                $lineaCot->save();
            }

            $pos_input = strpos($key, "importado-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numLinea = substr($key, $pos_input + strlen('importado-'));
                $lineaCot = LineaCotizacionMeson::find($numLinea);
                if ($request->input('importado-' . $numLinea) == "on") {
                    $lineaCot->es_importado = 1;
                } else {
                    $lineaCot->es_importado = 0;
                }
                $lineaCot->save();
            }



            $pos_input = strpos($key, "incluyeMayoreo-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numLinea = substr($key, $pos_input + strlen('incluyeMayoreo-'));
                $lineaCot = LineaCotizacionMeson::find($numLinea);
                if ($request->input('incluyeMayoreo-' . $numLinea) == "on") {
                    $lineaCot->es_mayoreo = 1;
                } else {
                    $lineaCot->es_mayoreo = 0;
                }
                $lineaCot->save();
            }

            $pos_input = strpos($key, "entregado-");
            if ($pos_input !== false && $pos_input >= 0) {
                $numLinea = substr($key, $pos_input + strlen('entregado-'));
                $lineaCot = LineaCotizacionMeson::find($numLinea);
                if ($request->input('entregado-' . $numLinea) == "on") {
                    $response = MovimientoRepuesto::generarEgresoVirtual($lineaCot->id_repuesto, $cotizacion->getIdLocal(), $lineaCot->cantidad,  "App\Modelos\LineaCotizacionMeson", $lineaCot->id_linea_cotizacion_meson);
                    if ($response) {
                        $lineaCot->es_atendido = true;
                        $lineaCot->fecha_atencion = Carbon::now();
                        $lineaCot->id_movimiento_salida_virtual = $response;
                    } else {
                        $lineaCot->es_atendido = false;
                    }
                }
                $lineaCot->save();
            }
        }
        return response()->json(['success' => true, 'route' => route('meson.show', $cotizacion->id_cotizacion_meson)]);
    }

    public function api()
    {

        $data = HojaTrabajo::all();
        return response()->json($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cotizacion = CotizacionMeson::find($id);
        $departamentos = Ubigeo::departamentos();
        $modelosTecnicos = ModeloTecnico::all();
        $provincias = [];
        $distritos = [];
        $ubigeo = $cotizacion->ubigeo;
        if ($ubigeo) {
            $provincias = Ubigeo::provinciasCod($ubigeo->getCodigoDepartamento());
            $distritos = Ubigeo::distritosCod($ubigeo->getCodigoDepartamento(), $ubigeo->getCodigoProvincia());
        }

        $cliente = Cliente::where('num_doc', $cotizacion->doc_cliente)->get()->first();


        $totalWithDiscountBrand = $cotizacion->getValueOnlyBrandDiscount();

        $totalWithAllDiscounts = $cotizacion->getValueDiscountedQuote2Approved();

        $totaldiscountUnit =  round($cotizacion->getValorCotizacion(), 2) - round($totalWithAllDiscounts, 2) - $totalWithDiscountBrand;
        $totalCotizacionSinDescuentos = $cotizacion->getValorCotizacion();

        $mostrarBoton = $this->validarReabrir($id);

        $repuestosCotizacion = LineaCotizacionMeson::where('id_cotizacion_meson', $cotizacion->id_cotizacion_meson)->orderBy('id_linea_cotizacion_meson', 'asc')->get();
        return view('repuestos.mesonDetalleCotizacion', [
            'cotizacion' => $cotizacion,
            'repuestosCotizacion' => $repuestosCotizacion,
            'listaDepartamentos' => $departamentos,
            'listaModelosTecnicos' => $modelosTecnicos,
            'listaProvincias' => $provincias,
            'listaDistritos' => $distritos,
            'mostrarBoton' => $mostrarBoton,
            'listaEliminados' => $cotizacion->getDeletedTransactions(),
            'refreshable' => false,
            'valorSinDescuento' => round($cotizacion->getValorCotizacion(), 2),
            'totalDiscountBrand' => round($totalWithDiscountBrand, 2),
            'totaldiscountUnit' => round($totaldiscountUnit, 2),
            'totalCotizacion' => round($totalWithAllDiscounts, 2),
            'estado_meson' => $cotizacion->getEstado(),
            'cliente' => $cliente
        ]);
    }

    public function reabrirCotizacion($id)
    {
        $reabrir = $this->validarReabrir($id);
        if (!$reabrir) return redirect()->route('meson.show', $id)->with('errorReabrir', 'Ya no se puede reabrir esta cotización');

        DB::beginTransaction();

        $movimientos_virtuales = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->get(['id_movimiento_salida_virtual']);

        foreach ($movimientos_virtuales as $movimiento) {
            $mov = $movimiento->id_movimiento_salida_virtual;
            if ($mov) {
                $movimiento_repuesto = MovimientoRepuesto::find($mov);
                $movimiento_repuesto->delete();
            }
        }

        $linea_cotizacion_meson = LineaCotizacionMeson::where('es_atendido', 1)
            ->where('es_entregado', 0)
            ->where('id_cotizacion_meson', $id)
            ->update(['id_movimiento_salida_virtual' => null]);

        $linea_cotizacion_meson = LineaCotizacionMeson::where('id_cotizacion_meson', $id)
            ->update(['es_atendido' => null, 'fecha_atencion' => null, 'es_importado' => null]);

        $venta_meson = VentaMeson::where('id_cotizacion_meson', $id)->delete();

        DB::commit();

        return redirect()->route('meson.show', $id)->with('successReabrir', 'La cotización se acaba de reabrir');
    }

    public function validarReabrir($id)
    {
        $reabrir = true;
        $venta_meson = VentaMeson::where('id_cotizacion_meson', $id)->get();

        if ($venta_meson->count() > 0) {
            $venta_meson = $venta_meson->first();
            if ($venta_meson->fecha_venta && $venta_meson->nro_factura) $reabrir = false;
        }

        if ($venta_meson->count() == 0) {
            $reabrir = false;
        }
        return $reabrir;
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

    public function eliminarRepuesto(Request $request)
    {
        $idLinea = $request->idLinea;
        $lineaCot = LineaCotizacionMeson::find($idLinea);
        if ($lineaCot->es_entregado != 1) {
            $this->saveTrackingDelete($lineaCot);
            if ($lineaCot) $lineaCot->delete();
        }

        return redirect()->back();
    }

    private function saveTrackingDelete($transaction)
    {
        $data = json_encode($transaction);
        $origen = "LineaCotizacionMeson";
        $id_contenedor_origen = $transaction->id_cotizacion_meson;
        $id_origen = $transaction->id_cotizacion_meson;
        $id_usuario_eliminador = Auth::user()->id_usuario;
        $name = Auth::user()->empleado->nombreCompleto();
        $description = "Repuesto con codigo " . $transaction->getCodigoRepuesto() . " eliminado por " . $name;

        $t = new TrackDeletedTransactions();
        $t->data = $data;
        $t->id_contenedor_origen = $id_contenedor_origen;
        $t->id_origen = $id_origen;
        $t->origen = $origen;
        $t->description = $description;
        $t->id_usuario_eliminador = $id_usuario_eliminador;
        $t->save();
    }

    public function cerrarCotizacion($id, Request $request)
    {
        $cotizacion = CotizacionMeson::find($id);
        $cotizacion->es_cerrada = 1;
        $cotizacion->fecha_cierre = Carbon::now();
        $cotizacion->razon_cierre = $request->razonCierre;
        $cotizacion->save();

        return redirect()->route('meson.index');
    }

    public function venderCotizacion($id)
    {
        DB::beginTransaction();
        $cotizacion = CotizacionMeson::find($id);
        $idLocal = $cotizacion->getIdLocal();

        foreach ($cotizacion->lineasCotizacionMeson as $lineaCotizacion) {

            $stockVirtual = $lineaCotizacion->repuesto->getStockVirtual($idLocal);
            $cantidadIngresada = $lineaCotizacion->cantidad;

            if (!$lineaCotizacion->es_atendido) {
                if ($stockVirtual >= $cantidadIngresada || $stockVirtual == 0) {
                    $response = MovimientoRepuesto::generarEgresoVirtual($lineaCotizacion->id_repuesto, $idLocal, $cantidadIngresada, "App\Modelos\LineaCotizacionMeson", $lineaCotizacion->id_linea_cotizacion_meson);

                    if ($response) {
                        $lineaCotizacion->es_atendido = true;
                        $lineaCotizacion->fecha_atencion = Carbon::now();
                        $lineaCotizacion->id_movimiento_salida_virtual = $response;
                    } else {
                        $lineaCotizacion->es_atendido = false;
                    }

                    $lineaCotizacion->save();
                } else {
                    $lineaCotizacion->cantidad = $stockVirtual;

                    $response = MovimientoRepuesto::generarEgresoVirtual($lineaCotizacion->id_repuesto, $idLocal, $stockVirtual, "App\Modelos\LineaCotizacionMeson", $lineaCotizacion->id_linea_cotizacion_meson);
                    // dd('reponse',$response);
                    if ($response) {
                        $lineaCotizacion->es_atendido = true;
                        $lineaCotizacion->fecha_atencion = Carbon::now();
                        $lineaCotizacion->id_movimiento_salida_virtual = $response;
                    } else {
                        $lineaCotizacion->es_atendido = false;
                    }

                    $lineaCotizacion->save();

                    $cantidadEnTransito = $cantidadIngresada - $stockVirtual;

                    $lineaCotizacion2 = new LineaCotizacionMeson();
                    $lineaCotizacion2->id_repuesto = $lineaCotizacion->id_repuesto;
                    $lineaCotizacion2->cantidad = $cantidadEnTransito;
                    $lineaCotizacion2->es_importado = 0;
                    $lineaCotizacion2->id_cotizacion_meson = $cotizacion->id_cotizacion_meson;
                    $lineaCotizacion2->es_mayoreo = $lineaCotizacion->es_mayoreo;
                    $lineaCotizacion2->descuento_unitario_aprobado = $lineaCotizacion->descuento_unitario_aprobado;
                    $lineaCotizacion2->descuento_marca = $lineaCotizacion->descuento_marca;
                    $lineaCotizacion2->descuento_marca_aprobado = $lineaCotizacion->descuento_marca_aprobado;
                    $lineaCotizacion2->descuento_unitario_dealer_por_aprobar = $lineaCotizacion->descuento_unitario_dealer_por_aprobar;
                    $lineaCotizacion2->descuento_unitario = $lineaCotizacion->descuento_unitario;
                    $lineaCotizacion2->fecha_registro_aprobacion_rechazo_descuento = $lineaCotizacion->fecha_registro_aprobacion_rechazo_descuento;
                    //$lineaCotizacion->precio_unitario = $request->input("cantidadLineaRepuesto-".$numRequest);                        
                    $lineaCotizacion2->es_grupo = $lineaCotizacion->es_grupo;
                    $lineaCotizacion2->save();
                }
            }
        }

        $ventaMeson = new VentaMeson();
        $ventaMeson->id_cotizacion_meson = $cotizacion->id_cotizacion_meson;
        $ventaMeson->save();
        DB::commit();

        return redirect()->back();
    }

    public function registrarDescuento(Request $request)
    {
        $idCotizacion = $request->idCotizacion;
        $cotizacion = CotizacionMeson::find($idCotizacion);
        if ($cotizacion) {
            $descuento = new DescuentoMeson();
            $descuento->id_cotizacion_meson = $cotizacion->id_cotizacion_meson;
            if ($request->porcentajeSolicitadoLubricantes !== null && $request->porcentajeSolicitadoLubricantes !== '')
                $descuento->porcentaje_solicitado_lubricantes = $request->porcentajeSolicitadoLubricantes;

            if ($request->porcentajeSolicitadoRptos !== null && $request->porcentajeSolicitadoRptos !== '')
                $descuento->porcentaje_solicitado_rptos = $request->porcentajeSolicitadoRptos;

            $descuento->id_usuario_solicitante = Auth::user()->id_usuario;
            $descuento->save();
        }
        return redirect()->route('meson.show', $idCotizacion);
    }


    public function aprobarDescuento(Request $request)
    {
        $sql = "UPDATE descuento_meson SET es_aprobado = 0 WHERE id_cotizacion_meson = ";
        if ($request->id_descuento) {
            $descuento = DescuentoMeson::find($request->id_descuento);
            $id_cotizacion_meson = $descuento->id_cotizacion_meson;
            $sql = $sql . $id_cotizacion_meson;
            DB::statement($sql);
            $descuento->es_aprobado = 1;
            $descuento->id_usuario_respuesta = Auth::user()->id_usuario;
            $descuento->save();
        }

        return redirect()->route('descuentos.index');
    }
    private function disapproveAccumulatedDiscount($id_cotizacion_meson)
    {

        $descuentoMeson = DescuentoMeson::where('id_cotizacion_meson', $id_cotizacion_meson)->first();
        if (isset($descuentoMeson)) {
            $descuentoMeson->es_aprobado = false;
            $descuentoMeson->save();
        }
    }

    private function createAccomulatedDiscount($id_cotizacion_meson)
    {
        $descuentoMeson = DescuentoMeson::where('id_cotizacion_meson', $id_cotizacion_meson)->first();
        $cotizacionMeson = CotizacionMeson::find($id_cotizacion_meson);
        // cambiar id usuario solicitante respuesta al igual que las ffechas por los respectivos
        //dd($descuentoMeson);
        if (isset($descuentoMeson)) {
            $descuentoMeson->porcentaje_solicitado_rptos = $cotizacionMeson->getTotalPercentajeDiscountApplied();
            $descuentoMeson->porcentaje_solicitado_lubricantes = $cotizacionMeson->getTotalPercentajeDiscountApplied();
            $descuentoMeson->es_aprobado = true;
            $descuentoMeson->id_usuario_solicitante = Auth::user()->id_usuario;
            $descuentoMeson->id_usuario_respuesta = Auth::user()->id_usuario;
            $descuentoMeson->fecha_registro = Carbon::now();
            $descuentoMeson->fecha_respuesta = Carbon::now();
            $descuentoMeson->save();
        } else {
            $descuentoMeson = new DescuentoMeson();
            $descuentoMeson->id_Cotizacion_meson = $id_cotizacion_meson;
            $descuentoMeson->porcentaje_solicitado_rptos = $cotizacionMeson->getTotalPercentajeDiscountApplied();
            $descuentoMeson->porcentaje_solicitado_lubricantes = $cotizacionMeson->getTotalPercentajeDiscountApplied();
            $descuentoMeson->es_aprobado = true;
            $descuentoMeson->id_usuario_solicitante = Auth::user()->id_usuario;
            $descuentoMeson->id_usuario_respuesta = Auth::user()->id_usuario;
            $descuentoMeson->fecha_registro = Carbon::now();
            $descuentoMeson->fecha_respuesta = Carbon::now();
            $descuentoMeson->save();
        }
    }

    public function aprobarTodosDescuentoUnitarios(Request $request)
    {
        $id_cotizacion_meson = $request->id_cotizacion_meson;
        $date_now = Carbon::now();
        $sql = "UPDATE linea_cotizacion_meson SET descuento_unitario_aprobado = 1, descuento_unitario = descuento_unitario_dealer_por_aprobar , descuento_unitario_dealer_por_aprobar=null, fecha_registro_aprobacion_rechazo_descuento='";
        $sql = $sql . $date_now . "'  WHERE id_cotizacion_meson = ";
        $sql = $sql . $id_cotizacion_meson;
        DB::statement($sql);
        //Descomentar la linea si se desea obtner un descuento acumulado en la tabla DescuentoMeson
        //$this->createAccomulatedDiscount($id_cotizacion_meson);
        return redirect()->route('descuentos.meson');
    }

    public function rechazarTodosDescuentoUnitarios(Request $request)
    {
        $id_cotizacion_meson = $request->id_cotizacion_meson;
        $date_now = Carbon::now();
        $sql = "UPDATE linea_cotizacion_meson SET descuento_unitario_aprobado = 0, descuento_unitario_dealer_por_aprobar=null, fecha_registro_aprobacion_rechazo_descuento= '";
        $sql = $sql . $date_now . "'  WHERE id_cotizacion_meson = ";
        $sql = $sql . $id_cotizacion_meson;
        DB::statement($sql);
        $this->disapproveAccumulatedDiscount($id_cotizacion_meson);
        return redirect()->route('descuentos.meson');
    }


    public function rechazarDescuento(Request $request)
    {
        if ($request->id_descuento) {
            $descuento = DescuentoMeson::find($request->id_descuento);
            $descuento->es_aprobado = 0;
            $descuento->id_usuario_respuesta = Auth::user()->id_usuario;
            $descuento->save();
        }

        return redirect()->route('descuentos.index');
    }

    public function entregarVentaCotizacion(Request $request)
    {

        $repuestosAsociados = LineaCotizacionMeson::where('id_cotizacion_meson', $request->id_cotizacion_meson)->get();

        $validarRepuestosReservados = true;
        foreach ($repuestosAsociados as $repuesto) {
            if ($repuesto->getDisponibilidadRepuestoText() != 'RESERVADO') $validarRepuestosReservados = false;
        }

        if (!$validarRepuestosReservados) {
            return [
                'status' => 'error',
                'message' => 'No todos sus repuestos asociados están reservados'
            ];
        }

        DB::beginTransaction();
        $cotizacion = CotizacionMeson::find($request->id_cotizacion_meson);
        if (!$cotizacion) return null;
        $count = 0;
        foreach ($cotizacion->ventasMeson as $ventaCotizacion) {
            $ventaCotizacion->fecha_venta = Carbon::createFromFormat('d/m/Y', $request->fechaEntrega);
            $ventaCotizacion->nro_factura = $request->nroFactura;
            $ventaCotizacion->fecha_registro_factura = Carbon::now();
            $ventaCotizacion->save();
            $count++;
        }

        foreach ($cotizacion->lineasCotizacionMeson as $lineaCotizacion) {
            if (!$lineaCotizacion->es_entregado) {

                $response = MovimientoRepuesto::generarEgresoFisico($lineaCotizacion->id_repuesto, $cotizacion->getIdLocal(), $lineaCotizacion->getCantidadRepuesto(), "App\Modelos\LineaCotizacionMeson", $lineaCotizacion->id_linea_cotizacion_meson);
                $lineaCotizacion->es_entregado = 1;
                $lineaCotizacion->fecha_entrega = Carbon::now();
                $lineaCotizacion->fecha_registro_entrega = Carbon::now();
                $lineaCotizacion->id_movimiento_salida = $response;
                $lineaCotizacion->save();
            }
        }
        DB::commit();

        return redirect()->route('entrega.index');
    }


    public function saveDescuento($id)
    {

        if (isset(request()->descuento_unitario) && !is_numeric(request()->descuento_unitario)) {
            return redirect()->back()->with('errorNumero', 'Ingrese solo número, porfavor');
        }

        $descuento = isset(request()->descuento_unitario) && request()->descuento_unitario > 0 ? request()->descuento_unitario : 0;

        $lineaCotizacionMeson = LineaCotizacionMeson::findOrFail($id);
        $lineaCotizacionMeson->descuento_unitario = $descuento;
        $lineaCotizacionMeson->save();

        return redirect()->back();
    }




    public function sendDiscountRequest(Request $request)
    {

        $id_cotizacion = $request->input("idCotizacion");
        $lineasCotizacion = LineaCotizacionMeson::where('id_cotizacion_meson', $id_cotizacion)->get();

        foreach ($lineasCotizacion as $linea_Cotizacion_meson) {
            $spare_discount =  $request->input("spare-" . $linea_Cotizacion_meson->id_linea_cotizacion_meson);

            if ($linea_Cotizacion_meson->repuesto->esLubricante() && $spare_discount == null) {
                $linea_Cotizacion_meson->descuento_unitario_dealer_por_aprobar = $request->input('porcentajeSolicitadoLubricantes');
            } else if (!$linea_Cotizacion_meson->repuesto->esLubricante() && $spare_discount == null) {
                $linea_Cotizacion_meson->descuento_unitario_dealer_por_aprobar = $request->input('porcentajeSolicitadoRepuestos');
            } else {
                $linea_Cotizacion_meson->descuento_unitario_dealer_por_aprobar = $spare_discount;
            }



            $linea_Cotizacion_meson->descuento_unitario_aprobado = null;

            $linea_Cotizacion_meson->save();
        }

        return redirect()->back();
    }



    public function sendBrandDiscountRequest(Request $request)
    {
        $id_cotizacion = $request->input("idCotizacion");

        $lineasCotizacion = LineaCotizacionMeson::where('id_cotizacion_meson', $id_cotizacion)->get();

        foreach ($lineasCotizacion as $linea_Cotizacion_meson) {
            $brand_discount =  $request->input("brand-" . $linea_Cotizacion_meson->id_linea_cotizacion_meson);
            $linea_Cotizacion_meson->descuento_marca = $brand_discount;
            $linea_Cotizacion_meson->descuento_marca_aprobado = 1;
            $linea_Cotizacion_meson->save();
        }

        return redirect()->back();
    }
}
