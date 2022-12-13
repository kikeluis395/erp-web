@extends('repuestos.repuestosCanvas')
@section('titulo', 'Meson - Crear Cotización')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <div class="col-12 mt-2 mt-sm-0">
            <h2 class="ml-3 mt-3 mb-4">Creación de cotización de repuestos</h2>
        </div>

        @include('modals.personalInfoUser')

        <form id="FormMesonCotizacion"
              class="my-3"
              method="POST"
              action="{{ route('meson.store') }}"
              autocomplete="off">
            @csrf
            <div class="row">
                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="nroDocIn"
                           class="col-form-label col-12 col-sm-6">{{ config('app.rotulo_documento') }}:</label>
                    <div class="col-12 col-sm-6 p-0">
                        <input id="nroDocIn"
                               name="nroDoc"
                               type="text"
                               class="form-control col-12"
                               placeholder="Número de documento"
                               data-validation="required"
                               data-validation-error-msg="Ingrese numero de documento"
                               data-validation-error-msg-container="#errorNroDoc"
                               required>
                        <span id="hintCliente"></span>
                        <div id="errorNroDoc"
                             class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                    </div>
                </div>

                <input id="modal_tipo_doc"
                       type="hidden"
                       name="modal_tipo_doc"
                       value="">
                <input id="modal_cliente"
                       type="hidden"
                       name="modal_cliente"
                       value="">
                <input id="modal_nombres"
                       type="hidden"
                       name="modal_nombres"
                       value="">
                <input id="modal_apellido_pat"
                       type="hidden"
                       name="modal_apellido_pat"
                       value="">
                <input id="modal_apellido_mat"
                       type="hidden"
                       name="modal_apellido_mat"
                       value="">

                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="nombreClienteIn"
                           class="col-form-label col-12 col-sm-4">Cliente:</label>
                    <div class="input-group col-12 col-sm-8 px-0">
                        <input id="nombreClienteIn"
                               type="text"
                               class="form-control "
                               placeholder="Nombre del cliente"
                               name="nombreCliente"
                               disabled>
                        <div class="input-group-append"
                             style="display:none;"
                             id="edit_client_button">
                            <button class="btn btn-outline-secondary"
                                    id="datosNUser"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#datosNuevoCliente"
                                    data-backdrop="static"><i class="fa fa-edit"></i></button>
                        </div>
                    </div>
                </div>

                {{-- <div class="form-group row ml-1 col-6 col-xl-3">
        <label for="nombreClienteIn" class="col-form-label col-12 col-sm-6">Cliente:</label>
        <input id="nombreClienteIn" type="text" class="form-control col-12 col-sm-6" placeholder="Nombre del cliente" name="nombreCliente">
      </div> --}}
                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="correoIn"
                           class="col-form-label col-12 col-sm-6">Correo:</label>
                    <input id="correoIn"
                           type="text"
                           class="form-control col-12 col-sm-6"
                           placeholder="Correo del cliente"
                           name="correo">
                </div>
                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="telefonoIn"
                           class="col-form-label col-12 col-sm-6">Teléfono:</label>
                    <input id="telefonoIn"
                           type="text"
                           class="form-control col-12 col-sm-6"
                           placeholder="Teléfono del cliente"
                           name="telefono">
                </div>
                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="monedaIn"
                           class="col-form-label col-6">Moneda: </label>
                    <select name="moneda"
                            id="monedaIn"
                            class="form-control col-6">
                        <option value="SOLES">SOLES</option>
                        <option value="DOLARES">DÓLARES</option>
                    </select>
                </div>
                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="direccionIn"
                           class="col-form-label col-12 col-sm-6">Dirección:</label>
                    <input id="direccionIn"
                           type="text"
                           class="form-control col-12 col-sm-6"
                           placeholder="Dirección del cliente"
                           name="direccion"
                           required>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="departamentoIn"
                           class="col-form-label col-6">Departamento: </label>
                    <select name="departamento"
                            id="departamentoIn"
                            class="form-control col-6"
                            data-validation="required"
                            data-validation-depends-on="distrito"
                            data-validation-error-msg=" "
                            required>
                        <option value=""></option>
                        @foreach ($listaDepartamentos as $departamento)
                            <option value="{{ $departamento->codigo_departamento }}">{{ $departamento->departamento }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="provinciaIn"
                           class="col-form-label col-6">Provincia: </label>
                    <select name="provincia"
                            id="provinciaIn"
                            class="form-control col-6"
                            data-validation="required"
                            data-validation-depends-on="departamento"
                            data-validation-error-msg=" "
                            required>
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="distritoIn"
                           class="col-form-label col-6">Distrito: </label>
                    <select name="distrito"
                            id="distritoIn"
                            class="form-control col-6"
                            data-validation="required"
                            data-validation-depends-on="provincia"
                            data-validation-error-msg=" "
                            required>
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="modeloTecnicoIn"
                           class="col-form-label col-6">Modelo técnico: </label>
                    <select name="modeloTecnico"
                            id="modeloTecnicoIn"
                            class="form-control col-6"
                            >
                        <option value=""></option>
                        @foreach ($listaModelosTecnicos as $modeloTecnico)
                            <option value="{{ $modeloTecnico->id_modelo_tecnico }}">{{ $modeloTecnico->nombre_modelo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <div class="form-group form-inline col-6 form-group-align-top">
                        <label for="observacionesIn">Observaciones:</label>
                        <textarea name="observaciones"
                                  type="text"
                                  class="form-control col-10 ml-3"
                                  id="observacionesIn"
                                  placeholder="Ingrese sus observaciones"
                                  maxlength="255"
                                  rows="3"
                                  autocomplete="off"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection


@section('table-content')
    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        <div class="row justify-content-end mr-4">
            <div>
                <span style="font-size: 17px">{{ Helper::mensajeIncluyeIGV() }}</span>
            </div>
        </div>
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 justify-content-between">
                        <div>
                            <h2>Repuestos a cotizar</h2>
                        </div>
                        <div>
                            <button id="btnAgregarRepuestoMeson"
                                    type="button"
                                    style="margin-left:15px"
                                    class="btn btn-warning">+</button>
                        </div>
                    </div>
                </div>

                <div class="table-cont-single">
                    <table id="tableRepuestosMeson"
                           tipo="nuevo"
                           class="table text-center table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">CÓDIGO</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">UNIDAD</th>
                                <th scope="col">CANT.</th>
                                <th scope="col">MAYOREO</th>
                                <th scope="col">DISPONIBILIDAD</th>
                                <th scope="col">¿ES IMPORTACIÓN?</th>
                                <th scope="col">P. UNIT.</th>
                                <th scope="col">TOTAL</th>
                                <th scope="col">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="p-0 mt-3">
            <div class="col-xl-12 p-0 mt-3">
                <div class="row justify-content-end m-0">
                    <div class="row col-6">
                        <span class="font-weight-bold col-9 text-right"
                              style="font-size: 17px; padding-top:1px">TOTAL: </span> <span class="col-3"><span
                                  id="simboloTotalCot"></span> <span id="totalCot">0.00</span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-0 mt-5">
            <div class="col-xl-12 p-0 mt-3">
                <div class="row justify-content-end m-0">
                    <div><button id="btnGuardarCotizacionMeson"
                                value="Submit"
                                type="submit"
                                form="FormMesonCotizacion"
                                style="margin-left:15px"
                                class="btn btn-warning">Finalizar registro</button></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/meson.js?v=' . time()) }}"></script>
    <script src="{{ asset('js/cotizaciones.js?v=' . time()) }}"></script>
@endsection
