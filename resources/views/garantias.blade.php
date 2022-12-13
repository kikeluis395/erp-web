@extends('tableCanvas')
@section('titulo', 'Modulo de garantias')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-4">Seguimiento garantias</h2>

        <div id="busquedaCollapsable"
             class="col-12 collapse borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRecepcion"
                  class="my-3"
                  method="GET"
                  action="{{ route('garantia.index') }}"
                  value="search">
                <div class="flex-wrap d-flex container-fluid justify-content-between">

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3">
                        <label for="filtroNroDoc"
                               class="col-form-label text-center col-12 col-sm-6">VIN</label>
                        <input id="filtroNroDoc"
                               name="vin"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="VIN"
                               maxlength="17"
                               {{-- value="{{ isset(request()->vin) ? request()->vin : '' }}" --}}>
                    </div>
                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3">
                        <label for="filtroPlaca"
                               class="col-form-label text-center col-12 col-sm-6 col-lg-6">Placa</label>
                        <input id="filtroPlaca"
                               name="placa"
                               type="text"
                               class="form-control col-12 col-sm-6 col-lg-6"
                               placeholder="Número de placa"
                               oninput="this.value = this.value.toUpperCase()"
                               {{-- value="{{ isset(request()->placa) ? request()->placa : '' }}" --}}>
                    </div>
                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3">
                        <label for="filtroOT"
                               class="col-form-label text-center col-12 col-sm-6 col-lg-6">OT</label>
                        <input id="filtroOT"
                               name="nroOT"
                               type="text"
                               class="form-control col-12 col-sm-6 col-lg-6"
                               placeholder="Órden de Trabajo"
                               {{-- value="{{ isset(request()->nroOT) ? request()->nroOT : '' }}" --}}>
                    </div>

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-3">
                        <label for="filtroOT"
                               class="col-form-label text-center col-12 col-sm-6 col-lg-6">Nº Documento</label>
                        <input id="filtroOT"
                               name="nroDoc"
                               type="text"
                               class="form-control col-12 col-sm-6 col-lg-6"
                               placeholder="Numero de documento"
                               {{-- value="{{ isset(request()->nroDoc) ? request()->nroDoc : '' }}" --}}>
                    </div>

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-6">
                        <div class="col-12 col-xs-12 col-sm-5 col-md-5">
                            <label for="filtroFechaInicio"
                                   class="col-form-label text-center col-12 col-sm-12">Rango F. Entrega</label>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-7 col-md-7 row">
                            <input name="fecha_inicio"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   id="filtroFechaInicio"
                                   data-validation-format="dd/mm/yyyy"
                                   data-validation-length="10"
                                   data-validation-error-msg-container="#errorFechaInicio"
                                   placeholder="dd/mm/aaaa"
                                   maxlength="10"
                                   style="width:49%"
                                   {{-- value="{{ isset(request()->fecha_inicio) ? request()->fecha_inicio : '' }}" --}} />
                            <span style="width: 2%"
                                  class="d-flex align-items-center justify-content-center">-</span>
                            <input name="fecha_fin"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   id="filtroFechaFin"
                                   data-validation-format="dd/mm/yyyy"
                                   data-validation-length="10"
                                   data-validation-error-msg-container="#errorFechaInicio"
                                   placeholder="dd/mm/aaaa"
                                   maxlength="10"
                                   style="width:49%"
                                   {{-- value="{{ isset(request()->fecha_fin) ? request()->fecha_fin : '' }}" --}} />
                        </div>
                    </div>

                    <div class="form-group row col-6 col-xs-6 col-sm-6 col-md-6"></div>

                </div>
                <div class="col-12">
                    <div class="row justify-content-end">
                        <button type="submit"
                                class="btn btn-primary ">Buscar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade"
             id="modalReporteFacturado"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">

            <div class="modal-dialog"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header fondo-sigma">
                        <h5 class="modal-title"
                            id="confirmarEntregaLabel">
                            GENERAR REPORTE
                        </h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"
                         style="max-height: 65vh;overflow-y: auto;">

                        <form id="FormGenerarReporteFacturadas"
                              method="POST"
                              action="{{ route('garantia.reporte') }}"
                              value="Submit"
                              autocomplete="off">
                            @csrf

                            {{-- <input type="hidden"
                                   name="id_recepcion_ot"
                                   value="{{ $entregable->id_recepcion_ot }}" /> --}}


                            <div class="form-group d-flex xscroll_none">
                                <label for="fechaInicio"
                                       class="col-sm-6 justify-content-start align-items-center d-flex">Inicio:</label>
                                <input name="fecha_inicio"
                                       type="text"
                                       autocomplete="off"
                                       class="datepicker form-control col-sm-6"
                                       id="fechaInicio"
                                       data-validation="date"
                                       data-validation-format="dd/mm/yyyy"
                                       data-validation-length="10"
                                       data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa"
                                       data-validation-error-msg-container="#errorFechaInicio"
                                       placeholder="dd/mm/aaaa"
                                       maxlength="10"
                                       {{-- min-date="{{ $entregable->minFechaEntrega() }}"
                                       value="{{ $entregable->minFechaEntrega() }}" /> --}} />
                                <div id="errorFechaInicio"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>

                            <div class="form-group d-flex xscroll_none">
                                <label for="fechaFin"
                                       class="col-sm-6 justify-content-start align-items-center d-flex">Fin:</label>
                                <input name="fecha_fin"
                                       type="text"
                                       autocomplete="off"
                                       class="datepicker form-control col-sm-6"
                                       id="fechaFin"
                                       data-validation="date"
                                       data-validation-format="dd/mm/yyyy"
                                       data-validation-length="10"
                                       data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa"
                                       data-validation-error-msg-container="#errorFechaFin"
                                       placeholder="dd/mm/aaaa"
                                       maxlength="10"
                                       {{-- min-date="{{ $entregable->minFechaEntrega() }}"
                                       value="{{ $entregable->minFechaEntrega() }}" --}} />

                                <div id="errorFechaFin"
                                     class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">Cerrar</button>
                        <button id="btnSubmit"
                                form="FormGenerarReporteFacturadas"
                                value="Submit"
                                type="submit"
                                class="btn btn-primary">Generar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('table-content')
    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        <div class="table-responsive borde-tabla">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 d-flex"
                         style="justify-content:space-between">
                        <div class="d-flex flex-row">
                            <div>
                                <h2>Listos para facturar</h2>
                            </div>

                            <button class="btn btn-primary rounded-pill px-3"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#busquedaCollapsable"
                                    aria-expanded="false"
                                    aria-controls="busquedaCollapsable"
                                   >
                                Filtrar
                            </button>
                        </div>
                        <div>

                            <button id="btnAgregarServicioTercero"
                                    data-toggle="modal"
                                    data-target="#modalReporteFacturado"
                                    aria-expanded="false"
                                    aria-controls="modalReporteFacturado"
                                    type="button"
                                    {{-- style="border-radius: 25px;padding: 10px; color:rgba(0,0,0,1)" --}}
                                    class="btn btn-warning rounded-pill px-3 py-2">REPORTE GARANTIAS FACTURADAS
                            </button>
                        </div>

                    </div>
                </div>

                <div class="table-cont-single">
                    <table class="table text-center table-striped table-sm tableFixHead">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col">SECCIÓN</th>
                                <th scope="col">OT</th>
                                <th scope="col">PLACA</th>
                                <th scope="col">N° DOC</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">F. CREACIÓN OT</th>
                                <th scope="col">F. ENTREGA VEH</th>
                                <th scope="col">F. GESTIÓN MARCA</th>
                                <th scope="col">SEGUIMIENTO</th>
                                <th scope="col">FACTURACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listaRecepcionesOTs as $entregable)

                                @if (is_a($entregable, 'App\Modelos\RecepcionOT') && is_null($entregable->garantia))
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <span class="{{ $entregable->claseGarantia() }} rounded-pill px-3">
                                                {{ $entregable->estado_garantia() }}
                                            </span>
                                        </td>
                                        <td>{{ $entregable->seccion() }}</td>
                                        <td>{!! $entregable->getLinkDetalleHTML() !!}</td>
                                        <td>{{ substr($entregable->hojaTrabajo->placa_auto, 0, 3) . '-' . substr($entregable->hojaTrabajo->placa_auto, 3, 3) }}
                                        </td>
                                        <td>{{ $entregable->hojaTrabajo->getNumDocCliente() }}</td>
                                        <td>{{ $entregable->hojaTrabajo->getNombreCliente() }}</td>
                                        <td>{{ $entregable->hojaTrabajo->getFechaRecepcionFormat() }}</td>
                                        <td>
                                            {{ $entregable->fechaNotaEntrega() }}
                                        </td>
                                        <td>{{ $entregable->gestionMarca() }}</td>
                                        <td>
                                            @include('modals.seguimientoGarantia')
                                        </td>
                                        <td>
                                            @include('modals.facturarGarantia')
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/garantia.js') }}"></script>
@endsection
