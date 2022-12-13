<div class="form-group form-inline row" style="display: flex;justify-content:center;">
    <button type="button" class="btn btn-success btn-tabla" data-toggle="modal" data-target="@if(isset($nombreCiaSeguro) && ($nombreCiaSeguro != 'PARTICULAR') && ($nombreCiaSeguro != '') && $datosRecepcionOT->esEditableOt()) #modalGenerarLiquidacion @else #modalAceptarLiquidacion @endif" data-backdrop="static">
        Generar Liquidacion
    </button>
</div>
    <!-- Modal -->
<div class="modal fade" id="modalGenerarLiquidacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header fondo-sigma">
            <h5 class="modal-title">
                Generar Liquidacion
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
            <form id="FormGenerarLiquidacion" method="GET" action="{{route('hojaLiquidacion')}}" value="Submit" autocomplete="off">
                
                <input name="nro_ot" type="hidden" value="{{$id_recepcion_ot}}">
                <div class="form-group form-inline">
                    <label class="col-sm-6 justify-content-end text-right">Seguro: </label>
                    <input class="form-control col-sm-5 mr-1" value="{{$nombreCiaSeguro}}" disabled>
                    <div id="errorPorcentajeMO" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                @if($datosHojaTrabajo->getSumaHorasCarroceria() > 0)
                <div class="form-group form-inline">
                    <label for="costoCar" class="col-sm-6 justify-content-end text-right">Carrocería: </label>
                    <input name="costoCar" type="text" class="form-control col-sm-5 mr-1" id="costoCar" data-validation="required number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el monto sin IGV para carroceria del seguro" data-validation-error-msg-container="#errorCar" placeholder="Ingrese el monto sin IGV para carroceria">
                    <div id="errorCar" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                @endif
                @if($datosHojaTrabajo->getSumaPanhosPintura() > 0)
                <div class="form-group form-inline">
                    <label for="costoPanhos" class="col-sm-6 justify-content-end text-right">Pintura: </label>
                    <input name="costoPanhos" type="text" class="form-control col-sm-5 mr-1" id="costoPanhos" data-validation="required number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el monto sin IGV para pintura del seguro" data-validation-error-msg-container="#errorPanhos" placeholder="Ingrese el monto sin IGV para pintura">
                    <div id="errorPanhos" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                @endif
                @if($datosHojaTrabajo->getSumaHorasMecanicaColision() > 0)
                <div class="form-group form-inline">
                    <label for="costoColi" class="col-sm-6 justify-content-end text-right">Mec. Colisión: </label>
                    <input name="costoColi" type="text" class="form-control col-sm-5 mr-1" id="costoColi" data-validation="required number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el monto sin IGV para colision del seguro" data-validation-error-msg-container="#errorColi" placeholder="Ingrese el monto sin IGV para colision">
                    <div id="errorColi" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                @endif
                <div class="form-group form-inline">
                    <label class="col-sm-6 justify-content-end text-right">Deducible: </label>
                    <div class="custom-control custom-switch col-sm-5 text-left" >
                        <input name="esPorcentaje" type="checkbox" class="custom-control-input" id="montoClienteSwitch">
                        @if($datosHojaTrabajo->moneda=="SOLES") 
                        <label class="custom-control-label" for="montoClienteSwitch" style="width:fit-content;">En Soles</label>
                        @elseif($datosHojaTrabajo->moneda=="DOLARES")
                        <label class="custom-control-label" for="montoClienteSwitch" style="width:fit-content;">En Dolares</label>
                        @endif
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label class="col-sm-6 justify-content-end text-right"></label>
                    <input name="costoCliente" type="text" class="form-control col-sm-5 mr-1" id="costoCliente" data-validation="required number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el monto sin IGV para el deducible" data-validation-error-msg-container="#errorCliente" placeholder="Ingrese el monto sin IGV para deducible">
                    <label id="labelPorcentaje">%</label>
                    <div id="errorCliente" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                <div class="form-group form-inline">
                    <label for="tipoMoneda" class="col-sm-6 justify-content-end text-right">Moneda: </label>
                    <select id="tipoMoneda" name="moneda" class="form-control col-sm-5 mr-1 w-100" disabled>
                                        <option value="SOLES" @if($datosHojaTrabajo->moneda=="SOLES") selected @endif>Soles</option>
                                        <option value="DOLARES" @if($datosHojaTrabajo->moneda=="DOLARES") selected @endif>Dólares</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button id="btnGenerarLiquidacion" form="FormGenerarLiquidacion" value="Submit" type="submit" class="btn btn-primary">
                Generar
            </button>
        </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAceptarLiquidacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Generar Liquidacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                <form id="FormAceptarLiquidacion" method="GET" action="{{route('hojaLiquidacion')}}" value="Submit" target="_blank">
                    <input name="nro_ot" type="hidden" value="{{$id_recepcion_ot}}">
                </form>
                ¿Está seguro que desea generar la liquidacion de la OT?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnAceptarLiquidacion" form="FormAceptarLiquidacion" value="Submit" type="submit" class="btn btn-primary" >Confirmar</button>
            </div>
        </div>
    </div>
</div>

@section('extra-scripts')
  @parent
  <script src="{{asset('js/modalLiquidacion.js')}}"></script>
@endsection