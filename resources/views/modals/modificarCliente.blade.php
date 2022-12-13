<!-- Modal -->
<div class="modal fade" id="modificarClienteModal" tabindex="-1" role="dialog" aria-labelledby="modificarClienteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="modificarClienteLabel">Modificar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormModificarCliente" method="POST" action="{{route('modificarCliente')}}" value="Submit" autocomplete="off">
          @csrf
          @include('sections.formClienteModificar',["cliente"=>$cliente])
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnModificarCliente" form="FormModificarCliente" value="Submit" type="submit" class="btn btn-primary">Modificar</button>
      </div>
    </div>
  </div>
</div>