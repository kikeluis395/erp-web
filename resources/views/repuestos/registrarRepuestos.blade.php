@extends('repuestos.repuestosCanvas')
@section('titulo', 'Repuestos - Maestro')

@section('table-content')
    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 15px 10px 10px 15px">
        <div class="row justify-content-between col-12">
            <h2 class="ml-3 mt-3 mb-0">Maestro de Repuestos</h2>
        </div>
        <p class="ml-3 mt-3 mb-4">Ingrese los datos del repuesto para completar el registro</p>
        <form class="col-12"
              id="FormRegistrarRecepcion"
              method="POST"
              action="{{ route('administracion.admrepuesto.store') }}"
              value="Submit"
              autocomplete="off"
              onkeydown="return event.key != 'Enter';">
            @csrf
            <div class="row">
                <div class="row col-12">
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="codigoIn"
                                   class="col-sm-6 justify-content-end">Código: </label>
                            <div class="col-sm-6">
                                <input name="codigo"
                                       type="text"
                                       class="form-control col-12 typeahead repuesto"
                                       autocomplete="off"
                                       tipo="repuestos"
                                       id="codigoIn"
                                       style="width:100%"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar el código del repuesto"
                                       data-validation-error-msg-container="#errorCodigo"
                                       placeholder="Ingrese el código del repuesto"
                                       oninput="this.value = this.value.toUpperCase()">
                                <div id="errorCodigo"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="descripcionIn"
                                   class="col-sm-6 justify-content-end">Descripción: </label>
                            <div class="col-sm-6">
                                <input name="descripcion"
                                       type="text"
                                       class="form-control col-12"
                                       id="descripcionIn"
                                       style="width:100%"
                                       data-validation="required"
                                       data-validation-error-msg="Debe ingresar la descripción del repuesto"
                                       data-validation-error-msg-container="#errorDescripcion"
                                       placeholder="Ingrese la descripción del repuesto"
                                       oninput="this.value = this.value.toUpperCase()">
                                <div id="errorDescripcion"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="marcaIn"
                                   class="col-sm-6 justify-content-end">Marca:</label>
                            <div class="col-sm-6">
                                <select name="idMarca"
                                        id="marcain"
                                        class="form-control required col-12"
                                        style="width:100%"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una opción"
                                        data-validation-error-msg-container="#errorMarca">
                                    <option value=""></option>
                                    @foreach ($listaMarcas as $marca)
                                        <option value="{{ $marca->id_marca_auto }}">{{ $marca->nombre_marca }}</option>
                                    @endforeach
                                </select>
                                <div id="errorMarca"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="categoriaIn"
                                   class="col-sm-6 justify-content-end">Categoría:</label>
                            <div class="col-sm-6">
                                <select name="idCategoria"
                                        id="categoriaIn"
                                        class="form-control required col-12"
                                        style="width:100%"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una opción"
                                        data-validation-error-msg-container="#errorCategoria">
                                    <option value=""></option>
                                    @foreach ($listaCategoriasRepuesto as $categoria)
                                        <option value="{{ $categoria->id_categoria_repuesto }}">
                                            {{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                                <div id="errorCategoria"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="unidadMedidaIn"
                                   class="col-sm-6 justify-content-end">Unidad de medida:</label>
                            <div class="col-sm-6">
                                <select name="idUnidad"
                                        id="unidadMedidaIn"
                                        class="form-control required col-12"
                                        style="width:100%"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una opción"
                                        data-validation-error-msg-container="#errorUnidadMedida">
                                    <option value=""></option>
                                    @foreach ($listaUnidades as $unidadMedida)
                                        <option @if ($unidadMedida->id_unidad_medida == 58) selected @endIf
                                                value="{{ $unidadMedida->id_unidad_medida }}">
                                            {{ $unidadMedida->nombre_unidad }}</option>
                                    @endforeach
                                </select>
                                <div id="errorUnidadMedida"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="unidadGrupoIn"
                                   class="col-sm-6 justify-content-end">Unidad de contenido:</label>
                            <div class="col-sm-6">
                                <select name="idUnidadGrupo"
                                        id="unidadGrupoIn"
                                        class="form-control required col-12"
                                        style="width:100%">
                                    <option value="">Sin grupo</option>
                                    @foreach ($listaUnidades as $unidadGrupo)
                                        <option value="{{ $unidadGrupo->id_unidad_medida }}">
                                            {{ $unidadGrupo->nombre_unidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="cantGrupoIn"
                                   class="col-sm-6 justify-content-end">Contenido: </label>
                            <div class="col-sm-6">
                                <input name="cantGrupo"
                                       type="text"
                                       class="form-control col-12"
                                       tipo="repuestos"
                                       id="cantGrupoIn"
                                       style="width:100%"
                                       data-validation="number"
                                       data-validation-error-msg="Debe ingresar una cantidad"
                                       data-validation-error-msg-container="#errorCantGrupo"
                                       data-validation-depends-on="idUnidadGrupo"
                                       disabled>
                                <div id="errorCantGrupo"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="ubicacionIn"
                                   class="col-sm-6 justify-content-end">Ubicación:</label>
                            <div class="col-sm-6">
                                <input name="ubicacion"
                                       type="text"
                                       class="form-control col-12"
                                       id="ubicacionIn"
                                       style="width:100%"
                                       data-validation-error-msg="Debe especificar la ubicación del repuesto"
                                       data-validation-error-msg-container="#errorUbicacionRepuesto"
                                       placeholder="Ingrese la ubicación del repuesto">
                                <div id="errorUbicacionRepuesto"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="monedaIn"
                                   class="col-sm-6 justify-content-end">Moneda:</label>
                            <div class="col-sm-6">
                                <select name="moneda"
                                        id="monedaIn"
                                        class="form-control required col-12"
                                        style="width:100%"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una opción"
                                        data-validation-error-msg-container="#errorMoneda">
                                    <option value=""></option>
                                    <option value="SOLES">Soles</option>
                                    <option value="DOLARES">Dolares</option>
                                </select>
                                <div id="errorMoneda"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="precioRepuestoIn"
                                   class="col-sm-6 justify-content-end">Precio de Venta*:</label>
                            <div class="col-sm-6">
                                <input name="pvp"
                                       type="text"
                                       class="form-control col-12"
                                       id="precioRepuestoIn"
                                       style="width:100%"
                                       data-validation="number required"
                                       data-validation-allowing="float"
                                       data-validation-error-msg="Debe especificar el precio del repuesto"
                                       data-validation-error-msg-container="#errorPrecioRepuesto"
                                       placeholder="Ingrese el precio del repuesto">
                                <div id="errorPrecioRepuesto"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            <label for="margenRepuestoIn"
                                   class="col-sm-6 justify-content-end">Margen(%):</label>
                            <div class="col-sm-6">
                                <input name="margen"
                                       type="text"
                                       class="form-control col-12"
                                       id="margenRepuestoIn"
                                       style="width:100%"
                                       data-validation="number required"
                                       data-validation-allowing="float"
                                       data-validation-error-msg="Debe especificar el margen del repuesto"
                                       data-validation-error-msg-container="#errorMargenRepuesto"
                                       placeholder="Ingrese el margen del repuesto">
                                <div id="errorMargenRepuesto"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline ">
                            <div class="col-6"
                                 style="text-align: right">
                                <div class="custom-control custom-switch ">
                                    <input type="checkbox"
                                           class="custom-control-input col-6"
                                           name="customSwitchMayoreo"
                                           id="customSwitchMayoreo">
                                    <label class="custom-control-label col-12"
                                           for="customSwitchMayoreo">
                                        <div id="customSwitchMayoreoText"
                                             name="customSwitchMayoreoText">Sin Mayoreo</div>
                                    </label>
                                </div>
                            </div>


                            <div class="col-6">
                                <input name="precioMayoreo"
                                       type="number"
                                       class="form-control col-12 ml-1"
                                       step="any"
                                       id="precioMayoreo"
                                       style="width:100%;display:none;"
                                       data-validation="number "
                                       data-validation-allowing="float"
                                       data-validation-error-msg-container="#errorPrecioMayoreo"
                                       placeholder="Ingrese el precio">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-12 px-0">
                        <div class="col-md-6 col-xl-4">

                            <div class="create_switch_element"
                                 label-text="Accesorio Ventas"
                                 input-name="aplicacion_ventas"
                                 data-text-checked="SI"
                                 data-text-unchecked="NO"
                                 data-class="ventas_accesorio"
                                 {{-- checked --}}>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="form-group form-inline">
                            @include("modals.modalModelosTecnicos",['modelosTecnicos'=>$modelosTecnicos])
                        </div>
                    </div>


                </div>
            </div>
            <p class="ml-3 mt-3 mb-4"
               style="color:red; font-weight:bold">*Precios incluyen IGV</p>
            <div class="row justify-content-center">
                <button id="btnRegistrarRecepcion"
                        value="Submit"
                        type="submit"
                        class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>

@endsection

@section('extra-scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/switch.js') }}"></script>
@endsection
