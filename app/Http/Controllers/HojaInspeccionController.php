<?php

namespace App\Http\Controllers;

use App\Modelos\ElementoInspeccion;
use App\Modelos\HojaInspeccion;
use App\Modelos\LineaHojaInspeccion;
use App\Modelos\LineaResultadoInspeccion;
use App\Modelos\RecepcionOT;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HojaInspeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->id_recepcion_ot) {
            $recepcionOT = RecepcionOT::find($request->id_recepcion_ot);
        }

        if (!isset($recepcionOT) || !$recepcionOT || !$recepcionOT->esInspeccionable()) {
            return redirect()->back();
        }

        $listaElementosInspeccion = ElementoInspeccion::all();
        return view('hojaInspeccion', ['listaElementosInspeccion' => $listaElementosInspeccion->all(),
            'refreshable' => false]);
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

    public function indexPDI(Request $request)
    {
        $cantidad_lineas_posibles = 96; // lOS PRIMEROS 58 SON SAVAR, LOS SIGUIENTES 59 SON DEALER
        $fecha_emision = Carbon::now();
        $list_checks = [];
        for ($i = 1; $i <= 96; $i++) {
            $list_checks[$i] = false;

        }

        if (isset($request->id_hoja_inspeccion)) {
            $hojaInspeccion = HojaInspeccion::find($request->id_hoja_inspeccion);

            foreach ($hojaInspeccion->lineasResultadoInspeccion as $row) {
                if ($row->es_savar == 1) {
                    $list_checks[$row->id_elemento_inspeccion] = true;
                } else {
                    $list_checks[$row->id_elemento_inspeccion + 58] = true;
                }

            }
            //dd($list_checks);
            return view('otros.pdi', ['fecha_emision' => $fecha_emision,
                'hojaInspeccion' => $hojaInspeccion,
                'list_checks' => $list_checks,

            ]);
        } else {

            return view('otros.pdi', ['fecha_emision' => $fecha_emision,
                'hojaInspeccion' => null,
                'list_checks' => $list_checks,

            ]);
        }

    }

    public function listAllPdi()
    {

        $listaElementosInspeccion = HojaInspeccion::all();
        return view('otros.pdiList', ['listHojasInspeccion' => $listaElementosInspeccion,
            'refreshable' => false]);
    }

    public function store2(Request $request)
    {
        $request = $request->all();
        //dd($request);
        //$user = json_decode($response->getBody()->getContents())[0];
        $listaElementosInspeccion = $request['listaElementosInspeccion'];

        $hojaInspeccion = new HojaInspeccion();
        $hojaInspeccion->id_recepcion_ot = $request['id_recepcion_ot'];
        $hojaInspeccion->modelo = $request['modelo'];
        $hojaInspeccion->ano_modelo = $request['ano-modelo'];
        $hojaInspeccion->destino = $request['destino'];
        $hojaInspeccion->vin = $request['vin'];
        $hojaInspeccion->color = $request['color'];
        $hojaInspeccion->save();

        //leer todos los elementos
        $count = 1;
        foreach ($listaElementosInspeccion as $key => $elementoInspeccion) {

            $linea = new LineaResultadoInspeccion();
            $linea->id_hoja_inspeccion = $hojaInspeccion->id_hoja_inspeccion;
            $linea->id_elemento_inspeccion = $key;
            if (isset($elementoInspeccion['savar'])) {
                $linea->es_dealer = false;
                $linea->es_savar = true;
            }
            if (isset($elementoInspeccion['dealer'])) {
                $linea->es_savar = false;
                $linea->es_dealer = true;
            }
            $linea->save();
        }

        return redirect()->route('otros.pdiList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $requests = $request->all();

        $detalleEnProceso = session()->get('detalleEnProceso');
        $recepcionOT = session()->get('recepcionOT');
        $estados = session()->get('estados');

        if (!$request->ignore) {
            $hojaInspeccion = new HojaInspeccion();
            $hojaInspeccion->id_recepcion_ot = $recepcionOT->id_recepcion_ot;
            $hojaInspeccion->save();

            //leer todos los elementos
            $listaElementosInspeccion = ElementoInspeccion::all();
            foreach ($listaElementosInspeccion as $elementoInspeccion) {
                $id = $elementoInspeccion->id_elemento_inspeccion;
                $color = $request->input('color-' . $id);
                $value = $request->input('valor-' . $id);
                $linea = new LineaHojaInspeccion();
                $linea->id_hoja_inspeccion = $hojaInspeccion->id_hoja_inspeccion;
                $linea->id_elemento_inspeccion = $id;

                if ($color) {
                    $linea->resultado = $color;
                }

                if ($value) {
                    $linea->valor = $value;
                }

                if ($linea->resultado) {
                    $linea->save();
                }

            }
        }

        $reparacion = $recepcionOT->ultReparacion();
        $reparacion->fecha_fin_operativo = Carbon::now();
        $reparacion->fecha_registro_fin_operativo = Carbon::now();
        $reparacion->save();

        $detalleEnProceso->save();
        foreach ($estados as $key => $estado) {
            $recepcionOT->cambiarEstado($estado);
        }

        session()->forget(['detalleEnProceso', 'recepcionOT', 'estados']);

        return redirect()->route('mecanica.tecnicos.index');
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
