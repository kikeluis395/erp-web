<?php

namespace App\Http\Controllers\Mecanica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\PrecioMEC;
use App\Modelos\HojaTrabajo;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\ModeloTecnico;
use App\Modelos\CiaSeguro;
use App\Modelos\TecnicoReparacion;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Vehiculo;
use App\Modelos\Cliente;
use App\Modelos\Empleado;
use App\Modelos\Ubigeo;
use App\Modelos\TipoCambio;
use App\Modelos\Modelo;
use App\Modelos\Usuario;
use Carbon\Carbon;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Mail;

class RecepcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recepciones = HojaTrabajo::all();

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
                //ACA DIVIDE LOS QUE SON NISSAN DE LOS QUE NO TIENEN MARCA FIJA
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
            if (!is_null($vin_code) && $vin_code) {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo.vehiculo', function ($query) use ($vin_code) {
                    $query->where('vin', 'like', $vin_code);
                });
            }
            if ($id_seguro != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->where('id_cia_seguro', $id_seguro);
            }
            if ($id_tipo_ot != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->where('id_tipo_ot', $id_tipo_ot);
            }
            if ($dni_empleado != 'all') {
                $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) use ($dni_empleado) {
                    $query->where('dni_empleado', '=', $dni_empleado);
                });
            }
        }

        /* Si el usuario no es ni jefe ni administrador ni jefe, solo se visualizaran las OTs correspondientes al empleado */
        // CAMBIO 0301: TODOS PUEDEN VER LO DE TODOS
        // if(!in_array($id_rol_usuario,[1,6 ,8,10,11,12,13,14])){
        //     $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo' , function ($query){
        //         $query->where('dni_empleado','=',Auth::user()->dni);
        //     });
        // }

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('hojaTrabajo', function ($query) {
            $query->whereIn('tipo_trabajo', ['PREVENTIVO', 'CORRECTIVO']);
        });

        $recepciones_ots_pre = $recepciones_ots_pre->whereHas('estadosReparacion', function ($query) {
            $query->whereNotIn('estado_reparacion.nombre_estado_reparacion_interno', ['cerrado', 'entregado', 'entregado_pt', 'entregado_hotline', 'garantia_cerrado', 'garantia_facturada'])
                ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1);
        });

        $lista_recepciones_ots = $recepciones_ots_pre->get();

        $recepciones_ots = $lista_recepciones_ots->sortBy(function ($recepcion) {
            return $recepcion->getHojaTrabajo()->fecha_recepcion;
        });

        // return $recepciones_ots_pre->with('hojaTrabajo.vehiculo')->get();


        $tiposOT = TipoOT::getAll('MEC');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereIn('nombre_estado_reparacion_interno', ['vehiculo_listo', 'liquidado', 'espera_asignacion', 'espera_reparacion', 'reparacion_mecanica', 'espera_reparacion_hotline', 'espera_reparacion_ampliacion', 'espera_reparacion_ampliacion_hotline', 'hotline', 'paralizado', 'paralizado_hotline', 'espera_control_calidad', 'espera_control_calidad_hotline'])
            ->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        $empleados = Empleado::whereHas('usuario', function ($query) {
            $query->whereHas('rol', function ($q){
                $q->whereIn('nombre_interno', ['asesor_servicios', 'jefe_taller']);
            });
        })->orderBy('primer_apellido')->get(); //SE DEBE CAMBIAR PARA QUE SOLO SE VEA LOS DE SERVICIO
        $departamentos = Ubigeo::departamentos();
        $tiposTrabajo = [
            (object) ['id' => 'PREVENTIVO', 'nombre' => 'PREVENTIVO'],
            (object) ['id' => 'CORRECTIVO', 'nombre' => 'CORRECTIVO']
        ];
        $listaTecnicos = TecnicoReparacion::all();
        // $asesores = Usuario::with(['rol'])
        //     ->whereHas('rol', function ($a) {
        //         $a->whereIn('nombre_interno', ['asesor_servicios', 'jefe_taller']);
        //     })->get();

        $listaModelos = Modelo::all();

        return view('mecanica.recepcion', [
            'departamento' => 'MECANICA',
            'listaRecepciones' => $recepciones,
            'listaRecepcionesOTs' => $recepciones_ots,
            'listaTiposOT' => $tiposOT,
            'listaMarcas' => $marcasAuto,
            'listaSeguros' => $seguros,
            'listaEstados' => $estados,
            'listaAsesores' => $empleados,
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
        $tiposOT = TipoOT::getAll('MEC');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $modelosTecnicos = ModeloTecnico::all();
        $modelos = Modelo::orderBy('nombre_modelo')->get();
        $seguros = CiaSeguro::orderBy('nombre_cia_seguro')->get();
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno', ['entregado', 'entregado_pt', 'entregado_hotline', 'espera_traslado'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        $empleados = Empleado::orderBy('primer_apellido')->get(); //SE DEBE CAMBIAR PARA QUE SOLO SE VEA LOS DE SERVICIO
        $departamentos = Ubigeo::departamentos();

        return view('mecanica.crearOT', [
            'departamento' => 'MECANICA',
            'listaTiposOT' => $tiposOT,
            'listaMarcas' => $marcasAuto,
            'listaModelosTecnicos' => $modelosTecnicos,
            'listaModelos' => $modelos,
            'listaSeguros' => $seguros,
            'listaEstados' => $estados,
            'listaAsesores' => $empleados,
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
        $fecha_registro = Carbon::now();
        $precio = PrecioMEC::where('tipo', 'MO')->where('habilitado', 1)->first();
    
        $recepcionOT = new RecepcionOT();
        $recepcionOT->id_tipo_ot = $request->tipoOT;
        $recepcionOT->id_local = Auth::user()->empleado->local->id_local;
        $recepcionOT->fecha_inicio = $fecha_registro;
        $recepcionOT->factura_para = $request->facturara;
        $recepcionOT->num_doc = $request->numDoc != null ? $request->numDoc : '';
        $recepcionOT->direccion = $request->direccion;
        $recepcionOT->kilometraje = $request->kilometraje;
        $recepcionOT->es_factura = $request->customSwitch1 != null ? true : false;
        $recepcionOT->precio_mec = $precio->id_precio_mo_mec;

        $hojaTrabajo = new HojaTrabajo();
        $hojaTrabajo->setPlacaAuto($request->nroPlaca);

        $hojaTrabajo->setNumDocCliente($request->cliente);
        $hojaTrabajo->dni_empleado = Auth::user()->empleado->dni;
        $hojaTrabajo->contacto = $request->contacto;
        $hojaTrabajo->fecha_recepcion = $fecha_registro;
        $hojaTrabajo->fecha_registro = $fecha_registro;
        $hojaTrabajo->fecha_modificacion = $fecha_registro;
        $hojaTrabajo->telefono_contacto = $request->telfContacto;
        $hojaTrabajo->telefono_contacto2 = $request->telfContacto2;
        $hojaTrabajo->email_contacto = $request->correoContacto;
        $hojaTrabajo->email_contacto2 = $request->correoContacto2;
        $hojaTrabajo->observaciones = "$request->observaciones";
        $hojaTrabajo->id_recepcion_ot = $recepcionOT->id_recepcion_ot;
        $hojaTrabajo->moneda = $request->moneda;
        $hojaTrabajo->tipo_cambio = TipoCambio::orderBy('id_tipo_cambio', 'desc')->first()->cobro;
        // la hoja de trabajo se guarda en la siguiente vista de detalles de trabajo


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
        

        session()->forget(['hojaTrabajo', 'recepcionOT', 'cotizacion']);
        session([
            'hojaTrabajo' => $hojaTrabajo,
            'recepcionOT' => $recepcionOT
        ]);
        return redirect()->route('mecanica.detalle_trabajos.index')->with(['departamento' => 'MECANICA']);
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
