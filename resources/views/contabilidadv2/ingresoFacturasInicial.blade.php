@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Ingreso de Facturas') 

@section('content')

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row  col-12">
        <h2 class="ml-3 mt-3 mb-0">Ingreso de Facturas - Contabilidad</h2>
    </div>
    <p class="ml-3 mt-3 mb-4">Ingrese los datos para ingresar la factura</p>
    <div class="container py-3">
        <div class="row">
            <div class="mx-auto col-sm-6">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">Ingreso Factura</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="formInicialFacturas" role="form" autocomplete="off" action="{{route('contabilidad.verNotasDeIngreso')}}" value="Submit" method="POST">
                            @csrf
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Periodo: </label>
                                <div class="col-sm-8">
                                    <input class="form-control w-100" data-validation="length required" data-validation-length="6" data-validation-error-msg="Debe ingresar un periodo del año, ejemplo 2021-1" data-validation-error-msg-container="#errorPeriodo" maxlength="6" name="periodo" type="text">
                                </div>
                                <div id="errorPeriodo" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end"># de Factura: </label>
                                <div class="col-sm-8">
                                    <input class="form-control w-100" data-validation="required number" data-validation-error-msg="Debe especificar el numero de la factura" data-validation-error-msg-container="#errorNFactura" name="nFactura" min="0" maxlength="16">
                                </div>
                                <div id="errorNFactura" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div>  
                            
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Fecha de Emisión: </label>
                                <div class="col-sm-8">
                                    <input type="text" name="fechaEmision"  autocomplete="off" class="datepicker form-control w-100" min-date="" placeholder="dd/mm/aaaa" data-validation="date required" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaValuacion" maxlength="10" value="{{ date('d/m/Y') }}" autocomplete="off">
                                </div>
                                <div id="errorFechaValuacion" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div>  

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Fecha Vencimiento: </label>
                                <div class="col-sm-8">
                                    <input type="text" name="fechaVencimiento"  autocomplete="off" class="datepicker form-control w-100" min-date="" placeholder="dd/mm/aaaa" data-validation="date required" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaVencimiento" maxlength="10" value="{{ date('d/m/Y') }}" autocomplete="off">
                                </div>
                                <div id="errorFechaVencimiento" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div>  

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 justify-content-end col-form-label form-control-label " >RUC proveedor:</label>
                                <div class="col-sm-8" >
                                    <input class="typeahead form-control w-100" data-toggle="tooltip" data-placement="top" title="Puede ingresar el RUC o el nombre del proveedor en este campo" data-validation="required" data-validation-error-msg="Debe ingresar un proveedor existente" data-validation-error-msg-container="#errorProveedor" tipo="proveedores" id="RUCProvID" type="text" name="RUCProv">
                                </div>
                                <div id="errorProveedor" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 justify-content-end col-form-label form-control-label " >Proveedor:</label>
                                <div class="col-sm-8">
                                    <input typeahead_second_field="RUCProvID" class="form-control w-100" type="text" id="nombreProvID" name="nombreProv" value="" readonly>
                                </div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Moneda: </label>
                                <div class="col-sm-8">
                                    <select id="tipoOperacion" name="moneda" class="form-control w-100" size="0">
                                        <option value="SOLES">01-Soles</option>
                                        <option value="DOLARES">02-Dólares</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Glosa: </label>
                                <div class="col-sm-8">
                                    <input class="form-control w-100" name="glosa" type="text" value="" >
                                </div>
                            </div> 
                            
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Tipo Movimiento: </label>
                                <div class="col-sm-8 mb-2">
                                    <input class="form-control w-100" data-validation="required" data-validation-error-msg="Debe ingresar el tipo de movimiento" data-validation-error-msg-container="#errorTipoMovimiento" name="tipoMovimiento" type="text" value="" >
                                </div>
                                <div id="errorTipoMovimiento" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div> 

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Forma de Pago: </label>
                                <div class="col-sm-8 mb-2">
                                    <input class="form-control w-100" data-validation="required" data-validation-error-msg="Debe ingresar la forma de pago" data-validation-error-msg-container="#errorFormaPago" name="formaPago" type="text" value="" >
                                </div>
                                <div id="errorFormaPago" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div> 

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" style="text-align:end;">Clasificacion Bien/Servicio: </label>
                                <div class="col-sm-8">
                                    <select id="clasificacion" name="clasificacion" class="form-control w-100" size="0">
                                        <option value="Mercaderia, materia prima, suministros y envases">001-Mercaderia, materia prima, suministros y envases</option>
                                        <option value="Activo fijo">002-Activo fijo</option>
                                        <option value="Otros activos no considerados en los numerales">003-Otros activos no considerados en los numerales</option>
                                        <option value="Gastos de educacion, recreacion, salud, cultural">004-Gastos de educacion, recreacion, salud, cultural</option>
                                        <option value="Otros gastos no incluidos en el numeral 4">005-Otros gastos no incluidos en el numeral 4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" style="text-align:end;">Modalidad Servicio: </label>
                                <div class="col-sm-8">
                                    <select id="modalidadServicio" name="modalidadServicio" class="form-control w-100" size="0">
                                        <option value="Servicio prestado integramente en el Perú">001-Servicio prestado integramente en el Perú</option>
                                        <option value="Servicio prestado parte en el Perú y parte en el extranjero">002-Servicio prestado parte en el Perú y parte en el extranjero</option>
                                        <option value="Servicio prestado exclusivamente en el extranjero">003-Servicio prestado exclusivamente en el extranjero</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" style="text-align:end;">Regimen: </label>
                                <div class="col-sm-8">
                                    <select id="tipoRegimen" name="regimen" class="form-control w-100" size="0">
                                        <option value="Afecto">01-Afecto</option>
                                        <option value="Afecto/Inafecto">02-Afecto/Inafecto</option>
                                        <option value="Inafecto">03-Inafecto</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-inline row" id="baseImponible" >
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Base Imponible: </label>
                                <div class="col-sm-8 mb-2">
                                    <input id="baseImponibleInput" data-validation="required number" data-validation-error-msg="Debe ingresar la base imponible" data-validation-error-msg-container="#errorBaseImponible" class="form-control w-100" name="baseImponible" type="number" value="" min="0">
                                </div>
                                <div id="errorBaseImponible" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div> 

                            <div class="form-group form-inline row" id="impuestos" >
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Impuestos (%): </label>
                                <div class="col-sm-8 mb-2">
                                    <input id="impuestosInput" class="form-control w-100" name="impuestos" type="number" value="" readonly>
                                </div>
                            </div> 

                            <div class="form-group form-inline row" id="inafecto" >
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Inafecto: </label>
                                <div class="col-sm-8 mb-2">
                                    <input id="inafectoInput" data-validation="required number" data-validation-error-msg="Debe ingresar el monto inafecto" data-validation-error-msg-container="#errorInafecto" class="form-control w-100" name="inafecto" type="number" value="" min="0">
                                </div>
                                <div id="errorInafecto" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                            </div> 

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Total Provisión: </label>
                                <div class="col-sm-8 mb-2">
                                    <input id="totalProvision" class="form-control w-100" name="totalProvision" value="0" readonly>
                                </div>
                            </div> 

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Afecto a detraccion: </label>
                                <div class="custom-control custom-switch col-sm-5 text-rigth" >
                                    
                                        <input name="esPerdida" type="checkbox" class="custom-control-input" id="detraccionSwitch">
                                        <label class="custom-control-label" for="detraccionSwitch" style="width:fit-content; margin:auto">No esta afecto</label>
                                </div>
                            </div>

                            <div class="form-group form-inline row detraccionSwitch">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Tipo de detraccion:</label>
                                <div class="col-sm-8 mb-2">
                                    <select id="tipo_detraccion" name="tipo_detraccion" class="form-control w-100" size="0">
                                        @foreach ($detracciones as $detraccion)
                                        <option id="opcion-{{$detraccion->id_detraccion}}" value="{{$detraccion->id_detraccion}}" porcentaje="{{$detraccion->porcentaje_detraccion}}">{{$detraccion->codigo_sunat}}-{{$detraccion->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-inline row" id="totalDetraccion">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">Total detraccion:</label>
                                <div class="col-sm-8 mb-2">
                                    <input class="form-control w-100" id='detraccion' name="detraccion" type="text" value="" readonly>
                                </div>
                            </div>

                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end">OC's Relacionadas: </label>
                                <label class="col-sm-2 col-form-label form-control-label justify-content-end"># OC</label>
                                <div class="col-sm-6 justify-content-end" style="display:flex;">
                                    <button id="btnAddLineaOCRelacionada" type="button" class="btn btn-warning" style="margin-top: -7px;">+</button>
                                </div>
                            </div>
                            <div id= "OCInputContainer">
                                <div class="form-group form-inline row" id="newOC-1">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"></label>
                                    <div class="col-sm-6 mb-2">
                                        <input class="form-control w-100" data-validation="required" data-validation-error-msg="Debe ingresar un numero de OC" data-validation-error-msg-container="#errorNumeroOC-1" name="OC-1" type="text" value="" >
                                    </div>
                                    <div class="col-sm-2 mb-2"><button id="btnEliminarNewOC-1"type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></div>
                                    <div id="errorNumeroOC-1" class="col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto"></div>
                                </div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end"></label>
                                <div class="col-sm-8 row justify-content-end">

                                    <button id="btnVisualisarNotasFactura" form="formInicialFacturas" value="Submit" type="submit" class="btn btn-warning" >Siguiente</button>
                                    
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

@section('extra-scripts')
  @parent
  <script src="{{asset('js/crearFacturas.js')}}"></script>
@endsection