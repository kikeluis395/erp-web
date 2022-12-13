<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\FacturaCompra;
use App\Modelos\CuentaBancaria;
use App\Modelos\Banco;
use Carbon\Carbon;
use App\Modelos\MovimientoBancario;
use App\Modelos\Proveedor;

class PagoProveedoresController extends Controller
{
    public function index(Request $request){
        if ($request->all() ==[]) {
            $facturas = FacturaCompra::whereNull('id_movimiento_bancario')->orderBy('fecha_vencimiento', 'ASC')->get();
        } else {
            $rucProveedor = $request->input("nroRUC");
            $id_proveedor = Proveedor::where('num_doc',$rucProveedor)->first()->id_proveedor;
            $moneda = $request->input("moneda");
            $facturas = FacturaCompra::whereNull('id_movimiento_bancario')->where('id_proveedor',$id_proveedor)->where('moneda',$moneda)->get();
        }
        
        $arregloBancos = [];
        $arregloIdsBancos = [];
        $cuentas = CuentaBancaria::all();
        foreach( $cuentas as $key => $cuenta ){
            if(!in_array($cuenta->id_banco, $arregloIdsBancos)){
                array_push($arregloIdsBancos, $cuenta->id_banco);
                $banco = new Banco();
                $banco->id_banco = $cuenta->id_banco;
                $banco->nombre_banco = $cuenta->banco->nombre_banco;
                array_push($arregloBancos, $banco);
            }
        }
                
        
        return view('contabilidadv2.pagoProveedores',['facturas' => $facturas,
                                                      'arregloBancos' => $arregloBancos,
                                                      'cuentas' => []]);
    }

    public function pagoFacturas(Request $request){
        $requests = $request->all();
        $cuenta = $request->input('cuentasIn');
        foreach ($requests as $key => $value) {
            //Obtenemos la posición del string ingresado para ver si existe el registro
            $pos_input=strpos($key,"factura-");
            //Si es que lo encuentra, entonces también deben estar los demas campos relacionados a ese número de fila
            if($pos_input!==false && $pos_input>=0){
                //Obtenemos el número de factura
                $numFactura = substr($key,$pos_input + strlen('factura-'));
                $factura = FacturaCompra::find($numFactura);
                $movimiento = new MovimientoBancario();
                $movimiento->tipo_movimiento = 'EGRESO';
                $movimiento->monto_movimiento = $factura->total;
                $movimiento->moneda_movimiento = 'SOLES';
                $movimiento->id_cuenta_afectada = $cuenta;
                $movimiento->fecha_movimiento = Carbon::now();
                $movimiento->save();

                $factura->id_movimiento_bancario = $movimiento->id_movimiento_bancario;
                $factura->save();
            }
        }
        return redirect()->route('contabilidad.pagoProveedores');
    }

    
}
