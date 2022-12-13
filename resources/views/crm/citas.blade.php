@extends('mecanica.tableCanvas')
@section('titulo', 'CRM - Seguimiento de citas')

@section('pretable-content')

    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-4">Seguimiento de Citas</h2>
        <div class="justify-content-between">
            <div style="background: white;margin-top:10px">
                <div class="row">
                    <div class="row ml-1 col-12 ml-sm-0 col-sm-12">
                        <div class="form-group form-inline">
                            <label for="filtroFecha"
                                   class="col-form-label col-6 col-lg-5">Fecha</label>
                            <input name="fecha"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control col-sm-6"
                                   id="fechaCitaIn"
                                   placeholder="dd/mm/aaaa"
                                   maxlength="10"
                                   autocomplete="off"
                                   value="{{ $fechaSeleccionada }}">
                        </div>
                        @if (session('citaExistente'))
                            <div style="color: red;">{{ session('citaExistente') }}</div>
                        @endif
                        @if (session('citaFechaError'))
                            <div style="color: red;">{{ session('citaFechaError') }}</div>
                        @endif
                        @if (session('errorFechas'))
                            <div style="color: red;">{{ session('errorFechas') }}</div>
                        @endif
                        @if (session('vehiculoError'))
                            <div style="color: red;">{{ session('vehiculoError') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="row justify-content-start mt-2 ml-2">
                <div class="circ-semaforo-popover ml-3 bg-secondary"
                     @if (false) style="background-color: gray" @endif></div><span class="semf-pop-info">Disponible</span>
                <div class="circ-semaforo-popover ml-3 bg-success"
                     @if (false) style="background-color: green" @endif></div><span class="semf-pop-info">Asistió</span>
                <div class="circ-semaforo-popover ml-3 bg-warning"
                     @if (false) style="background-color: yellow" @endif></div><span class="semf-pop-info">Reservado</span>
                <div class="circ-semaforo-popover ml-3 bg-danger"
                     @if (false) style="background-color: red" @endif></div><span class="semf-pop-info">No asistió</span>
            </div>

            <div class="mx-3">
                <button type="button"
                        class="btn btn-info"
                        data-toggle="modal"
                        data-target="#exportarCitas"
                        data-backdrop="static">Exportar</button>
                <!-- Modal -->
                <div class="modal fade"
                     id="exportarCitas"
                     tabindex="-1"
                     role="dialog"
                     aria-hidden="true">
                    <div class="modal-dialog"
                         role="document">
                        <div class="modal-content">
                            <div class="modal-header fondo-sigma">
                                <h5 class="modal-title">Exportar citas</h5>
                                <button type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body"
                                 style="max-height: 65vh;overflow-y: auto;">
                                <form id="FormExportarCitas"
                                      method="GET"
                                      action="{{ route('reportes.citas') }}"
                                      value="Submit"
                                      autocomplete="off">
                                    <fieldset>
                                        <div class="form-group form-inline">
                                            <label for="FechaIniEdit"
                                                   class="col-sm-6 justify-content-end">Fecha inicial: </label>
                                            <input name="fechaIni"
                                                   type="text"
                                                   autocomplete="off"
                                                   class="fecha-inicio form-control col-sm-6"
                                                   id="FechaIniEdit"
                                                   placeholder="dd/mm/aaaa"
                                                   maxlength="10"
                                                   autocomplete="off"
                                                   required
                                                   >
                                            <div id="errorFechaIniEdit"
                                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="FechaFinEdit"
                                                   class="col-sm-6 justify-content-end">Fecha final: </label>
                                            <input name="fechaFin"
                                                   type="text"
                                                   autocomplete="off"
                                                   class="fecha-fin form-control col-sm-6"
                                                   id="FechaFinEdit"
                                                   placeholder="dd/mm/aaaa"
                                                   maxlength="10"
                                                   autocomplete="off"
                                                   required
                                                   >
                                            <div id="errorFechaFinEdit"
                                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="asesorIn"
                                                   class="col-sm-6 justify-content-end">Asesor:</label>
                                            <select name="asesor"
                                                    id="asesorIn"
                                                    class="form-control col-sm-6">
                                                <option value="all">Todos</option>
                                                @foreach ($listaAsesores as $asesor)
                                                    <option value="{{ $asesor->dni }}">
                                                        {{ strtoupper($asesor->username) }}
                                                    </option>
                                                @endforeach
                                                {{-- @if (false)
                                                    <option value="{{ $asesor->dni }}">{{ $asesor->nombre_asesor }}
                                                    </option>
                                                @endif --}}
                                            </select>
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="estadoCita"
                                                   class="col-sm-6 justify-content-end">Estado de cita:</label>
                                            <select name="estado"
                                                    id="estadoCita"
                                                    class="form-control col-sm-6">
                                                <option value="all">Todos</option>
                                                <option value="asistio">Asistió</option>
                                                <option value="pendiente">Reservado</option>
                                                <option value="no_asistio">No asistió</option>
                                                <option value="cancelado">Cancelado</option>
                                                {{-- <option value="disponible">Disponible</option> --}}
                                            </select>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal">Cerrar</button>
                                <button id="btnExportarCitas"
                                        form="FormExportarCitas"                                        
                                        type="submit"
                                        class="btn btn-primary">Exportar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('table-content')
    <div class="mx-3"
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        <div id="tablaCitasContainer"
             class="table-responsive">

            <div class="table-cont-single">
                {!! $tablaCitas !!}
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    @parent
    <script>
        var modelos = {!! $listaModelos !!};
    </script>
    <script src="{{ asset('js/citas.js') }}"></script>
@endsection
