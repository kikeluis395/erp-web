<table>
    <thead>
        <tr>
            <th scope="col">N° OT</th>
            <th scope="col">TIPO OT</th>
            <th scope="col">ESTADO</th>
            <th scope="col">LOCAL</th>
            <th scope="col">FECHA INGRESO</th>
            <th scope="col">FECHA ENTREGA</th>
            <th scope="col">FECHA CIERRE</th>
            <th scope="col">VIN</th>
            <th scope="col">PLACA</th>
            <th scope="col">MARCA</th>
            <th scope="col">MODELO</th>
            <th scope="col">AÑO</th>
            <th scope="col">KILOMETRAJE</th>
            <th scope="col">N° DOCUMENTO</th>
            <th scope="col">CLIENTE</th>
            <th scope="col">TELÉFONO</th>
            <th scope="col">CORREO</th>
            <th scope="col">DIRECCIÓN</th>
            <th scope="col">DISTRITO</th>
            <th scope="col">PROVINCIA</th>
            <th scope="col">DEPARTAMENTO</th>
            <th scope="col">ASESOR</th>
            <th scope="col">DETALLE DEL SERVICIO</th>
            <th scope="col">BOLETA/FACTURA</th>
            <th scope="col">MONEDA</th>
            <th scope="col">TC</th>
            <th scope="col">$ VENTA </th>
            <th scope="col">S/ VENTA</th>
            <th scope="col">OBSERVACIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listaOrdenesTrabajo as $ordenTrabajo)
            <tr>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->getOTNroOT() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->tipoOT->nombre_tipo_ot }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->getEstadoTrabajo() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->empleado->local->nombre_local }}</td>
                <td style="vertical-align: middle">
                    {{ $ordenTrabajo->hojaTrabajo->getFechaRecepcionFormat('d/m/Y H:i') }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->fechaEntregadoFormat() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->fechaCierreFormat() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->vehiculo->getVin() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->getPlacaAutoFormat() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->vehiculo->getNombreMarca() }}</td>
                <td style="vertical-align: middle">{{ substr($ordenTrabajo->hojaTrabajo->getModeloVehiculo(), 0, 20) }}
                </td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->vehiculo->getAnhoVehiculo() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->kilometraje }} KM</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->cliente->getNumDocCliente() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->cliente->getNombreCliente() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->telefono_contacto }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->email_contacto }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->cliente->getDireccionCliente() }}
                </td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->cliente->getDistritoText() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->cliente->getProvinciaText() }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->cliente->getDepartamentoText() }}
                </td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->empleado->nombreCompleto() }}</td>
                <td style="vertical-align: middle">
                    {{ $ordenTrabajo->hojaTrabajo->getPrimerTrabajoPreventivoOptional() }}</td>
                <td style="vertical-align: middle">
                    {{ count($ordenTrabajo->entregas) ? $ordenTrabajo->ultEntrega()->nro_factura : '' }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->moneda }}</td>
                <td style="vertical-align: middle">{{ $ordenTrabajo->hojaTrabajo->tipo_cambio }}</td>
                <td style="vertical-align: middle">
                    {{ $ordenTrabajo->hojaTrabajo->moneda == 'DOLARES' ? number_format($ordenTrabajo->hojaTrabajo->recepcionOT->getMontoConSinDescuento() / 1.18, 2) : number_format($ordenTrabajo->hojaTrabajo->recepcionOT->getMontoConSinDescuento() / 1.18 / $ordenTrabajo->hojaTrabajo->tipo_cambio, 2) }}
                </td>
                <td style="vertical-align: middle">
                    {{ $ordenTrabajo->hojaTrabajo->moneda == 'SOLES' ? number_format($ordenTrabajo->hojaTrabajo->recepcionOT->getMontoConSinDescuento() / 1.18, 2) : number_format(($ordenTrabajo->hojaTrabajo->recepcionOT->getMontoConSinDescuento() / 1.18) * $ordenTrabajo->hojaTrabajo->tipo_cambio, 2) }}
                </td>
                <td style="vertical-align: middle">
                    {{ $ordenTrabajo->hojaTrabajo->observaciones }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
