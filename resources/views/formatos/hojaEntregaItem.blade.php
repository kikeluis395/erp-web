<div>
    <img src="{{ asset('assets/images/logo_planeta.jpg') }}"
         style="height: 28px;" />
</div>

<h3 align="center">ORDEN DE SALIDA N° #{{ $id }}</h3>

<div style="width: 100%; ">
    <table style="width: 100%; padding: 4px;">
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;width: 50%;"><strong style="font-size:10px;">Fecha:</strong> {{ $fecha }}
            </td>
            <td style="font-size:10.5px;width: 50%;"><strong style="font-size:10px;">OT:</strong> {{ $ot }}
            </td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Cliente:</strong> {{ $cliente }}
            </td>
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Marca:</strong> {{ $marca }}</td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Placa:</strong> {{ $placa }}</td>
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Modelo:</strong> {{ $modelo }}</td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Kilometraje:</strong>
                {{ $kilometraje }}</td>
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Color:</strong> {{ $color }}</td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Nro. Chasis:</strong> {{ $chasis }}
            </td>
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Nro. Motor:</strong> {{ $motor }}
            </td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Nro. de DOC:</strong> {{ $doc }}
            </td>
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Tipo OT:</strong> {{ $tipo_ot }}
            </td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">Hora Salida:</strong>
                {{ $hora_salida }}</td>
            <td style="font-size:10.5px;"></td>
        </tr>
    </table>
    <span style="font-size:10px;">OBSERVACIONES:</span>
    <p style="font-size:10.5px;">{{ $observaciones }}</p>
</div>
