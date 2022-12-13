<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Banco;
use App\Modelos\CuentaBancaria;
use App\Modelos\MovimientoBancario;
use Carbon\Carbon;

class BancosController extends Controller
{
    public function index(Request $request){
        $bancos = Banco::all();
        $cuentas = CuentaBancaria::all();
        //return view('contabilidadv2.bancos',['bancos'=>$bancos]);
        return view('contabilidadv2.bancos',['bancos' => $bancos,
                                             'cuentas' => $cuentas]);
    }

    public function store(Request $request){
        $cuenta = new CuentaBancaria();
        $cuenta->id_banco = $request->input('bancoSelecc');
        $cuenta->nro_cuenta = $request->input('numCuenta');
        $cuenta->moneda = $request->input('tipoMoneda');
        $cuenta->save();

        $ingresoInicial = new MovimientoBancario();
        $ingresoInicial->tipo_movimiento = "INGRESO";
        $ingresoInicial->comentario = "INGRESO INICIAL AL MOMENTO DE CREACIÓN";
        $ingresoInicial->monto_movimiento = $request->input('saldoInicial');
        $ingresoInicial->moneda_movimiento = $request->input('tipoMoneda');
        $ingresoInicial->id_cuenta_afectada = $cuenta->id_cuenta_bancaria;
        $ingresoInicial->fecha_movimiento = Carbon::now();
        $ingresoInicial->save();

        return redirect()->route('contabilidad.bancos');
    }
}
