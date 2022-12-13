<div class="form-group form-inline">
  <label for="nroParteIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Número de parte:</label>
  @if($repuesto->id_repuesto === null)
  <input name="nroParte" type="text" class="form-control col-sm-6" id="nroParteIn-{{$repuesto->id_item_necesidad_repuestos}}" data-validation="required length" data-validation-length="max45" data-validation-error-msg="Debe ingresar un número de parte de 45 caracteres máximo" data-validation-error-msg-container="#errorNroParte-{{$repuesto->id_item_necesidad_repuestos}}" placeholder="Ingrese el número de parte" maxlength="45" oninput="this.value = this.value.toUpperCase()">
  @else
  <div>{{$repuesto->getRepuestoNroParte()}}</div>
  @endif
  <div id="errorNroParte-{{$repuesto->id_item_necesidad_repuestos}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<div class="form-group form-inline">
  <label for="descripcionIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Descripción:</label>
  @if($repuesto->id_repuesto === null)
  <input name="descripcion" type="text" class="form-control col-sm-6" id="descripcionIn-{{$repuesto->id_item_necesidad_repuestos}}" value="{{$repuesto->getDescripcionRepuesto()}}" maxlength="128" disabled>
  @else
  <div>{{$repuesto->getDescripcionRepuesto()}}</div>
  @endif
</div>
<div class="form-group form-inline">
  <label for="cantidadIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Cantidad:</label>
  @if($repuesto->id_repuesto === null)
  <input name="cantidad" type="text" class="form-control col-sm-6" oninput="validateCero({{$repuesto->id_item_necesidad_repuestos}})" id="cantidadIn-{{$repuesto->id_item_necesidad_repuestos}}" data-validation="number required" data-validation-allowing="float" data-validation-error-msg="Debe especificar una cantidad" data-validation-error-msg-container="#errorCantidad-{{$repuesto->id_item_necesidad_repuestos}}" placeholder="Ingrese una cantidad" maxlength="6" value="{{$repuesto->getCantidadRepuestos()}}" required>  
  @else
  <div>{{$repuesto->getCantidadRepuestos()}}</div>
  @endif
  <div id="errorCantidad-{{$repuesto->id_item_necesidad_repuestos}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>