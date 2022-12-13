@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Generar Comprobante') 

@section('content')

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row  col-12">
        <h2 class="ml-3 mt-3 mb-0">Generar Comprobante - Contabilidad</h2>
    </div>
    <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la creación del comprobante</p>
    <div class="container py-3">
        <div class="row">
            <div class="mx-auto col-sm-6">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">Generar Comprobante</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="formGenerarComprobante" method="POST" action="{{route('contabilidad.generarComprobante.store')}}" role="form" value="Submit" autocomplete="off">
                            @csrf   
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 justify-content-end col-form-label form-control-label" for="tipoOperacion">Tipo de operación:</label>
                                    
                                <div class="col-sm-8">
                                    <select name="tipoOperacion" id="tipoOperacion" class="form-control w-100" size="0">
                                        <option value="OC">ORDEN DE TRABAJO</option>
                                        <option value="VOR">VEHÍCULO O REPUESTO</option>
                                        <option value="Anticipo">ANTICIPO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-inline row" id="divInputOperacion">
                                <label id="labelInputOperacion" class="col-sm-4 col-form-label form-control-label justify-content-end" for="inputOperacion">Ingrese OT: </label>
                                <div class="col-sm-8">
                                    <input name="inputOperacion" id="inputOperacion" class="form-control w-100" type="text">
                                </div>
                            </div>

                            <!-- Sección que se repite en los 3 casos -->

                            <div>
                                <div class="form-group form-inline row">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="tipoComprobante">Tipo Comprobante: </label>
                                    <div class="col-sm-8">
                                        <select name="tipoComprobante" id="tipoComprobante" class="form-control w-100" size="0">
                                            <option value="Bol">BOLETA</option>
                                            <option value="Fac">FACTURA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-inline row">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="correoCliente">Correo Cliente:</label>
                                    <div class="col-sm-8">
                                        <input name="correoCliente" class="form-control w-100" type="mail" value="" id="correoCliente">
                                    </div>
                                </div>
                                <div class="form-group form-inline row">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="condicionPago">Condicion de pago:</label>
                                    <div class="col-sm-8">
                                        <select name="condicionPago" id="condicionPago" class="form-control w-100" size="0">
                                            <option value="Contado">AL CONTADO</option>
                                            <option value="30dias">30 DÍAS</option>
                                            <option value="60dias">60 DÍAS</option>
                                            <option value="90dias">90 DÍAS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-inline row justify-content-end mb-3">
                                <div class="custom-control custom-switch text-left mr-4 mt-1 mb-3" >
                                    <input name="incluyeDetraccion" type="checkbox" class="custom-control-input" id="incluyeDetraccion">
                                    <label class="custom-control-label" for="incluyeDetraccion">Incluye Detracción</label>
                                </div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end"></label>
                                <div class="col-sm-8 row justify-content-end">
                                    <button class="btn btn-primary justify-content-end" form="formGenerarComprobante" type="submit" value="Submit">
                                        Generar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection