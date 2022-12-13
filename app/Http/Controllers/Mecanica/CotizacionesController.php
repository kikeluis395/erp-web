<?php

namespace App\Http\Controllers\Mecanica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\HojaTrabajo;
use App\Modelos\Cotizacion;
use App\Modelos\TipoOT;
use App\Modelos\MarcaAuto;
use App\Modelos\ModeloTecnico;
use App\Modelos\EstadoReparacion;
use App\Modelos\RecepcionOT;
use App\Modelos\Vehiculo;
use App\Modelos\Cliente;
use App\Modelos\Empleado;
use App\Modelos\Ubigeo;
use App\Modelos\TipoCambio;
use App\Helper\Helper;
use App\Modelos\Administracion\PrecioMEC;
use App\Modelos\Modelo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
// use Auth;
use Mail;

class CotizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $recepciones = HojaTrabajo::all();
        $id_rol_usuario=Auth::user()->id_rol;

        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $cotizaciones_pre = Cotizacion::with(['hojaTrabajo.vehiculo.marcaAuto']);
        }
        else {
            //aquí ya se presionó el boton buscar del filtro
            $placa = str_replace("-","",$request->nroPlaca);
            $nroCotizacion = $request->nroCotizacion;
            $nroDoc = $request->nroDoc;
            $nroOT = $request->nroOT;
            $id_marca = $request->marca;
            $dni_empleado = $request->asesor;

            $cotizaciones_pre = new Cotizacion();

            if(isset($nroDoc) && $nroDoc){
                $cotizaciones_pre=$cotizaciones_pre->whereHas('hojaTrabajo' , function ($query) use($nroDoc) {
                    $query->where('doc_cliente','LIKE',"$nroDoc%");
                });
            }

            if(isset($nroCotizacion) && $nroCotizacion){
                $cotizaciones_pre=$cotizaciones_pre->where('id_cotizacion', $nroCotizacion);
            }
            
            if(isset($placa) && $placa){
                $cotizaciones_pre=$cotizaciones_pre->whereHas('hojaTrabajo' , function ($query) use($placa) {
                    $query->where('placa_auto','LIKE',"%$placa%");
                });
            }

            if(isset($nroOT) && $nroOT){
                $cotizaciones_pre=$cotizaciones_pre->where((new RecepcionOT)->getKeyName(),$nroOT);
            }

            if ($id_marca!='all') {
                $cotizaciones_pre = $cotizaciones_pre->whereHas('hojaTrabajo.vehiculo.marcaAuto' , function ($query) use($id_marca) {
                    $query->where('id_marca_auto','=',$id_marca);
                });
            }

            // if(in_array($id_rol_usuario,[1,6 ,8,10,11,12,13,14])){
                if($dni_empleado && $dni_empleado!='all'){
                    $cotizaciones_pre = $cotizaciones_pre->whereHas('hojaTrabajo' , function ($query) use($dni_empleado) {
                        $query->where('dni_empleado','=',$dni_empleado);
                    });
                }
            // }

        }

        /* Si el usuario no es ni jefe ni administrador ni jefe, solo se visualizaran las OTs correspondientes al empleado */
        // CAMBIO 0301: TODOS PUEDEN VER LO DE TODOS
        // if(!in_array($id_rol_usuario,[1,6 ,8,10,11,12,13,14])){
        //     $cotizaciones_pre = $cotizaciones_pre->whereHas('hojaTrabajo' , function ($query){
        //         $query->where('dni_empleado','=',Auth::user()->dni);
        //     });
        // }

        $cotizaciones_pre=$cotizaciones_pre->whereHas('hojaTrabajo' , function ($query){
            $query->whereNotIn('tipo_trabajo',['DYP']);
        })->where('es_habilitado', 1);

        $lista_cotizaciones = $cotizaciones_pre->get();

        $cotizaciones = $lista_cotizaciones->sortBy(function ($recepcion){
            return $recepcion->getHojaTrabajo()->fecha_recepcion;
        });

        foreach ($cotizaciones as $cotizacion){
            $hojaTrabajo = $cotizacion->getHojaTrabajo();
            $moneda = Helper::obtenerUnidadMonedaCalculo($hojaTrabajo->moneda);
            $precioHoja = 0;
            foreach($hojaTrabajo->detallesTrabajo as $detalleTrabajo){
                $precioHoja += $detalleTrabajo->getPrecioVentaFinal($moneda);
            }
            foreach($hojaTrabajo->necesidadesRepuestos as $necesidadRepuesto){
                foreach($necesidadRepuesto->itemsNecesidadRepuestos as $itemNecesidadRepuesto){
                    $precioHoja += $itemNecesidadRepuesto->getMontoVentaTotal($itemNecesidadRepuesto->getFechaRegistroCarbon(),true);
                }
            } 
            foreach($hojaTrabajo->serviciosTerceros as $servicioTercero){
                $precioHoja += $servicioTercero->getPrecioVenta($moneda);
            }     
            $cotizacion->precioVenta = $precioHoja;
        }
        
        $tiposOT = TipoOT::getAll('MEC');
        $marcasAuto = MarcaAuto::orderBy('nombre_marca')->get();
        $empleados = Empleado::orderBy('primer_apellido')->get();//SE DEBE CAMBIAR PARA QUE SOLO SE VEA LOS DE SERVICIO
        $departamentos = Ubigeo::departamentos();
        $tiposTrabajo=[ (object) ['id'=>'PREVENTIVO','nombre'=>'PREVENTIVO'],
                        (object) ['id'=>'CORRECTIVO','nombre'=>'CORRECTIVO']];
        
        return view('mecanica.cotizaciones',['departamento' => 'MECANICA',
                                            'listaRecepciones'=>$recepciones,
                                            'listaCotizaciones'=>$cotizaciones,
                                            'listaTiposOT'=>$tiposOT,
                                            'listaMarcas'=>$marcasAuto,
                                            'listaAsesores'=>$empleados,
                                            'listaTiposTrabajo'=>$tiposTrabajo,
                                            'listaDepartamentos'=>$departamentos,
                                            'listaProvincias'=>[],
                                            'listaDistritos'=>[],
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
        $estados = EstadoReparacion::whereNotIn('nombre_estado_reparacion_interno',['entregado','entregado_pt','entregado_hotline','espera_traslado'])->orderBy('nombre_estado_reparacion_filtro')->groupBy('nombre_estado_reparacion_filtro')->get('nombre_estado_reparacion_filtro');
        $empleados = Empleado::orderBy('primer_apellido')->get();//SE DEBE CAMBIAR PARA QUE SOLO SE VEA LOS DE SERVICIO
        $departamentos = Ubigeo::departamentos();

        return view('mecanica.crearCotizacion',[ 'departamento' => 'MECANICA',
                                                'listaTiposOT'=>$tiposOT,
                                                'listaMarcas'=>$marcasAuto,
                                                'listaModelosTecnicos' => $modelosTecnicos,
                                                'listaModelos' => $modelos,
                                                'listaEstados'=>$estados,
                                                'listaAsesores'=>$empleados,
                                                'listaDepartamentos'=>$departamentos,
                                                'listaProvincias'=>[],
                                                'listaDistritos'=>[],
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
        $precio = PrecioMEC::where('tipo', 'MO')->where('habilitado', 1)->first();
    
        $cotizacion = new Cotizacion();
        $cotizacion->precio_mec = $precio->id_precio_mo_mec;;
        //$cotizacion->save();

        $hojaTrabajo = new HojaTrabajo();
        //VEHICULO
        // $placa=Vehiculo::saveVehiculo($request->nroPlaca,
        //                               $request->vin,
        //                               $request->marcaAuto,
        //                               $request->nombreModelo,
        //                               $request->tipoTransmision,
        //                               $request->kilometraje,
        //                               $request->anhoVehiculo,
        //                               $request->color,
        //                               $request->tipoCombustible);
        $hojaTrabajo->setPlacaAuto($request->nroPlaca);

        // $ubigeo=($request->departamento).($request->provincia).($request->distrito);
        // $doc_cliente=Cliente::saveCliente($request->cliente,
        //                                   $request->tipoID,
        //                                   $request->tipoCliente,
        //                                   $request->nombres,
        //                                   $request->apellidoPat,
        //                                   $request->apellidoMat,
        //                                   $request->sexo,
        //                                   $request->estadoCivil,
        //                                   $request->direccion,
        //                                   $request->telefono,
        //                                   $request->email,
        //                                   $ubigeo);
        $hojaTrabajo->setNumDocCliente($request->cliente);
        $hojaTrabajo->dni_empleado=Auth::user()->empleado->dni;
        $hojaTrabajo->contacto = $request->contacto;
        $hojaTrabajo->telefono_contacto = $request->telfContacto;
        $hojaTrabajo->email_contacto = $request->correoContacto;
        $hojaTrabajo->observaciones="$request->observaciones";
        $hojaTrabajo->id_cotizacion=$cotizacion->id_cotizacion;
        $hojaTrabajo->tipo_cambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
        $hojaTrabajo->moneda = $request->moneda;
        $hojaTrabajo->tipo_trabajo ='PREVENTIVO';//CAMBIAR
        //$hojaTrabajo->save();
        session()->forget(['hojaTrabajo','recepcionOT','cotizacion']);
        session(['hojaTrabajo'=>$hojaTrabajo,
                 'cotizacion'=>$cotizacion]);
        return redirect()->route('mecanica.detalle_trabajos.index')->with(['departamento'=>'MECANICA']);
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
