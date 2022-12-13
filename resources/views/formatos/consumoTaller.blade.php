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

<h3 align="center">CONSUMO DE TALLER N° {{ $consumoTaller->id_consumo_taller }}</h3>

<table style="width: 100%;">
    <tr>
        <td>Fecha Emisión:</td>
        <td>: {{ $fecha_impresion }}</td>
        <td>Asesor de repuestos</td>
        <td>: {{ $consumoTaller->getNombreCompletoUsuarioRegistro() }}</td>
        
    </tr>
    <tr>
        <td>Sucursal</td>
        <td>: Los Olivos</td>
        <td>Usuario Solicitante</td>
        <td>: {{ $consumoTaller->usuario_solicitante }}</td>
    </tr>
    {{-- <tr>
        <td>Fecha Entrega:</td>
        <td>: {{ $fecha_entrega }}</td>
    </tr> --}}
    </tr>
</table>

<table class="all-bordered"
       style="width: 100%; margin-top: 20px">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>C. Unitario</th>
            <th>C. Total</th>
            <th>Ubicación</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lineasConsumoTaller as $lineaConsumoTaller)
            <tr>
                <td>{{ $lineaConsumoTaller->getRepuestoNroParte() }}</td>
                <td>{{ $lineaConsumoTaller->getDescripcionRepuesto() }}</td>
                <td>{{ $lineaConsumoTaller->cantidad }}</td>
                <td>{{ $lineaConsumoTaller->getCostoUnitario() }}</td>
                <td>{{ $lineaConsumoTaller->obtenerTotal() }}</td>
                <td>{{ $lineaConsumoTaller->repuesto->ubicacion }}</td>
                <td>{{ $lineaConsumoTaller->stock }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pt-2">
    <p>Montos expresados en dólares y sin igv</p>
</div>
