@extends('tableCanvas')
@if (isset($id_recepcion_ot))
    @section('titulo', "Detalle de OT N° $id_recepcion_ot")
    @elseif(isset($id_cotizacion))
    @section('titulo', "Detalle de Cotizacion N° $id_cotizacion")
    @else
    @section('titulo', 'Modulo de recepcion - Registro')
    @endif

    @section('pretable-content')
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css" />
        @if (false)
            @if (isset($id_recepcion_ot))
                @include('modals.registrarCliente')
                @include('modals.registrarVehiculo')
            @elseif(isset($id_cotizacion))
                @include('modals.registrarClienteCotizacion')
                @include('modals.registrarVehiculoCotizacion')
            @endif
        @endif

        <div style="background: white;padding: 10px">
            <div class="col-12 mt-2 mt-sm-0">
                <div class="row justify-content-between">
                    <h2 class="ml-3 mt-3 mb-4">
                        @if (isset($id_recepcion_ot) || isset($datosRecepcionOT)) Órden de Trabajo - B&P
                        @else Cotización - B&P @endif
                    </h2>
                    <div class="row justify-content-end">
                        @if (session('cotizacionesPreAsociadas'))
                            <div class="mr-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        @foreach (session('cotizacionesPreAsociadas') as $cotizacion)
                                            <li class="page-item @if ($cotizacion->id_cotizacion == $id_cotizacion) disabled @endif"><a class="page-link"
                                                   href="{{ route('detalle_trabajos.index', ['id_cotizacion' => $cotizacion->id_cotizacion]) }}">Cotización
                                                    N° {{ $cotizacion->id_cotizacion }}</a></li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        @endif
                        <a
                           href="{{ isset($id_recepcion_ot) || isset($datosRecepcionOT) ? route('recepcion.index') : route('cotizaciones.index') }}"><button
                                    type="button"
                                    class="btn btn-info">Regresar</button></a>
                    </div>
                </div>

                @if (isset($id_recepcion_ot) || isset($datosRecepcionOT))
                    @include('sections.dataDetalleTrabajoDYP_OT')
                @elseif(isset($id_cotizacion) || isset($datosRecepcion))
                    @include('sections.dataDetalleTrabajoDYP_Cotizacion')
                @endif

                <div class="row justify-content-between">
                    <div class="form-group form-inline col-md-6 form-group-align-top">
                        <label for="observacionesIn">Observaciones:</label>
                        <textarea name="observaciones"
                                  type="text"
                                  class="form-control col-10 ml-3"
                                  id="observacionesIn"
                                  placeholder="Ingrese sus observaciones"
                                  maxlength="255"
                                  rows="3"
                                  form="formDetallesTrabajo"
                                  autocomplete="off"
                                  disabled>{{ $datosHojaTrabajo->observaciones }}</textarea>
                    </div>

                    <div class="row col-md-6 justify-content-end">
                        @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                            <div>

                                <div class="col-12">
                                    @if (isset($id_recepcion_ot) || isset($id_cotizacion))
                                        @if ($datosHojaTrabajo->getEstadoDescuento() != 'SOLICITUD DE DESCUENTO EN PROCESO')
                                            @include('modals.solicitarDescuento')
                                        @else
                                            <button id="btnRequestDicountDisable"
                                                    onClick="showAlert()"
                                                    type="button"
                                                    class="btn btn-success"
                                                    style="margin-left:15px">Solicitar descuento</button>
                                        @endif
                                    @endif

                                </div>

                                @if ($datosHojaTrabajo->isVisibleMessageDiscountRequest() || $datosHojaTrabajo->getEstadoDescuento() == 'SOLICITUD DE DESCUENTO EN PROCESO')
                                    @if ($datosHojaTrabajo->getEstadoDescuento() == 'SOLICITUD DE DESCUENTO EN PROCESO')
                                        <div class="col-12 text-center alert alert-warning">
                                            {{ $datosHojaTrabajo->getEstadoDescuento() }}
                                        </div>
                                    @elseIf($datosHojaTrabajo->getEstadoDescuento() == "SOLICITUD DE DESCUENTOS RECHAZADA")
                                        <div class="col-12 text-center alert alert-danger">
                                            {{ $datosHojaTrabajo->getEstadoDescuento() }}
                                        </div>
                                    @else
                                        @if ((string) $datosHojaTrabajo->getEstadoDescuento() != '')
                                            <div class="col-12 text-center alert alert-success">
                                                {{ $datosHojaTrabajo->getEstadoDescuento() }}
                                            </div>
                                        @endif
                                    @endIf
                                @endIf

                            </div>
                            <div>
                                @if (isset($id_cotizacion)) @include('modals.cotizacionAsociarOT')
                                @endif
                                @if (isset($id_recepcion_ot)) @include('modals.OTAsociarCotizacion')
                                @endif
                                @if (isset($listaEliminados) && $listaEliminados)
                                    @include('modals.trackingEliminados')@endif

                            </div>
                        @endif


                    </div>
                </div>


                <div class="row justify-content-end">
                    @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                        @if (false)
                            <div>
                                @if (isset($id_recepcion_ot) && $datosRecepcionOT->tieneInventario())<a
                                       href="{{ route('inventarioVehiculo.index', ['id_recepcion_ot' => $id_recepcion_ot]) }}"><button
                                                id="btnVerInventarioDyP"
                                                type="button"
                                                class="btn btn-success"
                                                style="margin-left:15px">Ver Inventario</button></a>@endif
                                @if (isset($id_recepcion_ot) && $datosRecepcionOT->esInventariable())<a
                                       href="{{ route('inventarioVehiculo.index', ['id_recepcion_ot' => $id_recepcion_ot]) }}"><button
                                                id="btnCompletarInventarioDyP"
                                                type="button"
                                                class="btn btn-danger"
                                                style="margin-left:15px">Completar Inventario</button></a>@endif
                            </div>
                        @endif
                        @if (isset($id_recepcion_ot)) @include('modals.historiaClinica', ['hojasTrabajoHC'
                            => $datosRecepcionOT->getHistoriaClinica()]) @endif
                    @endif
                    @if (isset($id_recepcion_ot) && $datosRecepcionOT->sePuedeGenerarLiquidacion(true) && ($totalServicios > 0 || count($listaRepuestosSolicitados) > 0 || count($listaServiciosTerceros) > 0))
                        <a href="{{ route('hojaLiquidacion', ['nro_ot' => $id_recepcion_ot, 'esPreliqui' => true]) }}"><button
                                    id="btnHojaPreliquidacion"
                                    type="button"
                                    class="btn btn-success"
                                    style="margin-left:15px">Generar Preliquidacion</button></a>
                    @endif
                </div>

            </div>
        </div>
    @endsection

    @section('table-content')
        <div id="containerDyP"
             class="mx-3"
             style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
            @if (session('asociarCotizacion'))
                <div class="modal fade show"
                     id="MensajeInicioModal"
                     tabindex="-1"
                     role="dialog"
                     aria-labelledby="MensajeLabel"
                     aria-hidden="true">
                    <div class="modal-dialog"
                         role="document">
                        <div class="modal-content">
                            <div class="modal-header fondo-sigma">
                                <h5 class="modal-title"
                                    id="MensajeLabel">Mensaje</h5>
                                <button type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Para continuar con la reparación, realice los ajustes correspondientes a la cotización y luego
                                asocie a la OT.
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('errorLiquidacion'))
                <div class="alert alert-danger"
                     role="alert">
                    {{ session('errorLiquidacion') }}
                </div>
            @endif
            <div class="mx-3"
                 style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
                <div class="table-responsive borde-tabla tableFixHead">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row col-12 justify-content-between">
                                <div>
                                    <h2>Mano de Obra</h2>
                                </div>
                                <div>
                                    @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                        @if (false && isset($listaOTsAsociables) && $listaOTsAsociables)
                                            @include('modals.cotizacionAsociarOT') @endif
                                        @if (false && isset($listaCotizacionesAsociables) && $listaCotizacionesAsociables)
                                            @include('modals.OTAsociarCotizacion') @endif
                                        <!-- <button id="btnEditarDetalleTrabajoDyP" type="button" class="btn btn-warning" style="margin-left:15px"></button> -->
                                        <button id="btnAgregarDetalleTrabajo"
                                                type="button"
                                                style="display: none; margin-left:15px"
                                                class="btn btn-warning">+</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="table-cont-single">
                            <form id="formDetallesTrabajo"
                                  method="POST"
                                  action="{{ route('detalle_trabajos.store') }}"
                                  autocomplete="off"
                                  onkeydown="return event.key != 'Enter';">
                                @csrf
                                @isset($id_cotizacion)
                                    <input type="hidden"
                                           name="cotizacion"
                                           value="1">
                                @endisset
                                @foreach ($listaRepuestosSolicitados as $repuestoSolicitado)
                                    <input type="hidden"
                                           name="desc_dealer-{{ $repuestoSolicitado->id_item_necesidad_repuestos }}"
                                           id="desc-dealer-{{ $repuestoSolicitado->id_item_necesidad_repuestos }}"
                                           value="{{ $repuestoSolicitado->descuento_unitario_dealer }}">
                                @endforeach
                                @if (isset($id_recepcion_ot))
                                    <input name="id_recepcion_ot"
                                           type="hidden"
                                           value="{{ $id_recepcion_ot }}">
                                @elseif(isset($id_cotizacion))
                                    <input name="id_cotizacion"
                                           type="hidden"
                                           value="{{ $id_cotizacion }}">
                                @endif
                                <table id="tablaDetallesTrabajo"
                                       class="table text-center table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">CODIGO OPERACION</th>
                                            <th scope="col">DESCRIPCION</th>
                                            <th scope="col">UNIDADES</th>
                                            @if (isset($id_cotizacion) || isset($id_recepcion_ot))
                                                <th scope="col">DESCUENTO</th>
                                                <th scope="col">PVP</th>
                                            @endif
                                            <!-- <th id="thEditarDetalleTrabajo" scope="col" style="display:none">EDITAR</th> -->
                                            @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                <th id="thEliminarDetalleTrabajo"
                                                    scope="col"
                                                    style="display:none">ELIMINAR</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listaDetallesTrabajo as $detalleTrabajo)
                                            <tr id="tdDetalleTrabajo-{{ $detalleTrabajo->id_operacion_trabajo }}">
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $detalleTrabajo->operacionTrabajo->cod_operacion_trabajo }}</td>
                                                <td>{{ $detalleTrabajo->getNombreDetalleTrabajo() }}</td>
                                                <td class="form-group form-inline justify-content-center mb-0">

                                                    @if ($detalleTrabajo->unidadPre())<label
                                                               id="unidadTablaDetalleTrabajoPre-{{ $detalleTrabajo->id_detalle_trabajo }}">{{ $detalleTrabajo->getUnidad() }}</label>
                                                    @endif
                                                    @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                        <input value="{{ $detalleTrabajo->valor_trabajo_estimado }}"
                                                               id="inputActualizarDetalleTrabajoValor-{{ $detalleTrabajo->id_detalle_trabajo }}"
                                                               form="formDetallesTrabajo"
                                                               name="inputActualizarDetalleTrabajoValor-{{ $detalleTrabajo->id_detalle_trabajo }}"
                                                               data-validation="required number"
                                                               data-validation-allowing="float"
                                                               class="form-control"
                                                               style="width: 60px; margin: 0px 5px; text-align: center;"
                                                               data-validation-error-msg=" ">
                                                    @else
                                                        <span
                                                              style="margin: 0px 5px;">{{ number_format($detalleTrabajo->valor_trabajo_estimado, 2) }}</span>
                                                    @endif
                                                    @if (!$detalleTrabajo->unidadPre())<label
                                                               id="unidadDetalleTrabajoPost-{{ $detalleTrabajo->id_detalle_trabajo }}">{{ $detalleTrabajo->getUnidad() }}</label>
                                                    @endif

                                                </td>
                                                @if (isset($id_cotizacion) || isset($id_recepcion_ot))
                                                    <td>{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }}
                                                        {{ $detalleTrabajo->getDescuento($monedaCalculos) }}</td>
                                                    <td>{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }}
                                                        {{ $detalleTrabajo->getSubTotal($monedaCalculos) }}</td>
                                                @endif
                                                <!-- <td id="tdEditarDetalleTrabajo-{{ $detalleTrabajo->id_operacion_trabajo }}" style="display:none"><button type="button" class="btn btn-warning"><i class="fas fa-info-circle icono-btn-tabla"></i></button></td> -->
                                                @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                    <td id="tdEliminarDetalleTrabajo-{{ $detalleTrabajo->id_operacion_trabajo }}"
                                                        style="display:none">
                                                        <div id="formEliminarDetalleTrabajo"
                                                             method="POST"
                                                             actionForm="{{ route('detalle_trabajos.destroy', ['id_detalle_trabajo' => $detalleTrabajo->id_detalle_trabajo]) }}">
                                                            @csrf
                                                            <button id="btnEliminarDetalleTrabajo-{{ $detalleTrabajo->id_detalle_trabajo }}"
                                                                    class="btn btn-warning"
                                                                    type="button"><i
                                                                   class="fas fa-trash icono-btn-tabla"></i></button>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="p-0 mt-4">
                    @if (isset($id_recepcion_ot) || isset($id_cotizacion))
                        <div class="col-xl-12 p-0">

                            <div class="table-responsive borde-tabla tableFixHead">
                                <div class="table-wrapper">
                                    <div class="table-title">
                                        <div class="row col-12 justify-content-between">
                                            <div>
                                                <h2>Repuestos</h2>
                                            </div>
                                            @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                <div>
                                                    @if (isset($id_recepcion_ot) || isset($id_cotizacion))
                                                        @include('modals.generarSolicitudRepuestos') @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="verRepuestosContent"
                                         class="table-cont-single">
                                        <div class="table-responsive"
                                             style="max-height: 400px;">
                                            <div class="table-wrapper"
                                                 style="min-width: 700px;">
                                                @if ($listaRepuestosSolicitados)
                                                    <table class="table text-center table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">NÚMERO DE PARTE</th>
                                                                <th scope="col">DESCRIPCION</th>
                                                                <th scope="col">CANTIDAD</th>
                                                                <th scope="col">DISPONIBILIDAD</th>
                                                                @if (isset($id_cotizacion) || isset($id_recepcion_ot))
                                                                    <th scope="col">DSCTO. MARCA</th>
                                                                    <th scope="col">DSCTO. DEALER</th>
                                                                    <th scope="col">DESCUENTO</th>
                                                                    <th scope="col">PRECIO VENTA</th>
                                                                    <th scope="col">MARGEN DEALER</th>
                                                                @endif
                                                                @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                                    <th id="thEliminarRepuesto"
                                                                        scope="col">ELIMINAR</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($listaRepuestosSolicitados as $repuestoSolicitado)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $repuestoSolicitado->getRepuestoNroParteTexto() }}
                                                                    </td>
                                                                    <td>{{ $repuestoSolicitado->getDescripcionRepuestoTexto() }}
                                                                    </td>
                                                                    <td>{{ $repuestoSolicitado->getCantidadRepuestosTexto() }}
                                                                    </td>
                                                                    <td>{{ $repuestoSolicitado->getDisponibilidad() }}</td>
                                                                    @if (isset($id_cotizacion) || isset($id_recepcion_ot))
                                                                        <td>{{ $repuestoSolicitado->descuento_unitario ?? 0 }}%
                                                                        </td>
                                                                        <td>
                                                                            @if ($repuestoSolicitado->getRepuestoNroParteTexto() == '' || $repuestoSolicitado->getRepuestoNroParteTexto() == '-')
                                                                                @php $disabled = 'disabled' @endphp
                                                                            @elseif($estadoOT=='liquidado' ||
                                                                                $estadoOT=='facturado')
                                                                                @php $disabled = 'disabled' @endphp
                                                                            @else
                                                                                @php $disabled = '' @endphp
                                                                            @endif
                                                                            {{ $repuestoSolicitado->getDescPorcentajeDealer($repuestoSolicitado->descuento_unitario_dealer ?? -1) * 100 }}%
                                                                        </td>
                                                                        <td>{{ $repuestoSolicitado->id_repuesto ? App\Helper\Helper::obtenerUnidadMoneda($moneda) : '' }}
                                                                            {{ $repuestoSolicitado->id_repuesto ? number_format($repuestoSolicitado->getDescuentoTotal($repuestoSolicitado->getFechaRegistroCarbon(), true, $repuestoSolicitado->descuento_unitario ?? 0, $repuestoSolicitado->descuento_unitario_dealer ?? -1), 2) : '-' }}
                                                                        </td>
                                                                        <td>{{ $repuestoSolicitado->id_repuesto ? App\Helper\Helper::obtenerUnidadMoneda($moneda) : '' }}
                                                                            {{ $repuestoSolicitado->id_repuesto ? number_format($repuestoSolicitado->getMontoVentaTotal($repuestoSolicitado->getFechaRegistroCarbon(), true, $repuestoSolicitado->descuento_unitario ?? 0, false, $repuestoSolicitado->descuento_unitario_dealer ?? -1), 2) : '-' }}
                                                                        </td>
                                                                        @if (isset($repuestoSolicitado->repuesto))
                                                                            <td>{{ $repuestoSolicitado->getMargenDealer($repuestoSolicitado->descuento_unitario_dealer ?? -1, $repuestoSolicitado->repuesto->margen) }}
                                                                            </td>
                                                                        @else
                                                                            <td>
                                                                                -
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                    @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                                        @if (!$repuestoSolicitado->entregado)

                                                                            <td
                                                                                id="tdEliminarRepuesto-{{ $repuestoSolicitado->id_item_necesidad_repuestos }}">
                                                                                <form method="POST"
                                                                                      action="{{ route('detalle_repuestos.destroy', ['id_item_necesidad_repuestos' => $repuestoSolicitado->id_item_necesidad_repuestos]) }}">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                           name="_method"
                                                                                           value="DELETE">
                                                                                    <button id="btnEliminarRepuesto-{{ $repuestoSolicitado->id_item_necesidad_repuestos }}"
                                                                                            type="submit"
                                                                                            class="btn btn-warning"><i
                                                                                           class="fas fa-trash icono-btn-tabla"></i></button>
                                                                                </form>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    SIN REPUESTOS SOLICITADOS
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 p-0 mt-3">
                            <div class="table-responsive borde-tabla tableFixHead">
                                <div class="table-wrapper">
                                    <div class="table-title">
                                        <div class="row col-12 justify-content-between">
                                            <div>
                                                <h2>Servicios Terceros</h2>
                                            </div>
                                            @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                <div>
                                                    <button id="btnAgregarServicioTercero"
                                                            type="button"
                                                            style="margin-left:15px"
                                                            class="btn btn-warning">+</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="verServiciosTercerosContent"
                                         class="table-cont-single">
                                        <div class="table-responsive"
                                             style="max-height: 400px;">
                                            <div class="table-wrapper"
                                                 style="min-width: 700px;">
                                                <table id="tablaServiciosTerceros"
                                                       @if (isset($id_cotizacion)) esCotizacion="true" @else esCotizacion="false" @endif
                                                       class="table text-center table-striped table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">CÓDIGO</th>
                                                            <th scope="col">DESCRIPCIÓN</th>
                                                            @if (!isset($id_cotizacion))
                                                                <th scope="col">PROVEEDOR</th>
                                                                <th scope="col">NRO OS</th>
                                                            @endif
                                                            <th scope="col">DESCUENTO</th>
                                                            <th scope="col">PVP</th>
                                                            @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                                <th id="thEliminarServicioTercero"
                                                                    scope="col">ELIMINAR</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($listaServiciosTerceros as $servicioTercero)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $servicioTercero->getCodigoServicioTercero() }}</td>
                                                                <td>{{ $servicioTercero->getDescripcion() }}</td>
                                                                @if (!isset($id_cotizacion))
                                                                    <td>
                                                                        @if (!is_null($servicioTercero->id_proveedor))
                                                                            {{ $servicioTercero->getNombreProveedor() }}
                                                                        @else <input class="form-control typeahead"
                                                                                   autocomplete="off"
                                                                                   tipo="proveedores"
                                                                                   form="formDetallesTrabajo"
                                                                                   name="inputActualizarProveedor-{{ $servicioTercero->id_servicio_tercero_solicitado }}"
                                                                                   id="actualizarProveedor-{{ $servicioTercero->id_servicio_tercero_solicitado }}"
                                                                                   style=" display: block; height: 100%; width: 100%; box-sizing: border-box;">
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $servicioTercero->obtenerOrdenServicio() }}</td>
                                                                @endif
                                                                <td>
                                                                    {{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }}
                                                                    @if (!is_null($servicioTercero->servicioTercero->pvp))
                                                                        {{ $servicioTercero->getDescuento($monedaCalculos) }}
                                                                    @elseif(is_null($servicioTercero->servicioTercero->pvp)
                                                                        && is_null($servicioTercero->pvp_libre)) -
                                                                    @elseif(is_null($servicioTercero->servicioTercero->pvp)
                                                                        && !is_null($servicioTercero->pvp_libre)) -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }}
                                                                    @if (!is_null($servicioTercero->servicioTercero->pvp))
                                                                        {{ $servicioTercero->getPrecioVenta($monedaCalculos) }}
                                                                    @elseif(is_null($servicioTercero->servicioTercero->pvp)
                                                                        && is_null($servicioTercero->pvp_libre))<input
                                                                               class="form-control"
                                                                               form="formDetallesTrabajo"
                                                                               name="inputActualizarPVP-{{ $servicioTercero->id_servicio_tercero_solicitado }}"
                                                                               id="actualizarPVP-{{ $servicioTercero->id_servicio_tercero_solicitado }}"
                                                                               style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                               @if (!isset($id_cotizacion) && $servicioTercero->obtenerOrdenServicio() === '-') disabled @endif>
                                                                    @elseif(is_null($servicioTercero->servicioTercero->pvp)
                                                                        &&
                                                                        !is_null($servicioTercero->pvp_libre)){{ $servicioTercero->pvp_libre }}
                                                                    @endif
                                                                </td>
                                                                @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                                                    <td
                                                                        id="tdEliminarServicioTercero-{{ $servicioTercero->id_servicio_tercero_solicitado }}">
                                                                        <form method="POST"
                                                                              action="{{ route('servicios_terceros.destroy', ['id_servicio_tercero_solicitado' => $servicioTercero->id_servicio_tercero_solicitado]) }}">
                                                                            @csrf
                                                                            <input type="hidden"
                                                                                   name="_method"
                                                                                   value="DELETE">
                                                                            <button id="btnEliminarServicioTercero-{{ $servicioTercero->id_servicio_tercero_solicitado }}"
                                                                                    type="submit"
                                                                                    class="btn btn-warning"
                                                                                    @if ($servicioTercero->obtenerOrdenServicio() != '-') disabled @endif><i
                                                                                   class="fas fa-trash icono-btn-tabla"></i></button>
                                                                        </form>
                                                                    </td>
                                                                @endif
                                                            </tr>

                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($id_cotizacion) || isset($id_recepcion_ot))
                        <div>
                            <div class="container py-3">
                                <div class="row">
                                    <div class="mx-auto col-sm-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header"
                                                 style="background-color: #435e7c;">
                                            <h4 class="mb-0 text-white">Totales @if (isset($id_cotizacion)) Cotización @else OT
                                                    @endif
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group form-inline row">
                                                    <label class="col-sm-5 col-form-label form-control-label justify-content-end"
                                                           for="totalServicios">MO: </label>
                                                    <div class="col-sm-7">
                                                        <input id="totalServicios"
                                                               class="form-control w-100"
                                                               type="text"
                                                               value="{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }} {{ $totalServicios }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline row">
                                                    <label class="col-sm-5 col-form-label form-control-label justify-content-end"
                                                           for="totalRepuestos">REPUESTOS: </label>
                                                    <div class="col-sm-7">
                                                        <input id="totalRepuestos"
                                                               class="form-control w-100"
                                                               type="text"
                                                               value="{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }} {{ $totalRepuestos }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline row">
                                                    <label class="col-sm-5 col-form-label form-control-label justify-content-end"
                                                           for="totalServiciosTerceros">TERCEROS: </label>
                                                    <div class="col-sm-7">
                                                        <input id="totalServiciosTerceros"
                                                               class="form-control w-100"
                                                               type="text"
                                                               value="{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }} {{ $totalServiciosTerceros }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline row">
                                                    <label class="col-sm-5 col-form-label form-control-label justify-content-end"
                                                           for="totalDescuentos">DSCTO MARCA: </label>
                                                    <div class="col-sm-7">
                                                        <input style="color:red!important;"
                                                               id="totalDescuentos"
                                                               class="form-control w-100"
                                                               type="text"
                                                               value="{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }} {{ $totalDescuentoMarca }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline row">
                                                    <label class="col-sm-5 col-form-label form-control-label justify-content-end"
                                                           for="totalDescuentos">DSCTO DEALER: </label>
                                                    <div class="col-sm-7">
                                                        <input style="color:red!important;"
                                                               id="totalDescuentos"
                                                               class="form-control w-100"
                                                               type="text"
                                                               value="{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }} {{ $totalDescuentoDealer }}"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline row">
                                                    <label class="col-sm-5 col-form-label form-control-label justify-content-end"
                                                       for="totalCotizacion">PRECIO FINAL @if (isset($id_cotizacion)) Cotización @else OT
                                                        @endif : </label>
                                                    <div class="col-sm-7">
                                                        <input id="totalCotizacion"
                                                               class="form-control w-100"
                                                               type="text"
                                                               value="{{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }} {{ $totalCotizacion }}"
                                                               disabled>
                                                    </div>
                                                </div>

                                                @if (isset($id_recepcion_ot) && $datosRecepcionOT->sePuedeGenerarLiquidacion() && ($totalServicios > 0 || count($listaRepuestosSolicitados) > 0 || count($listaServiciosTerceros) > 0))
                                                    @if ($datosRecepcionOT->esGarantia())
                                                        @include('modals.entregarVehiculo')
                                                    @else
                                                        @include('modals.generarLiquidacion')
                                                    @endif

                                                @endif

                                                @if (isset($id_recepcion_ot) && in_array($datosRecepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno, ['liquidado', 'liquidado_hotline', 'entregado', 'entregado_hotline', 'garantia_cerrado']))
                                                    @if ($estadoOT === 'garantia_cerrado')
                                                        <div class="form-group form-inline row"
                                                             style="display: flex;justify-content:center;">
                                                            <a href="{{ route('hojaEntrega', ['id_recepcion_ot' => $id_recepcion_ot]) }}"
                                                               target="_blank">
                                                                <button id="btnNotaEntrega"
                                                                        type="button"
                                                                        class="btn btn-success"
                                                                        style="margin-left:15px">Imprimir Nota de
                                                                    Entrega</button>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="form-group form-inline row"
                                                             style="display: flex;justify-content:center;">
                                                            <a
                                                               href="{{ route('hojaLiquidacion', ['nro_ot' => $id_recepcion_ot]) }}"><button
                                                                        id="btnImprimirLiquidacion"
                                                                        type="button"
                                                                        class="btn btn-success"
                                                                        style="margin-left:15px">Imprimir
                                                                    Liquidacion</button></a>
                                                        </div>
                                                    @endif
                                                    <div class="text-right">{{ Helper::mensajeIncluyeIGV() }}</div>
                                                @endIf
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-xl-12 p-0 mt-3">

                        <div class="row justify-content-between m-0">
                            @if ((isset($esEditableOT) && $esEditableOT) || (isset($esEditableCot) && $esEditableCot))
                                @if (!isset($id_recepcion_ot) && !isset($id_cotizacion))
                                    <div><button id="btnGuardarHojaTrabajo"
                                                value="Submit"
                                                type="submit"
                                                form="formDetallesTrabajo"
                                                style="display: none; margin-left:15px"
                                                class="btn btn-warning">Finalizar registro</button></div>
                                @else
                                    <div><button id="btnGuardarHojaTrabajo"
                                                value="Submit"
                                                type="submit"
                                                form="formDetallesTrabajo"
                                                style="display: none; margin-left:15px"
                                                class="btn btn-warning">Guardar</button></div>
                                @endif
                                @if (isset($id_recepcion_ot)) @include('modals.cerrarOT') @endif
                                @if (isset($id_cotizacion)) @include('modals.cerrarCotizacion')
                                @endif
                                @if (isset($id_cotizacion))
                                    <div class="btn-group"
                                         role="group">
                                        <button id="btnGroupDrop1"
                                                type="button"
                                                class="btn btn-warning dropdown-toggle ml-2"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                            Imprimir Cotización
                                        </button>
                                        <div class="dropdown-menu"
                                             aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item"
                                               href="{{ route('hojaCotizacion', ['nro_cotizacion' => $id_cotizacion, 'incluyeIGV' => true]) }}">Con
                                                IGV</a>
                                            <a class="dropdown-item"
                                               href="{{ route('hojaCotizacion', ['nro_cotizacion' => $id_cotizacion, 'incluyeIGV' => false]) }}">Sin
                                                IGV</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if (isset($id_recepcion_ot)) <a
                                   href="{{ route('hojaOT', ['nro_ot' => $id_recepcion_ot]) }}"><button id="btnHojaOT"
                                            type="button"
                                            class="btn btn-success"
                                            style="margin-left:15px">Imprimir OT</button></a> @endif
                            @if (isset($id_recepcion_ot) && in_array($datosRecepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno, ['liquidado', 'liquidado_hotline', 'garantia_cerrado']))
                                @include('modals.confirmarReAbrirOT')
                            @endif
                        </div>
                    </div>
                </div>

                <div style="display:none">
                    <input id="cant_items"
                           name="cant_items"
                           type="hidden"
                           value="{{ count($listaRepuestosSolicitados) + count($listaServiciosTerceros) + count($listaDetallesTrabajo) }}">
                    <input id="id_recepcion_ot"
                           name="cant_items"
                           type="hidden"
                           value="{{ isset($id_recepcion_ot) ? $id_recepcion_ot : 0 }}">
                    <input id="id_cotizacion"
                           name="cant_items"
                           type="hidden"
                           value="{{ isset($id_cotizacion) ? $id_cotizacion : 0 }}">

                </div>

            </div>
        @endsection

        @section('extra-scripts')
            @parent
            <script src="{{ asset('js/detalleTrabajo.js') }}"></script>
            <script src="{{ asset('js/cerrarGarantia.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
            <script>
                function showAlert() {
                    return Swal.fire(
                        '',
                        `EXISTE UNA SOLICITUD EN PROCESO. SOLICITAR APROBACIÓN O RECHAZO PARA GENERAR UNA NUEVA SOLICITUD`,
                        'error'
                    )
                }
                $(document).ready(function() {
                    // alert($('#cant_items').val())
                    if ($('#cant_items').val() < 1 && $('#id_recepcion_ot').val() != 0) {
                        $('#cerrarOTModal').modal('toggle')
                    }
                    if ($('#cant_items').val() < 1 && $('#id_cotizacion').val() != 0) {
                        $('#cerrarCotizacionModal').modal('toggle')
                    }
                });
            </script>
        @endsection
