@extends('mecanica.tableCanvas')
@section('titulo','Contabilidad - Compras') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Gestión de Compras</h2>
  <div class="col-12 mt-2 mt-sm-0">
    <div class="row justify-content-between ">
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
        Exportar
      </button>
      @include('modals.registrarCompra')
    </div>
    
</div>
@endsection

@section('table-content')
<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Compras Registradas</h2>
          </div>

          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
            Filtrar
          </button>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col"># ORDEN</th>
              <th scope="col"># FACTURA</th>
              <th scope="col">NOMBRE PROVEEDOR</th>
              <th scope="col"># PRODUCTOS SOLICITADOS</th>
              <th scope="col">COSTO TOTAL</th>
              <th scope="col">FECHA ENTREGA</th>
              <th scope="col">VER MAS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaCompras as $compra)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>{{$compra->nro_orden_compra}}</td>
              <td>{{$compra->nro_factura}}</td>
              <td>{{$compra->getNombreProveedor()}}</td>
              <td>{{$compra->getCantProductos()}}</td>
              <td>{{$compra->getCostoTotal()}}</td>
              <td>{{$compra->getFechaEntregaText()}}</td>
              <td><a href=""><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></a></td>
            </tr>
            @endforeach
            @if(false)
            <tr>
              <th scope="row">1</th>
              <td>12345678</td>
              <td>BRUNO VICTOR ESPEZUA ZAPANA</td>
              <td>5</td>
              <td>S/ 500</td>
              <td>20/11/2020</td>
              <td><a href=""><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></a></td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>10123456782</td>
              <td>LUIS ANDRES GOMES CAMPO</td>
              <td>7</td>
              <td>$ 4200</td>
              <td>29/11/2020</td>
              <td><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/compras.js')}}"></script>
@endsection