<!-- Modal -->
<div class="modal fade" id="cerrarCotizacionModal" tabindex="-1" role="dialog" aria-labelledby="cerrarOTLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="cerrarOTLabel">Cerrar Cotización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormCerrarCotizacion" method="POST" action="{{route('meson.cerrarCotizacion', $idCotizacion)}}" value="Submit" autocomplete="off">
          @csrf
          <div class="form-group form-inline">
            <label for="razonIn" class="col-sm-6 justify-content-end">Razón:</label>
            <textarea name="razonCierre" type="text" class="form-control col-sm-6" id="razonIn" placeholder="Ingrese la razón de cierre" maxlength="128" rows="3"></textarea> 
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnCerrarOT" form="FormCerrarCotizacion" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>