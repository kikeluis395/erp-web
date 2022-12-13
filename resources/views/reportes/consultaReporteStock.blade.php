@extends('contabilidadv2.layoutCont')
@section('titulo','Consulta de Stock') 

@section('content')

<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Consulta de Stock</h2>
  </div>
  
  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormObtenerConsultaStock" class="my-3 mr-3" method="GET" action="{{route('reportes.stock')}}" value="search">
        <div class="row">
			<div class="form-group col-md-2">
				<label for="local_otIn" class="col-form-label">Local:</label>
				<select name="local_ot" id="local_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_ot" required="">
				  <option value="1" >Los Olivos</option>
				</select>
				<div id="errorlocal_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
			</div>
			
			<div class="form-group col-md-2">
				<label for="local_otIn" class="col-form-label">Mes:</label>
				<select name="mes" id="local_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_ot" required="">
				  <option value="1" selected="true">Enero</option>
				  <option value="2" >Febrero</option>
				  <option value="3" >Marzo</option>
				  <option value="4" >Abril</option>
				  <option value="5" >Mayo</option>
				  <option value="6" >Junio</option>
				  <option value="7" >Julio</option>
				  <option value="8" >Agosto</option>
				  <option value="9" >Setiembre</option>
				  <option value="10'" >Octubre</option>
				  <option value="11" >Noviembre</option>
				  <option value="12" >Diciembre</option>
				  
				</select>
				<div id="errorlocal_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
			</div>
			
			<div class="form-group col-md-2">
				<label for="local_otIn" class="col-form-label">Año:</label>
				<select name="anio" id="local_otIn" class="form-control col-lg-12 valid" style="width: 100%;" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorlocal_ot" required="">
				  <option value="2021" selected="true">2021</option>
				  <option value="2022" >2022</option>
				  <option value="2023" >2023</option>
				  <option value="2024" >2024</option>
				</select>
				<div id="errorlocal_ot" class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
			</div>
			
			<div class="col-md-1">
				<label class="col-form-label" style="position: relative; margin-bottom: 18px;"></label>
				<button type="submit" class="btn btn-primary">Exportar</button>
			</div>	
        </div>
    </form>
  </div>
  
</div>

@endsection