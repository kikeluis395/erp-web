<!-- Modal -->
<div class="modal fade" id="anticiposModal" tabindex="-1" role="dialog" aria-labelledby="anticiposLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="anticiposLabel">Anticipos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <table class="table">
          <thead>
            <tr>
              <th align="center">DOCUMENTO</th>
              <th align="center">SERIE</th>
              <th align="center">NUMERO</th>
              <th align="center">FECHA EMISIÓN</th>
              <th align="center">MONTO C/ IGV</th>
              <th align="center">SELECCIONAR</th>
            </tr>
          </thead>
          <tbody id="anticiposBody">
            @foreach ($anticipos as $anticipo)
            <tr>
              <td>{{ $anticipo->tipo_comprobante }}</td>
              <td>{{ $anticipo->serie }}</td>
              <td>{{ $anticipo->nro_comprobante }}</td>
              <td>{{ $anticipo->fecha_emision }}</td>
              <td>{{ \App\Helper\Helper::obtenerUnidadMoneda($anticipo->moneda) }}{{ $anticipo->total_venta }}</td>
              <td>
                <input type="checkbox" name="asociarAnticipos[]" value="{{ $anticipo->id_comprobante_anticipo }}"
                  onclick="recalcularAnticipo(this)" class="form-control">
                <input type="hidden" value="{{ $anticipo->total_venta }}">
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>