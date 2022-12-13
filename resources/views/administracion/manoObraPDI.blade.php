@extends('mecanica.tableCanvas')
@section('titulo', 'PDI:Mano de Obra - Administración')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">PDI: Mano de Obra</h2>
    </div>
@endsection

@section('table-content')
    <script>
        var seccion = 'PDI'
        var precio = {!! $precio ? json_encode($precio) : json_encode((object) []) !!}
        var tipes = {!! json_encode($tipos) !!}
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
    $translate = ['MEC' => 'Precio Hora Mecánica PDI', 'CAR' => 'Precio Hora Carrocería PDI', 'PANHO' => 'Precio Paño Pintura PDI', 'TYP' => 'TYP'];

    @endphp

    <div class="mx-3"
         style="background: white;padding: 15px;overflow-y:auto;">

        <form id="formPrecioPDI"
              method="POST"
              action="{{ route('pdi_mo.store') }}"
              class="form_section">

            @csrf

            <div>
                <div class="table-responsive">
                    <div class="title_section">
                        <h4 class="mb-0">Precios PDI</h4>
                    </div>
                    <div class="content_section">
                        <div class="form_section">

                            <div class="row justify-content-center w-100">
                                <table border="0"
                                       class="w-40">
                                    @foreach ($tipos as $tipo)
                                        <tr>
                                            <td>
                                                <div class="row w-100">
                                                    <label for="precio_{{ $tipo }}"
                                                           class="col-form-label text-center col-sm-6 col-lg-6">
                                                        {{ $translate[$tipo] }}:
                                                    </label>
                                                    <input id="precio_{{ $tipo }}"
                                                           name="valor_costo_{{ $tipo }}"
                                                           type="number"
                                                           step="any"
                                                           class="form-control col-sm-6 col-lg-6"
                                                           placeholder="{{ $translate[$tipo] }}"
                                                           style="font-size: 25px; text-align: center"
                                                           value="{{ $precio->$tipo['existe'] ? $precio->$tipo['data']->valor_costo : '' }}"
                                                           onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                           required
                                                           data-validation="required">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <div style="position:relative;"
                                                         class="justify-content-center align-content-center">
                                                        <input type="checkbox"
                                                               class="custom-control-input moneda_switch"
                                                               id="monedaPrecio_{{ $tipo }}"
                                                               {{ $precio->$tipo['existe'] ? ($precio->$tipo['data']->moneda === 'DOLARES' ? 'checked' : '') : '' }}>
                                                        <label class="custom-control-label"
                                                               for="monedaPrecio_{{ $tipo }}">{{ $precio->$tipo['existe'] ? $precio->$tipo['data']->moneda : 'SOLES' }}</label>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
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

                    </div>
                </div>
            </div>
        </form>


        <div class="row w-100 justify-content-end mt-3">
            <div class="section_button">
                <button type="submit"
                        form="formPrecioPDI"
                        class="btn btn-primary rounded-pill">Guardar</button>
            </div>
        </div>

    </div>

@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/mo.js') }}"></script>
@endsection
