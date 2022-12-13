<!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#registrarClienteModal" data-backdrop="static">
  Registrar Cliente
</button> -->

<!-- Modal -->
<div class="modal fade" id="registrarClienteModal" tabindex="-1" role="dialog" aria-labelledby="registrarClienteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="registrarClienteLabel">Registrar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarCliente" method="POST" action="{{route('administracion.clientes.store')}}" value="Submit" autocomplete="off">
          @csrf
          @include('sections.formClienteCotizacion')
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnRegistrarCliente" form="FormRegistrarCliente" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>