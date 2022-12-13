@extends('repuestos.repuestosCanvas')
@section('titulo','Hojas de Inspeccion PDI') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-4">Seguimiento de Hojas de Inspeccion</h2>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('meson.index')}}" value="search">
      <div class="row">
        
        
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3 px-sm-0">
          <label for="filtroCOT" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6"># COT</label>
          <input id="filtroCOT" name="nroCOT" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Número de cotización" value="{{ isset(request()->nroCOT) ? request()->nroCOT : '' }}" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3 px-sm-0">
          <label for="filtroNV" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">Color</label>
          <input id="filtroNV" name="nroNV" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" >
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3">
          <label for="filtroNumDoc" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">Modelo</label>
          <input id="filtroNumDoc" name="modelo" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6"  >
        </div>
        <div class="form-group row ml-1 mr-1 col-12 col-sm-6 pr-sm-0 pl-0">
          <label for="filtroFechaInicioSolicitud" class="col-form-label col-12 col-sm-4 col-lg-5">Fecha de registro</label>
          <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
            <input id="filtroFechaInicioSolicitud" name="fechaInicioSolicitud" value="{{ isset(request()->fechaInicioSolicitud) ? request()->fechaInicioSolicitud : '' }}" type="text" autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha solicitud 1">
            -
            <input id="filtroFechaFinSolicitud" name="fechaFinSolicitud" value="{{ isset(request()->fechaFinSolicitud) ? request()->fechaFinSolicitud : '' }}" type="text" autocomplete="off" class="fecha-fin form-control col-5" placeholder="Fecha solicitud 2">
          </div>
        </div>

      <div class="col-12">
        <div class="row justify-content-end">
          <button type="submit" class="btn btn-primary mr-3">Buscar</button>
        </div>
      </div>
    </form>
  </div>

  @if(false)
  <div class="row justify-content-end">
    <a href="{{route('meson.create')}}"><button id="btnHojaRepuestos" type="button" class="btn btn-warning" style="margin-right:20px">Registrar Cotización</button></a>
  </div>
  @endif
</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Seguimiento de hojas de Inspeccion</h2>
          </div>
          
          {{-- @if(false) --}}
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
            Filtrar
          </button>
          {{-- @endif --}}
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col" >#</th>
              <th scope="col" ># COT</th>
              <th scope="col" >VIN</th>
              <th scope="col" >F. CREACIÓN</th>
              <th scope="col" >MODELO</th>
              <th scope="col" >COLOR</th>
              <th scope="col" >AÑO MODELO</th>
            </tr>
            
          </thead>
          <tbody>
            @foreach ($listHojasInspeccion as $pdi)              
            <tr>
              <th scope="row">{{$loop->iteration}}</th>              
              <td>{{isset($pdi->id_recepcion_ot) ?$pdi->id_recepcion_ot: '-' }}</td>
              <td>{{$pdi->vin}}</td>
              <td>{{$pdi->fecha_registro}}</td>
              <td>{{$pdi->modelo}}</td>
              <td>{{$pdi->color}}</td>
                            
              <td>{{$pdi->ano_modelo}}</td>
              <td><a href="{{route('verHojaInspeccionVehiculo',['id_hoja_inspeccion'=>$pdi->id_hoja_inspeccion])}}"><button type="button" class="btn btn-warning"><i class="fas fa-info-circle icono-btn-tabla"></i>  </i></button></a></td>
              
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection