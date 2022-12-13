<tr>
    <td>MOS</td>
    <td></td>
    @for ($i = 1; $i <= 12; $i++)
    @php $validador = true @endphp  
        @foreach ($mos as $factura)
            @if ($i == $factura->mes)
            @php
                $mos_val = number_format($moneda == 'soles' ? $factura->soles : $factura->dolares, 3, '.', ',');

                if ($mos_val > 1) $mos_class = 'bg-danger';
                if ($mos_val == 1) $mos_class = 'bg-warning';
                if ($mos_val < 1) $mos_class = 'bg-success';

            @endphp
            <td style="font-weigth:bold; color:white!important" class="{{ $mos_class }}  @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) @endif">                
                {{ $mos_val }}
            </td>                        
            @php $validador = false @endphp    
            @endif                            
        @endforeach
        @if ($validador)
            <td class="bg-success @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) text-danger @endif">
                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
            </td>                        
        @endif
    @endfor
</tr>