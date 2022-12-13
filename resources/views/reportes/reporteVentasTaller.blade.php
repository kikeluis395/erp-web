<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">SEDE</th>
      <th scope="col">ASESOR</th>
      <th scope="col">PLACA</th>
      <th scope="col">VIN</th>
      <th scope="col">MODELO</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">NUM. OT</th>
      <th scope="col">FECHA APERTURA OT</th>
      <th scope="col">TIPO OT</th>
      <th scope="col">FECHA FACT.</th>
      <th scope="col">DOCVENTA</th>
      <th scope="col">TIPO</th>
      <th scope="col">CODIGO</th>
      <th scope="col">PROD. SERV.</th>
      <th scope="col">CANT. FACTURADA</th>
      <th scope="col">MONEDA</th>
      <th scope="col">T.C. OT</th>
      <th scope="col">VVENTA DOLARES</th>
      <th scope="col">VVENTA DSCTO DOLARES</th>
      <th scope="col">COSTO UNIT. DOLARES</th>
      <th scope="col">COSTO TOTAL DOLARES</th>
      <th scope="col">MARGEN DOLARES</th>
      <th scope="col">OBSERVACIONES</th>    
    </tr>
  </thead>
  <tbody>
    @foreach ($resultados as $resultado)
    <tr>
        <td style="vertical-align: middle">{{$resultado->sede}}</td>
        <td style="vertical-align: middle">{{$resultado->asesor}}</td>
        <td style="vertical-align: middle">{{$resultado->placa}}</td>
        <td style="vertical-align: middle">{{$resultado->chasis}}</td>
        <td style="vertical-align: middle">{{$resultado->modelo}}</td>
        <td style="vertical-align: middle">{{$resultado->cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->num_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_apertura_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->tipo_ot}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_fact}}</td>
        <td style="vertical-align: middle">{{$resultado->num_fact}}</td>
        <td style="vertical-align: middle">{{$resultado->desctipo}}</td>
        <td style="vertical-align: middle">{{$resultado->idproducto}}</td>
        <td style="vertical-align: middle">{{$resultado->prod_serv}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->cant_facturada, 2, '.', '')}}</td>
        <td style="vertical-align: middle">{{$resultado->moneda}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->tc_ot, 2, '.', '')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_descto_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_unit_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->margen_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{$resultado->observaciones}}</td>                 
    </tr>
    @endforeach
  </tbody>
</table>