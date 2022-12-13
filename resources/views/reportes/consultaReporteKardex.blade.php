@extends('contabilidadv2.layoutCont')
@section('titulo', 'Consulta Reporte Kardex')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <div style="background: white;padding: 10px">
        <div class="row justify-content-between col-12">
            <h2>Reportes - Kardex</h2>
        </div>
        <div id="busquedaForm"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormObtenerReporteKardex"
                  class="my-3 mr-3"
                  method="GET"
                  value="search">
                <div class="row">
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="fechaInicial"
                                   class="col-form-label">Fecha Inicial</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="fechaInicial"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control w-100"
                                   id="fechaInicial"
                                   placeholder="dd/mm/aaaa"
                                   data-validation="date required"
                                   data-validation-format="dd/mm/yyyy"
                                   data-validation-length="10"
                                   data-validation-error-msg="Debe ingresar una fecha Inicial"
                                   data-validation-error-msg-container="#errorFechaInicial"
                                   maxlength="10"
                                   autocomplete="off">
                            <div id="errorFechaInicial"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>
                    </div>
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="fechaFinal"
                                   class="col-form-label">Fecha Final</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="fechaFinal"
                                   type="text"
                                   autocomplete="off"
                                   class="datepicker form-control w-100"
                                   id="fechaFinal"
                                   placeholder="dd/mm/aaaa"
                                   data-validation="date required"
                                   data-validation-format="dd/mm/yyyy"
                                   data-validation-length="10"
                                   data-validation-error-msg="Debe ingresar una fecha Final"
                                   data-validation-error-msg-container="#errorFechaFinal"
                                   maxlength="10"
                                   autocomplete="off">
                            <div id="errorFechaFinal"
                                 class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        </div>
                    </div>
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <div class="row justify-content-end mb-3">
                            {{-- <button formaction="{{route('reportes.consulta.kardex2')}}" type="submit" name="generar" class="btn btn-primary">Generar</button> --}}
                            <button formaction="{{ route('reportes.consulta.kardexV2') }}"
                                    type="submit"
                                    name="exportar"
                                    class="btn ml-2 btn-success">Exportar</button>
                        </div>
                    </div>
                    <div style="display:none"
                         class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="filtroNroRepuesto"
                                   class="col-form-label">Cod. Repuesto</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input id="filtroNroRepuesto"
                                   name="nroRepuesto"
                                   type="text"
                                   tipo="repuestos"
                                   class="form-control typeahead w-100"
                                   autocomplete="off"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="Puede ingresar el Codigo o la descripccion del repuesto en este campo">
                        </div>
                    </div>
                    <div style="display:none"
                         class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="filtroDescripcion"
                                   class="col-form-label">Descripción</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input id="filtroDescripcion"
                                   typeahead_second_field="filtroNroRepuesto"
                                   name="descripcion"
                                   type="text"
                                   class="form-control w-100"
                                   placeholder="Descripcion"
                                   readonly>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-end mb-3">
                    *Los precios mostrados se encuentran en dólares y no incluyen IGV
                </div>
            </form>
        </div>

    </div>
    @if (false)
        <div class="mx-3"
             style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
            <div class="table-responsive borde-tabla tableFixHead">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row col-12">
                            <div>
                                <h2>Reporte Kardex</h2>
                            </div>
                            <form id="FormReporteKardexExcel"
                                  class="my-3 mr-3"
                                  method="POST"
                                  action="{{ route('reportes.kardex', ['resultados' => $resultados]) }}"
                                  value="search">

                            </form>

                            @if (false)
                                <a
                                   href="{{ route('reportes.kardex', ['fechaInicial' => $fechaInicial, 'fechaFinal' => $fechaFinal, 'idRepuesto' => $idRepuesto]) }}"><button
                                            class="btn btn-primary">Exportar</button></a>
                            @endif
                        </div>
                    </div>

                    <div class="table-cont-single">
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">COD. REPUESTO</th>
                                    <th scope="col">FECHA MOV.</th>
                                    <th scope="col">TIPO MOV.</th>
                                    <th scope="col">CANT. INGRESO</th>
                                    <th scope="col">CANT. SALIDA</th>
                                    @if (false)
                                        <th scope="col">MONEDA COSTO</th>
                                    @endif
                                    <th scope="col">COSTO INGRESO</th>
                                    <th scope="col">COSTO SALIDA</th>
                                    <th scope="col">SALDO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultados as $resultado)
                                    <tr>

                                        <th style="vertical-align: middle"
                                            scope="row">{{ $loop->iteration }}</th>
                                        <td style="vertical-align: middle">{{ $resultado->codigo_repuesto }}</td>
                                        <td style="vertical-align: middle">{{ $resultado->fecha_movimiento }}</td>
                                        <td style="vertical-align: middle">{{ $resultado->motivo }}</td>
                                        <td style="vertical-align: middle">{{ $resultado->cantidad_ingreso }}</td>
                                        <td style="vertical-align: middle">{{ $resultado->cantidad_salida }}</td>
                                        @if (false)
                                            <td style="vertical-align: middle">{{ $resultado->moneda_costo }}</td>
                                        @endif
                                        <td style="vertical-align: middle">{{ $resultado->ingreso_dolares }}</td>
                                        <td style="vertical-align: middle">{{ $resultado->salida_dolares }}</td>
                                        <td style="vertical-align: middle">{{ $resultado->saldo_dolares }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    @endIf
    <script>
        $("#btnExport").on('click', function() {
            var link_sub = '/reportes/kardex/';
            var link_completo = rootURL + link_sub;
            var filtroNroRepuesto = $("#filtroNroRepuesto");
            var fechaInicial = $("#fechaInicial");
            var fechaFinal = $("#fechaFinal");
            $.get(link_completo, {
                'fechaInicial': fechaInicial,
                'fechaFinal': fechaFinal,
                'idRepuesto': filtroNroRepuesto
            }, function(data, status) {
                console.log(data)
            });
        });
    </script>

@endsection
