<style>
    * {
        border-width: 0.5px;
        font-family: 'sans-serif';
        font-size: 14px;
    }

    .all-bordered {
        border-spacing: 0;
        border-collapse: collapse;
    }

    .all-bordered td {
        border: solid;
    }

    .all-bordered th {
        border: solid;
    }

</style>
<div><img src="{{ asset('assets/images/logo_planeta.jpg') }}"
         style="height: 28px;"></div>

<h3 align="center">NOTA DE REINGRESO N° {{ $infoGeneral->id_reingreso }}</h3>

<table style="width: 100%;">
    <tr>
        <td>OT</td>
        <td>: {{ $infoGeneral->nro_ot }}</td>
        <td>Sucursal</td>
        <td>: {{ $infoGeneral->sucursal }}</td>
    </tr>
    <tr>
        <td>Placa</td>
        <td>: {{ $infoGeneral->placa }}</td>
        <td>Asesor Repuestos</td>
        <td>: {{ $infoGeneral->usuario }}</td>
    </tr>
    <tr>
        <td>Marca</td>
        <td>: {{ $infoGeneral->marca }}</td>
        <td>Asesor Servicio</td>
        <td>: {{ $infoGeneral->asesor }}</td>
    </tr>
    <tr>
        <td>Modelo</td>
        <td>: {{ $infoGeneral->modelo }}</td>
        <td>Fecha Entrega Rep.</td>
        <td>: {{ $infoGeneral->fecha_pr }}</td>
    </tr>
    <tr>
        <td>Cliente</td>
        <td>: {{ $infoGeneral->cliente }}</td>
        <td>Fecha Devolución Rep.</td>
        <td>: {{ $infoGeneral->fecha_impresion }}</td>
    </tr>
</table>

<table class="all-bordered"
       style="width: 100%; margin-top: 20px">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cant. Devolución</th>
            {{-- <th>V. Venta</th> --}}
            {{-- <th>Total</th> --}}
            <th>Ubicación</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lineasReingresoRepuestos as $lineaReingresoRepuestos)
            <tr>
                <td>{{ $lineaReingresoRepuestos->getRepuestoNroParte() }}</td>
                <td>{{ $lineaReingresoRepuestos->getDescripcionRepuesto() }}</td>
                <td>{{ $lineaReingresoRepuestos->cantidad_reingreso }}</td>
                {{-- <td>{{number_format($lineaReingresoRepuestos->getMontoVentaUnitario($lineaReingresoRepuestos->getFechaRegistroCarbon(),false),2)}}</td> --}}
                {{-- <td>{{number_format($lineaReingresoRepuestos->getMontoVentaTotal($lineaReingresoRepuestos->getFechaRegistroCarbon(),false),2)}}</td> --}}
                <td>{{ $lineaReingresoRepuestos->repuesto->ubicacion }}</td>
                <td>{{ $lineaReingresoRepuestos->stock }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
