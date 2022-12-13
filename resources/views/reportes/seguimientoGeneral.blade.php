<style>
.nav-tabs {
    border-bottom: 1px solid #dee2e6;
    background: #435d7d;
}

.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #495057;
    background-color: #d9edff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.nav-tabs .nav-link {
    color: white;
	border: solid 1px;
}
</style>

@extends('contabilidadv2.layoutCont')
@section('titulo','Consulta Reporte Seguimiento General') 

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Seguimiento General</h2>
  </div>
  
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.seguimientoGeneral')}}" value="search">
        <input type="hidden" name="pestania" id="pestania" value="1">
    <div class="row">
		<div class="col-md-2">
			<label for="anio" class="col-form-label">Año:</label>
			<select name="anio" id="anio_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#erroranio_ot" required="">
			    <option value="2021" {{ isset(request()->anio) && request()->anio == '2021' ? 'selected' : '' }}>2021</option>
                <option value="2022" {{ isset(request()->anio) && request()->anio == '2022' ? 'selected' : '' }}>2022</option>
                <option value="2023" {{ isset(request()->anio) && request()->anio == '2023' ? 'selected' : '' }}>2023</option>
                <option value="2024" {{ isset(request()->anio) && request()->anio == '2024' ? 'selected' : '' }}>2024</option>
			</select>
			<div id="erroranio_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
		</div>
		
		<div class="col-md-2">
			<label for="moneda" class="col-form-label">Moneda:</label>
			<select name="moneda" id="anio" class="form-control">
                <option value="dolares" {{ isset(request()->moneda) && request()->moneda == 'dolares' ? 'selected' : '' }}>
					Dólares</option>
				<option value="soles" {{ isset(request()->moneda) && request()->moneda == 'soles' ? 'selected' : '' }}>Soles
				</option>				
			</select>
		</div>

		<div class="col-md-4" style="top: 10px!important;">
			<span class="font-weight-bold letra-rotulo-detalle text-left">Sección una | ambas</span>            
			<div class="row">	
				<div class="col-md-6">
					<div class="form-check">
						<input type="checkbox" name="byp" id="byp" value="DYP" 
						{{ count(request()->all()) == 0 ? 'checked' : (isset(request()->byp) && request()->byp == 'DYP' ? 'checked' :  '') }}>
						<label class="form-check-label" for="byp">Carrocería y Pintura</label>  
					</div>
					
					<div class="form-check">
						<input type="checkbox" name="mec" id="mec" value="PREVENTIVO" 
						{{ count(request()->all()) == 0 ? 'checked' : (isset(request()->mec) && request()->mec == 'PREVENTIVO' ? 'checked' :  '') }}>
						<label class="form-check-label" for="mec">Mecánica</label> 
					</div>	

                    <div class="form-check d-none" id="chk_meson">
                        <input type="checkbox" name="meson" id="meson" value="meson" 
                        {{ count(request()->all()) == 0 ? 'checked' : (isset(request()->meson) && request()->meson == 'meson' ? 'checked' :  '') }}>
                        <label class="form-check-label" for="meson">Mesón</label>
                    </div>
				</div>				
				
				{{-- <div class="d-none" id="chk_meson">
					<div class="col-md-4 desplegable" style="margin-top: 5.5%;">
						<div class="form-check">
							<input type="checkbox" name="meson" id="meson" value="meson" 
							{{ count(request()->all()) == 0 ? 'checked' : (isset(request()->meson) && request()->meson == 'meson' ? 'checked' :  '') }}>
							<label class="form-check-label" for="meson">Mesón</label>
						</div>
					</div>
				</div> --}}
			</div>
		</div>

	    <div class="col-md-3" id="proyeccion" style="top: 34px!important; margin-right: -70px; margin-left: -8%;">
		  <span class="font-weight-bold letra-rotulo-detalle text-left">Proyección</span> 
		  <div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" name="proyeccion" id="customSwitchRealPro" {{ $proyeccion ? 'checked' : '' }}>
			<label class="custom-control-label"  for="customSwitchRealPro"> <div id = "customSwitchRealProText" name="customSwitchRealProText" >{{ $proyeccion ? 'PROYECTADO' : 'REAL' }}</div>  </label>
		  </div>
		</div>	
		
		<div class="col-md-1" style="margin: auto 0; ">			
			<button type="submit" class="btn btn-primary">Buscar</button>
		</div>				
	</div>
    </form>
</div>

@php
    $mes_actual = \Carbon\Carbon::now()->format('m');
	
	$color1 = ''; $color2 = ''; $color3 = ''; $color4 = ''; $color5 = ''; $color6 = ''; $color7 = ''; $color8 = ''; $color9 = '';
	$color10 = ''; $color11 = ''; $color12 = '';

    if($mes_actual == '01'){
	   $color1 = '#91f1fb!important';
	}

	if($mes_actual == '02'){
	   $color2 = '#91f1fb!important';
	}

	if($mes_actual == '03'){
	   $color3 = '#91f1fb!important';
	}

	if($mes_actual == '04'){
	   $color4 = '#91f1fb!important';
	}

	if($mes_actual == '05'){
	   $color5 = '#91f1fb!important';
	}

	if($mes_actual == '06'){
	   $color6 = '#91f1fb!important';
	}

	if($mes_actual == '07'){
	   $color7 = '#91f1fb!important';
	}

	if($mes_actual == '08'){
	   $color8 = '#91f1fb!important';
	}

	if($mes_actual == '09'){
	   $color9 = '#91f1fb!important';
	}

	if($mes_actual == '10'){
	   $color10 = '#91f1fb!important';
	}

	if($mes_actual == '11'){
	   $color11 = '#91f1fb!important';
	}

	if($mes_actual == '12'){
	   $color12 = '#91f1fb!important';
	}	
@endphp
  
<div class="mt-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ isset(request()->pestania) && request()->pestania == '1' ? 'active' : (!isset(request()->pestania) ? 'active' : '') }}" onclick="$('#chk_meson').addClass('d-none'); $('#pestania').val('1')" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true"><b>ÓRDENES DE TRABAJO</b></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ isset(request()->pestania) && request()->pestania == '2' ? 'active' : '' }}" onclick="$('#chk_meson').removeClass('d-none'); $('#pestania').val('2')" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false"><b>FACTURACIÓN</b></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ isset(request()->pestania) && request()->pestania == '3' ? 'active' : '' }}" onclick="$('#chk_meson').addClass('d-none'); $('#pestania').val('3')" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                aria-selected="false"><b>TICKET PROMEDIO</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '1' ? 'show active' : (!isset(request()->pestania) ? 'show active' : '') }}" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table text-center table-striped table-sm">
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold;">DÍAS TRANSCURRIDOS</td>
                    @for ($i = 1; $i <= 12; $i++)
                    <td style="color: #a57b02; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
                    @endfor
                </tr>
				
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold;">DÍAS HÁBILES</td>
                    @for ($i = 1; $i <= 12; $i++)
                    <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_filtro), App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
                    @endfor
                </tr>
				
                <tr class="alert alert-primary">
                    <th align="left" style="background-color: #e9e9e9;">TALLER</th>
                    @for ($i = 1; $i <= 12; $i++)
                    <th style="background-color: #e9e9e9;">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
                    @endfor
                </tr>
				
                <tr>
                    <td>Los Olivos</td>                                      
                    @for ($i = 1; $i <= 12; $i++)
                    @php $validador = true @endphp  
                        @foreach ($ordenes_trabajo as $orden_trabajo)
                            @if ($i == $orden_trabajo->mes)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="orden_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? number_format(($orden_trabajo->total/$diasUtiles)*$diasTotales, 0) : $orden_trabajo->total }}
                            </td> 
                          
                            @php $validador = false @endphp    
                            @endif                            
                        @endforeach
                        @if ($validador)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="orden_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
                            </td>
                        @endif
                    @endfor
                </tr>
            </table>
        </div>
		
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '2' ? 'show active' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table class="table text-center table-striped table-sm">
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold;">DÍAS TRANSCURRIDOS</td>
                    <td align="left" style="color: #856404; font-weight: bold;"></td>
                    @for ($i = 1; $i <= 12; $i++)
                    <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
                    @endfor
                </tr>
				
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold;">DÍAS HÁBILES</td>
                    <td align="left" style="color: #856404; font-weight: bold;"></td>
                    @for ($i = 1; $i <= 12; $i++)
                    <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_filtro), App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
                    @endfor
                </tr>
				
                <tr class="alert alert-primary">
                    <th align="left" style="background-color: #e9e9e9;">TALLER</th>
                    <th align="left" style="background-color: #e9e9e9;"></th>
                    @for ($i = 1; $i <= 12; $i++)
                    <th style="background-color: #e9e9e9;">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
                    @endfor
                </tr>
				
                <tr>
                    <td rowspan="5">Los Olivos</td>  
                </tr>
                <tr>
                    <td>VENTA</td>
                    @for ($i = 1; $i <= 12; $i++)
                    @php $validador = true @endphp  
                        @foreach ($facturacion as $factura)
                            @if ($i == $factura->mes)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->soles/$diasUtiles)*$diasTotales : $factura->soles) : 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->dolares/$diasUtiles)*$diasTotales : $factura->dolares), 0, '.', ',') }}
                            </td>                        
                            @php $validador = false @endphp    
                            @endif                            
                        @endforeach
                        @if ($validador)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
                            </td>                        
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td>COSTO</td>
                    @for ($i = 1; $i <= 12; $i++)
                    @php $validador = true @endphp  
                        @foreach ($facturacion as $factura)
                            @if ($i == $factura->mes)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->soles/$diasUtiles)*$diasTotales : $factura->soles) - 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_soles/$diasUtiles)*$diasTotales : $factura->margen_soles) : 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->dolares/$diasUtiles)*$diasTotales : $factura->dolares) - 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_dolares/$diasUtiles)*$diasTotales : $factura->margen_dolares), 0, '.', ',') }}
                            </td>                        
                            @php $validador = false @endphp    
                            @endif                            
                        @endforeach
                        @if ($validador)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
                            </td>                        
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td>UTILIDAD</td>
                    @for ($i = 1; $i <= 12; $i++)
                    @php $validador = true @endphp  
                        @foreach ($facturacion as $factura)
                            @if ($i == $factura->mes)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_soles/$diasUtiles)*$diasTotales : $factura->margen_soles) : 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_dolares/$diasUtiles)*$diasTotales : $factura->margen_dolares), 0, '.', ',') }}
                            </td>                        
                            @php $validador = false @endphp    
                            @endif                            
                        @endforeach
                        @if ($validador)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
                            </td>                        
                        @endif
                    @endfor
                </tr>
                <tr>
                    <td>MARGEN %</td>
                    @for ($i = 1; $i <= 12; $i++)
                    @php $validador = true @endphp  
                        @foreach ($facturacion as $factura)
                            @if ($i == $factura->mes)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ number_format($moneda == 'soles' ? 
                                (($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_soles/$diasUtiles)*$diasTotales : $factura->margen_soles) /
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->soles/$diasUtiles)*$diasTotales : $factura->soles))*100: 
                                (($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->margen_dolares/$diasUtiles)*$diasTotales : $factura->margen_dolares) /
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? ($factura->dolares/$diasUtiles)*$diasTotales : $factura->dolares))*100, 0, '.', '') }}%
                            </td>                        
                            @php $validador = false @endphp    
                            @endif                            
                        @endforeach
                        @if ($validador)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="facturacion_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}%
                            </td>                        
                        @endif
                    @endfor
                </tr>           

            </table>
        </div>
		
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '3' ? 'show active' : '' }}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <table class="table text-center table-striped table-sm">
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold;">DÍAS TRANSCURRIDOS</td>
                    @for ($i = 1; $i <= 12; $i++)
                    <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_filtro, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
                    @endfor
                </tr>
				
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold;">DÍAS HÁBILES</td>
                    @for ($i = 1; $i <= 12; $i++)
                    <td style="color: #856404; font-weight: bold;">{{ App\Helper\Helper::getDiasHabiles("$anio_filtro-$i-01", "$anio_filtro-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_filtro), App\Helper\Helper::getFeriados($anio_filtro, $i)) }}</td>
                    @endfor
                </tr>
				
                <tr class="alert alert-primary">
                    <th align="left" style="background-color: #e9e9e9;">TALLER</th>
                    @for ($i = 1; $i <= 12; $i++)
                    <th style="background-color: #e9e9e9;">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
                    @endfor
                </tr>
                <tr>
                    <td>Los Olivos</td>                                      
                    @for ($i = 1; $i <= 12; $i++)
                    @php $validador = true @endphp  
                        @foreach ($tickets as $ticket)
                            @if ($i == $ticket->mes)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="ticket_id" @endif>
                                {{ $simbolo }}{{ number_format($moneda == 'soles' ? 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (($ticket->soles/$diasUtiles)*$diasTotales) / (($ticket->total_ot/$diasUtiles)*$diasTotales) : $ticket->soles / $ticket->total_ot) : 
                                ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (($ticket->dolares/$diasUtiles)*$diasTotales) / (($ticket->total_ot/$diasUtiles)*$diasTotales) : $ticket->dolares / $ticket->total_ot), 0, '.', '') }}
                            </td>                            
                            @php $validador = false @endphp    
                            @endif                            
                        @endforeach
                        @if ($validador)
                            <td @if ($i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion) class="text-danger" id="ticket_id" @endif>
                                {{ $i == $mes_actual && $anio_filtro == $anio_actual && $proyeccion ? (0/$diasUtiles)*$diasTotales : 0 }}
                            </td>
                        @endif
                    @endfor
                </tr>
            </table>
        </div>
    </div>  
	
	@if(isset($ordenes_trabajo))		
	<div class="alert alert-primary" role="alert" align="center">
		<h5>Información actualizada al {{\Carbon\Carbon::now()->format('d/m/Y')}} a las {{\Carbon\Carbon::now()->format('h:i A')}}</h5>
	</div>
	@endif
		
  </div>
</div>
@endsection