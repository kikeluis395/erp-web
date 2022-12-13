<div class="form-group form-inline">
<label class="col-sm-6 justify-content-end">Tipo de Documento:</label>
    <select name="tipoID"
            id="tipoIDIn"
            class="form-control col-sm-6"
            data-validation="length"
            data-validation-length="min1"
            data-validation-error-msg="Debe seleccionar una opción"
            data-validation-error-msg-container="#errorTipoID"
            required>
        <option value=""></option>
        <option value="RUC">RUC</option>
        <option value="DNI">DNI</option>
        <option value="CE">CARNET EXTRANJERIA</option>
    </select>
    <div id="errorTipoID"
         class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<div class="form-group form-inline">
    <label for="clienteIn"
           class="col-sm-6 justify-content-end">Documento Cliente:</label>
    <input name="cliente"
           type="number"
           class="form-control col-sm-6"
           id="clienteInModal"
           data-validation="required"
           data-validation-error-msg="Debe especificar el DNI o RUC del cliente"
           data-validation-error-msg-container="#errorCliente"
           placeholder="Ingrese el DNI o RUC del cliente"
           maxlength="11"
           minlength="8"
           required
           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
    <div id="errorCliente"
         class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<fieldset id="infoCliente">
    <div class="form-group form-inline">
        <label for="nombresIn"
               class="col-sm-6 justify-content-end">Nombre(s):</label>
        <input name="nombres"
               type="text"
               class="form-control col-sm-6"
               id="nombresIn"
               data-validation="required"
               data-validation-error-msg="Debe especificar el nombre del cliente"
               data-validation-error-msg-container="#errorNombres"
               placeholder="Ingrese el nombre del cliente"
               maxlength="45"
               oninput="this.value = this.value.toUpperCase()"
               required>
        <div id="errorNombres"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <fieldset id="fieldsetPNatural">
        <div class="form-group form-inline"
             id="apellidoPatLine">
            <label for="apellidoPatIn"
                   class="col-sm-6 justify-content-end">Apellido Paterno:</label>
            <input name="apellidoPat"
                   type="text"
                   class="form-control col-sm-6"
                   id="apellidoPatIn"
                   data-validation="required"
                   data-validation-error-msg="Debe especificar el apellido paterno del cliente"
                   data-validation-error-msg-container="#errorApellidoPat"
                   placeholder="Ingrese el apellido paterno del cliente"
                   maxlength="45"
                   oninput="this.value = this.value.toUpperCase()"
                   required>
            <div id="errorApellidoPat"
                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
        </div>
        <div class="form-group form-inline"
             id="apellidoMatLine">
            <label for="apellidoMatIn"
                   class="col-sm-6 justify-content-end">Apellido Materno:</label>
            <input name="apellidoMat"
                   type="text"
                   class="form-control col-sm-6"
                   id="apellidoMatIn"
                   data-validation="required"
                   data-validation-error-msg="Debe especificar el apellido materno del cliente"
                   data-validation-error-msg-container="#errorApellidoMat"
                   placeholder="Ingrese el apellido materno del cliente"
                   maxlength="45"
                   oninput="this.value = this.value.toUpperCase()"
                   required>
            <div id="errorApellidoMat"
                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
        </div>
        <div class="form-group form-inline"
             id="sexoLine">
            <label for="sexoIn"
                   class="col-sm-6 justify-content-end">Sexo:</label>
            <select name="sexo"
                    id="sexoIn"
                    class="form-control col-sm-6"
                    data-validation="length"
                    data-validation-length="min1"
                    data-validation-error-msg="Debe seleccionar una opción"
                    data-validation-error-msg-container="#errorSexo"
                    required>
                <option value=""></option>
                <option value="F">FEMENINO</option>
                <option value="M">MASCULINO</option>
            </select>
            <div id="errorSexo"
                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
        </div>
        <div class="form-group form-inline"
             id="estadoCivilLine">
            <label for="estadoCivilIn"
                   class="col-sm-6 justify-content-end">Estado Civil:</label>
            <select name="estadoCivil"
                    id="estadoCivilIn"
                    class="form-control col-sm-6"
                    data-validation="length"
                    data-validation-length="min1"
                    data-validation-error-msg="Debe seleccionar una opción"
                    data-validation-error-msg-container="#errorEstadoCivil"
                    required>
                <option value=""></option>
                <option value="S">SOLTERO(A)</option>
                <option value="C">CASADO(A)</option>
                <option value="V">VIUDO(A)</option>
                <option value="D">DIVORCIADO(A)</option>
            </select>
            <div id="errorEstadoCivil"
                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
        </div>
    </fieldset>
    <div class="form-group form-inline">
        <label for="departamentoIn"
               class="col-sm-6 justify-content-end">Departamento:</label>
        <select name="departamento"
                id="departamentoIn"
                class="form-control col-sm-6"
                data-validation="length"
                data-validation-length="min1"
                data-validation-error-msg="Debe seleccionar un departamento"
                data-validation-error-msg-container="#errorDepartamento"
                required>
            <option value=""></option>
            @foreach ($listaDepartamentos as $departamento)
                <option value="{{ $departamento->codigo_departamento }}">{{ $departamento->departamento }}</option>
            @endforeach
        </select>
        <div id="errorDepartamento"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="provinciaIn"
               class="col-sm-6 justify-content-end">Provincia:</label>
        <select name="provincia"
                id="provinciaIn"
                class="form-control col-sm-6"
                data-validation="length"
                data-validation-length="min1"
                data-validation-error-msg="Debe seleccionar una provincia"
                data-validation-error-msg-container="#errorProvincia"
                required>
            <option value=""></option>
            @if (false)
                @foreach ($listaProvincias as $provincia)
                    <option value="{{ $provincia->codProvincia }}">{{ $provincia->nombre }}</option>
                @endforeach
            @endif
        </select>
        <div id="errorProvincia"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="distritoIn"
               class="col-sm-6 justify-content-end">Distrito:</label>
        <select name="distrito"
                id="distritoIn"
                class="form-control col-sm-6"
                data-validation="length"
                data-validation-length="min1"
                data-validation-error-msg="Debe seleccionar un distrito"
                data-validation-error-msg-container="#errorDistrito"
                required>
            <option value=""></option>
            @if (false)
                @foreach ($listaDistritos as $distrito)
                    <option value="{{ $distrito->codDistrito }}">{{ $distrito->nombre }}</option>
                @endforeach
            @endif
        </select>
        <div id="errorDistrito"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="direccionIn"
               class="col-sm-6 justify-content-end">Dirección:</label>
        <input name="direccion"
               type="text"
               class="form-control col-sm-6"
               id="direccionIn"
               data-validation="required"
               data-validation-error-msg="Debe especificar la direccion del cliente"
               data-validation-error-msg-container="#errorDireccion"
               placeholder="Ingrese la direccion del cliente"
               maxlength="45"
               oninput="this.value = this.value.toUpperCase()"
               required>
        <div id="errorDireccion"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline">
        <label for="telefonoIn"
               class="col-sm-6 justify-content-end">Teléfono:</label>
        <input name="telefono"
               type="text"
               class="form-control col-sm-6"
               id="telefonoIn"
               placeholder="Ingrese el número de teléfono"
               maxlength="45"
               required>
    </div>
    <div class="form-group form-inline">
        <label for="emailIn"
               class="col-sm-6 justify-content-end">Email:</label>
        <input name="email"
               type="email"
               class="form-control col-sm-6"
               id="emailIn"
               placeholder="Ingrese el email de contacto"
               data-validation=""
               data-validation-error-msg="Debe especificar el e-mail del cliente"
               data-validation-error-msg-container="#errorEmail"
               maxlength="45"
               required>
        <div id="errorEmail"
             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
</fieldset>
