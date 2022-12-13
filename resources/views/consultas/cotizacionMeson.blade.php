@extends('mecanica.tableCanvas')
@section('titulo', 'Cotizacion - Meson')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <div class="row justify-content-between col-12">
            <h2>Consulta - Cotizaciones Meson</h2>
        </div>

        <div id="busquedaForm"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormFiltrarRepuestos"
                  class="my-3 mr-3"
                  method="GET"
                  action="{{ route('consultas.meson') }}"
                  onsubmit="return submitReporteVentasTaller()"
                  value="search">
                <div class="row">
                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="nroCotizacion"
                                   class="col-form-label">Nro. Cotización</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input id="nroCotizacion"
                                   name="nroCotizacion"
                                   type="text"
                                   class="form-control typeahead w-100"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="Puede ingresar el nro de cotización"
                                   value="{{ isset(request()->nroCotizacion) ? request()->nroCotizacion : '' }}">
                        </div>
                    </div>

                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="nroNV"
                                   class="col-form-label">Nro. NV</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input id="nroNV"
                                   name="nroNV"
                                   type="text"
                                   class="form-control typeahead w-100"
                                   value="{{ isset(request()->nroNV) ? request()->nroNV : '' }}">
                        </div>
                    </div>

                    <div class="form-group row ml-1 col-6 col-sm-3">
                        <div class="col-12 col-sm-6">
                            <label for="docCliente"
                                   class="col-form-label">Doc. cliente</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input id="docCliente"
                                   name="docCliente"
                                   type="number"
                                   class="form-control typeahead w-100"
                                   maxlength="11"
                                   value="{{ isset(request()->docCliente) ? request()->docCliente : '' }}">
                        </div>
                    </div>

                    <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
                        <label for="filtroestadoCotizacionMeson"
                               class="col-form-label col-6 col-lg-5">Estado cotizacion</label>
                        <select name="estadoCotizacionMeson"
                                id="filtroSeguro"
                                class="form-control col-6 col-lg-7">
                            <option value="all">Todos</option>

                            @php
                                $estados_cot = ['PENDIENTE' => 'Pendientes', 'LIQUIDADO' => 'Liquidadas', 'FACTURADO' => 'Facturadas', 'CERRADA' => 'Cerradas'];
                            @endphp
                            @foreach (array_keys($estados_cot) as $estado)
                                <option value="{{ $estado }}"
                                        {{ isset(request()->estadoCotizacionMeson) && request()->estadoCotizacionMeson == $estado ? 'selected' : '' }}>
                                    {{ $estados_cot[$estado] }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>


                <div class="row mt-2">
                    <div class="col-md-6 ml-2 form-group row">
                        <label class="col-md-3">Fecha Rango Apertura</label>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaAperturaIni"
                                   id="fechaAperturaIni"
                                   onchange="controlarInputs('fechaApertura', 'fechaFactura')"
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaAperturaIni) ? request()->fechaAperturaIni : '' }}"
                                   {{-- required --}}>
                            <span class="text-danger"
                                  id="fechaAperturaIniError"></span>
                        </div>
                        <span class="mx-2">-</span>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaAperturaFin"
                                   id="fechaAperturaFin"
                                   onchange="controlarInputs('fechaApertura', 'fechaFactura')"
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaAperturaFin) ? request()->fechaAperturaFin : '' }}"
                                   {{-- required --}}>
                            <span class="text-danger"
                                  id="fechaAperturaFinError"></span>
                        </div>
                    </div>

                    <div class="col-md-6 ml-2 form-group row">
                        <label class="col-md-3">Fecha Rango Factura</label>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaFacturaIni"
                                   id="fechaFacturaIni"
                                   onchange="controlarInputs('fechaFactura', 'fechaApertura')"
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaFacturaIni) ? request()->fechaFacturaIni : '' }}"
                                   >
                            <span class="text-danger"
                                  id="fechaFacturaIniError"></span>
                        </div>
                        <span class="mx-2">-</span>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaFacturaFin"
                                   id="fechaFacturaFin"
                                   onchange="controlarInputs('fechaFactura', 'fechaApertura')"
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaFacturaFin) ? request()->fechaFacturaFin : '' }}"
                                   >
                            <span class="text-danger"
                                  id="fechaFacturaFinError"></span>
                        </div>
                    </div>

                    <div class="col-md-6 ml-2 form-group row">
                        <label class="col-md-3">Fecha Rango Cierre</label>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaCierreIni"
                                   id="fechaCierreIni"
                                   {{-- onchange="controlarInputs('fechaFactura', 'fechaApertura')" --}}
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaCierreIni) ? request()->fechaCierreIni : '' }}"
                                   >
                            <span class="text-danger"
                                  id="fechaCierreIniError"></span>
                        </div>
                        <span class="mx-2">-</span>
                        <div class="col-md-3">
                            <input type="text"
                                   autocomplete="off"
                                   class="datepicker form-control"
                                   name="fechaCierreFin"
                                   id="fechaCierreFin"
                                   {{-- onchange="controlarInputs('fechaFactura', 'fechaApertura')" --}}
                                   placeholder="dd/mm/yyyy"
                                   value="{{ isset(request()->fechaCierreFin) ? request()->fechaCierreFin : '' }}"
                                   >
                            <span class="text-danger"
                                  id="fechaCierreFinError"></span>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-3">
                    <a href="{{ route('consultas.meson') }}"
                       class="btn btn-secondary mr-3">Quitar filtros</a>

                    <button type="submit"
                            class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('table-content')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css" />

    @if (count($listaCotizaciones) > 0)
        <div class="mx-3"
             style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
            <div class="table-responsive borde-tabla tableFixHead">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row col-12 align-items-center">
                            <div>
                                <h2 class="mt-0">Cotizaciones </h2>
                            </div>

                            @if ($listaCotizaciones != null)
                                <a href="{{ route('consultas.cotizacionesMeson.exportExcel', $request) }}">
                                    <button class="btn btn-success px-3 py-2 rounded-pill">Exportar&nbsp;<i
                                           class="fas fa-file-excel"></i></button></a>
                            @endif

                        </div>
                    </div>

                    <div class="table-cont-single">
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">F. CREACIÓN</th>
                                    <th scope="col"># COT.</th>
                                    <th scope="col"># NV</th>
                                    <th scope="col"># FACTURA</th>
                                    <th scope="col">F. FACTURACION</th>
                                    <th scope="col">DOCUMENTO</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">VENDEDOR</th>
                                    <th scope="col">$ VENTA</th>
                                    <th scope="col">¿MAYOREO?</th>
                                    <th scope="col">OBS</th>
                                    <th scope="col">MOTIVO CIERRE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listaCotizaciones as $row)
                                    <tr>
                                        <th style="vertical-align: middle"
                                            scope="row">{{ $loop->iteration }}</th>
                                        <td style="vertical-align: middle">{{ $row->getFechaCreacionText() }}</td>
                                        <td style="vertical-align: middle">{!! $row->getLinkDetalleHTML() !!}</td>
                                        <td style="vertical-align: middle">{{ $row->getIdVentaMeson() }}</td>
                                        <td style="vertical-align: middle">{{ $row->getNumeroFactura() }}</td>
                                        <td style="vertical-align: middle">{{ $row->getFechaVentaCotizacion() }}</td>
                                        <td style="vertical-align: middle">{{ $row->doc_cliente }}</td>
                                        <td style="vertical-align: middle">{{ $row->nombre_cliente }}</td>
                                        <td style="vertical-align: middle">{{ $row->getNombrevendedor() }}</td>
                                        <td style="vertical-align: middle">
                                            {{-- {{ App\Helper\Helper::obtenerUnidadMoneda($row->moneda) }} --}}
                                            {{ $row->moneda == 'DOLARES' ? number_format($row->getValueDiscountedQuote2Approved() / 1.18, 2) : number_format($row->getValueDiscountedQuote2Approved() / 1.18 / $row->tipo_cambio, 2) }}

                                            {{-- {{ number_format($row->getValueDiscountedQuote2Approved(), 2) }}</td> --}}

                                        <td style="vertical-align: middle">{{ $row->esMayoreo() }}</td>
                                        <td style="vertical-align: middle">{{ $row->observaciones }}</td>
                                        <td style="vertical-align: middle">{{ $row->razon_cierre }}</td>


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
        </div>
    @endif
@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/recepcion.js') }}"></script>
    <script src="{{ asset('js/filtro.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
@endsection
