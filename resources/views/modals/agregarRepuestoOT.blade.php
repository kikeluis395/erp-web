<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregarRepuestoModal" data-backdrop="static">Agregar Repuesto</button>
<!-- Modal -->
<div class="modal fade" id="agregarRepuestoModal" tabindex="-1" role="dialog" aria-labelledby="agregarRepuestoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="agregarRepuestoLabel">Agregar Repuesto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarRepuesto" method="POST" action="{{route('detalle_repuestos.store')}}" value="Submit" autocomplete="off">
          @csrf
          <input type="hidden" name="tipoSubmit" value="registroRepuesto">
          <input type="hidden" name="id_recepcion_ot" value="{{$datosRecepcion->id_recepcion_ot}}">
          <input type="hidden" name="id_hoja_trabajo" value="{{$datosRecepcion->id_hoja_trabajo}}">
          <input type="hidden" name="id_necesidad_repuestos" value="{{$necesidadRepuestos->id_necesidad_repuestos}}">
          @include('sections.formAgregarRepuestoOT')
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button form="FormRegistrarRepuesto" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>