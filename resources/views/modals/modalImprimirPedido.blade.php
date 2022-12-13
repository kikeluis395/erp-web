
@if($necesidadRepuestos->getEstadoNecesidad() == 'ENTREGADO')
<a href="{{route('hojaRepuestos',['idNecesidadRepuestos' => $necesidadRepuestos->id_necesidad_repuestos])}}" target="_blank"><button id="btnHojaRepuestos" type="button" class="btn btn-success" style="margin-left:20px">Imprimir Pedido</button></a>
@else
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#imprimirPedidoModal" data-backdrop="static">Entregar Pedido</button>
@endIf

<div class="modal fade" id="imprimirPedidoModal" tabindex="-3" role="dialog" aria-hidden="true" style="z-index:2000">
    <div class="modal-dialog  modal-sm" >
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Entregas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                <form id="formImprimirPedido" method="GET" action="{{route('hojaRepuestos')}}" value="Submit" autocomplete="off">
                <h5>Entregado a</h5>
                <input id="entregado_a" name="entregado_a" type="text" >
                <input style="display:none" id="idNecesidadRepuestos" name="idNecesidadRepuestos" type="text" value="{{$necesidadRepuestos->id_necesidad_repuestos}}">
                </form>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-backdrop="static" data-dismiss="modal">No</button>                        
                <button id="btnPrintOrder" class="btn btn-success"  type="submit" form="formImprimirPedido" type="button" class="btn btn-primary button-disabled-when-cliked">Imprimir</button> 
            </div>
        </div>
    </div>
</div>