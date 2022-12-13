<button id="btnGenerarCompra" type="button" class="btn btn-warning" data-toggle="modal" data-target="#generarCompraModal" data-backdrop="static">Registrar Compra</button>
<!-- Modal -->
<div class="modal fade" id="generarCompraModal" tabindex="-1" role="dialog" aria-labelledby="generarCompraLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="generarCompraLabel">Registro de compras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="FormGenerarCompra" method="POST" 
        action=""
        value="Submit" autocomplete="off">
          @csrf
          <fieldset id="seccionForm">
            <div>
              <div class="form-group form-inline">
                <label for="tipoIn" class="col-sm-6 justify-content-end">Tipo:</label>
                <select name="tipo" id="tipoIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipo" required>
                  <option value="REPUESTOS">REPUESTOS</option>
                  <option value="SERVICIOS TERCEROS">SERVICIOS TERCEROS</option>
                </select>
                <div id="errorTipo" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <div class="form-group form-inline">
                <label for="ordenCompraIn" class="col-sm-6 justify-content-end">Orden de Compra:</label>
                <input name="ordenCompra" type="text" class="form-control col-sm-6" id="ordenCompraIn" data-validation="required" data-validation-error-msg="Debe especificar el numero de orden de compra" data-validation-error-msg-container="#errorOrdenCompra" placeholder="Ingrese el numero de orden de compra" maxlength="45" oninput="this.value = this.value.toUpperCase()">
                <div id="errorOrdenCompra" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <div class="form-group form-inline">
                <label for="facturaIn" class="col-sm-6 justify-content-end">Numero de factura:</label>
                <input name="factura" type="text" class="form-control col-sm-6" id="facturaIn" data-validation="required" data-validation-error-msg="Debe especificar la factura de compra" data-validation-error-msg-container="#errorFactura" placeholder="Ingrese la factura de la compra" maxlength="45" oninput="this.value = this.value.toUpperCase()">
                <div id="errorFactura" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <div id="containerOTIn" class="form-group form-inline">
                <label for="OTIn" class="col-sm-6 justify-content-end">Numero de OT:</label>
                <input name="nroOT" type="text" class="form-control col-sm-6" id="OTIn" data-validation-error-msg="Debe especificar el numero de OT" data-validation-error-msg-container="#errorNroOT" placeholder="Ingrese el numero de OT" maxlength="45">
                <div id="errorNroOT" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <div class="form-group form-inline">
                <label for="proveedorIn" class="col-sm-6 justify-content-end">Proveedor:</label>
                <select name="proveedor" id="proveedorIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorProveedor" required>
                  <option value=""></option>
                  @foreach($listaProveedores as $proveedor)
                  <option value="{{$proveedor->id_proveedor}}">{{$proveedor->nombre_proveedor}}</option>
                  @endforeach
                </select>
                <div id="errorProveedor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <div class="form-group form-inline">
                <label for="formaPagoIn" class="col-sm-6 justify-content-end">Forma de pago:</label>
                <select name="formaPago" id="formaPagoIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorFormaPago" required>
                  <option value=""></option>
                  <option value="CONTADO">AL CONTADO</option>
                  <option value="CREDITO">CRÉDITO</option>
                </select>
                <div id="errorFormaPago" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              @if(false)
              <div class="form-group form-inline">
                <label for="estadoIn" class="col-sm-6 justify-content-end">Estado:</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="estadoRadio" id="estadoRadioActivo" value="1">
                  <label class="form-check-label" for="estadoRadioActivo">Activo</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="estadoRadio" id="estadoRadioNulo" value="0">
                  <label class="form-check-label" for="estadoRadioNulo">Nulo</label>
                </div>
              </div>
              @endif
              <div class="form-group form-inline">
                <label for="tipoMonedaIn" class="col-sm-6 justify-content-end">Tipo Moneda:</label>
                <select name="tipoMoneda" id="tipoMonedaIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoMoneda" required>
                  <option value=""></option>
                  <option value="SOLES">S/</option>
                  <option value="DOLARES">USD $</option>
                </select>
                <div id="errorTipoMoneda" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              @if(false)
              <div class="form-group form-inline">
                <label for="tipoCambioIn" class="col-sm-6 justify-content-end">Tipo de Cambio:</label>
                <input name="tipoCambio" type="text" class="form-control col-sm-6" id="tipoCambioIn" data-validation="required" data-validation-error-msg="Debe especificar el tipo de cambio" data-validation-error-msg-container="#errorTipoCambio" placeholder="Ingrese el tipo de cambio" maxlength="45" oninput="this.value = this.value.toUpperCase()">
                <div id="errorTipoCambio" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              @endif
              <div class="form-group form-inline">
                <label for="fechaEntregaIn" class="col-sm-6 justify-content-end">Fecha de entrega: </label>
                <input name="fechaEntrega" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaEntregaIn" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaEntrega" placeholder="dd/mm/aaaa" maxlength="10" autocomplete="off">
                <div id="errorFechaEntrega" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnSubmit" form="FormGenerarCompra" value="Submit" type="submit" class="btn btn-primary">Registrar Cambios</button>
      </div>
    </div>
  </div>
</div>