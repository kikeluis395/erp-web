<!-- Modal -->
<div class="modal fade" id="clienteFacturacionModal" tabindex="-1" role="dialog"
  aria-labelledby="clienteFacturacionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="clienteFacturacionLabel">OTs / MVs pendientes de facturación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <table class="table">
          <thead>
            <tr>
              <th align="center">SECCIÓN</th>
              <th align="center">DOCUMENTO REF.</th>
              <th align="center">V. VENTA</th>
              <th align="center">P. VENTA</th>
              <th align="center"></th>
            </tr>
          </thead>
          <tbody id="clienteFacturacionBody">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>