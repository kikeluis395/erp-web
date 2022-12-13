<div class="form-group form-inline">
  <label for="tipoIDIn" class="col-sm-6 justify-content-end">Tipo de Documento:</label>
  <select name="tipoID" id="tipoIDIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoID" required>
    <option value=""></option>
    <option value="RUC">RUC</option>
    <option value="DNI">DNI</option>
    <option value="CE">CARNET EXTRANJERIA</option>
  </select>
  <div id="errorTipoID" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<div class="form-group form-inline">
  <label for="clienteIn" class="col-sm-6 justify-content-end">Documento Cliente:</label>
  <input name="cliente" type="text" class="form-control col-sm-6" id="clienteInModal" data-validation="required" data-validation-error-msg="Debe especificar el DNI o RUC del cliente" data-validation-error-msg-container="#errorCliente" placeholder="Ingrese el DNI o RUC del cliente" maxlength="15">
  <div id="errorCliente" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<fieldset id="infoCliente">
  <div class="form-group form-inline">
    <label for="nombresIn" class="col-sm-6 justify-content-end">Nombre(s):</label>
    <input name="nombres" type="text" class="form-control col-sm-6" id="nombresIn" data-validation="required" data-validation-error-msg="Debe especificar el nombre del cliente" data-validation-error-msg-container="#errorNombres" placeholder="Ingrese el nombre del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
    <div id="errorNombres" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
  <fieldset id="fieldsetPNatural">
    <div class="form-group form-inline" id="apellidoPatLine">
      <label for="apellidoPatIn" class="col-sm-6 justify-content-end">Apellido Paterno:</label>
      <input name="apellidoPat" type="text" class="form-control col-sm-6" id="apellidoPatIn" data-validation="required" data-validation-error-msg="Debe especificar el apellido paterno del cliente" data-validation-error-msg-container="#errorApellidoPat" placeholder="Ingrese el apellido paterno del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
      <div id="errorApellidoPat" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
    <div class="form-group form-inline" id="apellidoMatLine">
      <label for="apellidoMatIn" class="col-sm-6 justify-content-end">Apellido Materno:</label>
      <input name="apellidoMat" type="text" class="form-control col-sm-6" id="apellidoMatIn" data-validation="required" data-validation-error-msg="Debe especificar el apellido materno del cliente" data-validation-error-msg-container="#errorApellidoMat" placeholder="Ingrese el apellido materno del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
      <div id="errorApellidoMat" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
    </div>
  </fieldset>
  <div class="form-group form-inline">
    <label for="telefonoIn" class="col-sm-6 justify-content-end">Teléfono:</label>
    <input name="telefono" type="text" class="form-control col-sm-6" id="telefonoIn" placeholder="Ingrese el número de teléfono" maxlength="45">
  </div>
  <div class="form-group form-inline">
    <label for="emailIn" class="col-sm-6 justify-content-end">Email:</label>
    <input name="email" type="email" class="form-control col-sm-6" id="emailIn" placeholder="Ingrese el email de contacto" data-validation="" data-validation-error-msg="Debe especificar el e-mail del cliente" data-validation-error-msg-container="#errorEmail" maxlength="45">
    <div id="errorEmail" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
  </div>
</fieldset>