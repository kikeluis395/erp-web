<button id="btnDetalleDescuento"
        type="button"
        class="btn btn-warning"
        data-toggle="modal"
        data-target="#detalleDescuento-{{ $index }}"
        data-backdrop="static"
        style="margin-left: 15px"><i class="fas fa-info-circle icono-btn-tabla"></i></button>
<!-- Modal -->
<div class="modal fade"
     id="detalleDescuento-{{ $index }}"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">
                    {{ $descuento->hojaTrabajo->placa_auto . '- OT:' . $descuento->getIDFuenteDescuento() }}</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                @if (is_null($descuento->es_aprobado))
                    <table class="table text-center table-striped table-sm">
                        <tr>
                            <th></th>
                            <th>Porcentaje (%)</th>
                            <th align='center'>
                                {{ App\Helper\Helper::obtenerUnidadMoneda($descuento->hojaTrabajo->moneda) }}</th>
                        </tr>
                        <tr>
                            <th>Mano de Obra</th>
                            <td>{{ $descuento->porcentaje_aplicado_mo }}</td>
                            <td align='center'>
                                {{ $descuento->getMontoDescuentoMO(App\Helper\Helper::obtenerUnidadMonedaCalculo($descuento->hojaTrabajo->moneda)) }}
                            </td>
                        </tr>


                        <tr>
                            <th>Lubricantes</th>
                            <td>
                                @if ($descuento->hojaTrabajo->necesidadesRepuestos->count() > 0)
                                    @if ($descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2)->count() > 0)
                                        <button id="btnDetalleDescuento"
                                                type="button"
                                                class="btn btn-warning"
                                                data-toggle="modal"
                                                data-target="#detalleDescuentoUniLubri-{{ $index }}"
                                                data-backdrop="static"
                                                style="margin-left: 15px">VER </button>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $descuento->getMontoLubricantes() }}</td>
                        </tr>
                        <tr>
                            <th>Repuestos</th>
                            <td>
                                @if ($descuento->hojaTrabajo->necesidadesRepuestos->count() > 0)
                                    @if ($descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2)->count() > 0)
                                        <button id="btnDetalleDescuento"
                                                type="button"
                                                class="btn btn-warning"
                                                data-toggle="modal"
                                                data-target="#detalleDescuentoUni-{{ $index }}"
                                                data-backdrop="static"
                                                style="margin-left: 15px">VER </button>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $descuento->getMontoRepuestos() }}</td>
                        </tr>
                        <tr>
                            <th>Servicios Terceros</th>
                            <td>{{ $descuento->porcentaje_aplicado_servicios_terceros }}</td>
                            <td align='center'>
                                {{ $descuento->getMontoDescuentoServiciosTerceros(App\Helper\Helper::obtenerUnidadMonedaCalculo($descuento->hojaTrabajo->moneda)) }}
                            </td>
                        </tr>
                    </table>
                    <br>
                @endif

            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary"
                        data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


{{-- solo repuestos --}}
@if ($descuento->hojaTrabajo->necesidadesRepuestos->count() > 0)
    @if ($descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2)->count() > 0)
        @php
            $descuentos_unitarios = $descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2);
        @endphp
        <div class="modal fade"
             id="detalleDescuentoUni-{{ $index }}"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-xl"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">DETALLES DESCUENTOS UNITARIOS</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"
                         style="overflow-y: auto;">
                        <table class="w-100">
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">CÓDIGO</th>
                                <th scope="row">REPUESTO</th>
                                <th scope="row">P. REGULAR</th>
                                <th scope="row">DSCTO. MARCA</th>
                                <th scope="row">DSCTO. DEALER</th>
                                <th scope="row">DSCTO. TOTAL</th>
                                <th scope="row">P. C/ DSCTO</th>
                            </tr>
                            @php
                                $moneda = $descuento->hojaTrabajo->moneda;
                            @endphp
                            @foreach ($descuentos_unitarios as $item)
                                <tr>
                                    @if (!$item->repuesto->esLubricante())
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->repuesto->codigo_repuesto ?? '-' }}</td>
                                        <td>{{ $item->repuesto->descripcion ?? '-' }}{{ $item->moneda }}</td>
                                        <td>{{ Helper::obtenerUnidadMoneda($moneda) }}
                                            {{ number_format($item->getMontoUnitario($item->getFechaRegistroCarbon(), true), 2) }}
                                        </td>
                                        <td>{{ $item->descuento_unitario ?? '0' }}%</td>
                                        <td>{{ is_null($item->descuento_unitario_dealer_por_aprobar) ? '-' : $item->descuento_unitario_dealer_por_aprobar . '%' }}
                                        </td>
                                        <td>{{ $item->getPorcentajeAproximado($item->getFechaRegistroCarbon(), true, $item->descuento_unitario, $item->descuento_unitario_dealer_por_aprobar) }}
                                        </td>
                                        <td>{{ Helper::obtenerUnidadMoneda($moneda) }}
                                            {{ number_format($item->getMontoConDescMarcaDealer($item->getFechaRegistroCarbon(), true, $item->descuento_unitario, $item->descuento_unitario_dealer_por_aprobar), 2) }}
                                        </td>
                                    @endIf
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif



{{-- solo lubricantes --}}
@if ($descuento->hojaTrabajo->necesidadesRepuestos->count() > 0)
    @if ($descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2)->count() > 0)
        @php
            $descuentos_unitarios = $descuento->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos->where('descuento_unitario_dealer_aprobado', 2);
        @endphp
        <div class="modal fade"
             id="detalleDescuentoUniLubri-{{ $index }}"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-xl"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">DETALLES DESCUENTOS UNITARIOS</h5>
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"
                         style="overflow-y: auto;">
                        <table class="w-100">
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">CÓDIGO</th>
                                <th scope="row">REPUESTO</th>
                                <th scope="row">PRECIO VENTA</th>
                                <th scope="row">DSCT. MARCA</th>
                                <th scope="row">DSCT. DEALER</th>
                                <th scope="row">DSCT. TOTAL APROXIMADO</th>
                                <th scope="row">PRECIO VENTA FINAL</th>
                            </tr>
                            @php
                                $moneda = $descuento->hojaTrabajo->moneda;
                            @endphp
                            @foreach ($descuentos_unitarios as $item)
                                <tr>
                                    @if ($item->repuesto->esLubricante())
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->repuesto->codigo_repuesto ?? '-' }}</td>
                                        <td>{{ $item->repuesto->descripcion ?? '-' }}{{ $item->moneda }}</td>
                                        <td>{{ Helper::obtenerUnidadMoneda($moneda) }}
                                            {{ number_format($item->getMontoUnitario($item->getFechaRegistroCarbon(), true), 2) }}
                                        </td>
                                        <td>{{ $item->descuento_unitario ?? '0' }}%</td>
                                        <td>{{ is_null($item->descuento_unitario_dealer_por_aprobar) ? '-' : $item->descuento_unitario_dealer_por_aprobar . '%' }}
                                        </td>
                                        <td>{{ $item->getPorcentajeAproximado($item->getFechaRegistroCarbon(), true, $item->descuento_unitario, $item->descuento_unitario_dealer_por_aprobar) }}
                                        </td>
                                        <td>{{ Helper::obtenerUnidadMoneda($moneda) }}
                                            {{ number_format($item->getMontoConDescMarcaDealer($item->getFechaRegistroCarbon(), true, $item->descuento_unitario, $item->descuento_unitario_dealer_por_aprobar), 2) }}
                                        </td>
                                    @endIf
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
