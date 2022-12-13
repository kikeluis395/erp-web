@extends('contabilidadv2.layoutCont')
@section('titulo','Seguimiento de OS') 

@section('content')

<div style="background: white;padding: 10px">
    <h2 class="ml-3 mt-3 mb-4">Seguimiento de Solicitudes Servicios Terceros</h2>
    <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
        <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('seguimientoServiciosTerceros')}}"
            value="search">
            <div class="row">
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
                    <input id="filtroNroDoc" name="nroDoc"
                        value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}" type="text"
                        class="form-control col-12 col-sm-6" placeholder="Número de documento">
                </div>
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroPlaca" class="col-form-label col-12 col-sm-6">Placa</label>
                    <input id="filtroPlaca" name="nroPlaca"
                        value="{{ isset(request()->nroPlaca) ? request()->nroPlaca : '' }}" type="text"
                        class="form-control col-12 col-sm-6" placeholder="Número de placa"
                        oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroNroOT" class="col-form-label col-12 col-sm-6"># OT</label>
                    <input id="filtroNroOT" name="nroOT" value="{{ isset(request()->nroOT) ? request()->nroOT : '' }}"
                        type="text" class="form-control col-12 col-sm-6" placeholder="Número de OT">
                </div>
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroEstado" class="col-form-label col-12 col-sm-6">Estado</label>
                    <select name="estado" id="filtroEstado" class="form-control col-sm-6">
                        <option value="all">TODOS</option>
                        <option value="aprobado"
                            {{ isset(request()->estado) && request()->estado == 'aprobado' ? 'selected' : null }}>
                            APROBADO</option>
                        <option value="generado"
                            {{ isset(request()->estado) && request()->estado == 'generado' ? 'selected' : null }}>
                            GENERADO</option>
                        <option value="sin_generar"
                            {{ isset(request()->estado) && request()->estado == 'sin_generar' ? 'selected' : null }}>SIN
                            GENERAR</option>
                    </select>
                </div>
                <!-- <div class="form-group row ml-1 col-6 col-sm-3">
              <label for="filtroOT" class="col-form-label col-12 col-sm-6">OT</label>
              <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-6" placeholder="Órden de Trabajo">
            </div> -->
            </div>
            <div class="col-12">
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-primary ">Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row justify-content-end mr-4" >
        <div>
            <span style="font-size: 17px"> {{Helper::mensajeNoIncluyeIGV()}}</span>
        </div>
    </div>
    <div class="table-responsive borde-tabla tableFixHead">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row col-12 justify-content-between">
                    <div class="form-inline row">
                        <h2>Solicitudes Registradas</h2>           
                        <button class="btn btn-primary mr-4" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
                            Filtrar
                        </button>
                    </div>
                </div>
            </div>
      
            <div class="table-cont-single">
                <table class="table text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#OT</th>
                            <th scope="col">PLACA</th>
                            <th scope="col">RUC</th>
                            <th scope="col">PROVEEDOR</th>
                            <th scope="col">#OS</th>
                            <th scope="col">COSTO TOTAL</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">VISUALIZAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudServiciosTerceros as $solicitudServicioTercero)
                        <tr>
                            <th scope="row">{!!$solicitudServicioTercero->recepcion_ot->getLinkDetalleHTML()!!}</th>
                            <td>{{$solicitudServicioTercero->recepcion_ot->hojaTrabajo->placa_auto}}</td>
                            <td>{{$solicitudServicioTercero->num_doc}}</td>
                            <td>{{$solicitudServicioTercero->nombre_proveedor}}</td>
                            @if(is_null($solicitudServicioTercero->id_orden_servicio))
                            <td> - </td>
                            @else
                            <td>
                            {{$solicitudServicioTercero->id_orden_servicio}}
                                <!-- <a class='id-link' href= "{{route('hojaOrdenServicio',['id_orden_servicio'=>$solicitudServicioTercero->id_orden_servicio] )}}" target='_blank'>{{$solicitudServicioTercero->id_orden_servicio}}</a> -->
                            </td>
                            @endif
                            <td>@if(is_null($solicitudServicioTercero->costo_total)) - @else {{App\Helper\Helper::obtenerUnidadMonedaCambiar($solicitudServicioTercero->moneda)}} {{number_format($solicitudServicioTercero->costo_total,2)}} @endif</td>
                            <td>@if($solicitudServicioTercero->estado == 'aprobado') Aprobado @elseif($solicitudServicioTercero->estado == 'generado') Pendiente Aprobacion @else Sin Generar @endif</td>
                            <td><a href="{{route('visualizarServicioTercero', ['id_proveedor' => $solicitudServicioTercero->id_proveedor, 
                                                                               'id_recepcion_ot' => $solicitudServicioTercero->id_recepcion_ot,
                                                                               'estado' => $solicitudServicioTercero->estado,
                                                                               'id_orden_servicio' => $solicitudServicioTercero->id_orden_servicio])}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></a></td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection