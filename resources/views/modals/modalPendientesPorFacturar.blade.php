<button id="btnPendientePorFacturar"
        type="button"
        class="btn btn-warning"
        data-toggle="modal"
        data-target="#modalPendientesPorFacturar"
        data-backdrop="static"
        style="margin-left: 15px">PENDIENTES POR FACTURAR <i class="fas fa-info-circle icono-btn-tabla"></i></button>
<!-- Modal -->
<div class="modal fade "
     id="modalPendientesPorFacturar"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">PENDIENTES POR FACTURAR</h5>
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
                            <th scope="col">FECHA REGISTRO</th>
                            <th scope="col">SECCION</th>
                            <th scope="col">DOC REFERENCIA</th>
                            <th scope="col">N° DOCUMENTO</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">TOTAL</th>
                            
                            <th scope="col">FACTURAR</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendientesPorFacturar as $entregable)
                            <tr>
                                <th style="vertical-align: middle"
                                    scope="row">{{ $loop->iteration }}</th>
                                    @if(is_a($entregable,'App\Modelos\RecepcionOT'))
                                    <td>{{$entregable->hojaTrabajo->getFechaRecepcionFormat()}}</td>
                                    <td>{{$entregable->hojaTrabajo->tipo_trabajo=='DYP' ? 'B&P' : 'MEC'}}</td>
                                    <td>{!!$entregable->getLinkDetalleHTML()!!}</td>
                                    
                                    <td>{{$entregable->hojaTrabajo->getNumDocCliente()}}</td>
                                    <td>{{$entregable->hojaTrabajo->getNombreCliente()}}</td>
                                    
                                    <td>{{$entregable->tipoOT->nombre_tipo_ot}}</td>
                                    @if(false)<td><div class="cont-estado {{$entregable->claseEstado()}}">@if ($entregable->estadoActual()!=[]) {{$entregable->estadoActual()[0]->nombre_estado_reparacion}} @else - @endif</div></td>@endif
                                    
                                    <td>{{App\Helper\Helper::obtenerUnidadMoneda($entregable->hojaTrabajo->moneda)}} {{number_format($entregable->getMontoConSinDescuento(),2)}}</td>
                                    @if(false)<td>{{$entregable->getNombreCiaSeguro()}}</td>@endif
                                  @else
                                    <td>{{\Carbon\Carbon::parse($entregable->fecha_registro)->format('d/m/Y')}}</td>
                                    <td>MESÓN</td>
                                    <td>{!!$entregable->getLinkDetalleCotizacion()!!}</td>
                                    
                                    <td>{{$entregable->getNumDoc()}}</td>
                                    <td>{{$entregable->getNombreCliente()}}</td>
                                    
                                    <td>{{'-'}}</td>
                                    
                                    <td>{{App\Helper\Helper::obtenerUnidadMoneda($entregable->moneda)}} {{number_format($entregable->getValueDiscountedQuote2Approved(),2)}}</td>
                                  @endif

                                <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#confirmarEntregaModal-{{$loop->iteration}}" data-backdrop="static"><i class="fas fa-edit"></i></button></td>
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
