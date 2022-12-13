<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Modelos\LineaNotaIngreso;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\NotaIngreso;
use App\Modelos\OrdenCompra;
use App\Modelos\TipoCambio;
use App\Modelos\Parametro;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CrearNotaIngresoController extends Controller
{
    public function index(Request $request)
    {
        $rutaDescarga = '';
        if (session('rutaDescarga')) {
            $rutaDescarga = session('rutaDescarga');
        }
        $fecha_recepcion = Carbon::now();
        $fecha_recepcion = $fecha_recepcion->format('d/m/Y');
        if ($request->all() == []) {
            return view('contabilidadv2.crearNotaIngreso', ['fecha_recepcion' => $fecha_recepcion,
                'rutaDescarga' => $rutaDescarga]);
        } else {
            $OCRelacionada = $request->input('oCRelacionada');
            //dd($OCRelacionada);
            $orden_compra = OrdenCompra::find($OCRelacionada);
            if (is_null($orden_compra)) {
                return redirect()->back()->with('oCNoExiste', 'La OC ingresada no existe');
            } else if (!$orden_compra->es_aprobado) {
                return redirect()->back()->with('oCNoAprobada', 'La OC ingresada no se encuentra aprobada');
            } else if ($orden_compra->es_finalizado) {
                return redirect()->back()->with('oCAtendida', 'La OC ingresada ya ha sido atendida');
            } else {
                $lineas_compra = $orden_compra->lineasCompra;
                return view('contabilidadv2.crearNotaIngreso', ['fecha_recepcion' => $fecha_recepcion,
                    'orden_compra' => $orden_compra,
                    'lineas_compra' => $lineas_compra,
                    'rutaDescarga' => $rutaDescarga]);
            }
        }
    }
    public function store(Request $request)
    {
        $requests = $request->all();
        $fecha_recepcion = Carbon::now();
        $nota_ingreso = new NotaIngreso();
        $nota_ingreso->id_usuario_registro = Auth::user()->id_usuario;
        if ($request->guiaRemision != "") {
            $nota_ingreso->guia_remision = $request->guiaRemision;
        }
        if ($request->facturaNI != "") {
            $nota_ingreso->factura_asociada = $request->facturaNI;
        }
        $nota_ingreso->save();
        $id_nota_ingreso = $nota_ingreso->id_nota_ingreso;

        foreach ($requests as $key => $value) {
            //Obtenemos la posición del string ingresado para ver si existe el registro
            $pos_input = strpos($key, "cant-");
            //Si es que lo encuentra, entonces también deben estar los demas campos relacionados a ese número de fila
            if ($pos_input !== false && $pos_input >= 0) {
                //Obtenemos el número de registro
                $numRequest = substr($key, $pos_input + strlen('cant-'));
                $lineaNotaIngreso = new LineaNotaIngreso();
                $lineaNotaIngreso->id_nota_ingreso = $id_nota_ingreso;
                $lineaNotaIngreso->cantidad_ingresada = $request->input("cant-" . $numRequest);
                $lineaNotaIngreso->id_linea_orden_compra = $numRequest;
                $lineaNotaIngreso->save();

                //se registra como ingreso de repuestos FISICO (no existe el concepto de ingresos virtuales aun) (aqui POR AHORA) (bvez)
                $movimiento = new MovimientoRepuesto();
                $movimiento->id_repuesto = $lineaNotaIngreso->getIdRepuesto();
                $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
                $lineaOrdenCompra = $lineaNotaIngreso->lineaOrdenCompra;
                $cantidad = $lineaNotaIngreso->cantidad_ingresada;
                $movimiento->cantidad_movimiento = $lineaOrdenCompra->es_grupo ? $cantidad * $lineaOrdenCompra->repuesto->getCantidadUnidadesGrupo() : $cantidad;
                $movimiento->tipo_movimiento = 'INGRESO';
                $movimiento->fecha_movimiento = Carbon::now();
                $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
                $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;
                $movimiento->saldo = $this->getStock($lineaNotaIngreso->getIdRepuesto()) + $cantidad;
                $movimiento->costo = $this->getCosto($lineaNotaIngreso);
               
                $movimiento->costo_promedio_ingreso = $this->getCostoPromedioOnlyIngreso($lineaNotaIngreso->getIdRepuesto());
                    $movimiento->save();

                $lineaNotaIngreso->id_movimiento_ingreso = $movimiento->id_movimiento_repuesto;
                $lineaNotaIngreso->save();

              
            }
        }

        $oc_relacionada = $request->input('ocRelacionada');
        $orden_compra = OrdenCompra::find($oc_relacionada);
        if ($orden_compra->flagAtentidoTotal()) {
            $orden_compra->es_finalizado = 1;
            $orden_compra->fecha_finalizado = Carbon::now();
            $orden_compra->save();
        }
        $rutaDescarga = route('hojaNotaIngreso', ['id_nota_ingreso' => $id_nota_ingreso]);
        return redirect()->route('contabilidad.crearNotaIngreso')->with(['rutaDescarga' => $rutaDescarga]);

    }

    private function getStock($id_repuesto)
    {
        $last_movimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento','!=',"EGRESO VIRTUAL")->orderBy('fecha_movimiento','DESC')->first();

        return $last_movimiento!=null? $last_movimiento->saldo:0;
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
            $costo_dolar = $lineaNotaIngreso->lineaOrdenCompra->precio ;
            $costo_sol = $costo_dolar * $cobro;
        } else {

            $costo_sol = $lineaNotaIngreso->lineaOrdenCompra->precio;
            $costo_dolar = $costo_sol / $cobro;
        }

        return $costo_dolar;
    }

    private static function getCostoPromedioOnlyIngreso($id_repuesto, $ingreso, $costo_ingreso){
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento','desc')->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->first();
        
       if($lastMovimiento==null){
            return $costo_ingreso;
       }else if($lastMovimiento->tipo_movimiento == "EGRESO"){
            $costo = (($ingreso * $costo_ingreso)+($lastMovimiento->saldo *$lastMovimiento->costo))/($ingreso + $lastMovimiento->saldo);
            return round($costo, 4);
       }else if($lastMovimiento->tipo_movimiento == "INGRESO"){
            $costo = (($ingreso * $costo_ingreso)+($lastMovimiento->saldo *$lastMovimiento->costo_promedio_ingreso))/($ingreso + $lastMovimiento->saldo);
            return round($costo, 4);
       }
         
            
    }


    public function crearIngresoVehiculo(){
        $listaUbicaciones = Parametro::where('valor2','ubicacion')->where('valor1','!=','ALMACEN MARCA')->get();
        return view('vehiculoSeminuevo.ingresoVehiculos',['listaUbicaciones' => $listaUbicaciones]);
    }
}
