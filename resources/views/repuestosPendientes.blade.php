@extends('tableCanvas')
@section('titulo','Modulo de Seguimiento de Repuestos Pendientes') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Seguimiento de Repuestos Pendientes</h2>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('entrega.index')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        <div class="form-group row ml-1 col-6 col-md-3">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-4 col-lg-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-3">
          <label for="filtroOT" class="col-form-label col-12 col-sm-4 col-lg-6">OT/COT MESON</label>
          <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Órden de Trabajo">
        </div>

        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
          <label for="filtroMarca" class="col-form-label col-6 col-lg-5">Marca</label>
          <select name="marca" id="filtroMarca" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
          </select>
        </div>
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
          <label for="filtroSeguro" class="col-form-label col-6 col-lg-5">Seguro</label>
          <select name="seguro" id="filtroSeguro" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
          </select>
        </div>
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
  <div class="table-responsive borde-tabla">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>OTs/NVs con Repuestos Pendientes</h2>
          </div>

          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
            Filtrar
          </button>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm tableFixHead">
          <thead>
            <tr>
              <th rowspan="2" scope="col">#</th>
              <th rowspan="2" scope="col">FECHA REGISTRO</th>
              <th rowspan="2" scope="col">SECCIÓN</th>
              <th rowspan="2" scope="col">DOC. REFERENCIA</th>
              <th rowspan="2" scope="col">STATUS CLIENTE</th>
              <th rowspan="2" scope="col">RESPONSABLE</th>
              <th rowspan="2" scope="col">ESTADO REPUESTOS</th>
              <th colspan="2" scope="col">REP. PENDIENTES</th>
              <th rowspan="2" scope="col">REP. EN CUSTODIA</th>
              <th rowspan="2" scope="col">REP. ENTREGADOS</th>
              <th rowspan="2" scope="col"></th>              
            </tr>
            <tr>
              <th>En Tránsito</th>
              <th>En Importación</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($registros as $registro)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $registro->fecha_registro }}</td>
                    <td>{{ $registro->seccion }}</td>
                    <td>{!! $registro->doc_referencia !!}</td>
                    <td>{{ $registro->status_cliente }}</td>
                    <td>{{ $registro->responsable }}</td>
                    <td class="{{ $registro->estado_repuestos_color }}">{{ $registro->estado_repuestos }}</td>
                    <td>{{ $registro->en_transito }}</td>
                    <td>{{ $registro->en_importacion }}</td>
                    <td>{{ $registro->en_custodia }}</td>
                    <td>{{ $registro->entregados }}</td>
                    <td></td>
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
  <script src="{{asset('js/entrega.js')}}"></script>
@endsection