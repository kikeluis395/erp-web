<?php

namespace App\Http\Controllers\CarroceriaPintura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\PrecioDYP;
use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\ModeloTecnico;
use App\Modelos\CiaSeguro;
use App\Modelos\TecnicoReparacion;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Cotizacion;
use App\Modelos\Empleado;
use App\Modelos\Semaforo;
use App\Modelos\Cliente;
use App\Modelos\Vehiculo;
use App\Modelos\Modelo;
use App\Modelos\Ubigeo;
use App\Modelos\ServicioTerceroSolicitado;
use App\Modelos\ServicioTercero;
use App\Modelos\OTCerrada;
use App\Modelos\Proveedor;
use Carbon\Carbon;
use App\Modelos\TipoCambio;
// use Auth;
use Mail;
use App\Modelos\TrackDeletedTransactions;
use Illuminate\Support\Facades\Auth;

class RecepcionController extends Controller
{
    public static $lista_estancia = ["<15", "15-30", "30-60", "60-90", ">90"];

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
        $hojasTrabajo = HojaTrabajo::all();
        $id_rol_usuario = Auth::user()->id_rol;

        if ($request->all() == []) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $recepciones_ots_pre = RecepcionOT::with(['hojaTrabajo.vehiculo.marcaAuto', 'ciaSeguro']);
        } else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-", "", $request->nroPlaca);
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;
            $id_estado = $request->estado;
            $id_marca = $request->marca;
            $id_seguro = $request->seguro;
            $id_tipo_ot = $request->filtroTipoOT;
            $dni_empleado = $request->asesor;

            $numero_modelo = $request->modelo;
            $nombre_modelo = $request->nombre_modelo;
            $vin_code = $request->vin_code;

            $recepciones_ots_pre = new RecepcionOT();

            if (isset($nroDoc) && $nroDoc) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) use ($nroDoc) {
                    $query->where('doc_cliente', 'LIKE', "$nroDoc%");
                });
            }

            if (isset($placa) && $placa) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) use ($placa) {
                    $query->where('placa_auto', 'LIKE', "%$placa%");
                });
            }

            if (isset($nroOT) && $nroOT) {
                $recepciones_ots_pre = $recepciones_ots_pre->where((new RecepcionOT)->getKeyName(), $nroOT);
            }

            if ($id_estado != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion', function ($query) use ($id_estado) {
                    //URGENTE: esta solucion solo debe ser temporal, no se debe usar el nombre absoluto de la tabla
                    $query->where('estado_reparacion.nombre_estado_reparacion_filtro', '=', $id_estado)
                        ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
                });
            }

            if ($id_marca != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.vehiculo.marcaAuto', function ($query) use ($id_marca) {
                    $query->where('id_marca_auto', '=', $id_marca);
                });

                if (!is_null($numero_modelo) && $numero_modelo != '0' && $numero_modelo != '-') {
                    $name_model = Modelo::find($numero_modelo)->nombre_modelo;
                    if (!is_null($name_model)) {
                        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.car', function ($query) use ($name_model) {
                            $query->where('modelo', '=', $name_model);
                        });
                    }
                } else if (!is_null($nombre_modelo)) {
                    $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.car', function ($query) use ($nombre_modelo) {
                        $query->where('modelo', '=', $nombre_modelo);
                    });
                }
            }
            if ($id_marca == "all" && !is_null($numero_modelo) && $numero_modelo != '0' && $numero_modelo != '-') {

                $name_model = Modelo::find($numero_modelo)->nombre_modelo;
                if (!is_null($name_model)) {
                    $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.car', function ($query) use ($name_model) {
                        $query->where('modelo', '=', $name_model);
                    });
                }
            }

            if (!is_null($vin_code)) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.vehiculo', function ($query) use ($vin_code) {
                    $query->where('vin', 'like', $vin_code);
                });
            }

            if ($id_seguro != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->where('id_cia_seguro', $id_seguro);
            }

            if ($id_tipo_ot != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->where('id_tipo_ot', '=', $id_tipo_ot);
            }
            if ($dni_empleado != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) use ($dni_empleado) {
                    $query->where('dni_empleado', '=', $dni_empleado);
                });
            }
        }
        // return $recepciones_ots_pre->with('hojaTrabajo.vehiculo')->get();


        /* Si el usuario no es ni jefe ni administrador ni jefe, solo se visualizaran las OTs correspondientes al empleado */
        // CAMBIO 0301: TODOS PUEDEN VER LO DE TODOS
        // if(!in_array($id_rol_usuario,[1,6 ,8,10,11,12,13,14])){
        //     $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query){
        //         $query->where('dni_empleado','=',Auth::user()->dni);
        //     });
        // }

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion', function ($query) {
            $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno', ['entregado', 'entregado_pt', 'entregado_hotline'])
                ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
        });

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) {
            $query->where('tipo_trabajo', 'DYP');
        });

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion', function ($query) {
            $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno', ['cerrado', 'entregado', 'entregado_pt', 'entregado_hotline', 'garantia_cerrado', 'garantia_facturada'])
                ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
        });

        $lista_recepciones_ots = $recepciones_ots_pre->get();
        /*Aquí las operaciones que ya no puedan realizarse con Eloquent */
        $color_filtro = $request->filtroSemaforo;
        if ($color_filtro && $color_filtro != 'all') {
            $lista_recepciones_ots = $lista_recepciones_ots->filter(function ($value, $key) use ($color_filtro) {
                return $value->colorSemaforo() == $color_filtro;
            });
        }

        $filtro_estancia = $request->filtroEstancia;
        if (isset($filtro_estancia) && $filtro_estancia != 'all') {
            if (is_numeric($filtro_estancia) && $filtro_estancia >= 0 && $filtro_estancia < sizeof($lista_estancia)) {
                $rango_estancia = $lista_estancia[$filtro_estancia];
                $lista_recepciones_ots = $lista_recepciones_ots->filter(function ($value, $key) use ($rango_estancia) {
                    return $value->perteneceTiempoEstancia($rango_estancia);
                });
            }
        }

        $recepciones_ots = $lista_recepciones_ots->sortBy(function ($recepcionOT) {
            return $recepcionOT->getHojaTrabajo()->fecha_recepcion;
        });

        $colores = array_unique(array_column(Semaforo::all('color_css')->toArray(), 'color_css'));
        $tiposOT = TipoOT::getAll('DYP');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno', ['entregado', 'entregado_pt', 'entregado_hotline', 'espera_traslado'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        $empleados = Empleado::whereHas('usuario', function ($query) {
            $query->whereHas('rol', function ($q) {
                $q->whereIn('nombre_interno', ['asesor_servicios', 'jefe_taller']);
            });
        })->orderBy('primer_apellido')->get(); //SE DEBE CAMBIAR PARA QUE SOLO SE VEA LOS DE SERVICIO
        $departamentos = Ubigeo::departamentos();
        $listaTecnicos = TecnicoReparacion::all();
        $tiposTrabajo = [(object) ['id' => 'DYP', 'nombre' => 'DYP']];
        $listaModelos = Modelo::all();

        return view('recepcion', [
            'departamento' => 'DYP',
            'listaRecepciones' => $hojasTrabajo,
            'listaRecepcionesOTs' => $recepciones_ots,
            'listaTiposOT' => $tiposOT,
            'listaMarcas' => $marcasAuto,
            'listaSeguros' => $seguros,
            'listaEstados' => $estados,
            'listaAsesores' => $empleados,
            'listaColores' => $colores,
            'listaEstancia' => $lista_estancia,
            'listaTecnicos' => $listaTecnicos,
            'listaTiposTrabajo' => $tiposTrabajo,
            'listaDepartamentos' => $departamentos,
            'listaProvincias' => [],
            'listaDistritos' => [],
            'listaModelos' => $listaModelos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiposOT = TipoOT::getAll('DYP');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $modelosTecnicos = ModeloTecnico::all();
        $modelos = Modelo::orderBy('nombre_modelo')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno', ['entregado', 'entregado_pt', 'entregado_hotline', 'espera_traslado'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        $empleados = Empleado::orderBy('primer_apellido')->get(); //SE DEBE CAMBIAR PARA QUE SOLO SE VEA LOS DE SERVICIO
        $departamentos = Ubigeo::departamentos();
        $tiposTrabajo = [(object) ['id' => 'DYP', 'nombre' => 'DYP']];

        return view('crearOT', [
            'departamento' => 'DYP',
            'listaTiposOT' => $tiposOT,
            'listaMarcas' => $marcasAuto,
            'listaModelosTecnicos' => $modelosTecnicos,
            'listaModelos' => $modelos,
            'listaSeguros' => $seguros,
            'listaEstados' => $estados,
            'listaAsesores' => $empleados,
            'listaTiposTrabajo' => $tiposTrabajo,
            'listaDepartamentos' => $departamentos,
            'listaProvincias' => [],
            'listaDistritos' => [],
            'refreshable' => false,
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
        if ($request->id_recepcion_ot) {
            //En caso se edite una recepcion
            $preRecepcionOT = RecepcionOT::find($request->id_recepcion_ot);
            $hojaTrabajo = $preRecepcionOT->getHojaTrabajo(); //Se obtiene la recepcion relacionada

            $recepcionOT = $preRecepcionOT;
        } else {
            //En caso se registre una recepcion
            if ($request->nroOT) {
                if (RecepcionOT::where((new RecepcionOT)->getKeyName(), $request->nroOT)->exists()) {
                    return redirect()->route('recepcion.index')->with('error', 'EL NÚMERO DE OT YA EXISTE');
                }
            }
            // if(!$request->tipoOT){
            //     return redirect()->route('recepcion.index')->with('error','Debe seleccionar un tipo de OT');
            // }
            // if(!$request->marcaAuto){
            //     return redirect()->route('recepcion.index')->with('error','Debe seleccionar una marca de auto');
            // }
            // if(!$request->seguro){
            //     return redirect()->route('recepcion.index')->with('error','Debe seleccionar una cia seguro');
            // }

            $vehiculo = Vehiculo::where('placa', $request->nroPlaca)->first();
            $panhos = PrecioDYP::where('id_marca_auto', $vehiculo->id_marca_auto)->where('id_cia_seguro', $request->seguro)->where('tipo', 'PANHOS')->where('habilitado', 1)->first();
            $hh = PrecioDYP::where('id_marca_auto', $vehiculo->id_marca_auto)->where('id_cia_seguro', $request->seguro)->where('tipo', 'HH')->where('habilitado', 1)->first();

            $fecha_registro = Carbon::now();
            $recepcionOT = new RecepcionOT();
            $recepcionOT->id_tipo_ot = $request->tipoOT;
            $recepcionOT->id_cia_seguro = $request->seguro;
            $recepcionOT->factura_para = $request->facturara;
            $recepcionOT->num_doc = $request->numDoc != null ? $request->numDoc : '';
            $recepcionOT->direccion = $request->direccion;
            $recepcionOT->es_factura = $request->customSwitch1 != null ? true : false;
            $recepcionOT->id_local = Auth::user()->empleado->local->id_local;
            $recepcionOT->fecha_inicio = $fecha_registro;
            $recepcionOT->kilometraje = $request->kilometraje;

            $recepcionOT->nro_poliza = $request->nro_poliza;
            $recepcionOT->nro_siniestro = $request->nro_siniestro;

            $recepcionOT->precio_dyp = json_encode(["PANHOS" => $panhos->id_precio_mo_dyp, "HH" => $hh->id_precio_mo_dyp]);

            if ($request->fechaEntregaProg) {
                $recepcionOT->fecha_entregar = Carbon::createFromFormat('d/m/Y', $request->fechaEntregaProg);
            }

            $hojaTrabajo = new HojaTrabajo();
            //VEHICULO
            $hojaTrabajo->setPlacaAuto(strtoupper($request->nroPlaca));

            $hojaTrabajo->dni_empleado = Auth::user()->empleado->dni;
            $hojaTrabajo->contacto = $request->contacto;
            $hojaTrabajo->fecha_recepcion = $fecha_registro;
            $hojaTrabajo->fecha_registro = $fecha_registro;
            $hojaTrabajo->fecha_modificacion = $fecha_registro;
            $hojaTrabajo->telefono_contacto = $request->telfContacto;
            $hojaTrabajo->email_contacto = $request->correoContacto;
            $hojaTrabajo->telefono_contacto2 = $request->telfContacto2;
            $hojaTrabajo->email_contacto2 = $request->correoContacto2;
            $hojaTrabajo->observaciones = $request->observaciones;
            $hojaTrabajo->moneda = $request->moneda;

            $hojaTrabajo->tipo_cambio = isset($request->tipoCambio) ? $request->tipoCambio : TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
        }

        $hojaTrabajo->setPlacaAuto($request->nroPlaca);
        $hojaTrabajo->setNumDocCliente($request->cliente);


        //CHANGE UBIGEO FACT
        $departamento = $request->departamento;
        $provincia = $request->provincia;
        $distrito = $request->distrito;
        if ($departamento && $provincia && $distrito) {
            $cliente = $hojaTrabajo->cliente;
            $cliente->ubigeo_fac = "$departamento" . "$provincia" . "$distrito";
            $cliente->save();
        }
        ////


        $hojaTrabajo->tipo_trabajo = 'DYP';

        if (!$request->id_recepcion_ot) {
            //en caso la recepcion sea nueva y registrada
            // $recepcionOT->save();
            // $hojaTrabajo->id_recepcion_ot=$recepcionOT->id_recepcion_ot;
            // $hojaTrabajo->save();

            //se envian los correos solo si la recepcion es nueva
            if ($request->fechaTraslado) {
                $recepcionOT->fecha_traslado = Carbon::createFromFormat('d/m/Y', $request->fechaTraslado);
                // $recepcionOT->save();
                // $recepcionOT->cambiarEstado('espera_traslado');
            } else {
                // $recepcionOT->cambiarEstado('espera_valuacion');
            }
        } else if ($request->fechaTrasladoEditar) {
            $fechaEditar = Carbon::createFromFormat('d/m/Y', $request->fechaTrasladoEditar);
            if ($fechaEditar != $recepcionOT->fecha_traslado) {
                $recepcionOT->fecha_traslado = $fechaEditar;
                $recepcionOT->save();
            }
            //en caso se esté editando, la OT esté en espera de traslado, y 
        }
        //$recepcionOT->limpiarEstados();
        //$recepcionOT->estadosReparacion()->attach(1,['es_estado_actual'=>1]);//se graba un estado inicial, no se establece como estado actual
        session()->forget(['hojaTrabajo', 'recepcionOT', 'cotizacion']);
        session([
            'hojaTrabajo' => $hojaTrabajo,
            'recepcionOT' => $recepcionOT
        ]);
        return redirect()->route('detalle_trabajos.index')->with(['departamento' => 'DYP']);
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

    public function getUltimoKilometraje($nroPlaca)
    {
        $hojaTrabajo = HojaTrabajo::where('placa_auto', $nroPlaca)->whereNotNull('id_recepcion_ot')->orderBy('fecha_modificacion', 'desc')->first();
        return $hojaTrabajo ? $hojaTrabajo->recepcionOT->kilometraje : 0;
    }

    public function buscarRecepcionPlaca($nroPlaca)
    {
        $hojaTrabajo = HojaTrabajo::with(['vehiculo', 'cliente'])->where('placa_auto', $nroPlaca)->orderBy('fecha_modificacion', 'desc')->first();
        if (!$hojaTrabajo) {
            $vehiculo = Vehiculo::find($nroPlaca);
            if ($vehiculo) {
                $response = [
                    'placa' =>         $vehiculo->getPlaca(),
                    'vin' =>            $vehiculo->getVin(),
                    'motor' =>          $vehiculo->getMotor(),
                    'id_marca_auto' =>  $vehiculo->getIdMarca(),
                    'marca_auto' =>     $vehiculo->getNombreMarca(),
                    'modelo_auto' =>    $vehiculo->getModelo(),
                    'color' =>          $vehiculo->getColor(),
                    'tipo_transmision' =>   $vehiculo->getTipoTransmision(),
                    'anho_vehiculo' =>      $vehiculo->getAnhoVehiculo(),
                    'anho_modelo' =>      $vehiculo->getAnhoModelo(),
                    'kilometraje' => 0,
                    'tipo_combustible' =>   $vehiculo->getTipoCombustible(),
                    'modelo' => $vehiculo->modelo,
                    'modelo_tecnico' => $vehiculo->id_modelo_tecnico
                ];
                return $response;
            } else {
                return null;
            }
        }

        $response = [
            'placa' => $hojaTrabajo->vehiculo->getPlaca(),
            'vin' => $hojaTrabajo->vehiculo->getVin(),
            'motor' => $hojaTrabajo->vehiculo->getMotor(),
            'id_marca_auto' => $hojaTrabajo->vehiculo->getIdMarca(),
            'marca_auto' => $hojaTrabajo->vehiculo->getNombreMarca(),
            'modelo_auto' => $hojaTrabajo->vehiculo->getModelo(),
            'color' => $hojaTrabajo->vehiculo->getColor(),
            'tipo_transmision' => $hojaTrabajo->vehiculo->getTipoTransmision(),
            'anho_vehiculo' => $hojaTrabajo->vehiculo->getAnhoVehiculo(),
            'anho_modelo' =>      $hojaTrabajo->vehiculo->getAnhoModelo(),
            'tipo_combustible' => $hojaTrabajo->vehiculo->getTipoCombustible(),
            'kilometraje' => $this->getUltimoKilometraje($nroPlaca),
            'modelo' => $hojaTrabajo->vehiculo->modelo,
            'modelo_tecnico' => $hojaTrabajo->vehiculo->id_modelo_tecnico,
            //CLIENTE
            'num_doc' => $hojaTrabajo->cliente->getNumDocCliente(),
            'tipo_doc' => $hojaTrabajo->cliente->getTipoDocCliente(),
            'tipo_cliente' => $hojaTrabajo->cliente->getTipoCliente(),
            'nombres' => $hojaTrabajo->cliente->getNombres(),
            'apellido_pat' => $hojaTrabajo->cliente->getApellidoPat(),
            'apellido_mat' => $hojaTrabajo->cliente->getApellidoMat(),
            'nombre_completo' => $hojaTrabajo->cliente->getNombreCliente(),
            'sexo' => $hojaTrabajo->cliente->getSexo(),
            'estado_civil' => $hojaTrabajo->cliente->getEstadoCivil(),
            'direccion' => $hojaTrabajo->cliente->getDireccionCliente(),
            'celular' => $hojaTrabajo->cliente->getTelefonoCliente(),
            'email' => $hojaTrabajo->cliente->getCorreoCliente(),
            'cod_departamento' => $hojaTrabajo->cliente->getDepartamento(),
            'cod_provincia' => $hojaTrabajo->cliente->getProvincia(),
            'cod_distrito' => $hojaTrabajo->cliente->getDistrito(),
            'contacto' => $hojaTrabajo->contacto ?? $hojaTrabajo->cliente->getNombreCliente(),
            'telefono_contacto' => $hojaTrabajo->telefono_contacto ?? $hojaTrabajo->cliente->getTelefonoCliente(),
            'correo_contacto' => $hojaTrabajo->email_contacto ?? $hojaTrabajo->cliente->getCorreoCliente(),
        ];
        return $response;
    }

    public function existeOT($nroOT)
    {
        return RecepcionOT::where((new RecepcionOT)->getKeyName(), $nroOT)->exists() ? 'true' : 'false';
    }

    public function registrarVehiculo(Request $request)
    {
        $vehiculo = new Vehiculo();
        $nombreModelo = isset($request->nombreModeloText) ? $request->nombreModeloText : $request->nombreModelo;
        $placa = Vehiculo::saveVehiculo(
            $request->nroPlaca,
            $request->vin,
            $request->motor,
            $request->marcaAuto,
            $request->modeloTecnico,
            $nombreModelo,
            $request->tipoTransmision,
            $request->anhoVehiculo,
            $request->color,
            $request->tipoCombustible,
            $request->anhoModelo
        );
        return $placa;
    }

    public function agregarServicioTercero(Request $request)
    {
        $servicioTercero = ServicioTercero::where('codigo_servicio_tercero', $request->codServicioTercero)->first();
        $proveedor = $request->numDocProveedor ? Proveedor::where('num_doc', $request->numDocProveedor)->first() : null;

        $idProveedor = $proveedor ? $proveedor->id_proveedor : null;
        $idServicioTercero = $servicioTercero->id_servicio_tercero;

        $servicioTercero = new ServicioTerceroSolicitado();
        $servicioTercero->id_hoja_trabajo = $request->id_hoja_trabajo;
        $servicioTercero->id_proveedor = $idProveedor;
        $servicioTercero->id_servicio_tercero = $idServicioTercero;
        $servicioTercero->id_usuario_registro = Auth::user()->id_usuario;
        $servicioTercero->save();

        return redirect()->back();
    }

    public function cerrarOT(Request $request)
    {
        $ordenTrabajo = RecepcionOT::find($request->nro_ot);

        if ($ordenTrabajo) {
            $OTCerrada = new OTCerrada();
            $OTCerrada->id_recepcion_ot = $request->nro_ot;
            $OTCerrada->razon_cierre = $request->razonCierre;
            $OTCerrada->save();

            $ordenTrabajo->cambiarEstado('cerrado');

            $garantia =  TipoOT::where("nombre_tipo_ot", "like", "GARANT%")->get()->first()->id_tipo_ot;
            // se cambia el tipo de OT a CORTESIA
            $ordenTrabajo->id_tipo_ot = TipoOT::where('nombre_tipo_ot', 'CORTESIA')->first()->id_tipo_ot;
            $ordenTrabajo->save();

            if ($ordenTrabajo->hojaTrabajo->tipo_trabajo == 'DYP') {
                return redirect()->route('recepcion.index');
            } else {
                return redirect()->route('mecanica.recepcion.index');
            }
        }

        return redirect()->back();
    }

    public function reAbrirOT(Request $request)
    {
        $ordenTrabajo = RecepcionOT::find($request->nro_ot);
        if ($ordenTrabajo) $ordenTrabajo->reAbrirOT();
        return redirect()->back();
    }

    public function eliminarServicioTercero($id)
    {
        $servicioTerceroSolicitado = ServicioTerceroSolicitado::find($id);
        if ($servicioTerceroSolicitado) {
            if ($servicioTerceroSolicitado->obtenerOrdenServicio() == '-')
                $this->saveTrackingDelete($servicioTerceroSolicitado);
            $servicioTerceroSolicitado->delete();
            // else: retornar error de servicio tercero ya con orden de servicio. Debe eliminar la orden de servicio primero
        }
        //else: el servicio por borrar no existe (previamente borrado)

        return redirect()->back();
    }

    private function saveTrackingDelete($transaction)
    {
        $data = json_encode($transaction);
        $origen = "ServicioTerceroSolicitado";

        $id_cotizacion = $transaction->hojaTrabajo->id_cotizacion;
        $id_recepcion_ot = $transaction->hojaTrabajo->id_recepcion_ot;

        if ($id_cotizacion == null) {
            $origen = "ServicioTerceroSolicitadoOT";
            $id_contenedor_origen = $id_recepcion_ot;
        } else {
            $origen = "ServicioTerceroSolicitadoCot";
            $id_contenedor_origen = $id_cotizacion;
        }
        $id_origen = $transaction->id_servicio_tercero_solicitado;
        $id_usuario_eliminador = Auth::user()->id_usuario;
        $name = Auth::user()->empleado->nombreCompleto();

        $description = "Servicio de tercero: " . $transaction->servicioTercero->descripcion . " eliminado por " . $name;

        $t = new TrackDeletedTransactions();
        $t->data = $data;
        $t->id_contenedor_origen = $id_contenedor_origen;
        $t->id_origen = $id_origen;
        $t->origen = $origen;
        $t->description = $description;
        $t->id_usuario_eliminador = $id_usuario_eliminador;
        $t->save();
    }

    public function reasignarOTCotVehiculo(Request $request)
    {
        if ($request->esOT) {
            if (isset($request->idOT)) {
                $ordenTrabajo = RecepcionOT::find($request->idOT);
                $placa = $this->registrarVehiculo($request);
                $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
                $hojaTrabajo->placa_auto = $placa;
                $hojaTrabajo->save();
            } elseif (session('hojaTrabajo')) {
                $placa = $this->registrarVehiculo($request);
                $hojaTrabajo = session('hojaTrabajo');
                $hojaTrabajo->placa_auto = $placa;
                session(['hojaTrabajo' => $hojaTrabajo]);
            }
        } else if ($request->esCotizacion) {
            if (isset($request->idCotizacion)) {
                $cotizacion = Cotizacion::find($request->idCotizacion);
                $placa = $this->registrarVehiculo($request);
                $hojaTrabajo = $cotizacion->hojaTrabajo;
                $hojaTrabajo->placa_auto = $placa;
                $hojaTrabajo->save();
            } elseif (session('hojaTrabajo')) {
                $placa = $this->registrarVehiculo($request);
                $hojaTrabajo = session('hojaTrabajo');
                $hojaTrabajo->placa_auto = $placa;
                session(['hojaTrabajo' => $hojaTrabajo]);
            }
        }
    }
}
