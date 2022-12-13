@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Seguimiento de OC')

@section('content')

<div style="background: white;padding: 10px">
   <h2 class="ml-3 mt-3 mb-4">Seguimiento de OC</h2>
   <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
      <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('contabilidad.seguimientoOC')}}" value="search">
         <div class="row">
            <div class="form-group row ml-1 col-6 col-sm-3">
               <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
               <input id="filtroNroDoc" name="nroDoc" value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
            </div>
            {{--                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroPlaca" class="col-form-label col-12 col-sm-6">Placa</label>
                    <input id="filtroPlaca" name="nroPlaca"
                        value="{{ isset(request()->nroPlaca) ? request()->nroPlaca : '' }}" type="text"
            class="form-control col-12 col-sm-6" placeholder="Número de placa"
            oninput="this.value = this.value.toUpperCase()">
         </div> --}}
         <div class="form-group row ml-1 col-6 col-sm-3">
            <label for="filtroNroOC" class="col-form-label col-12 col-sm-6"># OC</label>
            <input id="filtroNroOC" name="nroOC" value="{{ isset(request()->nroOC) ? request()->nroOC : '' }}" type="text" class="form-control col-12 col-sm-6" placeholder="Número de OC">
         </div>
         <div class="form-group row ml-1 col-6 col-sm-3">
            <label for="filtroEstado" class="col-form-label col-12 col-sm-6">Estado</label>
            <select name="estado" id="filtroEstado" class="form-control col-sm-6">
               <option value="all">TODOS</option>
               {{-- <option value="atendido_total"
                            {{ isset(request()->estado) && request()->estado == 'atendido_total' ? 'selected' : null }}>
               ATENDIDO TOTAL</option> --}}
               <option value="atendido_parcial" {{ isset(request()->estado) && request()->estado == 'atendido_parcial' ? 'selected' : null }}>
                  ATENDIDO PARCIAL</option>
               <option value="aprobado" {{ isset(request()->estado) && request()->estado == 'aprobado' ? 'selected' : null }}>
                  APROBADO</option>
               <option value="pendiente_aprobacion" {{ isset(request()->estado) && request()->estado == 'pendiente_aprobacion' ? 'selected' : null }}>PENDIENTE
                  APROBACIÓN</option>
            </select>
         </div>
         <div class="form-group row ml-1 col-6 col-sm-3">
            <label for="filtroUserRegistro" class="col-form-label col-12 col-sm-6">U. Registro</label>
            <select name="userRegistro" id="filtroUserRegistro" class="form-control col-sm-6">
               <option value="all">TODOS</option>
               @foreach ($usuarios as $usuario)
               <option value="{{ $usuario[0] }}" {{ isset(request()->userRegistro) && request()->userRegistro == $usuario[0] ? 'selected' : '' }}>{{ $usuario[1] }}</option>
               @endforeach
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
@if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif
<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
   <div class="table-responsive borde-tabla tableFixHead">
      <div class="table-wrapper">
         <div class="table-title">
            <div class="row col-12 justify-content-between">
               <div class="form-inline row">
                  <h2>OC Registradas</h2>
                  <button class="btn btn-primary mr-4" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
                     Filtrar
                  </button>
               </div>

               <form id="FormCrearOC" class="d-flex justify-content-end" method="GET" action="{{route('contabilidad.crearOC')}}">
                  <button class="btn btn-primary btn-lg" type="submit">
                     Crear OC
                  </button>
               </form>
            </div>
         </div>

         <div class="table-cont-single">
            <table class="table text-center table-striped table-sm">
               <thead>
                  <tr>
                     <th scope="col">#OC</th>
                     <th scope="col">RUC</th>
                     <th scope="col">PROVEEDOR</th>
                     <th scope="col">FECHA</th>
                     <th scope="col">U. REGISTRO</th>
                     <th scope="col">COSTO TOTAL (SIN IGV)</th>
                     <th scope="col">ESTADO</th>
                     <th scope="col">VISUALIZAR</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($ordenesCompra as $ordenCompra)
                  <tr>
                     <th scope="row">
                        <a class='id-link' href="{{route('contabilidad.visualizarOC',['id_orden_compra' => $ordenCompra->id_orden_compra])}}" target='_blank'>{{$ordenCompra->id_orden_compra}}</a>
                     </th>
                     <td>{{$ordenCompra->getRUCProveedor()}}</td>
                     <td>{{$ordenCompra->getNombreProveedor()}}</td>
                     <td>{{$ordenCompra->getFechaEntregaText()}}</td>
                     <td>{{$ordenCompra->getNombreCompletoUsuarioRegistro()}}</td>
                     <td>{{App\Helper\Helper::obtenerUnidadMonedaCambiar($ordenCompra->tipo_moneda)}} {{number_format($ordenCompra->getCostoTotal(),2)}}</td>
                     <td>@if($ordenCompra->es_finalizado) Atentido Total @elseif($ordenCompra->flagTieneNotasIngreso()) Atendido Parcial @elseif($ordenCompra->es_aprobado) Aprobado @else Pendiente Aprobación @endif</td>
                     <td><a href="{{route('contabilidad.visualizarOC',['id_orden_compra' => $ordenCompra->id_orden_compra])}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i> </i></button></a></td>
                  </tr>
                  @endforeach

               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

@endsection