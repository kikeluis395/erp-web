<button id="btnDetalleDescuento"
        type="button"
        class="btn btn-warning"
        data-toggle="modal"
        data-target="#detalleDescuento-{{ $index }}"
        data-backdrop="static"
        style="margin-left: 15px"><i class="fas fa-info-circle icono-btn-tabla"></i></button>
<!-- Modal -->
<div class="modal fade "
     id="detalleDescuento-{{ $index }}"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">{{ 'COTIZACIÓN ' . $cotizacionMeson->id_cotizacion_meson }}</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <table class="table text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">CODIGO</th>
                            <th scope="col">REPUESTO</th>
                            <th scope="col">PVP</th>
                            <th scope="col">DSCTO. MARCA</th>
                            <th scope="col">DSCTO. DEALER</th>
                            <th scope="col">DSCTO. TOTAL</th>
                            <th scope="col">P C/ DSCTO</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotizacionMeson->getItemsThatRequireDiscount() as $item)
                            <tr>
                                <th style="vertical-align: middle"
                                    scope="row">{{ $loop->iteration }}</th>
                                <th style="vertical-align: middle">{{ $item->getCodigoRepuesto() }}</th>
                                <td style="vertical-align: middle">{{ $item->getDescripcionRepuesto() }}</td>
                                <td style="vertical-align: middle">
                                    {{ App\Helper\Helper::obtenerUnidadMoneda($cotizacionMeson->moneda) }}
                                    {{ number_format($item->getMontoUnitarioGrupo($item->getFechaRegistroCarbon(), true), 2) }}
                                </td>
                                <td style="vertical-align: middle"> {{ $item->getDescuentoMarca() }}%</td>
                                <td style="vertical-align: middle"> {{ $item->descuento_unitario_dealer_por_aprobar }}%
                                </td>
                                <td style="vertical-align: middle">
                                    {{ number_format($item->getTotalDiscountToBeApproved(), 2) }}%</td>
                                <td style="vertical-align: middle">
                                    {{ App\Helper\Helper::obtenerUnidadMoneda($cotizacionMeson->moneda) }}
                                    {{ number_format($item->getPriceWithDiscountToBeApproved(), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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
