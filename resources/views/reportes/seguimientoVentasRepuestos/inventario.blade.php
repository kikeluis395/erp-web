<tr>
    <td>INVENTARIO</td>
    <td></td>
    @for ($i = 1; $i <= 12; $i++)
    @php $validador = true @endphp  
    @php $proyeccion = false @endphp 
        @foreach ($inventario as $factura)
            @if ($i == $factura->mes)
            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->soles/$diasUtiles)*$diasTotales : $factura->soles) : 
                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->dolares/$diasUtiles)*$diasTotales : $factura->dolares), 0, '.', ',') }}

            </td>                        
            @php $validador = false @endphp    
            @endif                            
        @endforeach
        @if ($validador)
            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
                
            </td>                        
        @endif
    @endfor
</tr>