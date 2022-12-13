@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Pago Proveedores') 

@section('content')

<div style="background: white;padding: 10px">
    <h2 class="ml-3 mt-3 mb-4">Pago a Proveedores - Contabilidad</h2>
    <div class="row justify-content-start mt-2 ml-4">
        <div class="circ-semaforo-popover" style="background-color: green"></div><span class="semf-pop-info">&gt 10 días</span>
        <div class="circ-semaforo-popover ml-3" style="background-color: yellow"></div><span class="semf-pop-info">&gt 2 días</span>
        <div class="circ-semaforo-popover ml-3" style="background-color: red;"></div><span class="semf-pop-info" > < 2 días</span>
    </div>

    <div id="busquedaPagoProv" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
        <form id="FormFiltrarPagoProv" class="my-3" method="GET" action="{{route('contabilidad.pagoProveedores')}}" value="search">
            <div class="row">
                <div class="form-group row ml-1 col-6 col-sm-4">
                    <label for="filtroNroRUC" class="col-form-label col-12 col-sm-6">RUC Prov</label>
                    <input tipo="proveedores" id="filtroNroRUC" name="nroRUC" type="text" class="form-control mr-0 w-100 col-12 col-sm-6 typeahead" autocomplete="off"  placeholder="Número de RUC">
                </div>
                <div class="form-group row ml-1 col-6 col-sm-4">
                    <label for="filtroNombreProv" class="col-form-label col-12 col-sm-6">Nombre Prov</label>
                    <input typeahead_second_field="filtroNroRUC" id="filtroNombreProv" name="nombreProv" type="text" class="form-control col-12 col-sm-6" placeholder="Nombre Proveedor" disabled>
                </div>
                <div class="form-group row ml-1 col-6 col-sm-4">
                    <label for="filtroMoneda" class="col-form-label col-12 col-sm-6">Moneda</label>
                    <select id="filtroMoneda" name="moneda" class="form-control col-6">
                        <option value="SOLES">Soles</option>
                        <option value="DOLARES">Dólares</option>

                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-primary ">Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="background: white;padding: 10px">
    <form class="form" id="formPagarFacturas" method="POST" action="{{route('contabilidad.pagoProveedores.pagoFactura')}}" role="form" value="Submit" autocomplete="off">
        @csrf
        <div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
            <div class="table-responsive borde-tabla tableFixHead">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row col-12 justify-content-between">
                            <div class="form-inline row">
                                <h2>Deudas Pendientes</h2>
                    
                                <button class="btn btn-primary mr-4" type="button" data-toggle="collapse" data-target="#busquedaPagoProv" aria-expanded="false" aria-controls="busquedaPagoProv">
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <div class="table-cont-single">      
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">#Factura</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">RUC</th>
                                    <th scope="col">FECHA VENCIMIENTO</th>
                                    <th scope="col">MONTO (SIN IGV)</th>
                                    <th scope="col">MARCAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $facturas as $factura)
                                <tr>
                                    @if($factura->prueba)<th scope="row"><div class="circulo-semaforo" style="background-color: red; color: white;">{{$loop->iteration}}</div></th>
                                    @else <th scope="row"><div class="circulo-semaforo" style="background-color: red; color: white;">{{$loop->iteration}}</div></th>
                                    @endif
                                    <td>{{$factura->nro_factura}}</th>
                                    <td>{{$factura->getNombreProveedor()}}</td>
                                    <td>{{$factura->getRUCProveedor()}}</td>
                                    <td>{{$factura->fecha_vencimiento}}</td>
                                    <td>{{$factura->total}}</td>
                                    <td><input type="checkbox" id="factura-{{$factura->id_factura}}" name="factura-{{$factura->id_factura}}" value="{{$factura->id_factura}}"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 p-0">
            <div class="row justify-content-end m-0">
                <button type="button" data-toggle="modal" data-target="#modalEscogerCuenta" data-backdrop="static" style=" margin-left:15px" class="btn btn-warning mr-3">Siguiente</button>
                    <div class="modal fade" id="modalEscogerCuenta" tabindex="-1" role="dialog" aria-labelledby="pagarFacturas" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header fondo-sigma">
                                    <h5 class="modal-title" id="escogerCuenta">Escoger Cuenta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                                    <div class="form-group form-inline">
                                        <label for="bancosIn" class="col-sm-3 justify-content-end">Banco: </label>
                                        <select name="bancosIn" id="bancosIn" class="col-sm-9 justify-content-end form-control">
                                            <option value=""></option>
                                            @foreach($arregloBancos as $banco)
                                            <option value="{{$banco->id_banco}}">{{$banco->nombre_banco}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group form-inline">
                                        <label for="cuentasIn" class="col-sm-3 justify-content-end">Cuenta: </label>
                                        <select name="cuentasIn" class="col-sm-9 justify-content-end form-control" id="cuentasIn">
                                            <option value=""></option>
                                            @foreach($cuentas as $cuenta)
                                            <option value="{{$cuenta->id_cuenta_bancaria}}">{{$cuenta->nro_cuenta}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-secondary" >Imprimir</button>
                                    <button id="btnSubmitFactura" form="formPagarFacturas" value="Submit" type="submit" class="btn btn-primary">Pagar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </form>
</div>

@endsection