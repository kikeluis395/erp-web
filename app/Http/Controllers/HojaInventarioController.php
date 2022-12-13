<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\ElementoInventario;
use App\Modelos\HojaInventario;
use App\Modelos\LineaHojaInventario;
use App\Modelos\RecepcionOT;

class HojaInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->id_recepcion_ot){
            $recepcionOT = RecepcionOT::find($request->id_recepcion_ot);
            $esMecanica = in_array($recepcionOT->hojaTrabajo()->first()->tipo_trabajo,["PREVENTIVO","CORRECTIVO"]);

            $hojaInventarioArr = [];
            $hojaInventario = $recepcionOT->hojasInventario()->orderBy('fecha_registro', 'desc')->first();
            if($hojaInventario){
                $lineasHojaInventario = $hojaInventario->lineasHojaInventario()->get();
                foreach ($lineasHojaInventario as $key => $value) {
                    if($value->elementoInventario->clase == 'no_cuantificable'){
                        $hojaInventarioArr[$value->id_elemento_inventario] = $value->resultado_inventario;
                    }
                    elseif($value->elementoInventario->clase == 'cuantificable'){
                        $hojaInventarioArr[$value->id_elemento_inventario] = $value->cantidad;
                    }
                    elseif($value->elementoInventario->clase == 'rh-lh'){
                        $hojaInventarioArr[$value->id_elemento_inventario] = (object) ['rh' => $value->rh, 'lh' => $value->lh];
                    }
                }
            }
        }

        if( !isset($recepcionOT) || !$recepcionOT ){
            return redirect()->back();
        }

        $listaElementosInventario = ElementoInventario::orderBy('orden')->get();
        $listaCategorias = $listaElementosInventario->mapToGroups(function ($item, $key){
            return [$item['categoria'] => $item];
        })->all();

        return view('hojaInventario',['listaElementosInventario' => $listaCategorias,
                                      'id_recepcion_ot' => $request->id_recepcion_ot,
                                      'departamento' => ($esMecanica ? "MEC" : "DYP"),
                                      'hojaInventario' => $hojaInventarioArr,
                                      'refreshable'=>false]);
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
        $requests = $request->all();
        $hojaInventario = new HojaInventario();
        $hojaInventario->id_recepcion_ot = $request->id_recepcion_ot;
        $hojaInventario->save();

        foreach ($request->all() as $key => $value) {
            if(strpos($key, "objInv") !== false){
                $lineaHojaInventario = new LineaHojaInventario();
                $lineaHojaInventario->id_hoja_inventario = $hojaInventario->id_hoja_inventario;

                if(strpos($key, "objInv-") !== false){
                    $inputHeader = "objInv-";

                    if($value == 'on'){
                        $lineaHojaInventario->resultado_inventario = 1;
                    }
                    else{
                        $lineaHojaInventario->resultado_inventario = 0;
                    }
                }
                elseif(strpos($key, "objInvObs-") !== false){
                    $inputHeader = "objInvObs-";

                    $lineaHojaInventario->cantidad = $value;
                }
                elseif(strpos($key, "objInvLh-") !== false){
                    $inputHeader = "objInvLh-";

                    if($value == 'on'){
                        $lineaHojaInventario->lh = 1;
                    }
                    else{
                        $lineaHojaInventario->lh = 0;
                    }
                }
                elseif(strpos($key, "objInvRh-") !== false){
                    $inputHeader = "objInvRh-";

                    if($value == 'on'){
                        $lineaHojaInventario->rh = 1;
                    }
                    else{
                        $lineaHojaInventario->rh = 0;
                    }
                }
                
                $id = str_replace($inputHeader, "", $key);
                $lineaHojaInventario->id_elemento_inventario = $id;

                $lineaHojaInventario->save();
            }
        }

        if($request->departamento = "MEC")
            return redirect()->route('mecanica.detalle_trabajos.index', ["id_recepcion_ot" => $request->id_recepcion_ot]);
        elseif($request->departamento = "DYP")
            return redirect()->route('detalle_trabajos.index', ["id_recepcion_ot" => $request->id_recepcion_ot]);
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
