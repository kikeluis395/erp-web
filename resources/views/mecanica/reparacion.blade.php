@extends('mecanica.tableCanvas')
@section('titulo','Modulo de reparación - MECANICA') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-4">Reparaciones - Mecánica</h2>

    <div class="row justify-content-start mt-2">
      <div class="circ-semaforo-popover" style="background-color: green"></div><span class="semf-pop-info">0 - 2 días</span>
      <div class="circ-semaforo-popover ml-3" style="background-color: yellow"></div><span class="semf-pop-info">2 - 5 días</span>
      <div class="circ-semaforo-popover ml-3" style="background-color: red"></div><span class="semf-pop-info">&gt 5 días</span>
    </div>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('mecanica.reparacion.index')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3 px-sm-0">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-6 col-lg-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Número de placa" value="{{$placaFiltro}}" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroOT" class="col-form-label col-12 col-sm-6 col-lg-6">OT</label>
          <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Órden de Trabajo" value="{{$otFiltro}}">
        </div>
        <div class="form-group row ml-1 mr-1 col-12 col-sm-6 pr-sm-0 pl-0">
          <label for="filtroFechaInicioPromesa" class="col-form-label col-12 col-sm-4 col-lg-5">Fecha Promesa</label>
          <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
            <input id="filtroFechaInicioPromesa" name="fechaInicioPromesa" type="text"  autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha inicio promesa" value="{{$fechaInicioPromesaFiltro}}">
            -
            <input id="filtroFechaFinPromesa" name="fechaFinPromesa" type="text"  autocomplete="off" class="fecha-fin form-control col-5" placeholder="Fecha fin promesa" value="{{$fechaFinPromesaFiltro}}">
          </div>
        </div>
        
        <!-- <div class="form-group row ml-1 col-5 col-sm-3">
          
        </div> -->
      </div>
      <div class="row">
        <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
          <label for="filtroNroDoc" class="col-form-label col-6">DNI/RUC Cliente</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Número de cliente" value="">
        </div>
        <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3 px-lg-0">
          <label for="filtroEstado" class="col-form-label col-6 col-lg-5">Estado</label>
          <select id="filtroEstado" name="estado" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
            @foreach ($listaEstados as $estado)
              <option value="{{$estado->nombre_estado_reparacion_filtro}}">{{$estado->nombre_estado_reparacion_filtro}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
          <label for="filtroMarca" class="col-form-label col-6">Marca</label>
          <select name="marca" id="filtroMarca" class="form-control col-6 col-lg-6">
            <option value="all">Todos</option>
            @foreach ($listaMarcas as $marca)
              <option value="{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row justify-content-end ml-1 col-12 col-sm-6 col-lg-3">
          <label for="filtroSemaforo" class="col-form-label col-6">Semáforo</label>
          <select id="filtroSemaforo" name="filtroSemaforo" class="form-control col-6">
            <option value="all" selected>Todos</option>
            @foreach ($listaColores as $color)
            <option value="{{$color}}" style="background-color:{{$color}}">{{$color=='green'?'Verde':($color=='yellow'?'Amarillo':($color=='red'?'Rojo':''))}}</option>
            @endforeach
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
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Reparaciones</h2>
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
              <th scope="col">ESTADO</th>
              @if(false)<th scope="col">TIPO DAÑO</th>@endif
              <th scope="col">PLACA</th>
              @if(false)<!-- <th scope="col">F. RECEPCIÓN</th> -->@endif
              @if(false)<!-- <th scope="col">F. FINAL</th> -->@endif
              <th scope="col">OT</th>
              @if(false)<th scope="col">F. APROBACIÓN</th>@endif
              <th scope="col">F. PROMESA</th>
              <th scope="col">TECNICO ASIGNADO</th>
              <th scope="col">DATOS CASO</th>
              <th scope="col">INICIO OPERATIVO</th>
              <th scope="col">REPROGRAMACIÓN</th>
              @if(false)<th scope="col">INSPECCION</th>@endif
              <th scope="col">C.C</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRecepcionesOTs as $recepcion_ot)
            <tr>
              <th scope="row"><div class="circulo-semaforo">{{$loop->iteration}}</div></th>
              @if(false)<th scope="row"><div class="circulo-semaforo" style="background-color: {{$recepcion_ot->colorSemaforo()}}">{{$loop->iteration}}</div></th>@endif
              <td><div class="cont-estado {{$recepcion_ot->claseEstado()}}">@if ($recepcion_ot->estadoActual()!=[]) {{$recepcion_ot->estadoActual()[0]->nombre_estado_reparacion}} @else - @endif</div></td>
              @if(false)<td><div class="{{$recepcion_ot->claseCSSTipoDanhoTemp()}}">{{$recepcion_ot->tipoDanhoTemp()}}</div></td>@endif
              @if(false)<td class="{{$recepcion_ot->estiloEsHotline()}}">{{substr($recepcion_ot->hojaTrabajo->placa_auto,0,3).'-'.substr($recepcion_ot->hojaTrabajo->placa_auto,3,3)}}</td>@endif
              <td>{{substr($recepcion_ot->hojaTrabajo->placa_auto,0,3).'-'.substr($recepcion_ot->hojaTrabajo->placa_auto,3,3)}}</td>
              @if(false)<!-- <td>{{\Carbon\Carbon::parse($recepcion_ot->hojaTrabajo->fecha_recepcion)->format('d/m/Y')}}</td> -->@endif
              @if(false)<!-- aún no se si es el primero o el último <td>{{$recepcion_ot->fechaPromesa()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->primeraFechaPromesa())->format('d/m/Y')}}</td>-->@endif
              <td>{!!$recepcion_ot->getLinkDetalleHTML()!!}</td>
              @if(false)<td>{{$recepcion_ot->fechaAprobacion()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaAprobacion())->format('d/m/Y')}}</td>@endif
              <td>{{$recepcion_ot->fechaPromesa()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaPromesa())->format('d/m/Y')}}</td>
              <td>{{$recepcion_ot->getNombreTecnicoAsignado()}}</td>
              <td>
                <button type="button" class="btn btn-info btn-tabla" data-toggle="modal" data-target="#verDatosCliente-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-info-circle icono-btn-tabla"></i></button>
                  <!-- Modal -->
                  <div class="modal fade" id="verDatosCliente-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header fondo-sigma">
                          <h5 class="modal-title">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                          <form>
                            <fieldset>

                              @if(false)
                              <div class="form-group form-inline">
                                <label for="PlacaEdit" class="col-sm-6 justify-content-end">Placa: </label>
                                <input type="text" class="form-control col-sm-6" id="PlacaEdit" value="{{$recepcion_ot->hojaTrabajo->placa_auto}}" disabled>
                                <div id="errorPlacaEdit-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                              </div>
                              @endif

                              @if(false)
                              <div class="form-group form-inline">
                                <label for="PlacaEdit" class="col-sm-6 justify-content-end">Servicio Terceros: </label>
                                <input type="text" class="form-control col-sm-6" id="PlacaEdit" value="{{$recepcion_ot->ultValuacion()->valor_terceros ? $recepcion_ot->ultValuacion()->valor_terceros : '-'}}" disabled>
                                <div id="errorPlacaEdit-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                              </div>
                              @endif

                              <div class="form-group form-inline">
                                <label for="nroDocInfo" class="col-sm-6 justify-content-end">DNI/RUC Cliente: </label>
                                <input type="text" class="form-control col-sm-6" id="nroDocInfo" value="{{$recepcion_ot->hojaTrabajo->getNumDocCliente()}}" disabled>
                              </div>

                              <div class="form-group form-inline">
                                <label for="nroDocInfo" class="col-sm-6 justify-content-end">Nombre Cliente: </label>
                                <input type="text" class="form-control col-sm-6" id="nroDocInfo" value="{{$recepcion_ot->hojaTrabajo->getNombreCliente()}}" disabled>
                              </div>
                              
                              <div class="form-group form-inline">
                                <label for="marcaAuto" class="col-sm-6 justify-content-end">Marca:</label>
                                <select id="marcaAuto" class="form-control col-sm-6" disabled>
                                  <option>{{$recepcion_ot->hojaTrabajo->vehiculo->getNombreMarca()}}</option>
                                </select>
                              </div>

                              <div class="form-group form-inline">
                                <label for="modeloInfo" class="col-sm-6 justify-content-end">Modelo: </label>
                                <input type="text" class="form-control col-sm-6" id="modeloInfo" value="{{$recepcion_ot->hojaTrabajo->getModeloVehiculo()}}" disabled>
                              </div>

                              <div class="form-group form-inline">
                                <label for="fechaRecepcionInfo" class="col-sm-6 justify-content-end">F. Recepción: </label>
                                <input type="text" class="form-control col-sm-6" id="fechaRecepcionInfo" value="{{$recepcion_ot->hojaTrabajo->getFechaRecepcionFormat('d/m/Y H:i')}}" disabled>
                              </div>

                              @if(false)
                              <div class="form-group form-inline">
                                <label for="fechaRecepcionInfo" class="col-sm-6 justify-content-end">Suma Horas: </label>
                                <input type="text" class="form-control col-sm-6" id="fechaRecepcionInfo" value="{{$recepcion_ot->sumaHorasValuacion()}}" disabled>
                              </div>
                              @endif

                              <div class="form-group form-inline">
                                <label for="fechaRecepcionInfo" class="col-sm-6 justify-content-end">Mano de obra: </label>
                                <div class="col-sm-6">
                                  <ul style="text-align: left; padding-left:0">
                                  @foreach($recepcion_ot->hojaTrabajo->detallesTrabajo as $detalleTrabajo)
                                  <li>{{$detalleTrabajo->getNombreDetalleTrabajo()}}</li>
                                  @endforeach
                                  </ul>
                                </div>
                              </div>

                            </fieldset>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </td>

              <td>
                @if(!$recepcion_ot->id_tecnico_asignado)
                <button type="button" class="btn btn-warning btn-tabla" data-toggle="modal" data-target="#confirmarInicioModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="confirmarInicioModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="confirmarInicioOperativo-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title" id="confirmarInicioOperativo-{{$recepcion_ot->id_recepcion_ot}}">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormInicioOperativo-{{$recepcion_ot->id_recepcion_ot}}" method="POST" action="{{route('mecanica.reparacion.store')}}" value="Submit" autocomplete="off">
                          @csrf
                          <input type="hidden" name="tipoSubmit" value="inicioOperativo">
                          <input type="hidden" name="idRecepcionOT" value="{{$recepcion_ot->id_recepcion_ot}}">
                          <div class="form-group form-inline">
                            <label for="fechaPromesaIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha Promesa: </label>
                            <input name="fechaPromesaReparacion" min-date="{{\Carbon\Carbon::now()->format('d/m/Y')}}" type="text"  autocomplete="off" class="datepicker form-control col-6 col-sm-3" id="fechaPromesaIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaPromesa-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10">
                            <input name="horaPromesaReparacion" type="time" class="form-control col-6 col-sm-3" id="horaPromesaIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="required" data-validation-format="HH:mm" data-validation-length="5" data-validation-error-msg="Debe ingresar la hora" data-validation-error-msg-container="#errorFechaPromesa-{{$recepcion_ot->id_recepcion_ot}}">
                            <div id="errorFechaPromesa-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="empleadoMecIn_{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Técnico Mecánico: </label>
                            <select name="empleadoMec" class="col-sm-6 justify-content-end form-control" id="empleadoMecIn_{{$recepcion_ot->id_recepcion_ot}}">
                              <option value=""></option>
                              @foreach ($listaTecnicos as $empleado)
                              <option value="{{$empleado->id_tecnico}}">{{$empleado->nombre_tecnico}}</option>
                              @endforeach
                            </select>
                            <div id="errorEmpleadoMec-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnSubmit-{{$recepcion_ot->id_recepcion_ot}}" form="FormInicioOperativo-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @else
                <button type="button" class="btn btn-warning btn-tabla" disabled><i class="fas fa-edit icono-btn-tabla"></i></button>
                @endif
              </td>

              <td>
                @if($recepcion_ot->ultReparacion() && $recepcion_ot->ultReparacion()->ultFechaPromesa() && !$recepcion_ot->ultReparacion()->esTerminado())
                <button type="button" class="btn btn-warning btn-tabla" data-toggle="modal" data-target="#ampliacionModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="ampliacionModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="ampliacion-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormAmpliacion-{{$recepcion_ot->id_recepcion_ot}}" method="POST" action="{{route('mecanica.reparacion.store')}}" value="Submit" autocomplete="off">
                          @csrf
                          <input type="hidden" name="tipoSubmit" value="ampliacion">
                          <input type="hidden" name="idRecepcionOT" value="{{$recepcion_ot->id_recepcion_ot}}">
                          @if(false)
                          <div class="form-group form-inline">
                            <label for="fechaAmpliacionIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha ampliación: </label>
                            <input name="fechaAmpliacion" min-date="{{date('d/m/Y')}}" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaAmpliacionIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaAmpliacion-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10">
                            <div id="errorFechaAmpliacion-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                          </div>
                          @endif
                          <div class="form-group form-inline">
                            <label for="fechaReprogramacionIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha de reprogramación: </label>
                            <input name="fechaReprogramacion" min-date="{{$recepcion_ot->fechaInicioOperativoFormato()}}" type="text"  autocomplete="off" class="datepicker form-control col-6 col-sm-3" id="fechaReprogramacionIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaReprogramacion-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10">
                            <input name="horaReprogramacion" type="time" class="form-control col-6 col-sm-3" id="horaReprogramacionIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="required" data-validation-format="HH:mm" data-validation-length="5" data-validation-error-msg="Debe ingresar la hora" data-validation-error-msg-container="#errorFechaReprogramacion-{{$recepcion_ot->id_recepcion_ot}}">
                            <div id="errorFechaReprogramacion-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="razonIn" class="col-sm-6 justify-content-end">Razón: </label>
                            <select name="razon" id="razonIn" class="form-control col-sm-6">
                              <!-- <option value="ampliacion">AMPLIACIÓN</option> -->
                              <option value="falta_repuestos">ESPERA REPUESTOS</option>
                              <option value="priorizacion">PRIORIZAR OTRA OT</option>
                              <option value="rechazo_cliente">RECHAZO CLIENTE</option>
                              <option value="otros">OTROS</option>
                            </select>
                          </div>

                          <div class="form-group form-inline">
                            <label for="explicacionIn" class="col-sm-6 justify-content-end">Explicación: </label>
                            <textarea name="explicacion" type="text" class="form-control col-sm-6" id="explicacionIn" placeholder="Ingrese el motivo" maxlength="255" rows="5"></textarea> 
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnConfirmarAmpliacion-{{$recepcion_ot->id_recepcion_ot}}" form="FormAmpliacion-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @else
                <button type="button" class="btn btn-warning btn-tabla" disabled><i class="fas fa-edit icono-btn-tabla"></i></button>
                @endif
              </td>

              @if(false)
              <td>
                @if($recepcion_ot->tieneInspeccion())
                <a href="{{route('hojaInspeccion',['nro_ot'=>$recepcion_ot->id_recepcion_ot])}}"><button type="button" class="btn btn-success btn-tabla"><i class="fas fa-search icono-btn-tabla"></i></button></a>
                @else
                <button type="button" class="btn btn-danger btn-tabla" disabled><i class="fas fa-search icono-btn-tabla"></i></button>
                @endif
              </td>
              @endif

              <td>
                @if($recepcion_ot->esEsperaControlCalidad())
                <button type="button" class="btn btn-warning btn-tabla" data-toggle="modal" data-target="#confirmarTerminoModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="confirmarTerminoModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="confirmarTerminoOperativo-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title" id="confirmarTerminoOperativo-{{$recepcion_ot->id_recepcion_ot}}">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormTerminoOperativo-{{$recepcion_ot->id_recepcion_ot}}" method="POST" action="{{route('mecanica.reparacion.store')}}" value="Submit" autocomplete="off">
                          @csrf
                          <input type="hidden" name="tipoSubmit" value="terminoOperativo">
                          <input type="hidden" name="idRecepcionOT" value="{{$recepcion_ot->id_recepcion_ot}}">
                          <div class="form-group form-inline">
                            <label for="fechaTerminoIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha de Conformidad: </label>
                            @if(false)<input name="fechaTerminoOperativo" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaTerminoIn-{{$recepcion_ot->id_recepcion_ot}}" min-date="{{$recepcion_ot->minFechaCC()}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaTermino-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10" value="{{$recepcion_ot->minFechaCC()}}">@endif
                            <input name="fechaTerminoOperativo" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaTerminoIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaTermino-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10">
                            <div id="errorFechaTermino-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnSubmit-{{$recepcion_ot->id_recepcion_ot}}" form="FormTerminoOperativo-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @else
                <button type="button" class="btn btn-warning btn-tabla" disabled><i class="fas fa-edit icono-btn-tabla"></i></button>
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

@section('extra-scripts')
  @parent
  <script src="{{asset('js/reparacion.js')}}"></script>
@endsection