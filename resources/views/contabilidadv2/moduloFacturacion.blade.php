@extends('contabilidadv2.layoutCont')
@section('titulo','Módulo Facturación')

@section('extra-style')
<style>
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid #081F2D;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #081F2D transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('content')

<script>
    var pago_metodos = {!! $pago_metodos !!}  
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css"
    integrity="sha512-/D4S05MnQx/q7V0+15CCVZIeJcV+Z+ejL1ZgkAcXE1KZxTE4cYDvu+Fz+cQO9GopKrDzMNNgGK+dbuqza54jgw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row justify-content-between col-12">
        <h2 class="ml-3 mt-3 mb-0">Módulo Facturación</h2>
        <div class="justify-content-end">
            <a href="{{url()->current()}}"><button type="button" class="btn btn-info mt-4">Limpiar</button></a>
        </div>
    </div>
    <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la facturación</p>
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #435e7c;">
                    <h4 class="mb-0 text-white">Generar Factura</h4>
                </div>
                <div class="card-body">
                    <form class="form" id="formGenerarFactura" method="GET"
                        action="{{route('contabilidad.facturacion')}}" role="form" value="Submit2" autocomplete="off">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="empresa">Empresa</label>
                                <input id="empresa" name="empresa" class="form-control" type="text"
                                    value="PLANETA NISSAN" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sucursal">Sucursal</label>
                                <input type="text" class="form-control"
                                    value="{{ auth()->user()->empleado->local->nombre_local }}" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->username }}" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="fechaEmision">Fecha Emisión</label>
                                <input id="fechaEmision" name="fechaEmision" class="form-control" type="text"
                                    value="{{$fecha_emision}}" disabled>
                                <input id="fechaEmisionFormated" name="fechaEmisionFormated" class="form-control w-100"
                                    type="hidden" value="{{ $fecha_emision_formated }}" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="fechaVencimiento">Fecha Vencimiento</label>
                                <input name="fechaVencimiento" type="text" class="datepicker form-control w-100"
                                    id="fechaVencimiento" placeholder="dd/mm/aaaa" maxlength="10" autocomplete="off"
                                    disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="tipoOperacion">Tipo Venta</label>
                                <select id="tipoVenta" name="tipoVenta" class="form-control">
                                    @foreach ($tipoVentas as $tipoVenta)

                                    <option value="{{ $tipoVenta->nombre_venta }}">{{ $tipoVenta->nombre_venta }}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <label>&nbsp;</label>
                                <div class="text-danger form-group row justify-content-end" id="lblTipoVenta">->OT :
                                </div>
                            </div>
                            <div class="form-group row col-md-3">
                                <label class="col-12" for="oCRelacionada" id="labelDocumentoSol">Documento
                                    Referencia</label>
                                <div class="col-md-7">
                                    <input id="docRelacionado" name="docRelacionado" class="form-control w-100"
                                        type="text" @if(isset($documento)) value="{{$numDocumento}}" disabled @endif>
                                    <div class="text-danger text-small"></div>
                                </div>
                                <label class="col-md-1"><button id="buscarDocumento" type="button"
                                        class="btn btn-primary"><i class="fas fa-search"></i></button></label>
                            </div>
                            <div class="form-group col-md-6">
                                <label>&nbsp;</label>
                                <div>
                                    <a href="#" id="detalleRuta" class="btn btn-primary d-none" target="_blank">Ver
                                        Detalle</a>
                                    <button type="button" id="detalleRepuesto"
                                        onclick="$('#repuestosPendientesModal').modal('show')"
                                        class="btn btn-danger d-none" target="_blank">Ver Repuestos Pendientes</button>
                                    @include('modals.repuestoPendientes')                                    
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="motivoSolFact">Documento</label>
                                <select name="motivoSolFact" id="motivoSolFact" class="form-control">
                                    <option value="FACTURA" selected>FACTURA</option>
                                    <option value="BOLETA">BOLETA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-1">
                                <label for="serie">Serie</label>
                                <input type="text" id="serie" class="form-control" value="F001">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="serie">Número</label>
                                <input type="text" class="form-control" id="correlativo" value="" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="tipoOperacion">Tipo Operación</label>
                                <select id="tipoOperacion" name="tipoOperacion" class="form-control">
                                    <option value="VENTA">VENTA</option>
                                    <option value="ANTICIPO">ANTICIPO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <br>
                                <button type="button" class="btn btn-primary" id="btnAsociarAnticipo">Asociar
                                    Anticipo</button>
                                @include('modals.anticipos')

                                <button type="button" class="btn btn-warning d-none"
                                    id="btnAnticiposAsociados">Anticipos Asociados</button>
                                @include('modals.anticiposAsociados')
                            </div>
                        </div>

                        <div id="loader" class="col-12 row justify-content-center d-none">
                            <div class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>

                        <div id="dataLoaded">
                            <div class="row mt-3">
                                <div class="form-group col-md-2">
                                    <label for="monedaSol">Moneda</label>
                                    <select id="monedaSol" name="monedaSol" class="form-control">
                                        <option value="DOLARES">DOLARES</option>
                                        <option value="SOLES">SOLES</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="tipoCambioSol">Tipo Cambio</label>
                                    <input id="tipoCambioSol" name="tipoCambioSol" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="estadoSol">Estado Documento</label>
                                    <input id="estadoSol" name="estadoSol" class="form-control col-2" type="text"
                                        readonly>
                                </div>
                                <div class="form-group row ml-sm-0 col-sm-3" id="montoAnticipoDiv"
                                    style="display: none">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                        for="montoAnticipoInput">Monto:</label>
                                    <div class="col-sm-8">
                                        <input id="montoAnticipoInput" name="montoAnticipo" class="form-control w-100"
                                            type="text">
                                    </div>
                                </div>
                            </div>

                            {{-- Modal cliente con OTs/Mvs relacionadas --}}
                            @include('modals.clienteFacturacion')
                            {{-- Modal cliente con OTs/Mvs relacionadas --}}

                            <div class="row mt-3">
                                <div class="form-group col-12">
                                    <h3>Cliente</h2>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="docCliente">Documento</label>
                                    <input id="docCliente" name="docCliente" class="form-control" type="text">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nomCliente">Cliente</label>
                                    <input id="nomCliente" name="nomCliente" class="form-control" type="text">
                                </div>
                                <div class="col-md-7"></div> {{-- Div vacio para hacer salto de línea --}}
                                <div class="form-group col-md-5">
                                    <label for="direccionCliente">Dirección</label>
                                    <input id="direccionCliente" name="direccionCliente" form="formGenerarFactura"
                                        class="form-control col-md-10" type="text">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="departamentoCliente">Departamento</label>
                                    <select class="form-control" name="departamentoCliente" id="departamentoIn">
                                        <option value="" selected></option>
                                        @foreach ($listaDepartamentos as $departamento)
                                        <option value="{{$departamento->codigo_departamento}}">
                                            {{$departamento->departamento}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ciudadCliente">Ciudad</label>
                                    <select class="form-control" name="ciudadCliente" id="provinciaIn">
                                        <option value="" selected></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="distritoCliente">Distrito</label>
                                    <select class="form-control" name="distritoCliente" id="distritoIn">
                                        <option value="" selected></option>
                                    </select>
                                </div>

                                <div class="col-md-1"></div> {{-- Div vacio para hacer salto de línea --}}

                                <div class="form-group col-md-3">
                                    <label for="telefonoCliente">Teléfono</label>
                                    <input id="telefonoCliente" name="telefonoCliente" form="formGenerarFactura"
                                        class="form-control" type="text" maxlength="9">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="emailCliente">Email</label>
                                    <input id="emailCliente" name="emailCliente" form="formGenerarFactura"
                                        class="form-control" type="text">
                                </div>

                            </div>

                            <div class="row mt-3" id="divVehiculo">
                                <div class="form-group col-12">
                                    <h3>Vehículo</h2>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaFact">Placa</label>
                                    <input id="placaFact" name="placaFact" class="form-control" type="text">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaMarca">Marca</label>
                                    <input id="placaMarca" name="placaMarca" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaModelo">Modelo</label>
                                    <input id="placaModelo" name="placaModelo" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaKilometraje">Kilometraje</label>
                                    <input id="placaKilometraje" name="placaKilometraje" class="form-control"
                                        type="text" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="placaVin">VIN</label>
                                    <input id="placaVin" name="placaVin" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaMotor">Motor</label>
                                    <input id="placaMotor" name="placaMotor" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaAnio">Año</label>
                                    <input id="placaAnio" name="placaAnio" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placaColor">Color</label>
                                    <input id="placaColor" name="placaColor" class="form-control" type="text" readonly>
                                </div>
                            </div>
                            <div id="divReducible" class="d-none row mt-3">
                                <div class="form-group col-2">
                                    <h3>Seguro</h2>
                                </div>
                                <div class="alert alert-primary d-none" role="alert" id="alertDeducible">
                                    Facturar primero el deducible
                                </div>
                                <div class="form-group col-md-12" id="montoAnticipoDiv">

                                    <div class="custom-control custom-switch d-inline-block">
                                        <input type="checkbox" class="custom-control-input" name="rbtDeducible"
                                            id="rbtDeducible" {{-- disabled --}}>
                                        <label class="custom-control-label" for="rbtDeducible"></label>
                                    </div>
                                    <span>DEDUCIBLE</span>
                                </div>
                            </div>
                            <div id="divSeguro" class="d-none row">
                                <div class="form-group col-md-3">
                                    <label for="seguroRUC">RUC</label>
                                    <input id="seguroRUC" name="seguroRUC" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="seguroRS">Razón Social</label>
                                    <input id="seguroRS" name="seguroRS" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="seguroPoliza">N° Póliza</label>
                                    <input id="seguroPoliza" name="seguroPoliza" class="form-control" type="text">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="seguroSiniestro">N° Siniestro</label>
                                    <input id="seguroSiniestro" name="seguroSiniestro" class="form-control" type="text">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="seguroDir">Dirección</label>
                                    <input id="seguroDir" name="seguroDir" class="form-control" type="text" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="seguroDepartamento">Departamento</label>
                                    <input type="text" class="form-control" id="seguroDepartamento" name="seguroDepartamento" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="seguroCiudad">Ciudad</label>
                                    <input type="text" class="form-control" id="seguroCiudad" name="seguroCiudad" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="seguroDistrito">Distrito</label>
                                    <input type="text" class="form-control" id="seguroDistrito" name="seguroDistrito" readonly>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-3">
                                    <label for="condicionPago">Condicion de Pago</label>
                                    <select name="condicionPago" id="condicionPago" class="form-control">
                                        <option value="0">AL CONTADO</option>
                                        <option value="15">CRÉDITO A 15 DÍAS</option>
                                        <option value="30">CRÉDITO A 30 DÍAS</option>
                                        <option value="45">CRÉDITO A 45 DÍAS</option>
                                        <option value="60">CRÉDITO A 60 DÍAS</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="metodoPago">Método de pago</label>
                                    <select name="metodoPago" id="metodoPago" class="form-control">
                                        <option value=""></option>
                                        @foreach ($pago_metodos as $pago)
                                            <option value="{{ $pago->id_pago_metodo }}">{{ $pago->metodo_nombre_mostrar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 d-none" id="divEntidadFinanciera">
                                    <label for="entidadFinanciera">Entidad Financiera</label>
                                    <select class="form-control" id="entidadFinanciera">
                                        <option value=""></option>
                                        @foreach ($entidades as $entidad)
                                            <option value="{{ $entidad->id }}">{{ $entidad->valor1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 d-none" id="divTarjeta">
                                    <label for="tipoTarjeta">Tipo Tarjeta</label>
                                    <select class="form-control" id="tipoTarjeta">
                                        <option value=""></option>
                                        @foreach ($tarjetas as $tarjeta)
                                            <option value="{{ $tarjeta->id }}">{{ $tarjeta->valor1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 d-none" id="divNroOperacion">
                                    <label for="nroOperacion">N° Operación</label>
                                    <input type="text" class="form-control" id="nroOperacion">
                                </div>                                
                            </div>
                            <div class="form-group mt-3">
                                <label for="observaciones">Observaciones:</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" cols="30"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        {{--  @isset($motivo)
                            @else
                            <div class="row justify-content-end">
                                <button class="btn btn-primary justify-content-end mr-3" form="formGenerarFactura" type="submit" value="Submit2">
                                    Siguiente
                                </button>
                            </div>
                            @endisset --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none" id="divDetraccion">
        <div class="alert alert-success" role="alert" id="detraccionMsg">
            Este comprobante está sujeto a detracción
        </div>
    </div>
    <form class="form" id="formRegistrarSol" method="POST" action="{{route('contabilidad.facturacion.store')}}"
        role="form" value="Submit" onsubmit="return validateForm()" autocomplete="off">
        @csrf
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 justify-content-between">
                        <div class="row w-100 justify-content-between">
                            <h2>Detalle de la OT</h2>
                            <button type="button" id="addRowDetalle" class="btn btn-warning d-none">+</button>
                        </div>
                    </div>
                </div>
                <div class="table-cont-single">
                    <table id="tablaDetalleSol" class="table text-center table-striped table-sm" style="">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 2%;">#</th>
                                <th scope="col" style="width: 11%;">CODIGO</th>
                                <th scope="col" style="width: 15%;">DESCRIPCION</th>
                                <th scope="col" style="width: 10%;">C. COSTO</th>
                                <th scope="col" style="width: 10%;">UNIDAD</th>
                                <th scope="col" style="width: 8%;">V. UNIT</th>
                                <th scope="col" style="width: 8%;">CANTIDAD</th>
                                <th scope="col" style="width: 7%">V. VENTA</th>
                                <th scope="col" style="width: 7%">DESCUENTO</th>
                                <th scope="col" style="width: 7%">SUB TOT.</th>
                                <th scope="col" style="width: 7%;">IGV</th>
                                <th scope="col" style="width: 12%;">P. VENTA</th>
                            </tr>
                        </thead>
                        <tbody id="detalleTabla">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow-sm p-3 mt-3">
            <div class="row mt-3 d-none" id="divReducible2">
                <div class="form-group col-sm-1">
                    <label for="deducible">DEDUCIBLE</label>
                </div>
                <div class="form-group col-sm-2">
                    <input type="text" id="deducible" name="deducible" class="form-control">
                    <input type="hidden" id="montoDeducible" name="montoDeducible" class="form-control">
                </div>
            </div>
            <div class="row justify-content-between mt-3">
                <div class="form-group col-sm-12 d-none" id="divRebate">
                    <label for="incluirRebate" class="bg-success p-2"><input type="checkbox" name="incluirRebate" id="incluirRebate"> Facturar Rebate</label>                    
                </div>
                <div class="form-group col-sm-2">
                    <label for="vventa_total">Valor Venta</label>
                    <input type="text" id="vventa_total" name="vventa_total" class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="descuento_total">Descuento</label>
                    <input type="text" id="descuento_total" name="descuento_total" class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="subtotalvalorventa_total">Sub Total Valor Venta</label>
                    <input type="text" id="subtotalvalorventa_total" name="sub_total_valor_venta_total"
                        class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="impuesto_total">Impuesto(18%)</label>
                    <input type="text" id="impuesto_total" name="impuesto_total" class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="total">Total</label>
                    <input type="text" id="total" name="total" class="form-control" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-2 d-none" id="inputAnticipo">
                    <label for="anticipo">Anticipo(inc. IGV)</label>

                    <input type="text" id="anticipo" name="anticipo" class="form-control" readonly>
                </div>
            </div>
            <div class="row mt-3 justify-content-end mr-1 d-none" id="divSubmit">
                <button class="btn btn-primary" id="btnGenerarFactura">Generar Factura</button>
            </div>
            <div class="row mt-3 justify-content-between mr-1">
                <a id="descargaNE" href="#" target="_blank" class="btn btn-primary d-none mr-3">Descargar Nota de entrega</a>
                <a id="descargaCR" href="#" target="_blank" class="btn btn-success d-none mr-3">Descargar Constancia de repuestos</a>
                <a id="descargaC" href="#" target="_blank" class="btn btn-warning d-none ">Ver Comprobante</a>
            </div>
            @include('modals.facturarOT')
        </div>
    </form>
</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"
    integrity="sha512-CrNI25BFwyQ47q3MiZbfATg0ZoG6zuNh2ANn/WjyqvN4ShWfwPeoCOi9pjmX4DoNioMQ5gPcphKKF+oVz3UjRw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection