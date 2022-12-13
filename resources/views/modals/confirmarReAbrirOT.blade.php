<button type="button" class="btn btn-danger" style="margin-left:15px" data-toggle="modal" data-target="#modalReAbrirOT">
Reabrir OT
</button>

<!-- Modal -->
<div class="modal fade" id="modalReAbrirOT" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Reabrir OT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                <form id="FormReAbrirOT" method="POST" action="{{route('reAbrirOT')}}" value="Submit" autocomplete="off">
                    @csrf
                    <input name="nro_ot" type="hidden" value="{{$id_recepcion_ot}}">
                </form>
                ¿Está seguro que desea reabrir la OT?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnReAbrirOT" form="FormReAbrirOT" value="Submit" type="submit" class="btn btn-primary" >Confirmar</button>
            </div>
        </div>
    </div>
</div>

@section('extra-scripts')
  @parent
  <script src="{{asset('js/modalLiquidacion.js')}}"></script>
@endsection