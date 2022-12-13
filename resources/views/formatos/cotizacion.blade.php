<style>
    * {
        border-width: 0.5px;
        font-family: 'sans-serif';
    }

    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    .all-bordered td {
        border: solid;
    }

    .all-bordered th {
        border: solid;
    }

    tr.bottom-border td {
        border-bottom: solid;
    }

    tr.bottom-border tr th {
        border-bottom: solid;
    }

</style>

<table style="width: 100%; font-size:13px">
    <tr>
        <td align="left">
            <div><img src="{{ asset('assets/images/logo_planeta.jpg') }}"
                     style="height: 28px;"></div>
        </td>
    </tr>
    <tr>
        <th align="center">
            COTIZACIÓN N° {{ $hojaTrabajo->id_cotizacion }}
        </th>
    </tr>
    <tr>
        <th align="left">
            Centro de Servicios: {{ $hojaTrabajo->empleado->local->nombre_local }}
        </th>
    </tr>

    <!-- SECCION CLIENTE -->
    <tr>
        <th align="left"
            style="border: solid">
            CLIENTE
        </th>
    </tr>
    <tr>
        <td style="border: solid">
            <table style="width: 100%;">
                <tr>
                    <td>Doc. Identidad:</td>
                    <td>{{ $hojaTrabajo->getNumDocCliente() }}</td>
                </tr>
                <tr>
                    <td>Cliente:</td>
                    <td>{{ $hojaTrabajo->getNombreCliente() }}</td>
                    <td>Teléfono:</td>
                    <td>{{ $hojaTrabajo->getTelefonoCliente() }}</td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td>{{ $hojaTrabajo->getDireccionCliente() }}</td>
                    <td>Email:</td>
                    <td>{{ $hojaTrabajo->getCorreoCliente() }}</td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- SECCION VEHICULO -->
    <tr>
        <th align="left"
            style="border: solid">
            VEHICULO
        </th>
    </tr>
    <tr>
        <td style="border: solid">
            <table style="width: 100%;">
                <tr>
                    <td>Placa:</td>
                    <td>{{ $hojaTrabajo->getPlacaPartida() }}</td>
                    <td>Motor:</td>
                    <td>{{ $hojaTrabajo->vehiculo->motor }}</td>
                    <td>Chasis:</td>
                    <td>{{ $hojaTrabajo->vehiculo->vin }}</td>
                </tr>
                <tr>
                    <td>Marca:</td>
                    <td>{{ $hojaTrabajo->vehiculo->getNombreMarca() }}</td>
                    <td>Modelo:</td>
                    <td>{{ $hojaTrabajo->vehiculo->modelo }}</td>
                    <td>Color:</td>
                    <td>{{ $hojaTrabajo->vehiculo->color }}</td>
                </tr>
                <tr>
                    <td>Año Fabricación:</td>
                    <td>{{ $hojaTrabajo->vehiculo->anho_vehiculo }}</td>
                    <td>Seguro:</td>
                    <td>
                        @if ($hojaTrabajo->cotizacion->ciaSeguro)
                            {{ $hojaTrabajo->cotizacion->ciaSeguro->nombre_cia_seguro }}@endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@if (!$arregloCarroceria->isEmpty())
    <table style="width: 100%; font-size:13px; margin-top: 30px">
        <thead style="border: solid">
            <tr>
                <th align="left"
                    colspan="6"
                    style="border: solid">CARROCERÍA</th>
            </tr>
            <tr>
                <th>CODIGO</th>
                <th align="left">DESCRIPCIÓN</th>
                <th align="center">CANT.</th>
                <th align="right"
                    style="padding-right: 5px;">
                    @if ($incluyeIGV) PREC. @else VAL. @endif LISTA
                </th>
                <th align="right"
                    style="padding-right: 5px;">DESCUENTO</th>
                <th align="right"
                    style="padding-right: 5px;">
                    @if ($incluyeIGV) PREC. @else VAL. @endif VENTA
                    ({{ $moneda_simbolo }})
                </th>
            </tr>
        </thead>
        <tbody style="border: solid">
            @foreach ($arregloCarroceria as $detalleTrabajo)
                <tr class="bottom-border">
                    <td>{{ $detalleTrabajo->operacionTrabajo->cod_operacion_trabajo }}</td>
                    <td>{{ $detalleTrabajo->getNombreDetalleTrabajo() }}</td>
                    <td align="center">{{ $detalleTrabajo->valor_trabajo_estimado }} HORAS</td>
                    <td align="right">{{ $detalleTrabajo->getPrecioLista($monedaCalculo, $incluyeIGV) }}</td>
                    <td align="right">{{ $detalleTrabajo->getDescuento($monedaCalculo, $incluyeIGV) }}</td>
                    <td align="right">{{ $detalleTrabajo->getSubTotal($monedaCalculo, $incluyeIGV) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5"
                    align="right">Total Carrocería:</th>
                <td align="right">{{ $totalCarroceria }}</td>
            </tr>
        </tfoot>
    </table>
@endif

@if (!$arregloPanhos->isEmpty())
    <table style="width: 100%; font-size:13px; margin-top: 30px">
        <thead style="border: solid">
            <tr>
                <th align="left"
                    colspan="6"
                    style="border: solid">PINTURA</th>
            </tr>
            <tr>
                <th>CODIGO</th>
                <th align="left">DESCRIPCIÓN</th>
                <th align="center">CANT.</th>
                <th align="right"
                    style="padding-right: 5px;">
                    @if ($incluyeIGV) PREC. @else VAL. @endif LISTA
                </th>
                <th align="right"
                    style="padding-right: 5px;">DESCUENTO</th>
                <th align="right"
                    style="padding-right: 5px; width: 120px;">
                    @if ($incluyeIGV) PREC. @else VAL. @endif VENTA
                    ({{ $moneda_simbolo }})
                </th>
            </tr>
        </thead>
        <tbody style="border: solid">
            @foreach ($arregloPanhos as $detalleTrabajo)
                <tr class="bottom-border">
                    <td>{{ $detalleTrabajo->operacionTrabajo->cod_operacion_trabajo }}</td>
                    <td>{{ $detalleTrabajo->getNombreDetalleTrabajo() }}</td>
                    <td align="center">{{ $detalleTrabajo->valor_trabajo_estimado }} PAÑOS</td>
                    <td align="right">{{ $detalleTrabajo->getPrecioLista($monedaCalculo, $incluyeIGV) }}</td>
                    <td align="right">{{ $detalleTrabajo->getDescuento($monedaCalculo, $incluyeIGV) }}</td>
                    <td align="right">{{ $detalleTrabajo->getSubTotal($monedaCalculo, $incluyeIGV) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5"
                    align="right">Tot. Pintura:</th>
                <td align="right">{{ $totalPanhos }}</td>
            </tr>
        </tfoot>
    </table>
@endif

@if (!$arregloMecanica->isEmpty())
    <table style="width: 100%; font-size:13px; margin-top: 30px">
        <thead style="border: solid">
            <tr>
                <th align="left"
                    colspan="6"
                    style="border: solid">MECÁNICA</th>
            </tr>
            <tr>
                <th>CODIGO</th>
                <th align="left">DESCRIPCIÓN</th>
                <th align="center">CANT.</th>
                <th align="right"
                    style="padding-right: 5px;">
                    @if ($incluyeIGV) PREC. @else VAL. @endif LISTA
                </th>
                <th align="right"
                    style="padding-right: 5px;">DESCUENTO</th>
                <th align="right"
                    style="padding-right: 5px; width: 120px;">
                    @if ($incluyeIGV) PREC. @else VAL. @endif VENTA
                    ({{ $moneda_simbolo }})
                </th>
            </tr>
        </thead>
        <tbody style="border: solid">
            @foreach ($arregloMecanica as $detalleTrabajo)
                <tr class="bottom-border">
                    <td>{{ $detalleTrabajo->operacionTrabajo->cod_operacion_trabajo }}</td>
                    <td>{{ $detalleTrabajo->getNombreDetalleTrabajo() }}</td>
                    <td align="center">{{ $detalleTrabajo->valor_trabajo_estimado }} HORAS</td>
                    <td align="right">{{ $detalleTrabajo->getPrecioLista($monedaCalculo, $incluyeIGV) }}</td>
                    <td align="right">{{ $detalleTrabajo->getDescuento($monedaCalculo, $incluyeIGV) }}</td>
                    <td align="right">{{ $detalleTrabajo->getSubTotal($monedaCalculo, $incluyeIGV) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5"
                    align="right">Tot. Mecánica:</th>
                <td align="right">{{ $totalMecanica }}</td>
            </tr>
        </tfoot>
    </table>
@endif


<table style="width: 100%; font-size:13px; margin-top: 30px">
    <thead style="border: solid">
        <tr>
            <th align="left"
                colspan="7"
                style="border: solid">REPUESTOS</th>
        </tr>
        <tr>
            @if (false)
                <th> PR </th>
            @endif
            <th>NRO. PARTE</th>
            <th>DESCRIPCION</th>
            <th>DISPONIBILIDAD</th>
            <th align="center">CANT.</th>
            <th align="right"
                style="padding-right: 5px;">
                @if ($incluyeIGV) PREC. @else VAL. @endif UNIT
            </th>
            <th align="right"
                style="padding-right: 5px;">DESCUENTO</th>
            <th align="right"
                style="padding-right: 5px; width: 120px;">
                @if ($incluyeIGV) PREC. @else VAL. @endif VENTA
                ({{ $moneda_simbolo }})
            </th>
        </tr>
    </thead>
    <tbody style="border: solid">
        @foreach ($listaRepuestosAprobados as $repuestoAprobado)
            <tr class="bottom-border">
                @if (false)
                    <td> PR </td>
                @endif
                <td>{{ $repuestoAprobado->getRepuestoNroParte() }}</td>
                <td>{{ $repuestoAprobado->getDescripcionRepuestoAprobado() }}</td>
                <td align="center">{{ $repuestoAprobado->getDisponibilidad() }}</td>
                <td align="center">{{ $repuestoAprobado->getCantidad() }}</td>
                <td align="right">
                    {{ number_format($repuestoAprobado->getMontoUnitario($repuestoAprobado->getFechaRegistroCarbon(), $incluyeIGV), 2) }}
                </td>
                <td align="right">
                    {{ number_format($repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(), $incluyeIGV, $repuestoAprobado->descuento_unitario ?? 0, $repuestoAprobado->descuento_unitario_dealer ?? -1), 2) }}
                </td>
                <td align="right">
                    {{ number_format($repuestoAprobado->getMontoVentaTotal($repuestoAprobado->getFechaRegistroCarbon(), $incluyeIGV, $repuestoAprobado->descuento_unitario ?? 0, false, $repuestoAprobado->descuento_unitario_dealer ?? -1), 2) }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6"
                align="right">Tot. Repuestos:</th>
            <td align="right">{{ $totalRepuestos }}</td>
        </tr>
    </tfoot>
</table>

<table style="width: 100%; font-size:13px; margin-top: 30px">
    <thead style="border: solid">
        <tr>
            <th align="left"
                colspan="4"
                style="border: solid">SERVICIOS TERCEROS</th>
        </tr>
        <tr>
            <th style="width: 20%">CODIGO</th>
            <th align="left">DESCRIPCIÓN</th>
            <th align="right"
                style="padding-right: 5px;">DESCUENTO</th>
            <th align="right"
                style="padding-right: 5px; width: 130px">
                @if ($incluyeIGV) PREC. @else VAL. @endif VENTA
                ({{ $moneda_simbolo }})
            </th>
        </tr>
    </thead>
    <tbody style="border: solid">
        @foreach ($listaServiciosTerceros as $servicioTercero)
            <tr class="bottom-border">
                <td>{{ $servicioTercero->getCodigoServicioTercero() }}</td>
                <td>{{ $servicioTercero->getDescripcion() }}</td>
                @if (false)
                    <td align="right">{{ $detalleTrabajo->getPrecioLista($monedaCalculo) }}</td>
                @endif
                <td align="right">{{ $servicioTercero->getDescuento($monedaCalculo, $incluyeIGV) }}</td>
                <td align="right">
                    {{ $incluyeIGV ? $servicioTercero->getPrecioVenta($monedaCalculo) : $servicioTercero->getValorVenta($monedaCalculo) }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3"
                align="right">Total Servicios Terceros:</th>
            <td align="right">{{ $totalServiciosTerceros }}</td>
        </tr>
    </tfoot>
</table>

<table style="margin-top: 15px; width: 100%">
    @if ($incluyeIGV)
        <tr>
            <td style="width: 440px">&nbsp;</td>
            <th style="border: solid; width: 190px"
                align="left">VALOR VENTA {{ $moneda_simbolo }}</th>
            <th style="border: solid; width: 65px"
                align="right">{{ $subtotal }}</th>
        </tr>
        <tr>
            <td></td>
            <th style="border: solid"
                align="left">IGV {{ $moneda_simbolo }}</th>
            <th style="border: solid"
                align="right">{{ $igv }}</th>
        </tr>
    @endif
    <tr>
        <td style="height: 20px"></td>
        <td style="height: 20px"></td>
        <td style="height: 20px"></td>
    </tr>
    <tr>
        <td @if (!$incluyeIGV) style="width: 440px" @endif>&nbsp;</td>
        <th style="border: solid;width: 190px"
            align="left">TOTAL COTIZACIÓN {{ $moneda_simbolo }}</th>
        <th style="border: solid; width: 65px"
            align="right">{{ $total }}</th>
    </tr>
    <tr>
        <td @if (!$incluyeIGV) style="width: 440px" @endif>&nbsp;</td>
        <td colspan="2"
            align="right"
            style="font-size: 13px">
        @if ($incluyeIGV) {{ Helper::mensajeIncluyeIGV() }} @else
                {{ Helper::mensajeNoIncluyeIGV() }} @endif
        </td>
    </tr>
</table>

<table style="margin-top: 50px; width: 100%; font-size:13px; border: solid;">
    {{-- <tr>
        <td colspan="2"
            style="height: 10px"></td>
    </tr> --}}
    <tr>
        <th align="left">Asesor de Servicio:</th>
        <td>{{ $hojaTrabajo->empleado->nombreCompleto() }}</td>
    </tr>
    <tr>
        <th align="left">Teléfono:</th>
        <td>{{ $hojaTrabajo->empleado->telefono_contacto }}</td>
    </tr>
    <tr>
        <th align="left">Correo:</th>
        <td>{{ $hojaTrabajo->empleado->email }}</td>
    </tr>
    <tr>
        <td colspan="2"
            style="height: 10px"></td>
    </tr>

    <tr>
        <th align="left">Fecha Apertura Cotización:</th>
        <td>{{ \Carbon\Carbon::parse($hojaTrabajo->cotizacion->fecha_registro)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th align="left"
            style="width: 250px;">Cotización válida hasta:</th>
        <td>{{ \Carbon\Carbon::parse($hojaTrabajo->cotizacion->fecha_registro)->addDays(7)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th align="left"
            style="width: 250px;">Tipo de Cambio:</th>
        <td>{{ $hojaTrabajo->getTC() }}</td>
    </tr>

    <tr>
        <th align="left">Seguro:</th>
        <td>
            @if ($hojaTrabajo->cotizacion->ciaSeguro)
                {{ $hojaTrabajo->cotizacion->ciaSeguro->nombre_cia_seguro }}@endif
        </td>
    </tr>
    {{-- <tr>
        <th align="left">Ultima Modificacion por:</th>
        <td>{{ $hojaTrabajo->empleado->nombreCompleto() }}</td>
    </tr> --}}
    <tr>
        <th align="left"
            style="vertical-align: top;">Observaciones</th>
        <td>
            @if ($hojaTrabajo->observaciones)
                {{ $hojaTrabajo->observaciones }}
            @else SIN
                OBSERVACIONES
            @endif
        </td>
    </tr>
    {{-- <tr>
        <td colspan="2"
            style="height: 30px"></td>
    </tr> --}}
</table>
