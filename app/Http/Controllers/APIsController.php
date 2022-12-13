<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Administracion\OperacionTrabajoController;
use App\Http\Controllers\Controller;
use App\Modelos\CiaSeguro;
use App\Modelos\Cliente;
use App\Modelos\ComprobanteAnticipo;
use App\Modelos\ComprobanteVenta;
use App\Modelos\Cotizacion;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\OperacionTrabajo;
use App\Modelos\Proveedor;
use App\Modelos\RecepcionOT;
use App\Modelos\Repuesto;
use App\Modelos\ServicioTercero;
use App\Modelos\VehiculoNuevo;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\VehiculoSeminuevo;
// use Auth;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class APIsController extends Controller
{
    private static $limiteSugerencias = 20;

    //Typeahead
    public function buscarOperacionSugerencia($strOperacion, $tipo)
    {
        $lista = OperacionTrabajo::where(DB::raw("CONCAT(cod_operacion_trabajo,' - ',descripcion)"), 'LIKE', "%$strOperacion%");
        $lista = $tipo == "MECANICA" ? $lista->whereIn('tipo_trabajo', OperacionTrabajoController::$tiposMecanica) : $lista->whereIn('tipo_trabajo', OperacionTrabajoController::$tiposDyP);
        $lista = $lista->limit(self::$limiteSugerencias)->get();
        $arreglo = [];
        foreach ($lista as $key => $operacion) {
            $nombreMuestra = $operacion->cod_operacion_trabajo . ' - ' . $operacion->descripcion;
            $codOperacion = $operacion->cod_operacion_trabajo;
            $descripcion = $operacion->descripcion;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $codOperacion, 'second_field' => $descripcion]);
        }
        return $arreglo;
    }

    public function buscarOperacionSugerenciaMEC($strOperacion)
    {
        return $this->buscarOperacionSugerencia($strOperacion, "MECANICA");
    }

    public function buscarOperacionSugerenciaDYP($strOperacion)
    {
        return $this->buscarOperacionSugerencia($strOperacion, "DYP");
    }

    public function buscarRepuestoSugerencia($strRepuesto)
    {
        $lista = Repuesto::where(DB::raw("CONCAT(codigo_repuesto,' - ',descripcion)"), 'LIKE', "%$strRepuesto%")->limit(self::$limiteSugerencias)->get();
        $arreglo = [];
        foreach ($lista as $key => $repuesto) {
            $nombreMuestra = $repuesto->codigo_repuesto . ' - ' . $repuesto->descripcion;
            $codRepuesto = $repuesto->getNroParte();
            $descripcion = $repuesto->descripcion;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $codRepuesto, 'second_field' => $descripcion]);
        }
        return $arreglo;
    }

    public function buscarClienteSugerencia($strCliente)
    {
        $lista = Cliente::where(DB::raw("CONCAT(num_doc,' - ',nombres,' ',apellido_pat,' ',apellido_mat)"), 'LIKE', "%$strCliente%")->limit(self::$limiteSugerencias)->get();
        $arreglo = [];
        foreach ($lista as $key => $cliente) {
            $nombreMuestra = $cliente->num_doc . ' - ' . $cliente->getNombreCompleto();
            $numDoc = $cliente->num_doc;
            $nombre = $cliente->getNombreCompleto();

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $numDoc, 'second_field' => $nombre]);
        }
        return $arreglo;
    }

    public function buscarProveedorSugerencia($strProveedor)
    {
        $lista = Proveedor::where(DB::raw("CONCAT(num_doc,' - ',nombre_proveedor)"), 'LIKE', "%$strProveedor%")->limit(self::$limiteSugerencias)->get();
        $arreglo = [];
        foreach ($lista as $key => $proveedor) {
            $nombreMuestra = $proveedor->num_doc . ' - ' . $proveedor->nombre_proveedor;
            $numDoc = $proveedor->num_doc;
            $nombre = $proveedor->nombre_proveedor;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $numDoc, 'second_field' => $nombre]);
        }
        return $arreglo;
    }

    public function buscarServicioTerceroSugerencia(Request $request)
    {
        $idOT = $request->idOT;
        $es_ot = strpos($idOT, 'O') === 0;
        $es_coti = strpos($idOT, 'C') === 0;

        $strServicioTercero = $request->strServicioTercero;

        $ot = null;
        $coti = null;
        if ($es_ot) {
            $ot = RecepcionOT::with("hojaTrabajo.vehiculo.marcaAuto")->find(str_replace('O', '', $idOT));
        } else if ($es_coti) {          
            $coti = Cotizacion::with("hojaTrabajo.vehiculo.marcaAuto")->find(str_replace('C', '', $idOT));
        }

        if (is_null($ot) && is_null($coti)) return [];

        if (!is_null($ot))
            $marca = $ot->hojaTrabajo->vehiculo->id_marca_auto;
        if (!is_null($coti))
            $marca = $coti->hojaTrabajo->vehiculo->id_marca_auto;


        $lista = ServicioTercero::where(DB::raw("CONCAT(codigo_servicio_tercero,' - ',descripcion)"), 'LIKE', "%$strServicioTercero%")
            ->where('estado', 1)
            ->where('marcas', 'like', '%"M' . $marca . '": "1"%')
            ->limit(self::$limiteSugerencias)->get();

        $arreglo = [];
        foreach ($lista as $key => $servicioTercero) {
            $nombreMuestra = $servicioTercero->codigo_servicio_tercero . ' - ' . $servicioTercero->descripcion;
            $codServicio = $servicioTercero->codigo_servicio_tercero;
            $descripcion = $servicioTercero->descripcion;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $codServicio, 'second_field' => $descripcion]);
        }
        return $arreglo;
    }

    //Select2

    public function buscarTodosOperacion($tipo)
    {
        $lista = $tipo == "MECANICA" ? OperacionTrabajo::where("tipo_trabajo", "MECANICA") : OperacionTrabajo::where("tipo_trabajo", "!=", "MECANICA");
        $lista = $lista->limit(self::$limiteSugerencias)->get();
        $arreglo = [];
        foreach ($lista as $key => $operacion) {
            $nombreMuestra = $operacion->cod_operacion_trabajo . ' - ' . $operacion->descripcion;
            $codOperacion = $operacion->cod_operacion_trabajo;
            $descripcion = $operacion->descripcion;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $codOperacion, 'second_field' => $descripcion]);
        }
        return $arreglo;
    }

    public function buscarTodosOperacionMEC()
    {
        return $this->buscarTodosOperacion("MECANICA");
    }

    public function buscarTodosOperacionDYP()
    {
        return $this->buscarTodosOperacion("DYP");
    }

    public function buscarTodosRepuesto()
    {
        $lista = Repuesto::all();
        $arreglo = [];
        foreach ($lista as $key => $repuesto) {
            $nombreMuestra = $repuesto->codigo_repuesto . ' - ' . $repuesto->descripcion;
            $codRepuesto = $repuesto->getNroParte();
            $descripcion = $repuesto->descripcion;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $codRepuesto, 'second_field' => $descripcion]);
        }
        return $arreglo;
    }

    public function buscarTodosCliente()
    {
        $lista = Cliente::all();
        $arreglo = [];
        foreach ($lista as $key => $cliente) {
            $nombreMuestra = $cliente->num_doc . ' - ' . $cliente->getNombreCompleto();
            $numDoc = $cliente->num_doc;
            $nombre = $cliente->getNombreCompleto();

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $numDoc, 'second_field' => $nombre]);
        }
        return $arreglo;
    }

    public function buscarTodosProveedor()
    {
        $lista = Proveedor::all();
        $arreglo = [];
        foreach ($lista as $key => $proveedor) {
            $nombreMuestra = $proveedor->num_doc . ' - ' . $proveedor->nombre_proveedor;
            $numDoc = $proveedor->num_doc;
            $nombre = $proveedor->nombre_proveedor;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $numDoc, 'second_field' => $nombre]);
        }
        return $arreglo;
    }

    public function buscarTodosServicioTercero()
    {
        $lista = ServicioTercero::all();
        $arreglo = [];
        foreach ($lista as $key => $servicioTercero) {
            $nombreMuestra = $servicioTercero->codigo_servicio_tercero . ' - ' . $servicioTercero->descripcion;
            $codServicio = $servicioTercero->codigo_servicio_tercero;
            $descripcion = $servicioTercero->descripcion;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $codServicio, 'second_field' => $descripcion]);
        }
        return $arreglo;
    }

    public function consultarStock($codigo_repuesto)
    {
        $stock = Repuesto::where('codigo_repuesto', $codigo_repuesto)->first();
        $last_movimiento = MovimientoRepuesto::where('id_repuesto', $stock->id_repuesto)->where('tipo_movimiento', '!=', "EGRESO VIRTUAL")->orderBy('fecha_movimiento', 'DESC')->first();
        $costoUnitario = 0;
        if (!is_null($last_movimiento)) {
            if ($last_movimiento->tipo_movimiento === "EGRESO") {
                $costoUnitario = $last_movimiento->costo ? $last_movimiento->costo : 0;
            }
            if ($last_movimiento->tipo_movimiento === "INGRESO") {
                $costoUnitario = $last_movimiento->costo_promedio_ingreso ? $last_movimiento->costo_promedio_ingreso : 0;
            }
        }
        return [
            'stock' => $stock->getStockVirtual(Auth::user()->empleado->id_local),
            'ubicacion' => $stock->ubicacion,
            'precio_uni' => $stock->pvp,
            'costo_uni' => $costoUnitario,
            'esLubricante' => $stock->esLubricante(),
        ];
    }

    public function asignarDescuentoUnitario($id)
    {

        $item_necesidad_repuesto = ItemNecesidadRepuestos::findOrFail($id);
        $item_necesidad_repuesto->descuento_unitario = request()->descuento_unitario;
        $item_necesidad_repuesto->save();

        $monto_venta_total = number_format($item_necesidad_repuesto->getMontoVentaTotal($item_necesidad_repuesto->getFechaRegistroCarbon(), true), 2);
        $descuento_aplicado = number_format(($monto_venta_total * ($item_necesidad_repuesto->descuento_unitario / 100)), 2);
        $monto_con_descuento = number_format(($monto_venta_total - $descuento_aplicado), 2);

        $response = [
            "monto_venta_total" => $monto_venta_total,
            "descuento_aplicado" => $descuento_aplicado,
            "monto_con_descuento" => $monto_con_descuento,
        ];

        return $response;
    }

    public function buscarSeguros($id)
    {
        $seguro = CiaSeguro::find($id);

        return $seguro;
    }

    public function buscarDataNotaCredito($strNumDoc)
    {

        //$lista = VentaMeson::where("nro_factura", 'LIKE', "%$strNumDoc%")->limit(self::$limiteSugerencias)->get();

        $lista = ComprobanteVenta::where(DB::raw("CONCAT(serie,'-',nro_comprobante)"), 'LIKE', "%$strNumDoc%")->where('tipo_venta', 'MESON')->limit(self::$limiteSugerencias)->get();
        $lista2 = ComprobanteVenta::where(DB::raw("CONCAT(serie,'-',nro_comprobante)"), 'LIKE', "%$strNumDoc%")->where('tipo_venta', '!=', 'MESON')->limit(self::$limiteSugerencias)->get();
        $lista3 = ComprobanteAnticipo::where(DB::raw("CONCAT(serie,'-',nro_comprobante)"), 'LIKE', "%$strNumDoc%")->limit(self::$limiteSugerencias)->get();

        $arreglo = [];
        $items = [];
        $cliente = '';
        $placa = '-';
        $nombre = '-';
        $doc_cliente = '-';
        $direccion = '-';
        $telefono = '-';
        $correo = '-';
        $marca = '-';
        $modelo = '-';
        $kilometraje = '-';
        $vin = '-';
        $motor = '-';
        $ano = '-';
        $color = '-';
        $total_price = 0;
        $taxable_operations = 0;
        $total_igv = 0;
        $moneda = '-';
        $tipo_cambio = '';
        $tipo_operacion = '';
        $tipo_venta = '';
        $sale_id = null;
        $id_comprobante_venta = null;
        $id_comprobante_anticipo = null;

        //////////////
        // Meson//////
        /////////////
        if ($lista != null && count($lista) > 0) {

            $total_descuento = $lista[0]->total_descuento;
            $comprobanteVenta = $lista[0];
            $total_price = $comprobanteVenta->total_venta;
            $taxable_operations = $total_price / 1.18;
            $total_igv = $total_price - $taxable_operations;
            $moneda = $comprobanteVenta->moneda;
            $tipo_cambio = $comprobanteVenta->tipo_cambio;
            $tipo_operacion = $comprobanteVenta->tipo_operacion;
            $tipo_venta = $comprobanteVenta->tipo_venta;
            $sale_id = $comprobanteVenta->sale_id;
            $id_comprobante_venta = $comprobanteVenta->id_comprobante_venta;
            $nombre = $comprobanteVenta->nombre_cliente;
            $doc_cliente = $comprobanteVenta->nrodoc_cliente;
            $direccion = $comprobanteVenta->direccion_cliente;
            $telefono = $comprobanteVenta->telefono;
            $correo = $comprobanteVenta->email;
            $linesCotizacionMeson = $comprobanteVenta->cotizacionMeson->lineasCotizacionMeson;

            //dd($row->cotizacionMeson->comprobanteVenta());

            foreach ($linesCotizacionMeson as $key2 => $rowCotizacionMeson) {
                $valor_venta = $rowCotizacionMeson->getTotalWithDiscount() / 1.18 + $rowCotizacionMeson->getApplicableDiscount() / 1.18;
                $cantidad = $rowCotizacionMeson->cantidad;
                $valor_unitario = $valor_venta / $cantidad;
                array_push($items, (object) [
                    'id' => $rowCotizacionMeson->id_linea_cotizacion_meson,
                    'cantidad' => $cantidad,
                    'codigo' => $rowCotizacionMeson->getCodigoRepuesto(),
                    'descripcion' => $rowCotizacionMeson->getDescripcionRepuesto(),
                    'costo' => 'MESON',
                    'unidad' => 'UNI',
                    'valor_unitario' => round($valor_unitario, 2),
                    'valor_venta' => round($valor_venta, 2),
                    'descuento' => round($rowCotizacionMeson->getApplicableDiscount() / 1.18, 2),
                    'sub_total' => round($rowCotizacionMeson->getTotalWithDiscount() / 1.18, 2),
                    'impuesto' => round($rowCotizacionMeson->getTotalWithDiscount() / 1.18 * 0.18, 2),
                    'total' => round($rowCotizacionMeson->getTotalWithDiscount(), 2),


                ]);
            }
        }
        if ($lista2 != null && count($lista2) > 0) {


            $total_descuento = $lista2[0]->total_descuento;
            $comprobanteVenta = $lista2[0];
            $total_price = $comprobanteVenta->total_venta;
            $taxable_operations = $total_price / 1.18;
            $total_igv = $total_price - $taxable_operations;
            $moneda = $comprobanteVenta->moneda;
            $tipo_cambio = $comprobanteVenta->tipo_cambio;
            $tipo_operacion = $comprobanteVenta->tipo_operacion;
            $tipo_venta = $comprobanteVenta->tipo_venta;
            $sale_id = $comprobanteVenta->sale_id;
            $id_comprobante_venta = $comprobanteVenta->id_comprobante_venta;
            $nombre = $comprobanteVenta->nombre_cliente;
            $doc_cliente = $comprobanteVenta->nrodoc_cliente;
            $direccion = $comprobanteVenta->direccion_cliente;
            $telefono = $comprobanteVenta->telefono;
            $correo = $comprobanteVenta->email;

            $lineaPreFacturacion = $comprobanteVenta->recepcion->generarDetallesFacturacion();

            $placa = $comprobanteVenta->recepcion->hojaTrabajo()->first()->placa_auto;
            $marca = $comprobanteVenta->recepcion->hojaTrabajo()->first()->marcaAuto;
            $modelo = $comprobanteVenta->recepcion->hojaTrabajo()->first()->vehiculo->getModelo();
            $kilometraje = $comprobanteVenta->recepcion->kilometraje;
            $vin = $comprobanteVenta->recepcion->hojaTrabajo()->first()->vehiculo->vin;
            $motor = $comprobanteVenta->recepcion->hojaTrabajo()->first()->vehiculo->motor;
            $ano = $comprobanteVenta->recepcion->hojaTrabajo()->first()->vehiculo->anho_vehiculo;
            $color = $comprobanteVenta->recepcion->hojaTrabajo()->first()->getColor();
            $seguro = $comprobanteVenta->recepcion->ciaSeguro;

            foreach ($lineaPreFacturacion as $key2 => $rowDetalleOt) {

                array_push($items, (object) [
                    'id' => $key2,
                    'cantidad' => $rowDetalleOt->cantidad,
                    'codigo' => $rowDetalleOt->codigo,
                    'descripcion' => $rowDetalleOt->descripcion,
                    'costo' => $rowDetalleOt->tipo,
                    'unidad' => $rowDetalleOt->tipo,
                    'valor_unitario' => round($rowDetalleOt->valorUnitario, 2),
                    'valor_venta' => round($rowDetalleOt->valorVenta, 2),
                    'descuento' => round($rowDetalleOt->descuento, 2),
                    'sub_total' => round($rowDetalleOt->subtotal, 2),

                    'impuesto' => round($rowDetalleOt->igv, 2),
                    'total' => round($rowDetalleOt->precioVenta, 2),
                ]);
            }
        }

        if ($lista3 != null && count($lista3) > 0) {
            $total_descuento = $lista3[0]->total_descuento;
            $total_price = $lista3[0]->total_venta;
            $taxable_operations = $total_price / 1.18;
            $total_igv = $total_price - $taxable_operations;
            $moneda = $lista3[0]->moneda;
            $lineaComprobanteAnticipo = $lista3[0]->lineaComprobanteAnticipo;
            $nombre = $lista3[0]->nombre_cliente;
            $doc_cliente = $lista3[0]->nrodoc_cliente;
            $direccion = $lista3[0]->direccion_cliente;
            $telefono = $lista3[0]->telefono;
            $correo = $lista3[0]->email;
            $tipo_cambio = $lista3[0]->tipo_cambio;
            $tipo_operacion = $lista3[0]->tipo_operacion;
            $tipo_venta = $lista3[0]->venta;
            $sale_id = $lista3[0]->sale_id;
            $id_comprobante_anticipo = $lista3[0]->id_comprobante_anticipo;
            array_push($items, (object) [
                'id' => 1,
                'cantidad' => 1,
                'codigo' => $lineaComprobanteAnticipo->codigo_producto,
                'descripcion' => $lineaComprobanteAnticipo->descripcion,
                'costo' => 'ANTICIPO',
                'unidad' => 'UNI',
                'valor_unitario' => round($lineaComprobanteAnticipo->valor_unitario, 2),
                'valor_venta' => round($lineaComprobanteAnticipo->valor_venta, 2),
                'descuento' => 0,
                'sub_total' => round($lineaComprobanteAnticipo->valor_venta, 2),

                'impuesto' => round($lineaComprobanteAnticipo->igv, 2),
                'total' => round($lineaComprobanteAnticipo->precio_venta, 2),
            ]);
        }

        array_push($arreglo, (object) [
            'nombre' => $nombre,
            'doc_cliente' => $doc_cliente,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'correo' => $correo,
            'placa' => $placa,
            'items' => $items,
            'marca' => $marca,
            'modelo' => $modelo,
            'kilometraje' => $kilometraje,
            'vin' => $vin,
            'motor' => $motor,
            'ano' => $ano,
            'color' => $color,
            'valor_venta' => round($total_price + $total_descuento, 2),
            'descuento' => round($total_descuento, 2),
            'total_price' => round($total_price, 2),
            'taxable_operations' => round($taxable_operations, 2),
            'total_igv' => round($total_igv, 2),
            'moneda' => $moneda,
            'tipo_cambio' => $tipo_cambio,
            'tipo_operacion' => $tipo_operacion,
            'tipo_venta' => $tipo_venta,
            'sale_id' => $sale_id,
            'id_comprobante_venta' => $id_comprobante_venta,
            'id_comprobante_anticipo' => $id_comprobante_anticipo,
        ]);
        return $arreglo;
    }

    public function buscarModeloComercialSugerencia($strModelo)
    {
        $lista = VehiculoNuevo::where('modelo_comercial', 'LIKE', "%$strModelo%")->get();

        $arreglo = [];

        foreach ($lista as $vehiculo) {
            $nombreMuestra = $vehiculo->modelo_comercial;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $nombreMuestra, 'second_field' => '']);
        }

        return $arreglo;
    }


    public function buscarPosiblesIngresosVehiculoNuevo($vin)
    {

        $lista = LineaOrdenCompra::whereNotNull('id_vehiculo_nuevo')->where('vin', 'LIKE', "%$vin%")->get();

        $arreglo = [];

        foreach ($lista as $vehiculo) {
            $nombreMuestra = $vehiculo->vin;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $nombreMuestra, 'second_field' => '']);
        }

        return $arreglo;
    }

    
    public function buscarPosiblesIngresosVehiculoSeminuevo($placa)
    {
        $lista = VehiculoSeminuevo::where('placa', 'LIKE', "%$placa%")->get();

        $arreglo = [];

        foreach ($lista as $vehiculo) {
            $nombreMuestra = $vehiculo->placa;

            array_push($arreglo, (object) ['suggestion_display' => $nombreMuestra, 'input_show' => $nombreMuestra, 'second_field' => '']);
        }

        return $arreglo;
    }
}
