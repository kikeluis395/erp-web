<table class="table text-center table-striped table-sm" style="border: 1px solid #000000;">
  <thead>
    <tr>
      <th scope="col">USUARIO</th>
      <th scope="col">LOCAL</th>
      <th scope="col">FECHA</th>
      <th scope="col">RUC PROV.</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">ALMACEN</th>
      <th scope="col">NOTA DE INGRESO/DEVOLUCION</th>
      <th scope="col">FACTURA</th>
      <th scope="col">COD. PRODUCTO</th>
      <th scope="col">CATEGORIA</th>
      <th scope="col">MARCA</th>
      <th scope="col">NOMBRE PROD.</th>
      <th scope="col">CANTIDAD</th>
      <th scope="col">$ COSTO</th>
      <th scope="col">T.C.</th>
      <th scope="col">S/. COSTO</th>
    </tr>
  </thead>
  <tbody>
    
    @foreach ($resultados as $resultado)
    <tr>
      
      <td style="vertical-align: middle">{{$resultado['usuario']}}</td>
      <td style="vertical-align: middle">{{$resultado['local']}}</td>
      <td style="vertical-align: middle">{{$resultado['fecha']}}</td>
      <td style="vertical-align: middle">{{$resultado['ruc_proveedor']}}</td>
      <td style="vertical-align: middle">{{$resultado['nombre']}}</td>
      <td style="vertical-align: middle">{{$resultado['almacen']}}</td>
      <td style="vertical-align: middle">{{$resultado['nota_ingreso']}}</td>
      <td style="vertical-align: middle">{{$resultado['factura']}}</td>
      <td style="vertical-align: middle">{{$resultado['cod_producto']}}</td>
      <td style="vertical-align: middle">{{$resultado['categoria']}}</td>
      <td style="vertical-align: middle">{{$resultado['marca']}}</td>
      <td style="vertical-align: middle">{{$resultado['descripcion_producto']}}</td>
      <td style="vertical-align: middle">{{$resultado['cantidad']}}</td>
      <td style="vertical-align: middle">{{$resultado['costo_dolar']}}</td>
      <td style="vertical-align: middle">{{$resultado['tasa_cambio']}}</td>
      <td style="vertical-align: middle">{{$resultado['costo_sol']}}</td>
    </tr>
    @endforeach
  </tbody>
</table>