@php
$unique = "$asesor->username-" . str_replace(':', '', $hora);
$now = \Carbon\Carbon::now();
$fecha_cita = Carbon\Carbon::parse($asesor[$hora]->fecha_cita);
$days = $fecha_cita->diffInDays($now, false);
if ($days < 0) {
    $just_date = $fecha_cita->format('Y-m-d');
} else {
    $just_date = $now->format('Y-m-d');
}
$limiteSuperior = $just_date . ' ' . '23:59:59';
$limiteSuperior = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $limiteSuperior);

if ($days === 0) {
    $disabled = '';
} elseif ($days > 0) {
    $disabled = $limiteSuperior->diffInMinutes($fecha_cita, false) < 0 ? 'disabled' : '';
} elseif ($days < 0) {
    $disabled = $fecha_cita->diffInMinutes($limiteSuperior, false) < 0 ? 'disabled' : '';
}
// $disabled = $now->diffInMinutes($fecha_cita, false) < 0 ? 'disabled' : '';
@endphp
<div class="modal-dialog"
     role="document">
    <div class="modal-content">
        <div class="modal-header fondo-sigma">
            {{-- <h1>{{$days}}</h1> --}}
            <h5 class="modal-title"
                id="confirmarEntregaLabel-{{ $unique }}">CITA
                {{ Carbon\Carbon::parse($asesor[$hora]->fecha_cita)->format('d/m/Y H:i') }}</h5>
            <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"
             style="max-height: 65vh;overflow-y: auto;">

            <form id="formEditarCita-{{ $asesor[$hora]->id_cita_entrega }}"
                  data-idformcita="{{ $unique }}"
                  method="POST"
                  action="{{ route('crm.editarCita', ['idCita' => $asesor[$hora]->id_cita_entrega]) }}">
                @csrf

                <div class="form-group form-inline">
                    <label for="tipoIn-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Tipo Servicio: </label>

                    <select name="tipo"
                            id="tipoIn-{{ $unique }}"
                            class="form-control col-sm-6"
                            data-validation="length"
                            data-validation-length="min1"
                            data-validation-error-msg="Debe seleccionar una opción"
                            data-validation-error-msg-container="#errorTipo-{{ $unique }}"
                            required
                            {{ $disabled }}>
                        @php
                            $tipos = ['SINIESTRO' => 'SINIESTRO', 'PREVENTIVO' => 'PREVENTIVO', 'CORRECTIVO' => 'CORRECTIVO', 'GARANTIA' => 'GARANTÍA', 'DIAGNOSTICO' => 'DIAGNÓSTICO'];
                        @endphp
                        @foreach (array_keys($tipos) as $tipo)
                            <option value="{{ $tipo }}"
                                    {{ $asesor[$hora]->tipo_servicio === $tipo ? 'selected' : '' }}>
                                {{ $tipos[$tipo] }}
                            </option>
                        @endforeach

                    </select>
                    <div id="errorTipo-{{ $unique }}"
                         class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>

                <div class="form-group form-inline">
                    <label for="PlacaInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Placa: </label>
                    <input type="text"
                           class="form-control col-sm-6"
                           id="PlacaInfo-{{ $unique }}"
                           name="nroPlaca"
                           value="{{ $asesor[$hora]->placa_vehiculo }}"
                           disabled>
                </div>

                @if (!is_null($asesor[$hora]->vehiculo))
                    <div class="form-group form-inline">
                        <label for="marcaAuto-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Marca:</label>
                        <select id="marcaAuto-{{ $unique }}"
                                class="form-control col-sm-6 marca_auto"
                                name="marca"
                                {{ $disabled }}>
                            <option value="all">-</option>
                            @foreach ($marcasVehiculo as $marca)
                                <option value="{{ $marca->getIdMarcaAuto() }}"
                                        {{ $asesor[$hora]->vehiculo->id_marca_auto === $marca->getIdMarcaAuto() ? 'selected' : '' }}>
                                    {{ $marca->getNombreMarca() }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (!$asesor[$hora]->vehiculo->hasModelos())
                        {{-- @if ($asesor[$hora]->vehiculo->id_marca_auto === 2) --}}
                        <div class="form-group form-inline"
                             id="modelo_text-{{ $unique }}">
                            <label for="modeloTextible-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Modelo: </label>
                            <input id="modeloTextible-{{ $unique }}"
                                   name="nombre_modelo"
                                   type="text"
                                   class="form-control col-6"
                                   placeholder="Modelo"
                                   min="6"
                                   max="20"
                                   value={{ $asesor[$hora]->vehiculo->getNombreMarca() }}
                                   {{ $disabled }} />
                        </div>

                        <div class="form-group form-inline none"
                             id="modelo_select-{{ $unique }}">
                            <label for="modeloSelectible-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Modelo: </label>
                            <select name="modelo"
                                    id="modeloSelectible-{{ $unique }}"
                                    class="form-control col-6"
                                    {{ $disabled }}>
                                @foreach ($listaModelos as $modelo)
                                    <option value="{{ $modelo->id_modelo }}">
                                        {{ $modelo->nombre_modelo }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group form-inline"
                             id="modelo_select-{{ $unique }}">
                            <label for="modeloSelectible-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Modelo: </label>
                            <select name="modelo"
                                    id="modeloSelectible-{{ $unique }}"
                                    class="form-control col-6"
                                    {{ $disabled }}>
                                @foreach ($listaModelos as $modelo)
                                    <option value="{{ $modelo->id_modelo }}"
                                            {{ (string) $asesor[$hora]->vehiculo->getModelo() === (string) $modelo->nombre_modelo ? 'selected' : '' }}>
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
                                   placeholder="Modelo"
                                   min="6"
                                   max="20"
                                   {{ $disabled }} />
                        </div>
                    @endif
                @else
                    @if (!is_null($asesor[$hora]->id_marca_auto) && !is_null($asesor[$hora]->modelo))
                        <div class="form-group form-inline">
                            <label for="marcaAuto-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Marca:</label>
                            <select id="marcaAuto-{{ $unique }}"
                                    class="form-control col-sm-6 marca_auto"
                                    name="marca"
                                    {{ $disabled }}>
                                @foreach ($marcasVehiculo as $marca)
                                    <option value="{{ $marca->getIdMarcaAuto() }}"
                                            {{ $asesor[$hora]->id_marca_auto === $marca->getIdMarcaAuto() ? 'selected' : '' }}>
                                        {{ $marca->getNombreMarca() }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if (!$asesor[$hora]->hasModelos())
                            <div class="form-group form-inline none"
                                 id="modelo_select-{{ $unique }}">
                                <label for="modeloSelectible-{{ $unique }}"
                                       class="col-sm-6 justify-content-end">Modelo: </label>
                                <select name="modelo"
                                        id="modeloSelectible-{{ $unique }}"
                                        class="form-control col-6"
                                        {{ $disabled }}>
                                    @foreach ($listaModelos as $modelo)
                                        <option value="{{ $modelo->id_modelo }}">
                                            {{ $modelo->nombre_modelo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group form-inline"
                                 id="modelo_text-{{ $unique }}">
                                <label for="modeloTextible-{{ $unique }}"
                                       class="col-sm-6 justify-content-end">Modelo: </label>
                                <input id="modeloTextible-{{ $unique }}"
                                       name="nombre_modelo"
                                       type="text"
                                       class="form-control col-6"
                                       placeholder="Modelo"
                                       value={{ $asesor[$hora]->modelo }}
                                       {{ $disabled }} />
                            </div>
                        @else
                            <div class="form-group form-inline"
                                 id="modelo_select-{{ $unique }}">
                                <label for="modeloSelectible-{{ $unique }}"
                                       class="col-sm-6 justify-content-end">Modelo: </label>
                                <select name="modelo"
                                        id="modeloSelectible-{{ $unique }}"
                                        class="form-control col-6"
                                        {{ $disabled }}>
                                    @foreach ($listaModelos as $modelo)
                                        <option value="{{ $modelo->id_modelo }}"
                                                {{ $asesor[$hora]->modelo === $modelo->nombre_modelo ? 'selected' : '' }}>
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
                                       placeholder="Modelo"
                                       {{ $disabled }} />
                            </div>
                        @endif
                    @else
                        <div class="alert alert-danger px-5 w-100 mb-1"
                             role="alert"
                             align="center">
                            <h6 style="font-weight:200; text-transform:uppercase"
                                class="mb-0">Vuelva a ingresar estos campos por favor</h6>
                        </div>

                        <div class="form-group form-inline">
                            <label for="marcaAuto-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Marca:</label>
                            <select id="marcaAuto-{{ $unique }}"
                                    class="form-control col-sm-6 marca_auto"
                                    placeholder="No se guardo la marca"
                                    name="marca"
                                    {{-- {{ $disabled }} --}}>
                                <option value="none">-</option>
                                @foreach ($marcasVehiculo as $marca)
                                    <option value="{{ $marca->getIdMarcaAuto() }}">
                                        {{ $marca->getNombreMarca() }}</option>
                                @endforeach
                            </select>
                            <div id="error-marca-{{ $unique }}"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>

                        <div class="form-group form-inline"
                             id="modelo_select-{{ $unique }}">
                            <label for="modeloSelectible-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Modelo: </label>
                            <select name="modelo"
                                    id="modeloSelectible-{{ $unique }}"
                                    class="form-control col-6"
                                    {{-- {{ $disabled }} --}}>
                                <option value="none">-</option>
                                @foreach ($listaModelos as $modelo)
                                    <option value="{{ $modelo->id_modelo }}">
                                        {{ $modelo->nombre_modelo }}</option>
                                @endforeach
                            </select>
                            <div id="error-modelo-{{ $unique }}"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>

                        <div class="form-group form-inline none"
                             id="modelo_text-{{ $unique }}">
                            <label for="modeloTextible-{{ $unique }}"
                                   class="col-sm-6 justify-content-end">Modelo: </label>
                            <input id="modeloTextible-{{ $unique }}"
                                   name="nombre_modelo"
                                   type="text"
                                   class="form-control col-6"
                                   placeholder="Inserte modelo"
                                   {{-- {{ $disabled }} --}} />
                            <div id="error-nombre_modelo-{{ $unique }}"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>

                    @endif
                @endif

                <div class="form-group form-inline">
                    <label for="detalleServicioInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Detalle Servicio: </label>
                    <input type="text"
                           class="form-control col-sm-6"
                           id="detalleServicioInfo-{{ $unique }}"
                           name="detalle"
                           value="{{ $asesor[$hora]->detalle_servicio }}"
                           {{ $disabled }}>
                </div>

                <div class="form-group form-inline">
                    <label for="observacionesIn-{{ $asesor[$hora]->id_cita_entrega }}"
                           class="col-sm-6 justify-content-end">Observaciones: </label>
                    <textarea type="text"
                              class="form-control col-sm-6"
                              id="observacionesIn-{{ $unique }}"
                              name="observaciones"
                              maxlength="255"
                              rows="3"
                              {{ $disabled }}>{{ $asesor[$hora]->observaciones }}</textarea>
                </div>

                <div class="form-group form-inline">
                    <label for="nombreClienteInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Nombre del contacto: </label>
                    <input type="text"
                           class="form-control col-sm-6"
                           id="nombreClienteInfo-{{ $unique }}"
                           name="contacto"
                           value="{{ $asesor[$hora]->contacto }}"
                           {{ $disabled }}>
                </div>

                <div class="form-group form-inline">
                    <label for="telefonoClienteInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Número de contacto: </label>
                    <input type="text"
                           class="form-control col-sm-6"
                           id="telefonoClienteInfo-{{ $unique }}"
                           name="telefono"
                           value="{{ $asesor[$hora]->telefono_contacto }}"
                           {{ $disabled }}>
                </div>

                <div class="form-group form-inline">
                    <label for="correoClienteInfo-{{ $unique }}"
                           class="col-sm-6 justify-content-end">Correo de contacto: </label>
                    <input type="text"
                           class="form-control col-sm-6"
                           id="correoClienteInfo-{{ $unique }}"
                           name="correo"
                           value="{{ $asesor[$hora]->email_contacto }}"
                           {{ $disabled }}>
                </div>

            </form>

            @if (in_array($asesor[$hora]->estadoAsistencia(), ['reservado', 'no-asistio']))
                <form id="FormRegistrarReprogramacion-{{ $unique }}"
                      method="POST"
                      action="{{ route('crm.reprogramacion') }}"
                      value="Submit"
                      autocomplete="off">
                    @csrf
                    <input type="hidden"
                           value="{{ $asesor[$hora]->id_cita_entrega }}"
                           name="idCita">
                    <input type="hidden"
                           value="{{ $asesor[$hora]->dni_empleado }}"
                           name="dniAsesor">
                    <div style="background-color: #FFB6C1; padding: 10px;">
                        <div class="form-group form-inline">
                            <label for="fechaPromesaIn"
                                   class="col-sm-6 justify-content-end">Fecha Reprogramación: </label>
                            <input id="fechaReprogramacion-{{ $asesor[$hora]->id_cita_entrega }}"
                                   name="fechaReprogramacion"
                                   value="{{ \Carbon\Carbon::parse($asesor[$hora]->fecha_cita)->format('d/m/Y') }}"
                                   min-date="{{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d/m/Y') }}"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control col-6 col-sm-3 reprogramation"
                                   data-validation="date"
                                   data-validation-format="dd/mm/yyyy"
                                   data-validation-length="10"
                                   placeholder="dd/mm/aaaa"
                                   maxlength="10">
                            <select name="horaReprogramacion"
                                    id="horaReprogramacion-{{ $asesor[$hora]->id_cita_entrega }}"
                                    class="form-control col-6 col-sm-3"
                                    style="width:100%"
                                    data-validation="length"
                                    data-validation-length="min1"
                                    data-validation-error-msg="Debe seleccionar una opción"
                                    data-validation-error-msg-container="#errorMoneda"
                                    required>
                                @foreach ($horas as $horaDisponible)
                                    <option value="{{ $horaDisponible }}"
                                            @if ($horaDisponible == \Carbon\Carbon::parse($asesor[$hora]->fecha_cita)->format('H:i')) selected @endif>{{ $horaDisponible }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row justify-content-end">
                            <button id="submitReprog-{{ $unique }}"
                                    class="btn btn-primary mr-3"
                                    value="Submit"
                                    type="submit">Reprogramar</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button"
                    class="btn btn-primary"
                    data-dismiss="modal"
                    id="cita-detalle-close-{{ $unique }}">Cerrar</button>

            <button id="btnEditarCita-{{ $unique }}"
                    form="formEditarCita-{{ $asesor[$hora]->id_cita_entrega }}"
                    class="btn btn-warning"
                    type="submit">Guardar</button>

            <form id="formCancelarCita-{{ $unique }}"
                  method="POST"
                  action="{{ route('crm.cancelarCita', ['idCita' => $asesor[$hora]->id_cita_entrega]) }}">
                @csrf
                <button id="btnCancelarCita-{{ $unique }}"
                        class="btn btn-danger"
                        type="submit">Cancelar Cita</button>
            </form>
        </div>
    </div>
</div>
