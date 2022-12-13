<?php

namespace App\Http\Controllers\VehiculoSeminuevo;

use App\Http\Controllers\Controller;
use App\Modelos\LineaNotaIngreso;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\LocalEmpresa;
use App\Modelos\MovimientoOtroProductoServicio;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\MovimientoVehiculoSeminuevo;
use App\Modelos\NotaIngreso;
use App\Modelos\OrdenCompra;
use App\Modelos\OtroProductoServicio;
use App\Modelos\Proveedor;
use App\Modelos\Repuesto;
use App\Modelos\TipoCambio;
use App\Modelos\VehiculoSeminuevo;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;

class IngresoVehiculoSeminuevoController extends Controller
{
    public function index($id)
    {

       
    }

    public function show($id_nota_ingreso){

        

    }

    public function store(Request $request)
    {
        $requests = $request->all();


        DB::beginTransaction();
        $fecha_recepcion = Carbon::now();
        $nota_ingreso = new NotaIngreso();
        $nota_ingreso->id_usuario_registro = Auth::user()->id_usuario;
        $nota_ingreso->observaciones = $request->observaciones_sn;

        if ($request->observaciones != "") {
            $nota_ingreso->observaciones = $request->observaciones_sn;
        }

        $nota_ingreso->save();

        $id_nota_ingreso = $nota_ingreso->id_nota_ingreso;
        $oc_relacionada = $request->documentoRelacionado_sn;
   


        $lineaNotaIngreso = new LineaNotaIngreso();
        $lineaNotaIngreso->id_nota_ingreso = $id_nota_ingreso;
        $lineaNotaIngreso->cantidad_ingresada = 1;
        $lineaOrdenCompra = LineaOrdenCompra::where('id_orden_compra',$oc_relacionada)->first();
        $lineaNotaIngreso->id_linea_orden_compra = $lineaOrdenCompra->id_linea_orden_compra;

        $vehiculo_seminuevo = VehiculoSeminuevo::find($lineaOrdenCompra->id_vehiculo_seminuevo);
        $vehiculo_seminuevo->id_ubicacion = $request->ubicacion_sn;
        $vehiculo_seminuevo->save();

        $id_movimiento_vehiculo = $this->ingresoVehiculoSeminuevo($lineaNotaIngreso, 1, $lineaOrdenCompra->precio, $lineaOrdenCompra->id_vehiculo_seminuevo);
        $lineaNotaIngreso->id_movimiento_ingreso = null;

        $lineaNotaIngreso->save();

        

        if ($oc_relacionada != null) {
            $orden_compra = OrdenCompra::find($oc_relacionada);
            if ($orden_compra->flagAtentidoTotal()) {
                $orden_compra->es_finalizado = 1;
                $orden_compra->fecha_finalizado = Carbon::now();
                $orden_compra->save();
            }
        }

        DB::commit();
        return redirect()->route('hojaNotaIngresoVehiculoNuevo', ['id_nota_ingreso' => $id_nota_ingreso]);

        

    }


    public function update(Request $request)
    {
        $requests = $request->all();
        // dd($requests);
        $id_nota_ingreso = $request->id_nota_ingreso;
        $fecha_recepcion = Carbon::now();
        $nota_ingreso = NotaIngreso::find($id_nota_ingreso);
        $nota_ingreso->id_usuario_registro = Auth::user()->id_usuario;
        $nota_ingreso->observaciones = $request->observaciones;   
        $nota_ingreso->guia_remision = $request->guiaRemisionSol;
        $nota_ingreso->save();
        return $this->show($id_nota_ingreso);
    }


    private function ingresoVehiculoSeminuevo($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario,$id_vehiculo_seminuevo)
    {
        $movimiento = new MovimientoVehiculoSeminuevo();
        $movimiento->id_vehiculo_seminuevo = $id_vehiculo_seminuevo;
        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
        $movimiento->cantidad_movimiento = $cantidad_ingresada;
        $movimiento->tipo_movimiento = 'INGRESO';
        $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
        $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;

        $movimiento->saldo = 1;
        
        $movimiento->costo = $costo_unitario;

        $movimiento->motivo = 'COMPRAS';

        $movimiento->fecha_movimiento = Carbon::now();
        $movimiento->save();

        return $movimiento->id_vehiculo_seminuevo;
    }

    public function downloadPDF()
    {

        $motivo = isset(request()->motivo) ? request()->motivo : false;

        $pdf = PDF::loadView('formatos.reingresos', [
            'motivo' => $motivo,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream();
    }




    private function getCosto($lineaNotaIngreso)
    {

        $date_register = $lineaNotaIngreso->notaIngreso->fecha_registro;

        $date = strtotime("+1 day", strtotime($date_register));
        $date = date("Y-m-d 00:00:00", $date);

        $cobro = TipoCambio::where('fecha_registro', '<', $date)->orderBy('fecha_registro', 'desc')->first();
        $cobro = $cobro->cobro;
        $current = $lineaNotaIngreso->lineaOrdenCompra->ordenCompra->tipo_moneda;
        //dd($current);
        if ($current == "DOLARES") {
            $costo_dolar = $lineaNotaIngreso->lineaOrdenCompra->precio;
            $costo_sol = $costo_dolar * $cobro;
        } else {

            $costo_sol = $lineaNotaIngreso->lineaOrdenCompra->precio;
            $costo_dolar = $costo_sol / $cobro;
        }

        return $costo_dolar;
    }

    
    
}
