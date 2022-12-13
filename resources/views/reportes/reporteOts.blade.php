
<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">SECCION</th>
      <th scope="col">OT</th>
      <th scope="col">ESTADO OT</th>
      <th scope="col">TIPO OT</th>
      <th scope="col">FECHA APERTURA</th>
      <th scope="col">FECHA FACTURACIÓN</th>
      <th scope="col">LOCAL</th>
      <th scope="col">RECEPCIONISTA</th>
      <th scope="col">PLACA</th>
      <th scope="col">VIN</th>
      <th scope="col">MARCA</th>
      <th scope="col">MODELO TÉCNICO</th>
      <th scope="col">NUM DOC</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">TELÉFONO</th>
      <th scope="col">CORREO</th>
      <th scope="col">DIRECCIÓN</th>
      <th scope="col">DEPARTAMENTO</th>
      <th scope="col">CIUDAD</th>
      <th scope="col">DISTRITO</th>
      <th scope="col">TIPO CAMBIO</th>
      <th scope="col">COSTO REP</th>
      <th scope="col">VENTA REP</th>
      <th scope="col">DSCTO REP</th>
      <th scope="col">MARGEN REP</th>
      <th scope="col">COSTO TERCEROS</th>
      <th scope="col">VENTA TERCEROS</th>
      <th scope="col">DSCTO TERCEROS</th>
      <th scope="col">MARGEN TERCEROS</th>
      <th scope="col">TOTAL MO</th>
      <th scope="col">DSCTO MO</th>
      <th scope="col">VENTA TOTAL</th>
      <th scope="col">DSCTO TOTAL</th>
      <th scope="col">HORAS MEC</th>
      <th scope="col">HORAS MEC COLISIÓN</th>
      <th scope="col">HORAS CARROCERÍA</th>
      <th scope="col">PAÑOS</th>
      <th scope="col">OBSERVACIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($resultados as $resultado)
    <tr>
        <td style="vertical-align: middle">{{$resultado->seccion}}</td>
        <td style="vertical-align: middle">{{$resultado->ot}}</td>
        <td style="vertical-align: middle">{{$resultado->estado_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->tipo_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_apertura}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_facturacion}}</td>
        <td style="vertical-align: middle">{{$resultado->local}}</td>
        <td style="vertical-align: middle">{{$resultado->recepcionista}}</td>
        <td style="vertical-align: middle">{{$resultado->placa}}</td>
        <td style="vertical-align: middle">{{$resultado->vin}}</td> 
        <td style="vertical-align: middle">{{$resultado->marca}}</td>
        <td style="vertical-align: middle">{{$resultado->modelo_tecnico}}</td>
        <td style="vertical-align: middle">{{$resultado->num_doc}}</td>
        <td style="vertical-align: middle">{{$resultado->cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->telefono}}</td>
        <td style="vertical-align: middle">{{$resultado->correo}}</td>
        <td style="vertical-align: middle">{{$resultado->direccion}}</td>
        <td style="vertical-align: middle">{{$resultado->departamento}}</td>
        <td style="vertical-align: middle">{{$resultado->ciudad}}</td>
        <td style="vertical-align: middle">{{$resultado->distrito}}</td>
        <td style="vertical-align: middle">{{$resultado->tipo_cambio}}</td>
        <td style="vertical-align: middle">{{$resultado->costo_rep}}</td>
        <td style="vertical-align: middle">{{$resultado->venta_rep}}</td>
        <td style="vertical-align: middle">{{$resultado->dscto_rep}}</td>
        <td style="vertical-align: middle">{{$resultado->margen_rep}}</td>
        <td style="vertical-align: middle">{{$resultado->costo_terceros}}</td>
        <td style="vertical-align: middle">{{$resultado->venta_terceros}}</td>
        <td style="vertical-align: middle">{{$resultado->dscto_terceros}}</td>
        <td style="vertical-align: middle">{{$resultado->margen_terceros}}</td>
        <td style="vertical-align: middle">{{$resultado->total_mo}}</td>
        <td style="vertical-align: middle">{{$resultado->dscto_mo}}</td>
        <td style="vertical-align: middle">{{$resultado->venta_total}}</td>
        <td style="vertical-align: middle">{{$resultado->dscto_total}}</td>
        <td style="vertical-align: middle">{{$resultado->horas_mec}}</td>
        <td style="vertical-align: middle">{{$resultado->horas_mec_colision}}</td>
        <td style="vertical-align: middle">{{$resultado->horas_carr}}</td>
        <td style="vertical-align: middle">{{$resultado->panhos}}</td>
        <td style="vertical-align: middle">{{$resultado->observaciones}}</td>

    </tr>
    @endforeach
  </tbody>
</table>