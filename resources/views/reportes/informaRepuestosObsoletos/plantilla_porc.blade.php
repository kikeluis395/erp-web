<tr>
    <td style="background-color: #FFFF99">{{ $titulo_icc_porc }}</td>    
    @for ($i = 1; $i <= 12; $i++)
    @php $validador = true @endphp  
        @foreach ($icc_porc as $factura)
            @if ($i == $factura->mes)
            <td>
                {{ $moneda == 'soles' ? $factura->porc_soles : $factura->porc_dolares }}%
            </td>                        
            @php $validador = false @endphp    
            @endif                            
        @endforeach
        @if ($validador)
            <td>0%</td>                        
        @endif
    @endfor
</tr>