<table class="table text-center table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">COTIZACION</th>
            <th scope="col">FECHA CREACIÓN</th>
            <th scope="col">ESTADO</th>
            <th scope="col">LOCAL</th>
            <th scope="col">ASESOR SERVICIO</th>
            <th scope="col">PLACA</th>
            <th scope="col">VIN</th>
            <th scope="col">MARCA</th>
            <th scope="col">MODELO</th>
            <th scope="col">DOC CLIENTE</th>
            <th scope="col">CLIENTE</th>
            <th scope="col">TRABAJOS</th>
            <th scope="col">$ VENTA</th>
            <th scope="col">MOTIVO CIERRE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listaCotizaciones as $cotizacion)
            <tr>
                <th style="vertical-align: middle"
                    scope="row">{{ $loop->iteration }}</th>
                <td style="vertical-align: middle">{{ $cotizacion->id_cotizacion }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->getFechaRecepcionFormat() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->getEstado() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->empleado->local->nombre_local }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->empleado->nombreCompleto() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->getPlacaAutoFormat() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->vehiculo->getVin() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->vehiculo->getNombreMarca() }}</td>
                <td style="vertical-align: middle">{{ substr($cotizacion->hojaTrabajo->getModeloVehiculo(), 0, 10) }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->getNumDocCliente() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->getNombreCliente() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->getPrimerTrabajoPreventivoOptional() }}</td>
                <td style="vertical-align: middle">{{ $cotizacion->hojaTrabajo->moneda == 'DOLARES' ? number_format($cotizacion->hojaTrabajo->getValorTotal() / 1.18, 2) : number_format($cotizacion->hojaTrabajo->getValorTotal() / 1.18 / $cotizacion->hojaTrabajo->tipo_cambio, 2) }}</td>
                <td>{{ $cotizacion->getMotivoCierre() }}</td>
            </tr>
        @endforeach
        <!-- <tr>
      <th style="vertical-align: middle" scope="row">1</th>
      <td style="vertical-align: middle">1</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">SUZUKI</td>
      <td style="vertical-align: middle">SWIFT</td>
      <td style="vertical-align: middle">ABC-123</td>
      <td style="vertical-align: middle">BRUNO ESPEZUA</td>
      <td style="vertical-align: middle">ABIERTA</td>
      <td style="vertical-align: middle">BRUNO ESPEZUA</td>
    </tr>
    <tr>
      <th style="vertical-align: middle" scope="row">2</th>
      <td style="vertical-align: middle">2</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">09/12/2020</td>
      <td style="vertical-align: middle">KIA</td>
      <td style="vertical-align: middle">CERATO</td>
      <td style="vertical-align: middle">123-456</td>
      <td style="vertical-align: middle">BRUNO ESPEZUA</td>
      <td style="vertical-align: middle">ABIERTA</td>
      <td style="vertical-align: middle">BRUNO ESPEZUA</td>
    </tr> -->
    </tbody>
</table>
