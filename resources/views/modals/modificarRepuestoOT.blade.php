<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modificarRepuestoModal-{{$repuesto->id_item_necesidad_repuestos}}" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
<!-- Modal -->
<div class="modal fade" id="modificarRepuestoModal-{{$repuesto->id_item_necesidad_repuestos}}" tabindex="-1" role="dialog" aria-labelledby="modificarRepuestoLabel-{{$repuesto->id_item_necesidad_repuestos}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="modificarRepuestoLabel-{{$repuesto->id_item_necesidad_repuestos}}">Modificar Repuesto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormModificarRepuesto-{{$repuesto->id_item_necesidad_repuestos}}" method="POST" action="{{route('detalle_repuestos.update')}}" value="Submit" autocomplete="off">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" style="width:150px" id="id-{{$repuesto->id_item_necesidad_repuestos}}" name="id_item_necesidad_repuestos" value="{{$repuesto->id_item_necesidad_repuestos}}">
          @include('sections.formModificarRepuestoOT')
          {{-- <button method="POST" formaction="{{route('detalle_repuestos.update')}}" value="Submit" type="submit" class="btn btn-primary button-disabled-when-cliked">Confirmar entrega</button> --}}
          <div class="row justify-content-between pl-2 pr-2 ">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary button-disabled-when-cliked">Confirmar</button>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>