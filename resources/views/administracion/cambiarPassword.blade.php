@extends('tableCanvas')
@section('titulo','Administración - Cambiar contraseña') 

@section('pretable-content')
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 15px 10px 10px 15px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-0">Cambio de Contraseña</h2>
  </div>
  <p class="ml-3 mt-3 mb-4">Ingrese la nueva contraseña con la que desea iniciar sesión al sistema</p>
  @if( session('errorConfirm') )
  <div id="error" class="col-12 validation-error-cont text-left no-gutters pr-0">Las contraseñas ingresadas deben ser las mismas.</div>
  @endif
  <form class="col-6" id="FormCambiarPassword" method="POST" action="{{route('resetPassword.post')}}" value="Submit" autocomplete="off" onkeydown="return event.key != 'Enter';">
    @csrf
    <div class="form-group form-inline">
      <label for="pass1In" class="col-sm-6 justify-content-end">Nueva Contraseña: </label>
      <div class="col-sm-6">
        <input name="password" type="password" class="form-control" id="pass1In" data-validation="required" data-validation-error-msg="Debe ingresar una contraseña" data-validation-error-msg-container="#errorPass1" placeholder="Ingrese una contraseña">
        <div id="errorPass1" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label for="pass2In" class="col-sm-6 justify-content-end">Confirmar Contraseña:</label>
      <div class="col-sm-6">
        <input name="passwordConfirm" type="password" class="form-control" id="pass2In" data-validation="required" data-validation-error-msg="Debe ingresar una contraseña" data-validation-error-msg-container="#errorPass2" placeholder="Ingrese una contraseña">
        <div id="errorPass2" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
      </div>
    </div>
    
    <div class="row justify-content-center">
      <button id="btnCambiarPassword" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
    </div>
  </form>
</div>
@endsection