<table class="table text-center table-striped table-sm">
    <tr>
        <td align="left" style="color: #856404; font-weight: bold;">DÍAS TRANSCURRIDOS</td>
        <td align="left" style="color: #856404; font-weight: bold;"></td>
        @for ($i = 1; $i <= 12; $i++)
        <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
        @endfor
    </tr>
    
    <tr>
        <td align="left" style="color: #856404; font-weight: bold;">DÍAS HÁBILES</td>
        <td align="left" style="color: #856404; font-weight: bold;"></td>
        @for ($i = 1; $i <= 12; $i++)
        <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_filtro), App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
        @endfor
    </tr>
    
    <tr class="alert alert-primary">
        <th align="left" style="background-color: #e9e9e9;">TALLER</th>
        <th align="left" style="background-color: #e9e9e9;"></th>
        @for ($i = 1; $i <= 12; $i++)
        <th style="background-color: #e9e9e9;">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
        @endfor
    </tr>
    
    {{-- MO --}}

    <tr>
        <td rowspan="5">MANO DE OBRA</td>  
    </tr>
    <tr>
        <td>VENTA</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($mec_mo as $factura)
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
            @foreach ($mec_mo as $factura)
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
            @foreach ($mec_mo as $factura)
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
            @foreach ($mec_mo as $factura)
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
    
    {{-- REPUESTOS --}}
    <tr>
        <td colspan="14"></td>
    </tr>
    <tr>
        <td rowspan="5">REPUESTOS</td>  
    </tr>
    <tr>
        <td>VENTA</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($mec_rptos as $factura)
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
            @foreach ($mec_rptos as $factura)
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
            @foreach ($mec_rptos as $factura)
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
            @foreach ($mec_rptos as $factura)
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
    
    {{-- TOTAL --}}
    <tr>
        <td colspan="14"></td>
    </tr>
    <tr>
        <td rowspan="5">TOTAL</td>  
    </tr>
    <tr>
        <td>VENTA</td>
        @for ($i = 1; $i <= 12; $i++)
        @php $validador = true @endphp  
            @foreach ($mec_total as $factura)
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
            @foreach ($mec_total as $factura)
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
            @foreach ($mec_total as $factura)
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
            @foreach ($mec_total as $factura)
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

</table>