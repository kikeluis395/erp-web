<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">LOCAL</th>
      <th scope="col">VENDEDOR</th>
      <th scope="col">NUMDOC</th>
      <th scope="col">RAZON SOCIAL</th>
      <th scope="col">FECHA APERTURA</th>
      <th scope="col">FECHA FACTURA</th>
      <th scope="col">NRO COTIZACIÓN</th>
      <th scope="col">NOTA DE VENTA</th>
      <th scope="col">DOCVENTA</th>
      <th scope="col">CODIGO</th>
      <th scope="col">DESCRIPCION</th>
      <th scope="col">CATEGORIA</th>
      <th scope="col">MONEDA VENTA</th>
      <th scope="col">T.C. COTIZACION</th>
      <th scope="col">CANTIDAD</th>
      <th scope="col">VVENTA DOLARES</th>
      <th scope="col">DSCTO DOLARES</th>
      <th scope="col">VENTA DSCTO DOLARES</th>
      <th scope="col">COSTO UNIT. DOLARES</th>
      <th scope="col">COSTO TOTAL DOLARES</th>
      <th scope="col">MARGEN DOLARES</th>
      <th scope="col">OBSERVACIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($resultados as $resultado)
    <tr>
        <td style="vertical-align: middle">{{$resultado->local}}</td>        
        <td style="vertical-align: middle">{{$resultado->vendedor}}</td>
        <td style="vertical-align: middle">{{$resultado->numdoc}}</td>
        <td style="vertical-align: middle">{{$resultado->nombre_cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_apertura}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_factura}}</td>
        <td style="vertical-align: middle">{{$resultado->num_cotizacion}}</td>
        <td style="vertical-align: middle">{{$resultado->num_nota_venta}}</td>
        <td style="vertical-align: middle">{{$resultado->docventa}}</td>      
        <td style="vertical-align: middle">{{$resultado->idproducto}}</td>
        <td style="vertical-align: middle">{{$resultado->descripcion}}</td>
        <td style="vertical-align: middle">{{$resultado->categoria}}</td> 
        <td style="vertical-align: middle">{{$resultado->moneda ?? '-'}}</td> 
        <td style="vertical-align: middle">{{$resultado->tc_cotizacion}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->cantidad, 2, '.', '')}}</td>        
        <td style="vertical-align: middle">{{number_format($resultado->vventa_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->dscto_dolares,2,'.','')}}</td>        
        <td style="vertical-align: middle">{{number_format($resultado->venta_dscto_dolares,2,'.','')}}</td>        
        <td style="vertical-align: middle">{{number_format($resultado->costo_uni_dolares,2,'.','')}}</td>        
        <td style="vertical-align: middle">{{number_format($resultado->costo_total_dolares,2,'.','')}}</td>        
        <td style="vertical-align: middle">{{number_format($resultado->margen_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{$resultado->observaciones}}</td>
    </tr>

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    @endforeach
  </tbody>
</table>