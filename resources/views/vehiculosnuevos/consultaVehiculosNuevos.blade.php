@extends('mecanica.tableCanvas')
@section('titulo','Maestro de vehiculos nuevos') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="row justify-content-between col-12">
    <h2>Maestro de vehiculos nuevos</h2>
   
  </div>

  <div id="busquedaForm" class="col-12 borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRepuestos" class="my-3 mr-3" method="POST" action="{{route('vehiculonuevo.filter')}}" >
      @csrf
      <div class="row">

        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
          <div class="col-12 col-sm-6">
            <label for="marca" class="col-form-label col-6 col-lg-5">Marca:</label>
          </div>
          <div class="col-12 col-sm-6">
          <select name="marca" id="marca" class="form-control required col-12" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorMarca">
            <option value="Todo">TODOS</option>
            @foreach($listaMarcas as $marca)
            <option value="{{$marca->id_marca_auto}}">{{$marca->nombre_marca}}</option>
            @endforeach                
          </select>
          </div>
        </div>
      </div>
    <div class="row">

        <div class="form-group row ml-1 col-4">
          <div class="col-12 col-sm-6">
            <label for="modeloComercial" class="col-form-label">Modelo Comercial:</label>
          </div>
          <div class="col-12 col-sm-6">
            <input name="modeloComercial" type="text" class="form-control col-12 typeahead vehiculonuevo" tipo="modelosComerciales" id="codigoIn" style="width:100%" data-validation-error-msg="Debe ingresar el código del repuesto" data-validation-error-msg-container="#errorCodigo" placeholder="Ingrese el modelo Comercial" oninput="this.value = this.value.toUpperCase()">
              <div id="errorCodigo" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
          </div>
        </div>

        <div class="form-group row ml-1 col-6 col-sm-3">
          <div class="col-12 col-sm-6">
            <label for="estado" class="col-form-label">Estado:</label>
          </div>
          <div class="col-12 col-sm-6">
            <select name="estado" id="estado" class="form-control  col-12" style="width:100%"  data-validation-error-msg="Debe seleccionar una opción" >
              <option value="">Todos</option>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>
        </div>
        
        <div class="form-group row ml-1 col-4">
          <div class="col-12 col-sm-6">
            <label for="responsableCreacion" class="col-form-label">Responsable creación:</label>
          </div>
          <div class="col-12 col-sm-6">
            <select name="responsableCreacion" id="responsableCreacion" class="form-control col-12" style="width:100%"  data-validation-error-msg="Debe seleccionar una opción" >
              <option value=""></option>
              @foreach($listaAsesores as $empleado)
                <option value="{{$empleado->dni}}">{{$empleado->nombreCompleto()}}</option>
              @endforeach                
            </select>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-md-6 ml-2 form-group row">
          
        </div>
        <div class="col-md-6 ml-2 form-group row">
          
        </div>
      </div>

      <div class="row justify-content-end mb-3">
        
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="{{route('vehiculonuevo.index')}}"><button type="button" class="btn btn-info ml-3">Limpiar</button></a>
      </div>
    </form>
  </div>
  
</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12 justify-content-between">
          <div>
            <h2>Maestro vehiculos nuevos </h2>
           
          </div>
          <button type="button" class="btn btn-success mr-4"><a style="text-decoration: none; color:white;" href="{{route('vehiculonuevo.register')}}">Nuevo Modelo Comercial</a></button>      
        </div>
      </div>
  
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">ESTADO</th>
              <th scope="col">MARCA</th>
              <th scope="col">MODELO COMERCIAL</th>
              <th scope="col">F. CREACIÓN</th>
              <th scope="col">CREADO POR</th>
              <th scope="col">F. ÚLTIMA EDICIÓN</th>
              <th scope="col">EDITADO POR </th>
              <th scope="col"></th>
              <th scope="col"></th>
             
              
            </tr>
          </thead>
          <tbody>
            @foreach ($listaVehiculosNuevos as $row)
            <tr>
              <th style="vertical-align: middle" scope="row">{{$loop->iteration}}</th>
              @if($row->habilitado==true)
                <td style="vertical-align: middle; background-color:rgb(49, 228, 49); color:white; font-weight: bold;">ACTIVO</td>
              @else
              <td style="vertical-align: middle; background-color:rgb(150, 3, 3); color:white;font-weight: bold;">INACTIVO</td>
              @endIf
              <td style="vertical-align: middle">{{$row->marcaAuto->nombre_marca}}</td>
              <td style="vertical-align: middle">{{$row->modelo_comercial}}</td>
              <td style="vertical-align: middle">{{$row->created_at}}</td>
              <td style="vertical-align: middle">{{$row->getUsuarioRegistro()}}</td>
              <td style="vertical-align: middle">{{$row->updated_at}}</td>
              <td style="vertical-align: middle">{{$row->getUsuarioModifico()}}</td>
              <td><a href="/vehiculosNuevos/consulta/{{$row->id_vehiculo_nuevo}}" id="btndedit-{{$row->id_vehiculo_nuevo}}" style="text-decoration: none; color:white;" class="btn btn-warning" type="button"><i class="fas fa-edit icono-btn-tabla"></i></a></td>
              <td><a href="/vehiculosNuevos/delete/{{$row->id_vehiculo_nuevo}}" id="btnddelete-{{$row->id_vehiculo_nuevo}}" style="text-decoration: none; color:white;" class="btn btn-danger" type="button"><i class="fas fa-trash icono-btn-tabla"></i></a></td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection