<table class="table text-center table-striped table-sm">
	<thead>
	<tr>
	  <th scope="col">#</th>
	  <th scope="col">COD. REPUESTO</th>
	  <th scope="col">REPUESTO</th>
	  <th scope="col">UBICACION</th>
	  <th scope="col">STOCK</th>
	  <th scope="col">ULTIMO INGRESO</th>
	  <th scope="col">ULTIMO EGRESO</th>
	  <th scope="col">MARCA</th>
	  <th scope="col">CATEGORÍA</th> 
	  <th scope="col">COSTO UNITARIO $</th>
	  <th scope="col">COSTO TOTAL $</th>
	  <th scope="col">COSTO UNITARIO S/</th>    
	  <th scope="col">COSTO TOTAL S/</th>    
	</tr>
  </thead>
  <tbody>
	@foreach($resultados as $resultado)
	<tr>
	  <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
	  <td style="vertical-align: middle">{{$resultado->codigo_repuesto}}</td>
	  <td style="vertical-align: middle">{{$resultado->descripcion}}</td>
	  <td style="vertical-align: middle">{{$resultado->ubicacion}}</td>
	  <td style="vertical-align: middle">{{$resultado->stock_fisico}}</td>
	  <td style="vertical-align: middle">{{$resultado->UltIng}}</td>
	  <td style="vertical-align: middle">{{$resultado->UltEgr}}</td>
	  <td style="vertical-align: middle">{{$resultado->Marca}}</td>
	  <td style="vertical-align: middle">{{$resultado->nombre_categoria}}</td>
	  <td style="vertical-align: middle">{{$resultado->costoUnitarioD}}</td>
	  <td style="vertical-align: middle">{{$resultado->CostoTotalD}}</td>
	  <td style="vertical-align: middle">{{$resultado->CostoUnitarioS}}</td>
	  <td style="vertical-align: middle">{{$resultado->CostoTotalS}}</td>
	</tr>
	@endforeach
  </tbody>
</table>