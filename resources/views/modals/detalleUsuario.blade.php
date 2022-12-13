@php
$unique = $usuario->id_usuario;
@endphp
<button type="button"
        class="btn btn-success"
        data-toggle="modal"
        data-target="#editarUsuario-{{ $unique }}"
        data-backdrop="static">
    <i class="fas fa-edit"></i>
</button>


<div class="modal fade"
     id="editarUsuario-{{ $unique }}"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Editar Usuario: {{ strtoupper($usuario->username) }}</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">

                <form id="FormEditarUser-{{ $unique }}"
                      method="PATCH"
                      action="{{ route('perfiles.update', ['perfile' => $usuario->id_usuario]) }}"
                      autocomplete="off">
                    @csrf

                    <input type="hidden"
                           name="id_usuario"
                           value="{{ $unique }}">

                    <input type="hidden"
                           name="id_empleado"
                           value="{{ $usuario->empleado->dni }}">

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
                                       id="userDni-{{ $unique }}"
                                       placeholder="Ingrese numero de DNI"
                                       autocomplete="off"
                                       onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(0)))"
                                       required
                                       disabled
                                       value="{{ $usuario->dni }}" />

                                <div id="errorDNI-{{ $unique }}"
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
                                       id="userNames-{{ $unique }}"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar los nombres"
                                       data-validation-error-msg-container="#errorNames"
                                       placeholder="Ingrese los nombres"
                                       maxlength="255"
                                       autocomplete="off"
                                       autofocus="off"
                                       required
                                       value="{{ $usuario->empleado->primer_nombre }}" />

                                <div id="errorNames-{{ $unique }}"
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
                                       id="userFlastname-{{ $unique }}"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar apellido paterno"
                                       data-validation-error-msg-container="#errorApellidoPat"
                                       placeholder="Ingrese primer apellido"
                                       maxlength="255"
                                       autocomplete="off"
                                       autofocus="off"
                                       required
                                       value="{{ $usuario->empleado->primer_apellido }}" />

                                <div id="errorApellidoPat-{{ $unique }}"
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
                                       id="userSlastname-{{ $unique }}"
                                       placeholder="Ingrese segundo apellido"
                                       maxlength="255"
                                       autocomplete="off"
                                       value="{{ $usuario->empleado->segundo_apellido }}" />

                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userPhone"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">TELEFONO:
                                </label>
                                <input name="telefono"
                                       type="number"
                                       class="form-control col-sm-7"
                                       id="userPhone-{{ $unique }}"
                                       placeholder="Ingrese telefono"
                                       maxlength="255"
                                       autocomplete="off"
                                       onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(0)))"
                                       value="{{ $usuario->empleado->telefono_contacto }}" />

                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="userEmail"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">CORREO:
                                </label>
                                <input name="email"
                                       type="text"
                                       class="form-control col-sm-7"
                                       id="userEmail-{{ $unique }}"
                                       placeholder="Ingrese correo"
                                       maxlength="255"
                                       autocomplete="off"
                                       value="{{ $usuario->empleado->email }}" />
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="username"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">USERNAME:
                                </label>
                                <input name="username"
                                       type="text"
                                       class="form-control col-sm-7"
                                       id="username-{{ $unique }}"
                                       placeholder="Nombre de Usuario"
                                       maxlength="255"
                                       autocomplete="off"
                                       disabled
                                       value="{{ $usuario->username }}" />
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="username"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">LOCAL:
                                </label>
                                <select name="id_local"
                                        id="userLocal-{{ $unique }}"
                                        class="form-control col-sm-7"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una opción"
                                        required>
                                    @foreach ($locales as $local)
                                        <option value="{{ $local->id_local }}"
                                                {{ $usuario->empleado->id_local === $local->id_local ? 'selected' : '' }}>
                                            {{ $local->nombre_local }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group d-flex xscroll_none align-items-center">
                                <label for="password"
                                       class="col-sm-5 justify-content-start align-items-center d-flex">NUEVA
                                    CONTRASEÑA:
                                </label>
                                <input name="password"
                                       type="password"
                                       class="form-control col-sm-7"
                                       id="password-{{ $unique }}"
                                       placeholder="Nueva Contraseña"
                                       maxlength="255"
                                       autocomplete="off" />
                            </div>

                            <div class="create_switch_element"
                                 label-text="HABILITADO"
                                 input-name="habilitado-{{ $unique }}"
                                 data-text-checked="Activo"
                                 data-text-unchecked="Inactivo"
                                 custom-col="5"
                                 custom-position="start"
                                 data-class="habilitado-{{ $unique }} form-group d-flex xscroll_none align-items-center"
                                 {{ $usuario->habilitado === 1 ? 'checked' : '' }}
                                 {{-- checked --}}>
                            </div>
                            {{-- <div class="form-group d-flex xscroll_none align-items-center">
                            </div> --}}

                        </div>

                        <div class="col-7 d-flex mx-0 justify-content-start"
                             style="flex-direction:column;"
                             id="perfiles_{{ $unique }}">
                            <h3 class="mb-4">Perfiles</h3>

                            <div class="row w-100 mx-0 mb-3">
                                <div class="col-6 d-flex mx-0 px-1"
                                     style="flex-direction:column;">
                                    <span>Area:</span>
                                    <select name="area"
                                            id="userArea-{{ $unique }}"
                                            class="form-control area_get"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#error_userRol-{{ $unique }}"
                                            data-rol-select="userRol-{{ $unique }}"
                                            required>
                                        <option value="none">-</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area }}"
                                                    {{ $usuario->rol->area === $area ? 'selected' : '' }}>
                                                {{ $area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 d-flex mx-0 px-1"
                                     style="flex-direction:column;">
                                    <span>Rol:</span>
                                    <select name="id_rol"
                                            id="userRol-{{ $unique }}"
                                            class="form-control rol_get"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#error_userRol-{{ $unique }}"
                                            data-all-selects="perfiles_{{ $unique }}"
                                            required>

                                        @foreach ($rols as $rol)
                                            @if ($rol->area === $usuario->rol->area)
                                                <option value="{{ $rol->id_rol }}"
                                                        {{ $usuario->rol->id_rol === $rol->id_rol ? 'selected' : '' }}>
                                                    {{ $rol->nombre_rol }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div id="error_userRol-{{ $unique }}"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>

                            <div id="roles_adicionales-{{ $unique }}">
                                @if (!is_null($usuario->roles_adicionales))
                                    @php
                                        // $roles_adicionales = json_decode($usuario->roles_adicionales);
                                        $roles_adicionales = $usuario->roles_adicionales;
                                    @endphp
                                    @foreach ($roles_adicionales as $rol_adicional)

                                        @php
                                            // $area_rol_adicional = \App\Modelos\Rol::find($rol_adicional)->area;
                                            $id_unico = \Helper::randomChar();
                                        @endphp

                                        <div class="row w-100 mx-0 mb-3"
                                             id="{{ $id_unico }}">
                                            <div class="col-5 d-flex mx-0 px-1"
                                                 style="flex-direction:column;">
                                                <span>Area:</span>
                                                <select name="area"
                                                        id="userArea-{{ $unique }}"
                                                        class="form-control area_get"
                                                        data-validation="length"
                                                        data-validation-length="min1"
                                                        data-validation-error-msg="Debe seleccionar una opción"
                                                        data-validation-error-msg-container="#error_userRol-{{ $unique }}"
                                                        data-rol-select="rol_addon_{{ $id_unico }}"
                                                        required>
                                                    <option value="none">-</option>
                                                    @foreach ($areas as $area)
                                                        <option value="{{ $area }}"
                                                                {{ $rol_adicional->area === $area ? 'selected' : '' }}>
                                                            {{ $area }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-5 d-flex mx-0 px-1"
                                                 style="flex-direction:column;">
                                                <span>Rol:</span>
                                                <select name="RA_{{ $loop->iteration }}"
                                                        id="rol_addon_{{ $id_unico }}"
                                                        class="form-control rol_get rol_addon"
                                                        data-validation="length"
                                                        data-validation-length="min1"
                                                        data-validation-error-msg="Debe seleccionar una opción"
                                                        data-validation-error-msg-container="#error_userRol-{{ $unique }}"
                                                        data-all-selects="perfiles-{{ $unique }}"
                                                        required>

                                                    @foreach ($rols as $rol)
                                                        @if ($rol->area === $rol_adicional->area)
                                                            <option value="{{ $rol->id_rol }}"
                                                                    {{ $rol_adicional->id_rol === $rol->id_rol ? 'selected' : '' }}>
                                                                {{ $rol->nombre_rol }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <a href="#"
                                               class="col-sm-2 align-items-center d-flex justify-content-end loaded_rols"
                                               style="text-decoration: none"
                                               data-unique="{{ $id_unico }}">
                                                <i class="fas fa-minus"></i>
                                            </a>

                                            <div id="error_rol_addon_{{ $id_unico }}"
                                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>

                            <div class="form-group d-flex xscroll_none">
                                <a href="#"
                                   class="btn-add-rol col-sm-5 justify-content-end"
                                   data-append-id="roles_adicionales-{{ $unique }}"
                                   data-unique="{{ $unique }}">
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
                        form="FormEditarUser-{{ $unique }}">Registrar</button>

            </div>
        </div>
    </div>
</div>
