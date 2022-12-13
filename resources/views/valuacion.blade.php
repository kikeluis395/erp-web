@extends('tableCanvas')
@section('titulo','Modulo de valuación - B&P') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-4">Valuaciones de OTs</h2>

    <div class="row justify-content-start mt-2">
      <div class="circ-semaforo-popover" style="background-color: green"></div><span class="semf-pop-info">0 - 2 días</span>
      <div class="circ-semaforo-popover ml-3" style="background-color: yellow"></div><span class="semf-pop-info">2 - 5 días</span>
      <div class="circ-semaforo-popover ml-3" style="background-color: red"></div><span class="semf-pop-info">&gt 5 días</span>
    </div>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('valuacion.index')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-4 col-lg-3">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6 col-lg-9" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroOT" class="col-form-label col-12 col-sm-4 col-lg-2">OT</label>
          <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-8 col-lg-10" placeholder="Órden de Trabajo">
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
        <div class="form-group row ml-1 col-12 col-sm-3 pr-sm-0">
          <label for="filtroEstancia" class="col-form-label col-6 col-sm-6 col-lg-8">DÍAS ESTANCIA</label>
          <select id="filtroEstancia" name="filtroEstancia" class="form-control col-6 col-sm-6 col-lg-4">
            <option value="all" selected>Todos</option>
            @foreach ($listaEstancia as $estancia)
              <option value="{{$loop->iteration-1}}">{{$estancia}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 col-md">
          <label for="filtroEstado" class="col-form-label col-6 col-sm-3 col-lg-5">Estado</label>
          <select id="filtroEstado" name="estado" class="form-control col-6 col-sm-9 col-lg-7">
            <option value="all">Todos</option>
            @foreach ($listaEstados as $estado)
              <option value="{{$estado->nombre_estado_reparacion_filtro}}">{{$estado->nombre_estado_reparacion_filtro}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 col-sm-6 col-md">
          <label for="filtroMarca" class="col-form-label col-6 col-lg-5">Marca</label>
          <select name="marca" id="filtroMarca" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
            @foreach ($listaMarcas as $marca)
              <option value="{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 col-sm-6 col-md mr-0">
          <label for="filtroSeguro" class="col-form-label col-6 col-lg-5">Seguro</label>
          <select name="seguro" id="filtroSeguro" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
            @foreach ($listaSeguros as $seguro)
              <option value="{{$seguro->id_cia_seguro}}">{{$seguro->nombre_cia_seguro}}</option>
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
            <h2>Valuaciones</h2>
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
              <th scope="col">F. INGRESO</th>
              <th scope="col">DÍAS ESTANCIA</th>
              <th scope="col">PLACA</th>
              <th scope="col">OT</th>
              <th scope="col">MARCA</th>
              <th scope="col">MODELO</th>
              <th scope="col">SEGURO</th>
              <!-- <th scope="col">VALOR VENTA</th> -->
              <!-- <th scope="col">Fecha Promesa</th> -->
              <th scope="col">F. VALUACIÓN</th>
              <th scope="col">DATOS CLIENTE</th>
              <th scope="col">EDITAR</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRecepcionesOTs as $recepcion_ot)
            <tr>
              <th scope="row"><div class="circulo-semaforo" style="background-color: {{$recepcion_ot->colorSemaforo()}}">{{$loop->iteration}}</div></th>
              <td><div class="cont-estado {{$recepcion_ot->claseEstado()}}">@if ($recepcion_ot->estadoActual()!=[]) {{$recepcion_ot->estadoActual()[0]->nombre_estado_reparacion}} @else - @endif</div></td>
              <td>{{$recepcion_ot->hojaTrabajo->getFechaRecepcionFormat()}}</td>
              <td>{{$recepcion_ot->tiempoEstancia()}}</td>
              <td class="{{$recepcion_ot->estiloEsHotline()}}">{{substr($recepcion_ot->hojaTrabajo->placa_auto,0,3).'-'.substr($recepcion_ot->hojaTrabajo->placa_auto,3,3)}}</td>
              <td>{!!$recepcion_ot->getLinkDetalleHTML()!!}</td>
              <td>{{$recepcion_ot->hojaTrabajo->vehiculo->getNombreMarca()}}</td>
              <td>{{substr($recepcion_ot->hojaTrabajo->getModeloVehiculo(),0,10)}}</td>
              <td>{{$recepcion_ot->ciaSeguro ? $recepcion_ot->getNombreCiaSeguro() : '---'}}</td>
  
              @if(false)<!-- <td>@if($recepcion_ot->montoTotal()!='-')USD {{number_format($recepcion_ot->montoTotal(),2)}}@else - @endif</td> -->
              <!-- <td>{{$recepcion_ot->fechaPromesa()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaPromesa())->format('d/m/Y')}}</td> -->@endif
  
              <td>{{$recepcion_ot->fechaValuacion()=='-'? '-' :\Carbon\Carbon::parse($recepcion_ot->fechaValuacion())->format('d/m/Y')}}</td>
  
  
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
                              <div class="form-group form-inline">
                                <label for="tipoOTIn" class="col-sm-6 justify-content-end">Tipo de OT:</label>
                                <select id="tipoOTIn" class="form-control col-sm-6" disabled>
                                  <option>{{$recepcion_ot->getNombreTipoOT()}}</option>
                                </select>
                              </div>
                              <!--  -->

                              <div class="form-group form-inline">
                                <label for="ciaSeguroIn" class="col-sm-6 justify-content-end">Compañía de seguros:</label>
                                <select name="seguro" id="ciaSeguroIn" class="form-control col-sm-6" disabled>
                                  <option>{{$recepcion_ot->ciaSeguro ? $recepcion_ot->getNombreCiaSeguro() : '---'}}</option>
                                </select>
                              </div>

                              <div class="form-group form-inline">
                                <label for="clienteEdit" class="col-sm-6 justify-content-end">Cliente:</label>
                                <input type="text" class="form-control col-sm-6" id="clienteEdit" maxlength="45" value="{{$recepcion_ot->hojaTrabajo->getNombreCliente()}}" disabled>
                              </div>

                              <div class="form-group form-inline">
                                <label for="telefono" class="col-sm-6 justify-content-end">Teléfono:</label>
                                <input type="text" class="form-control col-sm-6" id="telefonoEdit" value="{{$recepcion_ot->hojaTrabajo->getTelefonoCliente()}}" maxlength="45" disabled>
                              </div>
                              <div class="form-group form-inline">
                                <label for="emailEdit" class="col-sm-6 justify-content-end">Email:</label>
                                <input type="text" class="form-control col-sm-6" id="emailEdit" maxlength="45" value="{{$recepcion_ot->hojaTrabajo->getCorreoCliente()}}" disabled>
                              </div>
                              <div class="form-group form-inline">
                                <label for="observacionesIn" class="col-sm-6 justify-content-end">Observaciones</label>
                                <textarea name="observaciones" type="text" class="form-control col-sm-6" id="observacionesIn" maxlength="255" rows="5" value="{{$recepcion_ot->hojaTrabajo->observaciones}}" disabled></textarea> 
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
                <button type="button" class="btn btn-warning btn-tabla" data-toggle="modal" data-target="#editarValuacionModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
                  <!-- Modal -->
                  <div class="modal fade" id="editarValuacionModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="editarValuacionLabel-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header fondo-sigma">
                          <h5 class="modal-title" id="editarValuacionLabel-{{$recepcion_ot->id_recepcion_ot}}">{{$recepcion_ot->hojaTrabajo->placa_auto}} - OT: {{$recepcion_ot->getNroOT()}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                          <form id="FormEditarValuacion-{{$recepcion_ot->id_recepcion_ot}}" method="POST" 
                          action="{{route('valuacion.store')}}"
                          value="Submit" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id_recepcion_ot" value="{{$recepcion_ot->id_recepcion_ot}}">
                            @if(true)
                            <!-- fieldset 1 -->
                            <fieldset id="seccionForm-{{$recepcion_ot->id_recepcion_ot}}" @if($recepcion_ot->ultValuacion() && $recepcion_ot->ultValuacion()->es_perdida_total) disabled @endif>
                              @if(!$recepcion_ot->esAmpliacion())
                                @if(!$recepcion_ot->ultValuacion() || ($recepcion_ot->ultValuacion() && !$recepcion_ot->ultValuacion()->fecha_valuacion))
                                  <div id="containerCotizaciones-{{$recepcion_ot->id_recepcion_ot}}" class="mb-2">
                                    <div class="form-group form-inline mb-0">
                                      <label for="cotizacionIn-{{$recepcion_ot->id_recepcion_ot}}-1" class="col-sm-6 justify-content-end"> <a id="eliminarLineaCotizacion-{{$recepcion_ot->id_recepcion_ot}}-1" class=" d-none" href="#">&times;&nbsp;&nbsp;</a> Cotización:</label>
                                      <select name="cotizacion-1" id="cotizacionIn-{{$recepcion_ot->id_recepcion_ot}}-1" class="form-control col-sm-6">
                                        <option value=""></option>
                                        @foreach($recepcion_ot->cotizacionesAsociables() as $cotizacion)
                                        <option value="{{$cotizacion->id_cotizacion}}">COTIZACION N° {{$cotizacion->id_cotizacion}}</option>
                                        @endforeach
                                      </select>
                                    </div>

                                    <div class="justify-content-end text-right" id="containerAddCotizacion-{{$recepcion_ot->id_recepcion_ot}}">
                                      <a id="btnAgregarCotizacion-{{$recepcion_ot->id_recepcion_ot}}" href="#" style="color: #007bff; text-decoration: none; background-color: transparent; font-weight: initial">Agregar cotización</a>
                                    </div>
                                  </div>

                                  <div class="form-group form-inline">
                                    <label for="fechaValuacionIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha fin de valuación: </label>
                                    <input name="fechaValuacion" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" min-date="{{$recepcion_ot->fechaRecepcionFormato()}}" id="fechaValuacionIn-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaValuacion-{{$recepcion_ot->id_recepcion_ot}}" maxlength="10" autocomplete="off">
                                    <div id="errorFechaValuacion-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                  </div>
                                 @else
                                  <!-- fieldset 1.1 -->
                                  <fieldset disabled="true">
                                  @if($recepcion_ot->ultValuacion()->es_perdida_total)
                                  <div style="color: red;">
                                    VEHÍCULO EN PÉRDIDA
                                  </div>
                                  @endif

                                  <div class="form-group form-inline">
                                    <label for="fechaRecepcionInfo" class="col-sm-6 justify-content-end">Cotizaciones: </label>
                                    <div class="col-sm-6">
                                      @if($recepcion_ot->ultValuacion()->cotizacionesPreAsociadas->count() > 0)
                                      <ul style="text-align: left; padding-left:0">
                                      @foreach($recepcion_ot->ultValuacion()->cotizacionesPreAsociadas as $cotizacion)
                                      <li>Cotización N°{{$cotizacion->id_cotizacion}}</li>
                                      @endforeach
                                      </ul>
                                      @else
                                      SIN COTIZACIONES
                                      @endif
                                    </div>
                                  </div>
                                  <div class="form-group form-inline">
                                    <label for="fechaValuacionIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha fin de valuación: </label>
                                    <input type="text" class="form-control col-sm-6" id="fechaValuacionIn-{{$recepcion_ot->id_recepcion_ot}}" value="{{$recepcion_ot->fechaFinValuacionPopup()}}" autocomplete="off">
                                  </div>
                                  </fieldset>
                                  <!-- eofieldset 1.1 -->
                                @endif
                              @endif
                            
                              @if(!$recepcion_ot->esParticular() && $recepcion_ot->ultValuacion())
                                @if($recepcion_ot->faltaFechaAprobacionSeguro())
                                  <div class="form-group form-inline">
                                    <label for="fechaSeguroIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha aprobación seguro: </label>
                                    <input name="fechaSeguro" min-date="{{$recepcion_ot->minFechaAprobacionSeguro()}}" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaSeguroIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaSeguro-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10" autocomplete="off" @if(!$recepcion_ot->ultValuacion())data-validation-optional="true"@endif>
                                    <div id="errorFechaSeguro-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                  </div>
                                @else
                                  <div class="form-group form-inline">
                                    <label for="fechaSeguroIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha aprobación seguro: </label>
                                    <input type="text" class="form-control col-sm-6" id="fechaSeguroIn-{{$recepcion_ot->id_recepcion_ot}}" value="{{$recepcion_ot->fechaAprobacionSeguroValuacionPopup()}}" autocomplete="off" disabled>
                                  </div>
                                @endif
                              @endif

                              @if(!in_array($recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno,['espera_valuacion', 'espera_valuacion_ampliacion', 'espera_aprobacion_seguro', 'espera_aprobacion_seguro_ampliacion']))
                              <fieldset id="camposAprobacionCliente-{{$recepcion_ot->id_recepcion_ot}}">
                                @if($recepcion_ot->faltaFechaAprobacionCliente())
                                  <div class="form-group form-inline">
                                    <label for="fechaClienteIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha aprobación cliente: </label>
                                    <input recepOT="{{$recepcion_ot->id_recepcion_ot}}" min-date="{{$recepcion_ot->minFechaAprobacionCliente()}}" name="fechaCliente" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaClienteIn-{{$recepcion_ot->id_recepcion_ot}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaCliente-{{$recepcion_ot->id_recepcion_ot}}" placeholder="dd/mm/aaaa" maxlength="10" autocomplete="off" @if(!$recepcion_ot->esObligatorioFechaAprobacionCliente())data-validation-optional="true"@endif>
                                    <div id="errorFechaCliente-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                  </div>
                                @else
                                  <div class="form-group form-inline">
                                    <label for="fechaClienteIn-{{$recepcion_ot->id_recepcion_ot}}" class="col-sm-6 justify-content-end">Fecha aprobación cliente: </label>
                                    <input recepOT="{{$recepcion_ot->id_recepcion_ot}}" type="text" class="form-control col-sm-6" id="fechaClienteIn-{{$recepcion_ot->id_recepcion_ot}}" value="{{$recepcion_ot->fechaAprobacionClienteValuacionPopup()}}" autocomplete="off" disabled>
                                  </div>
                                @endif
                              </fieldset>
                              @endif
  
                              @if(!$recepcion_ot->ultValuacion() || ($recepcion_ot->ultValuacion()  && !$recepcion_ot->ultValuacion()->es_rechazado))
                                <div class="custom-control custom-switch justify-content-end text-left" style="margin-left:40%">
                                  <input name="esRechazado" type="checkbox" class="custom-control-input" id="rechazadoSwitch-{{$recepcion_ot->id_recepcion_ot}}" @if($recepcion_ot->ultValuacion() && $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno=="rechazado") checked @endif>
                                  <label class="custom-control-label" for="rechazadoSwitch-{{$recepcion_ot->id_recepcion_ot}}">En Cargo</label>
                                </div>
                              @endif
  
                              @if(!$recepcion_ot->ultValuacion() || ($recepcion_ot->ultValuacion()  && !$recepcion_ot->ultValuacion()->es_perdida_total))
                                <div class="custom-control custom-switch justify-content-end text-left" style="margin-left:40%">
                                  <input name="esPerdida" type="checkbox" class="custom-control-input" id="perdidaSwitch-{{$recepcion_ot->id_recepcion_ot}}" @if($recepcion_ot->ultValuacion() && $recepcion_ot->ultValuacion()->es_perdida_total) checked @endif>
                                  <label class="custom-control-label" for="perdidaSwitch-{{$recepcion_ot->id_recepcion_ot}}">Pérdida total</label>
                                </div>
                              @endif
                            </fieldset>
                            <!-- eofieldset 1 -->
                            @endif
                            
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          @if(!$recepcion_ot->ultValuacion() || ($recepcion_ot->ultValuacion() && !$recepcion_ot->ultValuacion()->es_perdida_total))
                          <button id="btnSubmit-{{$recepcion_ot->id_recepcion_ot}}" form="FormEditarValuacion-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>
  </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/valuacion.js')}}"></script>
@endsection