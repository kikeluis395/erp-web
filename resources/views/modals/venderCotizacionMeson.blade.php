<!-- Modal -->
<div class="modal fade" id="venderCotizacionModal" tabindex="-1" role="dialog" aria-labelledby="venderCotizacionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="venderCotizacionLabel">Vender Cotización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        ¿Está seguro de que se realizará la venta de la presente cotización?
        <form id="FormVenderCotizacion" method="POST" action="{{route('meson.venderCotizacion', $idCotizacion)}}" value="Submit" autocomplete="off">
          @csrf
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnVenderOT" form="FormVenderCotizacion" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>