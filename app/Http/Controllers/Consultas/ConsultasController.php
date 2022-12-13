<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use App\Modelos\Cotizacion;
use App\Modelos\CotizacionMeson;
use App\Modelos\DetalleTrabajo;
use App\Modelos\Empleado;
use App\Modelos\HojaTrabajo;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\ItemNecesidadRepuestosDeleted;
use App\Modelos\LineaCotizacionMeson;
use App\Modelos\LineaReingresoRepuestos;
use App\Modelos\LocalEmpresa;
use App\Modelos\MarcaAuto;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\RecepcionOT;
use App\Modelos\Repuesto;
use App\Modelos\TipoCambio;
use App\Modelos\TipoOT;
use App\Modelos\Vehiculo;
use Carbon\Carbon;
use DateTime;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultasController extends Controller
{
    public function getHistoriaClinicaDetallesTrabajo($placa)
    {

        $detallesTrabajo = DetalleTrabajo::whereHas('hojaTrabajo', function ($query)
             use ($placa) {
                $query->where('placa_auto', $placa);
            })->has('hojaTrabajo.recepcionOT')->with(['hojaTrabajo.recepcionOT'])->get();

        return $detallesTrabajo;
    }

    public function getHistoriaClinicaDetallesTrabajoDoc($docum)
    {

        $detallesTrabajo = DetalleTrabajo::whereHas('hojaTrabajo', function ($query)
             use ($docum) {
                $query->where('doc_cliente', $docum);
            })->has('hojaTrabajo.recepcionOT')->with(['hojaTrabajo.recepcionOT'])->get();

        return $detallesTrabajo;
    }

    public function getHistoriaClinicaDetalleTrabajoVin($vin)
    {

        $detallesTrabajo = DetalleTrabajo::whereHas('hojaTrabajo.vehiculo', function ($query)
             use ($vin) {
                $query->where('vin', $vin);
            })->has('hojaTrabajo.recepcionOT')->with(['hojaTrabajo.recepcionOT'])->get();

        return $detallesTrabajo;
    }

    public function getHistoriaClinica($placa)
    {
        $placa = str_replace("-", "", $placa);
        $hojasTrabajo = HojaTrabajo::has('recepcionOT')->with(['recepcionOT', 'detallesTrabajo'])->where(
            'placa_auto',
            'LIKE',
            "%$placa%"
        )->get();

        return $hojasTrabajo;
    }

    public function getHistoriaClinicaDoc($docum)
    {
        $docum = str_replace("-", "", $docum);
        $hojasTrabajo = HojaTrabajo::has('recepcionOT')->with(['recepcionOT', 'detallesTrabajo'])->where(
            'doc_cliente',
            'LIKE',
            "%$docum%"
        )->get();

        return $hojasTrabajo;
    }

    public function consultaHistoriaClinica(Request $request)
    {
        //dd($request->all());
        $placa = $request->nroPlaca;
        $docum = $request->nroDoc;
        $vin = $request->nroVin;

        if ($placa) {
            $hojasTrabajo = $this->getHistoriaClinica($placa);

            $datosHistoria =
            HojaTrabajo::where('placa_auto', $placa)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
        } else if ($docum) {
            $hojasTrabajo = $this->getHistoriaClinicaDoc($docum);

            $datosHistoria =
            HojaTrabajo::where('doc_cliente', $docum)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
        } else if ($vin) {
            $varPlaca = Vehiculo::where('vin', $vin)->first()->placa;
            $hojasTrabajo = $this->getHistoriaClinica($varPlaca);
            $datosHistoria =
            HojaTrabajo::where('placa_auto', $varPlaca)->whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
            //print_r($datosHistoria);
            //print_r($hojasTrabajo);
            //return;
        } else {
            $hojasTrabajo = collect([]);
            $datosHistoria = HojaTrabajo::whereNotNull('id_recepcion_ot')->orderBy('fecha_registro', 'desc')->first();
        }

        return view('consultas.historiaClinica', [
            "listaHojasTrabajo" => $hojasTrabajo,
            "datosHistoria" => $datosHistoria,
            "refreshable" => false,
            "request" => $request->all(),
        ]);
    }

    public function getOrdenesTrabajo(Request $request)
    {

        $placa = str_replace("-", "", $request->nroPlaca);
        $nroDoc = $request->nroDoc;
        $nroOT = $request->nroOT;
        $id_marca = $request->marca;
        $dni_empleado = $request->asesor;
        $estadoOT = $request->estadoOT;
        $seccion = $request->seccion;
        $fechaIngresoIni = $request->fechaInicioIngreso;
        $fechaIngresoFin = $request->fechaFinIngreso;
        $fechaEntregaIni = $request->fechaInicioEntrega;
        $fechaEntregaFin = $request->fechaFinEntrega;
        $fechaCierreInicio = $request->fechaCierreInicio;
        $fechaCierreFin = $request->fechaCierreFin;

        $id_tipo_ot = $request->filtroTipoOT;
        $vin = $request->nroVIN;

        $hojasTrabajo = new RecepcionOT();

        $garantias_cerradas = [];

        if ($request->all() == []) {
            $hojasTrabajo = []; //$hojasTrabajo = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto']);
        } else {

            if ($placa) {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($placa) {
                    $query->where('placa_auto', 'LIKE', "%$placa%");
                });
            }

            if ($nroDoc) {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($nroDoc) {
                    $query->where('doc_cliente', 'LIKE', "%$nroDoc%");
                });
            }

            if ($nroOT) {
                $hojasTrabajo = $hojasTrabajo->where((new RecepcionOT)->getKeyName(), $nroOT);
            }

            if ($id_tipo_ot != 'all') {
                $hojasTrabajo = $hojasTrabajo->where('id_tipo_ot', $id_tipo_ot);
            }

            if ($id_marca && $id_marca != 'all') {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo.vehiculo.marcaAuto', function ($query) use ($id_marca) {
                    $query->where('id_marca_auto', $id_marca);
                });
            }

            if ($vin) {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo.vehiculo', function ($query) use ($vin) {
                    $query->where('vin', $vin);
                });
            }

            if ($dni_empleado && $dni_empleado != 'all') {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($dni_empleado) {
                    $query->where('dni_empleado', $dni_empleado);
                });
            }

            if ($seccion && $seccion != 'all') {
                $tiposTrabajo = ($seccion == 'MEC' ? ["PREVENTIVO", "CORRECTIVO"] : ["DYP"]);

                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($tiposTrabajo) {
                    $query->whereIn('tipo_trabajo', $tiposTrabajo);
                });
            }

            $garantia = TipoOT::where("nombre_tipo_ot", "like", "GARANT%")->get()->first()->id_tipo_ot;

            if ($estadoOT && $estadoOT != 'all') {
                switch ($estadoOT) {
                    case 'abiertas':
                        $hojasTrabajo = $hojasTrabajo->doesntHave('otCerrada')->doesntHave('entregas');

                        $hojasTrabajo = $hojasTrabajo->whereHas('estadosReparacion', function ($query) {
                            $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno', ['garantia_cerrado'])
                                ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
                        });

                        break;
                    case 'cerradas':

                        if ($id_tipo_ot != 'all' && (string) $id_tipo_ot === (string) $garantia) {
                            $hojasTrabajo = $hojasTrabajo->whereHas('estadosReparacion', function ($query) {
                                $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno', ['garantia_cerrado'])
                                    ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
                            });
                        } else {
                            if ($id_tipo_ot === 'all') {
                                $garantias_cerradas = $hojasTrabajo->whereHas('estadosReparacion', function ($query) {
                                    $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno', ['garantia_cerrado'])
                                        ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
                                });
                            }
                            $hojasTrabajo = $hojasTrabajo->has('otCerrada');
                        }

                        break;
                    case 'facturadas':

                        $hojasTrabajo = $hojasTrabajo->has('entregas');
                        break;
                    default:
                        break;
                }
            }

            if ($fechaIngresoIni) {
                $fechaIngresoIni = Carbon::createFromFormat('!d/m/Y', $fechaIngresoIni)->format('Y-m-d 00:00:00');
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($fechaIngresoIni) {
                    $query->where('fecha_recepcion', '>=', $fechaIngresoIni);
                });
            }

            if ($fechaIngresoFin) {
                $fechaIngresoFin = Carbon::createFromFormat('!d/m/Y', $fechaIngresoFin)->format('Y-m-d 23:59:59');
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($fechaIngresoFin) {
                    $query->where('fecha_recepcion', '<=', $fechaIngresoFin);
                });
            }

            if ($fechaEntregaIni) {
                $fechaEntregaIni = Carbon::createFromFormat('!d/m/Y', $fechaEntregaIni);

                $hojasTrabajo = $hojasTrabajo->whereHas('entregas', function ($query) use ($fechaEntregaIni) {
                    $query->where('fecha_entrega', '>=', $fechaEntregaIni);
                });
            }

            if ($fechaEntregaFin) {
                $fechaEntregaFin = Carbon::createFromFormat('!d/m/Y', $fechaEntregaFin);

                $hojasTrabajo = $hojasTrabajo->whereHas('entregas', function ($query) use ($fechaEntregaFin) {
                    $query->where('fecha_entrega', '<=', $fechaEntregaFin);
                });
            }

            if ($fechaCierreInicio) {

                $fechaCierreInicio = Carbon::createFromFormat('!d/m/Y', $fechaCierreInicio)->format('Y-m-d 00:00:00');

                if ($id_tipo_ot != 'all' && (string) $id_tipo_ot === (string) $garantia) {
                    $hojasTrabajo = $hojasTrabajo->where('fecha_nota_entrega', '>=', $fechaCierreInicio);
                } else {

                    if (is_a($garantias_cerradas, 'Illuminate\Database\Eloquent\Builder')) {
                        $garantias_cerradas = $garantias_cerradas->where('fecha_nota_entrega', '>=', $fechaCierreInicio);
                    }

                    $hojasTrabajo = $hojasTrabajo->whereHas('otCerrada', function ($query) use ($fechaCierreInicio) {
                        $query->where('fecha_registro', '>=', $fechaCierreInicio);
                    });
                }
            }

            if ($fechaCierreFin) {
                $fechaCierreFin = Carbon::createFromFormat('!d/m/Y', $fechaCierreFin)->format('Y-m-d 23:59:59');

                if ($id_tipo_ot != 'all' && (string) $id_tipo_ot === (string) $garantia) {
                    $hojasTrabajo = $hojasTrabajo->where('fecha_nota_entrega', '<=', $fechaCierreFin);
                } else {

                    if (is_a($garantias_cerradas, 'Illuminate\Database\Eloquent\Builder')) {
                        $garantias_cerradas = $garantias_cerradas->where('fecha_nota_entrega', '<=', $fechaCierreFin);
                    }

                    $hojasTrabajo = $hojasTrabajo->whereHas('otCerrada', function ($query) use ($fechaCierreFin) {
                        $query->where('fecha_registro', '<=', $fechaCierreFin);
                    });
                }
            }
        }

        if (is_a($garantias_cerradas, 'Illuminate\Database\Eloquent\Builder')) {
            $garantias_cerradas = $garantias_cerradas->get();
        }

        if ($hojasTrabajo) {
            // Illuminate\Database\Eloquent\Collection
            $ordenesTrabajo = $hojasTrabajo->get();
        } else {
            // Illuminate\Support\Collection
            $ordenesTrabajo = collect([]);
        }

        return $ordenesTrabajo->merge($garantias_cerradas);
    }

    public function consultaOrdenesTrabajo(Request $request)
    {
        $ordenesTrabajo = $this->getOrdenesTrabajo($request);
        $marcasVehiculo = MarcaAuto::all();
        $asesoresServicio = Empleado::all();
        $locales = LocalEmpresa::all();
        $tiposOT = TipoOT::where('habilitado', 1)->get();
        return view('consultas.ordenesTrabajo', [
            'listaOrdenesTrabajo' => $ordenesTrabajo,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores' => $asesoresServicio,
            'listaLocales' => $locales,
            'listaTiposOT' => $tiposOT,
            'request' => $request->all(),
            "refreshable" => false,
        ]);
    }

    public function getCotizaciones(Request $request)
    {
        $placa = str_replace("-", "", $request->nroPlaca);
        $nroCot = $request->nroCotizacion;
        $vin = $request->nroVIN;
        $nroDoc = $request->nroDoc;
        $nroOT = $request->nroOT;
        $id_marca = $request->marca;
        $dni_empleado = $request->asesor;
        $estadoOT = $request->estadoCotizacionTaller;
        // $estadoOT = $request->estadoOT;
        $seccion = $request->seccion;

        $start_date_creation = $request->fechaCreacionIni;
        $end_date_creation = $request->fechaCreacionFin;

        // $hojasTrabajo = new Cotizacion();
        $hojasTrabajo = Cotizacion::with("hojaTrabajo.empleado.local")
        // ->doesntHave('recepcionOT')
        ;

        if ($request->all() == []) {
            $hojasTrabajo = []; //$hojasTrabajo = Cotizacion::with(['hojaTrabajo.vehiculo.marcaAuto']);
        } else {
            if ($placa) {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($placa) {
                    $query->where('placa_auto', 'LIKE', "%$placa%");
                });
            }
            if ($vin) {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo.vehiculo', function ($query) use ($vin) {
                    $query->where('vin', $vin);
                });
            }

            if ($nroCot) {
                $hojasTrabajo = $hojasTrabajo->where('id_cotizacion', $nroCot);
            }

            if ($nroDoc) {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($nroDoc) {
                    $query->where('doc_cliente', 'LIKE', "%$nroDoc%");
                });
            }

            if ($nroOT) {
                $hojasTrabajo = $hojasTrabajo->where((new RecepcionOT)->getKeyName(), $nroOT);
            }

            if ($id_marca && $id_marca != 'all') {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo.vehiculo.marcaAuto', function ($query) use ($id_marca) {
                    $query->where('id_marca_auto', $id_marca);
                });
            }

            if ($dni_empleado && $dni_empleado != 'all') {
                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($dni_empleado) {
                    $query->where('dni_empleado', $dni_empleado);
                });
            }

            if ($estadoOT && $estadoOT != 'all') {
                //es_habilitado = 0;and ot vendida
                //es_habilitado = 1;pendiente
                //es_habilitado = 0;ot==null cerrado
                switch ($estadoOT) {
                    case 'vendida':
                        $hojasTrabajo = $hojasTrabajo->where('es_habilitado', '=', 0)->has('recepcionOT');
                        break;
                    case 'pendiente':
                        $hojasTrabajo = $hojasTrabajo->where('es_habilitado', '=', 1);
                        break;
                    case 'cerrada':
                        $hojasTrabajo = $hojasTrabajo->where('es_habilitado', '=', 0)->doesntHave('recepcionOT');
                        break;
                    default:
                        break;
                }
            }

            if ($seccion && $seccion != 'all') {
                $tiposTrabajo = ($seccion == 'MEC' ? ["PREVENTIVO", "CORRECTIVO"] : ["DYP"]);

                $hojasTrabajo = $hojasTrabajo->whereHas('hojaTrabajo', function ($query) use ($tiposTrabajo) {
                    $query->whereIn('tipo_trabajo', $tiposTrabajo);
                });
            }

            if ($start_date_creation) {
                $fechaCreacionInicio = Carbon::createFromFormat('!d/m/Y', $start_date_creation)->format('Y-m-d 00:00:00');
                $hojasTrabajo = $hojasTrabajo->where('fecha_registro', '>=', $fechaCreacionInicio);
            }

            if ($end_date_creation) {
                $fechaCreacionFin = Carbon::createFromFormat('!d/m/Y', $end_date_creation)->format('Y-m-d 23:59:59');
                $hojasTrabajo = $hojasTrabajo->where('fecha_registro', '<=', $fechaCreacionFin);
            }
        }

        if ($hojasTrabajo) {
            $cotizaciones = $hojasTrabajo
            // ->with("hojaTrabajo.empleado.local")
            ->get();
        } else {
            $cotizaciones = collect([]);
        }

        return $cotizaciones;
    }

    public function consultaCotizaciones(Request $request)
    {
        $cotizaciones = $this->getCotizaciones($request);
        // return $cotizaciones;
        $marcasVehiculo = MarcaAuto::all();
        $asesoresServicio = Empleado::whereHas('usuario', function ($query) {
            $query->whereIn('username', ['jnapuri', 'storrejon', 'asiancas', 'spacheco', 'cgomez']);
        })->get();
        $locales = LocalEmpresa::all();

        return view('consultas.cotizaciones', [
            'listaCotizaciones' => $cotizaciones,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores' => $asesoresServicio,
            'listaLocales' => $locales,
            'request' => $request->all(),
            "refreshable" => false,
        ]);
    }

    public function getRepuestosFilterResumen(Request $request)
    {
        $initDate = $request['fechaInicial'];
        $endDate = $request['fechaFinal'];

        $initDate = Carbon::createFromFormat('d/m/Y', $request['fechaInicial'])->format('Y-m-d 00:00:00');
        $endDate = Carbon::createFromFormat('d/m/Y', $request['fechaFinal'])->format('Y-m-d 23:59:00');

        $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();
        $locales = LocalEmpresa::all();

        $resultados = [];
        foreach ($locales as $taller) {
            $movimientoRepuestoSaldo = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->where('id_local_empresa', $taller->id_local)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->where('fecha_movimiento', '<', $initDate)->orderBy('fecha_movimiento', 'desc')->first();
            $saldo_inicial = 0;
            if ($movimientoRepuestoSaldo != null) {
                $saldo_inicial = $movimientoRepuestoSaldo->saldo;
            }
            $movimientoRepuesto = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->where('id_local_empresa', $taller->id_local)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->where('fecha_movimiento', '>=', $initDate)->where('fecha_movimiento', '<=', $endDate)->orderBy('fecha_movimiento', 'asc')->get();
            $ingresos = 0;
            $salidas = 0;
            foreach ($movimientoRepuesto as $row) {
                if ($row->tipo_movimiento == "INGRESO") {
                    $ingresos += $row->cantidad_movimiento;
                } else {
                    $salidas += $row->cantidad_movimiento;
                }
            }
            $date = Carbon::now()->format('Y-m-d H:i:s');
            $ultimoEgreso = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->where('id_local_empresa', $taller->id_local)->where('tipo_movimiento','EGRESO')->orderBy('fecha_movimiento', 'desc')->first();
            $ultimoIngreso = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->where('id_local_empresa', $taller->id_local)->where('tipo_movimiento','INGRESO')->orderBy('fecha_movimiento', 'desc')->first();
            $ultimoMovimiento = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->where('id_local_empresa', $taller->id_local)->where('tipo_movimiento','!=','EGRESO VIRTUAL')->orderBy('fecha_movimiento', 'desc')->first();
            
            $ultimoEgresoDate = $ultimoEgreso != null ? $ultimoEgreso->fecha_movimiento : '-';
            $ultimoIngresoDate = $ultimoIngreso != null ? $ultimoIngreso->fecha_movimiento : '-';
            $date= new DateTime($date);
            $diasSinMovimiento = $ultimoMovimiento!= null ?$date->diff(new DateTime($ultimoMovimiento->fecha_movimiento))->days: '-';
            
            $data = [
                'taller' => $taller->nombre_local,
                'saldo_inicial' => $saldo_inicial,
                'ingresos' => $ingresos,
                'salidas' => $salidas,
                'saldo_actual' => ($saldo_inicial + $ingresos - $salidas),
                'ubicacion' => $repuesto->ubicacion,
                'ultimo_ingreso' => $ultimoIngresoDate,
                'ultimo_egreso' => $ultimoEgresoDate,
                'dias_sin_movimiento' => $diasSinMovimiento,
                'icc' => '-'
            ];

            array_push($resultados, (object) $data);
        }
        return $resultados;
    }

    public function getRepuesto2(Request $request){
        $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();
        
        // $data = [
        //     'codigo_repuesto' => $row->movimientoSalidaVirtual->localEmpresa->nombre_local,
        //     'descripcion' => $row->movimientoSalidaVirtual->fecha_movimiento,
        //     'nombre_marca' => 'OT',
        //     'aplicacion_modelo' => $ot->getLinkDetalleHTML(),
        //     'nombre_categoria' => $row->movimientoSalidaVirtual->cantidad_movimiento,
        //     'costo_actual' =>,
        //     'ubicacion' =>,
        //     'nombre_local' =>,
        //     'saldo_fisico_actual'=>,
        //     ''
        // ];

    }

    public function getRepuestosFilterReservas(Request $request)
    {
        $initDate = $request['fechaInicial'];
        $endDate = $request['fechaFinal'];

        $initDate = Carbon::createFromFormat('d/m/Y', $request['fechaInicial'])->format('Y-m-d 00:00:00');
        $endDate = Carbon::createFromFormat('d/m/Y', $request['fechaFinal'])->format('Y-m-d 23:59:00');

        $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();
        $locales = LocalEmpresa::all();

        $resultados = [];
        // $itemNecesidadRepuestos = ItemNecesidadRepuestos::where('id_repuesto', $repuesto->id_repuesto)->whereNotNull('id_movimiento_salida_virtual')->whereNull('id_movimiento_salida')->whereHas('movimientoSalidaVirtual', function ($query) use ($initDate, $endDate) {
        //     $query->where('fecha_movimiento', '>=', $initDate)->where('fecha_movimiento', '<=', $endDate);
        // })->get();

        // $lineaCotizacionMeson = LineaCotizacionMeson::where('id_repuesto', $repuesto->id_repuesto)->whereNotNull('id_movimiento_salida_virtual')->whereNull('id_movimiento_salida')->whereHas('movimientoSalidaVirtual', function ($query) use ($initDate, $endDate) {
        //     $query->where('fecha_movimiento', '>=', $initDate)->where('fecha_movimiento', '<=', $endDate);
        // })->get();

        $itemNecesidadRepuestos = ItemNecesidadRepuestos::where('id_repuesto', $repuesto->id_repuesto)->whereNotNull('id_movimiento_salida_virtual')->whereNull('id_movimiento_salida')->get();

        $lineaCotizacionMeson = LineaCotizacionMeson::where('id_repuesto', $repuesto->id_repuesto)->whereNotNull('id_movimiento_salida_virtual')->whereNull('id_movimiento_salida')->get();

        foreach ($itemNecesidadRepuestos as $row) {
            $ot = RecepcionOT::find($row->idRecepcionOT());
            $data = [
                'taller' => $row->movimientoSalidaVirtual->localEmpresa->nombre_local,
                'fecha' => $row->movimientoSalidaVirtual->fecha_movimiento,
                'fuente' => 'OT',
                'num_fuente' => $ot->getLinkDetalleHTML(),
                'cantidad_reservada' => $row->movimientoSalidaVirtual->cantidad_movimiento,
            ];
            array_push($resultados, (object) $data);
        }

        foreach ($lineaCotizacionMeson as $row) {
            $data = [
                'taller' => $row->movimientoSalidaVirtual->localEmpresa->nombre_local,
                'fecha' => $row->movimientoSalidaVirtual->fecha_movimiento,
                'fuente' => 'COT-MESON',
                'num_fuente' => $row->cotizacionMeson->getLinkDetalleCotizacion(),
                'cantidad_reservada' => $row->movimientoSalidaVirtual->cantidad_movimiento,
            ];
            array_push($resultados, (object) $data);
        }
        return $resultados;
    }

    public function getCosto(){

    }
    public function getRepuestosFilterKardexLocal(Request $request)
    {
        $initDate = $request['fechaInicial'];
        $endDate = $request['fechaFinal'];

        $initDate = Carbon::createFromFormat('d/m/Y', $request['fechaInicial'])->format('Y-m-d 00:00:00');
        $endDate = Carbon::createFromFormat('d/m/Y', $request['fechaFinal'])->format('Y-m-d 23:59:00');

        $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();

        $id_local = 1;
        $resultados = [];

        $movimientoRepuestoSaldo = MovimientoRepuesto::where('id_repuesto',$repuesto->id_repuesto)->where('id_local_empresa', $id_local)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->where('fecha_movimiento', '<=', $initDate)->orderBy('fecha_movimiento', 'desc')->first();
        $total_cantidad_ingreso = 0;
        $total_cantidad_salida = 0;
        $total_costo_unitario = 0;

        $saldo_inicial = 0;
        $costo_unitario = 0;

        if ($movimientoRepuestoSaldo != null) {
            $saldo_inicial = $movimientoRepuestoSaldo->saldo;
            $costo_unitario = $movimientoRepuestoSaldo->costo;
            $data_inicial = [
                'fecha' => '',
                'fuente' => '',
                'num_fuente' => '',
                'motivo' => 'S.I.',
                'cantidad_ingreso' => '',
                'cantidad_salida' => '',
                'cantidad_saldo' => $saldo_inicial,
                'costo_unitario' => $costo_unitario,
            ];
        } else {
            $data_inicial = [
                'fecha' => '',
                'fuente' => '',
                'num_fuente' => '',
                'motivo' => 'S.I.',
                'cantidad_ingreso' => '',
                'cantidad_salida' => '',
                'cantidad_saldo' => $saldo_inicial,
                'costo_unitario' => $costo_unitario,
            ];
        }

        $total_cantidad_ingreso = $saldo_inicial;
        array_push($resultados, (object) $data_inicial);
        $movimientoRepuesto = MovimientoRepuesto::where('id_repuesto',$repuesto->id_repuesto)->where('id_local_empresa', $id_local)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->where('fecha_movimiento', '>=', $initDate)->where('fecha_movimiento', '<=', $endDate)->orderBy('fecha_movimiento', 'asc')->get();
        $ingresos = 0;
        $salidas = 0;
        foreach ($movimientoRepuesto as $row) {

            if ($row->motivo == "REINGRESO") {
                $fuente = LineaReingresoRepuestos::where('id_movimiento_reingreso', $row->id_movimiento_repuesto)->first();
            } else if ($row->fuente_type == "App\Modelos\ItemNecesidadRepuestosDeleted") {
                $fuente = ItemNecesidadRepuestosDeleted::where('id_movimiento_salida', $row->id_movimiento_repuesto)->first();
            } else {
                $fuente = $row->fuente;
            }
            if ($fuente == null) { //Si hay una linea borrada la salto Xd
                if($row->fuente_type == 'App\Modelos\ItemNecesidadRepuestos'){
                    $data_inicial = [
                        'fecha' => $row->fecha_movimiento,
                        'fuente' => 'OT',
                        'num_fuente' => 'anulada',
                        'motivo' => 'EGRESO',
                        'cantidad_ingreso' => 0,
                        'cantidad_salida' => $row->cantidad_movimiento,
                        'cantidad_saldo' => $saldo_inicial-$row->cantidad_movimiento,
                        'costo_unitario' => $row->costo,
                    ];
                    $saldo_inicial =  $saldo_inicial-$row->cantidad_movimiento;
                    $total_cantidad_salida+= $row->cantidad_movimiento;
                }else{
                    $data_inicial = [
                        'fecha' => '',
                        'fuente' => '',
                        'num_fuente' => '',
                        'motivo' => 'S.I.',
                        'cantidad_ingreso' => '',
                        'cantidad_salida' => '',
                        'cantidad_saldo' => $saldo_inicial+$row->cantidad_movimiento,
                        'costo_unitario' => $row->costo,
                    ];
                    $saldo_inicial =  $saldo_inicial+$row->cantidad_movimiento;
                    $total_cantidad_ingreso+= $row->cantidad_movimiento;
                    
                }
               
                $total_costo_unitario = $row->costo;
                array_push($resultados, (object) $data_inicial);
                continue;
            }
            $motivo = $fuente->motivo();
            $cantidad_ingreso = 0;
            $cantidad_salida = 0;
            if ($row->tipo_movimiento == 'INGRESO') {
                $cantidad_ingreso = $row->cantidad_movimiento;
            }
            if ($row->tipo_movimiento == 'EGRESO') {
                $cantidad_salida = $row->cantidad_movimiento;
            }
            $total_cantidad_ingreso+= $cantidad_ingreso;
            $total_cantidad_salida+= $cantidad_salida;
            $total_costo_unitario = $row->costo;
            $saldo_inicial = $saldo_inicial + $cantidad_ingreso - $cantidad_salida;
            $data = [
                'fecha' => $row->fecha_movimiento,
                'fuente' => $fuente->fuente(),
                'num_fuente' => $fuente->idFuente(),
                'motivo' => $motivo,
                'cantidad_ingreso' => $cantidad_ingreso,
                'cantidad_salida' => $cantidad_salida,
                'cantidad_saldo' => $saldo_inicial,
                'costo_unitario' => $row->costo,
            ];
// dd($data);
            array_push($resultados, (object) $data);
        }

        $data_final = [
            'fecha' => '',
            'fuente' => '',
            'num_fuente' => '',
            'motivo' => 'TOTAL',
            'cantidad_ingreso' => $total_cantidad_ingreso,
            'cantidad_salida' => $total_cantidad_salida,
            'cantidad_saldo' => $total_cantidad_ingreso-$total_cantidad_salida,
            'costo_unitario' => $total_costo_unitario,
        ];
        array_push($resultados, (object) $data_final);
        return $resultados;
    }

    public function getRepuestos(Request $request)
    {
        $tipo_cambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
        if (!$request->has('nroRepuesto')) {
            return collect([]);
        }
        $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();

        $ultimoMovimiento = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->where('tipo_movimiento', '!=', 'EGRESO VIRTUAL')->orderBy('fecha_movimiento','desc')->first();
        $precio_soles = 0;
        $precio_dolares = 0;
        if($repuesto->getPrecio(Carbon::now()) && $repuesto->getPrecio(Carbon::now())->getMoneda() === "SOLES"){
            $precio_soles = $repuesto->getPrecioUnitario(Carbon::now());
            $precio_dolares = $repuesto->getPrecioUnitario(Carbon::now()) / $tipo_cambio;
        }else{
            $precio_dolares = $repuesto->getPrecioUnitario(Carbon::now());
            $precio_soles = $repuesto->getPrecioUnitario(Carbon::now()) * $tipo_cambio;
        }

      

        $data = [
            'id_repuesto' => $repuesto->id_repuesto,
            'codigo_repuesto' => $request->nroRepuesto,
            'nombre_marca'=> $repuesto->marca!=null ? $repuesto->marca->nombre_marca: '-',
            'nombre_categoria'=> $repuesto->getNombreCategoria(),
            'ubicacion' => $repuesto->ubicacion,
            'descripcion' => $repuesto->descripcion,
            'nombre_local' => 'Los olivos',
            'moneda_pvp' => $repuesto->moneda_pvp,
            'pvp' => $repuesto->pvp,
            'saldo_actual' => $ultimoMovimiento!=null? $ultimoMovimiento->saldo:0,
            'precio_soles' => $precio_soles,
            'precio_dolares' => $precio_dolares
        ];
      

 
        $repuestos =[];
        array_push($repuestos, (object) $data);

        //dd($repuestos);
        return $repuestos;
    }
    
    public function consultaRepuestos(Request $request)
    {
        $repuestos = $this->getRepuestos($request);
        $tipo_cambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
        $resumen = [];
        $reservas = [];
        $kardex = [];
        $fecha = Carbon::now()->format('d/m/Y');
        $request['fechaFinal'] = $fecha;

        $repuesto = Repuesto::where('codigo_repuesto', $request->nroRepuesto)->first();
    
        $costo=0;
        $ultimoMovimiento =null;
        if($repuesto!=null){
            $ultimoMovimiento = MovimientoRepuesto::where('id_repuesto', $repuesto->id_repuesto)->orderBy('fecha_movimiento','desc')->first();

        }

        if($ultimoMovimiento!=null){
            $costo= $ultimoMovimiento->costo;
        }
        
        if ($request['fechaInicial'] != null && $request['fechaFinal'] != null) {
            $resumen = $this->getRepuestosFilterResumen($request);
            $reservas = $this->getRepuestosFilterReservas($request);
            $kardex = $this->getRepuestosFilterKardexLocal($request);
        }
        
        $codigo_repuesto = $request->nroRepuesto;
        $descripcion = $request->descripcion;
        

        return view('consultas.repuestos', [
            'listaRepuestos' => $repuestos,
            'request' => $request->all(),
            'refreshable' => false,
            'tipo_cambio' => $tipo_cambio,
            'resumen' => $resumen,
            'reservas' => $reservas,
            'kardex' => $kardex,
            'codigo_repuesto'=>$codigo_repuesto,
            'descripcion'=>$descripcion,
            'fecha_inicial' =>$request['fechaInicial'],
            'fecha_final' => $fecha,
            'costo' => $costo
        ]);
    }

    public function getConsultaMeson(Request $request)
    {
        $nroCotizacion = $request->nroCotizacion;
        $nroNV = $request->nroNV;
        $docCliente = $request->docCliente;
        $estadoCotizacionMeson = $request->estadoCotizacionMeson;

        $fechaAperturaIni = $request->fechaAperturaIni;
        $fechaAperturaFin = $request->fechaAperturaFin;
        $fechaFacturaIni = $request->fechaFacturaIni;
        $fechaFacturaFin = $request->fechaFacturaFin;

        $fechaCierreIni = $request->fechaCierreIni;
        $fechaCierreFin = $request->fechaCierreFin;

        $cotizacionMeson = CotizacionMeson::with(
            'lineasCotizacionMeson',
            'ventasMeson',
            'cliente',
            'usuarioRegistro',
            'descuentos',
            'ubigeo',
            'usuarioRegistro',
            'lineasCotizacionMeson.movimientoSalida'
        );

        if ($request->all() == []) {
            return [];
        } else {
            if ($nroCotizacion) {
                $cotizacionMeson = $cotizacionMeson->where('id_cotizacion_meson', $nroCotizacion);
            }

            if ($docCliente) {
                $cotizacionMeson = $cotizacionMeson->where('doc_cliente', $docCliente);
            }

            if ($nroNV) {
                $cotizacionMeson = $cotizacionMeson->whereHas('ventasMeson', function ($query) use ($nroNV) {
                    $query->where('id_venta_meson', 'LIKE', "$nroNV");
                });
            }

            if ($fechaAperturaIni && $fechaAperturaFin) {
               
                $fechaAperturaIni = Carbon::createFromFormat('!d/m/Y', $fechaAperturaIni);
                $fechaAperturaFin = Carbon::createFromFormat('!d/m/Y', $fechaAperturaFin);

                $cotizacionMeson = $cotizacionMeson->where('fecha_registro', '>=', $fechaAperturaIni);
                $cotizacionMeson = $cotizacionMeson->where('fecha_registro', '<=', $fechaAperturaFin);
            }

            if ($fechaFacturaIni && $fechaFacturaFin) {

                $fechaFacturaIni = Carbon::createFromFormat('!d/m/Y', $fechaFacturaIni);
                $fechaFacturaFin =  Carbon::createFromFormat('!d/m/Y', $fechaFacturaFin);

                $cotizacionMeson = $cotizacionMeson->whereHas('ventasMeson', function ($q) use ($fechaFacturaIni) {
                    $q->where('fecha_registro', ">=", $fechaFacturaIni);
                });
                $cotizacionMeson = $cotizacionMeson->whereHas('ventasMeson', function ($q) use ($fechaFacturaFin) {
                    $q->where('fecha_registro', "<=", $fechaFacturaFin);
                });
            }

            if ($fechaCierreIni && $fechaCierreFin) {

                $fechaCierreIni = Carbon::createFromFormat('!d/m/Y', $fechaCierreIni);
                $fechaCierreFin =  Carbon::createFromFormat('!d/m/Y', $fechaCierreFin);

                $cotizacionMeson = $cotizacionMeson->where('fecha_cierre', ">=", $fechaCierreIni);               
                $cotizacionMeson = $cotizacionMeson->where('fecha_cierre', "<=", $fechaCierreFin);
                
            }

            if ($estadoCotizacionMeson && $estadoCotizacionMeson != 'all') {
                $cotizacionMeson = $cotizacionMeson->get();
                $cotizacionMeson = $cotizacionMeson->filter(function ($value, $key) use ($estadoCotizacionMeson) {
                    return $value->consultaEstado() === $estadoCotizacionMeson;
                });

                return $cotizacionMeson;
            }
            return $cotizacionMeson->get();
        }
    }

    public function consultaMeson(Request $request)
    {

        $results = $this->getConsultaMeson($request);
        // return $results;

        return view('consultas.cotizacionMeson', [
            'listaCotizaciones' => $results,
            'request' => $request->all(),
            'refreshable' => false,
        ]);
    }
}
