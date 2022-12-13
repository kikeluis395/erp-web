@extends('tableCanvas')
@section('titulo','Modulo de entregas') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Entregas</h2>

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
            @foreach ($listaMarcas as $marca)
              <option value="{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
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
  <div class="table-responsive borde-tabla">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Listos para entregar</h2>
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
              <th scope="col">#</th>
              <th scope="col">SECCIÓN</th>
              <th scope="col">PLACA</th>
              <th scope="col">F. CREACIÓN</th>
              <th scope="col">N° DOC</th>
              <th scope="col">CLIENTE</th>
              <th scope="col">OT/N° COT. MESON</th>
              <th scope="col">TIPO OT</th>
              @if(false)<th scope="col">ESTADO</th>@endif
              <th scope="col">V. VENTA</th>
              <th scope="col">P. VENTA</th>
              @if(false)<th scope="col">SEGURO</th>@endif
              <th scope="col">ENTREGAR</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRecepcionesOTs as $entregable)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              @if(is_a($entregable,'App\Modelos\RecepcionOT'))
                <td>{{$entregable->hojaTrabajo->tipo_trabajo=='DYP' ? 'B&P' : 'MEC'}}</td>
                <td class="{{$entregable->estiloEsHotLine()}}">{{substr($entregable->hojaTrabajo->placa_auto,0,3).'-'.substr($entregable->hojaTrabajo->placa_auto,3,3)}}</td>
                <td>{{$entregable->hojaTrabajo->getFechaRecepcionFormat()}}</td>
                <td>{{$entregable->hojaTrabajo->getNumDocCliente()}}</td>
                <td>{{$entregable->hojaTrabajo->getNombreCliente()}}</td>
                <td>{!!$entregable->getLinkDetalleHTML()!!}</td>
                <td>{{$entregable->tipoOT->nombre_tipo_ot}}</td>
                @if(false)<td><div class="cont-estado {{$entregable->claseEstado()}}">@if ($entregable->estadoActual()!=[]) {{$entregable->estadoActual()[0]->nombre_estado_reparacion}} @else - @endif</div></td>@endif
                <td>{{App\Helper\Helper::obtenerUnidadMoneda($entregable->hojaTrabajo->moneda)}} {{number_format($entregable->getMontoConSinDescuento()/1.18,2)}}</td>
                <td>{{App\Helper\Helper::obtenerUnidadMoneda($entregable->hojaTrabajo->moneda)}} {{number_format($entregable->getMontoConSinDescuento(),2)}}</td>
                @if(false)<td>{{$entregable->getNombreCiaSeguro()}}</td>@endif
              @else
                <td>MESÓN</td>
                <td>{{'-'}}</td>
                <td>{{\Carbon\Carbon::parse($entregable->fecha_registro)->format('d/m/Y')}}</td>
                <td>{{$entregable->getNumDoc()}}</td>
                <td>{{$entregable->getNombreCliente()}}</td>
                <td>{!!$entregable->getLinkDetalleCotizacion()!!}</td>
                <td>{{'-'}}</td>
                <td>{{App\Helper\Helper::obtenerUnidadMoneda($entregable->moneda)}} {{number_format($entregable->getValueDiscountedQuote2Approved()/1.18,2)}}</td>
                <td>{{App\Helper\Helper::obtenerUnidadMoneda($entregable->moneda)}} {{number_format($entregable->getValueDiscountedQuote2Approved(),2)}}</td>
              @endif
              <td>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#confirmarEntregaModal-{{$loop->iteration}}" data-backdrop="static"><i class="fas fa-edit"></i></button>
                  <!-- Modal -->
                  <div class="modal fade" id="confirmarEntregaModal-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="confirmarEntregaLabel-{{$loop->iteration}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header fondo-sigma">
                          <h5 class="modal-title" id="confirmarEntregaLabel-{{$loop->iteration}}">@if(is_a($entregable,'App\Modelos\RecepcionOT')) {{$entregable->hojaTrabajo->placa_auto}} - OT: {{$entregable->getNroOT()}} @else COT. REPUESTOS # {{$entregable->id_cotizacion_meson}} @endif</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                          <form id="FormConfirmarEntrega-{{$loop->iteration}}" method="POST" 
                          @if(is_a($entregable,'App\Modelos\RecepcionOT'))
                            action="{{route('entrega.store')}}"
                          @else
                            action="{{route('meson.entregarVentaCotizacion')}}"
                          @endif
                          value="Submit" autocomplete="off">
                            @csrf
                            <input type="hidden" 
                              @if(is_a($entregable,'App\Modelos\RecepcionOT')) name="id_recepcion_ot" value="{{$entregable->id_recepcion_ot}}" 
                              @else name="id_cotizacion_meson" value="{{$entregable->id_cotizacion_meson}}" 
                            @endif>
                            <div class="form-group form-inline">
                              <label for="fechaEntregaIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Fecha de entrega: </label>
                              <input name="fechaEntrega" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaEntregaIn-{{$loop->iteration}}" @if(is_a($entregable,'App\Modelos\RecepcionOT')) min-date="{{$entregable->minFechaEntrega()}}" @endif data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaEntrega-{{$loop->iteration}}" placeholder="dd/mm/aaaa" maxlength="10" @if(is_a($entregable,'App\Modelos\RecepcionOT')) value="{{$entregable->minFechaEntrega()}}" @endif autocomplete="off">
                              <div id="errorFechaEntrega-{{$loop->iteration}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="nroFacturaIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Número de Factura: </label>
                              <input name="nroFactura" type="text" class="form-control col-sm-6" id="nroFacturaIn-{{$loop->iteration}}" @if ( !is_a($entregable,'App\Modelos\RecepcionOT') || ( ($entregable->getNombreTipoOT() != "GARANTÍA") && ($entregable->getNombreTipoOT() != "CORTESIA")) ) data-validation="required" @endif data-validation-error-msg="Debe ingresar el número de factura" data-validation-error-msg-container="#errorNroFactura-{{$loop->iteration}}" placeholder="Ingrese el número de factura" maxlength="32" autocomplete="off">
                              <div id="errorNroFactura-{{$loop->iteration}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            @if(false)
                            <div class="form-group form-inline">
                              <label for="fechaTrasladoIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Fecha de traslado: </label>
                              <input name="fechaTraslado" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaTrasladoIn-{{$loop->iteration}}" min-date="{{$entregable->minFechaEntrega()}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaTraslado-{{$loop->iteration}}" data-validation-optional="true" placeholder="dd/mm/aaaa" maxlength="10" value="" autocomplete="off">
                              <div id="errorFechaTraslado-{{$loop->iteration}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            @endif
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button id="btnSubmit-{{$loop->iteration}}" form="FormConfirmarEntrega-{{$loop->iteration}}" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
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
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/entrega.js')}}"></script>
@endsection