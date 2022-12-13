@extends('contabilidadv2.layoutCont')
@section('titulo','Consulta Reporte Kardex') 

@section('content')

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Reportes - OT's</h2>
  </div>
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.consulta.ots')}}" value="search">
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

<div class="mx-3" style="overflow-y:none;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Reporte de OT's</h2>
          </div>
            @if($resultados)
                <a href="{{route('reportes.ots', ['fechaInicial' => $fechaInicial, 'fechaFinal' => $fechaFinal])}}"><button class="btn btn-primary">Exportar</button></a>
            @endif
        </div>
      </div>

      @if(isset($resultadosCantidad))
      <div class="table-cont-single mt-3">
        <h4>OTs Existentes</h3>
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">SECCION</th>
              <th scope="col">CORRECTIVO</th>
              <th scope="col">PREVENTIVO</th>
              <th scope="col">RECLAMO</th>
              <th scope="col">GARANTIA</th>
              <th scope="col">PDI</th>
              <th scope="col">SINIESTRO</th>
              <th scope="col">CORTESIA</th>
              <th scope="col">ACCESORIOS</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resultadosCantidad as $resultado)
            <tr>
              <td style="vertical-align: middle">{{$resultado->seccion}}</td>
              <td style="vertical-align: middle">{{$resultado->CORRECTIVO}}</td>
              <td style="vertical-align: middle">{{$resultado->PREVENTIVO}}</td>
              <td style="vertical-align: middle">{{$resultado->RECLAMO}}</td>
              <td style="vertical-align: middle">{{$resultado->GARANTIA}}</td>
              <td style="vertical-align: middle">{{$resultado->PDI}}</td> 
              <td style="vertical-align: middle">{{$resultado->SINIESTRO}}</td>
              <td style="vertical-align: middle">{{$resultado->CORTESIA}}</td>
              <td style="vertical-align: middle">{{$resultado->ACCESORIOS}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      @if(isset($resultadosFacturacion))
      <div class="table-cont-single mt-3">
        <h4>Facturacion de OTs (EN DOLARES Y SIN IGV)</h3>
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">SECCION</th>
              <th scope="col">CORRECTIVO</th>
              <th scope="col">PREVENTIVO</th>
              <th scope="col">RECLAMO</th>
              <th scope="col">GARANTIA</th>
              <th scope="col">PDI</th>
              <th scope="col">SINIESTRO</th>
              <th scope="col">CORTESIA</th>
              <th scope="col">ACCESORIOS</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resultadosFacturacion as $resultado)
            <tr>
              <td style="vertical-align: middle">{{$resultado->seccion}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->CORRECTIVO,2)}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->PREVENTIVO,2)}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->RECLAMO,2)}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->GARANTIA,2)}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->PDI,2)}}</td> 
              <td style="vertical-align: middle">{{number_format($resultado->SINIESTRO,2)}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->CORTESIA,2)}}</td>
              <td style="vertical-align: middle">{{number_format($resultado->ACCESORIOS,2)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>
</div>

@endsection