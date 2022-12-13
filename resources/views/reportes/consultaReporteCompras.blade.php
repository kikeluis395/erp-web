@extends('contabilidadv2.layoutCont')
@section('titulo','Consulta Reporte Compras') 

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<div style="background: white;padding: 10px">
	<div class="row justify-content-between col-12">
	    <h2>Reporte - Compras</h2>
	</div>

	<div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
		<form id="FormObtenerReporteCompras" class="my-3 mr-3" method="GET"  value="search">
			<div class="row">
				<div class="form-group col-md-2">
					<label for="filtroLocal" class="col-form-label">Local:</label>
					<select name="filtroLocal" id="filtroLocal" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_ot" required="">
					  <option value="Los Olivos" selected="true">Los Olivos</option>
					</select>
					<div id="errorlocal_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
				</div>
				
				<div class="col-md-2">
					<label for="ano" class="col-form-label">Año:</label>
					<select name="ano" id="anio_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#erroranio_ot" required="">
					  <option value="2021" selected="true">2021</option>
					  <option value="2022">2022</option>
					  <option value="2023">2023</option>
					  <option value="2024">2024</option>
					  <option value="2025">2025</option>
					</select>
					<div id="erroranio_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
				</div>
				
				<div class="col-md-2">
					<label for="ano" class="col-form-label">Moneda:</label>
					<select name="moneda" id="moneda" class="form-control" required>
					  <option value="SOLES">Soles</option>
					  <option value="DOLARES">Dolares</option>
					</select>
					<div id="erroranio_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
				</div>

                <div class="col-md-4">
					<label class="col-form-label" style="position: relative; margin-bottom: 11.5%"></label>
					<button formaction="{{route('reportes.showResumenCompras')}}" type="submit" name="exportar" class="btn btn-primary">Generar</button>
                    <button formaction="{{route('reportes.comprasExport')}}" type="submit" name="exportar" class="btn btn-success">Exportar</button>
                </div>				
			</div>
		</form>
	</div>
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

@if($resultados!=null)
<div style="overflow-y:block;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row col-12">
                    <h2>Reporte Compra</h2>
				</div>
			</div>
			  
			<div class="table-cont-single mt-3">
			    <table class="table text-center table-striped table-sm">
					<thead>
					<tr class="alert alert-primary">
					  <th scope="col" style="background-color: #e9e9e9;">#</th>
					  <th scope="col" style="background-color: #e9e9e9;">DOC. PROVEEDOR</th>
					  <th scope="col" style="background-color: #e9e9e9;">NOM. PROVEEDOR</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color1}}">{{'ENE-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color2}}">{{'FEB-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color3}}">{{'MAR-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color4}}">{{'ABR-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color5}}">{{'MAY-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color6}}">{{'JUN-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color7}}">{{'JUL-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color8}}">{{'AGO-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color9}}">{{'SEP-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color10}}">{{'OCT-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color11}}">{{'NOV-'.$year}}</th>
					  <th scope="col" style="background-color: #e9e9e9; background-color:{{$color12}}">{{'DIC-'.$year}}</th>
					</tr>
					</thead>
					
					<tbody>
						@foreach($resultados as $resultado)
						<tr>
							<th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
							<td style="vertical-align: middle">{{$resultado['ruc_proveedor']}}</td>
							<td style="vertical-align: middle">{{$resultado['nombre_proveedor']}}</td>
							<td style="vertical-align: middle; background-color:{{$color1}}">{{ $resultado['01']}}</td>
							<td style="vertical-align: middle; background-color:{{$color2}}">{{$resultado['02']}}</td>
							<td style="vertical-align: middle; background-color:{{$color3}}">{{$resultado['03']}}</td>
							<td style="vertical-align: middle; background-color:{{$color4}}">{{$resultado['04']}}</td>
							<td style="vertical-align: middle; background-color:{{$color5}}">{{$resultado['05']}}</td>
							<td style="vertical-align: middle; background-color:{{$color6}}">{{$resultado['06']}}</td>
							<td style="vertical-align: middle; background-color:{{$color7}}">{{$resultado['07']}}</td>
							<td style="vertical-align: middle; background-color:{{$color8}}">{{$resultado['08']}}</td>
							<td style="vertical-align: middle; background-color:{{$color9}}">{{$resultado['09']}}</td>
							<td style="vertical-align: middle; background-color:{{$color10}}">{{$resultado['10']}}</td>
							<td style="vertical-align: middle; background-color:{{$color11}}">{{$resultado['11']}}</td>
							<td style="vertical-align: middle; background-color:{{$color12}}">{{$resultado['12']}}</td>
						</tr>
						@endforeach
				    </tbody>
				</table>
			</div>
		</div>
		
		@if(isset($resultados))		
		<div class="alert alert-primary" role="alert" align="center">
		    <h5>Información actualizada al {{\Carbon\Carbon::now()->format('d/m/Y')}} a las {{\Carbon\Carbon::now()->format('h:i A')}}</h5>
		</div>
		@endif
		
    </div>
</div>
@endif 

<script>
  $("#btnExport").on('click', function () {
    var link_sub='/reportes/Compras/';
		var link_completo = rootURL + link_sub;
    var filtroNroRepuesto = $("#filtroNroRepuesto");
    var fechaInicial = $("#fechaInicial");
    var fechaFinal = $("#fechaFinal");
			$.get(link_completo,{
        'fechaInicial': fechaInicial, 
        'fechaFinal' :  fechaFinal, 
        'idRepuesto' : filtroNroRepuesto
      },function(data,status) {
                console.log(data)
      });
  });
</script>
@endsection