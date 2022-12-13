@extends('mecanica.tableCanvas')
@section('titulo','Repuestos - Kardex') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-4">Kardex de Repuestos</h2>
  </div>
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarKardex" class="my-3 mr-3" method="GET" action="{{route('repuestos.movimientos')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroRepuesto" class="col-form-label col-12 col-sm-6">Cod. Repuesto</label>
          <input id="filtroNroRepuesto" name="nroRepuesto" type="text" class="form-control col-12 col-sm-6" placeholder="Código de repuesto">
        </div>
        @if(false)
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroDescripcion" class="col-form-label col-12 col-sm-6">Descripción</label>
          <input id="filtroDescripcion" name="descripcion" type="text" class="form-control col-12 col-sm-6" placeholder="Descripcion">
        </div>
        @endif
        <div class="form-group row ml-1 mr-1 col-12 col-sm-6 pr-sm-0 pl-0">
          <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
            <label for="filtroFechaInicioMovimiento" class="col-form-label col-12 col-sm-4 col-lg-5">Mes/Año Inicial</label>
            <input id="filtroFechaInicioMovimiento" name="fechaInicioMovimiento" type="text"  autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha inicio movimiento" value="">
          </div>
        </div>
      </div>
      <div class="row justify-content-end mb-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <button class="btn btn-primary ml-3">Limpiar</button>
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
            <h2>Kardex de Repuestos</h2>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">CODIGO</th>
              <th scope="col">DESCRIPCION</th>
              @if(false)
              <th scope="col">LOCAL</th>
              @endif
              <th scope="col">FECHA</th>
              <th scope="col">ENTRADA</th>
              <th scope="col">SALIDA</th>
              <th scope="col">SALDO</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRepuestos as $repuesto)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{$repuesto->codigo_repuesto}}</td>
              <td style="vertical-align: middle">{{$repuesto->descripcion}}</td>
              @if(false)
              <td style="vertical-align: middle">{{$repuesto->nombre_local}}</td>
              @endif
              <td style="vertical-align: middle">{{\Carbon\Carbon::parse($repuesto->fecha_movimiento)->format('d/m/Y')}}</td>
              <td style="vertical-align: middle">{{$repuesto->entrada}}</td>
              <td style="vertical-align: middle">{{$repuesto->salida}}</td>
              <td style="vertical-align: middle">{{$repuesto->saldo}}</td>
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