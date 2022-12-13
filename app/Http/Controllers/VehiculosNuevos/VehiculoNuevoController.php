<?php

namespace App\Http\Controllers\VehiculosNuevos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\MarcaAuto;
use App\Modelos\LocalEmpresa;
use App\Modelos\VehiculoNuevo;
use App\Modelos\Empleado;
use App\Modelos\Usuario;
use Auth;

class VehiculoNuevoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $listaVehiculosNuevos = VehiculoNuevo::all();
        $marcasVehiculo = MarcaAuto::all();
        $empleados = Empleado::whereHas('usuario', function ($q2) {$q2->where('id_rol',1);})->orderBy('primer_apellido')->get();
        return view('vehiculosnuevos/consultaVehiculosNuevos',  [
            'listaVehiculosNuevos'=>$listaVehiculosNuevos,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores'=>$empleados,
        ]);
    }

    public function show($id)
    {
        $vehiculo = VehiculoNuevo::find($id);
        $locales =LocalEmpresa::all();
        $marcasVehiculo = MarcaAuto::all();
        
        return view('vehiculosnuevos/registrarVehiculosNuevos',[ 
            'listaMarcas' => $marcasVehiculo,
            'listaLocales' => $locales,
            'vehiculoNuevo' => $vehiculo,
        
        ]);
    }

    public function filter(Request $request){
        $marca = $request->marca;
        $modeloComercial = $request->modeloComercial;
        $estado = $request->estado;
        $responsableCreacion = $request->responsableCreacion;
     // dd($request->all());
        //$lista = new VehiculoNuevo();
        
        if ($marca!=null ) {
            if($marca == "Todo"){
                $lista = new VehiculoNuevo();
            }else{
                $lista = new VehiculoNuevo();
                $lista = $lista->where('id_marca_auto',$marca);
            }
             
        }

        if ($modeloComercial!=null) {
            $lista = $lista->where('modelo_comercial',$modeloComercial);
        }

        if ($estado!=null) {
            $lista = $lista->where('habilitado',$estado);
        }

        if ($responsableCreacion!=null) {
            $lista = $lista->where('id_usuario_registro',$responsableCreacion);
        }
        $lista = $lista->get();
        $marcasVehiculo = MarcaAuto::all();
        $empleados = Empleado::whereHas('usuario', function ($q2) {$q2->where('id_rol',1);})->orderBy('primer_apellido')->get();
        return view('vehiculosnuevos/consultaVehiculosNuevos',  [
            'listaVehiculosNuevos'=>$lista,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores'=>$empleados,
        ]);

    }

    public function findModeloComercial(Request $request){
        $modeloComercial = $request->modeloComercial;
        dd($request->all());
        $lista = new VehiculoNuevo();
        
        if ($modeloComercial!=null) {
            $lista = $lista->where('modelo_comercial',$modeloComercial);
        }
        $vehiculo = $lista->first();
        $locales =LocalEmpresa::all();
        $marcasVehiculo = MarcaAuto::all();
        return view('vehiculosnuevos/registrarVehiculosNuevos',[ 
            'listaMarcas' => $marcasVehiculo,
            'listaLocales' => $locales,
            'vehiculoNuevo' => $vehiculo,
        
        ]);
    }

    public function register()
    {
        $locales =LocalEmpresa::all();
        $marcasVehiculo = MarcaAuto::all();
        
        return view('vehiculosnuevos/registrarVehiculosNuevos',[ 
            'listaMarcas' => $marcasVehiculo,
            'listaLocales' => $locales,
            'vehiculoNuevo' => null,
        
        ]);
    }

    public function store(Request $request)
    {
        $listaVehiculosNuevos = VehiculoNuevo::all();
        $marcasVehiculo = MarcaAuto::all();
        $empleados = Empleado::orderBy('primer_apellido')->get();

        if($request->id_vehiculo_nuevo != null){
            $vehiculoNuevo = VehiculoNuevo::find($request->id_vehiculo_nuevo );
            $vehiculoNuevo->id_usuario_registro = $vehiculoNuevo->id_usuario_registro;
            
            
        }else{
            
            $vehiculoNuevo = new  VehiculoNuevo();
            $vehiculoNuevo->id_usuario_registro = Auth::user()->id_usuario;
            $vehiculoNuevo->id_marca_auto = $request->idMarca;
            $vehiculoNuevo->id_local = 1;
            
        }

        $modelo_comercial = $request->modelo.'-'.$request->version;
        //validacion de que solo exista un modelo comercial
        $vehiculoAnterior = VehiculoNuevo::where('modelo_comercial',$modelo_comercial)->get();
      
        if(count($vehiculoAnterior)>0 && $request->id_vehiculo_nuevo==null){
            return view('vehiculosnuevos/consultaVehiculosNuevos',  [
                'listaVehiculosNuevos'=>$listaVehiculosNuevos,
                'listaMarcas' => $marcasVehiculo,
                'listaAsesores'=>$empleados,
            ]);
        }

        $vehiculoNuevo->modelo = $request->modelo;
        $vehiculoNuevo->id_usuario_modifico = Auth::user()->id_usuario;
        $vehiculoNuevo->version = $request->version;
        $vehiculoNuevo->modelo_comercial = $modelo_comercial;
        $vehiculoNuevo->carroceria = $request->carroceria;
        $vehiculoNuevo->tipo = $request->tipo;
        $vehiculoNuevo->combustible = $request->combustible;
        $vehiculoNuevo->cilindrada = $request->cilindrada;
        $vehiculoNuevo->num_cilindros = $request->numCilindros;
        $vehiculoNuevo->transmision = $request->transmision;
        $vehiculoNuevo->traccion = $request->traccion;
        $vehiculoNuevo->num_ruedas = $request->numRuedas;
        $vehiculoNuevo->num_ejes = $request->numEjes;
        $vehiculoNuevo->distancia_entre_ejes = $request->distEntreEjes;
        $vehiculoNuevo->num_puertas = $request->numPuertas;
        $vehiculoNuevo->num_asientos = $request->numAsientos;
        $vehiculoNuevo->cap_pasajeros = $request->capPasajeros;
        $vehiculoNuevo->peso_bruto = $request->pesoBruto;
        $vehiculoNuevo->potencia = $request->potencia;
        $vehiculoNuevo->peso_neto = $request->pesoNeto;
        $vehiculoNuevo->carga_util = $request->cargaUtil;
        $vehiculoNuevo->alto = $request->alto;
        $vehiculoNuevo->largo = $request->largo;
        $vehiculoNuevo->ancho = $request->ancho;
        
        
        
        $vehiculoNuevo->habilitado = $request->habilitado;
        $vehiculoNuevo->save();
        $listaVehiculosNuevos = VehiculoNuevo::all();
        
        
        return view('vehiculosnuevos/consultaVehiculosNuevos',  [
            'listaVehiculosNuevos'=>$listaVehiculosNuevos,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores'=>$empleados,
        ]);
         
    }

    public function destroy($id)
    {
        $vehiculo = VehiculoNuevo::find($id);
        $listaVehiculosNuevos = VehiculoNuevo::all();
        $marcasVehiculo = MarcaAuto::all();
        $empleados = Empleado::whereHas('usuario', function ($q2) {$q2->where('id_rol',1);})->orderBy('primer_apellido')->get();
        $vehiculo = VehiculoNuevo::find($id);
        if($vehiculo!=null){
            $vehiculo->delete();
        }
        

        return view('vehiculosnuevos/consultaVehiculosNuevos',  [
            'listaVehiculosNuevos'=>$listaVehiculosNuevos,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores'=>$empleados,
        ]);
    }
}
