<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\CategoriaRepuesto;
use App\Modelos\UnidadMedida;
use App\Modelos\MarcaAuto;
use App\Modelos\Repuesto;
use App\Modelos\PrecioRepuesto;
use App\Modelos\ModeloTecnico;
use App\Modelos\RepuestoAplicaModeloTecnico;
use App\Modelos\PrecioRepuestoMayoreo;
use Carbon\Carbon;
use Auth;

class RepuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('administracion.admrepuesto.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriaRepuestos = CategoriaRepuesto::all();
        $listaUnidades = UnidadMedida::all();
        $listaMarcas = MarcaAuto::orderBy('nombre_marca')->get();
        $modelosTecnicos = ModeloTecnico::all();
        return view('repuestos.registrarRepuestos', [
            'refreshable' => false,
            "listaUnidades" => $listaUnidades,
            "listaCategoriasRepuesto" => $categoriaRepuestos,
            "modelosTecnicos" => $modelosTecnicos,
            "listaMarcas" => $listaMarcas
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
        $repuesto = Repuesto::where('codigo_repuesto', $request->codigo)->first();
        //   dd($request->all());     
        if (!$repuesto) $repuesto = new Repuesto();
        $repuesto->codigo_repuesto = $request->codigo;
        $repuesto->descripcion = $request->descripcion;
        $repuesto->ubicacion = $request->ubicacion;
        $repuesto->pvp = $request->pvp;
        $repuesto->id_categoria_repuesto = $request->idCategoria;
        $repuesto->id_marca = $request->idMarca == 'otros' ? null : $request->idMarca;
        $repuesto->id_unidad_medida = $request->idUnidad;
        $repuesto->moneda_pvp = $request->moneda;
        $repuesto->id_unidad_grupo = $request->idUnidadGrupo != '' ? $request->idUnidadGrupo : null;
        $repuesto->cantidad_unidades_grupo = $request->cantGrupo;
        $repuesto->margen = $request->margen;
        $repuesto->aplicacion_ventas = $request->aplicacion_ventas === null ? 0 : 1;
        $repuesto->save();

        $precio = new PrecioRepuesto();
        $precio->monto = $request->pvp;
        $precio->incluye_igv = true;
        $precio->moneda = $request->moneda;
        $precio->id_repuesto = $repuesto->id_repuesto;
        $precio->id_local = Auth::user()->empleado->local->id_local;
        $carbonNow = Carbon::now();
        $precio->fecha_inicio_aplicacion = $carbonNow;
        $precio->fecha_registro = $carbonNow;
        $precio->save();

        $modelosTecnicos = ModeloTecnico::all();
        foreach ($modelosTecnicos as $key => $modeloTecnico) {
            if ($request['modeloTecnico-' . ($key + 1)] != null) {
                $repuestoAplicaModeloTecnico = new RepuestoAplicaModeloTecnico();
                $repuestoAplicaModeloTecnico->id_modelo_tecnico = $modeloTecnico->id_modelo_tecnico;
                $repuestoAplicaModeloTecnico->id_repuesto = $repuesto->id_repuesto;
                $repuestoAplicaModeloTecnico->save();
            }
        }

        $precioMayoreo = $request->precioMayoreo;
        if ($precioMayoreo != null) {
            $precioRepuestoMayoreo = new PrecioRepuestoMayoreo();
            $precioRepuestoMayoreo->monto = $precioMayoreo;

            $precioRepuestoMayoreo->incluye_igv = true;
            $precioRepuestoMayoreo->moneda = $request->moneda;
            $precioRepuestoMayoreo->id_repuesto = $repuesto->id_repuesto;
            $precioRepuestoMayoreo->id_local = Auth::user()->empleado->local->id_local;
            $carbonNow = Carbon::now();
            $precioRepuestoMayoreo->fecha_inicio_aplicacion = $carbonNow;
            $precioRepuestoMayoreo->fecha_registro = $carbonNow;

            $precioRepuestoMayoreo->save();
        }


        //Guardado modelo tecnico


        return redirect()->route('administracion.admrepuesto.create');
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
