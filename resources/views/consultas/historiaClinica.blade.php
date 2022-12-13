@extends('mecanica.tableCanvas')
@section('titulo','Consultas - Historia Clínica') 

@section('pretable-content')
<div style="background: white;padding: 10px">
	<div class="row justify-content-between col-12">
	    <h2>Consulta - Historia Clínica</h2>
	</div>
	
	<div id="busquedaCollapsable" class="col-12 borde-tabla" style="background: white;margin-top:10px" noLimpiar>
		<form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('consultas.historiaClinica')}}" value="search">
			<div class="row">
				<div class="form-group row ml-1 col-6 col-sm-3">
				  <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">Documento</label>
				  <input id="filtroNroDoc" name="nroDoc" type="text" maxlength="11" class="form-control col-12 col-sm-6" placeholder="Número de documento">
				</div>
				
				<div class="form-group row ml-1 col-6 col-sm-3">
				  <label for="filtroPlaca" class="col-form-label col-12 col-sm-6">Placa</label>
				  <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6" maxlength="6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
				</div>
				
				<div class="form-group row ml-1 col-6 col-sm-3">
				  <label for="filtroVin" class="col-form-label col-12 col-sm-6">Vin</label>
				  <input id="filtroVin" name="nroVin" type="text" class="form-control col-12 col-sm-6" maxlength="17" placeholder="Número de Vin" oninput="this.value = this.value.toUpperCase()">
				</div>
				
				<div class="form-group row ml-1 col-6 col-sm-3">
				  <button type="submit" class="btn btn-primary">Buscar</button>
				</div>
			</div>
		</form>
    </div>
</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    @if($listaHojasTrabajo->count()) 
	<!-- ############################################################################################################################################# -->
	<div class="row col-12 px-0 my-3">
		<!-- ******************************************* COLUMNA 1 *************************************************-->
		<div class="row col-sm-6 col-lg-4">
			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">PLACA:</span> 	
			<span class="col-6">{{$datosHistoria->getPlacaAutoFormat()}}</span>
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MARCA:</span>				      
			<span id="marcaVehiculo" class="col-6">{{$datosHistoria->vehiculo->getNombreMarca()}}</span>
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MODELO:</span>	  
			<span class="col-6">{{$datosHistoria->getModeloVehiculo()}}</span>
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">DOCUMENTO:</span>	  
			<span class="col-6">{{$datosHistoria->cliente->getNumDocCliente()}}</span> 
			
			<br>
			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CLIENTE:</span>	  
			<span class="col-6">{{$datosHistoria->cliente->getNombreCompleto()}}</span>
			
			<br>
			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">DIRECCIÓN:</span>	  
			<span class="col-6">{{$datosHistoria->cliente->getDireccionCliente()}} - {{$datosHistoria->cliente->getDistritoText()}} - {{$datosHistoria->cliente->getProvinciaText()}} - {{$datosHistoria->cliente->getDepartamentoText()}}</span>

			
		</div>
		
		
		<!-- ******************************************* COLUMNA 2 *************************************************-->
		<div class="row col-sm-6 col-lg-4 align-self-start">

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">AÑO:</span>	  
			<span class="col-6">{{$datosHistoria->vehiculo->anho_vehiculo}}</span>	
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CHASIS:</span> 	
			<span class="col-6">{{$datosHistoria->vehiculo->vin}}</span>
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MOTOR:</span> 	
			<span class="col-6">{{$datosHistoria->vehiculo->motor}}</span>
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TELEFONO:</span>				      
			<span  id="motorVehiculo"class="col-6">{{$datosHistoria->cliente->getTelefonoCliente() ?? "" }}</span>
			<br>

			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CORREO:</span>			      
			<span class="col-6">{{$datosHistoria->cliente->getCorreoCliente()}}</span>
			
		</div>
		
		
		<!-- ******************************************* COLUMNA 3 *************************************************-->
		<div class="row col-sm-6 col-lg-4 align-self-start">
			
			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">COLOR:</span>	  
			<span class="col-6">{{$datosHistoria->getColor()}}</span>
			<br>
			
			<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">KILOMETRAJE:</span>	  
			<span class="col-6">{{$datosHistoria->recepcionOT->kilometraje}}</span>
			<br>

		</div>
	</div>
	<!-- ############################################################################################################################################# -->
	
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Historia Clínica</h2>
          </div>

          @if($listaHojasTrabajo->count())
          <div>
            <a href="{{route('consultas.historiaClinica.exportPDF', $request)}}"><button class="btn btn-primary">Exportar PDF</button></a>
          </div>
          @endif
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">FECHA INGRESO</th>
			  <th scope="col">LOCAL</th>
			  <th scope="col">SECCIÓN</th>
              <th scope="col">OT</th>
              <th scope="col">ASESOR</th>
              <th scope="col">KILOMETRAJE</th>
              <th scope="col">MARCA</th>
              <th scope="col">MODELO</th>
              <th scope="col">DETALLES TRABAJOS OT</th>
              <th scope="col">OBS OT</th>
            </tr>
          </thead>
          <tbody>
		  	
            @foreach ($listaHojasTrabajo as $hojaTrabajo)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              <td style="vertical-align: middle">{{$hojaTrabajo->getFechaRecepcionFormat('d/m/Y')}}</td>
			    @if($hojaTrabajo->getTipoTrabajo() == 'DYP')
			        @php $seccion = 'B&P' @endphp
				@endif
				
			    @if($hojaTrabajo->getTipoTrabajo() == 'PREVENTIVO')
				    @php $seccion = 'MEC' @endphp
				@endif
			  <td style="vertical-align: middle">{{$hojaTrabajo->empleado->local->nombre_local}}</td>
			  <td style="vertical-align: middle">{{$seccion}}</td>
              <td style="vertical-align: middle">{!! $hojaTrabajo->recepcionOT->getLinkDetalleHTML() !!}</td>
              <td style="vertical-align: middle">{{$hojaTrabajo->empleado->nombreCompleto()}}</td>
              <td style="vertical-align: middle">{{$hojaTrabajo->recepcionOT->kilometraje}} KM</td>
              <td style="vertical-align: middle">{{$hojaTrabajo->vehiculo->getNombreMarca()}}</td>
              <td style="vertical-align: middle">{{substr($hojaTrabajo->getModeloVehiculo(),0,10)}}</td>
              <td style="padding:0">
                <table style="width:100%">
                  @foreach ($hojaTrabajo->detallesTrabajo as $detalleTrabajo)
                  <tr style="background-color:transparent">
                    <td>
                    {{$detalleTrabajo->getNombreDetalleTrabajo()}}
                    </td>
                  </tr>
                  @endforeach
                </table>
              </td>
              <td style="vertical-align: middle">{{$hojaTrabajo->observaciones}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @else
  <!--strong>Ingrese el número de placa en el cuado de búsqueda para comenzar.</strong-->
  @endif
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection