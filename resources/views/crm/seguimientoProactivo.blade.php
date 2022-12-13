@extends('mecanica.tableCanvas')
@section('titulo','Modulo de recepción')

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-4">Seguimiento Proactivo</h2>
  </div>
  <div id="busquedaCollapsable" class="col-12" style="background: white;margin-top:10px" >
    <form id="FormBuscarCitas" class="my-3" method="GET" action="{{route('crm.seguimientoProactivo')}}" value="search" noLimpiar>
      <div class="row">
        <div class="row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
          <div class="form-group form-inline">
            <label for="filtroFecha" class="col-form-label col-6 col-lg-5">Fecha</label>
            <input name="fecha" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaCitaIn" placeholder="dd/mm/aaaa" maxlength="10" autocomplete="off" value="@if(isset($_GET['fecha'])){{$_GET['fecha']}}@endif">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
      </div>
    </form>
  </div>

</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div id="tablaCitasContainer" class="table-responsive borde-tabla tableFixHead">
  </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/citas.js')}}"></script>
@endsection