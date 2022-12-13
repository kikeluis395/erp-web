@extends('mecanica.tableCanvas')
@section('titulo','Modulo de recepción - Cotizaciones MECANICA') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-4">Cotizaciones - Mecánica</h2>
  </div>
  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('mecanica.cotizaciones.index')}}" value="search">
      <div class="row">
        @if(false)
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        @endif
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroCotizacion" class="col-form-label col-12 col-sm-6"># Cotización</label>
          <input id="filtroNroCotizacion" name="nroCotizacion" type="text" class="form-control col-12 col-sm-6" placeholder="Número de cotización">
        </div>
        <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
          <label for="filtroMarca" class="col-form-label col-6">Marca</label>
          <select name="marca" id="filtroMarca" class="form-control col-6">
            <option value="all">Todos</option>
            @foreach ($listaMarcas as $marca)
              <option value="{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
            @endforeach
          </select>
        </div>

        @if(false)
        @if(in_array(Auth::user()->id_rol,[1,6]))
        <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
          <label for="filtroAsesor" class="col-form-label col-6">Asesor de Servicios</label>
          <select name="asesor" id="filtroAsesor" class="form-control col-6">
            <option value="all">Todos</option>
            @foreach ($listaAsesores as $empleado)
              <option value="{{$empleado->dni}}">{{$empleado->nombreCompleto()}}</option>
            @endforeach
          </select>
        </div>
        @endif
        @endif

      </div>
      <div class="col-12">
        <div class="row justify-content-end">
          <button type="submit" class="btn btn-primary ">Buscar</button>
        </div>
      </div>
    </form>
  </div>
  
</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row col-12">
            <div>
              <h2>Cotizaciones Registradas</h2>
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
                <th scope="col">F. CREACIÓN</th>
                <th scope="col">N° COTIZACION</th>
                <th scope="col">PLACA</th>
                <th scope="col">MARCA</th>
                <th scope="col">MODELO</th>
                <th scope="col">P. VENTA</th>
                <th>DETALLE</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($listaCotizaciones as $cotizacion)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$cotizacion->hojaTrabajo->getFechaRecepcionFormat()}}</td>
                <td>{!!$cotizacion->getLinkDetalleHTML()!!}</td>
                <td>{{substr($cotizacion->hojaTrabajo->placa_auto,0,3).'-'.substr($cotizacion->hojaTrabajo->placa_auto,3,3)}}</td>
                <td>{{$cotizacion->hojaTrabajo->vehiculo->getNombreMarca()}}</td>
                <td>{{substr($cotizacion->hojaTrabajo->getModeloVehiculo(),0,10)}}</td>
                <td>{{Helper::obtenerUnidadMonedaCambiar($cotizacion->hojaTrabajo->moneda)}} {{number_format($cotizacion->precioVenta,2)}}</td>
                <td><a href="{{route('mecanica.detalle_trabajos.index',['id_cotizacion'=>$cotizacion->id_cotizacion])}}"><button type="button" class="btn btn-warning"><i class="fas fa-info-circle icono-btn-tabla"></i>  </i></button></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection