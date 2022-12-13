<head>
<style>
    *{
        border-width:0.5px;
        font-family: 'sans-serif';
    }
    .all-bordered{
        border-spacing: 0;
        border-collapse: collapse;
    }

    .all-bordered td{
        border: solid;
    }

    .all-bordered th{
        border: solid;
    }
</style>
</head>
<body>

<table class="all-bordered" style="width: 100%;">
    @if($esPreliquidacion)
    <tr><th style="border: none" colspan="6" align="center">PRE-LIQUIDACION DE OT</th></tr>
    @else
    <tr><th style="border: none" colspan="6" align="center">LIQUIDACION DE OT</th></tr>
    @endif
	
    <tr align="left">
		<th>Centro Servicio</th>   
		<td>{{$hojaTrabajo->empleado->local->nombre_local}}</td>    
		<th>O.T.</th>   
		<td>{{$hojaTrabajo->id_recepcion_ot}}</td>      
        @if($seguro!="")		
		<th>Seguro</th>   
		<td>{{$seguro}}</td>
		@endif
	</tr>
	
    <tr align="left">
		<th>Tipo de Orden</th>     
		<td>{{$hojaTrabajo->recepcionOT->tipoOT->nombre_tipo_ot}}</td>            
		<th>Asesor</th> 
		<td colspan="3">{{$hojaTrabajo->empleado->nombreCompleto()}}</td>
	</tr>
	
    <tr align="left">
		<th>Fecha Apertura</th>     
		<td @if($seguro=="") colspan="5" @else @endif>{{$hojaTrabajo->getFechaRecepcionFormat('d/m/Y')}}</td>
		
		<th>Fecha Emisión</th>
		<td>{{$hojaTrabajo->recepcionOT->getFechaLiquidacionFormat()}}</td>
		
		<th>Fecha Impresión</th>
		<td>{{$ldate = date('d/m/Y')}}</td>
	</tr>
    
    <tr class="rotulo-tabla" align="left">
	    <th colspan="6">CLIENTE</th>
	</tr>
	
    <tr align="left">
		<th>Nombre</th>     
		<td colspan="3">{{$hojaTrabajo->cliente->getNombreCompleto()}}</td>
		<th>Doc.Ident</th>  
		<td>{{$hojaTrabajo->getNumDocCliente()}}</td>
	</tr>
	
    <tr align="left">
		<th>Direccion</th>  
		<td colspan="3">{{$hojaTrabajo->getDireccionCliente()}}</td>
		<th>Teléfono</th>   
		<td>{{$hojaTrabajo->getTelefonoCliente()}}</td>
	</tr>
	
    <tr align="left"><th>Email</th>     
	    <td colspan="5">{{$hojaTrabajo->getCorreoCliente()}}</td>
	</tr>

    <tr class="rotulo-tabla" align="left">
	    <th colspan="6">VEHICULO</th>
	</tr>
	
    <tr align="left">
		<th>Placa</th>             
		<td>{{$hojaTrabajo->getPlacaPartida()}}</td>        
		<th>Motor</th>      
		<td>{{$hojaTrabajo->vehiculo->motor}}</td>      
		<th>VIN</th>  
		<td>{{$hojaTrabajo->vehiculo->vin}}</td>
	</tr>
	
    <tr align="left"><th>Marca</th>      
		<td>{{$hojaTrabajo->vehiculo->getNombreMarca()}}</td>  
		<th>Modelo</th> 
		<td>{{$hojaTrabajo->vehiculo->getModelo()}}</td>  
		<th>Color</th>      
		<td>{{$hojaTrabajo->vehiculo->color}}</td>
	</tr>
	
    <tr align="left">
		<th>Año Fabricación</th>   
		<td>{{$hojaTrabajo->vehiculo->anho_vehiculo}}</td>
		<th>Kilometraje</th>
		<td colspan="3">{{$hojaTrabajo->recepcionOT->kilometraje}} KM</td>
	</tr>
</table>

@if(!$arregloCarroceria->isEmpty())
<table class="all-bordered" style="width: 100%; margin-top: 50px">
    <thead>
        <tr><th class="rotulo-tabla" colspan="6">CARROCERÍA</th></tr>
        <tr><th>Codigo</th> <th>Descripción</th>    <th>Horas</th>   <th>Precio Lista</th>   <th>Descuento</th>  <th>Precio Venta</th></tr>
    </thead>
    <tbody>
    @foreach($arregloCarroceria as $detalleTrabajo)
        <tr align="center">
            <td>{{$detalleTrabajo->operacionTrabajo->cod_operacion_trabajo}}</td>
            <td>{{$detalleTrabajo->getNombreDetalleTrabajo()}}</td>
            <td>{{number_format($detalleTrabajo->valor_trabajo_estimado,2)}}</td>
            <td align="right">{{$detalleTrabajo->getPrecioListaUnitario($monedaCalculo)}}</td>
            <td align="right">{{$detalleTrabajo->getDescuento($monedaCalculo)}}</td>
            <td align="right">{{$detalleTrabajo->getSubTotal($monedaCalculo)}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr align="center"><td colspan="4" style="border: none"></td>   <th>TOTAL</th>  <td align="right">{{$totalCarroceria}}</td></tr>
    </tfoot>
</table>
@endif

@if(!$arregloPanhos->isEmpty())
<table class="all-bordered" style="width: 100%; margin-top: 50px">
    <thead>
        <tr><th class="rotulo-tabla" colspan="6">PINTURA</th></tr>
        <tr><th>Codigo</th> <th>Descripción</th>    <th>Paños</th>   <th>Precio Lista</th>   <th>Descuento</th>  <th>Precio Venta</th></tr>
    </thead>
    <tbody>
    @foreach($arregloPanhos as $detalleTrabajo)
        <tr align="center">
            <td>{{$detalleTrabajo->operacionTrabajo->cod_operacion_trabajo}}</td>
            <td>{{$detalleTrabajo->getNombreDetalleTrabajo()}}</td>
            <td>{{number_format($detalleTrabajo->valor_trabajo_estimado,2)}}</td>
            <td align="right">{{$detalleTrabajo->getPrecioListaUnitario($monedaCalculo)}}</td>
            <td align="right">{{$detalleTrabajo->getDescuento($monedaCalculo)}}</td>
            <td align="right">{{$detalleTrabajo->getSubTotal($monedaCalculo)}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr align="center"><td colspan="4" style="border: none"></td>   <th>TOTAL</th>  <td align="right">{{$totalPanhos}}</td></tr>
    </tfoot>
</table>
@endif

@if(!$arregloMecanica->isEmpty())
<table class="all-bordered" style="width: 100%; margin-top: 50px">
    <thead>
        <tr><th class="rotulo-tabla" colspan="6">MECÁNICA</th></tr>
        <tr><th>Codigo</th> <th>Descripción</th>    <th>Horas</th>   <th>Precio Lista</th>   <th>Descuento</th>  <th>Precio Venta</th></tr>
    </thead>
    <tbody>
    @foreach($arregloMecanica as $detalleTrabajo)
        <tr align="center">
            <td>{{$detalleTrabajo->operacionTrabajo->cod_operacion_trabajo}}</td>
            <td>{{$detalleTrabajo->getNombreDetalleTrabajo()}}</td>
            <td>{{number_format($detalleTrabajo->valor_trabajo_estimado,2)}}</td>
            <td align="right">{{$detalleTrabajo->getPrecioListaUnitario($monedaCalculo)}}</td>
            <td align="right">{{$detalleTrabajo->getDescuento($monedaCalculo)}}</td>
            <td align="right">{{$detalleTrabajo->getSubTotal($monedaCalculo)}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr align="center"><td colspan="4" style="border: none"></td>   <th>TOTAL</th>  <td align="right">{{$totalMecanica}}</td></tr>
    </tfoot>
</table>
@endif

@if(count($listaRepuestosAprobados) > 0)
<table class="all-bordered" style="width: 100%; margin-top: 50px">
    <thead>
        <tr><th class="rotulo-tabla" colspan="7">REPUESTOS</td></tr>
        <tr>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Unidad Medida</th>
            <th>Precio Lista</th>
            <th>Descuento</th>
            <th>Precio Venta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listaRepuestosAprobados as $repuestoAprobado)
        <tr align="center">
            <td>{{$repuestoAprobado->getRepuestoNroParte()}}</td>
            <td>{{$repuestoAprobado->getDescripcionRepuestoAprobado()}}</td>
            <td>{{$repuestoAprobado->getCantidad()}}</td>
            <td>UND</td>
            <td align="right">{{number_format($repuestoAprobado->getMontoUnitario($repuestoAprobado->getFechaRegistroCarbon(),true),2)}}</td>
            <td align="right">{{number_format($repuestoAprobado->getDescuentoTotal($repuestoAprobado->getFechaRegistroCarbon(),true, $repuestoAprobado->descuento_unitario ?? 0, $repuestoAprobado->descuento_unitario_dealer ?? -1),2)}}</td>
            <td align="right">{{number_format($repuestoAprobado->getMontoVentaTotal($repuestoAprobado->getFechaRegistroCarbon(),true, $repuestoAprobado->descuento_unitario ?? 0, false, $repuestoAprobado->descuento_unitario_dealer ?? -1),2)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr align="center"><td colspan="5" style="border: none"></td>   <th>TOTAL</th>  <td align="right">{{$totalRepuestos}}</td></tr>
    </tfoot>
</table>
@endif

@if(count($listaServiciosTerceros) > 0)
<table class="all-bordered" style="width: 100%; margin-top: 50px">
    <thead>
        <tr><th class="rotulo-tabla" colspan="5">SERVICIOS ADICIONALES</td></tr>
        <tr>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>OS</th>
            <th>Descuento</th>
            <th>Precio Venta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listaServiciosTerceros as $serviciosTerceros)
        <tr align="center">
            <td>{{$serviciosTerceros->getCodigoServicioTercero()}}</td>
            <td>{{$serviciosTerceros->getDescripcion()}}</td>
            <td>{{$serviciosTerceros->obtenerOrdenServicio()}}</td>
            @if(false) <td align="right">{{$serviciosTerceros->getPrecioListaUnitario($monedaCalculo)}}</td> @endif
            <td align="right">{{$serviciosTerceros->getDescuento($monedaCalculo)}}</td>
            <td align="right">{{$serviciosTerceros->getPrecioVenta($monedaCalculo)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr align="center"> <td colspan="3" style="border: none"></td>  <th>TOTAL</th>  <td align="right">{{$totalServiciosTerceros}}</td></tr>
    </tfoot>
</table>
@endif

@if(false)
<table class="all-bordered" style="width: 100%; margin-top: 50px">
    <tr>
        <td style="width: 45%; border: none"></td>
        <th style="width: 30%;">TOTAL LIQUIDACION</th>
        <th>{{$moneda_simbolo}}</th>
        <th align="right">{{$subtotal}}</th>
    </tr>
</table>
@endif
@if(isset($deducible) && $seguro != 'PARTICULAR' && $seguro != '' && $seguro != '-')
    <table class="all-bordered" style="width: 45%;  margin-top: 50px">
        <tr align="center">
            <th>Deducible (Incluye IGV)</th>
            <td>{{$deducible}}</td>
        </tr>
    </table>
    </body>
@endif


<table class="all-bordered" style="width: 100%;  margin-top: 50px">
    <tr align="center">
        <th>Valor Venta {{$moneda_simbolo}}</th>        
        <td>{{number_format($hojaTrabajo->recepcionOT->getMontoConSinDescuento()/1.18,2)}}</td>
        <th>I.G.V {{$moneda_simbolo}}</th>
        <td>{{number_format(($hojaTrabajo->recepcionOT->getMontoConSinDescuento()/1.18)*0.18,2)}}</td>
        <th>Precio Venta {{$moneda_simbolo}}</th>
        <td>{{number_format($hojaTrabajo->recepcionOT->getMontoConSinDescuento(),2)}}</td>         
    </tr>
</table>
</body>