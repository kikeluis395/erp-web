<table class="table text-center table-striped table-sm"
       style="border: 1px solid #000000;">
    <thead>
        <tr>
            <th scope="col">SECCIÓN</th>
            <th scope="col">OT</th>
            <th scope="col">VIN</th>
            <th scope="col">PLACA</th>
            <th scope="col">DOCCLIENTE</th>
            <th scope="col">CLIENTE</th>
            <th scope="col">TELÉFONO</th>
            <th scope="col">CORREO</th>
            <th scope="col">DIRECCIÓN</th>
            <th scope="col">FECHA_APERTURA_OT</th>
            <th scope="col">FECHA_ENTREGA</th>
            <th scope="col">FECHA_GESTIÓN_MARCA</th>
            <th scope="col">FECHA_FACTURACIÓN</th>
            <th scope="col">DESCRIPCIÓN</th>
            <th scope="col">DOC_FACTURA</th>
            <th scope="col">ID_CIERRE</th>
            <th scope="col">MO $</th>
            <th scope="col">REPUESTOS $</th>
            <th scope="col">INCENTIVO $</th>
            <th scope="col">TOTAL $</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($resultados as $resultado)
            <tr>
                <td style="vertical-align: middle">{{ $resultado['seccion'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['ot'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['vin'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['placa'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['doc'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['cliente'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['telefono'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['correo'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['direccion'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['fecha_apertura'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['fecha_entrega'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['fecha_gestion'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['fecha_facturacion'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['descripcion'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['factura'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['id_cierre'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['monto_obra'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['monto_repuestos'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['monto_incentivo'] }}</td>
                <td style="vertical-align: middle">{{ $resultado['monto_total'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
