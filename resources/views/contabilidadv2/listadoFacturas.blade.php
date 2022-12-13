@extends('mecanica.tableCanvas')
@section('titulo','Seguimiento de Facturas') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Seguimiento de Facturas</h2>
   
  </div>

  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRepuestos" class="my-3 mr-3" method="GET" action="{{route('contabilidad.seguimientoFacturacion')}}" value="search">
      <div class="row">

        
        <div class="form-group ml-sm-0 col-sm-3">
          <label class="col-12 col-form-label form-control-label justify-content-end" for="filtroLocal" id="labelDocumentoSol">EMPRESA: </label>     
          <div class="col-12">
              <input id="filtroLocal" name="filtroLocal" class="form-control w-100" type="text" value="PLANETA NISSAN" disabled>
          </div>
      </div>

      <div class="form-group  ml-sm-0 col-3">     
          <div class="col-12">
            <label class="col-12 col-form-label form-control-label justify-content-end" for="filtroLocal" id="labelDocumentoSol">SUCURSAL: </label>
            <select name="filtroLocal" id="filtroLocal" class="form-control col-12 ">
              @foreach($locales as $local)
              <option value="{{$local->id_local}}">{{$local->nombre_local}}</option>
              @endforeach
            </select>
          </div>
      </div>

      <div class="form-group   col-3">
        <label for="filtroFechaEntrega" class="col-form-label col-12 ">Rango F. Emisión</label>
        <div class="row col-12 ">
          <input id="filtroFechaEmisionInicio" name="fechaInicioEntrega" type="text" autocomplete="off"
            class="fecha-inicio form-control col-5" placeholder="Fecha inicio"
            value="{{ isset(request()->fechaInicioEmision) ? request()->fechaInicioEntrega : '' }}">
          -
          <input id="filtroFechaEmisionFin" name="fechaFinEntrega" type="text" autocomplete="off"
            class="fecha-fin form-control col-5" placeholder="Fecha fin"
            value="{{ isset(request()->fechaFinEmision) ? request()->fechaFinEntrega : '' }}">
        </div>
      </div>


      <div class="form-group  ml-sm-0 col-3">     
        <div class="col-12">
          <label class="col-12 col-form-label form-control-label justify-content-end" for="filtroEstadoSunat" id="filtroEstadoSunat">ESTADO DOCUMENTO: </label>
          <select name="filtroEstadoSunat" id="filtroEstadoSunat" class="form-control col-12 ">
            <option value=""></option>
            <option value="Aceptado">Aceptado</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Anulado">Anulado</option>
            <option value="Rechazado">Rechazado</option>
            
          </select>
        </div>
      </div>

      <div class="form-group col-3 mb-4">
        <label class="col-12 col-form-label form-control-label justify-content-end" for="oCRelacionada" id="labelDocumentoSol">DOCUMENTO: </label>
        <div class="row ml-3">
            <select name="filtroSerieLetra" id="filtroSerieLetra" class="form-control col-4"> 
                <option value="F">Factura</option>
                <option value="C">Boleta</option>
            </select>
            <select name="numSerie" id="numSerie" class="form-control col-3">
              <option value="001">001</option>
              <option value="002">002</option>
              <option value="003">003</option>
              <option value="004">004</option>
              <option value="005">005</option>
          </select>
            
            <input placeholder="Num doc"  autocomplete="off" id="numDoc" name="numDoc" class="form-control col-3 ml-1" type="text" >

        </div>
      </div>


      <div class="form-group  ml-sm-0 col-3">     
        <div class="col-12">
          <label class="col-12 col-form-label form-control-label justify-content-end" for="filtroCentroCosto" >CENTRO DE COSTO: </label>
          <select name="filtroCentroCosto" id="filtroCentroCosto" class="form-control col-12 ">
            <option value=""></option>
            <option value="001">001 - Taller</option>
            <option value="002">002 - Ventas</option>
            <option value="003">003 - P&P</option>
            <option value="004">004 - Repuestos</option>
            <option value="005">005 - Venta Plaza Norte</option>
          </select>
        </div>
      </div>
      
       

        <div class="form-group  ml-sm-0 col-3">
          <div class="col-12">
            <label for="docCliente" class="col-form-label">DOC. CLIENTE</label>
            <input id="docCliente" name="docCliente" type="text"  class="form-control w-100" >
          </div>
        </div>

        <div class="form-group  ml-sm-0 col-3">
          <label for="filtroTipoOperacion" class="col-form-label col-12 ">TIPO DE OPERACION</label>
          <select name="filtroTipoOperacion" id="filtroTipoOperacion" class="form-control col-12">
            <option value=""></option>
            <option value="VENTA">Venta</option>
            <option value="ANTICIPO">Anticipo</option>  
          </select>
        </div>

        <div class="form-group  ml-sm-0 col-3">
          <label for="filtroTipoVenta" class="col-form-label col-12">TIPO DE VENTA</label>
          <select name="filtroTipoVenta" id="filtroTipoVenta" class="form-control col-12 ">
            <option value=""></option>
            <option value="B&P">BYP</option>
            <option value="GARANTIAS">Garantias</option>
            <option value="GENERAL">General</option>
            <option value="MEC">Mecánica</option>
            <option value="MESON">Mesón</option>
            <option value="VEHICULOS">Vehicular</option>  

          </select>
        </div>

        <div class="form-group  ml-sm-0 col-3">
          <label for="filtroTipoDocumento" class="col-form-label col-12">TIPO DE DOCUMENTO</label>
          <select name="filtroTipoDocumento" id="filtroTipoDocumento" class="form-control col-12">
            <option value=""></option>
            <option value="FACTURA">Factura</option>
            <option value="BOLETA">Boleta</option>
            <option value="NC">Nota de Crédito</option>
            <option value="ND">Nota de Débito</option>
          </select>
        </div>

        <div class="form-group  ml-sm-0 col-3">
          <label for="filtroCondicionPago" class="col-form-label col-12">CONDICIÓN DE PAGO</label>
          <select name="filtroCondicionPago" id="filtroCondicionPago" class="form-control col-12">
            <option value=""></option>
            <option value="0">Contado</option>
            <option value="15">Crédito a 15 días</option>
            <option value="30">Crédito a 30 días</option>
            <option value="45">Crédito a 45 días</option>
            <option value="60">Crédito a 60 días</option>
          </select>
        </div>
        
      </div>

      @include("modals.modalPendientesPorFacturar",['pendientesPorFacturar'=>$pendientesPorFacturar])
     

      <div class="row justify-content-end mb-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
        
        
        <a href="{{route('contabilidad.seguimientoFacturacion')}}"><button type="button" class="btn btn-info ml-3">Limpiar</button></a>
        
        <a href="{{ route('reporteSeguimientoFacturacion', ['datos' => request()->all()]) }}" class="btn btn-success ml-3" target="_blank">Descargar</a>
        {{-- <button class="btn btn-primary justify-content-end mr-3 btn-nota-credito" id="refreshState" type="button"  >
          Actualizar estado sibi
         </button> --}}
      </div>
    </form>
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
            <h2>COMPROBANTES </h2>
          </div>
        </div>
      </div>
  
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">LOCAL</th>
              <th scope="col">REGISTRADO POR</th>
              <th scope="col">FECHA REGISTRO</th>
              <th scope="col">C. COSTO</th>
              <th scope="col">TIPO DOCUMENTO</th>
              <th scope="col">DOCUMENTO</th>  
              <th scope="col">DOC CLIENTE</th>
              <th scope="col">CLIENTE</th>
              <th scope="col">CONDICION DE PAGO</th>
              <th scope="col">ESTADO CRÉDITO</th>
              <th scope="col">TIPO DE OPERACIÓN</th>
              <th scope="col">DOC REFERENCIA</th>
              <th scope="col">MONEDA</th>
              <th scope="col">DETRACCÓN</th>
              <th scope="col">SUBTOTAL</th>
              <th scope="col">IMPUESTO</th>
              <th scope="col">TOTAL</th>
              <th scope="col">ESTADO</th>
              <th scope="col">CÓDIGO SUNAT</th>
              <th scope="col">DESCRIPCIÓN SUNAT</th>
              <th scope="col">NOTA DE ENTREGA</th>
              <th scope="col">CONSTANCIA DE REPUESTOS</th>
              {{-- <th scope="col"></th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($listaNotas as $row)
            <tr>
              <th style="vertical-align: middle" class="{{ $row->semaforo }}" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{$row->local}} </td>
              <td style="vertical-align: middle">{{$row->registrado_por}} </td>
              <td style="vertical-align: middle">{{$row->fecha_registro}} </td>             
              <td style="vertical-align: middle">{{$row->centro_costo}} </td>
              <td style="vertical-align: middle">{{$row->tipo_documento}} </td>
              <td style="vertical-align: middle">{!! $row->url !!} </td>
              <td style="vertical-align: middle">{{$row->doc_cliente}} </td>
              <td style="vertical-align: middle">{{$row->cliente}} </td>
              <td style="vertical-align: middle">{{$row->condicion_pago_texto}} </td>
              <td style="vertical-align: middle">{{$row->estado_credito}} </td>
              <td style="vertical-align: middle">{{$row->tipo_operacion}} </td>
              <td style="vertical-align: middle">{!!$row->doc_referencia!!} </td>
              <td style="vertical-align: middle">{{$row->moneda}} </td>
              <td style="vertical-align: middle">{{$row->detraccion}} </td>
              <td style="vertical-align: middle">{{$row->subtotal}} </td>
              <td style="vertical-align: middle">{{$row->impuesto}} </td>
              <td style="vertical-align: middle">{{$row->total}} </td>
              <td style="vertical-align: middle">{{$row->estado}} </td>
              <td style="vertical-align: middle">{{$row->sunat_code}} </td>
              <td style="vertical-align: middle">{{$row->sunat_description}} </td>
              <td style="vertical-align: middle">{!! $row->url_nota_entrega !!} </td>
              <td style="vertical-align: middle">{!! $row->url_constancia !!} </td>
              {{-- <td style="vertical-align: middle">{!!$row->url!!}</td>         --}}       
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
