<?php

namespace App\Http\Controllers\Contabilidad;

use Carbon\Carbon;
use App\Helper\Helper;
use App\Modelos\Ubigeo;
use App\Modelos\CiaSeguro;
use App\Modelos\RecepcionOT;
use Illuminate\Http\Request;
use App\Modelos\CotizacionMeson;
use App\Http\Controllers\Controller;
use App\Modelos\EntregadoReparacion;
use App\Http\Controllers\Facturacion\FacturasController;
use App\Modelos\ComprobanteAnticipo;
use App\Modelos\ComprobanteVenta;
use App\Modelos\HojaTrabajo;
use App\Modelos\PagoMetodo;
use App\Modelos\Parametro;
use App\Modelos\TipoVenta;

class ModuloFacturasController extends Controller
{
    public function index(Request $request)
    {
        $anticipos = ComprobanteAnticipo::whereNull('id_comprobante_venta')
            ->whereNull('id_recepcion_ot')->whereNull('id_venta_meson')
            ->with('lineaComprobanteAnticipo')->get();
        $fecha_emision = Carbon::now();
        $fecha_emision_formated = $fecha_emision;
        $fecha_emision = $fecha_emision->format('d/m/Y');

        $pago_metodos = PagoMetodo::all();

        $departamentos = Ubigeo::departamentos();

        $tipoVentas = TipoVenta::all();

        $seguros = CiaSeguro::whereNotNull('ruc')->orderBy('nombre_cia_seguro')->get();

        $entidades = Parametro::where('valor2', 'ENTIDAD FINANCIERA')->get();
        $tarjetas = Parametro::where('valor2', 'TIPO TARJETA')->get();

        return view('contabilidadv2.moduloFacturacion', [
            'fecha_emision' => $fecha_emision,
            'fecha_emision_formated' => $fecha_emision_formated,
            'listaDepartamentos' => $departamentos,
            'seguros' => $seguros,
            'tipoVentas' => $tipoVentas,
            'anticipos' => $anticipos,
            'pago_metodos' => $pago_metodos,
            'entidades' => $entidades,
            'tarjetas' => $tarjetas,
        ]);
    }

    public function store(Request $request)
    {
        #dd($request->all());
        $datos = $request;
        $docRelacionado = $request->documentoRelacionado;
        $motivo = $request->motivoRelacionado;

        if ($motivo === 'FACTURA' || $motivo == "BOLETA") {
            $recepcion_ot = RecepcionOT::find($docRelacionado);
            $estado_ultimo = $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno;

            $cliente = $recepcion_ot->hojaTrabajo->cliente;
            $moneda = $recepcion_ot->hojaTrabajo->moneda;
            $listaItems = $recepcion_ot->generarDetallesFacturacion();
            if (is_null($request->input("incluyeDetraccion"))) {
                $detraccion = false;
            } else {
                $detraccion = true;
            }
            $response = (new FacturasController())->generarFactura($cliente, $listaItems, $detraccion, $datos, $moneda);

            //dd($facturaResponse->url_pdf);
            //dd($facturaResponse->url_pdf);
            //echo "<script>window.open('https://'+'$facturaResponse->url_pdf', '_blank')</script>";
            return redirect()->route('contabilidad.facturacion')->with('pdf_link', $response['factura']->url_pdf);
        } else {
            return view('contabilidadv2.moduloFacturacion');
        }
    }

    public function cargarPendientesFacturacion($filtro, $incluirMeson = false)
    {
        $response = [];

        $recepciones_ots_pre = RecepcionOT::whereHas('hojaTrabajo', function ($q) use ($filtro, $incluirMeson) {

            if ($incluirMeson) $q->where('doc_cliente', $filtro);
            else $q->where('placa_auto', $filtro);
        })->with(['hojaTrabajo.vehiculo.marcaAuto', 'ciaSeguro']);

        $recepciones_ots = $recepciones_ots_pre->whereHas('estadosReparacion', function ($query) {
            $query->whereIn('estado_reparacion.nombre_estado_reparacion_interno', ['liquidado', 'liquidado_hotline'/*,'perdida_total'*/])
                ->where('recepcion_ot_estado_reparacion.es_estado_actual', 1)
                ->orderBy('estado_reparacion.nombre_estado_reparacion');
        })->get();

        $tasaIGV = config('app.tasa_igv');

        foreach ($recepciones_ots as $recepcion) {
            $hojaTrabajo = $recepcion->getHojaTrabajo();
            $moneda = $hojaTrabajo->moneda;
            $monedaCalculo = Helper::obtenerUnidadMonedaCalculo($moneda);
            $precioHoja = 0;
            foreach ($hojaTrabajo->detallesTrabajo as $detalleTrabajo) {
                $precioHoja += $detalleTrabajo->getPrecioVentaFinal($monedaCalculo);
            }
            foreach ($hojaTrabajo->necesidadesRepuestos as $necesidadRepuesto) {
                foreach ($necesidadRepuesto->itemsNecesidadRepuestos as $itemNecesidadRepuesto) {
                    if ($itemNecesidadRepuesto->id_repuesto) //solo se suman los codificados
                        $precioHoja += $itemNecesidadRepuesto->getMontoVentaTotal($itemNecesidadRepuesto->getFechaRegistroCarbon(), true);
                }
            }
            foreach ($hojaTrabajo->serviciosTerceros as $servicioTercero) {
                $precioHoja += $servicioTercero->getPrecioVenta($monedaCalculo);
            }
            $recepcion->valorVenta = number_format($precioHoja / (1 + $tasaIGV), 2);
            $recepcion->precioVenta = number_format($precioHoja, 2);

            $ruta = '';
            if ($recepcion->hojaTrabajo->tipo_trabajo == 'DYP') {
                $ruta = route('detalle_trabajos.index', ['id_recepcion_ot' => $recepcion->id_recepcion_ot]);
            } else {
                $ruta = route('mecanica.detalle_trabajos.index', ['id_recepcion_ot' => $recepcion->id_recepcion_ot]);
            }

            $response[] = [
                'seccion' => $recepcion->hojaTrabajo->tipo_trabajo == 'DYP' ? 'B&P' : 'MEC',
                'documento' => $recepcion->id_recepcion_ot,
                'valorVenta' => $recepcion->valorVenta,
                'precioVenta' => $recepcion->precioVenta,
                'simbolo' => \App\Helper\Helper::obtenerUnidadMoneda($hojaTrabajo->moneda),
                'moneda' => $hojaTrabajo->moneda,
                'ruta' => $ruta
            ];
        }

        if ($incluirMeson) {
            $ventasMeson = CotizacionMeson::where('doc_cliente', $filtro)->whereHas('ventasMeson', function ($query) {
                $query->whereNull('fecha_venta')->whereNull('nro_factura');
            })->whereDoesntHave('lineasCotizacionMeson', function ($query) {
                $query->where('es_atendido', 0)->orWhereNull('es_atendido');
            })->orderBy('fecha_registro')->get();

            foreach ($ventasMeson as $venta) {
                $response[] = [
                    'seccion' => 'MESON',
                    'documento' => $venta->ventasMeson->first()->id_venta_meson,
                    'valorVenta' => number_format($venta->getValueDiscountedQuote2Approved() / (1 + config('app.tasa_igv')), 2),
                    'precioVenta' => number_format($venta->getValueDiscountedQuote2Approved(), 2),
                    'simbolo' => \App\Helper\Helper::obtenerUnidadMoneda($venta->moneda),
                    'moneda' => $venta->moneda,
                    'ruta' => route('meson.show', $venta->id_cotizacion_meson)
                ];
            }
        }

        return $response;
    }

    public function consultaInfoOT($docRelacionado)
    {

        $repuestos_pendientes = HojaTrabajo::where('id_recepcion_ot', $docRelacionado)->whereHas('necesidadesRepuestos', function ($q) {
            $q->whereHas('itemsNecesidadRepuestos', function ($q2) {
                $q2->whereIn('es_importado', [1, 0])->where('entregado', '!=', 1);
            });
        })->first();

        $anticipos_asociados = ComprobanteAnticipo::where('id_recepcion_ot', $docRelacionado)->get();
        $total_anticipos = 0;
        foreach ($anticipos_asociados as $anticipo) {
            $total_anticipos += $anticipo->total_venta;
        }

        $OTRelacionada = $docRelacionado;
        $ot = RecepcionOT::findOrFail($OTRelacionada);
        $seguro = [];

        $seccion = $ot->seccion();

        $id_seccion = TipoVenta::where('nombre_venta', $seccion)->first()->id_tipo_venta;

        $seguroParticular = false;
        $seguroFacturado = true;
        $facturarSeguro = false;
        $deducibleFacturado = false;

        $comprobanteAnticipo = ComprobanteAnticipo::where('id_recepcion_ot', $OTRelacionada)->get();
        if(count($comprobanteAnticipo)) $deducibleFacturado = true;

        if ($seccion == 'B&P') {
            $seguro = $ot->ciaSeguro;
            $seguro['departamento'] = $seguro->ubicacion->departamento;
            $seguro['provincia'] = $seguro->ubicacion->provincia;
            $seguro['distrito'] = $seguro->ubicacion->distrito;

            $seguroNombre = $seguro->nombre_cia_seguro;
            $comprobanteVenta = ComprobanteVenta::where('id_recepcion_ot', $OTRelacionada)->where('es_seguro', 1)->get();
            if (!count($comprobanteVenta)) {
                $seguroFacturado = false;
            } else {
                $facturarSeguro = true;
            }
            
            if ($seguroNombre == 'PARTICULAR') {
                $seguroParticular = true;
            }
        }

        $moneda = $ot->moneda;

        $items_repuestos = $repuestos_pendientes ? $repuestos_pendientes->necesidadesRepuestos->first()->itemsNecesidadRepuestos : [];

        if ($items_repuestos) {
            $items_repuestos = $items_repuestos->filter(function ($value) {
                $disponibilidad = $value->getDisponibilidad();
                return  $disponibilidad == 'EN IMPORTACIÓN' || $disponibilidad == 'EN TRÁNSITO';
            });
        }

        $res_pendientes = [];

        foreach ($items_repuestos as $item) {
            $total = $item->id_repuesto ? $item->getMontoVentaTotal($item->getFechaRegistroCarbon(), true, $item->descuento_unitario ?? 0, false, $item->descuento_unitario_dealer ?? -1) : '0';
            $res_pendientes[] = [
                'codigo' => $item->getCodigoRepuesto(),
                'descripcion' => $item->getDescripcionRepuestoTexto(),
                'disponibilidad' => $item->getDisponibilidad(),
                'cantidad' => $item->getCantidadRepuestosTexto(),
                'sub_total' => $total / (1 + config('app.tasa_igv')),
                'impuesto' => $total - $total / (1 + config('app.tasa_igv')),
                'total' => $total,
                'moneda' => $moneda,
                'simbolo' => \App\Helper\Helper::obtenerUnidadMoneda($moneda)
            ];
        }

        $tipo_ot = $ot->hojaTrabajo->tipo_trabajo == 'DYP' ? 'B&P' : 'MEC';

        if (is_null($ot)) {
            return [
                'status' => 'error',
                'message' => 'La OT ingresada no existe'
            ];
        }

        #if(!is_null(EntregadoReparacion::where('id_recepcion_ot', $ot->id_recepcion_ot)->first()) && $seccion == 'B&P') $deducibleFacturado = true;
        if (!is_null(EntregadoReparacion::where('id_recepcion_ot', $ot->id_recepcion_ot)->first()) && $seguroFacturado) {
            return [
                'status' => 'error',
                'message' =>  'La OT ingresada se encuentra facturada'
            ];
        }
        
        if (!is_null($ot->otCerrada->first())) {
            return [
                'status' => 'error',
                'message' =>  'La OT ingresada se encuentra cerrada'
            ];
        }
        
        if ($ot->estadoActual()[0]->nombre_estado_reparacion_filtro != 'LIQUIDADO') {
            return [
                'status' => 'error',
                'message' => 'La OT ingresada no está liquidada'
            ];
        }

        $hojaTrabajo = $ot->hojaTrabajo;
        $numOT = $ot->id_recepcion_ot;
        $moneda = $hojaTrabajo->moneda;
        $vehiculo = $hojaTrabajo->vehiculo;
        $vehiculo['modelo'] = $hojaTrabajo->vehiculo->getModelo();
        $vehiculo['marca'] = $hojaTrabajo->vehiculo->marcaAuto->nombre_marca;
        $vehiculo['kilometraje'] = $ot->kilometraje;
        $tipoCambio = $hojaTrabajo->tipo_cambio;
        $tipoOperacion = "Venta";
        $tipoVenta = "Servicio Taller";
        $motivoEmision = "Facturación";
        $cliente = $hojaTrabajo->cliente;
        $lineasFacturacion = $ot->generarDetallesFacturacion();
        $valorVenta = 0;
        $descuento = 0;
        $subTotalValorVenta = 0;
        $impuesto = 0;
        $total = 0;
        foreach ($lineasFacturacion as $lineaFacturacion) {
            $valorVenta += $lineaFacturacion->valorVenta;
            $descuento += $lineaFacturacion->descuento;
            $subTotalValorVenta += $lineaFacturacion->subtotal;
            $impuesto += $lineaFacturacion->igv;
            $total += $lineaFacturacion->precioVenta;
        }

        $cliente['nomCliente'] = $ot->factura_para ?? $cliente->getNombreCompleto();
        $cliente['doc_cliente'] = $ot->num_doc ?? $cliente['doc_cliente'];
        $cliente['direccion'] = $ot->direccion ?? $cliente['direccion'];
        $cliente['celular'] = $ot->hojaTrabajo->telefono_contacto2 ?? $ot->hojaTrabajo->telefono_contacto;
        $cliente['email'] = $ot->hojaTrabajo->email_contacto2 ?? $ot->hojaTrabajo->email_contacto;
        $cliente['departamento'] = substr($cliente->cod_ubigeo, 0, 2);
        $cliente['provincia'] = substr($cliente->cod_ubigeo, 2, 2);
        $cliente['distrito'] = substr($cliente->cod_ubigeo, 4, 2);

        
        $detraccion = false;
        if ($moneda == 'SOLES' && $total > 700) $detraccion = true;
        if ($moneda == 'DOLARES' && $total * \App\Modelos\TipoCambio::getTipoCambioCobroActual() > 700) $detraccion = true;

        $ruta = '';
        if ($ot->hojaTrabajo->tipo_trabajo == 'DYP') {
            $ruta = route('detalle_trabajos.index', ['id_recepcion_ot' => $ot->id_recepcion_ot]);
        } else {
            $ruta = route('mecanica.detalle_trabajos.index', ['id_recepcion_ot' => $ot->id_recepcion_ot]);
        }

        return [
            'documento' => $ot,
            'numDocumento' => $numOT,
            'moneda' => $moneda,
            'tipoCambio' => $tipoCambio,
            'vehiculo' => $vehiculo,
            'tipoOperacion' => $tipoOperacion,
            'tipoVenta' => $tipoVenta,
            'motivoEmision' => $motivoEmision,
            'cliente' => $cliente,
            'lineasFacturacion' => $lineasFacturacion,
            'valorVenta' => $valorVenta,
            'descuento' => $descuento,
            'subTotalValorVenta' => $subTotalValorVenta,
            'impuesto' => $impuesto,
            'precioVenta' => $total,
            'tipo_ot' => $tipo_ot,
            'seguro' => $seguro,
            'detraccion' => $detraccion,
            'ruta' => $ruta,
            'tiene_repuestos_pendientes' => count($res_pendientes) ?? false,
            'repuestos_pendientes' => $res_pendientes,
            'seguroParticular' => $seguroParticular,
            'seccion' => $seccion,

            'id_seccion' => $id_seccion,

            'anticipos_asociados' => $anticipos_asociados,
            'total_anticipos' => $total_anticipos,
            'seguroFacturado' => $seguroFacturado,
            'facturarSeguro' => $facturarSeguro,
            'deducibleFacturado' => $deducibleFacturado
        ];
    }

    public function consultaInfoMeson($docRelacionado)
    {

        $lista = CotizacionMeson::whereHas('ventasMeson', function ($q) use ($docRelacionado) {
            $q->where('id_venta_meson', $docRelacionado);
        })->get();

        foreach ($lista as $item) {
            if ($item->ventasMeson->first()->fecha_venta && $item->ventasMeson->first()->nro_factura) {
                return response()->json([
                    'status' => 'error',
                    'message' =>  'La NV ingresada se encuentra facturada'
                ]);
            }
        }

        $anticipos_asociados = ComprobanteAnticipo::where('id_venta_meson', $docRelacionado)->get();
        $total_anticipos = 0;
        foreach ($anticipos_asociados as $anticipo) {
            $total_anticipos += $anticipo->total_venta;
        }
        $tasaIGV = config('app.tasa_igv');
        $repuestos_pendientes = CotizacionMeson::whereHas('ventasMeson', function ($q) use ($docRelacionado) {
            $q->where('id_venta_meson', $docRelacionado);
        })->whereHas('lineasCotizacionMeson', function ($q2) {
            $q2->whereIn('es_importado', [1, 0])->where('es_entregado', '!=', 1);
        })->first();

        $items_repuestos = $repuestos_pendientes ? $repuestos_pendientes->lineasCotizacionMeson : [];

        if ($items_repuestos) {
            $items_repuestos = $items_repuestos->filter(function ($value) {
                $disponibilidad = $value->getDisponibilidadRepuestoText();
                return $disponibilidad == 'EN IMPORTACIÓN' || $disponibilidad == 'EN TRÁNSITO';
            });
        }

        $seccion = 'MESON';
        $id_seccion = TipoVenta::where('nombre_venta', $seccion)->first()->id_tipo_venta;

        $res_pendientes = [];
        
        $moneda = $lista[0]->moneda;

        foreach ($items_repuestos as $item) {
            $total = $item->getTotalWithDiscount() ?? 0;
            $res_pendientes[] = [
                'codigo' => $item->getCodigoRepuesto(),
                'descripcion' => $item->getDescripcionRepuesto(),
                'disponibilidad' => $item->getDisponibilidadNotaVenta(),
                'cantidad' => $item->getCantidadGrupo(),
                'sub_total' => $total / (1 + config('app.tasa_igv')),
                'impuesto' => $total - $total / (1 + config('app.tasa_igv')),
                'total' => $total,
                'moneda' => $moneda,
                'simbolo' => \App\Helper\Helper::obtenerUnidadMoneda($moneda)
            ];
        }


        $arreglo = [];
        $items = [];
        $cliente = '';
        $placa = '-';
        $nombre = '-';
        $doc_cliente = '-';
        $direccion = '-';
        $telefono = '-';
        $correo = '-';
        $valorVenta = 0;
        $descuento = 0;
        $subTotalValorVenta = 0;
        $impuesto = 0;
        $precioVenta = 0;
        if ($lista != null) {

            foreach ($lista as $key => $row) {
                $departamento = substr($row->cod_ubigeo, 0, 2);
                $provincia = substr($row->cod_ubigeo, 2, 2);
                $distrito = substr($row->cod_ubigeo, 4, 2);
                $nombre = $row->nombre_cliente;
                $doc_cliente = $row->doc_cliente;
                $direccion = $row->direccion_contacto;
                $telefono = $row->telefono_contacto;
                $correo = $row->email_contacto;
                $moneda = $row->moneda;
                $tipo_cambio = $row->tipo_cambio;
                $linesCotizacionMeson = $row->lineasCotizacionMeson;
                $ruta = route('meson.show', $row->id_cotizacion_meson);

                foreach ($linesCotizacionMeson as $key2 => $rowCotizacionMeson) {
                    
                    #$valor_venta = $rowCotizacionMeson->getTotalWithDiscount() / 1.18 + $rowCotizacionMeson->getApplicableDiscount();
                    $cantidad = $rowCotizacionMeson->cantidad;
                    $valor_venta = $rowCotizacionMeson->getMontoUnitario($rowCotizacionMeson->getFechaRegistroCarbon(), false) * $cantidad;
                    $valor_unitario = $valor_venta / $cantidad;
                    $valorVenta += $valor_venta;
                    $descuento += $rowCotizacionMeson->getApplicableDiscount() * $cantidad;
                    $subTotalValorVenta += $rowCotizacionMeson->getTotalWithDiscount() / 1.18;
                    $impuesto += $rowCotizacionMeson->getTotalWithDiscount() / 1.18 * 0.18;
                    $precioVenta += $rowCotizacionMeson->getTotalWithDiscount();
                    array_push($items, (object) [
                        'id' => $rowCotizacionMeson->id_linea_cotizacion_meson,
                        'cantidad' => $cantidad,
                        'codigo' =>  $rowCotizacionMeson->getCodigoRepuesto(),
                        'descripcion' => $rowCotizacionMeson->getDescripcionRepuesto(),
                        'costo' => 'MESON',
                        'unidad' => 'PRODUCTO',
                        'valor_unitario' => $valor_unitario,
                        'valor_venta' => $valor_venta,
                        'descuento' => $rowCotizacionMeson->getApplicableDiscount() * $cantidad,
                        'sub_total' => $rowCotizacionMeson->getTotalWithDiscount() / 1.18,
                        'impuesto' => $rowCotizacionMeson->getTotalWithDiscount() / 1.18 * 0.18,
                        'impuestoSinDescuento' => $valor_venta * $tasaIGV,
                        'total' => $rowCotizacionMeson->getTotalWithDiscount()
                    ]);
                }
            }
        }

        $detraccion = false;
        if ($moneda == 'SOLES' && $precioVenta > 700) $detraccion = true;
        if ($moneda == 'DOLARES' && $precioVenta * \App\Modelos\TipoCambio::getTipoCambioCobroActual() > 700) $detraccion = true;


        array_push($arreglo, (object) [
            'valorVenta' => $valorVenta,
            'descuento' => $descuento,
            'subTotalValorVenta' => $subTotalValorVenta,
            'impuesto' => $impuesto,
            'precioVenta' => $precioVenta,
            'detraccion' => $detraccion,
            'nombre' => $nombre,
            'moneda' => $moneda,
            'tipo_cambio' => $tipo_cambio,
            'doc_cliente' => $doc_cliente,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'correo' => $correo,
            'placa' => $placa,
            'items' => $items,
            'ruta' => $ruta,
            'tiene_repuestos_pendientes' => count($res_pendientes) ?? false,
            'repuestos_pendientes' => $res_pendientes,
            'seguroParticular' => false,

            'seccion' => $seccion,
            'id_seccion' => $id_seccion,
            'anticipos_asociados' => $anticipos_asociados,
            'total_anticipos' => $total_anticipos,
            'departamento' => $departamento,
            'provincia' => $provincia,
            'distrito' => $distrito,

            'seccion' => 'MESON',
            'anticipos_asociados' => $anticipos_asociados,
            'total_anticipos' => $total_anticipos,

        ]);
        return $arreglo;
    }


    public function apiFacturaStore(Request $request)
    {
        #return $request->all();
        $datos = $request;
        $docRelacionado = $request->documentoRelacionado;
        $motivo = $request->motivoRelacionado;
        $tipoVenta = $request->tipoVenta;
        $tipoOperacion = $request->tipoOperacion;

        if ($motivo === 'FACTURA' || $motivo == "BOLETA") {

            if (($tipoVenta == 'MEC' || $tipoVenta == 'B&P') && $tipoOperacion != 'ANTICIPO') {
                $response = (new FacturasController())->generarFactura($datos);
            } else if ($tipoVenta == 'MESON' && $tipoOperacion != 'ANTICIPO') {
                $meson = $this->consultaInfoMeson($docRelacionado);
                $meson = $meson[0];
                $response = (new FacturasController())->generarFacturaMeson($datos, $meson);
            } else if ($tipoVenta == 'GARANTIAS' || $tipoVenta == 'GENERAL' || $tipoOperacion == 'ANTICIPO') {
                $response = (new FacturasController())->generarFacturaGeneral($datos);
                return [
                    'status' => 'ok',
                    'message' => "¡{$motivo} GENERADA!",
                    'url' => $response['factura']['url_pdf'],
                    'correlativo' => $response['json']['number'],
                    'ruta_entrega' => '',
                    'ruta_constancia' => $response['ruta_constancia'],
                ];
            }

            return [
                'status' => 'ok',
                'message' => "¡{$motivo} GENERADA!",
                'url' => $response['factura']->url_pdf,
                'correlativo' => $response['json']['number'],
                'ruta_entrega' => $response['ruta_entrega'],
                'ruta_constancia' => $response['ruta_constancia']
            ];
        } else {
            return view('contabilidadv2.moduloFacturacion');
        }
    }

    public function listarAnticipos()
    {
        $anticipos = ComprobanteAnticipo::whereNull('id_comprobante_venta')->with('lineaComprobanteAnticipo')->get();

        return response()->json($anticipos);
    }

    public function obtenerSerie($venta)
    {
        $tipoVenta = TipoVenta::where('nombre_venta', $venta)->first();

        return [
            'venta' => $venta,
            'serie' => $tipoVenta->serie->numero ?? '',
        ];
    }
}
