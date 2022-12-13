@extends('mecanica.tableCanvas')
@section('titulo','Contabilidad - Proveedores') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Gestión de Proveedores</h2>
  <div class="col-12 mt-2 mt-sm-0">
    <div class="row justify-content-between ">
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
        Exportar
      </button>
      @include('modals.registrarProveedor')
    </div>
  </div>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('contabilidad.proveedores.index')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
      </div>
      <div class="col-12">
        <div class="row justify-content-end">
          <button type="submit" class="btn btn-primary ">Buscar</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('table-content')
<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Proveedores Registrados</h2>
          </div>

          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
            Filtrar
          </button>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <!-- <th scope="col">TIPO</th> -->
              <th scope="col">DNI/RUC</th>
              <th scope="col">EMPRESA</th>
              <!-- <th scope="col">GIRO</th> -->
              <th scope="col">CONTACTO</th>
              <th scope="col">TELEFONO</th>
              <th scope="col">EMAIL</th>
              <!-- <th scope="col">DIRECCION</th> -->
              <th scope="col">EDITAR</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($listaProveedores as $proveedor)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <!-- <td>{{$proveedor->tipo_proveedor}}</td> -->
              <td>{{$proveedor->num_doc}}</td>
              <td>{{$proveedor->nombre_proveedor}}</td>
              <!-- <td>{{$proveedor->giro}}</td> -->
              <td>{{$proveedor->contacto}}</td>
              <td>{{$proveedor->telf_contacto}}</td>
              <td>{{$proveedor->email_contacto}}</td>
              <!-- <td>{{$proveedor->direccion}}</td> -->
              <td>
                <button id="editarProvButton-{{$loop->iteration}}" departamento="{{$proveedor->getDepartamento()}}" provincia="{{$proveedor->getProvincia()}}" distrito="{{$proveedor->getDistrito()}}" type="button" class="btn btn-warning" data-toggle="modal" data-target="#editarProveedor-{{$loop->iteration}}" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
                <!-- Modal -->
                <div class="modal fade" id="editarProveedor-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="editarProveedorLabel-{{$loop->iteration}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title" id="editarProveedorLabel-{{$loop->iteration}}">Editar Proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <form id="FormEditarProveedor-{{$loop->iteration}}" method="POST" action="{{route('contabilidad.proveedores.editarProveedor')}}" value="Submit" autocomplete="off">
                          @csrf
                          <input type="hidden" name="idProveedor" value="{{$proveedor->id_proveedor}}">
                          <div class="form-group form-inline">
                            <label for="proveedorIn" class="col-sm-6 justify-content-end">Nro. Documento:</label>
                            <input name="nroDocumento" value="{{$proveedor->num_doc}}" type="text" class="form-control col-sm-6" id="proveedorIn" data-validation="required" data-validation-error-msg="Debe especificar el numero de documento del proveedor" data-validation-error-msg-container="#errorProveedor" placeholder="Ingrese el numero de documento" maxlength="45" oninput="this.value = this.value.toUpperCase()">
                            <div id="errorProveedor" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                          </div>
                          <fieldset id="infoProveedor">
                            <div class="form-group form-inline">
                              <label for="nombreIn" class="col-sm-6 justify-content-end">Nombre:</label>
                              <input name="nombre" value="{{$proveedor->nombre_proveedor}}" type="text" class="form-control col-sm-6" id="nombreIn" data-validation="required" data-validation-error-msg="Debe especificar el nombre del proveedor" data-validation-error-msg-container="#errorNombre" placeholder="Ingrese el nombre del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
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
                              <label for="departamentoIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Departamento:</label>
                              <select name="departamento" id="departamentoIn-{{$loop->iteration}}" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar un departamento" data-validation-error-msg-container="#errorDepartamento" required>
                                <option value=""></option>
                                @foreach ($listaDepartamentos as $departamento)
                                <option value="{{$departamento->codigo_departamento}}">{{$departamento->departamento}}</option>
                                @endforeach
                              </select>
                              <div id="errorDepartamento" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="provinciaIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Provincia:</label>
                              <select name="provincia" id="provinciaIn-{{$loop->iteration}}" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una provincia" data-validation-error-msg-container="#errorProvincia" required>
                                <option value=""></option>
                                @foreach ($listaProvincias as $provincia)
                                <option value="{{$provincia->codProvincia}}">{{$provincia->nombre}}</option>
                                @endforeach
                              </select>
                              <div id="errorProvincia" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="distritoIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Distrito:</label>
                              <select name="distrito" id="distritoIn-{{$loop->iteration}}" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar un distrito" data-validation-error-msg-container="#errorDistrito" required>
                                <option value=""></option>
                                @foreach ($listaDistritos as $distrito)
                                <option value="{{$distrito->codDistrito}}">{{$distrito->nombre}}</option>
                                @endforeach
                              </select>
                              <div id="errorDistrito" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="direccionIn" class="col-sm-6 justify-content-end">Dirección:</label>
                              <input name="direccion" value="{{$proveedor->direccion}}" type="text" class="form-control col-sm-6" id="direccionIn" data-validation="required" data-validation-error-msg="Debe especificar la direccion del cliente" data-validation-error-msg-container="#errorDireccion" placeholder="Ingrese la direccion del cliente" maxlength="45" oninput="this.value = this.value.toUpperCase()">
                              <div id="errorDireccion" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            @if(false)
                            <div class="form-group form-inline">
                              <label for="telefonoIn" class="col-sm-6 justify-content-end">Teléfono:</label>
                              <input name="telefono"  type="text" class="form-control col-sm-6" id="telefonoIn" placeholder="Ingrese el teléfono de la empresa" maxlength="45">
                            </div>
                            <div class="form-group form-inline">
                              <label for="emailIn" class="col-sm-6 justify-content-end">Email:</label>
                              <input name="email" type="email" class="form-control col-sm-6" id="emailIn" placeholder="Ingrese el email de la empresa" data-validation="required" data-validation-error-msg="Debe especificar el e-mail de la empresa" data-validation-error-msg-container="#errorEmail" maxlength="45">
                              <div id="errorEmail" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            @endif
                            <div class="form-group form-inline">
                              <label for="contactoIn" class="col-sm-6 justify-content-end">Contacto:</label>
                              <input name="contacto" value="{{$proveedor->contacto}}" type="text" class="form-control col-sm-6" id="contactoIn" placeholder="Ingrese el nombre del contacto" data-validation="required" data-validation-error-msg="Debe especificar el nombre del contacto" data-validation-error-msg-container="#errorContacto" maxlength="45">
                              <div id="errorContacto" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="telefonoContactoIn" class="col-sm-6 justify-content-end">Telf. Contacto:</label>
                              <input name="telefonoContacto" value="{{$proveedor->telf_contacto}}" type="text" class="form-control col-sm-6" id="telefonoContactoIn" placeholder="Ingrese el teléfono del contacto" data-validation="required" data-validation-error-msg="Debe especificar el telefono del contacto" data-validation-error-msg-container="#errorTelefonoContacto" maxlength="45">
                              <div id="errorTelefonoContacto" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="emailContactoIn" class="col-sm-6 justify-content-end">Email Contacto:</label>
                              <input name="emailContacto" value="{{$proveedor->email_contacto}}" type="email" class="form-control col-sm-6" id="emailContactoIn" placeholder="Ingrese el email de contacto" data-validation="" data-validation-error-msg="Debe especificar el e-mail del cliente" data-validation-error-msg-container="#errorEmailContacto" maxlength="45">
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
                        <button id="btnEditarProveedor-{{$loop->iteration}}" form="FormEditarProveedor-{{$loop->iteration}}" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              
            </tr>
            @endforeach
            @if(false)
            <tr>
              <th scope="row">1</th>
              <td>DISTRIBUIDOR</td>
              <td>12345678</td>
              <td>BRUNO VICTOR ESPEZUA ZAPANA</td>
              <td>REPRESENTANTE DE VENTAS</td>
              <td>AUTOPARTES S.A</td>
              <td>bvez@autopartes.pe</td>
              <td>CALLE AUTOPARTES 123 CERCADO DE LIMA - LIMA - LIMA</td>
              <td><a href=""><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></a></td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>LOGISTICA</td>
              <td>10123456782</td>
              <td>LUIS ANDRES GOMES CAMPO</td>
              <td>ALMACENES LIMA SAC</td>
              <td>GERENTE COMERCIAL</td>
              <td>lagc@almaceneslima.pe</td>
              <td>CALLE ALMACENES 123 CERCADO DE LIMA - LIMA - LIMA</td>
              <td><a href=""><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></a></td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
@endsection