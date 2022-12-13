<style>
* {
    font-family: 'sans-serif';
    font-size: 11px;
}
</style>

<h3>REPORTE DE HISTORIA CLINICA</h3>

<table style="width: 100%;">
	<tr>
		<th align="left" style="width: 10%;">Placa:</th>
		<td colspan="2" style="font-size: 15px">{{$datosHistoria->getPlacaAutoFormat()}}</td> 
		
		<th align="left">Motor:</th>
		<td align="left">{{$datosHistoria->vehiculo->motor}}</td>
		
		<th align="left">Chasis</th>
		<td>{{$datosHistoria->vehiculo->vin}}</td>
	</tr>
	
	<tr>
		<th align="left">Color:</th>
		<td colspan="2">{{$datosHistoria->getColor()}}</td>

		<th align="left">Marca</th>
		<td>{{$datosHistoria->vehiculo->getNombreMarca()}}</td>
		
		<th align="left">Modelo:</th>
		<td>{{$datosHistoria->getModeloVehiculo()}}</td>
	</tr>
	
	<tr>
		<th align="left">Año</th>
		<td colspan="2">{{$datosHistoria->vehiculo->anho_vehiculo}}</td> 
		
		<th align="left">Kilometraje</th>
		<td align="left">{{$datosHistoria->recepcionOT->kilometraje}} KM</td>
		
		<th align="left">Telefono</th>   
		<td align="left">{{$datosHistoria->cliente->getTelefonoCliente()}}</td>
	</tr>
	
	<tr>
		<th align="left">Documento</th>
		<td colspan="2">{{$datosHistoria->cliente->getNumDocCliente()}}</td>   

		<th align="left">Correo</th>      
		<td align="left">{{$datosHistoria->cliente->getCorreoCliente()}}</td>
	</tr>
	
    <tr>
	    <th align="left">Cliente</th>
		<td colspan="2">{{substr($datosHistoria->cliente->getNombreCompleto(), 0, 16)}}</td>
		
		<th align="left">Direccion</th>
		<td colspan="3">{{$datosHistoria->cliente->getDireccionCliente()}}</td>    
	</tr>
</table>

@include('consultas.historiaClinicaExport')