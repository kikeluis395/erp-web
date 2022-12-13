<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Modelos\RecepcionOT;
use App\Http\Controllers\APIsController;
use App\Modelos\NotaCreditoDebito;
use App\Modelos\LocalEmpresa;
use App\Modelos\Usuario;
use Auth;

class ModuloNotaCreditoController extends Controller
{
    public function index(Request $request){
        $fecha_emision = Carbon::now()->format('Y-m-d');
        $local = LocalEmpresa::first()->nombre_local;
        $id_usuario_registro = Auth::user()->id_usuario;
        $usuario = Usuario::find($id_usuario_registro)->username;
              
        return view('contabilidadv2.moduloNotaCredito', ['fecha_emision' => $fecha_emision,
                                                        'local' => $local,
                                                        'usuario' => $usuario
    ]);
    }

    public function store(Request $request){
        dd($request->all());
        $fecha_emision = Carbon::now()->format('Y-m-d');
        return view('contabilidadv2.moduloNotaCredito', ['fecha_emision' => $fecha_emision]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        
        $dataNotaCreditoDebito = NotaCreditoDebito::find($id);

        $fecha_emision = $dataNotaCreditoDebito->created_At;
        $detalleNotaCreditoDebito = APIsController::buscarDataNotaCredito($dataNotaCreditoDebito->doc_referencia);
        
        return view('contabilidadv2.moduloNotaCredito', ['fecha_emision' => $fecha_emision,
        'cabeceraNotaCreditoDebito'=>$dataNotaCreditoDebito,
        'detalleNotaCreditoDebito'=> $detalleNotaCreditoDebito[0]->items
        ]);
    } 
}
