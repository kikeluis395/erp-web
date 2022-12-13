<button type="button"
        class="btn btn-info"
        data-toggle="modal"
        data-target="#seguimientoGarantia-{{ $loop->iteration }}"
        data-backdrop="static"
        {{ $entregable->retrabajo() ? 'disabled' : '' }}><i class="fas fa-forward"></i></button>

<div class="modal fade"
     id="seguimientoGarantia-{{ $loop->iteration }}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="seguimientoGarantia-{{ $loop->iteration }}"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">

            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="confirmarEntregaLabel-{{ $loop->iteration }}">
                    SEGUIMIENTO
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


                <form id="FormSeguimientoGarantia-{{ $loop->iteration }}"
                      method="POST"
                      action="{{ route($entregable->reproceso() ? 'garantia.motivo' : 'garantia.registrar') }}"
                      value="Submit"
                      autocomplete="off">
                    @csrf

                    <input type="hidden"
                           name="id_recepcion_ot"
                           value="{{ $entregable->id_recepcion_ot }}" />

                    <input type="hidden"
                           name="id_seguimiento_garantia"
                           value="{{ $entregable->linea_garantia->id_seguimiento_garantia }}" />

                    <div class="form-group d-flex xscroll_none">
                        <label for="fechaCargaPortal-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Fecha carga a portal
                            marca:</label>

                        <input name="fecha_carga_portal"
                               type="text"
                               autocomplete="off"
                               class="datepicker form-control col-sm-6"
                               id="fechaCargaPortal-{{ $loop->iteration }}"
                               data-validation="date"
                               data-validation-format="dd/mm/yyyy"
                               data-validation-length="10"
                               data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa"
                               data-validation-error-msg-container="#errorFechaCargaPortal-{{ $loop->iteration }}"
                               placeholder="dd/mm/aaaa"
                               maxlength="10"
                               min-date="{{ date('d/m/Y') }}"
                               value="{{ $entregable->reproceso() ? date('d/m/Y', strtotime($entregable->linea_garantia->fecha_carga)) : '' }}"
                               {{-- value="{{ $entregable->reproceso() ? $entregable->linea_garantia->fecha_carga : '' }}" --}}
                               {{ $entregable->reproceso() ? 'readonly disabled' : '' }} />

                        <div id="errorFechaCargaPortal-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>

                    <div class="form-group d-flex xscroll_none">
                        <label for="codigoRegistroPortal-{{ $loop->iteration }}"
                               class="col-sm-6 justify-content-start align-items-center d-flex">Codigo de registro en
                            portal:
                        </label>
                        <input name="codigo_registro_portal"
                               type="text"
                               class="form-control col-sm-6"
                               id="codigoRegistroPortal-{{ $loop->iteration }}"
                               data-validation="required"
                               data-validation-error-msg="Debe ingresar codigo de registro"
                               data-validation-error-msg-container="#errorCodigoRegistro-{{ $loop->iteration }}"
                               placeholder="Ingrese codigo de registro portal"
                               maxlength="32"
                               autocomplete="off"
                               value="{{ $entregable->reproceso() ? $entregable->linea_garantia->codigo_registro : '' }}" />

                        <div id="errorCodigoRegistro-{{ $loop->iteration }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0">
                        </div>
                    </div>

                    @if ($entregable->reproceso())
                        <div class="form-group d-flex xscroll_none">
                            <label for="fechaReprocesoGarantia-{{ $loop->iteration }}"
                                   class="col-sm-6 justify-content-start align-items-center d-flex">Fecha de reproceso
                                garantía:</label>
                            <input name="fecha_reproceso_garantia"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control col-sm-6"
                                   id="fechaReprocesoGarantia-{{ $loop->iteration }}"
                                   data-validation="date"
                                   data-validation-format="dd/mm/yyyy"
                                   data-validation-length="10"
                                   data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa"
                                   data-validation-error-msg-container="#errorFechaReproceso-{{ $loop->iteration }}"
                                   placeholder="dd/mm/aaaa"
                                   maxlength="10"
                                   min-date="{{ date('d/m/Y') }}" />

                            <div id="errorFechaReproceso-{{ $loop->iteration }}"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0">
                            </div>
                        </div>


                        <div class="form-group d-flex xscroll_none">
                            <label for="motivoGarantia-{{ $loop->iteration }}"
                                   class="col-sm-6 justify-content-start align-items-center d-flex">Motivo Retrabajo:
                            </label>
                            <input name="motivo_garantia"
                                   type="text"
                                   class="form-control col-sm-6"
                                   id="motivoGarantia-{{ $loop->iteration }}"
                                   data-validation="required"
                                   data-validation-error-msg="Debe ingresar el motivo"
                                   data-validation-error-msg-container="#errorMotivo-{{ $loop->iteration }}"
                                   placeholder="Ingrese el motivo"
                                   maxlength="32"
                                   autocomplete="off" />
                            <div id="errorMotivo-{{ $loop->iteration }}"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0">
                            </div>
                        </div>

                        <div class="custom-control custom-switch justify-content-end text-left"
                             style="margin-left:40%">
                            <input name="garantia_rechazada"
                                   type="checkbox"
                                   class="custom-control-input"
                                   id="rechazadoGarantia-{{ $loop->iteration }}">
                            <label class="custom-control-label"
                                   for="rechazadoGarantia-{{ $loop->iteration }}">Garantía Rechazada</label>
                        </div>

                        <div class="form-group d-flex xscroll_none none">
                            <label for="motivoRechazo-{{ $loop->iteration }}"
                                   class="col-sm-6 justify-content-start align-items-center d-flex">Motivo rechazo:
                            </label>
                            <input name="motivo_rechazo"
                                   type="text"
                                   class="form-control col-sm-6"
                                   id="motivoRechazo-{{ $loop->iteration }}"
                                   data-validation="required"
                                   data-validation-error-msg="Debe ingresar motivo de rechazo"
                                   data-validation-error-msg-container="#errorMotivoRechazo-{{ $loop->iteration }}"
                                   placeholder="Ingrese el motivo de rechazo"
                                   maxlength="32"
                                   autocomplete="off" />
                            <div id="errorMotivoRechazo-{{ $loop->iteration }}"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0">
                            </div>
                        </div>
                    @endif


                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        id="close-seguimiento">Cerrar</button>

                <button id="btnSubmit-{{ $loop->iteration }}"
                        form="FormSeguimientoGarantia-{{ $loop->iteration }}"
                        value="Submit"
                        type="submit"
                        class="btn btn-primary">Confirmar</button>
            </div>

        </div>
    </div>
</div>
