@extends('repuestos.repuestosCanvas')
@section('titulo','Repuestos - Solicitudes') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-4">Solicitudes de Repuestos - OTs</h2>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('repuestosOT')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">N° Documento</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3 px-sm-0">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3">
          <label for="filtroOT" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">OT</label>
          <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Órden de Trabajo">
        </div>
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-4 col-xl-3">
          <label for="filtroMarca" class="col-form-label col-6 col-sm-4 col-lg-4 col-xl-6">Marca</label>
          <select name="marca" id="filtroMarca" class="form-control col-6 col-lg-8 col-xl-6">
            <option value="all">Todos</option>
            @foreach ($listaMarcas as $marca)
              <option value="{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-4 col-xl-3">
          <label for="filtroEstado" class="col-form-label col-6">Estado</label>
          <select name="estado" id="filtroEstado" class="form-control col-6">
            <option value="all">Todos</option>
            <option value="entregado">ENTREGADO</option>
            <option value="en-solicitud">EN SOLICITUD</option>
            <option value="sin-atender">SIN ATENDER</option>            
          </select>
        </div>
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-4 col-xl-3">
          <label for="filtroSeccion" class="col-form-label col-6">Sección</label>
          <select name="seccion" id="filtroSeccion" class="form-control col-6">
            <option value="all">Todos</option>
            <option value="DYP">B&P</option>
            <option value="MEC">MEC</option>
          </select>
        </div>

        <div class="form-group row ml-1 mr-1 col-10 col-sm-6 pr-sm-0 pl-0">
          <label for="filtroFechaInicioSolicitud" class="col-form-label col-12 col-sm-4 col-lg-5">Fecha Solicitud</label>
          <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
            <input id="filtroFechaInicioSolicitud" name="fechaInicioSolicitud" type="text"  autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha Inicio">
            -
            <input id="filtroFechaFinSolicitud" name="fechaFinSolicitud" type="text"  autocomplete="off" class="fecha-fin form-control col-5" placeholder="Fecha Fin">
          </div>
        </div>
      </div>

      <div class="form-group row  col-12 ml-sm-0 col-sm-6 col-md-4 col-xl-3">
        <label for="filtroTipoOT" class="col-form-label col-6">Tipo OT</label>
        <select name="filtroTipoOT" id="filtroTipoOT" class="form-control col-6">
          <option value="">Todos</option>
          @foreach ($listaTiposOT as $item)
            <option value="{{$item->id_tipo_ot}}">{{$item->nombre_tipo_ot}}</option>
          @endforeach
          
        </select>
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

<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Solicitudes de Repuestos</h2>
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
              <th scope="col" ROWSPAN=2>#</th>
              <!-- <th scope="col">ESTADO</th> -->
              @if(false)<!--<th scope="col">F. APROBACIÓN</th> -->@endif
              <th scope="col" ROWSPAN=2>ESTADO</th>
              <th scope="col" ROWSPAN=2>SECCION</th>
              <th scope="col" ROWSPAN=2>PLACA</th>
              <th scope="col"ROWSPAN=2>OT</th>
              <th scope="col"ROWSPAN=2>TIPO OT</td>
              <th scope="col"ROWSPAN=2>FECHA SOLICITUD</td>
              <th scope="col"ROWSPAN=2>SIN CODIFICAR</td>
                <th scope="col" style="min-width: 350px"
                style="padding:0px">
                <div class="column">
                    <div><span class="head_th">DISPONIBILIDAD</span></div>
                    <div class="row gray align-items-center justify-content-center">
                        <span class="sub_th">EN STOCK</span>
                        <span class="sub_th">EN TRANSITO</span>
                        <span class="sub_th">EN IMPORTACION</span>
                    </div>
                </div>
              </th>
              <th scope="col"ROWSPAN=2>ENTREGADOS</td>
              @if(false)
              <th  ROWSPAN=2>MARCA</th>
              <th  ROWSPAN=2>MODELO</th>
              
              @endif
              @if(false)<!-- <th scope="col">SEGURO</th> -->@endif
              @if(false)
              <!-- <th scope="col">MONTO REPUESTOS</th> -->
              <!-- <th scope="col">F. PROMESA</th> -->
              @endif
              
              <th scope="col" ROWSPAN=2></th>
            </tr>
           
            
          </thead>
          <tbody>
            @foreach ($listaRecepcionesOTs as $hojaTrabajo)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              @if(false)
              <!-- <td><div class="cont-estado {{$recepcion_ot->claseEstado()}}">@if ($recepcion_ot->estadoActual()!=[]) {{$recepcion_ot->estadoActual()[0]->nombre_estado_reparacion}} @else - @endif</div></td> -->
              @endif
              @if(false)<!-- <td>{{$recepcion_ot->fechaAprobacion()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaAprobacion())->format('d/m/Y')}}</td> -->@endif
              @if(false)<td class="{{$recepcion_ot->estiloEsHotline()}}">{{$hojaTrabajo->getPlacaPartida()}}</td>@endif
              <td><div class="cont-estado @if($hojaTrabajo->necesidadesRepuestos->first()->getEstadoNecesidad() == 'EN SOLICITUD') bg-warning @elseif($hojaTrabajo->necesidadesRepuestos->first()->getEstadoNecesidad() == 'ENTREGADO') bg-success text-white @else bg-danger text-white @endif">{{$hojaTrabajo->necesidadesRepuestos->first()->getEstadoNecesidad()}}</div></td>
              <td>{{$hojaTrabajo->tipo_trabajo=='DYP' ? 'B&P' : 'MEC'}}</td>
              <td>{{$hojaTrabajo->getPlacaPartida()}}</td>
              <td>{!!$hojaTrabajo->recepcionOT->getLinkDetalleHTML()!!}</td>
              <td>{{$hojaTrabajo->recepcionOT->tipoOT->nombre_tipo_ot}}</td>  
              <td>{{$hojaTrabajo->necesidadesRepuestos->first()->fecha_registro}}</td>
             
              @if(false)
              <!-- <td>USD {{number_format($recepcion_ot->ultValuacion()->valor_repuestos,2)}}</td> -->
              <!-- <td>{{$recepcion_ot->fechaPromesa()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaPromesa())->format('d/m/Y')}}</td> -->
              @endif
              <td>{{$hojaTrabajo->necesidadesRepuestos->first()->getNumItemsSinCodigo()}}</td>
              <td>                                  
                <div class="row align-items-center justify-content-center">
                    <span class="sub_th">{{$hojaTrabajo->necesidadesRepuestos->first()->getNumItemsStock()}}</span>
                    <span class="sub_th">{{$hojaTrabajo->necesidadesRepuestos->first()->getNumItemsTransito()}}</span>
                    <span class="sub_th">{{$hojaTrabajo->necesidadesRepuestos->first()->getNumItemsImportacion()}}</span>
                </div>
              </td>
       
              <td>{{$hojaTrabajo->necesidadesRepuestos->first()->getNumItemsEntregados()}}</td>
              <td><a href="{{route('detalle_repuestos.index',['id_hoja_trabajo'=>$hojaTrabajo->id_hoja_trabajo])}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection