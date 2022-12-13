@include('sections.formAgregarRepuestoCotizacion')
<div id="disponibilidadCont" class="form-group form-inline" style="display: none">
  <label class="col-sm-6 justify-content-end">Disponibilidad:</label>
  <div id="disponibilidad" class="col-sm-6 text-left"></div>
</div>
<div class="form-group form-inline" id="importacionCont" style="display: none">
  <label for="importacionIn" class="col-sm-6 justify-content-end">Status Pedido:</label>
  <select name="esImportacion" id="importacionIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorImportacion">
    <option value=""></option>
    <option value="0">EN TRÁNSITO</option>
    <option value="1">EN IMPORTACIÓN</option>
  </select>
  <div id="errorImportacion" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<fieldset id="fechasImportacion" style="display: none">
<div class="form-group form-inline">
  <label for="fechaPedidoIn" class="col-sm-6 justify-content-end">Fecha pedido:</label>
  <input name="fechaPedido" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaPedidoIn" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" data-validation-length="10" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaPedido" autocomplete="off">
  <div id="errorFechaPedido" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<div id="fechaPromesaRepuestoIn" class="form-group form-inline">
  <label for="fechaPromesaIn" class="col-sm-6 justify-content-end">Fecha promesa:</label>
  <input name="fechaPromesa" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaPromesaIn" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" data-validation-length="10" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaPromesa" autocomplete="off">
  <div id="errorFechaPromesa" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
</fieldset>