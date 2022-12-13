@extends('repuestos.repuestosCanvas')
@section('titulo','Repuestos - Solicitudes') 

@section('pretable-content')

<style>
  .head_th {
      font-size: 12px;
  }
  .sub_th {
      font-size: 14px;
      font-weight: 100;
  }
  .sub_norm,
  .sub_th {
      margin: 0px 15px;
      text-align: center;
      width: 80px;
      font-weight: 700;
  }
  .gray,
  .white {
      padding: 5px 0px;
      display: flex;
      place-content: center;
  }
  .gray {
      color: white;
      background-color: rgb(146, 146, 146);
  }
</style>

<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-4">Solicitudes de Repuestos - Cotizaciones</h2>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('repuestosCot')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroSeccion" class="col-form-label col-12 col-sm-6">Sección</label>
          <select name="seccion" id="filtroSeccion" class="form-control col-sm-6">
            <option value="all">TODOS</option>
            <option value="DYP" {{ isset(request()->seccion) && request()->seccion == 'DYP' ? 'selected' : null }}>
              B&P</option>
            <option value="MEC" {{ isset(request()->seccion) && request()->seccion == 'MEC' ? 'selected' : null }}>
              MEC</option>
          </select>
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">N° Documento</label>
          <input id="filtroNroDoc" name="nroDoc" value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3 px-sm-0">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" value="{{ isset(request()->nroPlaca) ? request()->nroPlaca : '' }}" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3">
          <label for="filtroCotizacion" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">Cotización</label>
          <input id="filtroCotizacion" name="nroCotizacion" value="{{ isset(request()->nroCotizacion) ? request()->nroCotizacion : '' }}" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="# Cotización">
        </div>
      
      <div class="form-group row ml-1 col-6 col-sm-3">
        <label for="filtroEstado" class="col-form-label col-6">Estado</label>
        <select name="estado" id="filtroEstado" class="form-control col-6">
          <option value="">Todos</option>
          <option value="CODIFICADOS">CODIFICADOS</option>
          <option value="SIN CODIFICAR">SIN CODIFICAR</option>      
        </select>
      </div>

      <div class="form-group row ml-1 col-5">
        <label for="filtroFechaInicioSolicitud" class="col-form-label col-12 col-sm-4 col-lg-3">Fecha Solicitud</label>
        <div class="row col-12 col-sm-8 col-lg-9 pl-0 justify-content-end">
          <input id="filtroFechaInicioSolicitud" name="fechaInicioSolicitud" type="text"  autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha Inicio">
          -
          <input id="filtroFechaFinSolicitud" name="fechaFinSolicitud" type="text"  autocomplete="off" class="fecha-fin form-control col-5" placeholder="Fecha Fin">
        </div>
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
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div class="form-inline row">
            <h2>Solicitudes de Repuestos</h2>
            <button class="btn btn-primary mr-4" type="button" data-toggle="collapse" data-target="#busquedaCollapsable"
              aria-expanded="false" aria-controls="busquedaCollapsable">
              Filtrar
            </button>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">ESTADO</th>
              <th scope="col">SECCION</th>
              <th scope="col">COTIZACIÓN</th>
              <th scope="col">F. SOLICITUD</th>
              <th scope="col">PLACA</th>
              
              <th scope="col">MODELO TÉCNICO</th>
              <th scope="col">SIN CODIFICAR</th>
              <th scope="col" style="min-width: 350px"
                            style="padding:0px">
                            <div class="column">
                                <div><span class="head_th">CODIFICADOS</span></div>
                                <div class="row gray align-items-center justify-content-center">
                                    <span class="sub_th">EN STOCK</span>
                                    <span class="sub_th">EN TRANSITO</span>
                                    <span class="sub_th">EN IMPORTACION</span>
                                </div>
                            </div>
              </th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRecepcionesOTs as $hojaTrabajo)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>              <div class="cont-estado @if($hojaTrabajo->necesidadesRepuestos()->first()->estadoParaUnaCotizacion() == 'SIN CODIFICAR') bg-warning @else bg-success text-white @endif">{{$hojaTrabajo->necesidadesRepuestos()->first()->estadoParaUnaCotizacion()}}</div>
              </td>

              <td>{{$hojaTrabajo->tipo_trabajo=='DYP' ? 'B&P' : 'MEC'}}</td>
              <td>{!!$hojaTrabajo->getLinkDetalleHTML()!!}</td>
              <td>{{$hojaTrabajo->necesidadesRepuestos()->first()->fecha_registro }}</td>
              <td>{{$hojaTrabajo->getPlacaPartida()}}</td>
              
              <td>{{$hojaTrabajo->vehiculo->getNombreModeloTecnico()}}</td>
              <td>{{$hojaTrabajo->necesidadesRepuestos()->first()->getNumItemsSinCodigo() }}</td>
             
              <td>                                  
                  <div class="row align-items-center justify-content-center">
                      <span class="sub_th">{{$hojaTrabajo->nroRepuestosEnStock()}}</span>
                      <span class="sub_th">{{$hojaTrabajo->nroRepuestosEnImportacion()}}</span>
                      <span class="sub_th">{{$hojaTrabajo->nroRepuestosEnTransito()}}</span>
                  </div>
              </td>
        
              <td><a href="{{route('detalle_repuestos.index',['id_hoja_trabajo'=>$hojaTrabajo->id_hoja_trabajo])}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a></td>
              {{-- <td>@include('modals.modalCerrarCotizacion')</td> --}}

            
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection