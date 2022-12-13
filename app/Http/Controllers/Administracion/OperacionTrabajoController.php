<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\OperacionTrabajo;

class OperacionTrabajoController extends Controller
{
    public static $tiposMecanica = ["MECANICA", "GLOBAL-HORAS-MEC"];
    //public static $tiposDyP = ["MECANICA Y COLISION","CARROCERIA","PANHOS PINTURA", "GLOBAL-HORAS-MEC", "GLOBAL-HORAS-CARR", "GLOBAL-PANHOS"];
    public static $tiposDyP = ["MECANICA", "MECANICA Y COLISION","CARROCERIA","PANHOS PINTURA", "GLOBAL-HORAS-MEC", "GLOBAL-HORAS-CARR", "GLOBAL-PANHOS"];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $codOperacion
     * @return \Illuminate\Http\Response
     */
    public function show($codOperacion)
    {
        $operacionTrabajo = OperacionTrabajo::where((new OperacionTrabajo)->codOperacionKeyName(),$codOperacion)->first();
        return $operacionTrabajo;
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

    public function getOperacionTrabajoDyP($codOperacion)
    {
        $operacionTrabajo = OperacionTrabajo::whereIn('tipo_trabajo',self::$tiposDyP)->where((new OperacionTrabajo)->codOperacionKeyName(),$codOperacion)->first();
        $response = $operacionTrabajo;
        if ($operacionTrabajo) {
            $response->unidad = $operacionTrabajo->getUnidad();
            $response->posicion = $operacionTrabajo->getPosicionUnidad();
        }
        return $response;
    }

    public function getOperacionTrabajoMec($codOperacion)
    {
        $operacionTrabajo = OperacionTrabajo::whereIn('tipo_trabajo',self::$tiposMecanica)->where((new OperacionTrabajo)->codOperacionKeyName(),$codOperacion)->first();
        $response = $operacionTrabajo;
        if ($operacionTrabajo) {
            $response->unidad = $operacionTrabajo->getUnidad();
            $response->posicion = $operacionTrabajo->getPosicionUnidad();
        }
        return $response;
    }
}
