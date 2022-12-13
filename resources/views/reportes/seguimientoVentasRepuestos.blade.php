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
    <h2>Seguimiento Ventas Repuestos</h2>
  </div>
  
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.seguimientoVentasRepuestos')}}" value="search">
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

	    <div class="col-md-3" id="proyeccion" style="top: 34px!important">
		  <span class="font-weight-bold letra-rotulo-detalle text-left">Proyección</span> 
		  <div class="custom-control custom-switch">
			<input type="checkbox" class="custom-control-input" name="proyeccion" id="customSwitchRealPro" {{ $proyeccion ? 'checked' : '' }}>
			<label class="custom-control-label"  for="customSwitchRealPro"> <div id = "customSwitchRealProText" name="customSwitchRealProText" >{{ $proyeccion ? 'PROYECTADO' : 'REAL' }}</div>  </label>
		  </div>
		</div>	
		
		<div class="col-md-3 row" style="margin: auto 0; ">			
			<button type="submit" class="btn btn-primary mr-2">Buscar</button>
            <a href="{{ route('reportes.seguimientoVentasRepuestos.export', ['anio' => $anio_filtro, 'id_local' => $id_local_filtro]) }}" class="btn btn-success">
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
                    <th align="left" style="background-color: #e9e9e9;"></th>
                    <th align="left" style="background-color: #e9e9e9;"></th>
                    @for ($i = 1; $i <= 12; $i++)
                    <th style="background-color: #e9e9e9;">{{ strtoupper(App\Helper\Helper::getNameMonth($i)) }}-{{ substr($anio_filtro, 2, 2) }}</th>
                    @endfor
                </tr>
                @include('reportes.seguimientoVentasRepuestos.byp')
                <tr>    
                    <td colspan="14"></td>
                </tr>
                @include('reportes.seguimientoVentasRepuestos.mec')
                <tr>    
                    <td colspan="14"></td>
                </tr>
                @include('reportes.seguimientoVentasRepuestos.meson')
                <tr>    
                    <td colspan="14"></td>
                </tr>
                @include('reportes.seguimientoVentasRepuestos.total')
                <tr>    
                    <td colspan="14"></td>
                </tr>
                @include('reportes.seguimientoVentasRepuestos.inventario')
                @include('reportes.seguimientoVentasRepuestos.mos')
            </table>

            <table class="table text-center table-striped table-sm">
                <tr>
                    <td rowspan="4">MOS (Months of Stock)</td>
                    <td rowspan="4">Inventario del Mes / Costo de Ventas del Mes</td>
                </tr>
                <tr>
                    <td class="bg-danger">MOS > 1</td>
                    <td>Se tiene stock para atender > 1 mes sin comprar nuevos repuestos</td>                
                </tr>
                <tr>
                    <td class="bg-warning">MOS = 1</td>
                    <td>Se tiene stock para atender 1 mes sin comprar nuevos repuestos</td>                    
                </tr>
                <tr>
                    <td class="bg-success">MOS < 1</td>
                    <td>Se tiene stock para atender < 1 mes sin comprar nuevos repuestos</td>                                    
                </tr>                
            </table>
        </div>		
    </div>          
  </div>
</div>
@endsection