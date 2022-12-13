<tr>
    <td @if ($titulo_icc == 'TOTAL') class="bg-dark text-white" @else style="background-color: #FFFF99" @endif>{{ $titulo_icc }}</td>    
    @for ($i = 1; $i <= 12; $i++)
    @php $validador = true @endphp  
        @foreach ($icc as $factura)
            @if ($i == $factura->mes)
            <td @if ($titulo_icc == 'TOTAL')  style="background-color: #D9D9D9" @endif>
                {{ $simbolo }}{{ number_format($moneda == 'soles' ? $factura->soles : $factura->dolares, 0, '.', ',') }}
            </td>                        
            @php $validador = false @endphp    
            @endif                            
        @endforeach
        @if ($validador)
            <td @if ($titulo_icc == 'TOTAL')  style="background-color: #D9D9D9" @endif>0</td>                        
        @endif
    @endfor
</tr>