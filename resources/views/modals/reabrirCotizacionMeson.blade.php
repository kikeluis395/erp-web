<!-- Modal -->
<div class="modal fade" id="reabrirCotizacionModal" tabindex="-1" role="dialog" aria-labelledby="cerrarOTLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="cerrarOTLabel">Reabrir Cotización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormReabrirCotizacion" method="POST" action="{{route('meson.reabrirCotizacion', $idCotizacion)}}" value="Submit" autocomplete="off">
          @csrf
          @method('DELETE')
          <p>¿Desea reabrir esta cotización?</p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnReabrirOT" form="FormReabrirCotizacion" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>