    <tr>
        <td rowspan="5">MESÓN</td>  
    </tr>
    <tr>
        <td>VENTA</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($meson as $factura)
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
    <tr>
        <td>COSTO</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($meson as $factura)
                @if ($i == $factura->mes)
                <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                    {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->soles/$diasUtiles)*$diasTotales : $factura->soles) - 
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_soles/$diasUtiles)*$diasTotales : $factura->margen_soles) : 
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->dolares/$diasUtiles)*$diasTotales : $factura->dolares) - 
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_dolares/$diasUtiles)*$diasTotales : $factura->margen_dolares), 0, '.', ',') }}
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
    <tr>
        <td>UTILIDAD</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($meson as $factura)
                @if ($i == $factura->mes)
                <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                    {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_soles/$diasUtiles)*$diasTotales : $factura->margen_soles) : 
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_dolares/$diasUtiles)*$diasTotales : $factura->margen_dolares), 0, '.', ',') }}
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
    <tr>
        <td>MARGEN %</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($meson as $factura)
                @if ($i == $factura->mes)
                <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                    {{ number_format($moneda == 'soles' ? 
                    (($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_soles/$diasUtiles)*$diasTotales : $factura->margen_soles) /
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->soles/$diasUtiles)*$diasTotales : $factura->soles))*100: 
                    (($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_dolares/$diasUtiles)*$diasTotales : $factura->margen_dolares) /
                    ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->dolares/$diasUtiles)*$diasTotales : $factura->dolares))*100, 0, '.', '') }}%
                </td>                        
                @php $validador = false @endphp    
                @endif                            
            @endforeach
            @if ($validador)
                <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                    {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}%
                </td>                        
            @endif
        @endfor
    </tr>        