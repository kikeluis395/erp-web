<!-- Modal -->
<div class="modal fade" id="modificarVehiculoModal" tabindex="-1" role="dialog" aria-labelledby="modificarVehiculoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="modificarVehiculoLabel">Modificar Vehículo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormModificarVehiculo" method="POST" action="{{route('modificarVehiculo')}}" value="Submit" autocomplete="off">
          @csrf
          @include('sections.formVehiculoModificar',["vehiculo"=>$vehiculo])
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnModificarVehiculo" form="FormModificarVehiculo" value="Submit" type="submit" class="btn btn-primary">Modificar</button>
      </div>
    </div>
  </div>
</div>