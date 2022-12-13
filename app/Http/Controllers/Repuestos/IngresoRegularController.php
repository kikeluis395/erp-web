<?php

namespace App\Http\Controllers\Repuestos;

use App\Http\Controllers\Controller;
use App\Modelos\LineaNotaIngreso;
use App\Modelos\LocalEmpresa;
use App\Modelos\MovimientoOtroProductoServicio;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\MovimientoVehiculoNuevo;
use App\Modelos\NotaIngreso;
use App\Modelos\OrdenCompra;
use App\Modelos\OtroProductoServicio;
use App\Modelos\Proveedor;
use App\Modelos\Repuesto;
use App\Modelos\TipoCambio;
use App\Modelos\VehiculoNuevo;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Modelos\VehiculoNuevoInstancia;
use PDF;

class IngresoRegularController extends Controller
{
    public function index($id)
    {

        $fecha_emision = Carbon::now();
        $fecha_emision = $fecha_emision->format('d/m/Y');

        $OCRelacionada = $id;
        $orden_compra = OrdenCompra::find($OCRelacionada);

        $numOrdenCompra = $orden_compra->id_orden_compra;
        $moneda = $orden_compra->tipo_moneda;
        $proveedor = Proveedor::find($orden_compra->id_proveedor);
        $rucProveedor = $proveedor->num_doc;
        $nombreProveedor = $proveedor->nombre_proveedor;
        $lineasRepuesto = $orden_compra->lineasCompra;

        $local_empresa = LocalEmpresa::first();

        return view('repuestos.ingresoRegular', [
            'fecha_creacion' => $orden_compra->fecha_registro,
            'documento_oc' => $orden_compra->codigo_orden_compra,
            'documento_ni' => $orden_compra->codigo_orden_compra,
            'usuario_creador' => $orden_compra->getNombreCompletoUsuarioRegistro(),
            'almacen' => $orden_compra->almacen != null ? $orden_compra->almacen->valor1 : '-',
            'motivo' => $orden_compra->motivo != null ? $orden_compra->motivo->valor1 : '-',
            'detalle_motivo' => $orden_compra->detalle_motivo,
            'fecha_emision' => $fecha_emision,
            'condicion_de_pago' => $orden_compra->condicion_pago,
            'nombre_proveedor' => $orden_compra->getNombreProveedor(),
            'ruc_proveedor' => $orden_compra->getRUCProveedor(),
            'direccion_proveedor' => $orden_compra->proveedor->direccion,
            'departamento_proveedor' => $orden_compra->proveedor->getDepartamentoText(),
            'provincia_proveedor' => $orden_compra->proveedor->getProvinciaText(),
            'distrito_proveedor' => $orden_compra->proveedor->getDistritoText(),
            'contacto_proveedor' => $orden_compra->proveedor->contacto,
            'email_contacto_proveedor' => $orden_compra->proveedor->email_contacto,
            'telf_proveedor' => $orden_compra->proveedor->telf_contacto,
            'sucursal' => $orden_compra->getNombreLocal(),
            'empresa' => $local_empresa->nombre_empresa,
            'moneda' => $moneda,
            'tipoCambio' => "-",
            'lineasRepuesto' => $lineasRepuesto,
            'guiaRemision' => '',
            'edited' => false,
            'tipo' => 'REPUESTO',
            'observaciones' =>  '',
            'id_nota_ingreso' => null
            
        ]);

    }

    public function show($id_nota_ingreso){

        $fecha_emision = Carbon::now();
        $fecha_emision = $fecha_emision->format('d/m/Y');

        $nota_ingreso = NotaIngreso::find($id_nota_ingreso);
        $OCRelacionada = $nota_ingreso->obtenerOrdenCompraRelacionada();
        $orden_compra = OrdenCompra::find($OCRelacionada);

        $numOrdenCompra = $orden_compra->id_orden_compra;
        $moneda = $orden_compra->tipo_moneda;
        $proveedor = Proveedor::find($orden_compra->id_proveedor);
        $rucProveedor = $proveedor->num_doc;
        $nombreProveedor = $proveedor->nombre_proveedor;
        $lineasRepuesto = $orden_compra->lineasCompra;

        $lineasNotaIngreso = $nota_ingreso->lineasNotaIngreso;

        $local_empresa = LocalEmpresa::first();

        if($orden_compra->lineasCompra->first()->id_vehiculo_nuevo){
            $tipo = "VEHICULO";
        }else{
            $tipo = "REPUESTO";
        }

        return view('repuestos.ingresoRegular', [
            'fecha_creacion' => $orden_compra->fecha_registro,
            'documento_oc' => $orden_compra->codigo_orden_compra,
            'documento_ni' => $orden_compra->codigo_orden_compra,
            'usuario_creador' => $orden_compra->getNombreCompletoUsuarioRegistro(),
            'almacen' => $orden_compra->almacen != null ? $orden_compra->almacen->valor1 : '-',
            'motivo' => $orden_compra->motivo != null ? $orden_compra->motivo->valor1 : '-',
            'detalle_motivo' => $orden_compra->detalle_motivo,
            'fecha_emision' => $fecha_emision,
            'condicion_de_pago' => $orden_compra->condicion_pago,
            'nombre_proveedor' => $orden_compra->getNombreProveedor(),
            'ruc_proveedor' => $orden_compra->getRUCProveedor(),
            'direccion_proveedor' => $orden_compra->proveedor->direccion,
            'departamento_proveedor' => $orden_compra->proveedor->getDepartamentoText(),
            'provincia_proveedor' => $orden_compra->proveedor->getProvinciaText(),
            'distrito_proveedor' => $orden_compra->proveedor->getDistritoText(),
            'contacto_proveedor' => $orden_compra->proveedor->contacto,
            'email_contacto_proveedor' => $orden_compra->proveedor->email_contacto,
            'telf_proveedor' => $orden_compra->proveedor->telf_contacto,
            'sucursal' => $orden_compra->getNombreLocal(),
            'empresa' => $local_empresa->nombre_empresa,
            'moneda' => $moneda,
            'tipoCambio' => "-",
            'lineasRepuesto' => $lineasRepuesto,
            'guiaRemision' => $nota_ingreso->guia_remision,
            'edited' => true,
            'id_nota_ingreso' =>   $nota_ingreso->id_nota_ingreso,
            'lineasNotaIngreso' => $lineasNotaIngreso,
            'observaciones' =>  $nota_ingreso->observaciones,
            'tipo' => $tipo
        ]);

    }

    public function store(Request $request)
    {
        $requests = $request->all();
        // dd($requests);

        DB::beginTransaction();
        $fecha_recepcion = Carbon::now();
        $nota_ingreso = new NotaIngreso();
        $nota_ingreso->id_usuario_registro = Auth::user()->id_usuario;

        if ($request->guiaRemisionSol != "") {
            $nota_ingreso->guia_remision = $request->guiaRemisionSol;
        }
        if ($request->facturaSol != "") {
            $nota_ingreso->factura_asociada = $request->facturaSol;
        }
        if ($request->observaciones != "") {
            $nota_ingreso->factura_asociada = $request->observaciones;
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

                //El repuesto viene en presentacion diferente caso Cilindro y se vend
                $costo_unitario = $this->getCosto($lineaNotaIngreso);
                $cantidad_ingresada = $request->input("cant-" . $numRequest);
                if ($lineaNotaIngreso->getIdRepuesto()) {
                    $repuesto = Repuesto::find($lineaNotaIngreso->getIdRepuesto());

                    $cantidad_unidades_grupo = 0;

                    if ($repuesto->cantidad_unidades_grupo != null) {

                        $cantidad_ingresada = $cantidad_ingresada * $repuesto->cantidad_unidades_grupo;
                        $costo_unitario = $costo_unitario / $cantidad_ingresada;
                    }
                    $lineaNotaIngreso->cantidad_ingresada = $cantidad_ingresada;

                    $lineaNotaIngreso->id_linea_orden_compra = $numRequest;
                    $lineaNotaIngreso->save();

                    $id_movimiento_repuesto = $this->ingresoAlmacenRepuestos($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario);
                    $lineaNotaIngreso->id_movimiento_ingreso = $id_movimiento_repuesto;
                    $lineaNotaIngreso->save();
                }

                if ($lineaNotaIngreso->getIdOtroProductoServico() != null) {
                    $otro_producto_servicio = OtroProductoServicio::find($lineaNotaIngreso->getIdOtroProductoServico());

                    $id_movimiento_repuesto = $this->ingresoOtroProductoServicio($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario);
                    $lineaNotaIngreso->id_movimiento_ingreso = $id_movimiento_repuesto;
                    $lineaNotaIngreso->save();

                }

                if ($lineaNotaIngreso->getIdVehiculoNuevoInstancia() != null) {
                    $vehiculo_nuevo_instancia = VehiculoNuevoInstancia::find($lineaNotaIngreso->getIdVehiculoNuevoInstancia());

                    $id_movimiento_vehiculo = $this->ingresoVehiculoNuevo($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario);
                    $lineaNotaIngreso->id_movimiento_ingreso = $id_movimiento_vehiculo;
                    $lineaNotaIngreso->save();

                }
            }
        }
      
        $oc_relacionada = $request->input('documentoRelacionado');

        if ($oc_relacionada != null) {
            $orden_compra = OrdenCompra::find($oc_relacionada);
            if ($orden_compra->flagAtentidoTotal()) {
                $orden_compra->es_finalizado = 1;
                $orden_compra->fecha_finalizado = Carbon::now();
                $orden_compra->save();
            }
        }
        
        DB::commit();
        $orden_compra = OrdenCompra::find($nota_ingreso->obtenerOrdenCompraRelacionada());
        if($orden_compra->tipo=="VEHICULOS"){
            return redirect()->route('hojaNotaIngresoVehiculoNuevo', ['id_nota_ingreso' => $id_nota_ingreso]);
        }else{
            return redirect()->route('hojaNotaIngreso', ['id_nota_ingreso' => $id_nota_ingreso]);
        }

        

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

    private function ingresoAlmacenRepuestos($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario)
    {
        $movimiento = new MovimientoRepuesto();
        $movimiento->id_repuesto = $lineaNotaIngreso->getIdRepuesto();
        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
        $movimiento->cantidad_movimiento = $cantidad_ingresada;
        $movimiento->tipo_movimiento = 'INGRESO';
        $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
        $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;

        $costoPromedioOnlyIngreso = $this->getCostoPromedioOnlyIngreso($lineaNotaIngreso->getIdRepuesto(), $cantidad_ingresada, $costo_unitario);

        $saldo = ($this->getStock($lineaNotaIngreso->getIdRepuesto()) + $cantidad_ingresada);
        $movimiento->saldo = $saldo;
        $movimiento->saldo_dolares = $this->getSaldoDolaresIngreso($lineaNotaIngreso->getIdRepuesto(), $cantidad_ingresada * $costo_unitario);
        $movimiento->costo = $costo_unitario;
        $movimiento->costo_promedio_ingreso = $costoPromedioOnlyIngreso > 0 ? $costoPromedioOnlyIngreso : $costo_unitario;
        $movimiento->motivo = 'COMPRAS';

        $movimiento->fecha_movimiento = Carbon::now();
        $movimiento->save();
        return $movimiento->id_movimiento_repuesto;
    }

    private function ingresoOtroProductoServicio($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario)
    {
        $movimiento = new MovimientoOtroProductoServicio();
        $movimiento->id_otro_producto_servicio = $lineaNotaIngreso->getIdOtroProductoServico();
        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
        $movimiento->cantidad_movimiento = $cantidad_ingresada;
        $movimiento->tipo_movimiento = 'INGRESO';
        $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
        $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;

        $saldo = ($this->getStockOtroProductoServicio($lineaNotaIngreso->getIdOtroProductoServico()) + $cantidad_ingresada);
        $movimiento->saldo = $saldo;
        //$movimiento->saldo_dolares = $this->getSaldoDolaresIngresoOtroProductoServicio($lineaNotaIngreso->getIdOtroProductoServico(), $cantidad_ingresada * $costo_unitario);
        $movimiento->costo = $costo_unitario;

        $movimiento->motivo = 'COMPRAS';

        $movimiento->fecha_movimiento = Carbon::now();
        $movimiento->save();

        return $movimiento->id_movimiento_otro_producto_servicio;
    }


    private function ingresoVehiculoNuevo($lineaNotaIngreso, $cantidad_ingresada, $costo_unitario)
    {
        $movimiento = new MovimientoVehiculoNuevo();
        $movimiento->id_vehiculo_nuevo = $lineaNotaIngreso->getIdVehiculoNuevoInstancia();
        $movimiento->id_local_empresa = Auth::user()->empleado->id_local;
        $movimiento->cantidad_movimiento = $cantidad_ingresada;
        $movimiento->tipo_movimiento = 'INGRESO';
        $movimiento->fuente_type = "App\Modelos\LineaNotaIngreso";
        $movimiento->fuente_id = $lineaNotaIngreso->id_linea_nota_ingreso;

        $saldo = ($this->getStockVehiculoNuevo($lineaNotaIngreso->getIdVehiculoNuevoInstancia()) + $cantidad_ingresada);
        $movimiento->saldo = $saldo;
        
        $movimiento->costo = $costo_unitario;

        $movimiento->motivo = 'COMPRAS';

        $movimiento->fecha_movimiento = Carbon::now();
        $movimiento->save();

        return $movimiento->id_vehiculo_nuevo;
    }

    public function downloadPDF()
    {

        $motivo = isset(request()->motivo) ? request()->motivo : false;

        $pdf = PDF::loadView('formatos.reingresos', [
            'motivo' => $motivo,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream();
    }

    private function getStock($id_repuesto)
    {
        $last_movimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento', '!=', "EGRESO VIRTUAL")->orderBy('fecha_movimiento', 'DESC')->first();

        return $last_movimiento != null ? $last_movimiento->saldo : 0;
    }

    private function getStockOtroProductoServicio($id_otro_producto_servicio)
    {
        $last_movimiento = MovimientoOtroProductoServicio::where('id_otro_producto_servicio', $id_otro_producto_servicio)->where('tipo_movimiento', '!=', "EGRESO VIRTUAL")->orderBy('fecha_movimiento', 'DESC')->first();

        return $last_movimiento != null ? $last_movimiento->saldo : 0;
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

    private static function getCostoPromedioOnlyIngreso($id_repuesto, $ingreso, $costo_ingreso)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();

        if ($lastMovimiento == null) {
            return $costo_ingreso;
        } else if ($lastMovimiento->tipo_movimiento == "EGRESO") {
            $costo = (($ingreso * $costo_ingreso) + ($lastMovimiento->saldo * $lastMovimiento->costo)) / ($ingreso + $lastMovimiento->saldo);
            return round($costo, 4);
        } else if ($lastMovimiento->tipo_movimiento == "INGRESO") {
            $costo = (($ingreso * $costo_ingreso) + ($lastMovimiento->saldo * $lastMovimiento->costo_promedio_ingreso)) / ($ingreso + $lastMovimiento->saldo);
            return round($costo, 4);
        }
    }
    private static function balanceWithDevolution($id_repuesto, $cantidad_movimiento)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo - $cantidad_movimiento;
    }

    private static function balanceWithReEntry($id_repuesto, $cantidad_movimiento)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo + $cantidad_movimiento;
    }

    private static function getSaldoDolaresIngresoOtroProductoServicio($id_otro_producto_servicio, $ingreso_dolares)
    {
        $lastMovimiento = MovimientoOtroProductoServicio::where('id_otro_producto_servicio', $id_otro_producto_servicio)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();

        if ($lastMovimiento != null) {
            return $lastMovimiento->saldo_dolares + $ingreso_dolares;
        } else {
            return $ingreso_dolares;
        }
    }

    private static function getSaldoDolaresEgreso($id_repuesto, $egreso_dolares)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        return $lastMovimiento->saldo_dolares - $egreso_dolares;
    }

    private static function getCostWithDevolucion($id_repuesto)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();
        if ($lastMovimiento->tipo_movimiento == "INGRESO") {
            return $lastMovimiento->costo_promedio_ingreso;
        } else {
            return $lastMovimiento->costo;
        }
    }

    private static function getSaldoDolaresIngreso($id_repuesto, $ingreso_dolares)
    {
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento', 'desc')->where('tipo_movimiento', "!=", 'EGRESO VIRTUAL')->first();

        if ($lastMovimiento != null) {
            return $lastMovimiento->saldo_dolares + $ingreso_dolares;
        } else {
            return $ingreso_dolares;
        }
    }

}
