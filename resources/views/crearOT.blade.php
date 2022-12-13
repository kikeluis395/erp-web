@extends('mecanica.tableCanvas')
@section('titulo', 'Modulo de recepción - Registrar OT B&P')

@section('pretable-content')
@endsection

@section('table-content')
    <script>
        var modelos = {!! $listaModelos !!}
        var modelos_tenicos = {!! $listaModelosTecnicos !!}
    </script>
    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 15px 10px 10px 15px">
        <div class="row justify-content-between col-12">
            <h2 class="ml-3 mt-3 mb-0">Registro de OT - B&P</h2>
        </div>
        <p class="ml-3 mt-3 mb-4">Ingrese los datos del cliente para continuar con el registro</p>
        <form class="col-xl-12"
              id="FormRegistrarRecepcion"
              method="POST"
              action="{{ route('recepcion.store') }}"
              value="Submit"
              autocomplete="off"
              onkeydown="return event.key != 'Enter';">
            @csrf

            <div class="card mb-3"
                 style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Datos del vehiculo</h5>
                    <div class="row">

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="tipoOTin"
                                       class="col-sm-4 justify-content-end">Tipo de OT:</label>
                                <div class="col-sm-8">
                                    <select name="tipoOT"
                                            id="tipoOTin"
                                            class="form-control required col-lg-8"
                                            style="width:100%"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#errorTipoOT">
                                        <option value=""></option>
                                        @foreach ($listaTiposOT as $tipoOT)
                                            <option value="{{ $tipoOT->id_tipo_ot }}">{{ $tipoOT->nombre_tipo_ot }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="errorTipoOT"
                                         class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-3">
                            <div class="form-group row  ">
                                <label for="nroPlacaIn"
                                       class="col-3 justify-content-end">Placa:</label>
                                <div class="col-6">
                                    <input name="nroPlaca"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="nroPlacaIn"
                                           data-validation="length"
                                           data-validation-length="6"
                                           data-validation-error-msg="Debe ingresar una placa de 6 caracteres"
                                           data-validation-error-msg-container="#errorPlaca"
                                           placeholder="Ingrese el número de placa"
                                           maxlength="6"
                                           oninput="this.value = this.value.trim().toUpperCase()">
                                    <div id="errorPlaca"
                                         class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                    <div id="hintPlaca"
                                         class="col-12 text-left no-gutters pr-0"></div>
                                </div>
                                <a class="col-2"><button id="btnBuscarPlaca"
                                            type="button">Buscar</button></a>
                            </div>
                        </div> --}}


                        <div class="col-3">
                            <div class="form-group row justify-content-between">

                                <label for="nroPlacaIn"
                                       class="col-3 justify-content-end">Placa:</label>
                                <div class="input-group col-6 col-sm-6 px-0">
                                    <input name="nroPlaca"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="nroPlacaIn"
                                           data-validation="length"
                                           data-validation-length="6"
                                           data-validation-error-msg="Debe ingresar una placa de 6 caracteres"
                                           data-validation-error-msg-container="#errorPlaca"
                                           placeholder="Ingrese el número de placa"
                                           maxlength="6"
                                           oninput="this.value = this.value.trim().toUpperCase()">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary"
                                                id="btnBuscarPlaca"
                                                type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                                <div id="errorPlaca"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                <div id="hintPlaca"
                                     class="col-12 text-left no-gutters pr-0"></div>
                            </div>
                        </div>


                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="kilometrajeInExt"
                                       class="col-4 justify-content-end">Kilometraje:</label>
                                <div class="col-sm-6">
                                    <input name="kilometraje"
                                           type="text"
                                           class="form-control col-lg-12"
                                           style="width:100%"
                                           id="kilometrajeInExt"
                                           data-validation="required number"
                                           data-validation-error-msg="Debe especificar el kilometraje del vehiculo"
                                           data-validation-error-msg-container="#errorKilometraje"
                                           placeholder="Ingrese el kilometraje del vehiculo"
                                           maxlength="8"
                                           required>
                                    <div id="errorKilometraje"
                                         class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="ciaSeguroIn"
                                       class="col-6 justify-content-end">Compañía de seguros:</label>
                                <div class="col-6">
                                    <select name="seguro"
                                            id="ciaSeguroIn"
                                            class="form-control col-lg-12"
                                            style="width:100%"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#errorSeguro"
                                            required>
                                        <option value=""></option>
                                        @foreach ($listaSeguros as $seguro)
                                            <option value="{{ $seguro->id_cia_seguro }}">
                                                {{ $seguro->nombre_cia_seguro }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="errorSeguro"
                                         class="col-sm-8 validation-error-cont text-right no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="monedaIn"
                                       class="col-4 justify-content-end">Moneda:</label>
                                <div class="col-8">
                                    <select name="moneda"
                                            id="monedaIn"
                                            class="form-control col-lg-12"
                                            style="width:100%"
                                            data-validation="length"
                                            data-validation-length="min1"
                                            data-validation-error-msg="Debe seleccionar una opción"
                                            data-validation-error-msg-container="#errorMoneda"
                                            required>
                                        <option value=""></option>
                                        <option value="SOLES">Soles</option>
                                        <option value="DOLARES">Dólares</option>
                                    </select>
                                    <div id="errorMoneda"
                                         class="col-sm-8 validation-error-cont text-right no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3"
                                 id="divTipoCambioSeguro">
                                <label for="tipoCambioIn"
                                       class="col-sm-6 justify-content-end">Tipo de cambio Seguro:</label>
                                <div class="col-sm-6">
                                    <input name="tipoCambio"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="tipoCambioIn"
                                           style="width:100%"
                                           placeholder="Ingrese el tipo de cambio">
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="numer_poliza"
                                       class="col-sm-6 justify-content-end">Nº. Poliza:</label>
                                <div class="col-sm-6">
                                    <input name="nro_poliza"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="numer_poliza"
                                           style="width:100%"
                                           placeholder="Ingrese número de póliza">
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3"
                                 id="divTipoCambioSeguro">
                                <label for="numero_siniestro"
                                       class="col-sm-6 justify-content-end">Nº. Siniestro:</label>
                                <div class="col-sm-6">
                                    <input name="nro_siniestro"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="numero_siniestro"
                                           style="width:100%"
                                           placeholder="Ingrese número de siniestro">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card mb-3"
                 style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Datos del cliente</h5>
                    <div class="row">

                        {{-- <div class="col-3">
                            <div class="form-group row ">
                                <label for="clienteIn"
                                       class="col-3  justify-content-end">Cliente:</label>
                                <div class="col-6">
                                    <input name="cliente"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="clienteIn"
                                           data-validation="required"
                                           data-validation-error-msg="Debe especificar el DNI o RUC del cliente"
                                           data-validation-error-msg-container="#errorClienteExt"
                                           placeholder="Ingrese el DNI o RUC del cliente"
                                           maxlength="15"
                                           disabled>

                                    <div id="errorClienteExt"
                                         class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                    <div id="hintCliente"
                                         class="col-12 text-left no-gutters pr-0"></div>
                                </div>
                                <a class="col-2"><button id="btnBuscarCliente"
                                            type="button">Buscar</button></a>
                            </div>
                        </div> --}}

                        <div class="col-3">
                            <div class="form-group row justify-content-between">
                                <label for="clienteIn"
                                       class="col-3 justify-content-end">Cliente:</label>

                                <div class="input-group col-6 col-sm-6 px-0">
                                    <input name="cliente"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="clienteIn"
                                           data-validation="required"
                                           data-validation-error-msg="Debe especificar el DNI o RUC del cliente"
                                           data-validation-error-msg-container="#errorClienteExt"
                                           placeholder="Ingrese el DNI o RUC del cliente"
                                           maxlength="15"
                                           disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary"
                                                id="btnBuscarCliente"
                                                type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                                <div id="errorClienteExt"
                                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                <div id="hintCliente"
                                     class="col-12 text-left no-gutters pr-0"></div>

                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="contactoInExt"
                                       class="col-4 justify-content-end">Contacto:</label>
                                <div class="col-8">
                                    <input name="contacto"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="contactoInExt"
                                           data-validation="required"
                                           data-validation-error-msg="Debe especificar el nombre del contacto"
                                           data-validation-error-msg-container="#errorContacto"
                                           placeholder="Ingrese el nombre del contacto"
                                           disabled>
                                    <div id="errorContacto"
                                         class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="telfContactoInExt"
                                       class="col-4 justify-content-end">Telf. Contacto:</label>
                                <div class="col-8">
                                    <input name="telfContacto"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="telfContactoInExt"
                                           style="width:100%"
                                           data-validation="required"
                                           data-validation-error-msg="Debe especificar el teléfono del contacto"
                                           data-validation-error-msg-container="#errorTelfContacto"
                                           placeholder="Ingrese el teléfono del contacto"
                                           disabled>
                                    <div id="errorTelfContacto"
                                         class="col-8 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>






                        <div class="col-3 mb-3">
                            <div class="form-group row mb-3">
                                <label for="correoContactoInExt"
                                       class="col-4 justify-content-end">Correo Contacto:</label>
                                <div class="col-8">
                                    <input name="correoContacto"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="correoContactoInExt"
                                           style="width:100%"
                                           data-validation=""
                                           data-validation-error-msg="Debe especificar el correo del contacto"
                                           data-validation-error-msg-container="#errorCorreoContacto"
                                           placeholder="Ingrese el correo del contacto"
                                           disabled>
                                    <div id="errorCorreoContacto"
                                         class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



            <div class="card"
                 style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Datos de facturación</h5>
                    <div class="row">

                        <div class="col-3 mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       name="customSwitch1"
                                       id="customSwitch1">
                                <label class="custom-control-label"
                                       for="customSwitch1">
                                    <div id="customSwitch1Text"
                                         name="customSwitch1Text">PAGO CON BOLETA</div>
                                </label>
                            </div>
                        </div>

                        <div class="col-3 mb-3">
                            <div class="form-group row mb-3">
                                <label for="facturara"
                                       id="facturaraText"
                                       class="col-4 justify-content-end">Nombre:</label>
                                <div class="col-8">
                                    <input name="facturara"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="facturara"
                                           style="width:100%"
                                           data-validation="required"
                                           data-validation-error-msg="Debe especificar el nombre de a quien facturar"
                                           data-validation-error-msg-container="#errorFacturara"
                                           placeholder="Ingrese el nombre"
                                           disabled>
                                    <div id="errorFacturara"
                                         class="col-8 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label class="col-4 justify-content-end">N° Documento:</label>
                                <div class="col-8">
                                    <input name="numDoc"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="numDoc"
                                           style="width:100%"
                                           data-validation="required"
                                           data-validation-error-msg="Debe especificar numero de documento"
                                           data-validation-error-msg-container="#errorDocumento"
                                           placeholder="Ingrese el numero de documento"
                                           disabled>
                                    <div id="errorDocumento"
                                         class="col-8 validation-error-cont text-left no-gutters pr-0"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label class="col-4 justify-content-end">Dirección Facturación:</label>
                                <div class="col-8">
                                    <input name="direccion"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="direccion"
                                           style="width:100%"
                                           placeholder="Ingrese la dirección ">
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group form-inline">
                                <label for="fact_departamentoIn"
                                       class="col-sm-6 justify-content-end">Departamento:</label>
                                <select name="departamento"
                                        id="fact_departamentoIn"
                                        class="form-control col-sm-6"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar un departamento"
                                        data-validation-error-msg-container="#errorDepartamento"
                                        required>
                                    <option value=""></option>
                                    @foreach ($listaDepartamentos as $departamento)
                                        <option value="{{ $departamento->codigo_departamento }}">
                                            {{ $departamento->departamento }}</option>
                                    @endforeach
                                </select>
                                <div id="errorDepartamento"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group form-inline">
                                <label for="fact_provinciaIn"
                                       class="col-sm-6 justify-content-end">Provincia:</label>
                                <select name="provincia"
                                        id="fact_provinciaIn"
                                        class="form-control col-sm-6"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar una provincia"
                                        data-validation-error-msg-container="#errorProvincia"
                                        required>
                                    <option value=""></option>
                                    @if (false)
                                        @foreach ($listaProvincias as $provincia)
                                            <option value="{{ $provincia->codProvincia }}">{{ $provincia->nombre }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="errorProvincia"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group form-inline">
                                <label for="fact_distritoIn"
                                       class="col-sm-6 justify-content-end">Distrito:</label>
                                <select name="distrito"
                                        id="fact_distritoIn"
                                        class="form-control col-sm-6"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Debe seleccionar un distrito"
                                        data-validation-error-msg-container="#errorDistrito"
                                        required>
                                    <option value=""></option>
                                    @if (false)
                                        @foreach ($listaDistritos as $distrito)
                                            <option value="{{ $distrito->codDistrito }}">{{ $distrito->nombre }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="errorDistrito"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                        </div>





                        {{-- <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="telfContactoInExt2"
                                       class="col-4 justify-content-end">Telf. Contacto:</label>
                                <div class="col-8">
                                    <input name="telfContacto2"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="telfContactoInExt2"
                                           style="width:100%"
                                           placeholder="Ingrese el teléfono del contacto"
                                           disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group row mb-3">
                                <label for="correoContactoInExt2"
                                       class="col-4 justify-content-end">Correo Contacto:</label>
                                <div class="col-8">
                                    <input name="correoContacto2"
                                           type="text"
                                           class="form-control col-lg-12"
                                           id="correoContactoInExt2"
                                           style="width:100%"
                                           placeholder="Ingrese segundo correo del contacto"
                                           disabled>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>



            <div class="row justify-content-center">
                <button id="btnRegistrarRecepcion"
                        value="Submit"
                        type="submit"
                        class="btn btn-primary">Registrar</button>
            </div>
        </form>
    </div>

    @include('modals.registrarCliente')
    @include('modals.registrarVehiculo')
@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/recepcion.js') }}"></script>
@endsection
