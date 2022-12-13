<table class="table text-center table-striped table-sm"
       style="border: 1px solid #000000;">
    <thead>
        <tr>
            <th scope="col">CODIGO</th>
            <th scope="col">DESCRIPCION</th>
            <th scope="col">FECHA</th>
            <th scope="col">USUARIO</th>
            <th scope="col">FUENTE</th>
            <th scope="col">NUM. FUENTE</th>
            <th scope="col">NUM. FACTURA</th>
            <th scope="col">MOTIVO</th>
            <th scope="col">UBICACION</th>
            <th scope="col">CANTIDAD INGRESO</th>
            <th scope="col">CANTIDAD SALIDA</th>
            <th scope="col">CANTIDAD SALDO</th>
            @if (false)
                <th scope="col">MONEDA COSTO</th>
                <th scope="col">TIPO CAMBIO</th>
            @endif

            <th scope="col">COSTO UNIT. DÓLARES</th>
            <th scope="col">INGRESO DÓLARES</th>
            <th scope="col">SALIDA DÓLARES</th>
            <th scope="col">SALDO DÓLARES</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($resultados as $resultado)
            <tr>
                <td style="vertical-align: middle">{{ $resultado->codigo_repuesto }}</td>
                <td style="vertical-align: middle">{{ $resultado->descripcion }}</td>
                <td style="vertical-align: middle">{{ $resultado->fecha_movimiento }}</td>
                <td style="vertical-align: middle">{{ $resultado->usuario }}</td>
                <td style="vertical-align: middle">{{ $resultado->fuente == 'MESON' ? 'NV MESON' : $resultado->fuente }}
                </td>
                <td style="vertical-align: middle">{{ $resultado->nro_fuente }}</td>
                <td style="vertical-align: middle">{{ $resultado->nro_factura }}</td>
                <td style="vertical-align: middle">{{ $resultado->motivo }}</td>
                <td style="vertical-align: middle">{{ $resultado->ubicacion }}</td>
                <td style="vertical-align: middle">{{ $resultado->cantidad_ingreso }}</td>
                <td style="vertical-align: middle">{{ $resultado->cantidad_salida }}</td>
                <td style="vertical-align: middle">{{ $resultado->cantidad_saldo }}</td>

                @if ($resultado->motivo == 'INGRESO')
                    <td style="vertical-align: middle">
                        {{ round($resultado->precio_de_compra, 4) }}</td>
                    <td style="vertical-align: middle">{{ $resultado->motivo != 'S.I.' ? round( $resultado->precio_de_compra*$resultado->cantidad_ingreso,4) : '' }}
                @else
                    <td style="vertical-align: middle">{{ $resultado->costo_dolares }}</td>
                    <td style="vertical-align: middle">{{ $resultado->motivo != 'S.I.' ? $resultado->ingreso_dolares : '' }}
                @endIf
                {{-- <td style="vertical-align: middle">{{ $resultado->costo_dolares }}</td> --}}
                
                </td>
                <td style="vertical-align: middle">{{ $resultado->motivo != 'S.I.' ? $resultado->salida_dolares : '' }}
                </td>
                <td style="vertical-align: middle">{{ $resultado->saldo_dolares }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
