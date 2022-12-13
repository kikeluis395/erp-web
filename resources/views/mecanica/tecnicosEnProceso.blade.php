@extends('mecanica.tableCanvas')
@section('titulo','Modulo Técnicos - MECANICA') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-0">Técnicos - Mecánica</h2>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarTecnicosEnProceso" class="my-3" method="GET" action="{{route('mecanica.tecnicos.index')}}" value="search">
      <div class="row">
        @if(false)
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        @endif
        <div class="form-group row ml-1 col-6 col-md-3">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-4 col-lg-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-3">
          <label for="filtroOT" class="col-form-label col-12 col-sm-6 col-lg-6">OT</label>
          <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Órden de Trabajo">
        </div>
        <div class="form-group row ml-1 col-12 col-md-3">
          <label for="filtroTecnico" class="col-form-label col-12 col-sm-6 col-lg-5">Técnico asignado</label>
          <select name="tecnico" id="filtroTecnico" class="form-control col-12 col-sm-6 col-lg-7">
            <option value="all">Todos</option>
            @foreach($listaTecnicos as $tecnico)
            <option value="{{$tecnico->id_tecnico}}">{{$tecnico->nombre_tecnico}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 col-sm-3">
          <label for="filtroSemaforo" class="col-form-label col-6 col-sm-6 col-lg-8">Semáforo</label>
          <select id="filtroSemaforo" name="filtroSemaforo" class="form-control col-6 col-sm-6 col-lg-4">
            <option value="all" selected>Todos</option>
            @foreach ($listaColores as $color)
              <option value="{{$color}}" style="background-color:{{$color}}">{{$color=='green'?'Verde':($color=='yellow'?'Amarillo':($color=='red'?'Rojo':''))}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group row ml-1 mr-1 col-12 col-sm-6 pr-sm-0 pl-0">
          <label for="filtroFechaInicioAsignacion" class="col-form-label col-12 col-sm-4 col-lg-5">Fecha Asignación</label>
          <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
            <input id="filtroFechaInicioAsignacion" name="fechaInicioAsignacion" type="text"  autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha inicio asignación" value="">
            -
            <input id="filtroFechaFinAsignacion" name="fechaFinAsignacion" type="text"  autocomplete="off" class="fecha-fin form-control col-5" placeholder="Fecha fin asignación" value="">
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
  <div class="table-responsive borde-tabla mt-4 tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Seguimiento Técnicos Mecánica</h2>
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
              <th scope="col">PLACA</th>
              <th scope="col">OT</th>
              <th scope="col">TIPO OT</th>
              <th scope="col">TRABAJOS</th>
              <th scope="col">TÉCNICO</th>
              <th scope="col">F. ASIGNACION</th>
              <th scope="col">F. PROMESA</th>
              <th scope="col">MEC</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRecepcionesOTs as $recepcion_ot)
            <tr>
              <th scope="row"><div class="circulo-semaforo" style="background-color: {{$recepcion_ot->colorSemaforoTecnicos()}}">{{$loop->iteration}}</div></th>
              <td class="{{$recepcion_ot->estiloEsHotline()}}">{{substr($recepcion_ot->hojaTrabajo->placa_auto,0,3).'-'.substr($recepcion_ot->hojaTrabajo->placa_auto,3,3)}}</td>
              <td>{!!$recepcion_ot->getLinkDetalleHTML()!!}</td>
              <td>{{$recepcion_ot->tipoOT->nombre_tipo_ot}}</td>
              <td>
                <button type="button" class="btn btn-info btn-tabla" data-toggle="modal" data-target="#verTrabajos-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-info-circle icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="verTrabajos-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header fondo-sigma">
                          <h5 class="modal-title">{{$recepcion_ot->hojaTrabajo->placa_auto}} - {{$recepcion_ot->getNroOT()}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                          <ul>
                            @foreach($recepcion_ot->hojaTrabajo->detallesTrabajo as $detalleTrabajo)
                              <li style="text-align: left">{{$detalleTrabajo->getNombreDetalleTrabajo()}}</li>
                            @endforeach
                          </ul>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                </div>
              </td>
              <td>{{$recepcion_ot->getNombreTecnicoAsignado()}}</td>
              <td>@if($recepcion_ot->ultReparacion()->fecha_inicio_operativo){{\Carbon\Carbon::parse($recepcion_ot->ultReparacion()->fecha_inicio_operativo)->format('d/m/Y')}}@endif</td>
              @if(false)<td><div class="{{$recepcion_ot->claseCSSTipoDanhoTemp()}}">{{$recepcion_ot->tipoDanhoTemp()}}</div></td>@endif

              <td>{{$recepcion_ot->fechaPromesa()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaPromesa())->format('d/m/Y')}}</td>

              <td>
                @if( false && !$recepcion_ot->detallesEnProceso()->get()->pluck('etapa_proceso')->contains("mecanica") )
                @elseif( false && $recepcion_ot->detallesEnProceso()->get()->pluck('etapa_proceso')->contains("mecanica") 
                    && !$recepcion_ot->detallesEnProceso()->get()->where('etapa_proceso','mecanica')->first()->es_etapa_finalizada)
                @elseif( false && $recepcion_ot->detallesEnProceso()->get()->where('etapa_proceso','mecanica')->first()->es_etapa_finalizada)
                @endif

                @if($recepcion_ot->detalleEnProcesoDisponible("mecanica"))
                <button type="button" class="btn btn-danger btn-tabla" data-toggle="modal" data-target="#confirmarInicioMecanicaModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-wrench icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="confirmarInicioMecanicaModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="confirmarInicioMecanica-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormIniciarMecanica-{{$recepcion_ot->id_recepcion_ot}}" method="POST" action="{{route('mecanica.tecnicos.store')}}" value="Submit">
                          @csrf
                          <input type="hidden" name="id_recepcion_ot" value="{{$recepcion_ot->id_recepcion_ot}}">
                          <input type="hidden" name="nombre_etapa" value="mecanica">
                        </form>
                        {{$recepcion_ot->preguntaInicioTecnico("MECÁNICA")}}
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnInicioMecanicaSubmit-{{$recepcion_ot->id_recepcion_ot}}" form="FormIniciarMecanica-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary" >Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @elseif($recepcion_ot->detalleEnProcesoEsActual("mecanica"))
                <button type="button" class="btn btn-warning btn-tabla" data-toggle="modal" data-target="#confirmarTerminoMecanicaModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-wrench icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="confirmarTerminoMecanicaModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="confirmarTerminoMecanica-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormTerminarMecanica-{{$recepcion_ot->id_recepcion_ot}}" method="POST" action="{{route('mecanica.tecnicos.store')}}" value="Submit">
                          @csrf
                          <input type="hidden" name="id_recepcion_ot" value="{{$recepcion_ot->id_recepcion_ot}}">
                          <input type="hidden" name="nombre_etapa" value="mecanica">
                        </form>
                        {{$recepcion_ot->preguntaFinTecnico("MECÁNICA")}}
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnTerminoMecanicaSubmit-{{$recepcion_ot->id_recepcion_ot}}" form="FormTerminarMecanica-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary" >Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @elseif($recepcion_ot->detalleEnProcesoEsFinalizado("mecanica"))
                <button type="button" class="btn btn-success btn-tabla" disabled><i class="fas fa-wrench icono-btn-tabla"></i></button>
                @elseif($recepcion_ot->detalleEnProcesoEsBloqueado("mecanica"))
                <button type="button" class="btn btn-danger btn-tabla" disabled><i class="fas fa-wrench icono-btn-tabla"></i></button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection