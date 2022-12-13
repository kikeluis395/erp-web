<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\MarcaAuto;
use App\Modelos\MarcaServicioTercero;
use App\Modelos\ServicioTercero;
use Carbon\Carbon;
use App\Modelos\Parametro;
use App\Modelos\Permiso;
use App\Modelos\Rol;
use App\Modelos\Usuario;
use Illuminate\Support\Facades\Auth;

class ServiciosTercerosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serviciosTerceros = ServicioTercero::with('serviciosTercerosSolicitados');
        if (count($request->all()) > 0) {
            $estado = $request->estado;
            $marca = $request->marca;
            $responsable = $request->responsable;
            $aplicacion_ventas = $request->aplicacion_ventas;

            if ($estado != '' && $estado != 'all') {
                $serviciosTerceros = $serviciosTerceros->where('estado', $estado);
            }
            if ($marca && $marca != 'all') {
                $serviciosTerceros = $serviciosTerceros->where('marcas', 'like', '%"M' . $marca . '": "1"%');
            }
            if ($responsable && $responsable != 'all') {
                $serviciosTerceros = $serviciosTerceros->where('creado_por', $responsable);
            }
            if ($aplicacion_ventas && $aplicacion_ventas != 'all') {
                $codes = ["SI" => 1, "NO" => 0];
                $serviciosTerceros = $serviciosTerceros->where('aplicacion_ventas', $codes[$aplicacion_ventas]);
            }
        }
        $marcas = MarcaAuto::whereHabilitado(1)->get();
        $serviciosTerceros  = $serviciosTerceros->orderBy('codigo_servicio_tercero')->get();

        return view('administracion.serviciosTerceros', [
            'listaServiciosTerceros' => $serviciosTerceros,
            'marcas' => $marcas,
            'responsables' => $this->getResponsables()
        ]);
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

        $codigo = $request->codigo;
        $verificarSTExistente = ServicioTercero::where('codigo_servicio_tercero', $codigo)->get();
        if (!$verificarSTExistente->isEmpty()) {
            return redirect()->back()->with('stExistente', 'El código de Servicio Tercero ingresado ya existe');
        }

        $servicioTercero = new ServicioTercero();
        $servicioTercero->codigo_servicio_tercero = $codigo;
        $servicioTercero->descripcion = $request->descripcion;
        $pvp = $request->precio;
        if ($pvp == "") {
            $servicioTercero->moneda = "SOLES";
        } else {
            $servicioTercero->pvp = $request->precio;
            $servicioTercero->moneda = $request->moneda;
        }
        $servicioTercero->estado = '1';
        $servicioTercero->aplicacion_ventas = $request->aplicacion_ventas;
        $servicioTercero->f_creacion = Carbon::now();
        $user = Auth::user()->id_usuario;
        $servicioTercero->creado_por = $user;
        $servicioTercero->editado_por = $user;
        $servicioTercero->marcas = json_encode($request->marcas);
        $servicioTercero->save();

        // $inp_marcas = $request->marca;

        // if (is_array($inp_marcas)) {
        //     foreach ($inp_marcas as $marca) {
        //         MarcaServicioTercero::create(['servicio_tercero_id' => $servicioTercero->id_servicio_tercero, 'marca_id' => $marca]);
        //     }
        //     //
        // }

        return redirect()->route('administracion.serviciosTerceros.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicioTercero = ServicioTercero::findOrFail($id)->load('marcasQueAplican', 'serviciosTercerosSolicitados');
        $ruta = route('administracion.serviciosTerceros.update', ['serviciosTercero' => $servicioTercero]);
        $marcas = MarcaAuto::whereHabilitado(1)->get();
        return response()->json(['servicio' => $servicioTercero, 'ruta' => $ruta, 'marcas' => $marcas]);
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
        // // $activo = Parametro::where(['valor2' => 'ESTADO SERVICIO TERCERO', 'valor1' => 'ACTIVO', 'estado' => '1'])->first()->id;
        // $activo = Parametro::where('valor2', '=', 'ESTADO SERVICIO TERCERO')
        //     ->where('valor1', '=', 'ACTIVO')
        //     ->where('estado', '=', '1')
        //     ->first();
        // // $activo = Parametro::where(['valor2' => 'ESTADO SERVICIO TERCERO', 'valor1' => 'ACTIVO', 'estado' => '1'])->first();
        // return $activo;
        // $inactivo = Parametro::where(['valor2' => 'ESTADO SERVICIO TERCERO', 'valor1' => 'INACTIVO', 'estado' => '1'])->first()->id;

        $servicioTercero = Serviciotercero::findOrFail($id);
        if ($servicioTercero->serviciosTercerosSolicitados->count() < 1) {
            $verificarSTExistente = ServicioTercero::where('codigo_servicio_tercero', $request->codigo)
                ->where('id_servicio_tercero', '<>', $servicioTercero->id_servicio_tercero)
                ->get();
            if (!$verificarSTExistente->isEmpty()) {
                return redirect()->back()->with('stExistente', 'El código de Servicio Tercero ingresado ya existe');
            }
        }
        $servicioTercero->codigo_servicio_tercero = $request->codigo_servicio_tercero;
        $servicioTercero->descripcion = $request->descripcion;
        $servicioTercero->moneda = $request->moneda;
        $servicioTercero->pvp = $request->pvp;
        $servicioTercero->estado = $request->estado;
        $servicioTercero->aplicacion_ventas = $request->aplicacion_ventas;
        $servicioTercero->f_edicion = Carbon::now();
        if (is_null($servicioTercero->creado_por)) $servicioTercero->creado_por = auth()->user()->id_usuario;
        $servicioTercero->editado_por = auth()->user()->id_usuario;
        $servicioTercero->marcas = json_encode($request->marcas);
        $servicioTercero->save();


        // $servicioTercero->marcasQueAplican()->delete();
        // if (is_array($request->marca)) {
        //     foreach ($request->marca as  $marcaNueva) {
        //         MarcaServicioTercero::create(['servicio_tercero_id' => $servicioTercero->id_servicio_tercero, 'marca_id' => $marcaNueva]);
        //     }
        // }
        return $servicioTercero;
        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $servicioTercero = ServicioTercero::findOrFail($request->id);
            // $servicioTercero->marcasQueAplican()->delete();
            $servicioTercero->delete();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, $th]);
        }
    }

    public function getResponsables()
    {
        return Usuario::with('empleado')->whereHas('rol', function ($q) {
            $q->whereHas('permisos', function ($query) {
                $query->where('permiso.nombre_interno', 'submodulo_seguimientoServiciosTerceros');
            });
        })->get();
    }
}
