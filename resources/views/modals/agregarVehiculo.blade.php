<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregarVehiculoModal" data-backdrop="static">
  Registrar OT
</button>

<!-- Modal -->
<div class="modal fade" id="agregarVehiculoModal" tabindex="-1" role="dialog" aria-labelledby="agregarVehiculoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="agregarVehiculoLabel">Registrar OT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarRecepcion" method="POST" action="@if($departamento=='MECANICA') {{route('mecanica.recepcion.store')}} @else {{route('recepcion.store')}} @endif" value="Submit" autocomplete="off">
          @csrf
          <div class="form-group form-inline">
            <label for="tipoOTin" class="col-sm-6 justify-content-end">Tipo de OT: </label>
            <select name="tipoOT" id="tipoOTin" class="form-control col-sm-6 required" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoOT">
              <option value=""></option>
              @foreach ($listaTiposOT as $tipoOT)
              <option value="{{$tipoOT->id_tipo_ot}}">{{$tipoOT->nombre_tipo_ot}}</option>
              @endforeach
            </select>
            <div id="errorTipoOT" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          <div class="form-group form-inline">
            <label for="fechaEntregaProgIn" class="col-sm-6 justify-content-end" style="text-align:right">Fecha de Entrega Programada:</label>
            <input name="fechaEntregaProg" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaEntregaProgIn" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" min-date="{{\Carbon\Carbon::now()->format('d/m/Y')}}" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaEntregaProg">
            <div id="errorFechaEntregaProg" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          @if($departamento=='MECANICA')
          <div class="form-group form-inline">
            <label for="tipoTrabajoin" class="col-sm-6 justify-content-end">Tipo de Trabajo: </label>
            <select name="tipoTrabajo" id="tipoTrabajoIn" class="form-control col-sm-6 required" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoTrabajo">
              <option value=""></option>
              @foreach ($listaTiposTrabajo as $tipoTrabajo)
              <option value="{{$tipoTrabajo->id}}">{{$tipoTrabajo->nombre}}</option>
              @endforeach
            </select>
            <div id="errorTipoTrabajo" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          @endif
          <div class="form-group form-inline">
            <label for="tecnicoAsignadoIn" class="col-sm-6 justify-content-end">Técnico Asignado: </label>
            <select name="tecnicoAsignado" id="tecnicoAsignadoIn" class="form-control col-sm-6 required" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTecnicoAsignado">
              <option value=""></option>
              @foreach ($listaTecnicos as $tecnico)
              <option value="{{$tecnico->id_tecnico}}">{{$tecnico->nombre_tecnico}}</option>
              @endforeach
            </select>
            <div id="errorTecnicoAsignado" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          @include('sections.formVehiculo')

          @include('sections.formCliente')

          @if($departamento=='DYP')
          @if(Auth::user() && Auth::user()->empleado->local->hace_traslado)
          @if(false)<!-- CAMBIAR RECIBE_VEHICULOS POR HACE_TRASLADO -->@endif
          <div class="form-group form-inline">
            <label for="fechaTrasladoIn" class="col-sm-6 justify-content-end">Fecha de traslado B&P</label>
            <input name="fechaTraslado" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaTrasladoIn" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFecha" data-validation-optional="true">
            <div id="errorFecha" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          @endif

          <div class="form-group form-inline">
            <label for="ciaSeguroIn" class="col-sm-6 justify-content-end">Compañía de seguros:</label>
            <select name="seguro" id="ciaSeguroIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorSeguro" required>
              <option value=""></option>
              @foreach ($listaSeguros as $seguro)
              <option value="{{$seguro->id_cia_seguro}}">{{$seguro->nombre_cia_seguro}}</option>
              @endforeach
            </select>
            <div id="errorSeguro" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          @endif
          
          <div class="form-group form-inline">
            <label for="observacionesIn" class="col-sm-6 justify-content-end">Observaciones</label>
            <textarea name="observaciones" type="text" class="form-control col-sm-6" id="observacionesIn" placeholder="Ingrese sus observaciones" maxlength="255" rows="5"></textarea> 
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnRegistrarRecepcion" form="FormRegistrarRecepcion" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>