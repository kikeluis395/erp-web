@extends('repuestos.repuestosCanvas')
@if($datosRecepcion->id_recepcion_ot)
  @section('titulo',"Repuestos - OT N° $datosRecepcion->id_recepcion_ot") 
@else
  @section('titulo',"Repuestos - Cotizacion N° $datosRecepcion->id_cotizacion") 
@endif

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <div class="row justify-content-between">
      <h2 class="ml-3 mt-3 mb-4">Detalle de Repuestos</h2>
      <div class="justify-content-end">
        @if($datosRecepcion->id_recepcion_ot)
        <a href="{{route('repuestosOT')}}"><button type="button" class="btn btn-info">Regresar</button></a>
        @else
        <a href="{{route('repuestosCot')}}"><button type="button" class="btn btn-info">Regresar</button></a>
        @endif
      </div>
    </div>

    <div class="row col-12 px-0 my-3">
      <div class="row col-sm-6 col-lg-4 align-self-start">
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right text-uppercase">{{config('app.rotulo_documento')}}: </span>				      <span class="col-6   ">{{$datosRecepcion->getNumDocCliente()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CLIENTE: </span>				    <span class="col-6   ">{{$datosRecepcion->getNombreCliente()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">PLACA: </span>				      <span class="col-6   ">{{$datosRecepcion->getPlacaPartida()}}</span>
      </div>
      <div class="row col-sm-6 col-lg-4 align-self-start">
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MARCA: </span>				      <span class="col-6   ">{{$datosRecepcion->vehiculo->getNombreMarca()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MODELO TÉCNICO: </span>			      <span class="col-6   ">{{$datosRecepcion->vehiculo->getNombreModeloTecnico()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">VIN: </span>			      <span class="col-6   ">{{$datosRecepcion->vehiculo->getVin()}}</span>
      </div>
      <div class="row col-sm-6 col-lg-4">
        @if($datosRecepcion->id_recepcion_ot)
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">OT: </span>				        <span class="col-6   ">{{$datosRecepcion->getOTNroOT()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TIPO OT: </span>				        <span class="col-6   ">{{$datosRecepcion->recepcionOT->getNombreTipoOT()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right"># PEDIDO: </span> 	<span class="col-6   ">{{$necesidadRepuestos->id_necesidad_repuestos}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA APERTURA OT: </span> 	<span class="col-6   ">{{$datosRecepcion->getFechaRecepcionFormat('d/m/Y H:i')}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA DE SOLICITUD: </span>			      <span class="col-6   ">{{\Carbon\Carbon::parse($necesidadRepuestos->fecha_registro)->format('d/m/Y H:i')}}</span>
        @else
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">COTIZACION: </span>				        <span class="col-6   ">{{$datosRecepcion->id_cotizacion}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA APERTURA COT: </span> 	<span class="col-6   ">{{$datosRecepcion->getFechaRecepcionFormat()}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA DE SOLICITUD: </span>			      <span class="col-6   ">{{\Carbon\Carbon::parse($necesidadRepuestos->fecha_registro)->format('d/m/Y H:i')}}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MONEDA: </span> 	<span class="col-6   ">{{$datosRecepcion->moneda}}</span>
        @endif
      </div>
    </div>
    
    <div class="row justify-content-end">
      @if(false)
      @if($datosRecepcion->id_recepcion_ot)
        @include('modals.agregarRepuestoOT')
      @else
        @include('modals.agregarRepuestoCotizacion')
      @endif
      @endif

      {{-- @if($necesidadRepuestos->esImprimible()) --}}
        @include('modals.modalImprimirPedido')
      
      {{-- @endif --}}
      
    
    </div>

  </div>
</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  @if(session('errorDatos'))  
      <div style="color: red; margin: auto;">{{session('errorDatos')}}</div>
  @endif
  @if (session('errorNumero'))
  <div class="alert alert-danger col-12" role="alert">
    {{ session('errorNumero') }}
  </div>
  @endif
  @if (session('successDescuento'))
  <div class="alert alert-success col-12" role="alert">
    {{ session('successDescuento') }}
  </div>
  @endif
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        
        <div class="row col-12">
          <div>
            <h2>Repuestos Solicitados</h2>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
            
              <th scope="col">ESTADO</th>
           
              <th scope="col">CÓDIGO</th>
              <th scope="col">DESCRIPCIÓN</th>
              <th scope="col">CANTIDAD</th>  
              <th scope="col">DÍAS S/ MOV.</th> 
              <th scope="col">UBICACIÓN</th>   
              @if($datosRecepcion->id_cotizacion)
                <th scope="col">DISPONIBILIDAD</th>
                @if(!$datosRecepcion->necesidadesRepuestos()->orderBy('fecha_registro','desc')->first()->es_finalizado)
                <th scope="col">¿ES IMPORTACIÓN?</th>
                @endif
                
              @endif
                    
              @if($datosRecepcion->id_cotizacion)
              <th scope="col">DSCTO. MARCA %</th>
              <th scope="col">DSCTO. MARCA</th>
              <th scope="col">P. REGULAR</th>
              <th scope="col">P. C/DSCTO</th>
              @if(!$datosRecepcion->necesidadesRepuestos()->orderBy('fecha_registro','desc')->first()->es_finalizado)
              <th scope="col"></th>
              @endif
              @endif
              
              @if($datosRecepcion->id_recepcion_ot)
              
              <th scope="col">DISPONIBILIDAD</th>
              <th scope="col" style="width: 100px">DSCTO. MARCA %</th>            
              <th scope="col">DSCTO. MARCA</th>
              <th scope="col">P. REGULAR</th>
              <th scope="col">P. C/DSCTO</th>
              <th scope="col"></th>
              
              @endif              
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRepuestos as $repuesto)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              @if(false)<!-- ESTO YA NO ENTRA. ANTES EL ESTADO ERA EN OTRA TABLA <td>{{$repuesto->estadoRepuesto->nombre_estado_repuesto}}</td> -->@endif
              @if($datosRecepcion->id_recepcion_ot)
              <td>
              @if($repuesto->entregado)
                    <div class="estado-repuesto-entregado">ENTREGADO</div> 
                  @elseif($repuesto->entregado === 0)
                    <div class="bg-warning">SIN ENTREGAR</div> 
                  @else
                    <div class="estado-repuesto-pendiente">SIN CODIFICAR</div> 
                  @endif</td>
              @else
              <td>@if($repuesto->id_repuesto!=null)
                    <div class="estado-repuesto-entregado">CODIFICADO</div>  
                  @else
                    <div class="estado-repuesto-pendiente">SIN CODIFICAR</div> 
                  @endif</td>
              @endif
              <td>{{$repuesto->getRepuestoNroParteTexto()}}</td>
              <td>{{$repuesto->getDescripcionRepuesto()}}</td>
              <td>{{$repuesto->getCantidadRepuestosTexto()}}</td> 
              <td>{{$repuesto->daysWithoutMovement()}}</td>
              <td>{{ $repuesto->repuesto->ubicacion ?? '-' }}</td>   
              @if($datosRecepcion->id_cotizacion)
              <td>@if($repuesto->id_repuesto){{$repuesto->getDisponibilidad()}} @else - @endif</td>
              @if(!$datosRecepcion->necesidadesRepuestos()->orderBy('fecha_registro','desc')->first()->es_finalizado)
              <td align="center">@csrf @if($repuesto->id_repuesto && !$repuesto->hayStock()) <input id="importado-{{$repuesto->id_item_necesidad_repuesto}}" name="importado-{{$repuesto->id_item_necesidad_repuesto}}" idItemRepuesto="{{$repuesto->id_item_necesidad_repuestos}}" type="checkbox" class="form-control" style="width:100px" @if($repuesto->es_importado == 1) checked @endif></td> @else - @endif</td>
              @endif
              
              @endif
                   
              @if($datosRecepcion->id_cotizacion)
              <td class="row justify-content-center align-items-center" style="width: 150px">
                <input type="text" id="desc_uni_{{ $repuesto->id_item_necesidad_repuestos }}" class="form-control col-md-6 mr-2"
                  value="{{ $repuesto->descuento_unitario ?? 0 }}"
                    oninput="$(`#form_desc_uni_{{ $repuesto->id_item_necesidad_repuestos }}`).val($(this).val())">%
              </td>
              <td>@if($repuesto->id_repuesto){{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}} {{number_format($repuesto->getMontoTotal($repuesto->getFechaRegistroCarbon(),true) * ($repuesto->descuento_unitario ? $repuesto->descuento_unitario/100 : 0),2)}} @else - @endif</td>              
              <td>@if($repuesto->id_repuesto){{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}} {{number_format($repuesto->getMontoTotal($repuesto->getFechaRegistroCarbon(),true),2)}} @else - @endif</td>
              <td>@if($repuesto->id_repuesto){{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}} {{number_format($repuesto->getMontoTotal($repuesto->getFechaRegistroCarbon(),true) * ($repuesto->descuento_unitario ? 1 - ($repuesto->descuento_unitario/100) : 1),2)}} @else - @endif</td>

              @endif
              
              @if($datosRecepcion->id_recepcion_ot)
                
                <td>{{$repuesto->getDisponibilidad()}}</td>
                <td class="row  mt-2">
                  <input type="text" id="desc_uni_{{ $repuesto->id_item_necesidad_repuestos }}" class="form-control col-md-6 mr-2 "
                  value="{{ $repuesto->descuento_unitario ?? 0 }}"
                    oninput="$(`#form_desc_uni_{{ $repuesto->id_item_necesidad_repuestos }}`).val($(this).val())"> <div class="mt-2">%</div>
                </td>                
                <td>{{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}} {{ number_format($repuesto->getDescuentoPorMarca($repuesto->getFechaRegistroCarbon(),true, $repuesto->descuento_unitario ?? 0), 2) }}</td>                
                <td>{{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}} {{ number_format($repuesto->getMontoUnitario($repuesto->getFechaRegistroCarbon(),true) * $repuesto->getCantidadRepuestos(), 2) }}</td>
                <td>{{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}} {{ number_format($repuesto->getMontoConDescPorMarca($repuesto->getFechaRegistroCarbon(),true, $repuesto->descuento_unitario ?? 0) , 2) }}</td>

                <td>
                  @if(!$repuesto->entregado)
                    @include('modals.modificarRepuestoOT')
                  @else
                    <button type="button" class="btn btn-warning" disabled><i class="fas fa-edit icono-btn-tabla"></i></button>
                  @endif
                </td>
              @else
                <td>@include('modals.modificarRepuestoCotizacion')</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="p-0 mt-3 mb-3">
    <div class="p-0 mt-3 mr-5">
      <div class="row justify-content-{{ isset(request()->id_hoja_trabajo) ? 'between' : 'end' }} m-0">
        @isset(request()->id_hoja_trabajo)
        <form action="{{ route('detalle_repuestos.saveDescuento') }}" method="POST">
          @csrf
          @foreach ($listaRepuestos as $repuesto)
          <input type="hidden" id="form_desc_uni_{{ $repuesto->id_item_necesidad_repuestos }}" name="desc_uni-{{ $repuesto->id_item_necesidad_repuestos }}" class="form-control col-md-6 mr-2" style="width: 100px"
          value="{{ $repuesto->descuento_unitario ?? 0 }}">
          @endforeach
          <button class="btn btn-warning">Guardar</button>
        </form>
        @endisset          
          <p>
            <span class="font-weight-bold text-right" style="font-size: 17px; padding-top:1px">TOTAL: </span> 	<span class="ml-3" id="simboloTotalCot">{{Helper::obtenerUnidadMoneda($datosRecepcion->moneda)}}</span> <span id="totalCot" style="width: 145px; text-align: right">{{$total}}</span>
          </p>
      </div>
    </div>
  </div>
  @if($datosRecepcion->id_cotizacion && $esFinalizable)
  <div class="p-0 mt-3">
    <div class="col-xl-12 p-0 mt-3">
      <div class="row justify-content-end m-0">
        <div>
          <form method="POST" action="{{route('detalleRepuestos.finalizarCotizacion',['id_hoja_trabajo'=>$datosRecepcion->id_hoja_trabajo])}}">
            @csrf
            <button id="btnFinCot" type="submit" class="btn btn-warning">Completar Cotización</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif
  
</div>


@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/detalleSolicitudRepuestos.js')}}"></script>
@endsection
