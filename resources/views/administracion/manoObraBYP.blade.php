@extends('mecanica.tableCanvas')
@section('titulo', 'BYP:Mano de Obra - Administración')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">BYP: Mano de Obra</h2>
    </div>
@endsection

@section('table-content')
    <script>
        var seccion = 'DYP'
        var costo = {!! $costo_exists ? json_encode($costo) : json_encode((object) []) !!}
        var costo_exists = "{!! $costo_exists ? '1' : '0' !!}"

        var precio = {!! $precio_exists ? json_encode($precio) : json_encode((object) []) !!}
        var precio_exists = "{!! $precio_exists ? '1' : '0' !!}"

        var danhos = {!! $danhos->criterios_exists ? json_encode($danhos->criterios) : json_encode((object) []) !!}
        var danhos_exists = "{!! $danhos->criterios_exists ? '1' : '0' !!}"
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
            padding: 4px 8px
        }

        th,
        td {
            border-right: 1px solid rgba(0, 0, 0, 0.068)
        }


        .danho_table th,
        .danho_table td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.068)
        }

        .long {
            padding: 4px 15px
        }

    </style>
    @php
    $col = count($marcas) > 2 ? '12' : '6';
    $monedas = ['SOLES' => 'Soles', 'DOLARES' => 'Dólares'];
    $seccion = 'DYP';
    @endphp

    @include('modals.costoMensualMEC')

    <div class="mx-3"
         style="background: white;padding: 15px;overflow-y:auto;">

        <form id="formCarroceria"
              method="POST"
              action="{{ route('carroceria_mo.store') }}"
              class="form_section">
            @csrf
            <div>
                <div class="table-responsive">
                    <div class="title_section">
                        <h4 class="mb-0">Precios del Servicio</h4>
                    </div>
                    <div class="content_section">

                        <div class="row col-8 sm-8 md-8 lg-8 justify-content-end mt-3"
                             style="height: 30px"></div>

                        <div class="alert alert-danger px-5 w-100 mb-0 glose_sup"
                             role="alert"
                             align="center">
                            <h5 style="font-weight:200; text-transform:uppercase"
                                class="mb-0">Ingresar montos SIN IGV</h5>
                        </div>

                        <div class="row w-100 mx-0 mb-5">
                            <div
                                 class="col-{{ $col }} d-flex mx-0 justify-content-center {{ $col === '6' ? '' : 'mb-5' }}">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="first_column">
                                                <h5
                                                    style="color:#435d7d;font-weight:bold; font-family: Arial, Helvetica, sans-serif">
                                                    VALOR VENTA HH CAR
                                                </h5>
                                            </th>
                                            @foreach ($marcas as $marca)
                                                <th style="font-weight: bold; text-align:center"
                                                    colspan="2">
                                                    {{ $marca->nombre_marca }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($seguros as $seguro)
                                            <tr>
                                                <td class="first_column">{{ $seguro->nombre_cia_seguro }}</td>
                                                @foreach ($marcas as $marca)
                                                    @php
                                                        $unique = $seguro->id_cia_seguro . ':' . $marca->id_marca_auto;
                                                    @endphp
                                                    <td>
                                                        <input id="precio_valor_venta_HH_{{ $unique }}"
                                                               name="precio_valor_venta_HH_{{ $unique }}"
                                                               type="number"
                                                               step="any"
                                                               class="form-control"
                                                               placeholder="Precio"
                                                               style="width: 85px"
                                                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                               value="{{ $precio_exists ? $precio['precio_valor_venta_HH_' . $unique] : '' }}">
                                                    </td>
                                                    <td>
                                                        <select name="moneda_HH_{{ $unique }}"
                                                                id="moneda_HH_{{ $unique }}"
                                                                class="form-control"
                                                                data-validation="length"
                                                                data-validation-length="min1"
                                                                data-validation-error-msg="Debe seleccionar moneda"
                                                                required
                                                                style="width: fit-content;">
                                                            @foreach (array_keys($monedas) as $moneda)
                                                                <option value="{{ $moneda }}"
                                                                        {{ $precio_exists ? ($precio['moneda_HH_' . $unique] === $moneda ? 'selected' : '') : '' }}>
                                                                    {{ $monedas[$moneda] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-{{ $col }} d-flex mx-0 justify-content-center"
                                 style="">

                                <table>
                                    <thead>
                                        <tr>
                                            <th class="first_column">
                                                <h5
                                                    style="color:#435d7d;font-weight:bold; font-family: Arial, Helvetica, sans-serif">
                                                    VALOR VENTA PAÑO
                                                </h5>
                                            </th>
                                            @foreach ($marcas as $marca)
                                                <th style="font-weight: bold; text-align:center"
                                                    colspan="2">
                                                    {{ $marca->nombre_marca }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($seguros as $seguro)
                                            <tr>
                                                <td class="first_column">{{ $seguro->nombre_cia_seguro }}</td>
                                                @foreach ($marcas as $marca)
                                                    @php
                                                        $unique = $seguro->id_cia_seguro . ':' . $marca->id_marca_auto;
                                                    @endphp
                                                    <td>
                                                        <input id="precio_valor_venta_PANHOS_{{ $unique }}"
                                                               name="precio_valor_venta_PANHOS_{{ $unique }}"
                                                               type="number"
                                                               step="any"
                                                               class="form-control"
                                                               placeholder="Precio"
                                                               style="width: 85px"
                                                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                               value="{{ $precio_exists ? $precio['precio_valor_venta_PANHOS_' . $unique] : '' }}">
                                                    </td>
                                                    <td>
                                                        <select name="moneda_PANHOS_{{ $unique }}"
                                                                id="moneda_PANHOS_{{ $unique }}"
                                                                class="form-control"
                                                                data-validation="length"
                                                                data-validation-length="min1"
                                                                data-validation-error-msg="Debe seleccionar moneda"
                                                                required
                                                                style="width: fit-content;">
                                                            @foreach (array_keys($monedas) as $moneda)
                                                                <option value="{{ $moneda }}"
                                                                        {{ $precio_exists ? ($precio['moneda_PANHOS_' . $unique] === $moneda ? 'selected' : '') : '' }}>
                                                                    {{ $monedas[$moneda] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
            </div>


            <div class="mt-4">
                <div class="table-responsive">
                    <div class="title_section">
                        <h4 class="mb-0">Costos Asociados</h4>
                    </div>
                    <div class="content_section">

                        <div class="row w-100 mx-0 mb-5">
                            <div class="form-group row col-3 custom-control custom-switch">
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

                            <div class="form-group row col-3">
                                <button type="button"
                                        class="btn btn-warning rounded-pill px-5"
                                        id="costo_mensual"
                                        data-toggle="modal"
                                        data-target="#crearST">Costo Mensual</button>
                            </div>

                            <div class="form-group row col-3 metodo_costo_in"
                                 style="display: none">

                                <label class="col-form-label pt-0">
                                    METODO DE COSTO:</label>

                                <div class="form-group row custom-control custom-switch ml-5">
                                    <input name="garantia_rechazada"
                                           type="checkbox"
                                           class="custom-control-input metodo_costo"
                                           id="tipoMetodoCosto">
                                    <label class="custom-control-label"
                                           for="tipoMetodoCosto">MONEDA</label>
                                </div>

                            </div>
                        </div>

                        <div class="row w-100 mx-0 mb-5 context_section"
                             style="display: none">
                            <div class="col-6 d-flex mx-0 justify-content-center">

                                <table border="0"
                                       class="table_section"
                                       style="display: none">
                                    <tr>
                                        <td colspan="3"
                                            align="left">
                                            <h5
                                                style="color:#435d7d;font-weight:bold; font-family: Arial, Helvetica, sans-serif">
                                                COSTO POR H-H CARROCERÍA
                                            </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label for="costoHoraHombreCarroceria"
                                                   class="col-form-label">COSTO H-H:</label>
                                        </td>
                                        <td>
                                            <input id="costoHoraHombreCarroceria"
                                                   name="costo_HH"
                                                   type="number"
                                                   step="any"
                                                   class="form-control"
                                                   placeholder="Costo Hora Hombre"
                                                   style="font-size: 25px; text-align: center"
                                                   onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                   value="{{ $costo_exists ? $costo->valor_costo_hh : '' }}">
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch row align-content-center">
                                                <div class="pl-5 in_coin">
                                                    <input name="garantia_rechazada"
                                                           type="checkbox"
                                                           class="custom-control-input moneda_switch"
                                                           id="monedaCostoCarroceria">
                                                    <label class="custom-control-label"
                                                           for="monedaCostoCarroceria">SOLES</label>
                                                </div>
                                                <span class="percentaje"
                                                      style="display: none">%</span>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6 d-flex mx-0 justify-content-center">
                                <table border="0"
                                       class="table_section"
                                       style="display: none">
                                    <tr>
                                        <td colspan="3"
                                            align="left">
                                            <h5
                                                style="color:#435d7d;font-weight:bold; font-family: Arial, Helvetica, sans-serif">
                                                COSTO POR PAÑO DE PINTURA
                                            </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label for="costoPanhoPintura"
                                                   class="col-form-label">COSTO PAÑO:</label>
                                        </td>
                                        <td>
                                            <input id="costoPanhoPintura"
                                                   name="costo_PANHOS"
                                                   type="number"
                                                   step="any"
                                                   class="form-control"
                                                   placeholder="Costo Hora Hombre"
                                                   style="font-size: 25px; text-align: center"
                                                   onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))"
                                                   value="{{ $costo_exists ? $costo->valor_costo_panhos : '' }}">
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch row align-content-center">
                                                <div class="pl-5 in_coin">
                                                    <input name="garantia_rechazada"
                                                           type="checkbox"
                                                           class="custom-control-input moneda_switch"
                                                           id="monedaCostoPanho">
                                                    <label class="custom-control-label"
                                                           for="monedaCostoPanho">SOLES</label>
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
                             style="display:none; position:relative"
                             class="row w-100 mx-0">
                            <div class="row col-8 sm-8 md-8 lg-8 justify-content-end mt-3"
                                 style="height: 50px"></div>

                            <div class="col-6 d-flex mx-0 justify-content-center">
                                <div class="alert alert-danger px-5 w-100 mb-0 glose_inf"
                                     role="alert"
                                     align="center"
                                     style="left:0px">
                                    <h5 style="font-weight:200; text-transform:uppercase"
                                        class="mb-0 glose_cost"></h5>
                                </div>
                            </div>
                            <div class="col-6 d-flex mx-0 justify-content-center">
                                <div class="alert alert-danger px-5 w-100 mb-0 glose_inf"
                                     role="alert"
                                     align="center"
                                     style="rigth:0px">
                                    <h5 style="font-weight:200; text-transform:uppercase"
                                        class="mb-0 glose_panho"></h5>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>


            @php
                $translate = ['HMO' => 'Horas MO', 'PAP' => 'Paños Pintura', 'REP' => "Repuestos $", 'LEV' => 'Leve', 'MED' => 'Medio', 'FUE' => 'Fuerte'];
            @endphp
            <div class="mt-4">
                <div class="table-responsive">
                    <div class="title_section">
                        <h4 class="mb-0">Criterios de Daño</h4>
                    </div>
                    <div class="content_section">

                        <div class="row w-100 mx-0 mb-5">
                            <div class="col-12 d-flex mx-0 justify-content-center">
                                <table class="danho_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            @foreach ($danhos->secciones as $seccion)
                                                <th style="font-weight: bold; text-align:center"
                                                    colspan="2">
                                                    {{ $translate[$seccion] }}
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th class="first_column">
                                                <h5
                                                    style="color:#435d7d;font-weight:bold; font-family: Arial, Helvetica, sans-serif">
                                                    Criterios de Daño
                                                </h5>
                                            </th>
                                            @foreach ($danhos->secciones as $seccion)
                                                @foreach ($danhos->limites as $limite)
                                                    <th style="font-weight: bold; text-align:center">
                                                        {{ ucfirst(strtolower($limite)) }}</th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($danhos->tipos as $tipo)
                                            <tr>
                                                <td class="first_column">{{ $translate[$tipo] }}</td>

                                                @foreach ($danhos->secciones as $seccion)
                                                    @foreach ($danhos->limites as $limite)
                                                        <td align="center"
                                                            style="width: 150px; height: 40px">
                                                            @php
                                                                $criterios_exists = $danhos->criterios_exists;
                                                                
                                                                $criterio = $danhos->criterios[$seccion][$tipo][$limite];
                                                                $before = $seccion === 'REP' ? '$' : '';
                                                                if (!is_null($criterio->before)) {
                                                                    $before = $criterio->before . ' ' . $before;
                                                                }
                                                                $unique = $criterio->id_criterio;
                                                                $editable = $criterio->editable;
                                                                
                                                            @endphp
                                                            <div
                                                                 class="row w-100 justify-content-center align-items-center">
                                                                <span>{{ $before }}&nbsp;</span>
                                                                @if ($editable === 1)
                                                                    <input id="CRI_{{ $unique }}"
                                                                           name="CRI_{{ $seccion . '_' . $tipo . '_' . $limite . '_' . $unique }}"
                                                                           type="number"
                                                                           step="any"
                                                                           class="form-control"
                                                                           placeholder=""
                                                                           style="width: 85px"
                                                                           value="{{ $criterio->valor }}"
                                                                           onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))">
                                                                @else
                                                                    <span>
                                                                        {{ $criterio->valor }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <div class="row w-100 justify-content-end mt-3">
            <div class="section_button">
                <button type="submit"
                        form="formCarroceria"
                        class="btn btn-primary rounded-pill">Guardar</button>
            </div>
        </div>
    </div>
@endsection


@section('extra-scripts')
    @parent
    <script src="{{ asset('js/mo.js') }}"></script>
@endsection
