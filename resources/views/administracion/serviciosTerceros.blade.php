@extends('mecanica.tableCanvas')
@section('titulo', 'Servicios Terceros - Administración')

@section('pretable-content')
    @php
    $estados = ['1' => 'Activo', '0' => 'Inactivo'];
    @endphp
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">Administración de Servicios Terceros</h2>

        <div id="busquedaCollapsable"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRecepcion"
                  class="my-3"
                  method="GET"
                  action="{{ route('administracion.serviciosTerceros.index') }}"
                  value="search"
                  noLimpiar>
                <div class="flex-wrap d-flex container-fluid justify-content-between">

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">

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

                    </div>

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">

                        <label for="filtroAplicacion"
                               class="col-form-label text-center col-12 col-sm-6">Aplicacion Marca</label>
                        <select name="marca"
                                id="filtroAplicacion"
                                class="form-control col-12 col-sm-6">
                            <option value="all">Todos</option>
                            <option value="1">NISSAN</option>
                            <option value="2">OTRAS MARCAS</option>
                        </select>

                    </div>


                    {{-- <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">
                        <label for="filtroResponsable"
                               class="col-form-label text-center col-12 col-sm-6">Responsable Creación</label>
                        <select name="responsable"
                                id="filtroResponsable"
                                class="form-control col-12 col-sm-6">
                            <option value="all"
                                    data-marca="0">Todos</option>

                            @foreach ($responsables as $responsable)
                                <option value="{{ $responsable->id_usuario }}">
                                    {{ strtoupper($responsable->username) }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 mb-0">
                        <label for="filtroAplicacion"
                               class="col-form-label text-center col-12 col-sm-6">Aplicación Ventas</label>
                        <select name="aplicacion_ventas"
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
                        </select>
                    </div>


                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3 justify-content-end mb-0">
                        <a href="{{ route('administracion.serviciosTerceros.index') }}">
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

    </style>

    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">

        <div class="row col-12 d-flex px-0 my-3"
             style="justify-content:flex-end">
            @include('modals.crearServicioTercero')

        </div>

        <div class="table-cont-single">
            <table class="table text-center table-striped table-sm tableTerceros">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">CODIGO</th>
                        <th scope="col">DESCRIPCION</th>

                        {{-- <th scope="col">FECHA CREACION</th>
                        <th scope="col">CREADO POR</th> --}}

                        <th scope="col">PRECIO</th>
                        <th scope="col">MONEDA</th>
                        <th scope="col"
                            style="padding:0px">
                            <div class="column">
                                <div><span class="head_th">APLICACIÓN MARCAS</span></div>
                                <div class="row gray align-items-center">
                                    @foreach ($marcas as $marca)
                                        <span class="sub_th">{{ $marca->nombre_marca }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </th>
                        <th scope="col">ACCESORIO VENTAS</th>
                        <th scope="col">DETALLE</th>
                        <th scope="col">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $monedas = ['SOLES' => 'Soles', 'DOLARES' => 'Dolares'];
                    @endphp

                    @foreach ($listaServiciosTerceros as $servicioTercero)
                        <tr id="tdServicioTercero-{{ $servicioTercero->id_servicio_tercero }}">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <th>
                                @if ($servicioTercero->estado == 1)
                                    <span class="badge badge-success">ACTIVO</span>
                                @else
                                    <span class="badge badge-danger">INACTIVO</span>
                                @endif
                            </th>
                            <td>{{ $servicioTercero->codigo_servicio_tercero }}</td>
                            <td>{{ \Helper::cutString(25, $servicioTercero->descripcion) }}</td>
                            {{-- <td>{{ $servicioTercero->getFechaCreacion() }}</td> --}}
                            {{-- <td>{{ $servicioTercero->creador() }}</td> --}}
                            <td>
                                @if ($servicioTercero->pvp)
                                    {{ App\Helper\Helper::obtenerUnidadMonedaCambiar($servicioTercero->moneda) }}
                                    {{ $servicioTercero->pvp }}@else - @endif
                            </td>
                            <td>{{ $servicioTercero->moneda }}</td>

                            <td>
                                @php
                                    $marks = $servicioTercero->marcas;
                                    if (!is_null($marks)) {
                                        $marks = json_decode($servicioTercero->marcas, true);
                                    } else {
                                        $marks = [];
                                        foreach ($marcas as $marca) {
                                            $id = $marca->id_marca_auto;
                                            $tarr = ["M$id" => '0'];
                                            $marks += $tarr;
                                        }
                                    }
                                @endphp
                                <div class="row white">
                                    @foreach (array_keys($marks) as $mark)
                                        <span class="sub_norm">{{ $marks[$mark] === '0' ? 'NO' : 'SI' }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ $servicioTercero->aplicacion_ventas === 1 ? 'SI' : 'NO' }}</td>
                            {{-- <td>{{ $servicioTercero->aplicacion_ventas }}</td> --}}
                            <td>
                                @include('modals.detalleServicioTercero')
                            </td>
                            <td>
                                @if ($servicioTercero->serviciosTercerosSolicitados->count() < 1)
                                    <form method="DELETE"
                                          id="deleteSTD-{{ $servicioTercero->id_servicio_tercero }}"
                                          action="{{ route('admin.destroy.servicioTerceros', ['id' => $servicioTercero]) }}">

                                        @csrf
                                        <button type="submit"
                                                class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    <input type="hidden"
           id="_token"
           value="{{ csrf_token() }}">
@endsection

@section('extra-scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/adm_serviciosTerceros.js') }}"></script>
@endsection
