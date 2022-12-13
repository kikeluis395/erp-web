<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregarVehiculoModal" data-backdrop="static">
  Registrar Cotizacion
</button>

<!-- Modal -->
<div class="modal fade" id="agregarVehiculoModal" tabindex="-1" role="dialog" aria-labelledby="agregarVehiculoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="agregarVehiculoLabel">Registrar Cotizacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarRecepcion" method="POST" action="@if($departamento=='MECANICA') {{route('mecanica.cotizaciones.store')}} @else {{route('cotizaciones.store')}} @endif" value="Submit" autocomplete="off">
          @csrf
          @include('sections.formVehiculo')

          @include('sections.formCliente')

          <div class="form-group form-inline">
            <label for="observacionesIn" class="col-sm-6 justify-content-end">Observaciones</label>
            <textarea name="observaciones" type="text" class="form-control col-sm-6" id="observacionesIn" placeholder="Ingrese sus observaciones" maxlength="255" rows="5"></textarea> 
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnRegistrarRecepcion" form="FormRegistrarRecepcion" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>