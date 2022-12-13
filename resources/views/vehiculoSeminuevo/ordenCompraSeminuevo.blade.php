@extends('contabilidadv2.layoutCont')
@section('titulo', 'Orden de Compra Vehiculo Seminuevo')

@section('content')


    <div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white; padding: 10px 10px 10px 10px">
        <div class="row justify-content-between col-12">
            <h2 class="ml-3 mt-3 mb-0">Orden de compra vehiculo Seminuevo</h2>
            <a href="{{ route('contabilidad.seguimientoOC') }}" class="pr-3">
                {!! Form::button('<i class="fas fa-arrow-left mr-2"></i>Regresar', ['class'=>'btn btn-success btn-sm', 'type' => 'button']) !!}
             </a>
        </div>
        <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la solicitud</p>

        @if (Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ Session::get('success') }}</li>
                </ul>
            </div>
        @endif
        <div class="mb-3 w-100">
            <div class="col-sm-12 px-0">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">
                            Registrar Orden de Compra

                        </h4>
                    </div>
                    <form id="formOrdenCompraSeminuevo" action="{{ route('vehiculo_seminuevo.store') }}" method="POST">
                        @csrf
                        <div class="card-body" style="padding: 27px">

                            <div class="row">
                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="empresa">Empresa: </label>
                                    <input id="empresa" name="empresa" class="form-control col-10" type="text"
                                        value="{{ $empresa }}" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="sucursal">Sucursal: </label>
                                    <input id="sucursal" name="sucursal" class="form-control col-10" type="text"
                                        value="{{ $sucursal }}" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="almacen">Almacen: </label>
                                    <input id="almacen" name="almacen" class="form-control col-10" type="text"
                                        value="{{ $almacen }}" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="documento_oc">Documento: </label>
                                    <input id="documento_oc" name="documento_oc" class="form-control col-10" type="text"
                                        value="{{ $documento_oc }}" readonly />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="documento_oc">Fecha emision: </label>
                                    <input id="fecha_emision" name="fecha_emision" class="form-control col-10" type="text"
                                        value="{{ $fecha_emision }}" readonly />
                                </div>

                                <div class="form-group  col-3 ">
                                    <label class="col-12 " for="moneda">Moneda: </label>
                                    <select class="form-control col-12" id="moneda" name="moneda">
                                        <option value="SOLES">SOLES</option>
                                        <option value="DOLARES">DOLARES</option>
                                    </select>
                                </div>


                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="usuario_creador">Usuario responsable: </label>
                                    <input id="usuario_creador" name="usuario_creador" class="form-control col-10"
                                        type="text" value="{{ $usuario_creador }}" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="motivo">Motivo: </label>
                                    <select class="form-control col-12" id="select_motivo" name="select_motivo">
                                        @foreach ($listaMotivosOC as $row)
                                            <option value="{{ $row->id }}" @if ($row->id == $tipo_documento_transfiriente) selected @endIf>{{ $row->valor1 }}</option>
                                        @endForeach
                                    </select>
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="detalle_motivo">Detalle de Motivo: </label>
                                    <input id="detalle_motivo" name="detalle_motivo" class="form-control col-10" type="text"
                                        value="{{ $detalle_motivo }}" />
                                </div>


                                <div class="form-group  col-6">
                                    <label class="col-12 col-form-label form-control-label justify-content-end"
                                        for="observaciones">Observaciones: </label>

                                    <input id="observaciones" name="observaciones"
                                        form="formRegistrarOrdenCompraVehiculoSeminuevo" class="form-control col-10 "
                                        type="text" value="{{ $observaciones }}" />

                                </div>




                                <div class="form-group  col-3 d-none">
                                    <input id="id_oc" name="id_nota_ingreso"
                                        form="formRegistrarOrdenCompraVehiculoSeminuevo" class="form-control col-10 "
                                        type="text" value="{{ $id_oc }}" />
                                </div>
                            </div>

                            <div class="card mb-4" style="width: 100%;">
                                <div class="card-body">
                                    <h5 class="card-title">Transfiriente</h5>
                                    <div class="row">

                                        <div class="form-group row col-3 ">
                                            <div class="col-4">
                                                <label class="col-12 " for="selectTipoDoc">Tipo: </label>
                                                <select class="form-control col-12" id="selectTipoDoc" name="selectTipoDoc"
                                                    onchange="isRUC(this)">
                                                    {{-- @foreach ($listaDocumentos as $row)
                                                        <option value="{{ $row->id }}" @if ($row->id == $tipo_documento_transfiriente) selected @endIf>{{ $row->valor1 }}
                                                        </option>
                                                    @endForeach --}}
                                                    <option value="DNI">DNI</option>
                                                    <option value="RUC">RUC</option>
                                                </select>


                                            </div>
                                            <div class="col-8">
                                                <label class="col-12 " for="documento_transfiriente">Documento: </label>
                                                <input id="documento_transfiriente" name="documento_transfiriente"
                                                    class="form-control col-10" type="text"
                                                    value="{{ $documento_transfiriente }}" />
                                            </div>

                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="contacto">Nombres: </label>
                                            <input id="nombres" name="nombres" class="form-control col-10" type="text"
                                                value="{{ $nombres }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="apellido_paterno">Apellido Paterno: </label>
                                            <input id="apellido_paterno" name="apellido_paterno" class="form-control col-10"
                                                type="text" value="{{ $contacto }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="apellido_materno">Apellido Materno: </label>
                                            <input id="apellido_materno" name="apellido_materno" class="form-control col-10"
                                                type="text" value="{{ $contacto }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="razon_social">Razón Social: </label>
                                            <input id="razon_social" name="razon_social" class="form-control col-10"
                                                type="text" value="{{ $contacto }}" />
                                        </div>





                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4 d-none" style="width: 100%;" id="seccion_representante_legal">
                                <div class="card-body">
                                    <h5 class="card-title">Representante Legal</h5>
                                    <div class="row">
                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="documento_representante_legal">Documento: </label>
                                            <input id="documento_representante_legal" name="documento_representante_legal"
                                                class="form-control col-10" type="text"
                                                value="{{ $documento_representante_legal }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="nombres_representante_legal">Nombres: </label>
                                            <input id="nombres_representante_legal" name="nombres_representante_legal"
                                                class="form-control col-10" type="text"
                                                value="{{ $nombres_representante_legal }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="apellido_paterno_representante_legal">Apellido
                                                Paterno: </label>
                                            <input id="apellido_paterno_representante_legal"
                                                name="apellido_paterno_representante_legal" class="form-control col-10"
                                                type="text" value="{{ $apellido_paterno_representante_legal }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="apellido_materno_representante_legal">Apellido
                                                Materno: </label>
                                            <input id="apellido_materno_representante_legal"
                                                name="apellido_materno_representante_legal" class="form-control col-10"
                                                type="text" value="{{ $apellido_materno_representante_legal }}" />
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4" style="width: 100%;">
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <div class="row">



                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="direccion">Dirección: </label>
                                            <input id="direccion" name="direccion" class="form-control col-10" type="text"
                                                value="{{ $direccion }}" />
                                        </div>


                                        <div class="form-group col-3">
                                            <label for="fact_departamentoIn"
                                                class="col-sm-12 justify-content-end">Departamento:</label>

                                            @if (!$edited)
                                                <select name="departamento" id="fact_departamentoIn"
                                                    class="form-control col-10" data-validation="length"
                                                    data-validation-length="min1"
                                                    data-validation-error-msg="Debe seleccionar un departamento"
                                                    data-validation-error-msg-container="#errorDepartamento" required>
                                                    <option value=""></option>
                                                    @foreach ($listaDepartamentos as $departamento)
                                                        <option value="{{ $departamento->codigo_departamento }}" @if ($departamento->departamento == $departamento) selected @endIf>
                                                            {{ $departamento->departamento }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="errorDepartamento"
                                                    class="col-12 validation-error-cont text-right no-gutters pr-0"></div>


                                            @else
                                                <input id="departamento" name="departamento" class="form-control col-10"
                                                    type="text" value="{{ $departamento }}" disabled />
                                            @endIf
                                        </div>


                                        <div class="form-group  col-3">
                                            <label for="fact_provinciaIn"
                                                class="col-12 justify-content-end">Provincia:</label>
                                            @if (!$edited)
                                                <select name="provincia" id="fact_provinciaIn" class="form-control col-10"
                                                    data-validation="length" data-validation-length="min1"
                                                    data-validation-error-msg="Debe seleccionar una provincia"
                                                    data-validation-error-msg-container="#errorProvincia">
                                                    <option value=""></option>
                                                    @if (false)
                                                        @foreach ($listaProvincias as $provincia)
                                                            <option value="{{ $provincia->codProvincia }}">
                                                                {{ $provincia->nombre }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div id="errorProvincia"
                                                    class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                            @else
                                                <input id="provincia" name="provincia" class="form-control col-10"
                                                    type="text" value="{{ $ciudad }}" disabled />
                                            @endIf
                                        </div>


                                        <div class="form-group  col-3">
                                            <label for="fact_distritoIn"
                                                class="col-12 justify-content-end">Distrito:</label>
                                            @if (!$edited)
                                                <select name="distrito" id="fact_distritoIn" class="form-control col-10"
                                                    data-validation="length" data-validation-length="min1"
                                                    data-validation-error-msg="Debe seleccionar un distrito"
                                                    data-validation-error-msg-container="#errorDistrito">
                                                    <option value=""></option>
                                                    @if (false)
                                                        @foreach ($listaDistritos as $distrito)
                                                            <option value="{{ $distrito->codDistrito }}" @if ($distrito->nombre == $distrito) selected @endIf>
                                                                {{ $distrito->nombre }}

                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div id="errorDistrito"
                                                    class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                            @else
                                                <input id="distrito" name="distrito" class="form-control col-10" type="text"
                                                    value="{{ $distrito }}" disabled />
                                            @endIf
                                        </div>


                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="telefono">Contacto: </label>
                                            <input id="telefono" name="telefono" class="form-control col-10" type="text"
                                                value="{{ $telefono }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " type="phone" for="telefono">Teléfono: </label>
                                            <input id="celular" name="celular" class="form-control col-10" type="text"
                                                value="{{ $telefono }}" />
                                        </div>

                                        <div class="form-group col-3 ">
                                            <label class="col-12 " for="email">Email: </label>
                                            <input id="email" name="email" class="form-control col-10" type="text"
                                                value="{{ $email }}" />
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4" style="width: 100%;">
                                <div class="card-body">
                                    <h5 class="card-title">Vehiculo</h5>
                                    <div class="row">
                                        <div class="form-group  col-2 ">
                                            <label class="col-12 " for="contacto">Placa: </label>
                                            <input id="placa" name="placa" class="form-control col-10" type="text" required
                                                maxlength="6" oninput="this.value = this.value.toUpperCase()"
                                                value="{{ $placa }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">VIN: </label>
                                            <input id="vin" name="vin" class="form-control col-10" type="text" required
                                                maxlength="17" oninput="this.value = this.value.toUpperCase()"
                                                value="{{ $vin }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Motor: </label>
                                            <input id="motor" name="motor" class="form-control col-10" type="text"
                                                value="{{ $motor }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Año Fabricacion: </label>
                                            <input id="anho_fabricacion" type="number" name="anho_fabricacion"
                                                class="form-control col-10" type="text" value="{{ $anho_fabricacion }}"
                                                @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="anho_modelo">Año modelo: </label>
                                            <input id="anho_modelo" type="number" name="anho_modelo"
                                                class="form-control col-10" type="text" value="{{ $anho_modelo }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="marca">Marca: </label>
                                            <select name="marca_seminuevoIn" id="marca_seminuevoIn"
                                                class="form-control col-10" data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="Debe seleccionar una marca"
                                                data-validation-error-msg-container="#errorMarca">
                                                <option value=""></option>

                                                @foreach ($marcas_seminuevos as $marca)
                                                    <option value="{{ $marca->id_marca_auto_seminuevo }}">
                                                        {{ $marca->nombre }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            {{-- <input id="marca" name="marca" class="form-control col-10" type="text"
                                                value="{{ $marca }}" @if ($edited) disabled @endIf  /> --}}
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Modelo: </label>
                                            <select name="modelo_seminuevoIn" id="modelo_seminuevoIn"
                                                class="form-control col-10" data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="Debe seleccionar un modelo"
                                                data-validation-error-msg-container="#errorProvincia">
                                                <option value=""></option>

                                            </select>

                                            {{-- <input id="modelo" name="modelo" class="form-control col-10" type="text"
                                                value="{{ $modelo }}" @if ($edited) disabled @endIf  /> --}}
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Versión: </label>
                                            <input id="version" name="version" class="form-control col-10" type="text"
                                                value="{{ $version }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Kilometraje: </label>
                                            <input id="kilometraje" name="kilometraje" class="form-control col-10"
                                                type="text" value="{{ $kilometraje }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Color: </label>
                                            <input id="color" name="color" class="form-control col-10" type="text"
                                                value="{{ $color }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Combustible: </label>
                                            <select name="combustible" id="combustible" class="form-control col-10"
                                                data-validation="length" data-validation-length="min1"
                                                data-validation-error-msg="Debe seleccionar una opción"
                                                data-validation-error-msg-container="#errorTipoCombustible" required>
                                                <option value=""></option>
                                                <option value="gasolina">GASOLINA</option>
                                                <option value="gnv-glp">GNV - GLP</option>
                                                <option value="petroleo">PETRÓLEO</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Cilindrada: </label>
                                            <input id="cilindrada" name="cilindrada" class="form-control col-10"
                                                type="number" value="{{ $cilindrada }}" @if ($edited) disabled @endIf />
                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="contacto">Transmisión: </label>
                                            <select name="transmision" id="transmision" class="form-control col-10"
                                                data-validation="length" data-validation-length="min1"
                                                data-validation-error-msg="Debe seleccionar una opción"
                                                data-validation-error-msg-container="#errorTipoTransmision" required>
                                                <option value=""></option>
                                                <option value="mecanico">MECÁNICA</option>
                                                <option value="automatico">AUTOMÁTICA</option>
                                            </select>

                                        </div>

                                        <div class="form-group  col-2 ">
                                            <label class="col-12 " for="contacto">Tracción: </label>
                                            <select name="traccion" id="traccion" class="form-control required col-12"
                                                style="width:100%" data-validation="length" data-validation-length="min1"
                                                data-validation-error-msg="Debe seleccionar una opción">
                                                {{-- @if ($vehiculoNuevo != null)
                                                  <option @if ($vehiculoNuevo->traccion == '4X2') selected="true"@endIf value="4X2">4X2</option>
                                                  <option @if ($vehiculoNuevo->traccion == '4X4') selected="true"@endIf value="4X4">4X4</option>  
                                                  <option @if ($vehiculoNuevo->traccion == '2WD') selected="true"@endIf value="2WD">2WD</option> 
                                                  <option @if ($vehiculoNuevo->traccion == '4WD') selected="true"@endIf value="4WD">4WD</option> 
                                                @else --}}
                                                <option value="4X2">4X2</option>
                                                <option value="4X4">4X4</option>
                                                <option value="2WD">2WD</option>
                                                <option value="4WD">4WD</option>
                                                {{-- @endIf --}}
                                            </select>

                                        </div>

                                        <div class="form-group col-2 ">
                                            <label class="col-12 " for="precio">Unidad valorizada en: </label>
                                            <input style="background-color:rgb(160, 234, 236)" id="precio" name="precio"
                                                class="form-control col-10" type="text" value="{{ $precio }}" @if ($edited) disabled @endIf />
                                        </div>

                                        @if (!$edited)
                                            <div class="form-group  col-2 ">
                                                <br>
                                                <button type="submit" form="formOrdenCompraSeminuevo"
                                                    class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                    <i class="material-icons"> Generar OC</i>
                                                </button>

                                            </div>
                                        @else
                                            {{-- <div class="form-group  col-2 ">
                                                <br>
                                                <button type="submit" formaction=""
                                                    class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                    <i class="material-icons"> Aprobar</i>
                                                </button>

                                            </div>

                                            <div class="form-group  col-2 ">
                                                <br>
                                                <button type="submit" form="formOrdenCompraSeminuevo"
                                                    class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                    <i class="material-icons"> Desaprobar</i>
                                                </button>

                                            </div> --}}
                                            <input id="idOrdenCompra" name="idOrdenCompra" value="{{$id_oc}}" class="d-none">

                                            <div class="form-group  col-2 ">
                                            @if ($estadoN == 'APROBADO')
                                            <div class="row" >
                                                {!! Form::button('<i class="fas fa-times mr-2"></i>ANULAR', ['class' => 'btn btn-danger mr-1', 'type' => 'button', 'name' => 'button', 'id' => 'anularOC']) !!}
                                                <a href="{{'/hojaOrdenCompraSeminuevo/?id_orden_compra='. $id_oc }}"><button type="button" class="btn btn-success" >Imprimir OC</button></a>
                                            </div>
                                           
                                                
                                            </div>
                                            @else
                                            <div class="row" >
                                                {!! Form::button('<i class="fas fa-check mr-2"></i>APROBAR', ['class' => 'btn btn-success mr-1', 'type' => 'button', 'name' => 'button', 'id' => 'aprobarOCSeminuevo']) !!}
                        
                                                {!! Form::button('<i class="fas fa-times mr-2"></i>RECHAZAR', ['class' => 'btn btn-danger mr-1', 'type' => 'button', 'name' => 'button', 'id' => 'rechazarOC']) !!}
                                            </div>
                                                @endif
                                            </div>
                                        @endIf
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="form-group  col-2 d-none">
                        <input type="text" name="oc_nueva" id="oc_nueva" value="{{ $oc_nueva }}">


                    </div>
                </div>
            </div>
        </div>
        


    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script>
        function isRUC(sel) {
            //var x= $("#selectTipoDoc option:selected" ).text();
            var x = selectTipoDoc.value;

            if (x == 'RUC') {
                $('#seccion_representante_legal').removeClass('d-none');
            } else {
                $('#seccion_representante_legal').toggleClass('d-none');
            }
        }

        // window.onload(function() {
        //     var oc_nueva = $('#oc_nueva').val();
        //     if (oc_nueva) {
        //         Swal.fire({
        //             text: "Orden de Compra Generada N°: " + oc_nueva,
        //             icon: "success",
        //             showCancelButton: true,
        //             confirmButtonText: "Aceptar",
        //             showCancelButton: false,
        //             // cancelButtonText: "No, Cancelar",
        //             customClass: {
        //                 confirmButton: "btn btn-success  mr-3",
        //                 // cancelButton: "btn btn-secondary ",

        //             },
        //             buttonsStyling: false,
        //         }).then((result) => {
        //             if (result.value) {

        //                 toastr["success"]("Registro actualizado correctamente");
        //                 var loc = window.location;
        //                 window.location = loc.protocol + "/seguimientoOC";
        //             }

        //         });

        //     }
        // });
    </script>
@endsection



@section('extra-scripts')
    @parent
    
    <script src="{{ asset('js/recepcion.js') }}"></script>
    <script src="{{ asset('scripts/script_validarOC.js') }}"></script>
@endsection

