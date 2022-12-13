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
    <h2>Seguimiento Ventas Taller</h2>
  </div>
  
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerReporteOTs" class="my-3 mr-3" method="GET" action="{{route('reportes.seguimientoVentasTaller')}}" value="search">
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
            <a href="{{ route('reportes.seguimientoVentasTaller.export', ['anio' => $anio_filtro]) }}" class="btn btn-success">
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
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ isset(request()->pestania) && request()->pestania == '1' ? 'active' : (!isset(request()->pestania) ? 'active' : '') }}" onclick="$('#chk_meson').addClass('d-none'); $('#pestania').val('1')" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true"><b>MECÁNICA</b></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ isset(request()->pestania) && request()->pestania == '2' ? 'active' : '' }}" onclick="$('#chk_meson').removeClass('d-none'); $('#pestania').val('2')" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false"><b>B&P</b></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ isset(request()->pestania) && request()->pestania == '3' ? 'active' : '' }}" onclick="$('#chk_meson').addClass('d-none'); $('#pestania').val('3')" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                aria-selected="false"><b>TOTAL</b></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '1' ? 'show active' : (!isset(request()->pestania) ? 'show active' : '') }}" id="home" role="tabpanel" aria-labelledby="home-tab">
            @include('reportes.seguimientoVentasTaller.mec')
        </div>
		
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '2' ? 'show active' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            @include('reportes.seguimientoVentasTaller.byp')
        </div>
		
        <div class="p-2 tab-pane fade {{ isset(request()->pestania) && request()->pestania == '3' ? 'show active' : '' }}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            @include('reportes.seguimientoVentasTaller.total')
        </div>
    </div>          
  </div>
</div>
@endsection