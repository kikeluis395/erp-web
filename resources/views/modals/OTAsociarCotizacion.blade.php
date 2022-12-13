<button id="btnOTAsociarCotizacion" type="button" class="btn btn-warning" data-toggle="modal" data-target="#OTAsociarCotizacion" data-backdrop="static" style="margin-left: 15px">Asociar Cotizacion</button>
<!-- Modal -->
<div class="modal fade" id="OTAsociarCotizacion" tabindex="-1" role="dialog" aria-labelledby="OTAsociarCotizacionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="OTAsociarCotizacionLabel">Asociar Cotizacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(isset($listaCotizacionesAsociables) && $listaCotizacionesAsociables)
        Seleccione la Cotizacion que desea asociar a la presente Orden de Trabajo:
        <form id="FormOTAsociarCotizacion" method="POST" 
        action="{{route('asociarOTCotizacion')}}"
        value="Submit" autocomplete="off">
        @csrf
          <input type="hidden" name="idRecepcionOT" value="{{$id_recepcion_ot}}">
          <fieldset id="seccionFormAsociarOT">
            <div>
              <select class="form-control" name="idCotizacion">
                <option value=""></option>
                @foreach ($listaCotizacionesAsociables as $cotizacion)
                <option value="{{$cotizacion->nroCotizacion}}">Cot. N° {{$cotizacion->nroCotizacion}} {{$cotizacion->fecha_registro}}</option>
                @endforeach
              </select>
            </div>
          </fieldset>
        </form>
        @else
        La presente OT no cuenta con cotizaciones asociables. Recuerde que deben existir cotizaciones con la misma placa que esta OT para poder asociarlas.
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        @if(isset($listaCotizacionesAsociables) && $listaCotizacionesAsociables)
        <button id="btnSubmitAsociarCotizacion" form="FormOTAsociarCotizacion" value="Submit" type="submit" class="btn btn-primary">Registrar Cambios</button>
        @endif
      </div>
    </div>
  </div>
</div>