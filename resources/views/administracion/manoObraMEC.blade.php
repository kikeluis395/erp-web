@extends('mecanica.tableCanvas')
@section('titulo', 'MEC:Mano de Obra - Administración')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">MEC: Mano de Obra</h2>
    </div>
@endsection

@section('table-content')
    <script>
        var seccion = 'MEC'
        var costo = {!! $costo_exists ? json_encode($costo) : json_encode((object) []) !!}
        var costo_exists = "{!! $costo_exists ? '1' : '0' !!}"

        var precio = {!! $precio_exists ? json_encode($precio) : json_encode((object) []) !!}
        var precio_exists = "{!! $precio_exists ? '1' : '0' !!}"
    </script>
    <style>
        .title_section {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 10px 30px;
            min-width: 100%;
            border-radius: 7px 7px 0 0;
        }

        .content_section {
            border: solid;
            border-width: 1px;
            border-color: #0000004d;
            border-top-width: 0px;
            border-radius: 0px 0px 7px 7px;
            padding-top: 2rem;
            padding-bottom: 1rem;
        }

        .section_button button {
            padding: 10px 50px;
            /* border-radius: 10px; */
            text-transform: uppercase;
            font-size: 18px
        }

        .form_section {
            position: relative;
        }

        .table_section td {
            padding: 10px 55px;
        }

        label {
            height: fit-content;
            font-size: 1.2em !important
        }

        .form-group {
            height: fit-content;
        }

        .alert-danger {
            background-color: #f9f0f1;
        }

        .alert {
            border-radius: 10px 10px 7px 7px;
            position: absolute;
            bottom: -15px;
            border-bottom-width: 0;
            border-left-width: 0;
            border-right-width: 0;
        }

        .custom-control-label {
            padding-left: 2rem;
            padding-bottom: 0.1rem;
        }

        .custom-switch .custom-control-label::before {
            left: -2.25rem;
            height: 1.5rem;
            width: 3rem;
            pointer-events: all;
            border-radius: 1.5rem;
        }

        .custom-switch .custom-control-label::after {
            top: calc(0.25rem + 2px);
            left: calc(-2.25rem + 2px);
            width: calc(1.5rem - 4px);
            height: calc(1.5rem - 4px);
            background-color: #adb5bd;
            border-radius: 1.5rem;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
            transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .custom-switch .custom-control-label::after {
                transition: none;
            }
        }

        .custom-switch .custom-control-input:checked~.custom-control-label::after {
            background-color: #fff;
            -webkit-transform: translateX(1.5rem);
            transform: translateX(1.5rem);
        }

    </style>

    @php
    $pe = $precio_exists;
    $seccion = 'MEC';
    $monedas = ['SOLES' => 'SOLES', 'DOLARES' => 'DÓLARES'];
    @endphp


    @include('modals.costoMensualMEC')

    <div class="mx-3"
         style="background: white;padding: 15px;overflow-y:auto;">

        <form id="formPrecioServicio"
              method="POST"
              action="{{ route('mecanica_mo.store') }}"
              class="form_section">

            @csrf


            <input type="hidden"
                   name="actual_precio_hh"
                   value="{{ $precio_exists ? $precio->precio_valor_venta : '' }}" />
            <input type="hidden"
                   name="actual_costo_hh"
                   value="{{ $costo_exists ? $costo->valor_costo : '' }}" />

            <div>
                <div class="table-responsive">
                    <div class="title_section">
                        <h4 class="mb-0">Precios del Servicio</h4>
                    </div>
                    <div class="content_section">
                        <div class="form_section">

                            <div class="row justify-content-center w-100">
                                <table border="0"
                                       class="w-40">
                                    <tr>

                                        <td>
                                            <div class="row w-100">
                                                <label for="precioHoraHombre"
                                                       class="col-form-label text-center col-sm-6 col-lg-6">PRECIO HORA
                                                    HOMBRE:</label>
                                                <input id="precioHoraHombre"
                                                       name="precio_valor_venta"
                                                       type="number"
                                                       step="any"
                                                       class="form-control col-sm-6 col-lg-6"
                                                       placeholder="Precio Hora Hombre"
                                                       style="font-size: 25px; text-align: center"
                                                       value="{{ $pe ? $precio->precio_valor_venta : '' }}"
                                                       onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                       required
                                                       data-validation="required">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <div style="position:relative;"
                                                     class="justify-content-center align-content-center">
                                                    <input name="garantia_rechazada"
                                                           type="checkbox"
                                                           class="custom-control-input moneda_switch"
                                                           id="monedaPrecioServicio"
                                                           {{ $pe ? ($precio->moneda === 'DOLARES' ? 'checked' : '') : '' }}>
                                                    <label class="custom-control-label"
                                                           for="monedaPrecioServicio">{{ $pe ? $monedas[$precio->moneda] : '' }}</label>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                            </div>

                            <div class="row col-8 sm-8 md-8 lg-8 justify-content-end mt-3"
                                 style="height: 70px"></div>

                            <div class="alert alert-danger px-5 w-100 mb-0"
                                 role="alert"
                                 align="center">
                                <h5 style="font-weight:200; text-transform:uppercase"
                                    class="mb-0">Colocar precio con IGV</h5>
                            </div>

                        </div>

                        {{-- <form id="formPrecioServicio"
                          method="POST"
                          action="{{ route('garantia.index') }}"
                          class="form_section"> --}}

                    </div>
                </div>
            </div>

            @php
                $ce = $costo_exists;
            @endphp

            <div class="mt-4">
                <div class="table-responsive">
                    <div class="title_section">
                        <h4 class="mb-0">Costos Asociados</h4>
                    </div>
                    <div class="content_section">

                        <div class="form_section">

                            <div class="flex-wrap d-flex container-fluid justify-content-between align-items-center">

                                <div class="form-group row col-3 sm-6 md-3 lg-3 custom-control custom-switch">
                                    <div style="position:relative;"
                                         class="row justify-content-center align-content-center">

                                        <input name="garantia_rechazada"
                                               type="checkbox"
                                               class="custom-control-input tipo_personal"
                                               id="tipoPersonal">
                                        <label class="custom-control-label"
                                               for="tipoPersonal">PERSONAL PROPIO</label>
                                    </div>
                                </div>

                                <div class="form-group row col-3 sm-6 md-3 lg-3">
                                    <button type="button"
                                            class="btn btn-warning rounded-pill px-5"
                                            id="costo_mensual"
                                            data-toggle="modal"
                                            data-target="#crearST">Costo Mensual</button>

                                </div>

                                <div class="form-group row col-6 sm-6 md-6 lg-6"></div>


                                <div class="form-group row col-12 sm-12 md-12 lg-12 justify-content-center">

                                    <table border="0"
                                           class="table_section"
                                           style="display: none">
                                        <tr>
                                            <td align="left">
                                                <label class="col-form-label pt-0">
                                                    METODO DE COSTO:</label>
                                            </td>
                                            <td align="center">
                                                <div class="form-group row custom-control custom-switch">
                                                    <input name="garantia_rechazada"
                                                           type="checkbox"
                                                           class="custom-control-input metodo_costo"
                                                           id="tipoMetodoCosto">
                                                    <label class="custom-control-label"
                                                           for="tipoMetodoCosto">MONEDA</label>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label for="costoHoraHombre"
                                                       class="col-form-label">COSTO H-H:</label>
                                            </td>
                                            <td>
                                                <input id="costoHoraHombre"
                                                       name="valor_costo"
                                                       type="number"
                                                       step="any"
                                                       class="form-control"
                                                       placeholder="Costo Hora Hombre"
                                                       style="font-size: 25px; text-align: center"
                                                       value="{{ $ce ? $costo->valor_costo : '' }}"
                                                       onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))">
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch row align-content-center">
                                                    <div class="pl-5 in_coin">
                                                        <input name="garantia_rechazada"
                                                               type="checkbox"
                                                               class="custom-control-input moneda_switch"
                                                               id="monedaCostoAsociado">
                                                        <label class="custom-control-label"
                                                               for="monedaCostoAsociado">SOLES</label>
                                                    </div>
                                                    <span class="percentaje"
                                                          style="display: none">%</span>
                                                </div>

                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div id="alert_costos"
                                 style="display:none; position:relative">
                                <div class="row col-8 sm-8 md-8 lg-8 justify-content-end mt-3"
                                     style="height: 50px"></div>

                                <div class="alert alert-danger px-5 w-100 mb-0"
                                     role="alert"
                                     align="center">
                                    <h5 style="font-weight:200; text-transform:uppercase"
                                        class="mb-0 glose_cost">C</h5>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </form>

        <div class="row w-100 justify-content-end mt-3">
            <div class="section_button">
                <button type="submit"
                        form="formPrecioServicio"
                        class="btn btn-primary rounded-pill">Guardar</button>
            </div>
        </div>

    </div>
@endsection


@section('extra-scripts')
    @parent
    <script src="{{ asset('js/mo.js') }}"></script>
@endsection
