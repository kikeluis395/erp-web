<div class="form-group form-inline">
  <label for="nroParteIn" class="col-sm-6 justify-content-end">Número de parte:</label>
  <input name="nroParte" type="text" class="form-control col-sm-6" id="nroParteIn" data-validation="required length" data-validation-length="max45" data-validation-error-msg="Debe ingresar un número de parte de 45 caracteres máximo" data-validation-error-msg-container="#errorNroParte" placeholder="Ingrese el número de parte" maxlength="45" oninput="this.value = this.value.toUpperCase()">
  <div id="errorNroParte" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<div class="form-group form-inline">
  <label for="descripcionIn" class="col-sm-6 justify-content-end">Descripción:</label>
  <input name="descripcion" type="text" class="form-control col-sm-6" id="descripcionIn" placeholder="Ingrese el número de parte" disabled>
</div>
<div class="form-group form-inline">
  <label for="cantidadIn" class="col-sm-6 justify-content-end">Cantidad:</label>
  <input name="cantidad" type="text" class="form-control col-sm-6" id="cantidadIn" data-validation="number required" data-validation-allowing="float" data-validation-error-msg="Debe especificar una cantidad" data-validation-error-msg-container="#errorCantidad" placeholder="Ingrese una cantidad" maxlength="6">
  <div id="errorCantidad" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>