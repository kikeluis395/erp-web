
<h4>OTs Existentes</h4>
<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">SECCION</th>
      <th scope="col">CORRECTIVO</th>
      <th scope="col">PREVENTIVO</th>
      <th scope="col">RECLAMO</th>
      <th scope="col">GARANTIA</th>
      <th scope="col">PDI</th>
      <th scope="col">SINIESTRO</th>
      <th scope="col">CORTESIA</th>
      <th scope="col">ACCESORIOS</th>
    </tr>
  </thead>
  <tbody>
    @foreach($resultadosCantidad as $resultado)
    <tr>
      <td style="vertical-align: middle">{{$resultado->seccion}}</td>
      <td style="vertical-align: middle">{{$resultado->CORRECTIVO}}</td>
      <td style="vertical-align: middle">{{$resultado->PREVENTIVO}}</td>
      <td style="vertical-align: middle">{{$resultado->RECLAMO}}</td>
      <td style="vertical-align: middle">{{$resultado->GARANTIA}}</td>
      <td style="vertical-align: middle">{{$resultado->PDI}}</td> 
      <td style="vertical-align: middle">{{$resultado->SINIESTRO}}</td>
      <td style="vertical-align: middle">{{$resultado->CORTESIA}}</td>
      <td style="vertical-align: middle">{{$resultado->ACCESORIOS}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<h4>Facturacion de OTs (EN DOLARES Y SIN IGV)</h4>
<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">SECCION</th>
      <th scope="col">CORRECTIVO</th>
      <th scope="col">PREVENTIVO</th>
      <th scope="col">RECLAMO</th>
      <th scope="col">GARANTIA</th>
      <th scope="col">PDI</th>
      <th scope="col">SINIESTRO</th>
      <th scope="col">CORTESIA</th>
      <th scope="col">ACCESORIOS</th>
    </tr>
  </thead>
  <tbody>
    @foreach($resultadosFacturacion as $resultado)
    <tr>
      <td style="vertical-align: middle">{{$resultado->seccion}}</td>
      <td style="vertical-align: middle">{{$resultado->CORRECTIVO}}</td>
      <td style="vertical-align: middle">{{$resultado->PREVENTIVO}}</td>
      <td style="vertical-align: middle">{{$resultado->RECLAMO}}</td>
      <td style="vertical-align: middle">{{$resultado->GARANTIA}}</td>
      <td style="vertical-align: middle">{{$resultado->PDI}}</td> 
      <td style="vertical-align: middle">{{$resultado->SINIESTRO}}</td>
      <td style="vertical-align: middle">{{$resultado->CORTESIA}}</td>
      <td style="vertical-align: middle">{{$resultado->ACCESORIOS}}</td>
    </tr>
    @endforeach
  </tbody>
</table>