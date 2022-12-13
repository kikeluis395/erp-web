<button type="button" class="btn btn-info btn-tabla" data-toggle="modal" data-target="#editarRecepcionModal-{{$recepcion_ot->id_recepcion_ot}}" data-backdrop="static"><i class="fas fa-info-circle icono-btn-tabla"></i></button>
<!-- Modal -->
<div class="modal fade" id="editarRecepcionModal-{{$recepcion_ot->id_recepcion_ot}}" tabindex="-1" role="dialog" aria-labelledby="editarRecepcionLabel-{{$recepcion_ot->id_recepcion_ot}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="editarRecepcionLabel-{{$recepcion_ot->id_recepcion_ot}}">Información del Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" @if(!$recepcion_ot->esEsperaTraslado()) style="max-height: 65vh; overflow-y: auto;" @endif>
        <form id="FormEditarRecepcion-{{$recepcion_ot->id_recepcion_ot}}" method="POST" 
        action="{{route('recepcion.store')}}"
        value="Submit" autocomplete="off">
          @csrf
          <input type="hidden" name="id_recepcion_ot" value="{{$recepcion_ot->id_recepcion_ot}}">
          <fieldset id="seccionForm-{{$recepcion_ot->id_recepcion_ot}}">
            @if($recepcion_ot->esEsperaTraslado())
            <div class="form-group form-inline">
              <label for="FechaTrasladoEdit" class="col-sm-6 justify-content-end">Fecha de Traslado: </label>
              <input name="fechaTrasladoEditar" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaTrasladoEdit" value="{{\Carbon\Carbon::parse($recepcion_ot->fechaTraslado())->format('d/m/Y')}}" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaTrasladoEdit-{{$recepcion_ot->id_recepcion_ot}}">
              <div id="errorFechaTrasladoEdit-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <hr style="border-width:3px;background:rgb(0,0,0,0.50);margin-bottom:10px">
            @endif
            <div @if($recepcion_ot->esEsperaTraslado()) style="max-height: 50vh; overflow-y: auto;" @endif>
              <div class="form-group form-inline">
                <label for="PlacaEdit" class="col-sm-6 justify-content-end">Placa: </label>
                <input type="text" class="form-control col-sm-6" id="PlacaEdit" value="{{$recepcion_ot->hojaTrabajo->placa_auto}}" disabled>
                <div id="errorPlacaEdit-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>

              <div class="form-group form-inline">
                <label for="nroOTEdit" class="col-sm-6 justify-content-end">Número de OT: </label>
                <input type="text" class="form-control col-sm-6" id="nroOTEdit" value="{{$recepcion_ot->getNroOT()}}" disabled>
              </div>

              <div class="form-group form-inline">
                <label for="tipoOTEdit" class="col-sm-6 justify-content-end">Tipo de OT: </label>
                <select class="form-control col-sm-6" disabled>
                  <option>{{$recepcion_ot->tipoOT->nombre_tipo_ot}}</option>
                </select>
              </div>

              <div class="form-group form-inline">
                <label for="marcaAutoEdit" class="col-sm-6 justify-content-end">Marca:</label>
                <select id="marcaAutoEdit" class="form-control col-sm-6" disabled>
                  <option>{{$recepcion_ot->hojaTrabajo->vehiculo->getNombreMarca()}}</option>
                </select>
                <div id="errorMarcaEdit" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>

              <div class="form-group form-inline">
                <label for="modeloEdit" class="col-sm-6 justify-content-end">Modelo: </label>
                <input name="nombreModelo" type="text" class="form-control col-sm-6" id="modeloEdit" data-validation="required" data-validation-error-msg="Debe especificar el modelo de vehículo" data-validation-error-msg-container="#errorModeloEdit-{{$recepcion_ot->id_recepcion_ot}}" maxlength="30" value="{{$recepcion_ot->hojaTrabajo->getModeloVehiculo()}}" oninput="this.value = this.value.toUpperCase()">
                <div id="errorModeloEdit-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <!--  -->
              <div class="form-group form-inline">
                <label for="clienteEdit" class="col-sm-6 justify-content-end">Cliente:</label>
                <input name="cliente" type="text" class="form-control col-sm-6" id="clienteEdit" data-validation="required" data-validation-error-msg="Debe especificar el nombre del cliente" data-validation-error-msg-container="#errorManoObra-{{$recepcion_ot->id_recepcion_ot}}" maxlength="45" value="{{$recepcion_ot->hojaTrabajo->getNombreCliente()}}" oninput="this.value = this.value.toUpperCase()">
                <div id="errorManoObra-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
              <div class="form-group form-inline">
                <label for="telefono" class="col-sm-6 justify-content-end">Teléfono:</label>
                <input name="telefonoEdit" type="text" class="form-control col-sm-6" id="telefonoEdit" value="{{$recepcion_ot->hojaTrabajo->getTelefonoCliente()}}" maxlength="45">
              </div>
              <div class="form-group form-inline">
                <label for="emailEdit" class="col-sm-6 justify-content-end">Email:</label>
                <input name="email" type="text" class="form-control col-sm-6" id="emailEdit" data-validation="required" data-validation-error-msg="Debe especificar el e-mail del cliente" data-validation-error-msg-container="#errorEmailEdit-{{$recepcion_ot->id_recepcion_ot}}" maxlength="45" value="{{$recepcion_ot->hojaTrabajo->getCorreoCliente()}}">
                <div id="errorEmailEdit-{{$recepcion_ot->id_recepcion_ot}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnSubmit-{{$recepcion_ot->id_recepcion_ot}}" form="FormEditarRecepcion-{{$recepcion_ot->id_recepcion_ot}}" value="Submit" type="submit" class="btn btn-primary">Registrar Cambios</button>
      </div>
    </div>
  </div>
</div>