<button id="btnTrackingEliminados" type="button" class="btn btn-danger" data-toggle="modal" data-target="#trackingEliminados" data-backdrop="static" style="margin-left: 15px">!</button>
<!-- Modal -->
<div class="modal fade" id="trackingEliminados" tabindex="-1" role="dialog" aria-labelledby="modalTrackingEliminados" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="modalTrackingEliminados">Transacciones eliminadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(isset($listaEliminados) && $listaEliminados)
           
            @foreach($listaEliminados as $row)
              <li>{{$row->description}} <span>{{$row->created_at}}</span></li>
            @endforeach
            
        @else
        No contiene transacciones eliminadas
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>