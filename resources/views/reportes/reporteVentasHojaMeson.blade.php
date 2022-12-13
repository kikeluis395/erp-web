<table class="table text-center table-striped table-sm">
  <thead>
    <tr>
      <th scope="col">LOCAL</th>
      <th scope="col">IDVENDEDOR</th>
      <th scope="col">VENDEDOR</th>
      <th scope="col">NUMDOC</th>
      <th scope="col">RAZON SOCIAL</th>
      <th scope="col">FECHA APERTURA</th>
      <th scope="col">FECHA FACTURA</th>
      <th scope="col">NRO COTIZACIÓN</th>
      <th scope="col">NOTA DE VENTA</th>
      <th scope="col">DOCVENTA</th>
      <th scope="col">IDMEDIDA</th>
      <th scope="col">IDPRODUCTO</th>
      <th scope="col">DESCRIPCION</th>
      <th scope="col">CATEGORIA</th>
      <th scope="col">T.C. COTIZACION</th>
      <th scope="col">CANTIDAD</th>
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
      <th scope="col">VENTA DSCTO SOLES</th>
      <th scope="col">VENTA DSCTO DOLARES</th>
      <th scope="col">COSTO UNIT. SOLES</th>
      <th scope="col">COSTO UNIT. DOLARES</th>
      <th scope="col">COSTO TOTAL SOLES</th>
      <th scope="col">COSTO TOTAL DOLARES</th>
      <th scope="col">MARGEN SOLES</th>
      <th scope="col">MARGEN DOLARES</th>
      <th scope="col">DESFPAGO</th>
      <th scope="col">CTA70</th>
      <th scope="col">OBSERVACIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($resultados as $resultado)
    <tr>
        <td style="vertical-align: middle">{{$resultado->local}}</td>
        <td style="vertical-align: middle">{{$resultado->idvendedor}}</td>
        <td style="vertical-align: middle">{{$resultado->vendedor}}</td>
        <td style="vertical-align: middle">{{$resultado->numdoc}}</td>
        <td style="vertical-align: middle">{{$resultado->nombre_cliente}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_apertura}}</td>
        <td style="vertical-align: middle">{{$resultado->fecha_factura}}</td>
        <td style="vertical-align: middle">{{$resultado->num_cotizacion}}</td>
        <td style="vertical-align: middle">{{$resultado->num_nota_venta}}</td>
        <td style="vertical-align: middle">{{$resultado->docventa}}</td>
        <td style="vertical-align: middle">{{$resultado->idmedida}}</td>
        <td style="vertical-align: middle">{{$resultado->idproducto}}</td>
        <td style="vertical-align: middle">{{$resultado->descripcion}}</td>
        <td style="vertical-align: middle">{{$resultado->categoria}}</td> 
        <td style="vertical-align: middle">{{$resultado->tc_cotizacion}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->cantidad, 2, '.', '')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->vventa_dolares,2,'.','')}}</td>

        <td style="vertical-align: middle">{{number_format($resultado->descuento_marca_porc,2,'.','')}}</td>              
        <td style="vertical-align: middle">{{number_format($resultado->descuento_marca_soles,2,'.','')}}</td>              
        <td style="vertical-align: middle">{{number_format($resultado->descuento_marca_dolares,2,'.','')}}</td> 

        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_porc,2,'.','')}}</td>              
        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_soles,2,'.','')}}</td>              
        <td style="vertical-align: middle">{{number_format($resultado->descuento_unitario_dolares,2,'.','')}}</td>                         

        <td style="vertical-align: middle">{{number_format($resultado->descuento_porc_total,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->dscto_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->dscto_dolares,2,'.','')}}</td>

        <td style="vertical-align: middle">{{number_format($resultado->venta_dscto_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->venta_dscto_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_uni_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_uni_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_total_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->costo_total_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->margen_soles,2,'.','')}}</td>
        <td style="vertical-align: middle">{{number_format($resultado->margen_dolares,2,'.','')}}</td>
        <td style="vertical-align: middle"></td>
        <td style="vertical-align: middle"></td>
        <td style="vertical-align: middle">{{$resultado->observaciones}}</td>
    </tr>

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    @endforeach
  </tbody>
</table>