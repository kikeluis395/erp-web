@extends('mecanica.tableCanvas')
@section('titulo','Consultas - Repuestos') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Consulta - Repuestos</h2>
  </div>
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRepuestos" class="my-3 mr-3" method="GET" action="{{route('consultas.repuestos')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <div class="col-12 col-sm-6">
            <label for="filtroNroRepuesto" class="col-form-label">Cod. Repuesto</label>
          </div>
          <div class="col-12 col-sm-6">
            <input value="{{$codigo_repuesto}}" id="filtroNroRepuesto" name="nroRepuesto" type="text" tipo="repuestos" class="form-control typeahead w-100" autocomplete="off" data-toggle="tooltip" data-placement="top" title="Puede ingresar el Codigo o la descripccion del repuesto en este campo">
          </div>
        </div>
        <div class="form-group row ml-1 col-5">
          <div class="col-4">
            <label for="filtroDescripcion" class="col-form-label">Descripción</label>
          </div>
          <div class="col-8">
            <input value="{{$descripcion}}" id="filtroDescripcion" typeahead_second_field="filtroNroRepuesto" name="descripcion" type="text" class="form-control w-100" placeholder="Descripcion" readonly>
          </div>
        </div>

        <div class="form-group row ml-1 col-6 col-sm-3">
          <div class="col-12 col-sm-6">
              <label for="fechaInicial"
                     class="col-form-label">Fecha Inicial</label>
          </div>
          <div class="col-12 col-sm-6">
              <input name="fechaInicial"
                     type="text"
                     autocomplete="off"
                     class="datepicker form-control w-100"
                     id="fechaInicial"
                     value="{{$fecha_inicial}}"
                     min-date="{{ date('01/01/2021') }}"
                     placeholder="dd/mm/aaaa"
                     data-validation="date required"
                     data-validation-format="dd/mm/yyyy"
                     data-validation-length="10"
                     data-validation-error-msg="Debe ingresar una fecha Inicial"
                     data-validation-error-msg-container="#errorFechaInicial"
                     maxlength="10"
                     autocomplete="off">
              <div id="errorFechaInicial"
                   class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
      </div>
      <div class="form-group row ml-1 col-6 col-sm-3">
          <div class="col-12 col-sm-6">
              <label for="fechaFinal"
                     class="col-form-label">Fecha Final</label>
          </div>
          <div class="col-12 col-sm-6">
              <input name="fechaFinal"
                     type="text"
                     disabled
                     value="{{$fecha_final}}"
                     autocomplete="off"
                     class="datepicker form-control w-100"
                     id="fechaFinal"
                     placeholder="dd/mm/aaaa"
                     data-validation="date required"
                     data-validation-format="dd/mm/yyyy"
                     data-validation-length="10"
                     data-validation-error-msg="Debe ingresar una fecha Final"
                     data-validation-error-msg-container="#errorFechaFinal"
                     maxlength="10"
                     autocomplete="off">
              <div id="errorFechaFinal"
                   class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
      </div>

      </div>
      <div class="row justify-content-end mb-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <button form="formBorrar" class="btn btn-primary ml-3">Limpiar</button>
      </div>
    </form>
    <form id="formBorrar"></form>
  </div>
  
</div>
@endsection

@section('table-content')

@if($listaRepuestos!=null&& count($listaRepuestos)>0)
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Características del repuesto</h2>
          </div>


        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">LOCAL</th>
              <th scope="col">MARCA</th>
              <th scope="col">CATEGORIA</th>
              
              <th scope="col">APLICACIÓN MODELO</th>
              <th scope="col">SALDO ACTUAL</th>
              
              <th scope="col">COSTO UNIT.(sin igv)</th>
    
              <th scope="col">PRECIO $ (con igv) </th>
              <th scope="col">PRECIO S/ (con igv)</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaRepuestos as $repuesto)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              
              <td style="vertical-align: middle">{{$repuesto->nombre_local}}</td>
              <td style="vertical-align: middle">{{$repuesto->nombre_marca}}</td>
              <td style="vertical-align: middle">{{$repuesto->nombre_categoria}}</td>  
              
              <td style="vertical-align: middle">-</td>
              <td style="vertical-align: middle">{{$repuesto->saldo_actual}}</td> 
              <td style="vertical-align: middle">$ {{$costo}}</td>
                         
              <td style="vertical-align: middle">{{App\Helper\Helper::obtenerUnidadMonedaCambiar("DOLARES")}}
                {{number_format($repuesto->precio_dolares,2)}}
              </td>
              <td style="vertical-align: middle">{{App\Helper\Helper::obtenerUnidadMonedaCambiar("SOLES")}}
                {{number_format($repuesto->precio_soles,2)}}
                
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Resumen de Movimientos</h2>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">LOCAL</th>
              <th scope="col">ULTIMO INGRESO</th>
              <th scope="col">ULTIMO EGRESO</th>
              <th scope="col">DÍAS SIN MOVIMIENTO</th>
              <th scope="col">ICC</th>
              <th scope="col">UBICACIÓN</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($resumen as $row)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{$row->taller}}</td>
              <td style="vertical-align: middle">{{$row->ultimo_ingreso}}</td>
              <td style="vertical-align: middle">{{$row->ultimo_egreso}}</td>
              <td style="vertical-align: middle">{{$row->dias_sin_movimiento}}</td>
              <td style="vertical-align: middle">{{$row->icc}}</td>
              <td style="vertical-align: middle">{{$row->ubicacion}}</td>   
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Reservas</h2>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TALLER</th>
              <th scope="col">FECHA</th>
              <th scope="col">FUENTE</th>
              <th scope="col">NUM FUENTE</th>
              <th scope="col">CANTIDAD RESERVADA</th>           
            </tr>
          </thead>
          <tbody>
            @foreach ($reservas as $row)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{$row->taller}}</td>
              <td style="vertical-align: middle">{{$row->fecha}}</td>
              <td style="vertical-align: middle">{{$row->fuente}}</td>
              <td style="vertical-align: middle">{!!$row->num_fuente!!}</td>
              <td style="vertical-align: middle">{{$row->cantidad_reservada}}</td>
                                   
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Detalle de movimientos</h2>
          </div>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">FECHA</th>
              <th scope="col">FUENTE</th>
              <th scope="col">NUM FUENTE</th>
              <th scope="col">MOTIVO</th>   
              <th scope="col">CANTIDAD INGRESO</th>
              <th scope="col">CANTIDAD SALIDA</th>
              <th scope="col">CANTIDAD SALDO</th>
              <th scope="col">COSTO UNITARIO</th>       
            </tr>
          </thead>
          <tbody>
            @foreach ($kardex as $row)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{$row->fecha}}</td>
              <td style="vertical-align: middle">{{$row->fuente}}</td>
              <td style="vertical-align: middle">{{$row->num_fuente}}</td>
              <td style="vertical-align: middle">{{$row->motivo}}</td>
              <td style="vertical-align: middle">{{$row->cantidad_ingreso}}</td>
              <td style="vertical-align: middle">{{$row->cantidad_salida}}</td>
              <td style="vertical-align: middle">{{$row->cantidad_saldo}}</td>
              <td style="vertical-align: middle">{{$row->costo_unitario}}</td>                 
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endIf
@endsection






@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection