@extends('mecanica.tableCanvas')
@section('titulo', 'Precios Vehiculos Nuevos - Ventas')

@section('pretable-content')
    @php
    $estados = ['1' => 'Activo', '0' => 'Inactivo'];
    @endphp
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">Precios Vehiculos Nuevos</h2>

        <div id="busquedaCollapsable"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRecepcion"
                  class="my-3"
                  method="GET"
                  action="{{ route('precios_nuevo.index') }}"
                  value="search"
                  noLimpiar>
                <div class="flex-wrap d-flex container-fluid justify-content-between">

                    {{-- <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">

                        <label for="filtroEstado"
                               class="col-form-label text-center col-12 col-sm-6">Estado</label>
                        <select name="estado"
                                id="filtroEstado"
                                class="form-control col-12 col-sm-6">

                            <option value="all">Todos</option>
                            @foreach (array_keys($estados) as $estado)
                                <option value="{{ $estado }}">{{ $estados[$estado] }}</option>
                            @endforeach
                        </select>

                    </div> --}}

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">

                        <label for="filtroAplicacion"
                               class="col-form-label text-center col-12 col-sm-6">Marca</label>
                        <select name="marca"
                                id="filtroAplicacion"
                                class="form-control col-12 col-sm-6">
                            <option value="all">Todos</option>
                            <option value="1">NISSAN</option>
                            <option value="2">OTRAS MARCAS</option>
                        </select>

                    </div>

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">
                        <label for="filtroAplicacion"
                               class="col-form-label text-center col-12 col-sm-6">Año Modelo</label>

                        <input name="anho"
                               id="precioIn"
                               value=""
                               type="number"
                               step="any"
                               maxLength="4"
                               class="form-control col-sm-6"
                               data-validation="required"
                               data-validation-error-msg="Debe especificar precio de venta"
                               data-validation-error-msg-container="#errorAnho"
                               placeholder="Ingrese precio de venta"
                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               onblur="this.value = Math.abs(parseFloat(parseFloat(this.value).toFixed(0)))">
                        {{-- <div id="errorAnho"
                             class="col-12 validation-error-cont text-right no-gutters pr-0"></div> --}}
                        {{-- <select name="aplicacion_ventas"
                                id="filtroAplicacion"
                                class="form-control col-12 col-sm-6">
                            <option value="all">Todos</option>
                            @php
                                $ventas = ['SI' => 'Si', 'NO' => 'No'];
                            @endphp

                            @foreach ($ventas as $key => $value)
                                <option value="{{ $key }}">
                                    {{ $value }}</option>
                            @endforeach
                        </select> --}}
                    </div>


                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 justify-content-end mb-0">
                        <a href="{{ route('precios_nuevo.index') }}">
                            <button type="button"
                                    class="btn btn-secondary mr-3 rounded-pill px-3">Quitar filtros</button>
                        </a>
                        <button type="submit"
                                class="btn btn-primary rounded-pill px-3">Buscar</button>
                    </div>

                </div>

            </form>
        </div>

    </div>
@endsection

@section('table-content')

    <script>
        var seccion = 'NUEVOS'
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

    @if ($searching)

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

            <form action="{{ route('precios_nuevo.store') }}"
                  id="formSaveNuevo"
                  method="POST">

                @csrf

                <div class="table-cont-single">
                    <table class="table text-center table-striped table-sm tableTerceros">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">MODELO</th>
                                <th scope="col">VERSIÓN</th>
                                <th scope="col"
                                    class="precio_head">PRECIO DE LISTA</th>
                                <th scope="col"
                                    class="bono_head">BONO</th>
                                <th scope="col"
                                    class="bono_head">BONO CIERRE</th>
                                <th scope="col"
                                    class="bono_head">BONO RETOMA</th>
                                <th scope="col"
                                    class="bono_head">BONO ADICIONAL 1</th>
                                <th scope="col"
                                    class="bono_head">BONO ADICIONAL 2</th>
                                <th scope="col">F. ÚLTIMA EDICIÓN</th>
                                <th scope="col">EDITADO POR</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach ($vehiculos as $vehiculo)
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
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </form>

            <div class="w-100 justify-content-center mt-3 d-flex">
                <div class="section_button"
                     style="width: fit-content">
                    <button type="submit"
                            form="formSaveNuevo"
                            class="btn btn-primary rounded-pill">Guardar</button>
                </div>
            </div>
        </div>
    @endif


@endsection

@section('extra-scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/precios.js') }}"></script>
@endsection
