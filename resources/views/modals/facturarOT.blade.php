<!-- Modal -->
<div class="modal fade" id="facturarModal" tabindex="-1" role="dialog" aria-labelledby="facturarLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="facturarLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <div class="form-group col-12">
          <label for="observaciones_entregado">Observaciones</label>
          <textarea class="form-control" name="observaciones_entregado" id="observaciones_entregado" cols="30" rows="10"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="confirmarFactura" data-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>