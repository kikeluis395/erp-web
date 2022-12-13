<table class="table text-center table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">FECHA CREACIÓN</th>
            <th scope="col"># COTIZACION</th>
            <th scope="col"># NV</th>
            <th scope="col"># FACTURA</th>
            <th scope="col">FECHA FACTURACION</th>
            <th scope="col">N° DOCUMENTO</th>
            <th scope="col">CLIENTE</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">MAIL</th>
            <th scope="col">DIRECCION</th>
            <th scope="col">DEPARTAMENTO</th>
            <th scope="col">PROVINCIA</th>
            <th scope="col">DISTRITO</th>
            <th scope="col">LOCAL</th>
            <th scope="col">VENDEDOR</th>
            <th scope="col">ESTADO</th>
            <th scope="col">MONEDA</th>
            <th scope="col">TC</th>
            <th scope="col">MAYOREO</th>
            {{-- <th scope="col">VALOR VENTA</th> --}}
            <th scope="col">$ VALOR VENTA</th>
            <th scope="col">S/ VALOR VENTA</th>
            {{-- <th scope="col">COSTO TOTAL</th>
            <th scope="col">MARGEN</th> --}}
            {{-- <th scope="col">DSCTO TOTAL</th> --}}
            {{-- <th scope="col">% DSCTO RPTOS</th>
            <th scope="col">% DSCTO LUBRICANTES</th> --}}

            <th scope="col">OBSERVACIONES</th>
            <th scope="col">MOTIVO CIERRE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listaCotizaciones as $row)
            <tr>
                <th style="vertical-align: middle"
                    scope="row">{{ $loop->iteration }}</th>
                <td style="vertical-align: middle">{{ $row->fecha_registro }}</td>
                <td style="vertical-align: middle">{{ $row->id_cotizacion_meson }}</td>
                <td style="vertical-align: middle">{{ $row->getIdVentaMeson() }}</td>
                <td style="vertical-align: middle">{{ $row->getNumeroFactura() }}</td>
                <td style="vertical-align: middle">{{ $row->getFechaVentaCotizacion() }}</td>
                <td style="vertical-align: middle">{{ $row->doc_cliente }}</td>
                <td style="vertical-align: middle">{{ $row->nombre_cliente }}</td>
                <td style="vertical-align: middle">{{ $row->telefono_contacto }}</td>
                <td style="vertical-align: middle">{{ $row->email_contacto }}</td>
                <td style="vertical-align: middle">{{ $row->direccion_contacto }}</td>
                <td style="vertical-align: middle">{{ $row->getDepartamento() }}</td>
                <td style="vertical-align: middle">{{ $row->getProvincia() }}</td>
                <td style="vertical-align: middle">{{ $row->getDistrito() }}</td>
                <td style="vertical-align: middle">{{ $row->getLocal() }}</td>
                <td style="vertical-align: middle">{{ $row->getNombrevendedor() }}</td>
                <td style="vertical-align: middle">{{ $row->getEstado() }}</td>
                <td style="vertical-align: middle">{{ $row->moneda }}</td>
                <td style="vertical-align: middle">{{ $row->tipo_cambio }}</td>
                <td style="vertical-align: middle">{{ $row->esMayoreo() }}</td>
                {{-- <td style="vertical-align: middle">{{ number_format($row->getMontoTotal(false, false), 2) }}</td> --}}
                {{-- <td style="vertical-align: middle">{{ number_format($row->getMontoTotal(false, true), 2) }}</td> --}}

                <td style="vertical-align: middle">
                    {{ $row->moneda == 'DOLARES' ? number_format($row->getMontoTotal(false, true) / 1.18, 2) : number_format($row->getMontoTotal(false, true) / 1.18 / $row->tipo_cambio, 2) }}
                </td>
                <td style="vertical-align: middle">
                    {{ $row->moneda == 'SOLES' ? number_format($row->getMontoTotal(false, true) / 1.18, 2) : number_format(($row->getMontoTotal(false, true) / 1.18) * $row->tipo_cambio, 2) }}
                </td>

                {{-- <td style="vertical-align: middle">
                    {{ number_format($row->getCostoUnitarioTotal($row->moneda, $row->tipo_cambio), 2) }}</td>
                <td style="vertical-align: middle">
                    {{ number_format($row->getMontoTotal(false, true) - $row->getCostoUnitarioTotal($row->moneda, $row->tipo_cambio), 2) }}
                </td> --}}
                {{-- <td style="vertical-align: middle">{{ number_format($row->getDescuentoTotal(false), 2) }}</td> --}}
                {{-- <td style="vertical-align: middle"
                    width="500">{{ $row->getDescuentoRptos() }}</td>
                <td style="vertical-align: middle">{{ $row->getDescuentoLubricantes() }}</td> --}}
                <td style="vertical-align: middle">{{ $row->observaciones }}</td>
                <td style="vertical-align: middle">{{ $row->razon_cierre }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
