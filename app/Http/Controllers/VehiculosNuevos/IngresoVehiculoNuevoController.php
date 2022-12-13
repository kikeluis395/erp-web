<?php

namespace App\Http\Controllers\VehiculosNuevos;

use App\Http\Controllers\Controller;
use App\Modelos\LineaNotaIngreso;
use App\Modelos\MovimientoOtroProductoServicio;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\MovimientoVehiculoNuevo;
use App\Modelos\NotaIngreso;
use App\Modelos\OrdenCompra;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\TipoCambio;
use App\Modelos\VehiculoNuevoInstancia;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;

class IngresoVehiculoNuevoController extends Controller
{
    public function index($id)
    {

    }

    public function show($id_nota_ingreso)
    {

    }

    public function store(Request $request)
    {
        $requests = $request->all();


        DB::beginTransaction();
        $fecha_recepcion = $request->fecha_recepcion;
        $nota_ingreso = new NotaIngreso();
        $nota_ingreso->id_usuario_registro = Auth::user()->id_usuario;

        if ($request->guiaRemisionSol != "") {
            $nota_ingreso->guia_remision = $request->guiaRemisionSol;
        }
        if ($request->facturaSol != "") {
            $nota_ingreso->factura_asociada = $request->facturaSol;
        }
        if ($request->observaciones != "") {
            $nota_ingreso->observaciones = $request->observaciones;
        }

        $nota_ingreso->save();

        $id_nota_ingreso = $nota_ingreso->id_nota_ingreso;
        $oc_relacionada = $request->documentoRelacionado;
 

        $lineaNotaIngreso = new LineaNotaIngreso();
        $lineaNotaIngreso->id_nota_ingreso = $id_nota_ingreso;
        $lineaNotaIngreso->cantidad_ingresada = 1;
        $lineaOrdenCompra = LineaOrdenCompra::where('id_orden_compra',$oc_relacionada)->first();
        $lineaNotaIngreso->id_linea_orden_compra = $lineaOrdenCompra->id_linea_orden_compra;

        $vehiculo_nuevo_instancia = VehiculoNuevoInstancia::find($lineaOrdenCompra->id_vehiculo_nuevo_instancia);

        $id_movimiento_vehiculo = $this->ingresoVehiculoNuevo($lineaNotaIngreso, 1, $lineaOrdenCompra->precio, $lineaOrdenCompra->id_vehiculo_nuevo_instancia);
        $lineaNotaIngreso->id_movimiento_ingreso = null;
        // dd($lineaNotaIngreso);
        $lineaNotaIngreso->save();

        

        if ($oc_relacionada != null) {
            $orden_compra = OrdenCompra::find($oc_relacionada);
            if ($orden_compra->flagAtentidoTotal()) {
                $orden_compra->es_finalizado = 1;
                $orden_compra->fecha_finalizado = Carbon::now();
                $orden_compra->save();
            }
        }

        $vehiculo_nuevo_instancia = VehiculoNuevoInstancia::find($lineaOrdenCompra->id_vehiculo_nuevo_instancia);
        $vehiculo_nuevo_instancia->id_ubicacion = $request->ubicacion;
        $vehiculo_nuevo_instancia->kilometraje = $request->kilometraje;
        $vehiculo_nuevo_instancia->save();

        DB::commit();
        // return 'exitoso';

//         $message = "
//         <div class='toast' role='alert' aria-live='assertive' aria-atomic='true'>
//   <div class='toast-header'>
  
//     <strong class='mr-auto'>Nota de ingreso</strong>
//     <small class='text-muted'>just now</small>
//     <button type='button' class='ml-2 mb-1 close' data-dismiss="toast" aria-label="Close">
//       <span aria-hidden='true'>&times;</span>
//     </button>
//   </div>
//   <div class="toast-body">
//     Nota de ingreso generada
//   </div>
// </div>
//         ";
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

    private function ingresoVehiculoNuevo($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario, $id_vehiculo_nuevo_instancia)
    {
        $movimiento = new MovimientoVehiculoNuevo();
        $movimiento->id_vehiculo_nuevo_instancia = $id_vehiculo_nuevo_instancia;
        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
        $movimiento->cantidad_movimiento = $cantidad_ingresada;
        $movimiento->tipo_movimiento = 'INGRESO';
        $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
        $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;

        $saldo = ($this->getStockVehiculoNuevo($id_vehiculo_nuevo_instancia) + $cantidad_ingresada);
        $movimiento->saldo = $saldo;

        $movimiento->costo = $costo_unitario;

        $movimiento->motivo = 'COMPRAS';

        $movimiento->fecha_movimiento = Carbon::now();
        $movimiento->save();

        return $movimiento->id_vehiculo_nuevo_instancia;
    }

    public function downloadPDF()
    {

        $motivo = isset(request()->motivo) ? request()->motivo : false;

        $pdf = PDF::loadView('formatos.reingresos', [
            'motivo' => $motivo,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream();
    }

    private function getStockVehiculoNuevo($id_vehiculo_nuevo_instancia)
    {
        $last_movimiento = MovimientoVehiculoNuevo::where('id_vehiculo_nuevo_instancia', $id_vehiculo_nuevo_instancia)->where('tipo_movimiento', '!=', "EGRESO VIRTUAL")->orderBy('fecha_movimiento', 'DESC')->first();

        return $last_movimiento != null ? $last_movimiento->saldo : 0;
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
