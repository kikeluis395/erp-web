<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\TipoCambio;
use DB;

class TipoCambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposCambio = TipoCambio::orderBy('fecha_registro','desc')->get();

        return view('administracion.tipoCambio', ['listaTiposCambio' => $tiposCambio]);
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

    public function store(Request $request){

        $tipoCambio = new TipoCambio();

        $compra = $request->tipoCambioCompra;
        $venta = $request->tipoCambioVenta;
        $cobro = $request->tipoCambioCobro;

        $fechaActual = date('Y-m-d');
 
        $tpc = TipoCambio::where(DB::raw('date(fecha_registro)'), $fechaActual)->orderBy('fecha_registro', 'desc');

        $count = $tpc->get()->count();

        if($count>0){ 
           $tipoCambio = $tpc->first();
        }
        else {
           $tipoCambio = new TipoCambio();
        }

        $tipoCambio->compra = $compra;
        $tipoCambio->venta  = $venta;
        $tipoCambio->cobro  = $cobro;
        $tipoCambio->save();

        return redirect()->route('tipoCambio.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $codOperacion
     * @return \Illuminate\Http\Response
     */
    public function show($codOperacion)
    {
        
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

    public function cambiarMoneda(Request $request)
    {
        $target = $request->target;
        if (!in_array($target,['USD','PEN'])) return redirect()->back();
        session(['moneda'=>$target]);

        return redirect()->back();
    }
}