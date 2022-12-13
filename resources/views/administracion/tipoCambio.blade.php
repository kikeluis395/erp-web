@extends('mecanica.tableCanvas')
@section('titulo','Tipo de Cambio - Administración') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-4">Administración de Tipos de Cambio</h2>
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
            <h2>Tipos de Cambio</h2>
          </div>
          @include('modals.registrarTipoCambio')
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">FECHA</th>
              <th scope="col" style="width: 200px">T.C COMPRA (S/)</th>
              <th scope="col" style="width: 200px">T.C VENTA (S/)</th>
              <th scope="col" style="width: 200px">T.C COBRO (S/)</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaTiposCambio as $tipoCambio)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{\Carbon\Carbon::parse($tipoCambio->fecha_registro)->format('d/m/Y')}}</td>
              <td style="vertical-align: middle">{{$tipoCambio->compra}}</td>
              <td style="vertical-align: middle">{{$tipoCambio->venta}}</td>
              <td style="vertical-align: middle">{{$tipoCambio->cobro}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection