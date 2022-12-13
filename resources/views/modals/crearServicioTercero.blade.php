<button id=""
        type="button"
        style=""
        class="btn btn-warning rounded-pill px-4"
        data-toggle="modal"
        data-target="#crearST"><i class="fas fa-plus"></i>&nbsp;Nuevo Servicio</button>

<div class="modal fade"
     id="crearST"
     tabindex="-1"
     role="dialog"
     aria-labelledby="crearSTLabel"
     aria-hidden="true">

    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="editarSTLabel">Crear Servicio Tercero</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <form id="FormCrearST"
                      method="POST"
                      action="{{ route('administracion.serviciosTerceros.store') }}"
                      autocomplete="off">
                    @csrf

                    <div class="form-group form-inline">
                        <label for="codigoIn"
                               class="col-sm-6 justify-content-end">Codigo Servicio Tercero:</label>
                        <input name="codigo"
                               value=""
                               id="codigo-Create"
                               type="text"
                               class="form-control col-sm-6 validable"
                               data-validation="required"
                               data-validation-error-msg="Debe especificar el codigo de servicio tercero"
                               data-validation-error-msg-container="#errorcodigo"
                               placeholder="Ingrese el codigo de servicio tercero"
                               maxlength="45"
                               oninput="this.value = this.value.toUpperCase()">
                        <div id="errorcodigo"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                    </div>
                    <fieldset id="infoProveedor">
                        <div class="form-group form-inline">
                            <label for="descripcionIn"
                                   class="col-sm-6 justify-content-end">Descripcion:</label>
                            <input name="descripcion"
                                   id="descripcion-Create"
                                   value=""
                                   type="text"
                                   class="form-control col-sm-6 validable"
                                   id="descripcionIn"
                                   data-validation="required"
                                   data-validation-error-msg="Debe especificar una descripcion"
                                   data-validation-error-msg-container="#errordescripcion"
                                   placeholder="Ingrese descripcion"
                                   maxlength="45"
                                   oninput="this.value = this.value.toUpperCase()">
                            <div id="errordescripcion"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>

                        <div class="form-group form-inline">
                            <label for="monedaIn"
                                   class="col-sm-6 justify-content-end">Moneda:</label>
                            <select name="moneda"
                                    id="moneda-Create"
                                    class="form-control col-sm-6"
                                    data-validation="length"
                                    data-validation-length="min1"
                                    data-validation-error-msg="Debe seleccionar moneda"
                                    data-validation-error-msg-container="#errormoneda"
                                    required>
                                <option value="SOLES">Soles</option>
                                <option value="DOLARES">Dolares</option>
                            </select>
                            <div id="errormoneda"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>


                        <div class="form-group form-inline">
                            <label for="marcasIn"
                                   class="col-sm-6 justify-content-end">Aplicación Marca:</label>

                            <div class="col-sm-6 column"
                                 id="marcas">
                                @foreach ($marcas as $marca)
                                    <div class="form-check justify-content-start">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               form="FormEditarST"
                                               id="marcas-{{ $marca->id_marca_auto }}"
                                               value="M{{ $marca->id_marca_auto }}">
                                        <label class="form-check-label"
                                               for="marcas-{{ $marca->id_marca_auto }}">
                                            {{ $marca->nombre_marca }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div id="errorAplicacionMarca"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>

                        </div>


                        <div class="form-group form-inline">
                            <label class="col-sm-6 justify-content-end">Accesorio Ventas:</label>

                            <div class="custom-switch custom-control ml-2">
                                <input id="ventasIn"
                                       type="checkbox"
                                       form="FormEditarST"
                                       class="custom-control-input ventas_apli"
                                       data-label="ventas_label"
                                      />

                                <label for="ventasIn"
                                       class="custom-control-label"
                                       id="ventas_label">NO</label>
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            <label for="precioIn"
                                   class="col-sm-6 justify-content-end">Precio de Venta:</label>
                            <input name="precio"
                                   id="precio-Create"
                                   value=""
                                   type="number"
                                   step="any"
                                   class="form-control col-sm-6"
                                   data-validation="required"
                                   data-validation-error-msg="Debe especificar precio de venta"
                                   data-validation-error-msg-container="#errorprecio"
                                   placeholder="Ingrese precio de venta"
                                   onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))">
                            <div id="errorprecio"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>

                    </fieldset>


            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        id="closeREG">Cerrar</button>
                <input type="submit"
                       class="btn btn-primary"
                       value="Registrar"
                       id="saveREG">

            </div>
            </form>
        </div>
    </div>
</div>
