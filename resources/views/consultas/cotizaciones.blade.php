@extends('mecanica.tableCanvas')
@section('titulo', 'Consultas - Cotizaciones Taller')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <div class="row justify-content-between col-12">
            <h2>Consulta - Cotizaciones</h2>
        </div>
        <div id="busquedaForm"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRecepcion"
                  class="my-3"
                  method="GET"
                  action="{{ route('consultas.cotizaciones') }}"
                  value="search">

                <div class="row">
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <label for="filtroNroDoc"
                               class="col-form-label col-12 col-sm-6">Doc. Cliente</label>
                        <input id="filtroNroDoc"
                               name="nroDoc"
                               type="number"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de documento"
                               maxlength="11"
                               value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}">
                    </div>
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <label for="filtroPlaca"
                               class="col-form-label col-12 col-sm-6">Placa</label>
                        <input id="filtroPlaca"
                               name="nroPlaca"
                               type="text"
                               maxlength="6"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de placa"
                               oninput="this.value = this.value.toUpperCase()"
                               value="{{ isset(request()->nroPlaca) ? request()->nroPlaca : '' }}">
                    </div>

                    <div class="form-group row col-6 col-sm-3">
                        <label for="filtroVIN"
                               class="col-form-label col-12 col-sm-6">VIN</label>
                        <input id="filtroVIN"
                               name="nroVIN"
                               type="text"
                               maxlength="17"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número VIN"
                               value="{{ isset(request()->nroVIN) ? request()->nroVIN : '' }}">
                    </div>

                    <div class="form-group row ml-1 col-6 col-md-3">
                        <label for="filtroCot"
                               class="col-form-label col-12 col-sm-4 col-lg-6"># Cotización</label>
                        <input id="filtroCot"
                               name="nroCotizacion"
                               type="text"
                               class="form-control col-12 col-sm-6 col-lg-6"
                               placeholder="Órden de Trabajo"
                               value="{{ isset(request()->nroCotizacion) ? request()->nroCotizacion : '' }}">
                    </div>
                    <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
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
                        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
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

                    <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
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

                    <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
                        <label for="filtroestadoCotizacionMeson"
                               class="col-form-label col-6 col-lg-5">Estado cotizacion</label>
                        <select name="estadoCotizacionTaller"
                                id="filtroSeguro"
                                class="form-control col-6 col-lg-7">
                            <option value="all">Todos</option>
                            <option value="vendida"
                                    {{ isset(request()->estadoCotizacionTaller) && request()->estadoCotizacionTaller == 'vendida' ? 'selected' : '' }}>
                                Vendida</option>
                            <option value="pendiente"
                                    {{ isset(request()->estadoCotizacionTaller) && request()->estadoCotizacionTaller == 'pendiente' ? 'selected' : '' }}>
                                Pendiente</option>
                            <option value="cerrada"
                                    {{ isset(request()->estadoCotizacionTaller) && request()->estadoCotizacionTaller == 'cerrada' ? 'selected' : '' }}>
                                Cerrada</option>
                        </select>
                    </div>

                    <div class="col-md-6 ml-2 form-group row">
                        <label class="col-md-3">Rango F. Creación</label>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaCreacionIni"
                                   id="fechaCreacionIni"
                                   onchange="controlarInputs('fechaApertura', 'fechaFactura')"
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaCreacionIni) ? request()->fechaCreacionIni : '' }}"
                                   {{-- required --}}>
                            <span class="text-danger"
                                  id="fechaCreacionIniError"></span>
                        </div>
                        <span class="mx-2">-</span>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaCreacionFin"
                                   id="fechaCreacionFin"
                                   onchange="controlarInputs('fechaApertura', 'fechaFactura')"
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaCreacionFin) ? request()->fechaCreacionFin : '' }}"
                                   {{-- required --}}>
                            <span class="text-danger"
                                  id="fechaCreacionFinError"></span>
                        </div>
                    </div>

                </div>

                <div class="row justify-content-end mb-3 mr-2">
                    <a href="{{ route('consultas.cotizaciones') }}"
                       class="btn btn-secondary mr-3">Quitar filtros</a>

                    <button type="submit"
                            class="btn btn-primary">Buscar</button>
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

        @if ($listaCotizaciones->count())
            <div class="table-responsive borde-tabla tableFixHead">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row col-12 align-items-center">
                            <div>
                                <h2 class="mt-0">Cotizaciones</h2>
                            </div>

                            @if ($listaCotizaciones->count())
                                <a href="{{ route('consultas.cotizaciones.exportExcel', $request) }}"><button
                                            class="btn btn-success px-3 py-2 rounded-pill">Exportar&nbsp;<i
                                           class="fas fa-file-excel"></i></button></a>
                            @endif
                        </div>
                    </div>

                    <div class="table-cont-single">
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">COTIZACION</th>
                                    <th scope="col">FECHA CREACIÓN</th>
                                    <th scope="col">ESTADO</th>
                                    <th scope="col">LOCAL</th>
                                    <th scope="col">ASESOR SERVICIO</th>
                                    <th scope="col">PLACA</th>
                                    <th scope="col">MARCA</th>
                                    <th scope="col">MODELO</th>
                                    <th scope="col">DOC CLIENTE</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">TRABAJOS</th>
                                    <th scope="col">$ VENTA</th>
                                    <th scope="col">MOTIVO CIERRE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listaCotizaciones as $cotizacion)
                                    @if (!is_null($cotizacion->hojaTrabajo))

                                        <tr>
                                            <th style="vertical-align: middle"
                                                scope="row">{{ $loop->iteration }}</th>
                                            <td style="vertical-align: middle">
                                                {!! $cotizacion->getLinkDetalleHTML() !!}
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->getFechaRecepcionFormat() }}</td>
                                            <td>{{ $cotizacion->getEstado() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->empleado->local->nombre_local }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->empleado->nombreCompleto() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->getPlacaAutoFormat() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->vehiculo->getNombreMarca() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ substr($cotizacion->hojaTrabajo->getModeloVehiculo(), 0, 10) }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->getNumDocCliente() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->getNombreCliente() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->hojaTrabajo->getPrimerTrabajoPreventivoOptional() }}</td>
                                            <td style="vertical-align: middle">
                                                {{ $cotizacion->getMontoDolares() }}
                                            </td>
                                            <td>{{ $cotizacion->getMotivoCierre() }}</td>
                                        </tr>
                                    @endif
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
