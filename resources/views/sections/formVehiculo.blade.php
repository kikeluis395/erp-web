<div class="form-group form-inline">
    <label for="nroPlacaIn"
           class="col-sm-6 justify-content-end">Placa: </label>
    <input name="nroPlaca"
           type="text"
           class="form-control col-sm-6"
           id="nroPlacaInModal"
           data-validation="length"
           data-validation-length="6"
           data-validation-error-msg="Debe ingresar una placa de 6 caracteres"
           data-validation-error-msg-container="#errorPlaca"
           placeholder="Ingrese el número de placa"
           maxlength="6"
           oninput="this.value = this.value.trim().toUpperCase()"
           required>
    <div id="errorPlaca"
         class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
  <fieldset id="infoVehiculo">
    <div class="form-group form-inline">
        <label for="vinIn"
               class="col-sm-6 justify-content-end">VIN: </label>
        <input name="vin"
               type="text"
               class="form-control col-sm-6"
               id="vinIn"
               data-validation="length"
               data-validation-length="required"
               data-validation-error-msg="Debe ingresar un VIN"
               data-validation-error-msg-container="#errorVIN"
               placeholder="Ingrese el VIN"
               maxlength="17"
               minlength="17"
               oninput="this.value = this.value.trim().toUpperCase()"
               required>
        <div id="errorVIN"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="motorIn"
               class="col-sm-6 justify-content-end">Motor: </label>
        <input name="motor"
               type="text"
               class="form-control col-sm-6"
               id="motorIn"
               data-validation="length"
               data-validation-length="required"
               data-validation-error-msg="Debe ingresar un numero de motor"
               data-validation-error-msg-container="#errorMotor"
               placeholder="Ingrese el número de motor"
               oninput="this.value = this.value.trim().toUpperCase()"
               maxlength="17"
               required>
        <div id="errorMotor"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="marcaAutoIn"
               class="col-sm-6 justify-content-end">Marca:</label>
        <select name="marcaAuto"
                id="marcaAutoIn"
                class="form-control col-sm-6"
                data-validation="length"
                data-validation-length="min1"
                data-validation-error-msg="Debe seleccionar una opción"
                data-validation-error-msg-container="#errorMarca"
                required
                onchange="desabilitar_combo_modelo_tecnico()">
            <option value=""
                    selected="selected"></option>
            @foreach ($listaMarcas as $marca)
                <option value="{{ $marca->getIdMarcaAuto() }}">{{ $marca->getNombreMarca() }}</option>
            @endforeach
        </select>
        <div id="errorMarca"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
  
    <div class="form-group form-inline">
        <label for="modeloTecnicoIn"
               class="col-sm-6 justify-content-end">Modelo Técnico:</label>
        <select name="modeloTecnico"                
                id="modeloTecnicoIn"
                class="form-control col-sm-6"
                onchange="control_modelo()">
            <option value=""></option>
            @foreach ($listaModelosTecnicos as $modeloTecnico)
                <option value="{{ $modeloTecnico->id_modelo_tecnico }}">{{ $modeloTecnico->nombre_modelo }}</option>
            @endforeach
        </select>
  
        <select name="modeloTecnico"
                id="modeloTecnicoIn2"
                class="form-control col-sm-6"
                style="display: none;"
                readonly
                disabled
                >
            <option value=""></option>
        </select>
  
        <div id="errorModeloTecnico"
        class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
  
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
               oninput="this.value = this.value.toUpperCase()"
               style="display: none;"
               >
  
        <select name="nombreModelo"
                id="nombreModelo2"
                class="form-control col-sm-6"
                >
            <option value=""></option>
            @foreach ($listaModelos as $modelo)
                <option value="{{ $modelo->id_modelo }}">{{ $modelo->nombre_modelo }}</option>
            @endforeach
        </select>
        <div id="errorModelo"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
  
    <div class="form-group form-inline">
        <label for="colorIn"
               class="col-sm-6 justify-content-end">Color:</label>
        <input name="color"
               type="text"
               class="form-control col-sm-6"
               data-validation="required"
               data-validation-error-msg="Debe especificar el color del vehículo"
               data-validation-error-msg-container="#errorColor"
               id="colorIn"
               placeholder="Ingrese el color"
               maxlength="30"
               oninput="this.value = this.value.toUpperCase()"
               required>
        <div id="errorColor"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="anhoVehiculoIn"
               class="col-sm-6 justify-content-end">Año de fabricación:</label>
        <input name="anhoVehiculo"
               type="number"
               class="form-control col-sm-6"
               data-validation="required"
               data-validation-error-msg="Debe especificar el año del vehículo"
               data-validation-error-msg-container="#errorAnhoVehiculo"
               id="anhoVehiculoIn"
               placeholder="Ingrese el año"
               maxlength="4"
               minlength="4"
               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"                                       
               required>
        <div id="errorAnhoVehiculo"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
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
               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"                                       
               required>
        <div id="errorAnhoModelo"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="tipoTransmisionIn"
               class="col-sm-6 justify-content-end">Tipo de transmisión:</label>
        <select name="tipoTransmision"
                id="tipoTransmisionIn"
                class="form-control col-sm-6"
                data-validation="length"
                data-validation-length="min1"
                data-validation-error-msg="Debe seleccionar una opción"
                data-validation-error-msg-container="#errorTipoTransmision"
                required>
            <option value=""></option>
            <option value="mecanico">MECÁNICA</option>
            <option value="automatico">AUTOMÁTICA</option>
        </select>
        <div id="errorTipoTransmision"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="tipoCombustibleIn"
               class="col-sm-6 justify-content-end">Tipo de combustible:</label>
        <select name="tipoCombustible"
                id="tipoCombustibleIn"
                class="form-control col-sm-6"
                data-validation="length"
                data-validation-length="min1"
                data-validation-error-msg="Debe seleccionar una opción"
                data-validation-error-msg-container="#errorTipoCombustible"
                required>
            <option value=""></option>
            <option value="gasolina">GASOLINA</option>
            <option value="gnv-glp">GNV - GLP</option>
            <option value="petroleo">PETRÓLEO</option>
        </select>
        <div id="errorTipoCombustible"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
  </fieldset>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
        type="text/javascript"></script>

  
  <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
  
  <script>
    $("#marcaAutoIn").change(function() {
        var selected_option = $('#marcaAutoIn').val();
        
        if (selected_option == '2') {
            $("#nombreModelo2").hide();
            document.querySelector('#nombreModelo2').removeAttribute('required')
            document.querySelector('#nombreModelo2').disabled = true
        
            $("#nombreModelo").show();
            document.querySelector('#nombreModelo').setAttribute('required', true)              
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
            // $("#modeloTecnicoIn2").removeProp("disabled");
            $('#modeloTecnicoIn2').append('<option value="' + id_mod + '" selected>' + name_mod + '</option>');
        } else {
            $("#modeloTecnicoIn").css("display", "block");
            document.querySelector('#modeloTecnicoIn').disabled=false
            // $("#modeloTecnicoIn").removeProp("disabled");
            $("#modeloTecnicoIn2 option").remove();
            //$("#modeloTecnicoIn").val("SELECCIONAR").trigger("change");
            $("#modeloTecnicoIn2").css("display", "none");
            $("#modeloTecnicoIn2").prop("disabled", true);
        }
    }
  
    function control_modelo() {
      var valor = $('#modeloTecnicoIn').val();

      if (valor == 58) {
          $("#nombreModelo2").hide();
          document.querySelector('#nombreModelo2').disabled=true
          document.querySelector('#nombreModelo2').removeAttribute('required')

          $("#nombreModelo").show();
          document.querySelector('#nombreModelo').setAttribute('required', true)          
          document.querySelector('#nombreModelo').disabled=false
      } else {
          $("#nombreModelo2").show();         
          document.querySelector('#nombreModelo2').setAttribute('required', true)
          document.querySelector('#nombreModelo2').disabled=false

          $("#nombreModelo").hide();
          document.querySelector('#nombreModelo').disabled=true
          document.querySelector('#nombreModelo').removeAttribute('required')
      }
  }
  </script>
  