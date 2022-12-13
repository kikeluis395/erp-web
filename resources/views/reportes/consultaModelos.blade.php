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
@section('titulo','Reporte Seguimiento Modelos') 

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Reporte - Seguimiento Modelos</h2>
  </div>
  
    <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.consulta.reporteModelos')}}" value="search">
    <div class="row">
	    <div class="form-group col-md-2">
			<label for="local_tIn" class="col-form-label">Local:</label>
			<select name="local_t" id="local_tIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_t" required="">
			@foreach($locales as $local)
			<option value="{{ $local->id_local }}" {{ isset(request()->local_t) && request()->local_t == $local->id_local ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
			@endforeach
			</select>
			<div id="errorlocal_t" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
		</div>
				
		<div class="col-md-2">
			<label for="anio_ot" class="col-form-label">Año:</label>
			<select name="anio_ot" id="anio_ot_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#erroranio_ot_ot" required="">
			    <option value="2021" {{ isset(request()->anio_ot) && request()->anio_ot == '2021' ? 'selected' : '' }}>2021</option>
                <option value="2022" {{ isset(request()->anio_ot) && request()->anio_ot == '2022' ? 'selected' : '' }}>2022</option>
                <option value="2023" {{ isset(request()->anio_ot) && request()->anio_ot == '2023' ? 'selected' : '' }}>2023</option>
                <option value="2024" {{ isset(request()->anio_ot) && request()->anio_ot == '2024' ? 'selected' : '' }}>2024</option>
			</select>
			<div id="erroranio_ot_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
		</div>
		
		<div class="col-md-2">
			<label for="ano" class="col-form-label">Moneda:</label>
			<select name="moneda" id="moneda" class="form-control" required>
			  <option value="SOLES">Soles</option>
			  <option value="DOLARES">Dolares</option>
			</select>
			<div id="erroranio_ot_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
		</div>

		<div class="col-md-4" style="top: 10px!important; margin-right: -10%;">
			<span class="font-weight-bold letra-rotulo-detalle text-left">Sección una | ambas</span>            
			<div class="row">	
				<div class="col-md-6">
					<div class="form-check">
						<input type="checkbox" name="seccion_1" id="seccion_1" value="DYP" 
						{{count(request()->all()) == 0 ? 'checked' : (isset(request()->seccion_1) && request()->seccion_1 == 'DYP' ? 'checked' : '')}}>
						<label class="form-check-label" for="seccion_1">Carrocería y Pintura</label>  
					</div>
					
					<div class="form-check">
						<input type="checkbox" name="seccion_2" id="seccion_2" value="PREVENTIVO" 
						{{count(request()->all()) == 0 ? 'checked' : (isset(request()->seccion_2) && request()->seccion_2 == 'PREVENTIVO' ? 'checked' : '')}}>
						<label class="form-check-label" for="seccion_2">Mecánica</label> 
					</div>	
				</div>				
			</div>
		</div>

	    <div class="col-md-2" id="proyeccion" style="top: 34px!important; margin-left: -8%;">
		  <span class="font-weight-bold letra-rotulo-detalle text-left">Proyección</span> 
		  <div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" name="proyeccion" id="customSwitchRealPro">
			<label class="custom-control-label"  for="customSwitchRealPro"><div id = "customSwitchRealProText" name="customSwitchRealProText"></div></label>
		  </div>
		</div>	
		
		<div class="col-md-1">
			<label class="col-form-label" style="position: relative; margin-bottom: 25px;"></label>
			<button type="submit" class="btn btn-primary">Generar</button>
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

@if(isset($cantModelOts))
<div class="mt-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true"><b>OT's</b></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false"><b>FACTURACIÓN</b></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                aria-selected="false"><b>TICKET</b></a>
        </li>
    </ul>
	
    <div class="tab-content" id="myTabContent">
        <div class="p-2 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table text-center table-striped table-sm">
                <thead>
				    <tr>
						<th scope="col" align="left" style="color: #856404;">DÍAS TRANSCURRIDOS</th>
						@for ($i = 1; $i <= 12; $i++)
						@php
							$diasutiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_ot, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_ot, $i)) 
						@endphp
						<th style="color: #856404;">
						{{$diasutiles}}
						</th>
						@endfor
					</tr>

					<tr>
						<th scope="col" align="left" style="color: #856404;">DÍAS HÁBILES</th>
						@for ($i = 1; $i <= 12; $i++)
						@php
							$diashabiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_ot), App\Helper\Helper::getFeriados($anio_ot, $i))
						@endphp
						<th style="color: #856404;">
						{{$diashabiles}} 
						</th>
						@endfor
					</tr>
						
					<tr class="alert alert-primary">
						<th scope="col" style="background-color: #e9e9e9;">OT´S</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color: #e9e9e9; background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>
					</tr>
				</thead>

				<tbody>
				@if(count($cantModelOts))
					@foreach($cantModelOts as $listcantmodelots)
						<tr>
							<td style="vertical-align: middle;"><b>{{$listcantmodelots->MODELO}}</b></td>
							<td style="vertical-align: middle; background-color:{{$color1}}">{{$listcantmodelots->ENE}}</td>
							<td style="vertical-align: middle; background-color:{{$color2}}">{{$listcantmodelots->FEB}}</td>
							<td style="vertical-align: middle; background-color:{{$color3}}">{{$listcantmodelots->MAR}}</td>
							<td style="vertical-align: middle; background-color:{{$color4}}">{{$listcantmodelots->ABR}}</td>
							<td style="vertical-align: middle; background-color:{{$color5}}">{{$listcantmodelots->MAY}}</td>
							<td style="vertical-align: middle; background-color:{{$color6}}">{{$listcantmodelots->JUN}}</td>
							<td style="vertical-align: middle; background-color:{{$color7}}">{{$listcantmodelots->JUL}}</td>
							<td style="vertical-align: middle; background-color:{{$color8}}">{{$listcantmodelots->AGO}}</td>
							<td style="vertical-align: middle; background-color:{{$color9}}">{{$listcantmodelots->SEP}}</td>
							<td style="vertical-align: middle; background-color:{{$color10}}">{{$listcantmodelots->OCT}}</td>
							<td style="vertical-align: middle; background-color:{{$color11}}">{{$listcantmodelots->NOV}}</td>
							<td style="vertical-align: middle; background-color:{{$color12}}">{{$listcantmodelots->DIC}}</td>
						</tr>
					@endforeach
					
	
						<tr>
							<td style="vertical-align: middle;"><b>OTROS</b></td>
							<td style="vertical-align: middle; background-color:{{$color1}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color2}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color3}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color4}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color5}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color6}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color7}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color8}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color9}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color10}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color11}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color12}}"><b></b></td>
						</tr>

					
					
						<tr>
							<td style="vertical-align: middle;"><b>TOTAL</b></td>
							<td style="vertical-align: middle; background-color:{{$color1}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color2}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color3}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color4}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color5}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color6}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color7}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color8}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color9}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color10}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color11}}"><b></b></td>
							<td style="vertical-align: middle; background-color:{{$color12}}"><b></b></td>
						</tr>
					
					
					@else
					<tr>
						<td align="center" scope="col" colspan=12 class="mensajeError"><strong>No se encontraron resultados</strong></td>
					</tr>
				@endif
				</tbody>
            </table>
        </div>
		
        <div class="p-2 tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table class="table text-center table-striped table-sm">
				<tr>
					<th scope="col" align="left" style="color: #856404;">DÍAS TRANSCURRIDOS</th>
					@for ($i = 1; $i <= 12; $i++)
					@php
						$diasutiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_ot, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_ot, $i)) 
					@endphp
					<th style="color: #856404;">
					{{$diasutiles}}
					</th>
					@endfor
				</tr>

				<tr>
					<th scope="col" align="left" style="color: #856404;">DÍAS HÁBILES</th>
					@for ($i = 1; $i <= 12; $i++)
					@php
						$diashabiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_ot), App\Helper\Helper::getFeriados($anio_ot, $i))
					@endphp
					<th style="color: #856404;">
					{{$diashabiles}} 
					</th>
					@endfor
				</tr>

                <tr class="alert alert-primary">
					<th scope="col" style="background-color: #e9e9e9;">FACTURACIÓN</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>
				</tr>				
			</table>
        </div>
		
        <div class="p-2 tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <table class="table text-center table-striped table-sm">
                <tr>
					<th scope="col" align="left" style="color: #856404;">DÍAS TRANSCURRIDOS</th>
					@for ($i = 1; $i <= 12; $i++)
					@php
						$diasutiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-".App\Helper\Helper::getDayForDiasHabiles($anio_ot, $anio_actual, $i, $mes_actual, $dia_actual) , App\Helper\Helper::getFeriados($anio_ot, $i)) 
					@endphp
					<th style="color: #856404;">
					{{$diasutiles}}
					</th>
					@endfor
				</tr>

				<tr>
					<th scope="col" align="left" style="color: #856404;">DÍAS HÁBILES</th>
					@for ($i = 1; $i <= 12; $i++)
					@php
						$diashabiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-".cal_days_in_month(CAL_GREGORIAN, $i, $anio_ot), App\Helper\Helper::getFeriados($anio_ot, $i))
					@endphp
					<th style="color: #856404;">
					{{$diashabiles}} 
					</th>
					@endfor
				</tr>

                <tr class="alert alert-primary">
					<th scope="col" style="background-color: #e9e9e9;">TICKET</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
					<th scope="col" style="background-color: #e9e9e9; background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>
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
    @endif
</div>
@endsection