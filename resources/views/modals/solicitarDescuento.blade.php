<button type="button" class="btn btn-success btn-tabla" data-toggle="modal" data-target="#modalSolicitarDescuento" data-backdrop="static" style="margin-left:15px">
    @if(isset($id_recepcion_ot)) Solicitar Descuento
    @elseif(isset($id_cotizacion)) Colocar Descuento
    @endif
</button>
    <!-- Modal -->
<div class="modal fade" id="modalSolicitarDescuento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header fondo-sigma">
            <h5 class="modal-title">
                @if(isset($id_recepcion_ot)) Solicitar Descuento
                @elseif(isset($id_cotizacion)) Colocar Descuento
                @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
            <form id="FormSolicitarDescuento" method="POST" action="{{route('descuentos.store')}}" value="Submit" autocomplete="off">
                @csrf
                <input name="idHojaTrabajo" type="hidden" value="{{isset($datosHojaTrabajo) ? $datosHojaTrabajo->id_hoja_trabajo : null}}">
                <div class="form-group text-left ">
                    <div class="row"  style="align-items: center">
                        <label for="inputPorcentaje" class="col-4 ">MANO DE OBRA: </label>
                        <input name="porcentajeSolicitadoMO" type="text" class="form-control col-2 mr-1" id="inputPorcentajeMO" data-validation-optional-if-answered="porcentajeSolicitadoLubricantes, porcentajeSolicitadoRptos, porcentajeSolicitadoST" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de MO" data-validation-error-msg-container="#errorPorcentajeMO"> %
                        <div id="errorPorcentajeMO" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                        
                    </div>
                </div>

                <div class="form-group text-left">
                    <div class="row " style="align-items: center">
                        <label for="inputPorcentaje" class="col-4 ">LUBRICANTES: </label>
                        <input name="porcentajeSolicitadoLubricantes" type="text" class="form-control col-2 mr-1" id="inputPorcentajeLubricantes" data-validation-optional-if-answered="porcentajeSolicitadoMO, porcentajeSolicitadoRptos, porcentajeSolicitadoST" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de lubricantes" data-validation-error-msg-container="#errorPorcentajeLubricantes"> %
                        
                        <a href="#" id="moreLubricants" onClick="showMoreLubricants()" class="link-success fas fa-eye col-2 mr-1"></a>
                    
                        <a href="#" id="lessLubricants" onClick="showLessLubricants()" style="display:none" class="fas fa-eye-slash  link-danger col-2 mr-1"> </a>
                    
                        <a href="#" class="fas fa-plus" onClick="applyDiscountLubricants()"> Aplicar a todos</a>

                        <div id="listLubricants" style="display:none">
                            <table class="table text-center table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th> Repuesto</th>
                                        <th> DSCTO. Dealer</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach ($listaRepuestosSolicitados as $repuestoSolicitado)
                                    <tr>
                                        @if($repuestoSolicitado->repuesto!=null)
                                        @if($repuestoSolicitado->repuesto->getNombreCategoria()=='LUBRICANTES')
                                        <td>{{$repuestoSolicitado->getDescripcionRepuestoTexto()}}</td>
                                        <td class="d-flex justify-content-center align-items-center">    
                                        <input type="text" class="descuento-lubricante form-control mr-2"
                                                id="item-necesidad-repuesto-{{ $repuestoSolicitado->id_item_necesidad_repuestos }}"
                                                name="dscto-dealer-{{$repuestoSolicitado->id_item_necesidad_repuestos}}"
                                                form="FormSolicitarDescuento"
                                                style="width: 60px"
                                                value="{{ $repuestoSolicitado->getDescPorcentajeDealer($repuestoSolicitado->descuento_unitario_dealer ?? -1) * 100 }}">%
                                        </td>
                                        @endIf
                                    @endIf
                                    </tr>
                                    @endforeach
                                    </tbody>
                            </table>      
                        </div>
                    </div>
                    
                    <div id="errorPorcentajeLubricantes" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
                <div class="form-group text-left">
                    <div class="row"  style="align-items: center">
                        <label for="inputPorcentaje" style="text-align:left" class="col-4 text-left" >REPUESTOS: </label>
                        <input id="inputPorcentajeRepuestos" name="porcentajeSolicitadoRptos" type="text" class="form-control col-2 mr-1" id="inputPorcentajeRPTOS" data-validation-optional-if-answered="porcentajeSolicitadoMO, porcentajeSolicitadoLubricantes, porcentajeSolicitadoST" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de repuestos" data-validation-error-msg-container="#errorPorcentajeRPTOS"> %                      
                        <a href="#" id="moreSpares" onClick="showMoreSpares()" class="link-success fas fa-eye col-2 mr-1"></a>
                        <a href="#" id="lessSpares" onClick="showLessSpares()" style="display:none" class="fas fa-eye-slash  link-danger col-2 mr-1"> </a>
                        <a href="#" class="fas fa-plus" onClick="applyDiscountSpares()"> Aplicar a todos</a>

                    </div>
                    <div id="listSpares" style="display:none">
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th> Repuesto</th>
                                    <th> DSCTO. Dealer</th>
                                </tr>
                            </thead>
                             <tbody> 
                                @foreach ($listaRepuestosSolicitados as $repuestoSolicitado)
                                <tr>
                                    @if($repuestoSolicitado->repuesto!=null)
                                        @if($repuestoSolicitado->repuesto->getNombreCategoria()!='LUBRICANTES')
                                        <td>{{$repuestoSolicitado->getDescripcionRepuestoTexto()}}</td>
                                        <td class="d-flex justify-content-center align-items-center">    
                                        <input type="text" class="descuento-repuesto form-control mr-2"
                                                id="item-necesidad-repuesto-{{ $repuestoSolicitado->id_item_necesidad_repuestos }}"
                                                name="dscto-dealer-{{$repuestoSolicitado->id_item_necesidad_repuestos}}"
                                                form="FormSolicitarDescuento"
                                                style="width: 60px"
                                                value="{{ $repuestoSolicitado->getDescPorcentajeDealer($repuestoSolicitado->descuento_unitario_dealer ?? -1) * 100 }}">%
                                        </td>
                                        @endIf
                                    @endIf
                                </tr>
                                 @endforeach
                                </tbody>
                        </table>      
                    </div>
                    <div id="errorPorcentajeRPTOS" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                
                </div>
                <div class="form-group  text-left">
                    <div class="row " style="align-items: center">
                    <label for="inputPorcentaje" class="col-4 ">S. TERCEROS: </label>
                    <input name="porcentajeSolicitadoST" type="text" class="form-control col-2 mr-1" id="inputPorcentajeST" data-validation-optional-if-answered="porcentajeSolicitadoMO, porcentajeSolicitadoLubricantes, porcentajeSolicitadoRptos" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de servicios terceros" data-validation-error-msg-container="#errorPorcentajeST"> %
                    </div>
                    <div id="errorPorcentajeST" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button id="btnRegistrarVehiculo" form="FormSolicitarDescuento" value="Submit" type="submit" class="btn btn-primary  button-disabled-when-cliked">
                @if(isset($id_recepcion_ot)) Solicitar
                @elseif(isset($id_cotizacion)) Colocar
                @endif
            </button>
        </div>
        </div>
    </div>
</div>

<script>

    function showMoreSpares() { 
            $('#moreSpares').css('display', 'none')
            $('#lessSpares').css('display', 'block')
            document.getElementById('listSpares').style.display = 'block';  
    }
    function showLessSpares() {
        $('#moreSpares').css('display', 'block')
        $('#lessSpares').css('display', 'none')
        document.getElementById('listSpares').style.display = 'none'; 
    }
    function showMoreLubricants() { 
            $('#moreLubricants').css('display', 'none')
            $('#lessLubricants').css('display', 'block')
            document.getElementById('listLubricants').style.display = 'block';  
    }
    function showLessLubricants() {
        $('#moreLubricants').css('display', 'block')
        $('#lessLubricants').css('display', 'none')
        document.getElementById('listLubricants').style.display = 'none'; 
    }



    function applyDiscountSpares() { 
        var discountPercentajeSpare = document.getElementById("inputPorcentajeRepuestos").value;
        $('.descuento-repuesto').val(discountPercentajeSpare);
    }

    function applyDiscountLubricants() { 
        var discountPercentajeLubricant = document.getElementById("inputPorcentajeLubricantes").value;
        $('.descuento-lubricante').val(discountPercentajeLubricant);
    }
</script>