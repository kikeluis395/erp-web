<div class="form-group form-inline row"
     style="display: flex; justify-content: center">
    <button type="button"
            class="btn btn-success btn-tabla"
            data-toggle="modal"
            data-target="#modalEntregarVehiculo"
            data-backdrop="static">
        Entregar Vehículo
    </button>
</div>

<div class="modal fade"
     id="modalEntregarVehiculo"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modalEntregarVehiculo"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="confirmarEntregaLabel">
                    NOTA DE ENTREGA {{ $datosRecepcionOT->hojaTrabajo->placa_auto }} - OT: {{ $datosRecepcionOT->getNroOT() }}
                </h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh; overflow-y: auto">
                <form id="FormEntregarVehiculo"
                      method="POST"
                      action="{{ route('garantia.store') }}"
                      value="Submit"
                      autocomplete="off">
                    @csrf

                    <input type="hidden"
                           value="{{ $datosRecepcionOT->id_recepcion_ot }}"
                           name="id_recepcion_ot" />

                    <div class="form-group">
                        <label for="observacionesIn">Observaciones:</label>
                        <textarea name="observaciones_entrega"
                                  type="text"
                                  class="form-control"
                                  id="observacionesIn"
                                  placeholder="Ingrese sus observaciones"
                                  maxlength="255"
                                  rows="3"
                                  form="FormEntregarVehiculo"
                                  data-validation-error-msg-container="#errorObservaciones"
                                  autocomplete="off"></textarea>

                        <div id="errorObservaciones"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal" id="close-entregar">
                    Cerrar
                </button>
                <button id="btnSubmit"
                        form="FormEntregarVehiculo"
                        value="Submit"
                        type="submit"
                        class="btn btn-primary">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
