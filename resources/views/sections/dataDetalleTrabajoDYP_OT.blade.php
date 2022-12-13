<div class="row col-12 px-0 my-3">
    <!-- ******************************************* COLUMNA 1 *************************************************-->
	<div class="row col-sm-6 col-lg-4">
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right text-uppercase">{{config('app.rotulo_documento')}}:</span> 	
		<span id="numDocCliente"class="col-6"> 
		@if($esEditableOT)
		    @php $sololectura = '' @endphp
		<a id="abrirModificarCliente" href="#" data-toggle="modal" 
		data-target="#modificarClienteModal" departamento="{{$datosHojaTrabajo->cliente->getDepartamento()}}" 
		provincia="{{$datosHojaTrabajo->cliente->getProvincia()}}" distrito="{{$datosHojaTrabajo->cliente->getDistrito()}}"> {{$datosHojaTrabajo->getNumDocCliente()}} &nbsp; 
		<i class="fas fa-edit"></i>
		</a>
		@else {{$datosHojaTrabajo->getNumDocCliente()}} 
		    @php $sololectura = 'readonly' @endphp
		@endif
		</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CLIENTE:</span> 	
		<span class="col-6">{{$datosHojaTrabajo->getNombreCliente()}} </span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">DIRECCIÓN:</span>	  
		<span class="col-6">{{$datosHojaTrabajo->getDireccionCliente()}} </span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TELÉFONO:</span>	  
		<span class="col-6">{{$datosHojaTrabajo->getTelefonoCliente()}}</span>	
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">EMAIL:</span>	  
		<span class="col-6">{{$datosHojaTrabajo->getCorreoCliente()}}</span>
		<br>	
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CONTACTO:</span>	  
		<span class="col-6">
			<input id="contacto" name="contacto" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" {{$sololectura}}
			style="height: 25px; font-size: 15px" id="contactoInExt" data-validation="required" 
			data-validation-error-msg="Debe especificar el nombre del contacto" data-validation-error-msg-container="#errorContacto"
			placeholder="Ingrese el nombre del contacto" value="{{$datosHojaTrabajo->contacto}}">
			<div id="errorContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
		</span>	 
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TELF. CONTACTO:</span>		
		<span class="col-6">
			<input id="telfContacto" name="telfContacto" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" {{$sololectura}}
			style="height: 25px; font-size: 15px" id="telfContactoInExt" data-validation="required" 
			data-validation-error-msg="Debe especificar el teléfono del contacto" data-validation-error-msg-container="#errorTelfContacto" 
			placeholder="Ingrese el teléfono del contacto" value="{{$datosHojaTrabajo->telefono_contacto}}">
			<div id="errorTelfContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
		</span>	 
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">EMAIL CONTACTO:</span>		
		<span class="col-6">
			<input id="correoContacto" name="correoContacto" type="email" form="formDetallesTrabajo" class="form-control py-0 px-2" 
			style="height: 25px; font-size: 15px" id="correoContactoInExt" data-validation="" {{$sololectura}}
			data-validation-error-msg="Debe especificar el correo del contacto" data-validation-error-msg-container="#errorCorreoContacto" 
			placeholder="Ingrese el correo del contacto" value="{{$datosHojaTrabajo->email_contacto}}">
			<div id="errorCorreoContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
		</span>
		<br>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FACTURAR A:</span>
		<span class="col-6">
			<input id="facturara" name="facturara" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" id="facturara" data-validation="" data-validation-error-msg="Debe especificar el nombre de a quien se facturara" data-validation-error-msg-container="#errorFacturara" placeholder="Ingrese el correo del contacto" {{$sololectura}}
			value="{{$datosRecepcionOT->factura_para != null? $datosRecepcionOT->factura_para: $datosHojaTrabajo->getNombreCliente()}}">
			<div id="errorFacturara" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
		</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">N° DOCUMENTO:</span>
		<span class="col-6">
			<input id="numDoc" name="numDoc" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" id="numDoc" data-validation="" data-validation-error-msg="Debe especificar el numero de documento" data-validation-error-msg-container="#errorNumDoc" placeholder="Ingrese el numero de documento" {{$sololectura}}
			value="{{$datosRecepcionOT->num_doc != null? $datosRecepcionOT->num_doc: $datosHojaTrabajo->getNumDocCliente()}}">
			<div id="errorNumDoc" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
		</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">DIR. FACTURACIÓN:</span>
		<span class="col-6">
			<input id="direccion" name="direccion" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" id="direccio" placeholder="Ingrese la direccion" {{$sololectura}}
			value="{{$datosRecepcionOT->direccion != null? $datosRecepcionOT->direccion: $datosHojaTrabajo->getDireccionCliente()}}">
		<div id="errorNumDoc" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
	</div>
	
	
	<!-- ******************************************* COLUMNA 2 *************************************************-->
	<div class="row col-sm-6 col-lg-4 align-content-start">
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">PLACA:</span>				      
		<span class="col-6">
		@if($esEditableOT)
		<a id="placaVehiculo" href="#" data-toggle="modal" data-target="#modificarVehiculoModal">{{substr($datosHojaTrabajo->placa_auto,0,3).'-'.substr($datosHojaTrabajo->placa_auto,3,3)}} &nbsp; 
		<i class="fas fa-edit"></i>  
		</a>
		@else {{substr($datosHojaTrabajo->placa_auto,0,3).'-'.substr($datosHojaTrabajo->placa_auto,3,3)}} @endif</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MARCA:</span>				      
		<span id="marcaVehiculo" class="col-6">{{$datosHojaTrabajo->vehiculo->getNombreMarca()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MODELO TECNICO:</span>			      
		<span id="modeloTecnicoVehiculo" class="col-6">{{$datosHojaTrabajo->vehiculo->getNombreModeloTecnico()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">VIN:</span>				      
		<span  id="vinVehiculo"class="col-6">{{$datosHojaTrabajo->vehiculo->getVin()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MOTOR:</span>				      
		<span  id="motorVehiculo"class="col-6">{{$datosHojaTrabajo->vehiculo->getMotor()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">AÑO FABRICACIÓN:</span>				      
		<span id="anhoVehiculo" class="col-6">{{$datosHojaTrabajo->vehiculo->getAnhoVehiculo()}}</span>
		<br>

		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">AÑO MODELO:</span>				      
		<span id="anhoVehiculo" class="col-6">{{$datosHojaTrabajo->vehiculo->getAnhoModelo()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">COLOR:</span>
		<span id="" class="col-6">{{$datosHojaTrabajo->getColor()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">KILOMETRAJE:</span>	  
		<span class="col-6">{{$datosRecepcionOT->kilometraje}} KM</span>
		<br>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MONEDA:</span>
		<span class="col-6">
		@if($esEditableOT)
		  <select name="monedaHT" id="monedaHT" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" form="formDetallesTrabajo" 
		  autocomplete="off">
			  <option value="SOLES" @if($datosHojaTrabajo->moneda == "SOLES") selected @endif>Soles</option>
			  <option value="DOLARES" @if($datosHojaTrabajo->moneda == "DOLARES") selected @endif>Dólares</option>
		  </select>
		@else   
		  {{$datosHojaTrabajo->moneda}}
		@endif
		</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">T.C. OT:</span>
		<span class="col-6">
		  <input name="tipoCambio" id="tipoCambioIn" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" form="formDetallesTrabajo" 
		  value="{{\App\Modelos\TipoCambio::getTipoCambioPorFecha($datosHojaTrabajo->fecha_registro)}}" placeholder="Ingrese el tipo de cambio" disabled>
		</span>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">T.C. SEGURO:</span>
		<span class="col-6">
		@if($esEditableOT)
		  <input name="tipoCambio" id="tipoCambioIn" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" form="formDetallesTrabajo" 
		  value="{{$datosHojaTrabajo->tipo_cambio}}" placeholder="Ingrese el tipo de cambio">
		@else 
		  {{$datosHojaTrabajo->tipo_cambio}} 
		@endif
		</span>
	</div>
	
	
	<!-- ******************************************* COLUMNA 3 *************************************************-->
	<div class="row col-sm-6 col-lg-4 align-self-start">
	    <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">OT:</span>				        
		<span  class="col-6" style="font-weight: bold; margin-top: -6px; font-size: large;">{{isset($datosRecepcionOT) ? $datosRecepcionOT->getNroOT() : '-'}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TIPO DE OT:</span>
		<span class="col-6">
		@if($esEditableOT)
		  <select name="tipoOT" id="tipoOTin" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" form="formDetallesTrabajo" 
		  autocomplete="off">
			@foreach ($listaTiposOT as $tipoOT)
			<option value="{{$tipoOT->id_tipo_ot}}" @if($datosRecepcionOT->id_tipo_ot == $tipoOT->id_tipo_ot) selected @endif>{{$tipoOT->nombre_tipo_ot}}</option>
			@endforeach
		  </select>
		@else
		  {{$datosRecepcionOT->getNombreTipoOT()}}
		@endif
		</span>
		<br>

		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA DE INGRESO:</span> 	
		<span class="col-6">{{$datosHojaTrabajo->getFechaRecepcionFormat('d/m/Y H:i')}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA PROMESA:</span>	  
		<span class="col-6">{{$datosRecepcionOT->ultimaFechaPromesaFormat()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">ASESOR:</span>			      
		<span class="col-6">{{$datosHojaTrabajo->empleado->nombreCompleto()}}</span>
		<br>
		
		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">SEGURO:</span>
		<span class="col-6">
		@if($esEditableOT)
		  <select name="seguroSelect" id="seguroSelect" class="form-control py-0 px-2" style="height: 25px; font-size: 15px" form="formDetallesTrabajo" autocomplete="off">
			@foreach ($listaSeguros as $seguro)
			<option value="{{$seguro->id_cia_seguro}}" @if($nombreCiaSeguro == $seguro->nombre_cia_seguro) selected @endif>{{$seguro->nombre_cia_seguro}}</option>
			@endforeach
		  </select>
		@else
		  {{$nombreCiaSeguro}}
		@endif
		</span>

		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">Nº. POLIZA:</span>			      
		{{-- <span class="col-6">{{$datosRecepcionOT->nro_poliza}}</span> --}}
		<span class="col-6">
			<input id="poliza" name="nro_poliza" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" {{$sololectura}}
			style="height: 25px; font-size: 15px" id="polizaInExt" 			
			placeholder="Ingrese el numero de poliza" value="{{$datosRecepcionOT->nro_poliza}}">
			{{-- <div id="errorContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div> --}}
		</span>
		<br>

		<span class="font-weight-bold letra-rotulo-detalle col-6 text-right">Nº. SINIESTRO</span>			      
		{{-- <span class="col-6">{{$datosRecepcionOT->nro_siniestro}}</span> --}}
		<span class="col-6">
			<input id="siniestro" name="nro_siniestro" type="text" form="formDetallesTrabajo" class="form-control py-0 px-2" {{$sololectura}}
			style="height: 25px; font-size: 15px" id="siniestroInExt" 			
			placeholder="Ingrese el numero de siniestro" value="{{$datosRecepcionOT->nro_siniestro}}">
		</span>

		<br>
	</div>
</div>

@include('modals.modificarCliente',["cliente"=>$datosHojaTrabajo->cliente])
@include('modals.modificarVehiculo',["vehiculo"=>$datosHojaTrabajo->vehiculo])