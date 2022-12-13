<button type="button"
        class="btn btn-warning"
        data-toggle="modal"
        data-target="#confirmarFactura-{{ $loop->iteration }}"
        data-backdrop="static"
        {{ $entregable->reproceso() ? '' : 'disabled' }}><i class="fas fa-dollar-sign"></i></button>
<!-- Modal -->

<div class="modal fade"
     id="confirmarFactura-{{ $loop->iteration }}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="confirmarEntregaLabel-{{ $loop->iteration }}"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="confirmarEntregaLabel-{{ $loop->iteration }}">
                    FACTURAR @if (is_a($entregable, 'App\Modelos\RecepcionOT'))
                        {{ $entregable->hojaTrabajo->placa_auto }} - OT:
                        {{ $entregable->getNroOT() }} @endif
                </h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">


                <form id="FormConfirmarEntrega-{{ $loop->iteration }}"
                      method="POST"
                      action="{{ route('garantia.facturar') }}"
                      value="Submit"
                      autocomplete="off">
                    @csrf

                    <input type="hidden"
                           name="id_recepcion_ot"
                           value="{{ $entregable->id_recepcion_ot }}" />

                    <div class="form-group d-flex xscroll_none">
                        <label for="nroFacturaIn-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Número
                            de Factura:
                        </label>
                        <input name="nro_factura"
                               type="text"
                               class="form-control col-sm-6"
                               id="nroFacturaIn-{{ $loop->iteration }}"
                               data-validation="required"
                               data-validation-error-msg="Debe ingresar el número de factura"
                               data-validation-error-msg-container="#errorNroFactura-{{ $loop->iteration }}"
                               placeholder="Ingrese el número de factura"
                               maxlength="32"
                               autocomplete="off" />
                        <div id="errorNroFactura-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>

                    <div class="form-group d-flex xscroll_none">
                        <label for="idCierreMarca-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">ID Cierre Marca:
                        </label>
                        <input name="id_cierre_marca"
                               type="text"
                               class="form-control col-sm-6"
                               id="idCierreMarca-{{ $loop->iteration }}"
                               data-validation="required"
                               data-validation-error-msg="Debe ingresar el ID de cierre"
                               data-validation-error-msg-container="#errorIdCierre-{{ $loop->iteration }}"
                               placeholder="Ingrese el ID de cierre"
                               maxlength="32"
                               autocomplete="off" />
                        <div id="errorIdCierre-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>

                    <div class="form-group d-flex xscroll_none">
                        <label for="fechaEntregaIn-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Fecha
                            de facturacion:</label>
                        <input name="fecha_factura"
                               type="text"
                               autocomplete="off"
                               class="datepicker form-control col-sm-6"
                               id="fechaEntregaIn-{{ $loop->iteration }}"
                               data-validation="date"
                               data-validation-format="dd/mm/yyyy"
                               data-validation-length="10"
                               data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa"
                               data-validation-error-msg-container="#errorFechaEntrega-{{ $loop->iteration }}"
                               placeholder="dd/mm/aaaa"
                               maxlength="10"
                               min-date="{{ date('d/m/Y') }}"    
                               {{-- value="{{ $entregable->minFechaEntrega() }}" --}} />

                        <div id="errorFechaEntrega-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>

                    <div class="custom-control custom-switch justify-content-end text-left d-flex mb-2">

                        <label for="fechaEntregaIn-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex"></label>

                        <div class="col-sm-6">
                            <input name="coin"
                                   type="checkbox"
                                   class="custom-control-input"
                                   id="tipoMoneda-{{ $loop->iteration }}">
                            <label class="custom-control-label"
                                   for="tipoMoneda-{{ $loop->iteration }}">Soles</label>
                        </div>
                    </div>

                    <div class="form-group d-flex xscroll_none">
                        <label for="montoManoObra-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Monto
                            mano de Obra (S/):
                        </label>
                        <input name="monto_mano_obra"
                               type="number"
                               class="form-control col-sm-6"
                               id="montoManoObra-{{ $loop->iteration }}"
                               step="any"
                               min="0"
                               data-validation="required"
                               data-validation-error-msg="Debe ingresar un monto de mano de obra"
                               data-validation-error-msg-container="#errorManoObra-{{ $loop->iteration }}"
                               placeholder="Ingrese monto mano de obra"
                               maxlength="32"
                               autocomplete="off"
                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))" />

                        <div id="errorManoObra-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>
                    <div class="form-group d-flex xscroll_none">
                        <label for="montoRepuestos-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Monto
                            Repuestos (S/):
                        </label>
                        <input name="monto_repuestos"
                               type="number"
                               class="form-control col-sm-6"
                               id="montoRepuestos-{{ $loop->iteration }}"
                               data-validation="required"
                               data-validation-error-msg="Debe ingresar un monto de repuesto"
                               data-validation-error-msg-container="#errorMontoRepuesto-{{ $loop->iteration }}"
                               placeholder="Ingrese el monto de repuesto"
                               maxlength="32"
                               step="any"
                               min="0"
                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                               autocomplete="off" />
                        <div id="errorMontoRepuesto-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>
                    <div class="form-group d-flex xscroll_none">
                        <label for="montoIncentivo-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Monto
                            Incentivo (S/):
                        </label>
                        <input name="monto_incentivo"
                               type="number"
                               class="form-control col-sm-6"
                               id="montoIncentivo-{{ $loop->iteration }}"
                               data-validation="required"
                               data-validation-error-msg="Debe ingresar un monto de incentivo"
                               data-validation-error-msg-container="#errorMontoIncentivo-{{ $loop->iteration }}"
                               placeholder="Ingrese monto de incentivo"
                               maxlength="32"
                               step="any"
                               min="0"
                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                               autocomplete="off" />
                        <div id="errorMontoIncentivo-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>

                </form>

                <div class="alert alert-danger"
                     role="alert"
                     align="center">
                    <h5>Valores ingresados sin IGV</h5>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Cerrar</button>
                <button id="btnSubmit-{{ $loop->iteration }}"
                        form="FormConfirmarEntrega-{{ $loop->iteration }}"
                        value="Submit"
                        type="submit"
                        class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>
