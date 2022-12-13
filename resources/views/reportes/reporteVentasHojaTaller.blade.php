<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">PERIODO DE APERTURA</th>
      <th scope="col">SEDE</th>
      <th scope="col">DESCTIPO</th>
      <th scope="col">TIPO DE SERVICIO</th>
      <th scope="col">ASESOR</th>
      <th scope="col">PLACA</th>
      <th scope="col">VIN</th>
      <th scope="col">MODELO</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">NUM. OT</th>
      <th scope="col">ITEM</th>
      <th scope="col">ID</th>
      <th scope="col">FECHA APERTURA OT</th>
      <th scope="col">TIPO OT</th>
      <th scope="col">ESTADO OT</th>
      <th scope="col">CANT. SOLICITADA</th>
      <th scope="col">PEDIDO DE REPUESTO</th>
      <th scope="col">ID ENTREGA</th>
      <th scope="col">CANT. ENTREGADA</th>
      <th scope="col">FECHA ENTREGA REP.</th>
      <th scope="col">FECHA VENTA</th>
      <th scope="col">ID DOCUMENTO</th>
      <th scope="col">NUM. FACT.</th>
      <th scope="col">EST. FACT.</th>
      <th scope="col">FECHA FACT.</th>
      <th scope="col">ID PRODUCTO</th>
      <th scope="col">PROD. SERV.</th>
      <th scope="col">ID MONEDA</th>
      <th scope="col">MONEDA</th>
      <th scope="col">CANT. FACTURADA</th>
      <th scope="col">T.C. OT</th>
      <th scope="col">VVENTA SOLES</th>
      <th scope="col">VVENTA DOLARES</th>      
      <th scope="col">DSCTO % MARCA</th>
      <th scope="col">DSCTO MARCA SOLES</th>
      <th scope="col">DSCTO MARCA DOLARES</th>
      <th scope="col">DSCTO % DEALER</th>
      <th scope="col">DSCTO DEALER SOLES</th>
      <th scope="col">DSCTO DEALER DOLARES</th>
      <th scope="col">DSCTO % TOTAL</th>
      <th scope="col">DSCTO SOLES</th>
      <th scope="col">DSCTO DOLARES</th>
      <th scope="col">VVENTA DSCTO SOLES</th>
      <th scope="col">VVENTA DSCTO DOLARES</th>
      <th scope="col">COSTO UNIT. SOLES</th>
      <th scope="col">COSTO UNIT. DOLARES</th>
      <th scope="col">COSTO TOTAL SOLES</th>
      <th scope="col">COSTO TOTAL DOLARES</th>
      <th scope="col">MARGEN SOLES</th>
      <th scope="col">MARGEN DOLARES</th>
      <th scope="col">OBSERVACIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($resultados as $resultado)
    <tr>
        <td style="vertical-align: middle">{{$resultado->periodo_apertura}}</td>
        <td style="vertical-align: middle">{{$resultado->sede}}</td>
        <td style="vertical-align: middle">{{$resultado->desctipo}}</td>
        <td style="vertical-align: middle">{{$resultado->tipo_servicio}}</td>
        <td style="vertical-align: middle">{{$resultado->asesor}}</td>
        <td style="vertical-align: middle">{{$resultado->placa}}</td>
        <td style="vertical-align: middle">{{$resultado->chasis}}</td>
        <td style="vertical-align: middle">{{$resultado->modelo}}</td>
        <td style="vertical-align: middle">{{$resultado->cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->num_ot}}</td> 
        <td style="vertical-align: middle">{{$resultado->item}}</td>
        <td style="vertical-align: middle">{{$resultado->id}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_apertura_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->tipo_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->estado_ot}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->cant_solicitada, 2, '.', '')}}</td>
        <td style="vertical-align: middle">{{$resultado->nro_salvirtual}}</td>
        <td style="vertical-align: middle">{{$resultado->id_entrega}}</td>
        <td style="vertical-align: middle">{{$resultado->cant_entregada}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_entrega_rep}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_vta}}</td>
        <td style="vertical-align: middle">{{$resultado->IDDOCUMENTO}}</td>
        <td style="vertical-align: middle">{{$resultado->num_fact}}</td>
        <td style="vertical-align: middle">{{$resultado->est_fact}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_fact}}</td>
        <td style="vertical-align: middle">{{$resultado->idproducto}}</td>
        <td style="vertical-align: middle">{{$resultado->prod_serv}}</td>
        <td style="vertical-align: middle">{{$resultado->idmoneda}}</td>
        <td style="vertical-align: middle">{{$resultado->moneda}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->cant_facturada, 2, '.', '')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->tc_ot, 2, '.', '')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_dolares,2,'.','')}}</td>

        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_marca_porc,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_marca_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_marca_dolares,2,'.','')}}</td>

        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_dealer_porc,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_dealer_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_dealer_dolares,2,'.','')}}</td>        

        <td style="vertical-align: middle">{{number_format($resultado->descuento_porc_total,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->dscto_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->dscto_dolares,2,'.','')}}</td>

        <td style="vertical-align: middle">{{number_format($resultado->vventa_descto_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_descto_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_unit_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_unit_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->margen_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->margen_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{$resultado->observaciones}}</td>
    </tr>
    @endforeach
  </tbody>
</table>