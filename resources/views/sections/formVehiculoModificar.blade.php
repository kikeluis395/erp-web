<div class="form-group form-inline">
  <label for="nroPlacaIn" class="col-sm-6 justify-content-end">Placa: </label>
  <input name="nroPlaca" type="text" class="form-control col-sm-6" required id="nroPlacaInModal" data-validation="length" data-validation-length="6" data-validation-error-msg="Debe ingresar una placa de 6 caracteres" data-validation-error-msg-container="#errorPlaca" placeholder="Ingrese el número de placa" maxlength="6" oninput="this.value = this.value.toUpperCase()" value="{{$vehiculo->getPlaca()}}">
  <div id="errorPlaca" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<fieldset id="infoVehiculo">
  <div class="form-group form-inline">
    <label for="vinIn" class="col-sm-6 justify-content-end">VIN: </label>
    <input name="vin" type="text" class="form-control col-sm-6" id="vinIn" required data-validation="length" data-validation-length="required" data-validation-error-msg="Debe ingresar un VIN" data-validation-error-msg-container="#errorVIN" placeholder="Ingrese el VIN" maxlength="17" oninput="this.value = this.value.toUpperCase()" value="{{$vehiculo->getVin()}}">
    <div id="errorVIN" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
@if(isset($id_recepcion_ot) || isset($datosRecepcionOT))
  <div class="form-group form-inline">
    <label for="motorIn" class="col-sm-6 justify-content-end">Motor: </label>
    <input name="motor" type="text" required class="form-control col-sm-6" id="motorIn" data-validation="length" data-validation-length="required" data-validation-error-msg="Debe ingresar un numero de motor" data-validation-error-msg-container="#errorMotor" maxlength="17"
	placeholder="Ingrese el número de motor" oninput="this.value = this.value.toUpperCase()" value="{{$vehiculo->getMotor()}}">
    <div id="errorMotor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
@endif

<div class="form-group form-inline">
  <label for="marcaAutoIn" class="col-sm-6 justify-content-end">Marca:</label>
  <select name="marcaAuto" id="marcaAutoIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorMarca" required onchange="desabilitar_combo_modelo_tecnico()">
{{-- <option value="" ></option> --}}
    @foreach ($listaMarcas as $marca)
        <option @if($vehiculo->getIdMarca()==$marca->getIdMarcaAuto()) selected @endif value="{{$marca->getIdMarcaAuto()}}" id="marca-{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
    @endforeach
  </select>
  <div id="errorMarca" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>

<div class="form-group form-inline">
  <label for="modeloTecnicoIn"
         class="col-sm-6 justify-content-end">Modelo Técnico:</label>
  <select name="modeloTecnico"                
          id="modeloTecnicoIn"
          class="form-control col-sm-6"
          onchange="control_modelo()"
          @if($vehiculo->getIdMarca()===2) style="display: none;" disabled @endif
          >
      {{-- <option value=""></option> --}}
      @foreach ($listaModelosTecnicos as $modeloTecnico)
          <option value="{{ $modeloTecnico->id_modelo_tecnico }}" {{$modeloTecnico->id_modelo_tecnico===$vehiculo->id_modelo_tecnico?'selected':''}}>{{ $modeloTecnico->nombre_modelo }}</option>
      @endforeach
  </select>

  <select name="modeloTecnico"
          id="modeloTecnicoIn2"
          class="form-control col-sm-6"
          @if($vehiculo->getIdMarca()===1) style="display: none;" disabled @endif          
          readonly          
          >
      {{-- <option value=""></option> --}}
      @foreach ($listaModelosTecnicos as $modeloTecnico)
        @if ($modeloTecnico->id_modelo_tecnico===58)
          <option value="{{ $modeloTecnico->id_modelo_tecnico }}" selected>{{ $modeloTecnico->nombre_modelo }}</option>
        @endif
      @endforeach
  </select>

  <div id="errorModeloTecnico"
  class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>

{{-- ////// --}}
<div class="form-group form-inline">
  <label for="nombreModelo"
         class="col-sm-6 justify-content-end">Modelo:</label>
  <input name="nombreModeloText"
         type="text"
         class="form-control col-sm-6"
         data-validation="required"
         data-validation-error-msg="Debe especificar el modelo de vehículo"
         data-validation-error-msg-container="#errorModelo"
         id="nombreModelo"
         placeholder="Ingrese el modelo"
         maxlength="30"
         value="{{$vehiculo->getModelo()}}"
         oninput="this.value = this.value.toUpperCase()"
         @if($vehiculo->getIdMarca()==1 && $vehiculo->id_modelo_tecnico!=58) style="display: none;" disabled @endif
         >

  <select name="nombreModelo"
          id="nombreModelo2"
          class="form-control col-sm-6"
          {{-- @if($vehiculo->getIdMarca()===2) style="display: none;" disabled @endif --}}
          @if($vehiculo->getIdMarca()===2||($vehiculo->getIdMarca()==1 && $vehiculo->id_modelo_tecnico===58)) style="display: none;" disabled @endif
          >
      {{-- <option value=""></option> --}}
      @foreach ($listaModelos as $modelo)       
        <option value="{{ $modelo->id_modelo }}" @if($vehiculo->modelo==$modelo->id_modelo) selected @endIf>{{ $modelo->nombre_modelo }}</option>
      @endforeach
  </select>
  <div id="errorModelo"
       class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>

@if(isset($id_recepcion_ot) || isset($datosRecepcionOT))
  <div class="form-group form-inline">
    <label for="colorIn" class="col-sm-6 justify-content-end">Color:</label>
    <input name="color" type="text" class="form-control col-sm-6" data-validation="required" data-validation-error-msg="Debe especificar el color del vehículo" data-validation-error-msg-container="#errorColor" id="colorIn" placeholder="Ingrese el color" maxlength="30" oninput="this.value = this.value.toUpperCase()" value="{{$vehiculo->getColor()}}">
    <div id="errorColor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
  <div class="form-group form-inline">
    <label for="anhoVehiculoIn" class="col-sm-6 justify-content-end">Año de fabricación:</label>
    <input name="anhoVehiculo" type="text" class="form-control col-sm-6" data-validation="required" data-validation-error-msg="Debe especificar el año del vehículo" data-validation-error-msg-container="#errorAnhoVehiculo" id="anhoVehiculoIn" placeholder="Ingrese el año" maxlength="4" oninput="this.value = this.value.toUpperCase()" value="{{$vehiculo->getAnhoVehiculo()}}">
    <div id="errorAnhoVehiculo" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>

  {{-- //// --}}
  <div class="form-group form-inline">
    <label for="anhoModelo"
           class="col-sm-6 justify-content-end">Año de modelo:</label>
    <input name="anhoModelo"
           type="number"
           class="form-control col-sm-6"
           data-validation="required"
           data-validation-error-msg="Debe especificar el año del vehículo"
           data-validation-error-msg-container="#errorAnhoModelo"
           id="anhoModelo"
           placeholder="Ingrese el año"
           maxlength="4"
           value="{{$vehiculo->anho_modelo}}"
           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"                                       
           required>
    <div id="errorAnhoModelo"
         class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
  {{-- ////////// --}}

  <div class="form-group form-inline">
    <label for="tipoTransmisionIn" class="col-sm-6 justify-content-end">Tipo de transmisión:</label>
    <select name="tipoTransmision" id="tipoTransmisionIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoTransmision" required>
      <option value=""></option>
      <option value="mecanico" @if($vehiculo->getTipoTransmision()=="mecanico") selected @endif >MECÁNICA</option>
      <option value="automatico"@if($vehiculo->getTipoTransmision()=="automatico") selected @endif >AUTOMÁTICA</option>
    </select>
    <div id="errorTipoTransmision" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
  <div class="form-group form-inline">
    <label for="tipoCombustibleIn" class="col-sm-6 justify-content-end">Tipo de combustible:</label>
    <select name="tipoCombustible" id="tipoCombustibleIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoCombustible" required>
      <option value=""></option>
      <option value="gasolina" @if($vehiculo->getTipoCombustible()=="gasolina") selected @endif>GASOLINA</option>
      <option value="gnv-glp" @if($vehiculo->getTipoCombustible()=="gnv-glp") selected @endif>GNV - GLP</option>
      <option value="petroleo" @if($vehiculo->getTipoCombustible()=="petroleo") selected @endif>PETRÓLEO</option>
    </select>
    <div id="errorTipoCombustible" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
@endif
  <input type="hidden" name="idCotizacion" id="idCotModVehi" value="{{isset($id_cotizacion) ? $id_cotizacion : null}}">
  <input type="hidden" name="idOT" id="idOTModVehi" value="{{isset($id_recepcion_ot) ? $id_recepcion_ot : null}}">
  <input type="hidden" name="esOT" id="flagOTModVehi" value="{{isset($id_recepcion_ot) || isset($datosRecepcionOT) ? true : false}}">
  <input type="hidden" name="esCotizacion" id="flagCotModVehi" value="{{isset($id_cotizacion) || isset($datosRecepcion) ? true : false}}">
</fieldset>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->

<script>
  $("#marcaAutoIn").change(function() {
      var selected_option = $('#marcaAutoIn').val();
      
      if (selected_option == '2') {
          $("#nombreModelo2").hide();
          document.querySelector('#nombreModelo2').removeAttribute('required')
          document.querySelector('#nombreModelo2').disabled = true
      
          $("#nombreModelo").show();
          $("#nombreModelo").prop('required', true)
          document.querySelector('#nombreModelo').disabled = false
      } else {
          $('#nombreModelo2').show();
          $("#nombreModelo2").prop('required', true)
          document.querySelector('#nombreModelo2').disabled = false

          $("#nombreModelo").hide();
          document.querySelector('#nombreModelo').removeAttribute('required')
          document.querySelector('#nombreModelo').disabled = true

          $("#modeloTecnicoIn").val('1')
      }
  });

  function desabilitar_combo_modelo_tecnico() {
      var valor = $('#marcaAutoIn').val()
      var id_mod = 58;
      var name_mod = 'OTROS MODELOS';

      if (valor == 2) {
          $("#modeloTecnicoIn").css("display", "none");
          $("#modeloTecnicoIn").prop("disabled", true);
          
          $("#modeloTecnicoIn2").css("display", "block");
          document.querySelector('#modeloTecnicoIn2').disabled=false
          $('#modeloTecnicoIn2').append('<option value="' + id_mod + '" selected>' + name_mod + '</option>');
      } else {
          $("#modeloTecnicoIn").css("display", "block");
          document.querySelector('#modeloTecnicoIn').disabled=false
          $("#modeloTecnicoIn2 option").remove();
          $("#modeloTecnicoIn2").css("display", "none");
          $("#modeloTecnicoIn2").prop("disabled", true);
      }
  }

  function control_modelo() {
      var valor = $('#modeloTecnicoIn').val();

      if (valor == 58) {
          $("#nombreModelo2").hide();
          document.querySelector('#nombreModelo2').disabled=true
          $("#nombreModelo").show();
          document.querySelector('#nombreModelo').disabled=false
      } else {
          $("#nombreModelo2").show();
          document.querySelector('#nombreModelo2').disabled=false
          $("#nombreModelo").hide();
          document.querySelector('#nombreModelo').disabled=true
      }
  }
</script>