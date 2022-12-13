<button id="btnHistoriaClinica"
        type="button"
        class="btn btn-warning"
        data-toggle="modal"
        data-target="#historiaClinica"
        data-backdrop="static"
        style="margin-left: 15px">Historia Clínica</button>
<!-- Modal -->
<div class="modal fade"
     id="historiaClinica"
     tabindex="-1"
     role="dialog"
     aria-labelledby="historiaClinicaLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="historiaClinicaLabel">Historia Clínica</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div style="max-height: 50vh; overflow-y: auto"
                     class="tableFixHead">
                    @if ($hojasTrabajoHC->count() === 0)
                        Este vehículo no cuenta con una historia clínica
                    @else
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Sección</th>
                                    <th scope="col">OT</th>
                                    <th scope="col">Asesor</th>
                                    <th scope="col">KM</th>
                                    <th scope="col">Trabajo</th>
                                    <th scope="col">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hojasTrabajoHC as $hojaTrabajo)
                                    <tr>
                                        <td style="vertical-align: middle">{{ $hojaTrabajo->getFechaRecepcionFormat() }}
                                        </td>
                                        @if ($hojaTrabajo->getTipoTrabajo() == 'DYP')
                                            @php $seccion = 'B&P' @endphp
                                        @endif

                                        @if ($hojaTrabajo->getTipoTrabajo() == 'PREVENTIVO')
                                            @php $seccion = 'MEC' @endphp
                                        @endif
                                        <td style="vertical-align: middle">{{ $seccion }}</td>
                                        <td style="vertical-align: middle">{!! $hojaTrabajo->recepcionOT->getLinkDetalleHTML() !!}</td>
                                        <td style="vertical-align: middle">
                                            {{ $hojaTrabajo->empleado->nombreCompleto() }}</td>
                                        <td style="vertical-align: middle">{{ $hojaTrabajo->recepcionOT->kilometraje }}
                                            KM</td>

                                        <td style="padding:0">
                                            <table style="width:100%">
                                                @foreach ($hojaTrabajo->detallesTrabajo as $detalleTrabajo)
                                                    <tr style="background-color:transparent">
                                                        <td>
                                                        
                                                            {{ $detalleTrabajo->getNombreDetalleTrabajo() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>

                                        <td style="vertical-align: middle">{{ $hojaTrabajo->observaciones }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
