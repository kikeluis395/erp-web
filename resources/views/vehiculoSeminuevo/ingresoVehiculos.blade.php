@extends('contabilidadv2.layoutCont')
@section('titulo', 'Ingreso de vehiculos')

@section('content')


    <div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white; padding: 10px 10px 10px 10px">
        <div class="row justify-content-between col-12">
            <h2 class="ml-3 mt-3 mb-0">Ingreso de vehiculos</h2>

        </div>
        <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la solicitud</p>


        <div class="mb-3 w-100">
            <div class="col-sm-12 px-0">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">
                            Registrar Ingreso Vehiculo
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="customSwitchIngresoVehiculo"
                                    id="customSwitchIngresoVehiculo">
                                <label class="custom-control-label" for="customSwitchIngresoVehiculo">
                                    <div id="customSwitchIngresoVehiculoText" name="customSwitchIngresoVehiculoText">Nuevo
                                    </div>
                                </label>
                            </div>
                        </h4>
                    </div>

                    <div class="card-body" style="padding: 27px">
                        <form id="formIngresoVehiculoNuevo"  >
                            @csrf
                            <div class="row" id="seccionVehiculoNuevo">
                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin">VIN: </label>

                                    <input name="codigo" type="text" class="form-control col-12 typeahead vehiculosNuevos"
                                        autocomplete="off" tipo="vehiculosNuevos" id="codigoIn" style="width:100%"
                                        {{-- data-validation="required" --}}
                                        data-validation-error-msg="Debe ingresar el código del repuesto"
                                        data-validation-error-msg-container="#errorCodigo"
                                        placeholder="Ingrese el código del repuesto"
                                        oninput="this.value = this.value.toUpperCase()" />


                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin">Tipo de Stock: </label>
                                    <input id="tipo_stock" name="tipo_stock" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin">Marca: </label>
                                    <input id="marca" name="marca" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="modelo_comercial">Modelo Comercial: </label>
                                    <input id="modelo_comercial" name="modelo_comercial" class="form-control col-10"
                                        type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="motor">Motor: </label>
                                    <input id="motor" name="motor" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="anho_modelo">Año modelo: </label>
                                    <input id="anho_modelo" name="anho_modelo" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="color">Color: </label>
                                    <input id="color" name="color" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="kilometraje">Kilometraje: </label>
                                    <input id="kilometraje" name="kilometraje" class="form-control col-10" type="text"
                                        autocomplete="off" />
                                </div>


                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin">Ubicacion: </label>
                                    <select class="form-control col-10" id="ubicacion" name="ubicacion">
                                        @foreach($listaUbicaciones as $ubicacion)
                                            <option value="{{$ubicacion->id}}">{{$ubicacion->valor1}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="guia-remision">Guía Remisión: </label>
                                    <input id="guia-remision" name="guiaRemisionSol" class="form-control col-10"
                                    autocomplete="off" type="text" />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="documento">Nota de Ingreso: </label>
                                    

                                        <div class="row ml-1">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text p-0 px-2">NI</div>
                                             </div>
                                             <div class="input-group-prepend">
                                                <div class="input-group-text p-0 px-2">{{ 2021 }}</div>
                                             </div>
                                            <input id="documento" name="documento" class="form-control col-6" type="text"
                                                disabled />
                                        </div>
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="fecha_recepcion">Fecha Recepción: </label>
                                    <input id="fecha_recepcion" name="fecha_recepcion" class="form-control col-10" type="text"
                                        disabled />
                                </div>


                                <div class="form-group  col-6">
                                    <label class="col-12 col-form-label form-control-label justify-content-end"
                                        for="observaciones">Observaciones: </label>

                                    <input id="observaciones" name="observaciones" class="form-control col-10 "
                                        type="text" />

                                </div>

                                <div class="form-group d-none col-6">


                                    <input form="formIngresoVehiculoNuevo" id="documentoRelacionado"
                                        name="documentoRelacionado" class="form-control col-10 " type="text" />

                                </div>

                                <div class="form-group  col-2 ">
                                    <br>
                                    <button id="btn_registrar_ingreso_nuevo" type="button" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                        <i class="material-icons"> REGISTRAR</i>
                                    </button>

                                </div>

                                <div class="form-group  col-2 ">
                                    <br>
                                    <a id="linkImprimir" class="d-none">

                                        <button class="btn btn-success btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons"> IMPRIMIR</i>
                                        </button>
                                    </a>

                                </div>

                            </div>
                        </form>

                        <form id="formIngresoVehiculoSeminuevo" action="{{ route('ingresoVehiculoSeminuevo') }}"
                            method="POST">
                            @csrf
                            <div class="row d-none" id="seccionVehiculoSeminuevo">


                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin">Placa: </label>

                                    <input name="codigo" type="text"
                                        class="form-control col-12 typeahead vehiculosSeminuevos" autocomplete="off"
                                        tipo="vehiculosSeminuevos" id="codigoInSeminuevos" style="width:100%"
                                        data-validation="required"
                                        data-validation-error-msg="Debe ingresar el código del repuesto"
                                        data-validation-error-msg-container="#errorCodigo"
                                        placeholder="Ingrese el código del repuesto"
                                        oninput="this.value = this.value.toUpperCase()" />


                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="marca_sn">Marca: </label>
                                    <input id="marca_sn" name="marca_sn" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="modelo_sn">Modelo: </label>
                                    <input id="modelo_sn" name="modelo_sn" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="version_sn">Version: </label>
                                    <input id="version_sn" name="version_sn" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin_sn">VIN: </label>
                                    <input id="vin_sn" name="vin_sn" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="motor_sn">Motor: </label>
                                    <input id="motor_sn" name="motor_sn" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="anho_fabricacion_sn">Año fabricación: </label>
                                    <input id="anho_fabricacion_sn" name="anho_fabricacion_sn" class="form-control col-10"
                                        type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="anho_modelo_sn">Año modelo: </label>
                                    <input id="anho_modelo_sn" name="anho_modelo_sn" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="kilometraje_sn">Kilometraje: </label>
                                    <input id="kilometraje_sn" name="kilometraje_sn" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="color_sn">Color: </label>
                                    <input id="color_sn" name="color_sn" class="form-control col-10" type="text" disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="tipo_stock_sn">Tipo de Stock: </label>
                                    <input id="tipo_stock_sn" name="tipo_stock_sn" class="form-control col-10" type="text"
                                        disabled />
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="vin">Ubicacion: </label>
                                    <select class="form-control col-10" id="ubicacion_sn" name="ubicacion_sn">
                                        @foreach($listaUbicaciones as $ubicacion)
                                        <option value="{{$ubicacion->id}}">{{$ubicacion->valor1}}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="documento_sn">Nota de Ingreso: </label>
                                    <div class="row ml-1">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text p-0 px-2">NI</div>
                                         </div>
                                         <div class="input-group-prepend">
                                            <div class="input-group-text p-0 px-2">{{ 2021 }}</div>
                                         </div>
                                        <input id="documento_sn" name="documento_sn" class="form-control col-6" type="text"
                                            disabled />
                                    </div>
                                    
                                </div>

                                <div class="form-group col-3 ">
                                    <label class="col-12 " for="fecha_recepcion_sn">Fecha Recepción: </label>
                                    <input id="fecha_recepcion_sn" name="fecha_recepcion_sn" class="form-control col-10" type="text"
                                        disabled />
                                </div>


                                <div class="form-group  col-6">
                                    <label class="col-12 col-form-label form-control-label justify-content-end"
                                        for="observaciones_sn">Observaciones: </label>

                                    <input id="observaciones_sn" name="observaciones_sn" class="form-control col-10 "
                                        type="text" />

                                </div>

                                <div class="form-group d-none col-6">
                                    <input form="formIngresoVehiculoSeminuevo" id="documentoRelacionado_sn"
                                        name="documentoRelacionado_sn" class="form-control col-10 " type="text" />

                                </div>

                                <div class="form-group  col-2 ">
                                    <br>
                                    <button id="btn_registrar_sn" type="submit" form="formIngresoVehiculoSeminuevo"
                                        class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                        <i class="material-icons"> REGISTRAR</i>
                                    </button>

                                </div>

                                <div class="form-group  col-2 ">
                                    <br>
                                    <a id="linkImprimir_sn" class="d-none">

                                        <button class="btn btn-success btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons"> IMPRIMIR</i>
                                        </button>
                                    </a>

                                </div>

                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>



    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script>
  
$('#btn_registrar_ingreso_nuevo').click(function (e) {
    e.preventDefault()


        $('#formIngresoVehiculoNuevo').submit()
}); 


    $('#formIngresoVehiculoNuevo').submit(function (e) {
    e.preventDefault();
    let tipoVenta = $('#tipoVenta').val()

    var formData = new FormData(formIngresoVehiculoNuevo);
    console.log(formData);

});




    </script>
@endsection



@section('extra-scripts')

@endsection
