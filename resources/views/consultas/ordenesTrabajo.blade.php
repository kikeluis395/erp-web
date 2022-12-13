@extends('mecanica.tableCanvas')
@section('titulo', 'Consultas - Órdenes de Trabajo')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <div class="row justify-content-between col-12">
            <h2>Consulta - Órdenes de Trabajo</h2>
        </div>
        <div id="busquedaForm"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRecepcion"
                  class="my-3"
                  method="GET"
                  action="{{ route('consultas.ordenesTrabajo') }}"
                  value="search">
                <div class="row">
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <label for="filtroNroDoc"
                               class="col-form-label col-12 col-sm-6">N° DOCUMENTO</label>
                        <input id="filtroNroDoc"
                               name="nroDoc"
                               type="number"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de documento"
                               maxlength="11"
                               value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}">
                    </div>
                    <div class="form-group row col-6 col-sm-3">
                        <label for="filtroPlaca"
                               class="col-form-label col-12 col-sm-6">Placa</label>
                        <input id="filtroPlaca"
                               name="nroPlaca"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de placa"
                               maxlength="6"
                               oninput="this.value = this.value.toUpperCase()"
                               value="{{ isset(request()->nroPlaca) ? request()->nroPlaca : '' }}">
                    </div>

                    <div class="form-group row col-6 col-sm-3">
                        <label for="filtroVIN"
                               class="col-form-label col-12 col-sm-6">VIN</label>
                        <input id="filtroVIN"
                               name="nroVIN"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número VIN"
                               maxlength="17"
                               value="{{ isset(request()->nroVIN) ? request()->nroVIN : '' }}">
                    </div>




                    <div class="form-group row col-12 ml-sm-0 col-sm-6 col-md-3">
                        <label for="filtroMarca"
                               class="col-form-label col-6 col-lg-5">Marca</label>
                        <select name="marca"
                                id="filtroMarca"
                                class="form-control col-6 col-lg-7">
                            <option value="all">Todos</option>
                            @foreach ($listaMarcas as $marca)
                                <option value="{{ $marca->getIdMarcaAuto() }}"
                                        {{ isset(request()->marca) && request()->marca == $marca->getIdMarcaAuto() ? 'selected' : '' }}>
                                    {{ $marca->getNombreMarca() }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (in_array(Auth::user()->id_rol, [1, 6]))
                        <div class="form-group row col-12 ml-sm-0 col-sm-6 col-md-3">
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
                    @endif

                    <div class="form-group row col-12 ml-sm-0 col-sm-6 col-md-3">
                        <label for="filtroLocal"
                               class="col-form-label col-6 col-lg-5">Local</label>
                        <select name="local"
                                id="filtroLocal"
                                class="form-control col-6 col-lg-7">
                            <option value="all">Todos</option>
                            @foreach ($listaLocales as $local)
                                <option value="{{ $local->id_local }}"
                                        {{ isset(request()->local) && request()->local == $local->id_local ? 'selected' : '' }}>
                                    {{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row col-6 col-md-3">
                        <label for="filtroOT"
                               class="col-form-label col-12 col-sm-4 col-lg-6">OT</label>
                        <input id="filtroOT"
                               name="nroOT"
                               type="text"
                               class="form-control col-12 col-sm-6 col-lg-6"
                               placeholder="Órden de Trabajo"
                               value="{{ isset(request()->nroOT) ? request()->nroOT : '' }}">
                    </div>

                    <div class="form-group row col-12 ml-sm-0 col-sm-6 col-md-3">
                        <label for="filtroSeccion"
                               class="col-form-label col-6 col-lg-5">Sección</label>
                        <select name="seccion"
                                id="filtroSeccion"
                                class="form-control col-6 col-lg-7">
                            <option value="all">Todos</option>
                            <option value="MEC"
                                    {{ isset(request()->seccion) && request()->seccion == 'MEC' ? 'selected' : '' }}>
                                Mecánica</option>
                            <option value="DYP"
                                    {{ isset(request()->seccion) && request()->seccion == 'DYP' ? 'selected' : '' }}>
                                Carrocería y Pintura</option>
                        </select>
                    </div>

                    <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
                        <label for="filtroEstadoOT"
                               class="col-form-label col-6 col-lg-5">Estado OT</label>
                        <select name="estadoOT"
                                id="filtroSeguro"
                                class="form-control col-6 col-lg-7">
                            <option value="all">Todos</option>
                            <option value="abiertas"
                                    {{ isset(request()->estadoOT) && request()->estadoOT == 'abiertas' ? 'selected' : '' }}>
                                Abiertas</option>
                            <option value="cerradas"
                                    {{ isset(request()->estadoOT) && request()->estadoOT == 'cerradas' ? 'selected' : '' }}>
                                Cerradas</option>
                            <option value="facturadas"
                                    {{ isset(request()->estadoOT) && request()->estadoOT == 'facturadas' ? 'selected' : '' }}>
                                Facturadas
                            </option>
                        </select>
                    </div>

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


                    <div class="form-group row ml-1 col-12 col-sm-6 pr-sm-0 col-lg-6">
                        <label for="filtroFechaIngreso"
                               class="col-form-label col-12 col-sm-4 col-lg-5">Rango F. Ingreso</label>
                        <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
                            <input id="filtroFechaIngresoInicio"
                                   name="fechaInicioIngreso"
                                   type="text"
                                   autocomplete="off"
                                   class="fecha-inicio form-control col-6"
                                   placeholder="Fecha inicio"
                                   value="{{ isset(request()->fechaInicioIngreso) ? request()->fechaInicioIngreso : '' }}">
                            -
                            <input id="filtroFechaIngresoFin"
                                   name="fechaFinIngreso"
                                   type="text"
                                   autocomplete="off"
                                   class="fecha-fin form-control col-5"
                                   placeholder="Fecha fin"
                                   value="{{ isset(request()->fechaFinIngreso) ? request()->fechaFinIngreso : '' }}">
                        </div>
                    </div>

                    <div class="form-group row ml-1 col-12 col-sm-6 pr-sm-0 col-lg-6">
                        <label for="filtroFechaEntrega"
                               class="col-form-label col-12 col-sm-4 col-lg-5">Rango F. Facturación</label>
                        <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
                            <input id="filtroFechaEntregaInicio"
                                   name="fechaInicioEntrega"
                                   type="text"
                                   autocomplete="off"
                                   class="fecha-inicio form-control col-6"
                                   placeholder="Fecha inicio"
                                   value="{{ isset(request()->fechaInicioEntrega) ? request()->fechaInicioEntrega : '' }}">
                            -
                            <input id="filtroFechaEntregaFin"
                                   name="fechaFinEntrega"
                                   type="text"
                                   autocomplete="off"
                                   class="fecha-fin form-control col-5"
                                   placeholder="Fecha fin"
                                   value="{{ isset(request()->fechaFinEntrega) ? request()->fechaFinEntrega : '' }}">
                        </div>
                    </div>

                    <div class="form-group row ml-1 col-12 col-sm-6 pr-sm-0 col-lg-6">
                        <label for="filtroFechaCierre"
                               class="col-form-label col-12 col-sm-4 col-lg-5">Rango F. Cierre</label>
                        <div class="row col-12 col-sm-8 col-lg-7 pl-0 justify-content-end">
                            <input id="filtroFechaCierreInicio"
                                   name="fechaCierreInicio"
                                   type="text"
                                   autocomplete="off"
                                   class="fecha-inicio form-control col-6"
                                   placeholder="Fecha inicio"
                                   value="{{ isset(request()->fechaCierreInicio) ? request()->fechaCierreInicio : '' }}">
                            -
                            <input id="filtroFechaCierreFin"
                                   name="fechaCierreFin"
                                   type="text"
                                   autocomplete="off"
                                   class="fecha-fin form-control col-5"
                                   placeholder="Fecha fin"
                                   value="{{ isset(request()->fechaCierreFin) ? request()->fechaCierreFin : '' }}">
                        </div>
                    </div>



                </div>
                <div class="row justify-content-end mb-3">
                    <a href="{{ route('consultas.ordenesTrabajo') }}"
                       class="btn btn-secondary mr-3">Quitar filtros</a>
                    <button type="submit"
                            class="btn btn-primary mr-3">Buscar</button>
                    <!-- <button class="btn btn-primary ml-3">Limpiar</button> -->
                </div>
            </form>
        </div>

    </div>
@endsection

@section('table-content')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css" />

    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        @if ($listaOrdenesTrabajo->count())
            <div class="table-responsive borde-tabla tableFixHead">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row col-12 align-items-center">
                            <div>
                                <h2 class="mt-0">Órdenes de Trabajo</h2>
                            </div>

                            @if ($listaOrdenesTrabajo->count())
                                <a href="{{ route('consultas.ordenesTrabajo.exportExcel', $request) }}"><button
                                            class="btn btn-success px-3 py-2 rounded-pill">Exportar&nbsp;<i class="fas fa-file-excel"></i></button></a>
                            @endif
                        </div>
                    </div>

                    <div class="table-cont-single">
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">SECCIÓN</th>
                                    <th scope="col">TIPO OT</th>
                                    <th scope="col">N° OT</th>
                                    <th scope="col">ESTADO</th>
                                    <th scope="col">PLACA</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">MARCA</th>
                                    <th scope="col">MODELO</th>
                                    <th scope="col">FECHA INGRESO</th>
                                    <th scope="col">FECHA ENTREGA</th>
                                    <th scope="col">FECHA CIERRE</th>
                                    <th scope="col">DNI/RUC</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">ASESOR</th>
                                    <th scope="col">TRABAJO</th>
                                    <th scope="col">$ VENTA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listaOrdenesTrabajo as $ordenTrabajo)
                                    <tr>
                                        <th style="vertical-align: middle"
                                            scope="row">{{ $loop->iteration }}</th>
                                        <td style="vertical-align: middle">{{ $ordenTrabajo->seccion() }}</td>
                                        <td style="vertical-align: middle">{{ $ordenTrabajo->tipoOT->nombre_tipo_ot }}
                                        </td>
                                        <td style="vertical-align: middle">{!! $ordenTrabajo->getLinkDetalleHTML() !!}</td>
                                        <td style="vertical-align: middle">{{ $ordenTrabajo->getEstadoTrabajo() }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->getPlacaAutoFormat() }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->vehiculo->vin }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->vehiculo->getNombreMarca() }}</td>
                                        <td style="vertical-align: middle">
                                            {{ substr($ordenTrabajo->hojaTrabajo->getModeloVehiculo(), 0, 30) }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->getFechaRecepcionFormat() }}</td>
                                        <td style="vertical-align: middle">{{ $ordenTrabajo->fechaEntregadoFormat() }}
                                        </td>
                                        <td style="vertical-align: middle">{{ $ordenTrabajo->fechaCierreFormat() }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->getNumDocCliente() }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->getNombreCliente() }}</td>
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->empleado->nombreCompleto() }}</td>
                                        @if (false)
                                            <td style="vertical-align: middle">
                                                {{ $ordenTrabajo->localEmpresa->nombre_local }}</td>
                                        @endif
                                        <td style="vertical-align: middle">
                                            {{ $ordenTrabajo->hojaTrabajo->getPrimerTrabajoPreventivoOptional() }}
                                        </td>
                                        @if (true || $ordenTrabajo->fechaEntregadoFormat() != '-')
                                            <td style="vertical-align: middle">
                                                {{-- {{ App\Helper\Helper::obtenerUnidadMoneda($ordenTrabajo->hojaTrabajo->moneda) }} --}}
                                                {{-- {{ number_format($ordenTrabajo->hojaTrabajo->recepcionOT->getMontoConSinDescuento() / 1.18, 2) }} --}}
                                                {{ $ordenTrabajo->getMontoTotalDolares() }}
                                            </td>
                                        @else
                                            <td style="vertical-align: middle">-</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="alert alert-primary"
                     role="alert"
                     align="center">
                    <h5>Valores expresados en dólares y sin IGV</h5>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/recepcion.js') }}"></script>
    <script src="{{ asset('js/filtro.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>

@endsection
