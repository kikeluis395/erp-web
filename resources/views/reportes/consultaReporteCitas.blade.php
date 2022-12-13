<style>
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #eaeaea!important;
}

.semaforo-rojo {
    width: 15px;
    height: 15px;
	background: red;
	border-radius: 50% !important;
}

.semaforo-ambar {
    width: 15px;
    height: 15px;
	background: yellow;
	border-radius: 50% !important;
}

.semaforo-verde {
    width: 15px;
    height: 15px;
	background: #0fbb0f;
	border-radius: 50% !important;
}
</style>

@extends('contabilidadv2.layoutCont')
@section('titulo','Reporte - Citas') 

@section('content')
<div style="background: white;padding: 10px">
	<div class="row justify-content-between col-12">
	    <h2>Reporte - Seguimiento Citas</h2>
	</div>

	<div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
		<form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.consulta.reporteCitas')}}" value="search">
			<div class="row">
				<div class="form-group col-md-2">
					<label for="local_otIn" class="col-form-label">Local:</label>
					<select name="local_ot" id="local_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_ot" required="">
					@foreach($locales as $local)
					<option value="{{ $local->id_local }}" {{ isset(request()->local_ot) && request()->local_ot == $local->id_local ? 'selected' : '' }}>{{ $local->nombre_local }}</option>
					@endforeach
					</select>
					<div id="errorlocal_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
				</div>
				
				<div class="col-md-2">
					<label for="anio_ot" class="col-form-label">Año:</label>
					<select name="anio_ot" id="anio_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#erroranio_ot" required="">
					    <option value="2021" {{ isset(request()->anio_ot) && request()->anio_ot == '2021' ? 'selected' : '' }}>2021</option>
						<option value="2022" {{ isset(request()->anio_ot) && request()->anio_ot == '2022' ? 'selected' : '' }}>2022</option>
						<option value="2023" {{ isset(request()->anio_ot) && request()->anio_ot == '2023' ? 'selected' : '' }}>2023</option>
						<option value="2024" {{ isset(request()->anio_ot) && request()->anio_ot == '2024' ? 'selected' : '' }}>2024</option>
					</select>
					<div id="erroranio_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
				</div>	

                <div class="col-md-1">
					<label class="col-form-label" style="position: relative; margin-bottom: 23.4px;"></label>
					<button type="submit" class="btn btn-primary">Generar</button>
                </div>				
			</div>
		</form>
	</div>
</div>

@php
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

@if(isset($CantCitAgen))
<div style="overflow-y:block;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
		<div class="table-wrapper">
			<div class="table-title" style="background-color: #f79f0b;">
				<div class="row col-12">
					<h2>TOTAL CITAS AGENDADAS</h2>
				</div>
			</div>
 			  
			<div class="table-cont-single mt-3">
			    <table class="table text-center table-striped table-sm">
				    <thead>
						<tr class="alert alert-primary">
							<th scope="col">USUARIO</th>
							<th scope="col" style="background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>
						</tr>
				    </thead>

					<tbody>
					@if(count($CantCitAgen))
						@foreach($CantCitAgen as $listcitagen)
							<tr>
								<td style="vertical-align: middle;"><b>{{$listcitagen->USUARIO}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color1}}">{{$listcitagen->ENE}}</td>
								<td style="vertical-align: middle; background-color:{{$color2}}">{{$listcitagen->FEB}}</td>
								<td style="vertical-align: middle; background-color:{{$color3}}">{{$listcitagen->MAR}}</td>
								<td style="vertical-align: middle; background-color:{{$color4}}">{{$listcitagen->ABR}}</td>
								<td style="vertical-align: middle; background-color:{{$color5}}">{{$listcitagen->MAY}}</td>
								<td style="vertical-align: middle; background-color:{{$color6}}">{{$listcitagen->JUN}}</td>
								<td style="vertical-align: middle; background-color:{{$color7}}">{{$listcitagen->JUL}}</td>
								<td style="vertical-align: middle; background-color:{{$color8}}">{{$listcitagen->AGO}}</td>
								<td style="vertical-align: middle; background-color:{{$color9}}">{{$listcitagen->SEP}}</td>
								<td style="vertical-align: middle; background-color:{{$color10}}">{{$listcitagen->OCT}}</td>
								<td style="vertical-align: middle; background-color:{{$color11}}">{{$listcitagen->NOV}}</td>
								<td style="vertical-align: middle; background-color:{{$color12}}">{{$listcitagen->DIC}}</td>
							</tr>
						@endforeach
						
						@foreach($CantCitAgenTotal as $listcitagentotal)
							<tr>
								<td style="vertical-align: middle;"><b>TOTAL</b></td>
								<td style="vertical-align: middle; background-color:{{$color1}}"><b>{{$listcitagentotal->T_ENE}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color2}}"><b>{{$listcitagentotal->T_FEB}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color3}}"><b>{{$listcitagentotal->T_MAR}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color4}}"><b>{{$listcitagentotal->T_ABR}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color5}}"><b>{{$listcitagentotal->T_MAY}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color6}}"><b>{{$listcitagentotal->T_JUN}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color7}}"><b>{{$listcitagentotal->T_JUL}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color8}}"><b>{{$listcitagentotal->T_AGO}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color9}}"><b>{{$listcitagentotal->T_SEP}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color10}}"><b>{{$listcitagentotal->T_OCT}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color11}}"><b>{{$listcitagentotal->T_NOV}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color12}}"><b>{{$listcitagentotal->T_DIC}}</b></td>
							</tr>
						@endforeach
						
						@else
						<tr>
							<td align="center" scope="col" colspan=12 class="mensajeError"><strong>No se encontraron resultados</strong></td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>
@endif 

<br>

@if(isset($CantCitAgenEfec))
<div style="overflow-y:block;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
		<div class="table-wrapper">
			<div class="table-title" style="background: #de1616!important;">
				<div class="row col-12">
					<h2>TOTAL CITAS AGENDADAS EFECTIVAS</h2>
				</div>
			</div>
 			  
			<div class="table-cont-single mt-3">
			    <table class="table text-center table-striped table-sm">
				    <thead>
						<tr class="alert alert-primary">
							<th scope="col">USUARIO</th>
							<th scope="col" style="background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>
						</tr>
				    </thead>
				
					<tbody>
					@if(count($CantCitAgenEfec))
						@foreach($CantCitAgenEfec as $listcitagenefec)
							<tr>
								<td style="vertical-align: middle;"><b>{{$listcitagenefec->USUARIO}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color1}}">{{$listcitagenefec->ENE}}</td>
								<td style="vertical-align: middle; background-color:{{$color2}}">{{$listcitagenefec->FEB}}</td>
								<td style="vertical-align: middle; background-color:{{$color3}}">{{$listcitagenefec->MAR}}</td>
								<td style="vertical-align: middle; background-color:{{$color4}}">{{$listcitagenefec->ABR}}</td>
								<td style="vertical-align: middle; background-color:{{$color5}}">{{$listcitagenefec->MAY}}</td>
								<td style="vertical-align: middle; background-color:{{$color6}}">{{$listcitagenefec->JUN}}</td>
								<td style="vertical-align: middle; background-color:{{$color7}}">{{$listcitagenefec->JUL}}</td>
								<td style="vertical-align: middle; background-color:{{$color8}}">{{$listcitagenefec->AGO}}</td>
								<td style="vertical-align: middle; background-color:{{$color9}}">{{$listcitagenefec->SEP}}</td>
								<td style="vertical-align: middle; background-color:{{$color10}}">{{$listcitagenefec->OCT}}</td>
								<td style="vertical-align: middle; background-color:{{$color11}}">{{$listcitagenefec->NOV}}</td>
								<td style="vertical-align: middle; background-color:{{$color12}}">{{$listcitagenefec->DIC}}</td>
							</tr>
						@endforeach
						
						@foreach($CantCitAgenEfecTotal as $listcitagenefectotal)
							<tr>
								<td style="vertical-align: middle;"><b>TOTAL</b></td>
								<td style="vertical-align: middle; background-color:{{$color1}}"><b>{{$listcitagenefectotal->T_ENE}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color2}}"><b>{{$listcitagenefectotal->T_FEB}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color3}}"><b>{{$listcitagenefectotal->T_MAR}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color4}}"><b>{{$listcitagenefectotal->T_ABR}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color5}}"><b>{{$listcitagenefectotal->T_MAY}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color6}}"><b>{{$listcitagenefectotal->T_JUN}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color7}}"><b>{{$listcitagenefectotal->T_JUL}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color8}}"><b>{{$listcitagenefectotal->T_AGO}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color9}}"><b>{{$listcitagenefectotal->T_SEP}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color10}}"><b>{{$listcitagenefectotal->T_OCT}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color11}}"><b>{{$listcitagenefectotal->T_NOV}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color12}}"><b>{{$listcitagenefectotal->T_DIC}}</b></td>
							</tr>
						@endforeach
					@else
						<tr>
							<td align="center" scope="col" colspan=12 class="mensajeError"><strong>No se encontraron resultados</strong></td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>
@endif

<br>

@if(isset($CantEfectividad))
<div style="overflow-y:block;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
		<div class="table-wrapper">
			<div class="table-title" style="background: #58b91c!important;">
				<div class="row col-12">
					<h2>% EFECTIVIDAD</h2>
				</div>
			</div>
 			  
			<div class="table-cont-single mt-3">
			    <table class="table text-center table-striped table-sm">
				    <thead>
					    <th scope="col">USUARIO</th>
						<th scope="col" style="background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
						<th scope="col" style="background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>
				    </thead>
				
					<tbody>
					@if(count($CantEfectividad))
						@foreach($CantEfectividad as $listefectividad)
							<tr>
								<td style="vertical-align: middle;"><b>{{$listefectividad->USUARIO}}</b></td>

								@php 
								    $efecMes1 = $listefectividad->EF_ENE == '' ? 0 : $listefectividad->EF_ENE;
								    $dato1 = number_format($efecMes1 * 100, 0, ",", ".")." %";
									
									if($dato1<80){
									   $clase1 = 'semaforo-rojo';
									}else if($dato1>=80 && $dato1<=90){
									   $clase1 = 'semaforo-ambar';
									}else if($dato1>90){
									   $clase1 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color1}}">
									<div class="{{$clase1}}"></div>
									<div style="margin-top: -28%; margin-left: 25%; background-color:{{$color1}}">{{$dato1}}</div>
								</td>
								
								@php 
								    $efecMes2 = $listefectividad->EF_FEB == '' ? 0 : $listefectividad->EF_FEB;
								    $dato2 = number_format($efecMes2 * 100, 0, ",", ".")." %";
									
									if($dato2<80){
									   $clase2 = 'semaforo-rojo';
									}else if($dato2>=80 && $dato2<=90){
									   $clase2 = 'semaforo-ambar';
									}else if($dato2>90){
									   $clase2 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color2}}">
									<div class="{{$clase2}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato2}}</div>
								</td>
								
								@php 
								    $efecMes3 = $listefectividad->EF_MAR == '' ? 0 : $listefectividad->EF_MAR;
								    $dato3 = number_format($efecMes3 * 100, 0, ",", ".")." %";
									
									if($dato3<80){
									   $clase3 = 'semaforo-rojo';
									}else if($dato3>=80 && $dato3<=90){
									   $clase3 = 'semaforo-ambar';
									}else if($dato3>90){
									   $clase3 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color3}}">
									<div class="{{$clase3}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato3}}</div>
								</td>
								
								@php 
								    $efecMes4 = $listefectividad->EF_ABR == '' ? 0 : $listefectividad->EF_ABR;
								    $dato4 = number_format($efecMes4 * 100, 0, ",", ".")." %";
									
									if($dato4<80){
									   $clase4 = 'semaforo-rojo';
									}else if($dato4>=80 && $dato4<=90){
									   $clase4 = 'semaforo-ambar';
									}else if($dato4>90){
									   $clase4 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color4}}">
									<div class="{{$clase4}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato4}}</div>
								</td>

								@php 
								    $efecMes5 = $listefectividad->EF_MAY == '' ? 0 : $listefectividad->EF_MAY;
								    $dato5 = number_format($efecMes5 * 100, 0, ",", ".")." %";
									
									if($dato5<80){
									   $clase5 = 'semaforo-rojo';
									}else if($dato5>=80 && $dato5<=90){
									   $clase5 = 'semaforo-ambar';
									}else if($dato5>90){
									   $clase5 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color5}}">
									<div class="{{$clase5}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato5}}</div>
								</td>
								
								@php 
								    $efecMes6 = $listefectividad->EF_JUN == '' ? 0 : $listefectividad->EF_JUN;
								    $dato6 = number_format($efecMes6 * 100, 0, ",", ".")." %";
									
									if($dato6<80){
									   $clase6 = 'semaforo-rojo';
									}else if($dato6>=80 && $dato6<=90){
									   $clase6 = 'semaforo-ambar';
									}else if($dato6>90){
									   $clase6 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color6}}">
									<div class="{{$clase6}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato6}}</div>
								</td>

								@php 
								    $efecMes7 = $listefectividad->EF_JUL == '' ? 0 : $listefectividad->EF_JUL;
								    $dato7 = number_format($efecMes7 * 100, 0, ",", ".")." %";
									
									if($dato7<80){
									   $clase7 = 'semaforo-rojo';
									}else if($dato7>=80 && $dato7<=90){
									   $clase7 = 'semaforo-ambar';
									}else if($dato7>90){
									   $clase7 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color7}}">
									<div class="{{$clase7}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato7}}</div>
								</td>
								
								@php 
								    $efecMes8 = $listefectividad->EF_AGO == '' ? 0 : $listefectividad->EF_AGO;
								    $dato8 = number_format($efecMes8 * 100, 0, ",", ".")." %";
									
									if($dato8<80){
									   $clase8 = 'semaforo-rojo';
									}else if($dato8>=80 && $dato8<=90){
									   $clase8 = 'semaforo-ambar';
									}else if($dato8>90){
									   $clase8 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color8}}">
									<div class="{{$clase8}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato8}}</div>
								</td>
								
								@php 
								    $efecMes9 = $listefectividad->EF_SEP == '' ? 0 : $listefectividad->EF_SEP;
								    $dato9 = number_format($efecMes9 * 100, 0, ",", ".")." %";
									
									if($dato9<80){
									   $clase9 = 'semaforo-rojo';
									}else if($dato9>=80 && $dato9<=90){
									   $clase9 = 'semaforo-ambar';
									}else if($dato9>90){
									   $clase9 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color9}}">
									<div class="{{$clase9}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato9}}</div>
								</td>
								
								@php 
								    $efecMes10 = $listefectividad->EF_OCT == '' ? 0 : $listefectividad->EF_OCT;
								    $dato10 = number_format($efecMes10 * 100, 0, ",", ".")." %";
									
									if($dato10<80){
									   $clase10 = 'semaforo-rojo';
									}else if($dato10>=80 && $dato10<=90){
									   $clase10 = 'semaforo-ambar';
									}else if($dato10>90){
									   $clase10 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color10}}">
									<div class="{{$clase10}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato10}}</div>
								</td>

								@php 
								    $efecMes11 = $listefectividad->EF_NOV == '' ? 0 : $listefectividad->EF_NOV;
								    $dato11 = number_format($efecMes11 * 100, 0, ",", ".")." %";
									
									if($dato11<80){
									   $clase11 = 'semaforo-rojo';
									}else if($dato11>=80 && $dato11<=90){
									   $clase11 = 'semaforo-ambar';
									}else if($dato11>90){
									   $clase11 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color11}}">
									<div class="{{$clase11}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato11}}</div>
								</td>
 
								@php 
								    $efecMes12 = $listefectividad->EF_DIC == '' ? 0 : $listefectividad->EF_DIC;
								    $dato12 = number_format($efecMes12 * 100, 0, ",", ".")." %";
									
									if($dato12<80){
									   $clase12 = 'semaforo-rojo';
									}else if($dato12>=80 && $dato12<=90){
									   $clase12 = 'semaforo-ambar';
									}else if($dato12>90){
									   $clase12 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color12}}">
									<div class="{{$clase12}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;">{{$dato12}}</div>
								</td>
							</tr>
						@endforeach
						
						@foreach($CantEfectividadTotal as $listefectividadtotal)
							<tr>
								<td style="vertical-align: middle;"><b>TOTAL</b></td>
								@php 
								    $efecMes1 = $listefectividadtotal->T_EF_ENE == '' ? 0 : $listefectividadtotal->T_EF_ENE; 
								    $dato1 = number_format($efecMes1 * 100, 0, ",", ".")." %";
									
									if($dato1<80){
									   $clase1 = 'semaforo-rojo';
									}else if($dato1>=80 && $dato1<=90){
									   $clase1 = 'semaforo-ambar';
									}else if($dato1>90){
									   $clase1 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color1}}">
									<div class="{{$clase1}}"></div>
									<div style="margin-top: -28%; margin-left: 25%; background-color:{{$color1}}"><b>{{$dato1}}</b></div>
								</td>
								
								@php 
								    $efecMes2 = $listefectividadtotal->T_EF_FEB == '' ? 0 : $listefectividadtotal->T_EF_FEB; 
								    $dato2 = number_format($efecMes2 * 100, 0, ",", ".")." %";
									
									if($dato2<80){
									   $clase2 = 'semaforo-rojo';
									}else if($dato2>=80 && $dato2<=90){
									   $clase2 = 'semaforo-ambar';
									}else if($dato2>90){
									   $clase2 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color2}}">
									<div class="{{$clase2}}"></div>
									<div style="margin-top: -28%; margin-left: 25%; background-color:{{$color2}}"><b>{{$dato2}}</b></div>
								</td>
								
								@php 
								    $efecMes3 = $listefectividadtotal->T_EF_MAR == '' ? 0 : $listefectividadtotal->T_EF_MAR; 
								    $dato3 = number_format($efecMes3 * 100, 0, ",", ".")." %";
									
									if($dato3<80){
									   $clase3 = 'semaforo-rojo';
									}else if($dato3>=80 && $dato3<=90){
									   $clase3 = 'semaforo-ambar';
									}else if($dato3>90){
									   $clase3 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color3}}">
									<div class="{{$clase3}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato3}}</b></div>
								</td>
								
								@php 
								    $efecMes4 = $listefectividadtotal->T_EF_ABR == '' ? 0 : $listefectividadtotal->T_EF_ABR; 
								    $dato4 = number_format($efecMes4 * 100, 0, ",", ".")." %";
									
									if($dato4<80){
									   $clase4 = 'semaforo-rojo';
									}else if($dato4>=80 && $dato4<=90){
									   $clase4 = 'semaforo-ambar';
									}else if($dato4>90){
									   $clase4 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color4}}">
									<div class="{{$clase4}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato4}}</b></div>
								</td>
								
								@php 
								    $efecMes5 = $listefectividadtotal->T_EF_MAY == '' ? 0 : $listefectividadtotal->T_EF_MAY; 
								    $dato5 = number_format($efecMes5 * 100, 0, ",", ".")." %";
									
									if($dato5<80){
									   $clase5 = 'semaforo-rojo';
									}else if($dato5>=80 && $dato5<=90){
									   $clase5 = 'semaforo-ambar';
									}else if($dato5>90){
									   $clase5 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color5}}">
									<div class="{{$clase5}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato5}}</b></div>
								</td>
 
								@php 
								    $efecMes6 = $listefectividadtotal->T_EF_JUN == '' ? 0 : $listefectividadtotal->T_EF_JUN; 
								    $dato6 = number_format($efecMes6 * 100, 0, ",", ".")." %";
									
									if($dato6<80){
									   $clase6 = 'semaforo-rojo';
									}else if($dato6>=80 && $dato6<=90){
									   $clase6 = 'semaforo-ambar';
									}else if($dato6>90){
									   $clase6 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color6}}">
									<div class="{{$clase6}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato6}}</b></div>
								</td>
								
								@php 
								    $efecMes7 = $listefectividadtotal->T_EF_JUL == '' ? 0 : $listefectividadtotal->T_EF_JUL; 
								    $dato7 = number_format($efecMes7 * 100, 0, ",", ".")." %";
									
									if($dato7<80){
									   $clase7 = 'semaforo-rojo';
									}else if($dato7>=80 && $dato7<=90){
									   $clase7 = 'semaforo-ambar';
									}else if($dato7>90){
									   $clase7 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color7}}">
									<div class="{{$clase7}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato7}}</b></div>
								</td>
								
								@php 
								    $efecMes8 = $listefectividadtotal->T_EF_AGO == '' ? 0 : $listefectividadtotal->T_EF_AGO; 
								    $dato8 = number_format($efecMes8 * 100, 0, ",", ".")." %";
									
									if($dato8<80){
									   $clase8 = 'semaforo-rojo';
									}else if($dato8>=80 && $dato8<=90){
									   $clase8 = 'semaforo-ambar';
									}else if($dato8>90){
									   $clase8 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color8}}">
									<div class="{{$clase8}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato8}}</b></div>
								</td>
								
								@php 
								    $efecMes9 = $listefectividadtotal->T_EF_SEP == '' ? 0 : $listefectividadtotal->T_EF_SEP; 
								    $dato9 = number_format($efecMes9 * 100, 0, ",", ".")." %";
									
									if($dato9<80){
									   $clase9 = 'semaforo-rojo';
									}else if($dato9>=80 && $dato9<=90){
									   $clase9 = 'semaforo-ambar';
									}else if($dato9>90){
									   $clase9 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color9}}">
									<div class="{{$clase9}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato9}}</b></div>
								</td>
								
								@php 
								    $efecMes10 = $listefectividadtotal->T_EF_OCT == '' ? 0 : $listefectividadtotal->T_EF_OCT;
								    $dato10 = number_format($efecMes10 * 100, 0, ",", ".")." %";
									
									if($dato10<80){
									   $clase10 = 'semaforo-rojo';
									}else if($dato10>=80 && $dato10<=90){
									   $clase10 = 'semaforo-ambar';
									}else if($dato10>90){
									   $clase10 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color10}}">
									<div class="{{$clase10}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato10}}</b></div>
								</td>
 
								@php 
								    $efecMes11 = $listefectividadtotal->T_EF_NOV == '' ? 0 : $listefectividadtotal->T_EF_NOV;
								    $dato11 = number_format($efecMes11 * 100, 0, ",", ".")." %";
									
									if($dato11<80){
									   $clase11 = 'semaforo-rojo';
									}else if($dato11>=80 && $dato11<=90){
									   $clase11 = 'semaforo-ambar';
									}else if($dato11>90){
									   $clase11 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color11}}">
									<div class="{{$clase11}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato11}}</b></div>
								</td>
 
								@php 
								    $efecMes12 = $listefectividadtotal->T_EF_DIC == '' ? 0 : $listefectividadtotal->T_EF_DIC;
								    $dato12 = number_format($efecMes12 * 100, 0, ",", ".")." %";
									
									if($dato12<80){
									   $clase12 = 'semaforo-rojo';
									}else if($dato12>=80 && $dato12<=90){
									   $clase12 = 'semaforo-ambar';
									}else if($dato12>90){
									   $clase12 = 'semaforo-verde';
									}
								@endphp
								<td scope="row" style="background-color:{{$color12}}">
									<div class="{{$clase12}}"></div>
									<div style="margin-top: -28%; margin-left: 25%;"><b>{{$dato12}}</b></div>
								</td>
							</tr>
						@endforeach
						
						@else
						<tr>
							<td align="center" scope="col" colspan=12 class="mensajeError"><strong>No se encontraron resultados</strong></td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>
@endif 

<br>

@if(isset($CantCliSinCita))
<div style="overflow-y:block;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
		<div class="table-wrapper">
			<div class="table-title" style="background: #042e5a!important">
				<div class="row col-12">
					<h2>CLIENTE SIN CITA</h2>
				</div>
			</div>
 			  
			<div class="table-cont-single mt-3">
			    <table class="table text-center table-striped table-sm">
				    <thead>
						<tr class="alert alert-primary">
						    <th scope="col"></th>
							<th scope="col" style="background-color:{{$color1}}">ENE-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color2}}">FEB-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color3}}">MAR-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color4}}">ABR-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color5}}">MAY-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color6}}">JUN-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color7}}">JUL-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color8}}">AGO-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color9}}">SET-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color10}}">OCT-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color11}}">NOV-{{SUBSTR($anio_ot, -2)}}</th>
							<th scope="col" style="background-color:{{$color12}}">DIC-{{SUBSTR($anio_ot, -2)}}</th>						
						</tr>
				    </thead>
				
					<tbody>
					@if(count($CantCitAgenEfecTotal))
					    @foreach($CantCitAgenEfecTotal as $listcitagenefec)
						<tr>
							<td style="vertical-align: middle;">CLIENTES CON CITA</td>
							<td style="vertical-align: middle; background-color:{{$color1}}">{{$listcitagenefec->T_ENE}}</td>
							<td style="vertical-align: middle; background-color:{{$color2}}">{{$listcitagenefec->T_FEB}}</td>
							<td style="vertical-align: middle; background-color:{{$color3}}">{{$listcitagenefec->T_MAR}}</td>
							<td style="vertical-align: middle; background-color:{{$color4}}">{{$listcitagenefec->T_ABR}}</td>
							<td style="vertical-align: middle; background-color:{{$color5}}">{{$listcitagenefec->T_MAY}}</td>
							<td style="vertical-align: middle; background-color:{{$color6}}">{{$listcitagenefec->T_JUN}}</td>
							<td style="vertical-align: middle; background-color:{{$color7}}">{{$listcitagenefec->T_JUL}}</td>
							<td style="vertical-align: middle; background-color:{{$color8}}">{{$listcitagenefec->T_AGO}}</td>
							<td style="vertical-align: middle; background-color:{{$color9}}">{{$listcitagenefec->T_SEP}}</td>
							<td style="vertical-align: middle; background-color:{{$color10}}">{{$listcitagenefec->T_OCT}}</td>
							<td style="vertical-align: middle; background-color:{{$color11}}">{{$listcitagenefec->T_NOV}}</td>
							<td style="vertical-align: middle; background-color:{{$color12}}">{{$listcitagenefec->T_DIC}}</td>
						</tr>
						@endforeach
						
						@foreach($CantCliSinCita as $listcanclicincita)
							<tr>
							    <td style="vertical-align: middle;">CLIENTES SIN CITA</td>
								<td style="vertical-align: middle; background-color:{{$color1}}">{{$listcanclicincita->ENE}}</td>
								<td style="vertical-align: middle; background-color:{{$color2}}">{{$listcanclicincita->FEB}}</td>
								<td style="vertical-align: middle; background-color:{{$color3}}">{{$listcanclicincita->MAR}}</td>
								<td style="vertical-align: middle; background-color:{{$color4}}">{{$listcanclicincita->ABR}}</td>
								<td style="vertical-align: middle; background-color:{{$color5}}">{{$listcanclicincita->MAY}}</td>
								<td style="vertical-align: middle; background-color:{{$color6}}">{{$listcanclicincita->JUN}}</td>
								<td style="vertical-align: middle; background-color:{{$color7}}">{{$listcanclicincita->JUL}}</td>
								<td style="vertical-align: middle; background-color:{{$color8}}">{{$listcanclicincita->AGO}}</td>
								<td style="vertical-align: middle; background-color:{{$color9}}">{{$listcanclicincita->SEP}}</td>
								<td style="vertical-align: middle; background-color:{{$color10}}">{{$listcanclicincita->OCT}}</td>
								<td style="vertical-align: middle; background-color:{{$color11}}">{{$listcanclicincita->NOV}}</td>
								<td style="vertical-align: middle; background-color:{{$color12}}">{{$listcanclicincita->DIC}}</td>
							</tr>
						@endforeach
						
						@foreach($CantCliConySinCita as $listcliconysincitatotal)
							<tr>
								<td style="vertical-align: middle;"><b>TOTAL</b></td>
								<td style="vertical-align: middle; background-color:{{$color1}}"><b>{{$listcliconysincitatotal->T_CCYSC_ENE}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color2}}"><b>{{$listcliconysincitatotal->T_CCYSC_FEB}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color3}}"><b>{{$listcliconysincitatotal->T_CCYSC_MAR}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color4}}"><b>{{$listcliconysincitatotal->T_CCYSC_ABR}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color5}}"><b>{{$listcliconysincitatotal->T_CCYSC_MAY}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color6}}"><b>{{$listcliconysincitatotal->T_CCYSC_JUN}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color7}}"><b>{{$listcliconysincitatotal->T_CCYSC_JUL}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color8}}"><b>{{$listcliconysincitatotal->T_CCYSC_AGO}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color9}}"><b>{{$listcliconysincitatotal->T_CCYSC_SEP}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color10}}"><b>{{$listcliconysincitatotal->T_CCYSC_OCT}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color11}}"><b>{{$listcliconysincitatotal->T_CCYSC_NOV}}</b></td>
								<td style="vertical-align: middle; background-color:{{$color12}}"><b>{{$listcliconysincitatotal->T_CCYSC_DIC}}</b></td>
							</tr>
						@endforeach
						
						@foreach($CantCliConCitaTotal as $listcliconcittotal)
						    <tr>
								<td style="vertical-align: middle;"><b>% CLIENTES CON CITA</b></td>
								@php $cscMes1 = $listcliconcittotal->P_CCC_ENE == '' ? 0 : $listcliconcittotal->P_CCC_ENE; @endphp
								<td style="vertical-align: middle; background-color:{{$color1}}"><b>{{number_format($cscMes1 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes2 = $listcliconcittotal->P_CCC_FEB == '' ? 0 : $listcliconcittotal->P_CCC_FEB; @endphp
								<td style="vertical-align: middle; background-color:{{$color2}}"><b>{{number_format($cscMes2 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes3 = $listcliconcittotal->P_CCC_MAR == '' ? 0 : $listcliconcittotal->P_CCC_MAR; @endphp
								<td style="vertical-align: middle; background-color:{{$color3}}"><b>{{number_format($cscMes3 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes4 = $listcliconcittotal->P_CCC_ABR == '' ? 0 : $listcliconcittotal->P_CCC_ABR; @endphp
								<td style="vertical-align: middle; background-color:{{$color4}}"><b>{{number_format($cscMes4 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes5 = $listcliconcittotal->P_CCC_MAY == '' ? 0 : $listcliconcittotal->P_CCC_MAY; @endphp
								<td style="vertical-align: middle; background-color:{{$color5}}"><b>{{number_format($cscMes5 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes6 = $listcliconcittotal->P_CCC_JUN == '' ? 0 : $listcliconcittotal->P_CCC_JUN; @endphp
								<td style="vertical-align: middle; background-color:{{$color6}}"><b>{{number_format($cscMes6 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes7 = $listcliconcittotal->P_CCC_JUL == '' ? 0 : $listcliconcittotal->P_CCC_JUL; @endphp
								<td style="vertical-align: middle; background-color:{{$color7}}"><b>{{number_format($cscMes7 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes8 = $listcliconcittotal->P_CCC_AGO == '' ? 0 : $listcliconcittotal->P_CCC_AGO; @endphp
								<td style="vertical-align: middle; background-color:{{$color8}}"><b>{{number_format($cscMes8 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes9 = $listcliconcittotal->P_CCC_SEP == '' ? 0 : $listcliconcittotal->P_CCC_SEP; @endphp
								<td style="vertical-align: middle; background-color:{{$color9}}"><b>{{number_format($cscMes9 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes10 = $listcliconcittotal->P_CCC_OCT == '' ? 0 : $listcliconcittotal->P_CCC_OCT; @endphp
								<td style="vertical-align: middle; background-color:{{$color10}}"><b>{{number_format($cscMes10 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes11 = $listcliconcittotal->P_CCC_NOV == '' ? 0 : $listcliconcittotal->P_CCC_NOV; @endphp
								<td style="vertical-align: middle; background-color:{{$color11}}"><b>{{number_format($cscMes11 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes12 = $listcliconcittotal->P_CCC_DIC == '' ? 0 : $listcliconcittotal->P_CCC_DIC; @endphp
								<td style="vertical-align: middle; background-color:{{$color12}}"><b>{{number_format($cscMes12 * 100, 0, ",", ".")." %"}}</b></td>
							</tr>
						@endforeach
						
						@foreach($CantCliSinCitaTotal as $listclisincittotal)
						    <tr>
								<td style="vertical-align: middle;"><b>% CLIENTES SIN CITA</b></td>
								@php $cscMes1 = $listclisincittotal->P_CSC_ENE == '' ? 0 : $listclisincittotal->P_CSC_ENE; @endphp
								<td style="vertical-align: middle; background-color:{{$color1}}"><b>{{number_format($cscMes1 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes2 = $listclisincittotal->P_CSC_FEB == '' ? 0 : $listclisincittotal->P_CSC_FEB; @endphp
								<td style="vertical-align: middle; background-color:{{$color2}}"><b>{{number_format($cscMes2 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes3 = $listclisincittotal->P_CSC_MAR == '' ? 0 : $listclisincittotal->P_CSC_MAR; @endphp
								<td style="vertical-align: middle; background-color:{{$color3}}"><b>{{number_format($cscMes3 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes4 = $listclisincittotal->P_CSC_ABR == '' ? 0 : $listclisincittotal->P_CSC_ABR; @endphp
								<td style="vertical-align: middle; background-color:{{$color4}}"><b>{{number_format($cscMes4 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes5 = $listclisincittotal->P_CSC_MAY == '' ? 0 : $listclisincittotal->P_CSC_MAY; @endphp
								<td style="vertical-align: middle; background-color:{{$color5}}"><b>{{number_format($cscMes5 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes6 = $listclisincittotal->P_CSC_JUN == '' ? 0 : $listclisincittotal->P_CSC_JUN; @endphp
								<td style="vertical-align: middle; background-color:{{$color6}}"><b>{{number_format($cscMes6 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes7 = $listclisincittotal->P_CSC_JUL == '' ? 0 : $listclisincittotal->P_CSC_JUL; @endphp
								<td style="vertical-align: middle; background-color:{{$color7}}"><b>{{number_format($cscMes7 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes8 = $listclisincittotal->P_CSC_AGO == '' ? 0 : $listclisincittotal->P_CSC_AGO; @endphp
								<td style="vertical-align: middle; background-color:{{$color8}}"><b>{{number_format($cscMes8 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes9 = $listclisincittotal->P_CSC_SEP == '' ? 0 : $listclisincittotal->P_CSC_SEP; @endphp
								<td style="vertical-align: middle; background-color:{{$color9}}"><b>{{number_format($cscMes9 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes10 = $listclisincittotal->P_CSC_OCT == '' ? 0 : $listclisincittotal->P_CSC_OCT; @endphp
								<td style="vertical-align: middle; background-color:{{$color10}}"><b>{{number_format($cscMes10 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes11 = $listclisincittotal->P_CSC_NOV == '' ? 0 : $listclisincittotal->P_CSC_NOV; @endphp
								<td style="vertical-align: middle; background-color:{{$color11}}"><b>{{number_format($cscMes11 * 100, 0, ",", ".")." %"}}</b></td>
								@php $cscMes12 = $listclisincittotal->P_CSC_DIC == '' ? 0 : $listclisincittotal->P_CSC_DIC; @endphp
								<td style="vertical-align: middle; background-color:{{$color12}}"><b>{{number_format($cscMes12 * 100, 0, ",", ".")." %"}}</b></td>
							</tr>
						@endforeach
						
						@else
						<tr>
							<td align="center" scope="col" colspan=12 class="mensajeError"><strong>No se encontraron resultados</strong></td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
		</div>
		
		@if(isset($CantCitAgen))		
		<div class="alert alert-primary" role="alert" align="center">
		    <h5>Información actualizada al {{$fechaActual}} a las {{date('h:i a', strtotime($date))}}</h5>
		</div>
		@endif
		
    </div>
</div>
@endif 
@endsection