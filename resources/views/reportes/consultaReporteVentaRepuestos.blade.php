@extends('contabilidadv2.layoutCont')
@section('titulo','Consulta Reporte Kardex') 

@section('content')

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Reportes - Venta Repuestos</h2>
  </div>
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteKardex" class="my-3 mr-3" method="GET" action="{{route('reportes.consulta.ventaRepuestos')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <div class="col-12 col-sm-6">
            <label for="fechaInicial" class="col-form-label">Fecha Inicial</label>
          </div>
          <div class="col-12 col-sm-6">
            <input name="fechaInicial" type="text"  autocomplete="off" class="datepicker form-control w-100" id="fechaInicial" placeholder="dd/mm/aaaa" data-validation="date required" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar una fecha Inicial" data-validation-error-msg-container="#errorFechaInicial" maxlength="10" autocomplete="off">
            <div id="errorFechaInicial" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
        </div>
        <div class="form-group row ml-1 col-6 col-sm-3">
          <div class="col-12 col-sm-6">
            <label for="fechaFinal" class="col-form-label">Fecha Final</label>
          </div>
          <div class="col-12 col-sm-6">
            <input name="fechaFinal" type="text"  autocomplete="off" class="datepicker form-control w-100" id="fechaFinal" placeholder="dd/mm/aaaa" data-validation="date required" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar una fecha Final" data-validation-error-msg-container="#errorFechaFinal" maxlength="10" autocomplete="off">
            <div id="errorFechaFinal" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
        </div>
      </div>
      <div class="row justify-content-end mb-3">
        <button type="submit" class="btn btn-primary">Generar</button>
      </div>
    </form>
  </div>
  
</div>

<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Reporte Venta Repuestos</h2>
          </div>
          @if($resultados)
                <a href="{{route('reportes.ventaRepuestos', ['fechaInicial' => $fechaInicial, 'fechaFinal' => $fechaFinal])}}"><button class="btn btn-primary">Exportar</button></a>
            @endif
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">NOMB. ASESOR</th>
              <th scope="col">NOMB. CLIENTE</th>
              <th scope="col">TIPO VENTA</th>
              <th scope="col">NRO COT</th>
              <th scope="col">NRO OT</th>
              <th scope="col">FECHA FACTURA</th>
              <th scope="col">COD. REPUESTO</th>
              <th scope="col">DESCRIPCION REP.</th>
              <th scope="col">COSTO ($)</th>
              <th scope="col">VENTA ($)</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resultados as $resultado)
            <tr>
              <td style="vertical-align: middle">{{$resultado->nombre_asesor}}</td>
              <td style="vertical-align: middle">{{$resultado->nombre_cliente}}</td>
              <td style="vertical-align: middle">{{$resultado->tipo_venta}}</td>
              <td style="vertical-align: middle">{{$resultado->nro_cotizacion}}</td>
              <td style="vertical-align: middle">{{$resultado->nro_ot}}</td>
              <td style="vertical-align: middle">{{$resultado->fecha_factura}}</td> 
              <td style="vertical-align: middle">{{$resultado->codigo_repuesto}}</td>
              <td style="vertical-align: middle">{{$resultado->descripcion}}</td>
              <td style="vertical-align: middle">{{$resultado->costo_dolares}}</td>
              <td style="vertical-align: middle">{{$resultado->venta_dolares}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection