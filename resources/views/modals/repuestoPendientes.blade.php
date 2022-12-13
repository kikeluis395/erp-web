<!-- Modal -->
<div class="modal fade" id="repuestosPendientesModal" tabindex="-1" role="dialog"
  aria-labelledby="repuestosPendientesLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="repuestosPendientesLabel">Repuestos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <table class="table">
          <thead>
            <tr>
              <th align="center">CÓDIGO</th>
              <th align="center">DESCRIPCIÓN</th>
              <th align="center">DISPONIBILIDAD</th>
              <th align="center">CANTIDAD</th>
              <th align="center">SUB TOTAL</th>
              <th align="center">IMPUESTO</th>
              <th align="center">TOTAL</th>
            </tr>
          </thead>
          <tbody id="repuestoPendientesBody">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>