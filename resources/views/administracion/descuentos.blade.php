@extends('mecanica.tableCanvas')
@section('titulo','Administracion - Descuentos') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-4">Gestión de Descuentos</h2>
  </div>
  @if(false)
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRepuestos" class="my-3 mr-3" method="GET" action="{{route('consultas.repuestos')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroRepuesto" class="col-form-label col-12 col-sm-6">Cod. Repuesto</label>
          <input id="filtroNroRepuesto" name="nroRepuesto" type="text" class="form-control col-12 col-sm-6" placeholder="Código de repuesto">
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroDescripcion" class="col-form-label col-12 col-sm-6">Descripción</label>
          <input id="filtroDescripcion" name="descripcion" type="text" class="form-control col-12 col-sm-6" placeholder="Descripcion">
        </div>
      </div>
      <div class="row justify-content-end mb-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <button class="btn btn-primary ml-3">Limpiar</button>
      </div>
    </form>
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
            <h2>Descuentos de Taller</h2>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              {{-- <th scope="col">TIPO</th> --}}
              <th scope="col">LOCAL</th>
              <th scope="col">OT</th>
              {{-- <th scope="col"># COT. MESON</th> --}}
              <th scope="col">PLACA</th>
              <th scope="col">ASESOR</th>
              <th scope="col">F. SOLICITUD</th>
              <th scope="col">P. REGULAR</th>
              <th scope="col">DETALLE</th>
              <th scope="col">P C/ DSCTO</th>
              <th scope="col">RECHAZAR</th>
              <th scope="col">APROBAR</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaDescuentos as $descuento)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              {{-- <td style="vertical-align: middle">{{$descuento->getFuenteDescuento()}}</td>               --}}
              <td style="vertical-align: middle">{{$descuento->getLocal() ?? '-'}}</td>
              @if($descuento->getFuenteDescuento()=='OT')
                <td style="vertical-align: middle">{{$descuento->getIDFuenteDescuento()}}</td>
                <td style="vertical-align: middle">{{$descuento->getPlaca()}}</td>
              @else
                <td style="vertical-align: middle">-</td>
                <td style="vertical-align: middle">{{$descuento->getIDFuenteDescuento()}}</td>
              @endif
              {{-- <td style="vertical-align: middle">{{$descuento->getIDClienteDescuento()}}</td> --}}
              <td style="vertical-align: middle">{{$descuento->getAsesorSolicitante()}}</td>
              <td style="vertical-align: middle">{{$descuento->getFechaSolicitud()}}</td>
              
              <td style="vertical-align: middle">
              @if($descuento->getFuenteDescuento()=='OT'){{App\Helper\Helper::obtenerUnidadMoneda($descuento->hojaTrabajo->moneda)}} {{number_format($descuento->getPrecioSinDescuentoPeroConMarca(App\Helper\Helper::obtenerUnidadMonedaCalculo($descuento->hojaTrabajo->moneda)),2)}}
              @else{{App\Helper\Helper::obtenerUnidadMoneda($descuento->cotizacionMeson->moneda)}} {{number_format($descuento->getPrecioSinDescuentoPeroConMarca(App\Helper\Helper::obtenerUnidadMonedaCalculo($descuento->cotizacionMeson->moneda)),2)}}@endif
              </td>
              <td style="vertical-align: middle">@if($descuento->getFuenteDescuento()=='OT') @include("modals.detalleDescuento",['index'=> $loop->iteration, 'descuento'=>$descuento]) @endif</td>
              <td style="vertical-align: middle">
              @if($descuento->getFuenteDescuento()=='OT'){{App\Helper\Helper::obtenerUnidadMoneda($descuento->hojaTrabajo->moneda)}} {{number_format($descuento->getPrecioConDescuentosSiFueraAprobarse(App\Helper\Helper::obtenerUnidadMonedaCalculo($descuento->hojaTrabajo->moneda)),2)}}
              @else{{App\Helper\Helper::obtenerUnidadMoneda($descuento->cotizacionMeson->moneda)}} {{number_format($descuento->getPrecioConDescuentosSiFueraAprobarse(App\Helper\Helper::obtenerUnidadMonedaCalculo($descuento->cotizacionMeson->moneda)),2)}}@endif
              </td>
              <td style="vertical-align: middle">
                <button type="button" class="btn btn-danger btn-tabla" data-toggle="modal" data-target="#rechazarDescuento-{{$loop->iteration}}" data-backdrop="static"><i class="fas fa-wrench icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="rechazarDescuento-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">RECHAZAR DESCUENTO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormRechazarDescuento-{{$loop->iteration}}" method="POST" action="@if($descuento->getFuenteDescuento()=='OT') {{route('descuentos.rechazar')}} @else {{route('meson.rechazarDescuento')}} @endif" value="Submit">
                          @csrf
                          <input type="hidden" name="id_descuento" value="{{$descuento->getIdDescuento()}}">
                          @if ($descuento->hojaTrabajo->necesidadesRepuestos->count() > 0)
                          @if ($descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2)->count() > 0)
                          <input type="hidden" name="id" value="{{ $descuento->hojaTrabajo->necesidadesRepuestos->first()->id_necesidad_repuestos }}">
                          @endif
                          @endif                        
                        </form>
                        ¿Está seguro que desea rechazar el descuento?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnRechazarDescuentoSubmit-{{$loop->iteration}}" form="FormRechazarDescuento-{{$loop->iteration}}" value="Submit" type="submit" class="btn btn-primary" >Confirmar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>

              <td style="vertical-align: middle">
                <button type="button" class="btn btn-success btn-tabla" data-toggle="modal" data-target="#aprobarDescuento-{{$loop->iteration}}" data-backdrop="static"><i class="fas fa-wrench icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="aprobarDescuento-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">APROBAR DESCUENTO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormAprobarDescuento-{{$loop->iteration}}" method="POST" action="@if($descuento->getFuenteDescuento()=='OT') {{route('descuentos.aprobar')}} @else {{route('meson.aprobarDescuento')}} @endif" value="Submit">
                          @csrf
                          <input type="hidden" name="id_descuento" value="{{$descuento->getIdDescuento()}}">
                          @if ($descuento->hojaTrabajo->necesidadesRepuestos->count() > 0)
                          @if ($descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2)->count() > 0)
                          <input type="hidden" name="id" value="{{ $descuento->hojaTrabajo->necesidadesRepuestos->first()->id_necesidad_repuestos }}">
                          @endif    
                          @endif
                          
                        </form>
                        ¿Está seguro que desea aprobar el descuento?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnAprobarDescuentoSubmit-{{$loop->iteration}}" form="FormAprobarDescuento-{{$loop->iteration}}" value="Submit" type="submit" class="btn btn-primary" >Confirmar</button>
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
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection