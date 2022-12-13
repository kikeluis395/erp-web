@extends('mecanica.tableCanvas')
@section('titulo', 'Generalidades del Dealer - Administración')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">Generalidades del Dealer</h2>
    </div>
@endsection

@section('table-content')
    <script>
        var last_fecha = "{!! $last_fecha !!}"
        var horario = {!! json_encode($horario) !!}
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
            position: relative;
            height: 300px;
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

        .glose_inf {
            border-radius: 10px 10px 7px 7px;
            position: absolute;
            bottom: -15px;
            border-bottom-width: 0;
            border-left-width: 0;
            border-right-width: 0;
        }

        .glose_sup {
            border-radius: 7px 7px 10px 10px;
            position: absolute;
            top: 0px;
            border-top-width: 0;
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

        .first_column {
            font-weight: bold;
            padding: 4px 35px !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.068)
        }

        tbody td {
            padding: 8px 24px
        }

        th,
        td {
            border-right: 1px solid rgba(0, 0, 0, 0.068)
        }

        thead th:last-child,
        tr td:last-child {
            border-right: 0px;
        }

        .long {
            padding: 4px 15px
        }

    </style>

    <div class="mx-3"
         style="background: white;padding: 15px;overflow-y:auto;">

        <form id="formPrecioServicio"
              method="POST"
              action="{{ route('dealer.horario') }}"
              class="form_section">

            @csrf
            <input type="hidden"
                   name="id_horario"
                   value={{ $horario['id_horario'] }}>

            <div class="row w-100 mx-0 mb-5">
                <div class="col-6 d-flex mx-0 justify-content-center">
                    <div class="w-100">
                        <div class="table-responsive">
                            <div class="title_section">
                                <h4 class="mb-0">Horario</h4>
                            </div>
                            <div class="content_section justify-content-center d-flex align-content-center">

                                {{-- <div class="row col-12 sm-12 md-12 lg-12 justify-content-end mt-3"
                                     style="height: 30px"></div>

                                <div class="alert alert-danger px-5 w-100 mb-0 glose_sup"
                                     role="alert"
                                     align="center">
                                    <h5 style="font-weight:200; text-transform:uppercase"
                                        class="mb-0">Configuracion vigente desde el: {{ $horario['aplica_desde'] }}</h5>
                                </div> --}}

                                @php
                                    $options = ['LV' => 'LUNES - VIERNES', 'S' => 'SABADO', 'D' => 'DOMINGO'];
                                    $limites = ['IN' => 'Ingreso', 'OUT' => 'Salida'];
                                @endphp

                                <table border="0"
                                       style="margin: auto">
                                    <thead>
                                        <th></th>
                                        @foreach (array_keys($limites) as $limite)
                                            <th style="font-weight: bold; text-align:center">
                                                {{ $limites[$limite] }}
                                            </th>
                                        @endforeach
                                    </thead>
                                    <tbody>
                                        @foreach (array_keys($options) as $option)
                                            <tr>
                                                <td>{{ $options[$option] }}:</td>
                                                @foreach (array_keys($limites) as $limite)
                                                    @php
                                                        $unique = $option . '_' . $limite;
                                                        $min = $limite === 'IN' ? '07:00' : '17:00';
                                                        $max = $limite === 'IN' ? '09:00' : '19:00';
                                                    @endphp
                                                    <td>
                                                        <div class="form-group form-inline">
                                                            <input name="H_{{ $unique }}"
                                                                   id="H_{{ $unique }}"
                                                                   type="time"
                                                                   step="3600"
                                                                   min="{{ $min }}"
                                                                   max="{{ $max }}"
                                                                   class="form-control col-12"
                                                                   data-validation="required"
                                                                   data-validation-format="HH:mm"
                                                                   data-validation-length="5"
                                                                   data-validation-error-msg="Ingrese una hora valida"
                                                                   data-validation-error-msg-container="#error_time_{{ $unique }}"
                                                                   value="{{ $horario["H_$unique"] }}">

                                                            <div id="error_time_{{ $unique }}"
                                                                 class="col-12 validation-error-cont text-right no-gutters pr-0">
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 d-flex mx-0 justify-content-center">
                    <div class="w-100">
                        <div class="table-responsive">
                            <div class="title_section">
                                <h4 class="mb-0">Citas</h4>
                            </div>
                            <div class="content_section d-flex align-content-center">
                                <table border="0"
                                       style="margin: auto">
                                    <tbody>
                                        <tr>
                                            <td>INTERVALO CITAS:</td>
                                            <td>
                                                <select name="intervalo_citas"
                                                        id="intervalo_citas"
                                                        class="form-control"
                                                        data-validation="length"
                                                        data-validation-length="min1"
                                                        data-validation-error-msg="Debe seleccionar intervalo"
                                                        required
                                                        style="width: fit-content;">
                                                    @php
                                                        $intervalos = ['15', '30', '60'];
                                                    @endphp
                                                    @foreach ($intervalos as $intervalo)
                                                        <option value="{{ $intervalo }}"
                                                                {{ (string) $intervalo === (string) $horario['intervalo_citas'] ? 'selected' : '' }}>
                                                            {{ $intervalo }} Minutos
                                                        </option>
                                                    @endforeach                                                    

                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"
                                                style="padding: 50px 10px"
                                                align="center">

                                                <button type="button"
                                                        class="btn btn-warning rounded-pill px-5"
                                                        id="costo_mensual"
                                                        data-toggle="modal"
                                                        data-target="#crearST">Usuarios con acceso</button>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @include('modals.usuariosListaCitas')

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
    <script src="{{ asset('js/dealer.js') }}"></script>
@endsection
