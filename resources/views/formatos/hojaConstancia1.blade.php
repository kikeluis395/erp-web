@include('formatos.headerConstancia', ['pagina' => 1])
<br>
<table>
    <tr>
        @if ($seccion == 'B&P')
        <td class="justify">
            Estimado Sr(a). {{ $cliente }}, identificado con documento {{ $documento_cliente}} propietario del vehículo de
            marca {{ $marca }}, modelo {{ $modelo }} 3, placa {{ $placa }} al cual le hemos realizado los trabajos autorizados por la
            Compañía de Seguros PACIFICO con número de siniestro 1000508043 en la orden de trabajo {{ $documento }}; dejamos
            CONSTANCIA a través de la presente, la relación de los siguientes repuestos que se encuentran PENDIENTES de
            instalación por encontrarse en importación:
        </td>
        @elseif($seccion == 'MEC')
        <td class="justify">
            Estimado Sr(a). {{ $cliente }}, identificado con documento {{ $documento_cliente}} propietario del vehículo de
            marca {{ $marca }}, modelo {{ $modelo }}, placa {{ $placa }} al cual le hemos realizado trabajos de mantenimiento preventivo
            y/o correctivo en la orden de trabajo {{ $documento }}; dejamos CONSTANCIA a través de la presente, la relación de los
            siguientes repuestos que se encuentran PENDIENTES de instalación por encontrarse en importación:
        </td>
        @else
        <td class="justify">
            Estimado Sr(a). {{ $cliente }}, identificado con documento {{ $documento_cliente}} al cual se le ha vendido los
            repuestos indicados en la cotización {{ $cotizacion }} con NV MESÓN {{ $documento }}; dejamos CONSTANCIA a través de la presente, la
            relación de los siguientes repuestos que se encuentran PENDIENTES de entrega por encontrarse en importación:
        </td>
        @endif
    </tr>
</table>
<br>
<div style="width: 100%">
    <table style="width: 80%; margin: 0 auto" class="table_rpt">
        <tr style="background-color: #7F7F7F; color: white">
            <th>CÓDIGO</th>
            <th>DESCRIPCIÓN</th>
            <th>FECHA<br>PEDIDO</th>
            <th>FECHA<br>ESTIMADA<br>ARRIBO</th>
        </tr>
        @foreach ($rptos_pendientes as $rpto)
            <tr class="table_rpt">
                <td align="center">{{ $rpto->codigo }}</td>
                <td align="center">{{ $rpto->descripcion }}</td>
                <td align="center">{{ $rpto->fecha_pedido }}</td>
                <td align="center">{{ $rpto->fecha_promesa }}</td>
            </tr>
        @endforeach

    </table>
</div>
<br>
<br>
<table>
    <tr>
        <td class="justify">
            Una vez que contemos con los repuestos en nuestro almacén nos contactaremos con Ud. al teléfono o correo
            electrónico brindado líneas abajo. <u><strong>ES MUY IMPORTANTE CONTAR CON SUS DATOS ACTUALIZADOS PARA PODER
                    INFORMARLE OPORTUNAMENTE POR LO QUE USTED</strong></u>
        </td>
    </tr>
</table>

@include('formatos.footerConstancia')