<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">NOMBRE ASESOR</th>
      <th scope="col">NOMBRE LOCAL</th>
      <th scope="col">DOC CLIENTE</th>
      <th scope="col">NOMBRE CLIENTE</th>
      <th scope="col">TIPO VENTA</th>
      <th scope="col">NRO COTIZACION</th>
      <th scope="col">NRO OT</th>
      <th scope="col">FECHA REGISTRO</th>
      <th scope="col">FACTURA VENTA</th>
      <th scope="col">FECHA FACTURA</th>
      <th scope="col">TIPO CAMBIO</th>
      <th scope="col">CÓDIGO REPUESTO</th>
      <th scope="col">ID REPUESTO</th>
      <th scope="col">CATEGORÍA</th>
      <th scope="col">DESCRIPCIÓN</th>
      <th scope="col">CANTIDAD</th>
      <th scope="col">ES MAYOREO</th>
      <th scope="col">COSTO UNITARIO</th>
      <th scope="col">MONEDA COSTO UNITARIO</th>
      <th scope="col">PVP UNITARIO</th>
      <th scope="col">MONEDA PVP</th>
      <th scope="col">TASA DESCUENTO</th>
      <th scope="col">COSTO DÓLARES</th>
      <th scope="col">VENTA DOLARES</th>
      <th scope="col">DESCUENTO</th>
      <th scope="col">MARGEN</th>
      <th scope="col">OBSERVACIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($resultados as $resultado)
    <tr>
        <td style="vertical-align: middle">{{$resultado->nombre_asesor}}</td>
        <td style="vertical-align: middle">{{$resultado->nombre_local}}</td>
        <td style="vertical-align: middle">{{$resultado->doc_cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->nombre_cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->tipo_venta}}</td>
        <td style="vertical-align: middle">{{$resultado->nro_cotizacion}}</td>
        <td style="vertical-align: middle">{{$resultado->nro_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_registro}}</td>
        <td style="vertical-align: middle">{{$resultado->factura_venta}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_factura}}</td> 
        <td style="vertical-align: middle">{{$resultado->tipo_cambio}}</td>
        <td style="vertical-align: middle">{{$resultado->codigo_repuesto}}</td>
        <td style="vertical-align: middle">{{$resultado->id_repuesto}}</td>
        <td style="vertical-align: middle">{{$resultado->categoria}}</td>
        <td style="vertical-align: middle">{{$resultado->descripcion}}</td>
        <td style="vertical-align: middle">{{$resultado->cantidad}}</td>
        <td style="vertical-align: middle">{{$resultado->es_mayoreo}}</td>
        <td style="vertical-align: middle">{{$resultado->costo_unitario}}</td>
        <td style="vertical-align: middle">{{$resultado->moneda_costo_unitario}}</td>
        <td style="vertical-align: middle">{{$resultado->pvp_unitario}}</td>
        <td style="vertical-align: middle">{{$resultado->moneda_pvp}}</td>
        <td style="vertical-align: middle">{{$resultado->tasa_descuento}}</td>
        <td style="vertical-align: middle">{{$resultado->costo_dolares}}</td>
        <td style="vertical-align: middle">{{$resultado->venta_dolares}}</td>
        <td style="vertical-align: middle">{{$resultado->descuento}}</td>
        <td style="vertical-align: middle">{{$resultado->margen}}</td>
        <td style="vertical-align: middle">{{$resultado->observaciones}}</td>
    </tr>
    @endforeach
  </tbody>
</table>