@php
$unique = "$asesor->username-" . str_replace(':', '', $hora);
@endphp
<div class="modal-dialog"
     role="document">
    <div class="modal-content">
        <div class="modal-header fondo-sigma">
            <h5 class="modal-title"
                id="confirmarEntregaLabel-{{ $unique }}">CITA</h5>
            <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"
             style="max-height: 65vh;overflow-y: auto;">

            <form id="FormRegistrarCita-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}"
                  method="POST"
                  action="{{ route('crm.citas.store') }}"
                  value="submit"
                  autocomplete="off">
                @csrf
                <input type="hidden"
                       name="fecha"
                       value="{{ $fecha }}" />
                <input type="hidden"
                       name="hora"
                       value="{{ $hora }}" />
                <input type="hidden"
                       name="empleado"
                       value="{{ $asesor->dni }}" />
                <div class="form-group form-inline">
                    <label for="tipoIn-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Tipo Cita:</label>
                    <select name="tipo"
                            id="tipoIn-{{ $unique }}"
                            class="form-control col-sm-6"
                            data-validation="length"
                            data-validation-length="min1"
                            data-validation-error-msg="Debe seleccionar una opción"
                            data-validation-error-msg-container="#errorTipo-{{ $unique }}"
                            required>
                        <option value=""></option>
                        <option value="SINIESTRO">SINIESTRO</option>
                        <option value="PREVENTIVO">PREVENTIVO</option>
                        <option value="CORRECTIVO">CORRECTIVO</option>
                        <option value="GARANTIA">GARANTÍA</option>
                        <option value="DIAGNOSTICO">DIAGNÓSTICO</option>
                    </select>
                    <div id="errorTipo-{{ $unique }}"
                         class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                <div class="form-group form-inline">
                    <label for="PlacaEdit-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Placa: </label>
                    <input name="placa"
                           type="text"
                           class="form-control col-sm-6 placa_register"
                           id="PlacaEdit-{{ $unique }}"
                           required
                           maxlength="6"
                           oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="form-group form-inline">
                    <label for="marcaAuto-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Marca:</label>
                    <select id="marcaAuto-{{ $unique }}"
                            class="form-control col-sm-6 marca_auto"
                            name="marca"
                            required
                            >
                        @foreach ($marcasVehiculo as $marca)
                            <option value="{{ $marca->getIdMarcaAuto() }}">
                                {{ $marca->getNombreMarca() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-inline"
                     id="modelo_select-{{ $unique }}">
                    <label for="modeloSelectible-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Modelo: </label>
                    <select name="modelo"
                            id="modeloSelectible-{{ $unique }}"
                            class="form-control col-6"
                            required
                            >
                        @foreach ($listaModelos as $modelo)
                            <option value="{{ $modelo->id_modelo }}">
                                {{ $modelo->nombre_modelo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-inline none"
                     id="modelo_text-{{ $unique }}">
                    <label for="modeloTextible-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Modelo: </label>
                    <input id="modeloTextible-{{ $unique }}"
                           name="nombre_modelo"
                           type="text"
                           class="form-control col-6"
                           placeholder="Modelo" />
                </div>


                <div class="form-group form-inline">
                    <label for="detalleServicioInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Detalle Servicio: </label>
                    <input type="text"
                           class="form-control col-sm-6"
                           id="detalleServicioInfo-{{ $unique }}"
                           name="detalleServicio"
                           value="">
                </div>

                <div class="form-group form-inline">
                    <label for="observacionesIn-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Observaciones: </label>
                    <textarea name="observaciones"
                              type="text"
                              class="form-control col-sm-6"
                              id="observacionesIn-{{ $unique }}"
                              placeholder="Ingrese sus observaciones"
                              maxlength="255"
                              rows="3"></textarea>
                </div>

                <!-- <div class="form-group form-inline">
          <label for="numeroClienteInfo" class="col-sm-6 justify-content-end">DNI/RUC: </label>
          <input name="numDoc" type="text" class="form-control col-sm-6" id="numeroClienteInfo" required>
        </div> -->

                <div class="form-group form-inline">
                    <label for="nombreClienteInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Nombre del contacto: </label>
                    <input type="text"
                           name="contacto"
                           class="form-control col-sm-6"
                           id="nombreClienteInfo-{{ $unique }}"
                           value=""
                           required
                           >
                </div>

                <div class="form-group form-inline">
                    <label for="telefonoClienteInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Número de contacto: </label>
                    <input type="text"
                           name="nroContacto"
                           class="form-control col-sm-6"
                           id="telefonoClienteInfo-{{ $unique }}"
                           value=""
                           required
                           >
                </div>

                <div class="form-group form-inline">
                    <label for="correoClienteInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Correo de contacto: </label>
                    <input type="text"
                           name="correoContacto"
                           class="form-control col-sm-6"
                           id="correoClienteInfo-{{ $unique }}"
                           value="">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal">Cerrar</button>
            <button id="btnSubmit-{{ $unique }}"
                    class="btn btn-primary"
                    form="FormRegistrarCita-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}"
                    value="Submit"
                    type="submit">Confirmar</button>
        </div>
    </div>
</div>
