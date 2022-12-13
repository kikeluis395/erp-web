<!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#registrarVehiculoModal" data-backdrop="static">
  Registrar Vehículo
</button> -->

<!-- Modal -->
<div class="modal fade"
     id="registrarVehiculoModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="registrarVehiculoLabel"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="registrarVehiculoLabel">Registrar Vehículo</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <form id="FormRegistrarVehiculo"
                      method="POST"
                      action="{{ route('registrarVehiculo') }}"
                      value="Submit"
                      autocomplete="off">
                    @csrf
                    @include('sections.formVehiculo')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Cerrar</button>
                <button id="btnRegistrarVehiculo"
                        form="FormRegistrarVehiculo"
                        value="Submit"
                        type="submit"
                        class="btn btn-primary">Registrar</button>
            </div>
        </div>
    </div>
</div>
