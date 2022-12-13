<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregarTipoCambioModal" data-backdrop="static">
  Registrar
</button>

<!-- Modal -->
<div class="modal fade" id="agregarTipoCambioModal" tabindex="-1" role="dialog" aria-labelledby="agregarTipoCambioLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="agregarTipoCambioLabel">Registrar Tipo de Cambio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarTipoCambio" method="POST" action="{{route('tipoCambio.store')}}" value="Submit" autocomplete="off">
          @csrf
          <div class="form-group form-inline">
            <label for="TCCompraIn" class="col-sm-6 justify-content-end">T.C. Compra (S/.):</label>
            <input name="tipoCambioCompra" type="text" class="form-control col-sm-6" id="TCCompraIn" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe especificar el tipo de cambio para la compra" data-validation-error-msg-container="#errorTCCompra" placeholder="Ingrese el tipo de cambio para la compra" maxlength="45">
            <div id="errorTCCompra" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          <div class="form-group form-inline">
            <label for="TCVentaIn" class="col-sm-6 justify-content-end">T.C. Venta (S/.):</label>
            <input name="tipoCambioVenta" type="text" class="form-control col-sm-6" id="TCVentaIn" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe especificar el tipo de cambio para la venta" data-validation-error-msg-container="#errorTCVenta" placeholder="Ingrese el tipo de cambio para la venta" maxlength="45">
            <div id="errorTCVenta" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          <div class="form-group form-inline">
            <label for="TCCobroIn" class="col-sm-6 justify-content-end">T.C. Cobro (S/.):</label>
            <input name="tipoCambioCobro" type="text" class="form-control col-sm-6" id="TCCobroIn" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe especificar el tipo de cambio para el cobro" data-validation-error-msg-container="#errorTCCobro" placeholder="Ingrese el tipo de cambio para el cobro" maxlength="45">
            <div id="errorTCCobro" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnRegistrarTipoCambio" form="FormRegistrarTipoCambio" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>