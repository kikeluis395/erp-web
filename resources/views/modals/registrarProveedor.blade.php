<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregarProveedorModal" data-backdrop="static">
  Registrar Proveedor
</button>

<!-- Modal -->
<div class="modal fade" id="agregarProveedorModal" tabindex="-1" role="dialog" aria-labelledby="agregarProveedorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="agregarProveedorLabel">Registrar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
        <form id="FormRegistrarProveedor" method="POST" action="{{route('contabilidad.proveedores.store')}}" value="Submit" autocomplete="off">
          @csrf
          <div class="form-group form-inline">
            <label for="proveedorIn" class="col-sm-6 justify-content-end">Nro. Documento:</label>
            <input name="nroDocumento" type="text" class="form-control col-sm-6" id="proveedorIn" data-validation="required" data-validation-error-msg="Debe especificar el numero de documento del proveedor" data-validation-error-msg-container="#errorProveedor" placeholder="Ingrese el numero de documento" maxlength="45" oninput="this.value = this.value.toUpperCase()">
            <div id="errorProveedor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
          </div>
          <fieldset id="infoProveedor">
            <div class="form-group form-inline">
              <label for="nombreIn" class="col-sm-6 justify-content-end">Nombre:</label>
              <input name="nombre" type="text" class="form-control col-sm-6" id="nombreIn" data-validation="required" data-validation-error-msg="Debe especificar el nombre del proveedor" data-validation-error-msg-container="#errorNombre" placeholder="Ingrese el nombre del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
              <div id="errorNombre" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            @if(false)
            <div class="form-group form-inline">
              <label for="giroIn" class="col-sm-6 justify-content-end">Giro:</label>
              <input name="giro" type="text" class="form-control col-sm-6" id="giroIn" data-validation="required" data-validation-error-msg="Debe especificar el giro del proveedor" data-validation-error-msg-container="#errorGiro" placeholder="Ingrese el giro del proveedor" maxlength="45" oninput="this.value = this.value.toUpperCase()">
              <div id="errorGiro" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <div class="form-group form-inline">
              <label for="tipoProveedorIn" class="col-sm-6 justify-content-end">Tipo:</label>
              <select name="tipoProveedor" id="tipoProveedorIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorTipoProveedor" required>
                <option value=""></option>
                <option value="DISTRIBUIDOR">DISTRIBUIDOR</option>
                <option value="MAYORISTA">MAYORISTA</option>
                <option value="MINORISTA">MINORISTA</option>
                <option value="SERVICIO DE GRUAS">SERVICIO DE GRUAS</option>
                <option value="TRANSPORTISTA">TRANSPORTISTA</option>
              </select>
              <div id="errorTipoProveedor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            @endif
            <div class="form-group form-inline">
              <label for="departamentoIn" class="col-sm-6 justify-content-end">Departamento:</label>
              <select name="departamento" id="departamentoIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar un departamento" data-validation-error-msg-container="#errorDepartamento" required>
                <option value=""></option>
                @foreach ($listaDepartamentos as $departamento)
                <option value="{{$departamento->codigo_departamento}}">{{$departamento->departamento}}</option>
                @endforeach
              </select>
              <div id="errorDepartamento" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <div class="form-group form-inline">
              <label for="provinciaIn" class="col-sm-6 justify-content-end">Provincia:</label>
              <select name="provincia" id="provinciaIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una provincia" data-validation-error-msg-container="#errorProvincia" required>
                <option value=""></option>
                @foreach ($listaProvincias as $provincia)
                <option value="{{$provincia->codProvincia}}">{{$provincia->nombre}}</option>
                @endforeach
              </select>
              <div id="errorProvincia" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <div class="form-group form-inline">
              <label for="distritoIn" class="col-sm-6 justify-content-end">Distrito:</label>
              <select name="distrito" id="distritoIn" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar un distrito" data-validation-error-msg-container="#errorDistrito" required>
                <option value=""></option>
                @foreach ($listaDistritos as $distrito)
                <option value="{{$distrito->codDistrito}}">{{$distrito->nombre}}</option>
                @endforeach
              </select>
              <div id="errorDistrito" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <div class="form-group form-inline">
              <label for="direccionIn" class="col-sm-6 justify-content-end">Dirección:</label>
              <input name="direccion" type="text" class="form-control col-sm-6" id="direccionIn" data-validation="required" data-validation-error-msg="Debe especificar la direccion del cliente" data-validation-error-msg-container="#errorDireccion" placeholder="Ingrese la direccion del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
              <div id="errorDireccion" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            @if(false)
            <div class="form-group form-inline">
              <label for="telefonoIn" class="col-sm-6 justify-content-end">Teléfono:</label>
              <input name="telefono" type="text" class="form-control col-sm-6" id="telefonoIn" placeholder="Ingrese el teléfono de la empresa" maxlength="45">
            </div>
            <div class="form-group form-inline">
              <label for="emailIn" class="col-sm-6 justify-content-end">Email:</label>
              <input name="email" type="email" class="form-control col-sm-6" id="emailIn" placeholder="Ingrese el email de la empresa" data-validation="required" data-validation-error-msg="Debe especificar el e-mail de la empresa" data-validation-error-msg-container="#errorEmail" maxlength="45">
              <div id="errorEmail" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            @endif
            <div class="form-group form-inline">
              <label for="contactoIn" class="col-sm-6 justify-content-end">Contacto:</label>
              <input name="contacto" type="text" class="form-control col-sm-6" id="contactoIn" placeholder="Ingrese el nombre del contacto" data-validation="required" data-validation-error-msg="Debe especificar el nombre del contacto" data-validation-error-msg-container="#errorContacto" maxlength="45">
              <div id="errorContacto" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <div class="form-group form-inline">
              <label for="telefonoContactoIn" class="col-sm-6 justify-content-end">Telf. Contacto:</label>
              <input name="telefonoContacto" type="text" class="form-control col-sm-6" id="telefonoContactoIn" placeholder="Ingrese el teléfono del contacto" data-validation="required" data-validation-error-msg="Debe especificar el telefono del contacto" data-validation-error-msg-container="#errorTelefonoContacto" maxlength="45">
              <div id="errorTelefonoContacto" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            <div class="form-group form-inline">
              <label for="emailContactoIn" class="col-sm-6 justify-content-end">Email Contacto:</label>
              <input name="emailContacto" type="email" class="form-control col-sm-6" id="emailContactoIn" placeholder="Ingrese el email de contacto" data-validation="" data-validation-error-msg="Debe especificar el e-mail del cliente" data-validation-error-msg-container="#errorEmailContacto" maxlength="45">
              <div id="errorEmailContacto" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
            </div>
            @if(false)
            <div class="form-group form-inline">
              <label for="domiciliadoIn" class="col-sm-6 justify-content-end">Domiciliado:</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="domiciliadoRadio" id="domiciliadoRadioSi" value="1">
                <label class="form-check-label" for="domiciliadoRadioSi">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="domiciliadoRadio" id="domiciliadoRadioNo" value="0">
                <label class="form-check-label" for="domiciliadoRadioNo">No</label>
              </div>
            </div>
            <div class="form-group form-inline">
              <label for="activoIn" class="col-sm-6 justify-content-end">Activo:</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="activoRadio" id="activoRadioSi" value="1">
                <label class="form-check-label" for="activoRadioSi">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="activoRadio" id="activoRadioNo" value="0">
                <label class="form-check-label" for="activoRadioNo">No</label>
              </div>
            </div>
            @endif
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnRegistrarProveedor" form="FormRegistrarProveedor" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>