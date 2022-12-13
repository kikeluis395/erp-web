<style>
*{
	font-family: 'sans-serif';
	font-size: 10px;
}

.all-bordered{
	border-spacing: 0;
	/*border-collapse: collapse;*/
	border: solid;
}

.all-bordered td{
	border: solid;
}

.all-bordered tr{
	border: solid;
}

.negrita{
	font-weight: bold;
}
</style>

{{--<table class="all-bordered" style="width: 100%; margin-top: 20px; border: solid">
    <thead>
        <tr>
			<th>Fecha</th>
			<th>Ta</th>
			<th>Sección</th>
			<th>OT</th>
			<th>Asesor</th>
			<th>KM</th>
			<th>Factura</th>
			<th>Cod. Oper</th>
			<th>Desc. Trab.</th>
			<th>Observ. Trab.</th>
			<th>Tec</th>
        </tr>
    </thead>
	
    <tbody>
	@php
		$varTemp1 = '';
		$varTemp2 = '';
		$varTemp3 = '';
	@endphp
	
    @foreach ($detallesTrabajo as $detalleTrabajo)
        <tr>	
			<td align="center">{{$detalleTrabajo->hojaTrabajo->fecha_registro}}</td>
			<td align="center">{{$detalleTrabajo->hojaTrabajo->recepcionOT->localEmpresa->nombre_local}}</td>
			@if($detalleTrabajo->hojaTrabajo->getTipoTrabajo() == 'DYP')
				@php $seccion = 'B&P' @endphp
			@endif
			
			@if($detalleTrabajo->hojaTrabajo->getTipoTrabajo() == 'PREVENTIVO')
				@php $seccion = 'MEC' @endphp
			@endif
		    <td align="center" rowspan="{{$rowspan ?? 1}}">{{$seccion}}</td>
			<td align="center">{{$detalleTrabajo->hojaTrabajo->id_recepcion_ot}}</td>
			<td align="center">{{$detalleTrabajo->hojaTrabajo->recepcionOT->asesorServicio()}}</td>
			<td align="center">{{$detalleTrabajo->hojaTrabajo->recepcionOT->kilometraje}}</td>
			<td align="center">
			@if($detalleTrabajo->hojaTrabajo->recepcionOT->entregas->first())
			{{$detalleTrabajo->hojaTrabajo->recepcionOT->entregas->first()->nro_factura}}
			@else
			 -
			@endif
			</td>
			<td align="center">{{$detalleTrabajo->operacionTrabajo->cod_operacion_trabajo}}</td>
			<td align="center">{{$detalleTrabajo->getNombreDetalleTrabajo()}}</td>
			<td align="center">{{$detalleTrabajo->hojaTrabajo->observaciones}}</td>
			<td align="center">{{$detalleTrabajo->hojaTrabajo->recepcionOT->getNombreTecnicoAsignado()}}</td>
        </tr>
    @endforeach
    </tbody>
</table>--}}

<div>

<table style="width:100%; text-align:center">
	<tr>
		<td><h1 style="font-size:12px;">HISTORIA CLÍNICA</h1></td>
	<tr>
</table>
</div>

<br>
<br>
<div>
<table style="align: center; width: 100%">
	<tr>
		<td class="negrita">PLACA:</td>
		<td>{{$datosHistoria->getPlacaAutoFormat()}}</td>
		<td class="negrita">AÑO:</td>
		<td>{{$datosHistoria->vehiculo->anho_vehiculo}}</td>
		<td class="negrita">COLOR:</td>
		<td>{{$datosHistoria->getColor()}}</td>
	</tr>
	<tr>
		<td class="negrita">MARCA:</td>
		<td>{{$datosHistoria->vehiculo->getNombreMarca()}}</td>
		<td class="negrita">CHASIS:</td>
		<td>{{$datosHistoria->vehiculo->vin}}</td>
		<td class="negrita">KILOMETRAJE:</td>
		<td>{{$datosHistoria->recepcionOT->kilometraje}}</td>
	</tr>
	<tr>
		<td class="negrita">MODELO:</td>
		<td>{{$datosHistoria->getModeloVehiculo()}}</td>
		<td class="negrita">MOTOR:</td>
		<td>{{$datosHistoria->vehiculo->motor}}</td>
	</tr>
	<tr>
		<td class="negrita">DOCUMENTO:</td>
		<td>{{$datosHistoria->cliente->getNumDocCliente()}}</td>
		<td class="negrita">TELEFONO:</td>
		<td>{{$datosHistoria->cliente->getTelefonoCliente() ?? "" }}</td>
	</tr>
	<tr>
		<td class="negrita">CLIENTE:</td>
		<td>{{$datosHistoria->cliente->getNombreCompleto()}}</td>
		<td class="negrita">CORREO:</td>
		<td>{{$datosHistoria->cliente->getCorreoCliente()}}</td>
	</tr>
	<tr>
		<td class="negrita">DIRECCION:</td>
		<td>{{$datosHistoria->cliente->getDireccionCliente()}} - {{$datosHistoria->cliente->getDistritoText()}} - {{$datosHistoria->cliente->getProvinciaText()}} - {{$datosHistoria->cliente->getDepartamentoText()}}</td>
	</tr>
</table>
</div>
<br>
<div>
    @if($listaHojasTrabajo->count()) 
  
        <table class="all-bordered" style="width: 100%; border-collapse:collapse">
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
              <td style="text-align: center" scope="row">{{$loop->iteration}}</td>
              <td style="text-align: center">{{$hojaTrabajo->getFechaRecepcionFormat('d/m/Y')}}</td>
			    @if($hojaTrabajo->getTipoTrabajo() == 'DYP')
			        @php $seccion = 'B&P' @endphp
				@endif
				
			    @if($hojaTrabajo->getTipoTrabajo() == 'PREVENTIVO')
				    @php $seccion = 'MEC' @endphp
				@endif
			  <td style="text-align: center">{{$hojaTrabajo->empleado->local->nombre_local}}</td>
			  <td style="text-align: center">{{$seccion}}</td>
              <td style="text-align: center">{{$hojaTrabajo->recepcionOT->id_recepcion_ot }}</td>
              <td style="text-align: center">{{$hojaTrabajo->empleado->nombreCompleto()}}</td>
              <td style="text-align: center">{{$hojaTrabajo->recepcionOT->kilometraje}} KM</td>
              <td style="text-align: center">{{$hojaTrabajo->vehiculo->getNombreMarca()}}</td>
              <td style="text-align: center">{{substr($hojaTrabajo->getModeloVehiculo(),0,10)}}</td>
              <td style="padding:0">
			 
                <table style="width:100%; border:none !important; border-collapse:collapse;">
			    @foreach ($hojaTrabajo->detallesTrabajo as $detalleTrabajo) 
                  <tr style="background-color:transparent; border:none !important;">
				  @if(count($hojaTrabajo->detallesTrabajo)>1)
                    <td style="border: none !important; border-bottom: 1px solid;">
					@else
					<td style="border: none !important;">
					@endif
                    {{$detalleTrabajo->getNombreDetalleTrabajo()}}
                    </td>
                  </tr>
                  @endforeach
                </table>
              </td>
              <td style="text-align: center">{{$hojaTrabajo->observaciones}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
 
 
  @endif
</div>