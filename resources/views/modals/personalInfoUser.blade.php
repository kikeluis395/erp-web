<div class="modal fade"
     id="datosNuevoCliente"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="editarSTLabel">Datos Cliente</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close" id="close_nuevo_cliente">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">

                <form id="detalleNuevoUsuarioMeson"
                      method="POST"
                      action="{{ route('meson.store') }}"
                      autocomplete="off">

                    <div class="form-group form-inline">
                        <label for="tipo_doc"
                               class="col-sm-6 justify-content-end">Tipo Documento:</label>
                        <select name="tipo_doc"
                                id="tipo_doc"
                                class="form-control col-sm-6 tipo_doc"
                                data-validation="length"
                                data-validation-length="min1"
                                data-validation-error-msg="Debe seleccionar una opción"
                                data-validation-error-msg-container="#errorTipoDoc"
                                required>
                            {{-- <option value="none">-</option> --}}
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CE">CE</option>

                        </select>
                        <div id="errorTipoDoc"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>

                    <div class="form-group form-inline"
                         id="ruc"
                         style="display: none">
                        <label for="cliente"
                               class="col-sm-6 justify-content-end">Cliente:</label>
                        <input name="cliente"
                               value=""
                               id="cliente"
                               type="text"
                               class="form-control col-sm-6 validable"
                               data-validation="required"
                               data-validation-error-msg="Debe especificar nombres"
                               data-validation-error-msg-container="#errorCliente"
                               placeholder="Ingrese nombres"
                               maxlength="45"
                               oninput="this.value = this.value.toUpperCase()">
                        <div id="errorCliente"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>

                    <div id="other"
                         style="display: none">
                        <div class="form-group form-inline">
                            <label for="nombres"
                                   class="col-sm-6 justify-content-end">Nombres:</label>
                            <input name="nombres"
                                   value=""
                                   id="nombres"
                                   type="text"
                                   class="form-control col-sm-6 validable"
                                   data-validation="required"
                                   data-validation-error-msg="Debe especificar nombres"
                                   data-validation-error-msg-container="#errorNames"
                                   placeholder="Ingrese nombres"
                                   maxlength="45"
                                   oninput="this.value = this.value.toUpperCase()">
                            <div id="errorNames"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="apellido_pat"
                                   class="col-sm-6 justify-content-end">Apellido Paterno:</label>
                            <input name="apellido_pat"
                                   value=""
                                   id="apellido_pat"
                                   type="text"
                                   class="form-control col-sm-6 validable"
                                   data-validation="required"
                                   data-validation-error-msg="Debe especificar apellido paterno"
                                   data-validation-error-msg-container="#errorapellidooat"
                                   placeholder="Ingrese apellido paterno"
                                   maxlength="45"
                                   oninput="this.value = this.value.toUpperCase()">
                            <div id="errorapellidooat"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="apellido_mat"
                                   class="col-sm-6 justify-content-end">Apellido Materno:</label>
                            <input name="apellido_mat"
                                   value=""
                                   id="apellido_mat"
                                   type="text"
                                   class="form-control col-sm-6 validable"
                                   data-validation="required"
                                   data-validation-error-msg="Debe especificar apellido materno"
                                   data-validation-error-msg-container="#errorapellidomat"
                                   placeholder="Ingrese apellido materno"
                                   maxlength="45"
                                   oninput="this.value = this.value.toUpperCase()">
                            <div id="errorapellidomat"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>
                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        id="closeREG">Cerrar</button>
                <button type="submit"
                        class="btn btn-primary"
                        form="detalleNuevoUsuarioMeson"
                        id="saveREG">Guardar</button>

            </div>
            </form>
        </div>
    </div>
</div>
