@php
$unique = $servicioTercero->id_servicio_tercero;
@endphp
<button type="button"
        class="btn btn-success"
        data-toggle="modal"
        data-target="#editarServicioTercero-{{ $unique }}"
        data-backdrop="static">
    <i class="fas fa-edit"></i>
</button>


<div class="modal fade"
     id="editarServicioTercero-{{ $unique }}"
     role="dialog"
     aria-labelledby="editarServicioTercero-{{ $unique }}"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Editar Servicio Tercero</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">

                <form id="FormEditarST-{{ $unique }}"
                      method="POST"
                      action="{{ route('administracion.serviciosTerceros.show', ['serviciosTercero' => $servicioTercero]) }}"
                      autocomplete="off">
                    @csrf

                    <input type="hidden"
                           name="id_servicio_tercero"
                           value="{{ $unique }}">

                    <div class="form-group form-inline">
                        <label for="proveedorIn-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Código:</label>
                        <input name="codigo_servicio_tercero"
                               value="{{ $servicioTercero->codigo_servicio_tercero }}"
                               id="proveedorIn-{{ $unique }}"
                               type="text"
                               class="form-control col-sm-6"
                               data-validation="required"
                               data-validation-error-msg="Debe especificar el codigo de servicio tercero"
                               data-validation-error-msg-container="#errorcodigo-{{ $unique }}"
                               placeholder="Ingrese el codigo de servicio tercero"
                               maxlength="45"
                               oninput="this.value = this.value.toUpperCase()"
                               readonly>

                        <div id="errorcodigo-{{ $unique }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>

                    <div class="form-group form-inline">
                        <label for="descripcionIn-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Descripción:</label>
                        <input name="descripcion"
                               value="{{ $servicioTercero->descripcion }}"
                               type="text"
                               class="form-control col-sm-6"
                               id="descripcionIn-{{ $unique }}"
                               data-validation="required"
                               data-validation-error-msg="Debe especificar una descripcion"
                               data-validation-error-msg-container="#errordescripcion-{{ $unique }}"
                               placeholder="Ingrese descripcion"
                               maxlength="45"
                               oninput="this.value = this.value.toUpperCase()">
                        <div id="errordescripcion-{{ $unique }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>

                    <div class="form-group form-inline">
                        <label for="precioIn-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Precio de Venta:</label>
                        <input name="pvp"
                               id="precioIn-{{ $unique }}"
                               value="{{ $servicioTercero->pvp }}"
                               type="number"
                               step="any"
                               class="form-control col-sm-6"
                               data-validation="required"
                               data-validation-error-msg="Debe especificar precio de venta"
                               data-validation-error-msg-container="#errorprecio-{{ $unique }}"
                               placeholder="Ingrese precio de venta"
                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))">
                        <div id="errorprecio-{{ $unique }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>

                    <div class="form-group form-inline">
                        <label for="monedaIn-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Moneda:</label>
                        <select name="moneda"
                                id="monedaIn-{{ $unique }}"
                                class="form-control col-sm-6"
                                data-validation="length"
                                data-validation-length="min1"
                                data-validation-error-msg="Debe seleccionar moneda"
                                data-validation-error-msg-container="#errormoneda-{{ $unique }}"
                                required>

                            @foreach (array_keys($monedas) as $moneda)
                                <option value="{{ $moneda }}"
                                        {{ $servicioTercero->moneda === $moneda ? 'selected' : '' }}>
                                    {{ $monedas[$moneda] }}
                                </option>
                            @endforeach
                        </select>
                        <div id="errormoneda-{{ $unique }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>

                    <div class="form-group form-inline">
                        <label for="marcasIn-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Aplicación Marca:</label>

                        @php
                            $marks = $servicioTercero->marcas;
                            if (!is_null($marks)) {
                                $marks = json_decode($servicioTercero->marcas, true);
                            } else {
                                $marks = [];
                                foreach ($marcas as $marca) {
                                    $id = $marca->id_marca_auto;
                                    $tarr = ["M$id" => '0'];
                                    $marks += $tarr;
                                }
                            }
                        @endphp

                        <div class="col-sm-6 row"
                             id="marcas-{{ $unique }}">
                            @foreach ($marcas as $marca)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           form="FormEditarST-{{ $unique }}"
                                           value="M{{ $marca->id_marca_auto }}"
                                           id="marcas-{{ $unique }}-{{ $marca->id_marca_auto }}"
                                           {{ $marks["M$marca->id_marca_auto"] === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                           for="marcas-{{ $unique }}-{{ $marca->id_marca_auto }}">
                                        {{ $marca->nombre_marca }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div id="errorAplicacionMarca-{{ $unique }}"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>


                    <div class="form-group form-inline"
                         >
                        <label class="col-sm-6 justify-content-end">Accesorio Ventas:</label>

                        <div class="custom-switch custom-control ml-2">
                            <input id="ventasIn-{{ $unique }}"
                                   type="checkbox"
                                   form="FormEditarST-{{ $unique }}"
                                   class="custom-control-input ventas_apli"
                                   data-label="ventas_{{ $unique }}"
                                   {{ $servicioTercero->aplicacion_ventas === 1 ? 'checked' : '' }} />

                            <label for="ventasIn-{{ $unique }}"
                                   class="custom-control-label" id="ventas_{{ $unique }}">{{ $servicioTercero->aplicacion_ventas === 1 ? 'SI' : 'NO' }}</label>
                        </div>                        
                    </div>

                    {{-- <div class="custom-control custom-switch">
                        <div style="position:relative;"
                             class="justify-content-center align-content-center">
                            <input name="garantia_rechazada"
                                   type="checkbox"
                                   class="custom-control-input moneda_switch"
                                   id="monedaPrecioServicio"
                                   {{ $pe ? ($precio->moneda === 'DOLARES' ? 'checked' : '') : '' }}>
                            <label class="custom-control-label"
                                   for="monedaPrecioServicio">{{ $pe ? $precio->moneda : '' }}</label>
                        </div>
                    </div> --}}

                    <div class="form-group form-inline"
                         id="estados-{{ $unique }}">
                        <label for="estadoIn-{{ $unique }}"
                               class="col-sm-6 justify-content-end">Estado:</label>
                        <input id="estadoIn-{{ $unique }}"
                               value="1"
                               type="checkbox"
                               form="FormEditarST-{{ $unique }}"
                               class="form-check-input"
                               {{ $servicioTercero->estado === 1 ? 'checked' : '' }} />
                        <span
                              id="estadoSTD-{{ $unique }}">{{ $servicioTercero->estado === 1 ? 'ACTIVO' : 'INACTIVO' }}</span>
                    </div>


                    <div class="alert alert-info rounded-pill px-5"
                         role="alert"
                         align="center">
                        <h6 style="font-weight:bold"
                            class="mb-0">*Precios incluyen IGV</h6>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        id="close-{{ $unique }}">Cerrar</button>
                <button type="submit"
                        form="FormEditarST-{{ $unique }}"
                        class="btn btn-primary"
                        id="save-{{ $unique }}">Registrar</button>
            </div>
        </div>
    </div>
</div>
