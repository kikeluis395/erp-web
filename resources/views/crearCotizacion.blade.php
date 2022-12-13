@extends('mecanica.tableCanvas')
@section('titulo','Modulo de recepción - Registrar Cotizacion B&P') 

@section('pretable-content')
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 15px 10px 10px 15px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-0">Registro de Cotización - B&P</h2>
  </div>
  <p class="ml-3 mt-3 mb-4">Ingrese los datos del cliente para continuar con el registro</p>
  <form class="col-xl-6" id="FormRegistrarRecepcion" method="POST" action="{{route('cotizaciones.store')}}" value="Submit" autocomplete="off" onkeydown="return event.key != 'Enter';">
    @csrf
    <div class="form-group form-inline">
      <label for="nroPlacaIn" class="col-sm-6 justify-content-end">Placa: </label>
      <div class="col-sm-6">
        <input name="nroPlaca" type="text" class="form-control col-lg-8" id="nroPlacaIn" style="width:100%" data-validation="length" data-validation-length="6" data-validation-error-msg="Debe ingresar una placa de 6 caracteres" data-validation-error-msg-container="#errorPlaca" placeholder="Ingrese el número de placa" maxlength="6" oninput="this.value = this.value.toUpperCase()">
        <a><button id="btnBuscarPlaca" type="button">Buscar</button></a>
        <div id="errorPlaca" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
        <div id="hintPlaca" class="col-12 text-left no-gutters pr-0"></div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label for="clienteIn" class="col-sm-6 justify-content-end">Cliente:</label>
      <div class="col-sm-6">
        <input name="cliente" type="text" class="form-control col-lg-8" id="clienteIn" style="width:100%" data-validation="required" data-validation-error-msg="Debe especificar el DNI o RUC del cliente" data-validation-error-msg-container="#errorClienteExt" placeholder="Ingrese el DNI o RUC del cliente" maxlength="15" disabled>
        <a href="#"><button id="btnBuscarCliente" type="button">Buscar</button></a>
        <div id="errorClienteExt" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
        <div id="hintCliente" class="col-12 text-left no-gutters pr-0"></div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label for="ciaSeguroIn" class="col-sm-6 justify-content-end">Compañía de seguros:</label>
      <div class="col-sm-6">
        <select name="seguro" id="ciaSeguroIn" class="form-control col-lg-8" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorSeguro" required>
          <option value=""></option>
          @foreach ($listaSeguros as $seguro)
          <option value="{{$seguro->id_cia_seguro}}">{{$seguro->nombre_cia_seguro}}</option>
          @endforeach
        </select>
      </div>
      <div id="errorSeguro" class="col-sm-10 validation-error-cont text-right no-gutters pr-0"></div>
    </div>

    <div class="form-group form-inline">
      <label for="monedaIn" class="col-sm-6 justify-content-end">Moneda:</label>
      <div class="col-sm-6">
          <select name="moneda" id="monedaIn" class="form-control col-lg-8" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorMoneda" required>
          <option value=""></option>
          <option value="SOLES">Soles</option>
          <option value="DOLARES">Dólares</option>
        </select>
        <div id="errorMoneda" class="col-sm-8 validation-error-cont text-right no-gutters pr-0"></div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label for="contactoInExt" class="col-sm-6 justify-content-end">Contacto:</label>
      <div class="col-sm-6">
        <input name="contacto" type="text" class="form-control col-lg-8" id="contactoInExt" style="width:100%" data-validation="required" data-validation-error-msg="Debe especificar el nombre del contacto" data-validation-error-msg-container="#errorContacto" placeholder="Ingrese el nombre del contacto" disabled>
        <div id="errorContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label for="telfContactoInExt" class="col-sm-6 justify-content-end">Telf. Contacto:</label>
      <div class="col-sm-6">
        <input name="telfContacto" type="text" class="form-control col-lg-8" id="telfContactoInExt" style="width:100%" data-validation="required" data-validation-error-msg="Debe especificar el teléfono del contacto" data-validation-error-msg-container="#errorTelfContacto" placeholder="Ingrese el teléfono del contacto" disabled>
        <div id="errorTelfContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label for="correoContactoInExt" class="col-sm-6 justify-content-end">Correo Contacto:</label>
      <div class="col-sm-6">
        <input name="correoContacto" type="text" class="form-control col-lg-8" id="correoContactoInExt" style="width:100%" data-validation="" data-validation-error-msg="Debe especificar el correo del contacto" data-validation-error-msg-container="#errorCorreoContacto" placeholder="Ingrese el correo del contacto" disabled>
        <div id="errorCorreoContacto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
      </div>
    </div>

    @if(false)
    <div class="form-group form-inline">
      <label for="observacionesIn" class="col-sm-6 justify-content-end">Observaciones</label>
      <textarea name="observaciones" type="text" class="form-control col-lg-8" id="observacionesIn" style="width:100%" placeholder="Ingrese sus observaciones" maxlength="255" rows="5"></textarea> 
    </div>
    @endif
    
    <div class="row justify-content-center">
      <button id="btnRegistrarRecepcion" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
    </div>
  </form>
</div>

@include('modals.registrarClienteCotizacion')
@include('modals.registrarVehiculoCotizacion')
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection