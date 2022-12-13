@extends('mecanica.tableCanvas')
@section('titulo', 'Modulo de recepción - MECANICA')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-4">OTs - Mecánica</h2>
        <div id="busquedaCollapsable"
             class="col-12 collapse borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRecepcion"
                  class="my-3"
                  method="GET"
                  action="{{ route('mecanica.recepcion.index') }}"
                  value="search">
                <div class="row">
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <label for="filtroNroDoc"
                               class="col-form-label col-12 col-sm-6">Nº DOCUMENTO</label>
                        <input id="filtroNroDoc"
                               name="nroDoc"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de documento"
                               value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}">
                    </div>
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <label for="filtroPlaca"
                               class="col-form-label col-12 col-sm-6">Placa</label>
                        <input id="filtroPlaca"
                               name="nroPlaca"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de placa"
                               value="{{ isset(request()->nroPlaca) ? request()->nroPlaca : '' }}"
                               oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <label for="filtroOT"
                               class="col-form-label col-12 col-sm-6">OT</label>
                        <input id="filtroOT"
                               name="nroOT"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Órden de Trabajo"
                               value="{{ isset(request()->nroOT) ? request()->nroOT : '' }}">
                    </div>
                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                        <label for="filtroEstado"
                               class="col-form-label col-6">Estado</label>
                        <select id="filtroEstado"
                                name="estado"
                                class="form-control col-6">
                            <option value="all">Todos</option>
                            @foreach ($listaEstados as $estado)
                                <option value="{{ $estado->nombre_estado_reparacion_filtro }}"
                                        {{ isset(request()->estado) && request()->estado == $estado->nombre_estado_reparacion_filtro ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado_reparacion_filtro }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                        <label for="filtroMarca"
                               class="col-form-label col-6">Marca</label>
                        <select name="marca"
                                id="filtroMarca"
                                class="form-control col-6">
                            <option value="all">Todos</option>
                            @foreach ($listaMarcas as $marca)
                                <option value="{{ $marca->getIdMarcaAuto() }}"
                                        {{ isset(request()->marca) && request()->marca == $marca->getIdMarcaAuto() ? 'selected' : '' }}>
                                    {{ $marca->getNombreMarca() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3 
                                    {{ isset(request()->marca) ? (request()->marca == 'all' || request()->marca == '1' ? 'block' : 'none') : 'block' }}"
                         id="modelo_select">
                        <label for="filtroModelo"
                               class="col-form-label col-6">Modelo</label>
                        <select name="modelo"
                                id="filtroModelo"
                                class="form-control col-6">
                            <option value="-"
                                    data-marca="0">-</option>
                            @foreach ($listaModelos as $modelo)
                                <option value="{{ $modelo->id_modelo }}"
                                        data-marca="{{ $modelo->id_marca_auto }}"
                                        {{ isset(request()->modelo) && request()->modelo == $modelo->id_modelo ? 'selected' : '' }}>
                                    {{ $modelo->nombre_modelo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3 {{ isset(request()->marca) ? (request()->marca == 'all' || request()->marca == '1' ? 'none' : 'block') : 'none' }}" id="modelo_text">
                        <label for="filtroModeloOtro"
                               class="col-form-label col-12 col-sm-6">Modelo</label>
                        <input id="filtroModeloOtro"
                               name="nombre_modelo"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Modelo"
                               value="{{ isset(request()->nombre_modelo) ? request()->nombre_modelo : '' }}">
                    </div>

                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                        <label for="filtroVin"
                               class="col-form-label col-12 col-sm-6">VIN</label>
                        <input id="filtroVin"
                               name="vin_code"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="VIN"
                               maxlength="17"
                               value="{{ isset(request()->vin_code) ? request()->vin_code : '' }}">
                    </div>


                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                        <label for="filtroAsesor"
                               class="col-form-label col-6">Asesor de Servicios</label>
                        <select name="asesor"
                                id="filtroAsesor"
                                class="form-control col-6">
                            <option value="all">Todos</option>
                            @foreach ($listaAsesores as $empleado)
                                <option value="{{ $empleado->dni }}"
                                        {{ isset(request()->asesor) && request()->asesor == $empleado->dni ? 'selected' : '' }}>
                                    {{ $empleado->nombreCompleto() }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (in_array(Auth::user()->id_rol, [1, 6]))
                    @endif


                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                        <label for="filtroTipoOT"
                               class="col-form-label col-6">Tipo de OT</label>
                        <select name="filtroTipoOT"
                                id="filtroTipoOT"
                                class="form-control col-6">
                            <option value="all">Todos</option>
                            @foreach ($listaTiposOT as $tipoOT)
                                <option value="{{ $tipoOT->id_tipo_ot }}"
                                        {{ isset(request()->filtroTipoOT) && request()->filtroTipoOT == $tipoOT->id_tipo_ot ? 'selected' : '' }}>
                                    {{ $tipoOT->nombre_tipo_ot }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                        <label for="filtroAsesor"
                               class="col-form-label col-6">Asesor de Servicios</label>
                        <select name="filtroAsesor"
                                id="filtroAsesor"
                                class="form-control col-6">
                            <option value="all">Todos</option>
                            @foreach ($listaTiposOT as $tipoOT)
                                <option value="{{ $tipoOT->id_tipo_ot }}"
                                        {{ isset(request()->filtroAsesor) && request()->filtroAsesor == $tipoOT->id_tipo_ot ? 'selected' : '' }}>
                                    {{ $tipoOT->nombre_tipo_ot }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-12">
                    <div class="row justify-content-end">
                        <button type="submit"
                                class="btn btn-primary ">Buscar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('table-content')
    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12">
                        <div>
                            <h2>Seguimiento de OTs</h2>
                        </div>

                        <button class="btn btn-primary"
                                type="button"
                                data-toggle="collapse"
                                data-target="#busquedaCollapsable"
                                aria-expanded="false"
                                aria-controls="busquedaCollapsable">
                            Filtrar
                        </button>
                    </div>
                </div>
                <div class="table-cont-single">
                    <table class="table text-center table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ESTADO</th>
                                @if (false)
                                    <th scope="col">TIPO DAÑO</th>
                                @endif
                                <th scope="col">F. INGRESO</th>
                                <th scope="col">DÍAS ESTANCIA</th>
                                <th scope="col">PLACA</th>
                                <th scope="col">OT</th>
                                <th scope="col">TIPO OT</th>
                                <th scope="col">ASESOR DE SERVICIO</th>
                                <th scope="col">MARCA</th>
                                <th scope="col">MODELO</th>
                                <th scope="col">F. PROMESA</th>
                                <th>DETALLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($listaRecepcionesOTs) > 0)
                                @foreach ($listaRecepcionesOTs as $recepcion_ot)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <div class="cont-estado {{ $recepcion_ot->claseEstado() }}">
                                                @if ($recepcion_ot->estadoActual() != [])
                                                    {{ $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion }}
                                                @else
                                                    -
                                                @endif
                                            </div>

                                            {{-- @if ($recepcion_ot->estadoActual() != [])
                                                <div class="cont-estado {{ $recepcion_ot->status_clase($recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno) }}">
                                                    {{ $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion }}
                                                </div>
                                            @else
                                                <div class="cont-estado">
                                                    -
                                                </div>
                                            @endif --}}

                                        </td>
                                        @if (false)
                                            <td>
                                                <div class="{{ $recepcion_ot->claseCSSTipoDanhoTemp() }}">
                                                    {{ $recepcion_ot->tipoDanhoTemp() }}</div>
                                            </td>
                                        @endif
                                        <td>{{ $recepcion_ot->hojaTrabajo->getFechaRecepcionFormat() }}</td>
                                        <td>{{ $recepcion_ot->tiempoEstancia() }}</td>
                                        <td class="@if (false) {{ $recepcion_ot->estiloEsHotline() }} @endif">
                                            {{ substr($recepcion_ot->hojaTrabajo->placa_auto, 0, 3) . '-' . substr($recepcion_ot->hojaTrabajo->placa_auto, 3, 3) }}
                                        </td>
                                        <td>{!! $recepcion_ot->getLinkDetalleHTML() !!}</td>
                                        <td>{{ $recepcion_ot->getNombreTipoOT() }}</td>
                                        <td>{{ $recepcion_ot->hojaTrabajo->empleado->nombreCompleto() }}</td>
                                        @if ($recepcion_ot->hojaTrabajo->vehiculo != null)
                                            <td>{{ $recepcion_ot->hojaTrabajo->vehiculo->getNombreMarca() }} </td>
                                        @else
                                            <td>-</td>
                                        @endIf


                                        <td>{{ substr($recepcion_ot->hojaTrabajo->getModeloVehiculo(), 0, 15) }}</td>
                                        <td>
                                            {{ $recepcion_ot->fechaPromesa() == '-' ? '-' : \Carbon\Carbon::parse($recepcion_ot->fechaPromesa())->format('d/m/Y') }}
                                        </td>
                                        <td><a
                                               href="{{ route('mecanica.detalle_trabajos.index', ['id_recepcion_ot' => $recepcion_ot->id_recepcion_ot]) }}"><button
                                                        type="button"
                                                        class="btn btn-warning"><i
                                                       class="fas fa-info-circle icono-btn-tabla"></i>
                                                    </i></button></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11">No hay registros que mostrar</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/recepcion.js') }}"></script>
    <script src="{{ asset('js/marca.js') }}"></script>
@endsection
