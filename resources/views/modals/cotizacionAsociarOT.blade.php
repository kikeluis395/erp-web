<button id="btnCotizacionAsociarOT" type="button" class="btn btn-warning" data-toggle="modal" data-target="#cotizacionAsociarOT" data-backdrop="static" style="margin-left: 15px">Asociar a OT</button>
<!-- Modal -->
<div class="modal fade" id="cotizacionAsociarOT" tabindex="-1" role="dialog" aria-labelledby="cotizacionAsociarOTLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="cotizacionAsociarOTLabel">Asociar a OT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(isset($listaOTsAsociables) && $listaOTsAsociables)
        Seleccione la Orden de Trabajo a la cual desea asociar la presente cotización:
        <form id="FormCotizacionAsociarOT" method="POST" 
        action="{{route('asociarOTCotizacion')}}"
        value="Submit" autocomplete="off">
        @csrf
          <input type="hidden" name="idCotizacion" value="{{$id_cotizacion}}">
          <input type="hidden" name="actionPost" value="goto_OT">
          <fieldset id="seccionFormAsociarOT">
            <div>
              <select class="form-control" name="idRecepcionOT">
                <option value=""></option>
                @foreach ($listaOTsAsociables as $ordenTrabajo)
                <option value="{{$ordenTrabajo->id_recepcion_ot}}">OT N° {{$ordenTrabajo->nroOT}} {{$ordenTrabajo->fecha_registro}}</option>
                @endforeach
              </select>
            </div>
          </fieldset>
        </form>
        @else
        La presente cotización no cuenta con OTs asociables. Recuerde que deben existir OTs con la misma placa que esta cotización para poder asociarlas.
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnSubmitAsociarOT" form="FormCotizacionAsociarOT" value="Submit" type="submit" class="btn btn-primary">Registrar Cambios</button>
      </div>
    </div>
  </div>
</div>