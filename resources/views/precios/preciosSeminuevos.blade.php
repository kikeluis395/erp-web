@extends('mecanica.tableCanvas')
@section('titulo', 'Precios Vehiculos Seminuevos - Ventas')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">Precios Vehiculos Seminuevos</h2>
    </div>
@endsection

@section('table-content')

    <script>
        var seccion = 'SEMINUEVOS'
        var vehiculos = {!! $vehiculos ? json_encode($vehiculos) : json_encode((object) []) !!}
        var precios = {!! $precios ? json_encode($precios) : json_encode((object) []) !!}
    </script>

    <style>
        .head_th {
            font-size: 12px;
        }

        .sub_th {
            font-size: 14px;
            font-weight: 100;
        }

        .sub_norm,
        .sub_th {
            margin: 0px 15px;
            text-align: center;
            width: 80px;
        }

        .gray,
        .white {
            padding: 5px 0px;
            display: flex;
            place-content: center;
        }

        .gray {
            background-color: rgb(146, 146, 146);

        }

        .section_button button {
            padding: 10px 50px;
            /* border-radius: 10px; */
            text-transform: uppercase;
            font-size: 18px
        }

        .precio_head {
            background-color: #af9763 !important;
        }

        .precio {
            background-color: #fff5e9
        }

        .bono_head {
            background-color: #79a08c !important
        }

        .bono {
            background-color: #ecfbec
        }

    </style>

    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">

        <div class="col-12 d-flex px-0 my-3"
             style="justify-content:flex-start">

            <div class="alert alert-danger px-5 mb-0"
                 role="alert"
                 align="center">
                <h5 style="font-weight:200; text-transform:uppercase"
                    class="mb-0 glose_cost">Montos en dólares e incluyen IGV</h5>
            </div>

        </div>

        <form action="{{ route('precios_seminuevo.store') }}"
              id="formSaveSeminuevo"
              method="POST">

            @csrf

            <div class="table-cont-single">
                <table class="table text-center table-striped table-sm tableTerceros">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">FECHA DE INGRESO</th>
                            <th scope="col">DÍAS EN STOCK</th>
                            <th scope="col">MARCA</th>
                            <th scope="col">MODELO</th>
                            <th scope="col">VERSIÓN</th>
                            <th scope="col"
                                class="precio_head">PRECIO DE LISTA</th>
                            <th scope="col">F. ÚLTIMA EDICIÓN</th>
                            <th scope="col">EDITADO POR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $vehiculo)

                            @php
                                $unique = $vehiculo->id_vehiculo_seminuevo;
                                $existe = $precios["V$unique"]['existe'];
                                $data = null;
                                if ($existe) {
                                    $data = $precios["V$unique"]['precio'];
                                }
                                // $inputs = ['precio', 'bono', 'bono_cierre', 'bono_retoma', 'bono_adicional_1', 'bono_adicional_2'];
                                $class = ['precio' => 'precio', 'bono' => 'bono'];
                            @endphp
                            <tr>

                                <input type="hidden"
                                       value="{{ $existe ? '1' : '0' }}"
                                       name="existe_V{{ $unique }}">
                                @if ($existe)
                                    <input type="hidden"
                                           value="{{ $data->id_vehiculo_seminuevo }}"
                                           name="id_V{{ $unique }}">
                                @endif

                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>{{ $vehiculo->modelo }}</td>
                                <td>{{ $vehiculo->version }}</td>
                                <td class="{{ $class["precio"] }}">
                                    <div class="d-flex row justify-content-center">
                                        <input name="precio_V{{ $unique }}"
                                               id="precio_V{{ $unique }}"
                                               type="number"
                                               step="any"
                                               maxLength="9"
                                               class="form-control col-sm-6"
                                               autocomplete="off"
                                               value="{{ $existe ? $data->precio : '' }}"
                                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))">
                                    </div>
                                </td>
                                <td>{{ $existe ? $data->prior_fecha() : '' }}</td>
                                <td>{{ $existe ? $data->prior_usuario() : '' }}</td>

                            </tr>
                        @endforeach

                        {{-- @foreach ($vehiculos as $vehiculo)
                            @php
                                $unique = $vehiculo->id_vehiculo_nuevo;
                                $existe = $precios["V$unique"]['existe'];
                                $data = null;
                                if ($existe) {
                                    $data = $precios["V$unique"]['precio'];
                                }
                                $inputs = ['precio', 'bono', 'bono_cierre', 'bono_retoma', 'bono_adicional_1', 'bono_adicional_2'];
                                $class = ['precio' => 'precio', 'bono' => 'bono', 'bono_cierre' => 'bono', 'bono_retoma' => 'bono', 'bono_adicional_1' => 'bono', 'bono_adicional_2' => 'bono'];
                            @endphp

                            <tr>
                                <input type="hidden"
                                       value="{{ $existe ? '1' : '0' }}"
                                       name="existe_V{{ $unique }}">
                                @if ($existe)
                                    <input type="hidden"
                                           value="{{ $data->id_precio_vehiculo_nuevo }}"
                                           name="id_V{{ $unique }}">
                                @endif

                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $vehiculo->modelo }}</td>
                                <td>{{ $vehiculo->version }}</td>
                                @foreach ($inputs as $input)
                                    <td class="{{ $class[$input] }}">
                                        <div class="d-flex row justify-content-center">
                                            <input name="{{ $input }}_V{{ $unique }}"
                                                   id="{{ $input }}_V{{ $unique }}"
                                                   type="number"
                                                   step="any"
                                                   maxLength="9"
                                                   class="form-control col-sm-6"
                                                   autocomplete="off"
                                                   value="{{ $existe ? $data->$input : '' }}"
                                                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                   onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(2)))">
                                        </div>

                                    </td>
                                @endforeach
                                <td>{{ $existe ? $data->prior_fecha() : '' }}</td>
                                <td>{{ $existe ? $data->prior_usuario() : '' }}</td>
                            </tr>
                        @endforeach --}}

                    </tbody>
                </table>
            </div>

        </form>

        <div class="w-100 justify-content-center mt-3 d-flex">
            <div class="section_button"
                 style="width: fit-content">
                <button type="submit"
                        form="formSaveSeminuevo"
                        class="btn btn-primary rounded-pill">Guardar</button>
            </div>
        </div>
    </div>



@endsection

@section('extra-scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/precios.js') }}"></script>
@endsection
