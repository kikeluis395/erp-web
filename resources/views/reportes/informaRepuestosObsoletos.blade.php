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
@section('titulo','Consulta Reporte Kardex') 

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Informe Repuestos Obsoletos</h2>
  </div>
  
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.informaRepuestosObsoletos')}}" value="search">
        <input type="hidden" name="pestania" id="pestania" value="{{ isset(request()->pestania) ? request()->pestania : 1 }}">
    <div class="row">
		<div class="col-md-2">
			<label for="local" class="col-form-label">Local:</label>
			<select name="local" id="local_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_ot" required="">			    
                @foreach ($locales as $local)
                    <option value="{{ $local->id_local }}">{{ $local->nombre_local }}</option>
                @endforeach
			</select>
			<div id="errorlocal_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
		</div>
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
		
		<div class="col-md-3 row" style="margin: auto 0; ">			
			<button type="submit" class="btn btn-primary mr-2">Buscar</button>
            <a href="{{ route('reportes.informaRepuestosObsoletos.export', ['anio' => $anio_filtro, 'id_local' => $id_local_filtro]) }}" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-excel"
                    viewBox="0 0 16 16">
                    <path
                        d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
                    <path
                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                </svg>
                Exportar
            </a>
		</div>				
	</div>
    </form>
  </div>
  
  <div class="mt-3">
    <div class="tab-content" id="myTabContent">
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '1' ? 'show active' : (!isset(request()->pestania) ? 'show active' : '') }}" id="home" role="tabpanel" aria-labelledby="home-tab">

            <table class="table table-bordered">
                <tr>
                    <th style="width: 243.85px" class="text-center">ICC</th>
                    <th>SIGNIFICADO</th>
                </tr>
                <tr>
                    <th style="background-color: #FFFF99" class="text-center">F</td>
                    <td>Nuevos o sin movimiento en los ultimos 3 meses</td>
                </tr>
                <tr>
                    <th style="background-color: #FFFF99" class="text-center">G</th>
                    <td>Desde 3 a 6 meses SIN SALIDAS</td>
                </tr>
                <tr>
                    <th style="background-color: #FFFF99" class="text-center">H</th>
                    <td>Desde 6 a 12 meses SIN SALIDAS</td>
                </tr>
                <tr>
                    <th style="background-color: #FFFF99" class="text-center">I</th>
                    <td>Desde 12 a 24 meses SIN SALIDAS</td>
                </tr>
                <tr>
                    <th style="background-color: #FFFF99" class="text-center">J</th>
                    <td>Mas de 24 meses SIN SALIDAS</td>
                </tr>
            </table>
            <table class="table text-center table-striped table-sm">
                <tr>
                    <td align="left" style="color: #856404; font-weight: bold; width: 243.85px">DÍAS TRANSCURRIDOS</td>                    
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
                    <th align="left"></th>                    
                    @for ($i = 1; $i <= 12; $i++)
                    <th class="bg-danger text-white">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
                    @endfor
                </tr>
                @foreach ($array_icc as $item_icc)
                    @php
                        $icc_name = "icc_{$item_icc}";
                    @endphp
                    @include('reportes.informaRepuestosObsoletos.plantilla', ['titulo_icc' => $item_icc, 'icc' => $$icc_name ])    
                @endforeach  
            </table>  
            <br>
            <table class="table text-center table-striped table-sm">
                <tr class="alert alert-primary">
                    <th align="left" style="width: 243.85px" class="text-danger">PARTICIPACIÓN%</th>                    
                    @for ($i = 1; $i <= 12; $i++)
                    <th class="text-white" style="background-color: #595959">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
                    @endfor
                </tr>
                @foreach ($array_icc as $item_icc)
                    @if ($item_icc != 'TOTAL')
                        @php
                        $icc_name = "porc_icc_{$item_icc}";
                        @endphp
                        @include('reportes.informaRepuestosObsoletos.plantilla_porc', ['titulo_icc_porc' => $item_icc, 'icc_porc' => $$icc_name ])   
                    @endif 
                @endforeach  
            </table>            
        </div>		
    </div>          
  </div>
</div>
@endsection