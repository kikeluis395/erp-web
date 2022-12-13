<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="format-detection" content="telephone=no"> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

<title>Page title</title>

<style>
	.icono{
		font-size: 20px;
		font-weight: 5px;
		color: white;
	}
	.cuadrado{
		width: 30px;
		height: 30px;
		border-width: 2px;
		border-style: solid;
		border-color: gray;
	}
	.recta{
		/*margin-left: 12px;/* width_cuadrado/2 - width_recta/2 */
		height: 100px;
		width: 6px;
	}
	.recta-peque{
		/*margin-left: 12px;/* width_cuadrado/2 - width_recta/2 */
		height: 40px;
	}
	.recta-peque-ulti{
		height: 40px;
		background: transparent !important;
	}
	.completo{
		background-color: green;
	}
    .incompleto{
		background-color: gray;
	}
	.texto{
		color:#FFFFFF;
		font-size:23px;
		padding-left: 25px;
	}
	.link-button { 
		background: none;
		border: none;
		color: #0066ff;
		text-decoration: underline;
		cursor: pointer;
	}

	@import url(http://fonts.googleapis.com/css?family=Roboto:300); /*Calling our web font*/

	/* Some resets and issue fixes */
	#outlook a { padding:0; }
	body{ width:100% !important;-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; }
	.ReadMsgBody { width: 100%; }
	.ExternalClass {width:100%;}
	.backgroundTable {margin:0 auto; padding:0; width:100% !important;}
	table td {border-collapse: collapse;}
	.ExternalClass * {line-height: 115%;}
	/* End reset */


	/* These are our tablet/medium screen media queries */
	@media screen and (max-width: 630px){
		.texto{
			color:#FFFFFF;
			font-size:20px;
			padding-left: 25px;
		}
		.recta-peque{
			/*margin-left: 12px;/* width_cuadrado/2 - width_recta/2 */
			height: 85px;
		}
		.recta-peque-ulti{
			height: 85px;
			background: transparent !important;
		}
		/* Display block allows us to stack elements */                      
		*[class="mobile-column"] {display: block;} 

		/* Some more stacking elements */
		*[class="mob-column"] {float: none !important;width: 100% !important;}     

		/* Hide stuff */
		*[class="hide"] {display:none !important;}          

		/* This sets elements to 100% width and fixes the height issues too, a god send */
		*[class="100p"] {width:100% !important; height:auto !important;}                    

		/* For the 2x2 stack */         
		*[class="condensed"] {padding-bottom:40px !important; display: block;}

		/* Centers content on mobile */
		*[class="center"] {text-align:center !important; width:100% !important; height:auto !important;}            

		/* 100percent width section with 20px padding */
		*[class="100pad"] {width:100% !important; padding:20px;} 

		/* 100percent width section with 20px padding left & right */
		*[class="100padleftright"] {width:100% !important; padding:0 20px 0 20px;} 

		/* 100percent width section with 20px padding top & bottom */
		*[class="100padtopbottom"] {width:100% !important; padding:20px 0px 20px 0px;}
	}
</style>


</head>

<body style="padding:0; margin:0">

<table width="640" cellspacing="0" cellpadding="0" bgcolor="#" class="100p">
	<tr>
		<td bgcolor="#3b464e" width="640" valign="top" class="100p">
			<!--[if gte mso 9]>
			<v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;">
				<v:fill type="tile" color="#3b464e" />
				<v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
					<![endif]-->
					<div>
						<table width="640" border="0" cellspacing="0" cellpadding="20" class="100p">
							<tr>
								<td valign="top">
									<table border="0" cellspacing="0" cellpadding="0" width="600" class="100p">
										<tr>
											<td align="center">
												<div class="cuadrado completo"><span class="icono">&#10003;</span></div>
												<div class="recta recta-peque completo"></div>
											</td>
											<td align="left" class="texto">
                                                @if($fecIngreso)
                                                <div>Se registró el ingreso de tu unidad el día <br>{{$fecIngreso}}@if($horaIngreso) a las {{$horaIngreso}}@endif</div>
                                                @endif

											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecIngreso)
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
                                        </tr>
                                        @if(!$esParticular)
										<tr>
											<td align="center">
                                                @if($fecAprSeguro)
												<div class="cuadrado completo"><span class="icono">&#10003;</span></div>
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="cuadrado"></div>
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
											<td align="left" class="texto">
                                                @if($fecAprSeguro)
                                                <div>Tu vehículo fue aprobado por el seguro el día <br>{{$fecAprSeguro}}@if($horaAprSeguro) a las {{$horaAprSeguro}}@endif</div>
                                                @else
                                                <div>Aprobación por seguro pendiente</div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecAprSeguro)
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
                                        </tr>
                                        @endif
										<tr>
											<td align="center">
                                                @if($fecAprCliente)
												<div class="cuadrado completo"><span class="icono">&#10003;</span></div>
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="cuadrado"></div>
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
											<td align="left" class="texto">
                                                @if($fecAprCliente)
                                                <div>Se registró tu aprobación el día <br>{{$fecAprCliente}}@if($horaAprCliente) a las {{$horaAprCliente}}@endif</div>
                                                @else
                                                <div>Aprobación pendiente</div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecAprCliente)
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecIniRep)
												<div class="cuadrado completo"><span class="icono">&#10003;</span></div>
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="cuadrado"></div>
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
											<td align="left" class="texto">
                                                @if($fecIniRep)
                                                <div>Tu vehículo inició el proceso de reparación el día <br>{{$fecIniRep}}@if($horaIniRep) a las {{$horaIniRep}}@endif</div>
                                                @else
                                                <div>Inicio de reparación pendiente</div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecIniRep)
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecVehListo)
												<div class="cuadrado completo"><span class="icono">&#10003;</span></div>
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="cuadrado"></div>
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
											<td align="left" class="texto">
                                                @if($fecVehListo)
                                                <div>Tu vehículo se encuentra listo. Pronto nos estaremos comunicando contigo.</div>
                                                @else
                                                <div>Fin de operación pendiente</div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecVehListo)
                                                <div class="recta recta-peque completo"></div>
                                                @else
                                                <div class="recta recta-peque incompleto"></div>
                                                @endif
											</td>
										</tr>
										<tr>
											<td align="center">
                                                @if($fecEntrega)
                                                <div class="recta recta-peque completo"></div>
                                                <div class="cuadrado completo"><span class="icono">&#10003;</span></div>
                                                @else
                                                <div class="recta recta-peque incompleto"></div>
                                                <div class="cuadrado"></div>
                                                @endif
												<div class="recta recta-peque-ulti"></div>
											</td>
											<td align="left" class="texto">
                                                @if($fecEntrega)
                                                <div>Se registró la entrega de tu unidad el día <br>{{$fecEntrega}}@if($horaEntrega) a las {{$horaEntrega}}@endif</div>
                                                @else
                                                <div>Entrega pendiente</div>
                                                @endif
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<!--[if gte mso 9]>
				</v:textbox>
			</v:rect>
			<![endif]-->
		</td>
	</tr>
</table>
@if($showLink)
	@if(false)
	<form action="/emailTracking" method="GET">
		<input type="hidden" name="ingdt"   value="{{$fecIngreso}}"/>
		<input type="hidden" name="inghr"   value="{{$horaIngreso}}"/>
		<input type="hidden" name="ispart"  value="{{$esParticular}}"/>
		<input type="hidden" name="apsegdt" value="{{$fecAprSeguro}}"/>
		<input type="hidden" name="apseghr" value="{{$horaAprSeguro}}"/>
		<input type="hidden" name="apclidt" value="{{$fecAprCliente}}"/>
		<input type="hidden" name="apclihr" value="{{$horaAprCliente}}"/>
		<input type="hidden" name="inrepdt" value="{{$fecIniRep}}"/>
		<input type="hidden" name="inrephr" value="{{$horaIniRep}}"/>
		<input type="hidden" name="velisdt" value="{{$fecVehListo}}"/>
		<input type="hidden" name="velishr" value=""/>
		<input type="hidden" name="envehdt" value="{{$fecEntrega}}"/>
		<input type="hidden" name="envehhr" value="{{$horaEntrega}}"/>
		¿No puedes visualizar el correo correctamente? Haz click <input type="submit" class="link-button" value="aquí"/>
	</form>
	@endif
	<br>¿No puedes visualizar el correo correctamente? Haz click <a href="{{route('emailTracking.show',['ingdt'=>$fecIngreso, 'inghr'=>$horaIngreso, 'ispart'=>$esParticular, 'apsegdt'=>$fecAprSeguro, 'apseghr'=>$horaAprSeguro, 'apclidt'=>$fecAprCliente, 'apclihr'=>$horaAprCliente, 'inrepdt'=>$fecIniRep, 'inrephr'=>$horaIniRep, 'velisdt'=>$fecVehListo, 'velishr'=>'', 'envehdt'=>$fecEntrega, 'envehhr'=>$horaEntrega])}}">aquí</a>
	<br>
@endif 
	
</body>
</html>

