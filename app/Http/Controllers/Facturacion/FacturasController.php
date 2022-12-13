<?php

namespace App\Http\Controllers\Facturacion;

use DB;
use Auth;
use Excel;
use Carbon\Carbon;
use App\Modelos\Cliente;
use App\Modelos\VentaMeson;
use App\Modelos\RecepcionOT;
use Illuminate\Http\Request;
use App\Modelos\CotizacionMeson;
use App\Modelos\ComprobanteVenta;
use App\Modelos\MovimientoRepuesto;
use App\Http\Controllers\Controller;
use App\Modelos\ComprobanteAnticipo;
use App\Modelos\EntregadoReparacion;
use App\Modelos\LineaCotizacionMeson;
use App\Modelos\LineaComprobanteVenta;
use App\Modelos\LineaComprobanteAnticipo;
use App\Http\Controllers\Administracion\UsuarioController;
use App\Modelos\Proveedor;
use App\Rebate;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    /**
     * Realiza la solicitud de factura a componente externo
     *
     * @param  ComprobanteVenta  $id
     * @return App\Modelos\ComprobanteVenta
     */
    public function generarFactura($datos)
    {                
        DB::beginTransaction();

        $descuentoTotal = 0;
        $subtotalFactura = 0;
        $totalIGV = 0;
        $totalFactura = 0;

        $seguroParticular = false;

        $tipo_comprobante = $datos->motivoRelacionado;
        $docRelacionado = $datos->documentoRelacionado;
        $tipoVenta = $datos->tipoVenta;
        $email = $datos->email;
        $telefono = $datos->telefono;
        $tipo_cambio = $datos->tipo_cambio;
        $observaciones_entregado = $datos->observaciones_entregado;
        $tipoTarjeta = $datos->tipoTarjeta;
        $entidadFinanciera = $datos->entidadFinanciera ?? null;

        if ($tipoVenta == 'MEC' || $tipoVenta == 'B&P') {
            $recepcion_ot = RecepcionOT::find($docRelacionado);
            
            $moneda = $recepcion_ot->hojaTrabajo->moneda;
            $listaProductos = $recepcion_ot->generarDetallesFacturacion();
            $seccion = $recepcion_ot->seccion();
            $seguro = $recepcion_ot->getNombreCiaSeguro();

            if ($seccion == 'B&P' && $seguro == 'PARTICULAR') {
                $seguroParticular = true;
            }

            foreach ($listaProductos as $lineaFacturacion) {
                #$valorVenta += $lineaFacturacion->valorVenta;
                $descuentoTotal += $lineaFacturacion->descuentoConIgv; // Para sibi debemos enviar con IGV
                $subtotalFactura += $lineaFacturacion->subtotal;
                $totalIGV += $lineaFacturacion->igv; // Para sibi debemos enviar con IGV
                $totalFactura += $lineaFacturacion->precioVenta;
            }

            if ($datos->anticipos_a_asociar) {
                $anticipos_a_asociar = explode(',', $datos->anticipos_a_asociar);
                foreach($anticipos_a_asociar as $anticipo) {
                    $anticipo_agregado = \App\Modelos\ComprobanteAnticipo::find($anticipo);
                    $anticipo_agregado->id_recepcion_ot = $docRelacionado;
                    $anticipo_agregado->save();
                }
            }
            $anticipos_asociados = \App\Modelos\ComprobanteAnticipo::where('id_recepcion_ot', $docRelacionado)->get();
            $advances = ''; //representa los anticipos
            $total_advances = 0;
            $total_advances_igv = 0;
            $total_advances_sub = 0;
            $estado_advance = 0;
            if (count($anticipos_asociados)) {
                $estado_advance = 2;
                $advances = 'advances: [';
                foreach ($anticipos_asociados as $anticipo) {
                    $total_advances_igv += $anticipo->total_igv;
                    $total_advances += $anticipo->total_venta;
                    $total_advances_sub += $anticipo->monto_sujeto_igv;
                    $advances .= '{id: '. $anticipo->id_advance .'},';
                }
                $advances .= '
            ],
            total_advances: '.$total_advances.',
            ';

            }
            
        } else if ($tipoVenta == 'MESON') {
            $meson = (new \App\Http\Controllers\Contabilidad\ModuloFacturasController)->consultaInfoMeson($docRelacionado);
            $meson = $meson[0];

            $descuentoTotal = $meson->descuento;
            $subtotalFactura = $meson->subTotalValorVenta;
            $totalIGV = $meson->impuesto;
            $totalFactura = $meson->precioVenta;
            $moneda = $meson->moneda;
            $listaProductos = $meson->items;
        }

        $detraccion_msg = '';
        $detraccion = false;
        if ($moneda == 'SOLES') {
            if ($totalFactura > 700) $detraccion = true;
            $coin = 'PEN';
        } else if ($moneda == 'DOLARES') {
            if ($totalFactura * \App\Modelos\TipoCambio::getTipoCambioCobroActual() > 700) $detraccion = true;
            $coin = 'USD';
        }

        if ($detraccion && $tipo_comprobante == 'FACTURA') {
            $detraccion_msg = '
                detraction: 0.12,
                detraction_code: "022",
            ';
        }

        if ($tipo_comprobante == 'FACTURA') {
            $tipo_documento = '01';
            switch ($datos->tipoVenta) {
                case 'MEC':
                    $serie = 'F001';
                    break;
                case 'BYP':
                    $serie = 'F001';
                    break;
            }
        } else {
            $tipo_documento = '03';
            switch ($datos->tipoVenta) {
                case 'MEC':
                    $serie = 'B001';
                    break;
                case 'BYP':
                    $serie = 'B001';
                    break;
            }
        }

        $detraccionMensaje = $detraccion ? 'Mantenimiento y reparación de bienes muebles - 12%' : 'Sin detracción';

        $detailsInvoice = [];
        $factura = new ComprobanteVenta();

        $docCliente = $datos->docCliente;
        $nomCliente = $datos->nomCliente;
        $direccionCliente = $datos->direccionCliente;

        if (isset($datos->deducible) && $datos->deducible == 'SEGURO' && !$seguroParticular) {
            $docCliente = $datos->seguroRUC;
            $nomCliente = $datos->seguroRS;
            $direccionCliente = $datos->seguroDir;
            $nro_poliza = $datos->nro_poliza;
            $nro_siniestro = $datos->nro_siniestro;
            if($recepcion_ot->nro_poliza != $nomCliente) $recepcion_ot->nro_poliza = $nro_poliza;
            if($recepcion_ot->nro_siniestro != $nomCliente) $recepcion_ot->nro_siniestro = $nro_siniestro;
            $factura->es_seguro = 1;
        } else {
            if($recepcion_ot->factura_para != $nomCliente) $recepcion_ot->factura_para = $nomCliente;
            if($recepcion_ot->num_doc != $docCliente) $recepcion_ot->num_doc = $docCliente;
            if($recepcion_ot->direccion != $direccionCliente) $recepcion_ot->direccion = $direccionCliente;

            $ubigeo = $datos->departamento . $datos->provincia . $datos->distrito;
            if($recepcion_ot->hojaTrabajo->telefono_contacto != $telefono) $recepcion_ot->hojaTrabajo->telefono_contacto2 = $telefono;
            if($recepcion_ot->hojaTrabajo->email_contacto != $email) $recepcion_ot->hojaTrabajo->email_contacto2 = $email;
            if($recepcion_ot->hojaTrabajo->cliente->cod_ubigeo != $ubigeo) $recepcion_ot->hojaTrabajo->cliente->cod_ubigeo = $ubigeo;
            if($recepcion_ot->hojaTrabajo->cliente->celular != $telefono) $recepcion_ot->hojaTrabajo->cliente->celular = $telefono;
            if($recepcion_ot->hojaTrabajo->cliente->email != $email) $recepcion_ot->hojaTrabajo->cliente->email = $email;
            
        }
        $recepcion_ot->push();

        $serie = $datos->serie;
        $factura->fill([
            'tipo_comprobante' => $tipo_comprobante,
            'serie' => $serie,
            #'nro_comprobante' => $nroFactura,
            'nrodoc_cliente' => $docCliente,
            'nombre_cliente' => $nomCliente,
            'direccion_cliente' => $direccionCliente,
            'fecha_emision' => date('Y-m-d'),
            'formato_impresion' => 'A4',
            'total_descuento' => $descuentoTotal,
            'total_venta' => $totalFactura,
            'monto_sujeto_igv' => $subtotalFactura,
            'tasa_detraccion' => $detraccion ? 0.12 : 0,
            'monto_inafecto' => 0,
            'monto_exonerado' => 0,
            'total_igv' => $totalIGV,
            'moneda' => $moneda,
            'email' => $email,
            'telefono' => $telefono,
            'tipo_cambio' => $tipo_cambio,
        ]);
        $factura->save();

        $details = '';

        if (isset($datos->deducible) && $datos->deducible == 'DEDUCIBLE' && !$seguroParticular) {
            $montoDeducible = $datos->montoDeducible ?? 0;
            $descuentoTotal = 0;
            $subtotalFactura = $montoDeducible / 1.18;
            $totalIGV = $subtotalFactura * 0.18;
            $totalFactura = $montoDeducible;
            $lineaFactura = new LineaComprobanteVenta();
            $lineaFactura->fill([
                'cantidad' => 1,
                'unidad_medida' => '-',
                'codigo_producto' => '-',
                'descripcion' => 'DEDUCIBLE',
                'tipo_igv' => 'GRAVADO',
                'valor_unitario' => $montoDeducible,
                'valor_venta' => $montoDeducible,
                'igv' => 0,
                'precio_venta' => $montoDeducible
            ]);
            $lineaFactura->id_comprobante_venta = $factura->id_comprobante_venta;
            $lineaFactura->save();

            $tasaIGV = config('app.tasa_igv');
            $details .= '
              {
                item_id: 1,
                quantity: 1,
                unit_measure: "ZZ",
                code: "-",
                description: "DEDUCIBLE",        
                igv_type: "10",
                discount: 0, 
                unit_value: ' . ($montoDeducible / (1 + $tasaIGV)) . ',
                sale_value: ' . $montoDeducible . ',
                igv: 0,        
                unit_price: ' . $montoDeducible . ',
              },
            ';
        } else {

            $item_id = 1;
            foreach ($listaProductos as $key => $item) {
                $lineaFactura = new LineaComprobanteVenta();
                $lineaFactura->fill([
                    'cantidad' => $item->cantidad,
                    'unidad_medida' => ($item->tipo == 'PRODUCTO' ? 'NIU' : 'ZZ'),
                    'codigo_producto' => $item->codigo,
                    'descripcion' => $item->descripcion,
                    'tipo_igv' => 'GRAVADO',
                    'valor_unitario' => $item->valorUnitario,
                    'valor_venta' => $item->valorVenta,
                    'igv' => $item->igv,
                    'precio_venta' => $item->precioVenta
                ]);
                $lineaFactura->id_comprobante_venta = $factura->id_comprobante_venta;
                $lineaFactura->save();

                $tasaIGV = config('app.tasa_igv');

                $unit_price = $item->valorUnitario * (1 + $tasaIGV);
                $sale_value = $item->valorUnitario * $item->cantidad;

                $details .= '
                {
                    item_id: 1,
                    quantity: ' . $item->cantidad . ',
                    unit_measure: "' . ($item->tipo == 'PRODUCTO' ? 'NIU' : 'ZZ') . '",
                    code: "' . $item->codigo . '",
                    description: "' . $item->descripcion . '",        
                    igv_type: "10",
                    discount: ' . $item->descuentoConIgv . ', 
                    unit_value: ' . $item->valorUnitario . ',
                    sale_value: ' . $sale_value . ',
                    igv: ' . $item->igvSinDescuento . ',        
                    unit_price: ' . $unit_price . ',
                },
                ';
            }
        }

        $anticipo = false;

        $httpClient = new \GuzzleHttp\Client();

        $body = '
            mutation {
            sales(
            document_type: "' . $tipo_documento . '",
            serie: "' . $serie . '",
            coin: "' . $coin . '",
            contact_identity: "' . $docCliente . '",
            contact_name: "' . $nomCliente . '",
            contact_address: "' . $direccionCliente . '",
            observations: "' . $datos->observaciones . '",
            pdf: "a4", 
            total_igv: ' . ($totalIGV - $total_advances_igv) . ',    
            total_discount: '.$descuentoTotal.',
            total_price: ' . ($totalFactura - $total_advances)  . ',         
            taxable_operations: ' . ($subtotalFactura - $total_advances_sub) . ',
            unaffected_operations: 0,
            exempted_operations: 0,
            created_from: 0,   
            advance: '.$estado_advance.',
            '.$advances.'
            proforma: false,
            ' . $detraccion_msg . '
            details: [' . $details . ']
            ) {    
                id
                number
                sunat_description
                pdf
                result    
                sunat_code
                advanceDB{
                  id
                } 
            }
        }
        ';

        /* if($detraccion){
            $diccDetraccion = ['detraction' => 0.12,
                               'detraction_code' => '022' ];
            $body = array_merge($body, $diccDetraccion);
        } */


        $token = env('SIBI_TOKEN');

        $header = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ];
        
        $response = $httpClient->post(env('SIBI_URL'), ['headers' => $header, 'body' => json_encode([
            'query' => $body
        ])]);
        $bodyResponse = $response->getBody();
        $json = (object) json_decode($bodyResponse->read(1024), true);
        
        $json = $json->data['sales'];
        $number = \App\Helper\Helper::generarNroComprobante($json['number']);
        $numeracionFactura = "{$serie}-{$number}";

        $url_pdf = "https://app.sibi.pe/pdf/vouchers/20606257261/{$tipo_documento}/" . $json['id'];
        $factura->url_pdf = $url_pdf;
        $factura->sale_id = $json['id'];
        $factura->sunat_code = $json['sunat_code'];
        $factura->sunat_description = $json['sunat_description'];
        $factura->nro_comprobante = $number;
        $factura->id_tipo_tarjeta = $tipoTarjeta;
        $factura->id_entidad_financiera = $entidadFinanciera;
        $factura->nro_operacion = $datos->nro_operacion;
        $factura->id_recepcion_ot = $datos->documentoRelacionado;
        $factura->tipo_operacion = $datos->tipoOperacion;
        $factura->tipo_venta = $datos->tipoVenta;

        #$factura->recepcion->entregas->fecha_entrega = Carbon::now();
        #$factura->recepcion->entregas->nro_factura = $numeracionFactura;
        $factura->observaciones = $datos->observaciones;
        $factura->condicion_pago = $datos->condicionPago;
        $factura->id_usuario_registro = auth()->user()->id_usuario;
        $factura->estado = 'Enviado';
        $factura->id_local = auth()->user()->empleado->id_local;
        $factura->id_pago_metodo = $datos->metodoPago;
        $factura->fecha_vencimiento = date('Y-m-d', strtotime($datos->fechaEmision . '+ ' . $datos->condicionPago . ' days'));
        $factura->save();
        $ruta = '';


        $entrega = new EntregadoReparacion();
        $entrega->fecha_entrega = Carbon::now();
        $entrega->nro_factura = $numeracionFactura;
        $entrega->fecha_registro = Carbon::now();
        $entrega->id_recepcion_ot = $factura->id_recepcion_ot;
        $entrega->id_comprobante_venta = $factura->id_comprobante_venta;
        if ($factura->es_seguro) $entrega->es_seguro = $factura->es_seguro;
        $entrega->observaciones = $observaciones_entregado;
        $entrega->save();

        $recepcion_ot->cambiarEstado('entregado');

        $ruta = route('hojaNotaEntrega', [
            'id_recepcion_ot' => $recepcion_ot->id_recepcion_ot,
            'id_entregado_reparacion' => $entrega->id_entregado_reparacion
        ]);
        $factura->url_entrega = $ruta;        
        
        
        $ruta_constancia = false;
        if ($datos->tiene_repuestos_pendientes != 'false') {
            $ruta_constancia = route('hojaConstancia', [
                'seccion' => $seccion,
                'documento' => $docRelacionado
            ]);

            $factura->url_constancia = $ruta_constancia;
        }

        $factura->save();

        DB::commit();

        return [
            'factura' => $factura,
            'json' => $json,
            'ruta_entrega' => $ruta,
            'ruta_constancia' => $ruta_constancia
        ];
    }

    public function generarFacturaGeneral($datos)
    {
        $tipo_comprobante = $datos->motivoRelacionado;
        $anticipo = $datos->tipoOperacion == 'ANTICIPO' ? true : false;
        $email = $datos->email;
        $telefono = $datos->telefono;
        $tipo_cambio = $datos->tipo_cambio;
        $rebate = $datos->rebate == 'true' ? true : false;
        $tipoTarjeta = $datos->tipoTarjeta ?? null;
        $entidadFinanciera = $datos->entidadFinanciera ?? null;

        //información del proveedor para el rebate
        $proveedor = Proveedor::find(1);

        DB::beginTransaction();
        $tasaIGV = config('app.tasa_igv');
        $rows = [];
        $totalFactura = 0;
        for ($i = 1; $i <= $datos['rows']; $i++) {
            $totalFactura += $datos["pventaNew-{$i}"];
            $rows[] = [
                'codigo' => $datos["codigoNew-{$i}"],
                'descripcion' => $datos["descripcionNew-{$i}"],
                'unidad' => $datos["unidadNew-{$i}"],
                'cantidad' => $datos["cantidadNew-{$i}"],
                'valor_unitario' => $datos["pventaNew-{$i}"] / (1+$tasaIGV),
                'valor_venta' => $datos["pventaNew-{$i}"],
                'impuesto' => ($datos["pventaNew-{$i}"] / (1+$tasaIGV)) * $tasaIGV,
                'total' => $datos["pventaNew-{$i}"],
            ];
        }

        $subtotalFactura = number_format($totalFactura / 1.18, 2, '.', '');
        $totalIGV = number_format(($totalFactura / 1.18) * 0.18, 2, '.', '');
        $totalFactura = number_format($totalFactura, 2, '.', '');
        $moneda = $datos->moneda;
        #return $rows;
        $listaProductos = $rows;
        // required data: dnicliente, nombrecliente, direccionCliente, arreglo de (cantidad, producto/servicio, codigo, descripcion, valor_unitario, valor_venta, igv, precio_total)                    

        $detraccion = false;
        $detraccion_msg = '';
        if ($moneda == 'SOLES') {
            if ($totalFactura > 700) $detraccion = true;
            $coin = 'PEN';
        } else if ($moneda == 'DOLARES') {
            if ($totalFactura * \App\Modelos\TipoCambio::getTipoCambioCobroActual() > 700) $detraccion = true;
            $coin = 'USD';
        }
        if ($detraccion && $tipo_comprobante == 'FACTURA') {
            $detraccion_msg = '
                detraction: 0.12,
                detraction_code: "022",
            ';
        }

        if ($anticipo) $factura = new ComprobanteAnticipo();
        else $factura = new ComprobanteVenta();

        if ($tipo_comprobante == 'FACTURA') {
            $tipo_documento = '01';
            switch ($datos->tipoVenta) {
                case 'GARANTIAS':
                    $serie = 'F001';
                    break;
                case 'GENERAL':
                    $serie = 'F001';
                    break;
            }
        } else {
            $tipo_documento = '03';
            switch ($datos->tipoVenta) {
                case 'GARANTIAS':
                    $serie = 'B001';
                    break;
                case 'GENERAL':
                    $serie = 'B001';
                    break;
            }
        }

        $serie = $datos->serie;
        $tipoVenta = $datos->tipoVenta;
        $docRelacionado = $datos->documentoRelacionado ?? false;

        $docCliente = $datos->docCliente;
        $nomCliente = $datos->nomCliente;
        $direccionCliente = $datos->direccionCliente;
        if ($rebate) {
            $docCliente = $proveedor->num_doc;
            $nomCliente = $proveedor->nombre_proveedor;
            $direccionCliente = $proveedor->direccion;
            $email = $proveedor->email_contacto;
            $telefono = $proveedor->telf_contacto;                    
        }
        $ubigeo = $datos->departamento . $datos->provincia . $datos->distrito;

        if ($tipoVenta == 'MESON' && $docRelacionado) {
            $cotizacion_meson = \App\Modelos\CotizacionMeson::whereHas('ventasMeson', function ($q) use ($docRelacionado) {
                $q->where('id_venta_meson', $docRelacionado);
            })->first();
            if ($cotizacion_meson->cod_ubigeo != $ubigeo) $cotizacion_meson->cod_ubigeo = $ubigeo;
            if ($cotizacion_meson->doc_cliente != $docCliente) $cotizacion_meson->doc_cliente = $docCliente;
            if ($cotizacion_meson->nombre_cliente != $nomCliente) $cotizacion_meson->nombre_cliente = $nomCliente;
            if ($cotizacion_meson->direccion_contacto != $direccionCliente) $cotizacion_meson->direccion_contacto = $direccionCliente;
            if ($cotizacion_meson->telefono_contacto != $telefono) $cotizacion_meson->telefono_contacto = $telefono;
            if ($cotizacion_meson->email_contacto != $email) $cotizacion_meson->email_contacto = $email;
            $cotizacion_meson->save();
        } else if (($tipoVenta == 'MEC' || $tipoVenta == 'B&P') && $docRelacionado) {

            
            $recepcion_ot = RecepcionOT::find($docRelacionado);
            if ($recepcion_ot->factura_para != $nomCliente) $recepcion_ot->factura_para = $nomCliente;
            if ($recepcion_ot->num_doc != $docCliente) $recepcion_ot->num_doc = $docCliente;
            if ($recepcion_ot->direccion != $direccionCliente) $recepcion_ot->direccion = $direccionCliente;
            
            if ($recepcion_ot->hojaTrabajo->telefono_contacto != $telefono) $recepcion_ot->hojaTrabajo->telefono_contacto2 = $telefono;
            if ($recepcion_ot->hojaTrabajo->email_contacto != $email) $recepcion_ot->hojaTrabajo->email_contacto2 = $email;
            if ($recepcion_ot->hojaTrabajo->cliente->cod_ubigeo != $ubigeo) $recepcion_ot->hojaTrabajo->cliente->cod_ubigeo = $ubigeo;
            if ($recepcion_ot->hojaTrabajo->cliente->celular != $telefono) $recepcion_ot->hojaTrabajo->cliente->celular = $telefono;
            if ($recepcion_ot->hojaTrabajo->cliente->email != $email) $recepcion_ot->hojaTrabajo->cliente->email = $email;
            $recepcion_ot->push();
        }

        $serie = $datos->serie;
        $factura->fill([
            'tipo_comprobante' => $tipo_comprobante,
            'serie' => $serie,
            #'nro_comprobante' => $nroFactura,
            'nrodoc_cliente' => $docCliente,
            'nombre_cliente' => $nomCliente,
            'direccion_cliente' => $direccionCliente,
            'fecha_emision' => date('Y-m-d'),
            'formato_impresion' => 'A4',
            'total_descuento' => 0,
            'total_venta' => $totalFactura,
            'monto_sujeto_igv' => $subtotalFactura,
            'tasa_detraccion' => $detraccion ? 0.12 : 0,
            'monto_inafecto' => 0,
            'monto_exonerado' => 0,
            'total_igv' => $totalIGV,
            'moneda' => $moneda,
            'email' => $email,
            'telefono' => $telefono,
            'tipo_cambio' => $tipo_cambio,

        ]);
        $factura->save();

        $details = '';

        $item_id = 1;
        foreach ($listaProductos as $key => $item) {
            $item = (object) $item;
            if ($anticipo) $lineaFactura = new LineaComprobanteAnticipo();
            else $lineaFactura = new LineaComprobanteVenta();

            $descripcionRebate = $item->descripcion;

            $lineaFactura->fill([
                'cantidad' => $item->cantidad,
                'unidad_medida' => $item->unidad,
                'codigo_producto' => $item->codigo,
                'descripcion' => $item->descripcion,
                'tipo_igv' => 'GRAVADO',
                'valor_unitario' => $item->valor_unitario,
                'valor_venta' => $item->valor_venta,
                'igv' => $item->impuesto,
                'precio_venta' => $item->total
            ]);

            if ($anticipo) $lineaFactura->id_comprobante_anticipo = $factura->id_comprobante_anticipo;
            else $lineaFactura->id_comprobante_venta = $factura->id_comprobante_venta;
            $lineaFactura->save();

            $tasaIGV = config('app.tasa_igv');
            $unit_price = $item->valor_unitario * (1 + $tasaIGV);
            $sale_value = $item->valor_unitario * $item->cantidad;
            $details .= '
              {
                item_id: 1,
                quantity: ' . $item->cantidad . ',
                unit_measure: "' . $item->unidad . '",
                code: "' . $item->codigo . '",
                description: "' . $item->descripcion . '",        
                igv_type: "10",
                discount: 0, 
                unit_value: ' . $item->valor_unitario . ', 
                sale_value: ' . $sale_value . ',
                igv: ' . $item->impuesto . ',        
                unit_price: ' . $unit_price . ',
              },
            ';
            //unit_value -> V. Unit.
            //unit_price -> P. Unit.
            //sale_value -> V. Unit x Cantidad
        }


        $httpClient = new \GuzzleHttp\Client();
        $anticipo = $anticipo ? 1 : 0;
        $body = '
        mutation {
        sales(
          document_type: "' . $tipo_documento . '",
          serie: "' . $serie . '",
          coin: "' . $coin . '",
          contact_identity: "' . $docCliente . '",
          contact_name: "' . $nomCliente . '",
          contact_address: "' . $direccionCliente . '",
          observations: "' . $datos->observaciones . '",
          pdf: "a4", 
          total_igv: ' . $totalIGV . ',    
          total_discount: 1,
          total_price: ' . $totalFactura . ',         
          taxable_operations: ' . $subtotalFactura . ',
          unaffected_operations: 0,
          exempted_operations: 0,
          created_from: 0,   
          advance: ' . $anticipo . ',
          proforma: false,
          ' . $detraccion_msg . '
          details: [' . $details . ']
        ) {    
            id
            number
            sunat_description
            pdf
            result    
            sunat_code
            advanceDB{
              id
            }
        }
      }
    ';

        #return $body;
        /* if($detraccion){
            $diccDetraccion = ['detraction' => 0.12,
                               'detraction_code' => '022' ];
            $body = array_merge($body, $diccDetraccion);
        } */


        $token = env('SIBI_TOKEN');

        $header = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ];

        $response = $httpClient->post(env('SIBI_URL'), ['headers' => $header, 'body' => json_encode([
            'query' => $body
        ])]);

        $bodyResponse = $response->getBody();
        $json = (object) json_decode($bodyResponse->read(1024), true);
        
        $json = $json->data['sales'];        
        $number = \App\Helper\Helper::generarNroComprobante($json['number']);
        $numeracionFactura = "{$serie}-{$number}";

        $url_pdf = "https://app.sibi.pe/pdf/vouchers/20606257261/{$tipo_documento}/" . $json['id'];
        $factura->url_pdf = $url_pdf;
        $factura->sale_id = $json['id'];
        $factura->sunat_code = $json['sunat_code'];
        $factura->sunat_description = $json['sunat_description'];
        if ($rebate && !$anticipo) $factura->es_rebate = 1;
        if ($anticipo) $factura->id_advance = $json['advanceDB']['id'];
        $factura->nro_comprobante = $number;
        $factura->id_tipo_tarjeta = $tipoTarjeta;
        $factura->id_entidad_financiera = $entidadFinanciera;

        if ($rebate) {
            $rebate = new Rebate();
            $rebate->id_local = auth()->user()->empleado->id_local;
            $rebate->dni = auth()->user()->dni;
            $rebate->id_proveedor = 1;    
            $rebate->factura = $numeracionFactura;
            $rebate->descripcion = $descripcionRebate;
            $rebate->tipo_cambio = $tipo_cambio;
            $rebate->venta_dolares = $totalFactura;
            $rebate->venta_dscto_dolares = $totalFactura;
            $rebate->margen_dolares = $totalFactura;
            $rebate->fecha_registro = Carbon::now();
            $rebate->save();
        }

        $factura->nro_operacion = $datos->nro_operacion;
        if ($tipoVenta == 'MESON') $factura->id_venta_meson = $datos->documentoRelacionado;
        else if ($tipoVenta == 'MEC' || $tipoVenta == 'B&P') $factura->id_recepcion_ot = $datos->documentoRelacionado;
        $factura->tipo_operacion = $datos->tipoOperacion;
        $factura->tipo_venta = $datos->tipoVenta;
        $factura->observaciones = $datos->observaciones;
        $factura->condicion_pago = $datos->condicionPago;
        $factura->id_usuario_registro = auth()->user()->id_usuario;
        $factura->estado = 'Enviado';
        $factura->id_local = auth()->user()->empleado->id_local;
        $factura->id_pago_metodo = $datos->metodoPago;
        $factura->fecha_vencimiento = date('Y-m-d', strtotime($datos->fechaEmision . '+ ' . $datos->condicionPago . ' days'));
        $factura->save();

        /* $entrega = new VentaMeson();
        $entrega->fecha_venta = Carbon::now();
        $entrega->nro_factura = $numeracionFactura;
        $entrega->fecha_registro = Carbon::now();
        $entrega->fecha_registro_factura = Carbon::now();
        $entrega->id_cotizacion_meson = $factura->id_venta_meson;
        $entrega->id_comprobante_venta = $factura->id_comprobante_venta;
        $entrega->save(); */

        $ruta_constancia = false;
        if ($datos->tiene_repuestos_pendientes != 'false') {

            $ruta_constancia = route('hojaConstancia', [
                'seccion' => $tipoVenta,
                'documento' => $datos->documentoRelacionado
            ]);
            $factura->url_constancia = $ruta_constancia;
        }
        $factura->save();

        DB::commit();

        return [
            'factura' => $factura,
            'json' => $json,
            'ruta_constancia' => $ruta_constancia
        ];
    }

    public function generarFacturaMeson($datos, $meson)
    {
        $tipo_comprobante = $datos->motivoRelacionado;
        $email = $datos->email;
        $telefono = $datos->telefono;
        $tipo_cambio = $datos->tipo_cambio;
        $tipoTarjeta = $datos->tipoTarjeta ?? null;
        $entidadFinanciera = $datos->entidadFinanciera ?? null;
        DB::beginTransaction();
        // required data: dnicliente, nombrecliente, direccionCliente, arreglo de (cantidad, producto/servicio, codigo, descripcion, valor_unitario, valor_venta, igv, precio_total)                    
        $descuentoTotal = $meson->descuento;
        $subtotalFactura = $meson->subTotalValorVenta;
        $totalIGV = $meson->impuesto;
        $totalFactura = $meson->precioVenta;
        $moneda = $meson->moneda;
        $listaProductos = $meson->items;

        $doc_relacionado = $datos->documentoRelacionado;
        $cotizacion_meson = \App\Modelos\CotizacionMeson::whereHas('ventasMeson', function($q) use($doc_relacionado){
            $q->where('id_venta_meson', $doc_relacionado);
        })->first();

        if ($datos->anticipos_a_asociar) {
            $anticipos_a_asociar = explode(',', $datos->anticipos_a_asociar);
            foreach($anticipos_a_asociar as $anticipo) {
                $anticipo_agregado = \App\Modelos\ComprobanteAnticipo::find($anticipo);
                $anticipo_agregado->id_venta_meson = $datos->documentoRelacionado;
                $anticipo_agregado->save();
            }
        }

        $anticipos_asociados = \App\Modelos\ComprobanteAnticipo::where('id_venta_meson', $datos->documentoRelacionado)->get();
        $advances = ''; //representa los anticipos
        $total_advances = 0;
        $total_advances_igv = 0;
        $total_advances_sub = 0;
        $estado_advance = 0;
        if (count($anticipos_asociados)) {
            $estado_advance = 2;
            $advances = 'advances: [';
            foreach ($anticipos_asociados as $anticipo) {
                $total_advances_igv += $anticipo->total_igv;
                $total_advances += $anticipo->total_venta;
                $total_advances_sub += $anticipo->monto_sujeto_igv;
                $advances .= '{id: ' . $anticipo->id_advance . '},';
            }
            $advances .= '
            ],
            total_advances: ' . $total_advances . ',
            ';
        }

        $detraccion = false;
        $detraccion_msg = '';
        if ($moneda == 'SOLES') {
            if ($totalFactura > 700) $detraccion = true;
            $coin = 'PEN';
        } else if ($moneda == 'DOLARES') {
            if ($totalFactura * \App\Modelos\TipoCambio::getTipoCambioCobroActual() > 700) $detraccion = true;
            $coin = 'USD';
        }

        if ($detraccion && $tipo_comprobante == 'FACTURA') {
            $detraccion_msg = '
                detraction: 0.12,
                detraction_code: "022",
            ';
        }

        if ($tipo_comprobante == 'FACTURA') {
            $tipo_documento = '01';

            $serie = 'F001';
        } else {
            $tipo_documento = '03';

            $serie = 'B001';
        }

        $detailsInvoice = [];
        $factura = new ComprobanteVenta();

        $docCliente = $datos->docCliente;
        $nomCliente = $datos->nomCliente;
        $direccionCliente = $datos->direccionCliente;
        $telefono_contacto = $datos->telefonoCliente;
        $email_contacto = $datos->emailCliente;
        $ubigeo = $datos->departamento . $datos->provincia . $datos->distrito;

        if($cotizacion_meson->cod_ubigeo != $ubigeo) $cotizacion_meson->cod_ubigeo = $ubigeo;
        if($cotizacion_meson->doc_cliente != $docCliente) $cotizacion_meson->doc_cliente = $docCliente;
        if($cotizacion_meson->nombre_cliente != $nomCliente) $cotizacion_meson->nombre_cliente = $nomCliente;
        if($cotizacion_meson->direccion_contacto != $direccionCliente) $cotizacion_meson->direccion_contacto = $direccionCliente;
        if($cotizacion_meson->telefono_contacto != $telefono_contacto) $cotizacion_meson->telefono_contacto = $telefono_contacto;
        if($cotizacion_meson->email_contacto != $email_contacto) $cotizacion_meson->email_contacto = $email_contacto;
        $cotizacion_meson->save();
        	
        $serie = $datos->serie;
        $factura->fill([
            'tipo_comprobante' => $tipo_comprobante,
            'serie' => $serie,
            #'nro_comprobante' => $nroFactura,
            'nrodoc_cliente' => $docCliente,
            'nombre_cliente' => $nomCliente,
            'direccion_cliente' => $direccionCliente,
            'fecha_emision' => date('Y-m-d'),
            'formato_impresion' => 'A4',
            'total_descuento' => $descuentoTotal,
            'total_venta' => $totalFactura,
            'monto_sujeto_igv' => $subtotalFactura,
            'tasa_detraccion' => $detraccion ? 0.12 : 0,
            'monto_inafecto' => 0,
            'monto_exonerado' => 0,
            'total_igv' => $totalIGV,
            'moneda' => $moneda,
            'email' => $email,
            'telefono' => $telefono,
            'tipo_cambio' => $tipo_cambio,
        ]);
        $factura->save();

        $details = '';

        $item_id = 1;
        foreach ($listaProductos as $key => $item) {
            $lineaFactura = new LineaComprobanteVenta();
            $lineaFactura->fill([
                'cantidad' => $item->cantidad,
                'unidad_medida' => $item->unidad,
                'codigo_producto' => $item->codigo,
                'descripcion' => $item->descripcion,
                'tipo_igv' => 'GRAVADO',
                'valor_unitario' => $item->valor_unitario,
                'valor_venta' => $item->valor_venta,
                'igv' => $item->impuesto,
                'precio_venta' => $item->total
            ]);
            $lineaFactura->id_comprobante_venta = $factura->id_comprobante_venta;
            $lineaFactura->save();

            $tasaIGV = config('app.tasa_igv');
            $unit_price = $item->valor_unitario * (1 + $tasaIGV);
            $sale_value = $item->valor_unitario * $item->cantidad;
            $details .= '
              {
                item_id: 1,
                quantity: ' . $item->cantidad . ',
                unit_measure: "' . ($item->unidad == 'PRODUCTO' ? 'NIU' : 'ZZ') . '",
                code: "' . $item->codigo . '",
                description: "' . $item->descripcion . '",        
                igv_type: "10",
                discount: ' . $item->descuento . ', 
                unit_value: ' . $item->valor_unitario . ',
                sale_value: ' . $sale_value . ',
                igv: ' . $item->impuestoSinDescuento . ',        
                unit_price: ' . $unit_price . ',
              },
            ';
        }

        $httpClient = new \GuzzleHttp\Client();

        $body = '
            mutation {
            sales(
            document_type: "' . $tipo_documento . '",
            serie: "' . $serie . '",
            coin: "' . $coin . '",
            contact_identity: "' . $docCliente . '",
            contact_name: "' . $nomCliente . '",
            contact_address: "' . $direccionCliente . '",
            observations: "' . $datos->observaciones . '",
            pdf: "a4", 
            total_igv: ' . ($totalIGV - $total_advances_igv) . ',    
            total_discount: '.$descuentoTotal.',
            total_price: ' . ($totalFactura - $total_advances)  . ',         
            taxable_operations: ' . ($subtotalFactura - $total_advances_sub) . ',
            unaffected_operations: 0,
            exempted_operations: 0,
            created_from: 0,   
            advance: '.$estado_advance.',
            '.$advances.'
            proforma: false,
            ' . $detraccion_msg . '
            details: [' . $details . ']
            ) {    
                id
                number
                sunat_description
                pdf
                result    
                sunat_code
                advanceDB{
                  id
                }
            }
        }
        ';


        /* if($detraccion){
            $diccDetraccion = ['detraction' => 0.12,
                               'detraction_code' => '022' ];
            $body = array_merge($body, $diccDetraccion);
        } */


        $token = env('SIBI_TOKEN');
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ];


        $response = $httpClient->post(env('SIBI_URL'), ['headers' => $header, 'body' => json_encode([
            'query' => $body
        ])]);
        $bodyResponse = $response->getBody();
        $json = (object) json_decode($bodyResponse->read(1024), true);
        $json = $json->data['sales'];
        $number = \App\Helper\Helper::generarNroComprobante($json['number']);
        $numeracionFactura = "{$serie}-{$number}";

        $url_pdf = "https://app.sibi.pe/pdf/vouchers/20606257261/{$tipo_documento}/" . $json['id'];
        $factura->url_pdf = $url_pdf;
        $factura->sale_id = $json['id'];
        $factura->sunat_code = $json['sunat_code'];
        $factura->sunat_description = $json['sunat_description'];
        $factura->nro_comprobante = $number;        	
        $factura->id_tipo_tarjeta = $tipoTarjeta;
        $factura->id_entidad_financiera = $entidadFinanciera;
        $factura->nro_operacion = $datos->nro_operacion;
        $factura->id_venta_meson = $datos->documentoRelacionado;
        $factura->tipo_operacion = $datos->tipoOperacion;
        $factura->tipo_venta = $datos->tipoVenta;
        $factura->observaciones = $datos->observaciones;
        $factura->condicion_pago = $datos->condicionPago;
        $factura->id_usuario_registro = auth()->user()->id_usuario;
        $factura->estado = 'Enviado';
        $factura->id_local = auth()->user()->empleado->id_local;
        $factura->id_pago_metodo = $datos->metodoPago;
        $factura->fecha_vencimiento = date('Y-m-d', strtotime($datos->fechaEmision . '+ ' . $datos->condicionPago . ' days'));
        $factura->save();

        /* $entrega = new VentaMeson();
        $entrega->fecha_venta = Carbon::now();
        $entrega->nro_factura = $numeracionFactura;
        $entrega->fecha_registro = Carbon::now();
        $entrega->fecha_registro_factura = Carbon::now();
        $entrega->id_cotizacion_meson = $factura->id_venta_meson;
        $entrega->save(); */
        $documentoRelacionado = $datos->documentoRelacionado;
        $repuestosAsociados = LineaCotizacionMeson::whereHas('cotizacionMeson.ventasMeson', function ($q) use ($documentoRelacionado) {
            $q->where('id_venta_meson', $documentoRelacionado);
        })->get();

        $validarRepuestosReservados = true;
        foreach ($repuestosAsociados as $repuesto) {
            if ($repuesto->getDisponibilidadRepuestoText() != 'RESERVADO') $validarRepuestosReservados = false;
        }

        if (!$validarRepuestosReservados) {
            return [
                'status' => 'error',
                'message' => 'No todos sus repuestos asociados están reservados'
            ];
        }

        $cotizacion = CotizacionMeson::whereHas('ventasMeson', function ($q) use ($documentoRelacionado) {
            $q->where('id_venta_meson', $documentoRelacionado);
        })->first();
        if (!$cotizacion) return null;
        $count = 0;
        foreach ($cotizacion->ventasMeson as $ventaCotizacion) {
            $ventaCotizacion->fecha_venta = Carbon::now();
            $ventaCotizacion->nro_factura = $numeracionFactura;
            $ventaCotizacion->fecha_registro_factura = Carbon::now();
            $ventaCotizacion->id_comprobante_venta = $factura->id_comprobante_venta;
            $ventaCotizacion->save();
            $count++;
        }

        foreach ($cotizacion->lineasCotizacionMeson as $lineaCotizacion) {
            if (!$lineaCotizacion->es_entregado) {

                $response = MovimientoRepuesto::generarEgresoFisico($lineaCotizacion->id_repuesto, $cotizacion->getIdLocal(), $lineaCotizacion->getCantidadRepuesto(), "App\Modelos\LineaCotizacionMeson", $lineaCotizacion->id_linea_cotizacion_meson);
                $lineaCotizacion->es_entregado = 1;
                $lineaCotizacion->fecha_entrega = Carbon::now();
                $lineaCotizacion->fecha_registro_entrega = Carbon::now();
                $lineaCotizacion->id_movimiento_salida = $response;
                $lineaCotizacion->save();
            }
        }

        $ruta_constancia = false;
        if ($datos->tiene_repuestos_pendientes != 'false') {

            $ruta_constancia = route('hojaConstancia', [
                'seccion' => 'MESON',
                'documento' => $datos->documentoRelacionado
            ]);
            $factura->url_constancia = $ruta_constancia;
        }
        $factura->save();
        DB::commit();

        return [
            'factura' => $factura,
            'json' => $json,
            'ruta_entrega' => '',
            'ruta_constancia' => $ruta_constancia
        ];
    }
}
