@extends('contabilidadv2.layoutCont')
@section('titulo','Consulta Reporte Ventas') 

@section('content')

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Reportes - Ventas Mesón</h2>
  </div>
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteKardex" class="my-3 mr-3" method="GET" action="{{route('reportes.ventasMeson.export')}}" onsubmit="return submitReporteVentasTaller()" value="search">
      <div class="row">
        <div class="col-md-6 ml-2 form-group row">
          <label class="col-md-3">Fecha Rango Apertura</label>
          <div class="col-md-3">
            <input type="text" autocomplete="off" class="datepicker form-control" name="fechaAperturaIni" id="fechaAperturaIni"
              onchange="controlarInputs('fechaApertura', 'fechaFactura')" placeholder="dd/mm/yyyy" required>
            <span class="text-danger" id="fechaAperturaIniError"></span>
          </div>
          <span class="mx-2">-</span>
          <div class="col-md-3">
            <input type="text" autocomplete="off" class="datepicker form-control" name="fechaAperturaFin" id="fechaAperturaFin"
              onchange="controlarInputs('fechaApertura', 'fechaFactura')" placeholder="dd/mm/yyyy" required>
            <span class="text-danger" id="fechaAperturaFinError"></span>
          </div>
        </div>
        <div class="col-md-6 ml-2 form-group row">
          <label class="col-md-3">Fecha Rango Factura</label>
          <div class="col-md-3">
            <input type="text" autocomplete="off" class="datepicker form-control" name="fechaFacturaIni" id="fechaFacturaIni"
              onchange="controlarInputs('fechaFactura', 'fechaApertura')" placeholder="dd/mm/yyyy" required>
            <span class="text-danger" id="fechaFacturaIniError"></span>
          </div>
          <span class="mx-2">-</span>
          <div class="col-md-3">
            <input type="text" autocomplete="off" class="datepicker form-control" name="fechaFacturaFin" id="fechaFacturaFin"
              onchange="controlarInputs('fechaFactura', 'fechaApertura')" placeholder="dd/mm/yyyy" required>
            <span class="text-danger" id="fechaFacturaFinError"></span>
          </div>
        </div>
      </div>
      <div class="row justify-content-end mb-3">
        <button type="submit" class="btn btn-primary">Generar</button>
      </div>
    </form>
  </div>
  
</div>

@if(false)
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
@endif
@endsection