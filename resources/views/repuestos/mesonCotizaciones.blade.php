@extends('repuestos.repuestosCanvas')
@section('titulo','Meson - Cotizaciones') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <h2 class="ml-3 mt-3 mb-4">Seguimiento de Cotizaciones</h2>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('meson.index')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-4 col-xl-3">
          <label for="filtroEstado" class="col-form-label col-6">Estado</label>
          <select name="estado" id="filtroEstado" class="form-control col-6">
            <option value="all">Todos</option>
            {{-- <option value="FACTURADO - RP" {{ isset(request()->estado) && request()->estado == 'FACTURADO - RP' ? 'selected' : '' }}>FACTURADO - RP</option> --}}
            <option value="LIQUIDADO" {{ isset(request()->estado) && request()->estado == 'LIQUIDADO' ? 'selected' : '' }}>LIQUIDADO</option>
            {{-- <option value="LIQUIDADO - RP" {{ isset(request()->estado) && request()->estado == 'LIQUIDADO - RP' ? 'selected' : '' }}>LIQUIDADO - RP</option> --}}
            <option value="PENDIENTE" {{ isset(request()->estado) && request()->estado == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
          </select>
        </div>
        <div class="form-group row ml-1 mr-1 col-12 col-sm-6 pr-sm-0 pl-0">
          <label for="filtroFechaInicioSolicitud" class="col-form-label col-12 col-sm-4 col-lg-5">FECHA CREACIÓN COT.</label>
          <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
            <input id="filtroFechaInicioSolicitud" name="fechaInicioSolicitud" value="{{ isset(request()->fechaInicioSolicitud) ? request()->fechaInicioSolicitud : '' }}" type="text" autocomplete="off" class="fecha-inicio form-control col-6" placeholder="Fecha inicio">
            -
            <input id="filtroFechaFinSolicitud" name="fechaFinSolicitud" value="{{ isset(request()->fechaFinSolicitud) ? request()->fechaFinSolicitud : '' }}" type="text" autocomplete="off" class="fecha-fin form-control col-5" placeholder="Fecha fin">
          </div>
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3 px-sm-0">
          <label for="filtroCOT" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6"># COTIZACIÓN</label>
          <input id="filtroCOT" name="nroCOT" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Número de cotización" value="{{ isset(request()->nroCOT) ? request()->nroCOT : '' }}" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3 px-sm-0">
          <label for="filtroNV" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6"># NOTA VENTA</label>
          <input id="filtroNV" name="nroNV" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Nota de Venta" value="{{ isset(request()->nroNV) ? request()->nroNV : '' }}" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-4 col-xl-3">
          <label for="filtroNumDoc" class="col-form-label col-12 col-sm-4 col-lg-4 col-xl-6">N° DOCUMENTO</label>
          <input id="filtroNumDoc" name="numDoc" type="text" class="form-control col-12 col-sm-6 col-lg-8 col-xl-6" placeholder="Número de documento" value="{{ isset(request()->numDoc) ? request()->numDoc : '' }}">
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
        <div class="row col-12 justify-content-between">
          <div class="form-inline row">
            <div>
              <h2>Seguimiento de cotizaciones</h2>
            </div>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
              Filtrar
            </button>
          </div>
          <a href="{{route('meson.create')}}" class="btn btn-info">Crear Cotizacion de Meson</a>
          
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col" ROWSPAN=2>#</th>
              <th scope="col" ROWSPAN=2>ESTADO</th>
              <th scope="col" ROWSPAN=2>F. CREACIÓN</th>
              <th scope="col" ROWSPAN=2># COT.</th>
              <th scope="col" ROWSPAN=2># NV</th>
              <th scope="col" ROWSPAN=2>N° DOCUMENTO</th>
              <th scope="col" ROWSPAN=2>CLIENTE</th>
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

             
              <th scope="col" ROWSPAN=2>P. TOTAL</th>
              <th scope="col" ROWSPAN=2>DETALLE</th>
            </tr>
            <tr>
           
          </thead>
          <tbody>
            @foreach ($listaCotizaciones as $cotizacion)              
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td><div class="cont-estado {{$cotizacion->claseEstado()}}">{{$cotizacion->getEstado()}}</div></td>
              <td>{{$cotizacion->getFechaCreacionText()}}</td>
              
              <td>{!!$cotizacion->getLinkDetalleHTML()!!}</td>
              <td>@if($cotizacion->esVendido()){{$cotizacion->ventasMeson->first()->id_venta_meson}} @else - @endif</td>
              <td>{{$cotizacion->getNumDoc()}}</td>
              <td>{{$cotizacion->getNombreCliente()}}</td>
              <td>                                  
                <div class="row align-items-center justify-content-center">
                    <span class="sub_th">{{$cotizacion->contarRepuestosAsociados()['contadorEnStock']}}</span>
                    <span class="sub_th">{{$cotizacion->contarRepuestosAsociados()['contadorEnTransito']}}</span>
                    <span class="sub_th">{{$cotizacion->contarRepuestosAsociados()['contadorEnImportacion']}}</span>
                </div>
              </td>


              
              <td>{{App\Helper\Helper::obtenerUnidadMonedaCambiar($cotizacion->getMoneda())}} {{round($cotizacion->getValueDiscountedQuote2Approved(), 2)}}</td>
              <td><a href="{{route('meson.show', $cotizacion->id_cotizacion_meson)}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection