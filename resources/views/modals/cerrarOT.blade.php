<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cerrarOTModal" data-backdrop="static">
  Cerrar OT
</button>

<!-- Modal -->
<div class="modal fade" id="cerrarOTModal" tabindex="-1" role="dialog" aria-labelledby="cerrarOTLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="cerrarOTLabel">Cerrar OT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        @if(count($listaRepuestosSolicitados) || count($listaServiciosTerceros) || count($listaDetallesTrabajo))
        No es posible cerrar la OT. Debe eliminar toda la mano de obra, repuestos y servicios terceros antes de continuar.
        @else
        <form id="FormCerrarOT" method="POST" action="{{route('cierreOT')}}" value="Submit" autocomplete="off">
          @csrf
          <input type="hidden" name="nro_ot" value="{{$datosRecepcionOT->id_recepcion_ot}}">
          <div class="form-group form-inline">
            <label for="razonIn" class="col-sm-6 justify-content-end">Razón:</label>
            <textarea name="razonCierre" type="text" class="form-control col-sm-6" id="razonIn" placeholder="Ingrese la razón de cierre" maxlength="128" rows="3"></textarea> 
          </div>
        </form>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        @if(!(count($listaRepuestosSolicitados) || count($listaServiciosTerceros) || count($listaDetallesTrabajo)))
        <button id="btnCerrarOT" form="FormCerrarOT" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
        @endif
      </div>
    </div>
  </div>
</div>