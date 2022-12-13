<button type="button"
        class="btn btn-warning rounded-pill px-5"
        id="costo_mensual"
        data-toggle="modal"
        data-target="#crearUser"><i class="fas fa-plus"></i>&nbsp;NUEVO USUARIO</button>

<div class="modal fade text-center"
     id="crearUser"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-xl"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="editarSTLabel">NUEVO USUARIO</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <form id="FormCrearUser"
                      method="POST"
                      action="{{ route('perfiles.store') }}"
                      autocomplete="off">
                    @csrf

                    <div class="row w-100 mx-0">
                        <div class="col-5 d-flex mx-0 justify-content-start"
                             style="flex-direction:column;">
                            <h3 class="mb-4">Datos de Usuario</h3>
                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userDni"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">DNI:
                                </label>
                                <input name="dni"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       type="number"
                                       maxlength="8"
                                       class="form-control col-sm-7"
                                       id="userDni"
                                       placeholder="Ingrese numero de DNI"
                                       autocomplete="off"
                                       onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(0)))"
                                       required />

                                <div id="errorDNI"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0">
                                </div>
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userNames"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">NOMBRES:
                                </label>
                                <input name="name"
                                       type="text"
                                       class="form-control col-sm-7 names"
                                       id="userNames"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar los nombres"
                                       data-validation-error-msg-container="#errorNames"
                                       placeholder="Ingrese los nombres"
                                       maxlength="255"
                                       autocomplete="off"
                                       autofocus="off"
                                       required />

                                <div id="errorNames"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0">
                                </div>
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userFlastname"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">APELLIDO
                                    PATERNO:
                                </label>
                                <input name="apellido_pat"
                                       type="text"
                                       class="form-control col-sm-7 flname"
                                       id="userFlastname"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar apellido paterno"
                                       data-validation-error-msg-container="#errorApellidoPat"
                                       placeholder="Ingrese primer apellido"
                                       maxlength="255"
                                       autocomplete="off"
                                       autofocus="off"
                                       required />

                                <div id="errorApellidoPat"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0">
                                </div>
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userSlastname"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">APELLIDO
                                    MATERNO:
                                </label>
                                <input name="apellido_mat"
                                       type="text"
                                       class="form-control col-sm-7"
                                       id="userSlastname"
                                       placeholder="Ingrese segundo apellido"
                                       maxlength="255"
                                       autocomplete="off" />

                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userPhone"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">TELEFONO:
                                </label>
                                <input name="telefono"
                                       type="number"
                                       class="form-control col-sm-7"
                                       id="userPhone"
                                       placeholder="Ingrese telefono"
                                       maxlength="255"
                                       autocomplete="off"
                                       onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(0)))" />

                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userEmail"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">CORREO:
                                </label>
                                <input name="email"
                                       type="text"
                                       class="form-control col-sm-7"
                                       id="userEmail"
                                       placeholder="Ingrese correo"
                                       maxlength="255"
                                       autocomplete="off" />
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="username"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">USERNAME:
                                </label>
                                <input name="username"
                                       type="text"
                                       class="form-control col-sm-7"
                                       id="username"
                                       placeholder="Nombre de Usuario"
                                       maxlength="255"
                                       autocomplete="off"
                                       disabled />
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="username"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">LOCAL:
                                </label>
                                <select name="id_local"
                                        id="userLocal"
                                        class="form-control col-sm-7"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una opción"
                                        required>
                                    @foreach ($locales as $local)
                                        <option value="{{ $local->id_local }}">{{ $local->nombre_local }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="password"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">CONTRASEÑA:
                                </label>
                                <input name="password"
                                       type="password"
                                       class="form-control col-sm-7"
                                       id="password"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar contraseña"
                                       data-validation-error-msg-container="#errorPassword"
                                       placeholder="Contraseña"
                                       maxlength="255"
                                       autocomplete="off"
                                       required />

                                <div id="errorPassword"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0">
                                </div>
                            </div>
                        </div>

                        <div class="col-7 d-flex mx-0 justify-content-start"
                             style="flex-direction:column;"
                             id="perfiles_creator">
                            <h3 class="mb-4">Perfiles</h3>

                            <div class="row w-100 mx-0 mb-3">
                                <div class="col-6 d-flex mx-0 px-1"
                                     style="flex-direction:column;">
                                    <span>Area:</span>
                                    <select name="area"
                                            id="userArea"
                                            class="form-control area_get"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#error_userRol"
                                            data-rol-select="userRol"
                                            required>
                                        <option value="none">-</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area }}">{{ $area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 d-flex mx-0 px-1"
                                     style="flex-direction:column;">
                                    <span>Rol:</span>
                                    <select name="id_rol"
                                            id="userRol"
                                            class="form-control rol_get"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#error_userRol"
                                            data-all-selects="perfiles_creator"
                                            required>
                                        <option value="none">-</option>
                                    </select>
                                </div>

                                <div id="error_userRol"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>

                            <div id="roles_adicionales"></div>

                            <div class="form-group d-flex xscroll_none">
                                <a href="#"
                                   class="btn-add-rol col-sm-5 justify-content-end"
                                   data-append-id="roles_adicionales"
                                   data-unique="creator">
                                    <i class="fas fa-plus"></i>
                                    &nbsp;Añadir rol
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary rounded-pill px-4 py-2"
                        data-dismiss="modal">Cerrar</button>
                <button type="submit"
                        class="btn btn-primary rounded-pill px-4 py-2"
                        form="FormCrearUser">Registrar</button>

            </div>
        </div>
    </div>
</div>
