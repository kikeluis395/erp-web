<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregarServicioTerceroModal" data-backdrop="static">
  Agregar Servicio
</button>

<!-- Modal -->
<div class="modal fade" id="agregarServicioTerceroModal" tabindex="-1" role="dialog" aria-labelledby="agregarServicioTerceroLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="agregarServicioTerceroLabel">Registrar Servicio Tercero</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarServicioTercero" method="POST" action="{{route('agregarServicioTercero')}}" value="Submit" autocomplete="off">
          @csrf
          <input type="hidden" name="id_hoja_trabajo" value="{{$datosHojaTrabajo->id_hoja_trabajo}}">
          <div class="form-group form-inline">
            <label for="servicioTerceroIn" class="col-sm-6 justify-content-end">Cód. Servicio Tercero:</label>
            <div class="col-sm-5"><input name="codServicioTercero" type="text" class="form-control typeahead" autocomplete="off"  tipo="serviciosTerceros" id="servicioTerceroIn" data-validation="required" data-validation-error-msg="Debe especificar un código" data-validation-error-msg-container="#errorCodigoServicioTercero" placeholder="Ingrese el código del servicio" maxlength="128" oninput="this.value = this.value.toUpperCase()"></div>
            <div id="errorCodigoServicioTercero" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>

          <div class="form-group form-inline">
            <label for="descripcionIn" class="col-sm-6 justify-content-end">Descripcion:</label>
            <input type="text" class="form-control col-sm-6" id="descripcionIn" typeahead_second_field="servicioTerceroIn" disabled>
          </div>

          @if(isset($id_recepcion_ot))
          <div class="form-group form-inline">
            <label for="proveedorIn" class="col-sm-6 justify-content-end">Proveedor:</label>
            <select name="numDocProveedor" id="proveedorIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorProveedor" required>
              <option value=""></option>
              @foreach($listaProveedores as $proveedor)
              <option value="{{$proveedor->num_doc}}">{{$proveedor->nombre_proveedor}}</option>
              @endforeach
            </select>
            <div id="errorProveedor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          @endif
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnRegistraServicioTercero" form="FormRegistrarServicioTercero" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>