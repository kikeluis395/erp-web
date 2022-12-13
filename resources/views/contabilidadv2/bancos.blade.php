@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Bancos') 

@section('content')

<div style="background: white;padding: 10px">
    <h2 class="ml-3 mt-3 mb-4">Bancos - Contabilidad</h2>

    <div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 justify-content-between">
                        <div class="form-inline row">
                            <h2>Cuentas Registradas</h2>
                        </div>

                        <div class="d-flex justify-content-end" >
                            <button data-toggle="modal" data-target="#modalCrearCuenta" data-backdrop="static" style=" margin-left:15px" class="btn btn-warning mr-3" >
                                Añadir Cuenta
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="modalCrearCuenta" tabindex="-1" role="dialog" aria-labelledby="confirmarInicioOperativo" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header fondo-sigma">
                                            <h5 class="modal-title">Añadir Cuenta</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                                            <form class="form" id="formCrearCuenta" method="POST" action="{{route('contabilidad.bancos.store')}}" role="form" value="Submit" autocomplete="off">
                                                @csrf
                                                <div class="form-group form-inline">
                                                    <label for="empleadoMecIn" class="col-sm-4 justify-content-end">Banco: </label>
                                                    <select name="bancoSelecc" class="col-sm-8 justify-content-end form-control" id="empleadoMecIn_">
                                                        @foreach( $bancos as $banco)
                                                        <option value="{{$banco->id_banco}}">{{$banco->nombre_banco}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group form-inline">
                                                    <label for="numCuenta" class="col-sm-4 justify-content-end">Cuenta: </label>
                                                    <input name="numCuenta" id="numCuenta" class="form-control col-sm-8" type="text" value="">
                                                </div>

                                                <div class="form-group form-inline">
                                                    <label for="tipoMoneda" class="col-sm-4 justify-content-end">Moneda: </label>
                                                    <select name="tipoMoneda" class="col-sm-8 justify-content-end form-control" id="tipoMoneda">
                                                        <option value="SOLES">SOLES</option>
                                                        <option value="DOLARES">DOLARES</option>
                                                    </select>
                                                </div>
                                    
                                                <div class="form-group form-inline">
                                                    <label for="saldoInicial" class="col-sm-4 justify-content-end">Saldo Inicial: </label>
                                                    <input name="saldoInicial" id="saldoInicial" class="form-control col-sm-8" type="text" value="">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button id="btnSubmit" form="formCrearCuenta" value="Submit" type="submit" class="btn btn-primary">Crear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        
                <div class="table-cont-single">
                    <table class="table text-center table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">BANCO</th>
                                <th scope="col">CUENTA</th>
                                <th scope="col">MONEDA</th>
                                <th scope="col">SALDO</th>
                                @if(false)<th scope="col">EDITAR</th>@endif
                                <th scope="col">MOVIMIENTOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cuentas as $cuenta)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$cuenta->banco->nombre_banco}}</td>
                                <td>{{$cuenta->nro_cuenta}}</td>
                                <td>{{$cuenta->moneda}}</td>
                                <td>{{$cuenta->getSaldo()}}</td>
                                @if(false)
                                <td>
                                    <button type="button" class="btn btn-warning btn-tabla" data-toggle="modal" data-target="#modalEditarCuenta" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i></button>
                                    <div class="modal fade" id="modalEditarCuenta" tabindex="-1" role="dialog" aria-labelledby="confirmarInicioOperativo" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header fondo-sigma">
                                                    <h5 class="modal-title" id="confirmarInicioOperativo">Editar Cuenta</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                                                    <form id="FormInicioOperativo" method="GET"  value="Submit" autocomplete="off">
                                                        @csrf
                                                        <input type="hidden" name="tipoSubmit" value="inicioOperativo">
                                                        <input type="hidden" name="idRecepcionOT" value="">
                                                        <div class="form-group form-inline">
                                                            <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Banco: </label>
                                                            <select name="empleadoMec" class="col-sm-9 justify-content-end form-control" id="empleadoMecIn_">
                                                                <option value="BCP">BCP</option>
                                                                <option value="IBK">IBK</option>
                                                                <option value="BBVA">BBVA</option>
                                                            </select>
                                                            <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                                        </div>

                                                        <div class="form-group form-inline">
                                                            <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Cuenta: </label>
                                                            <input class="form-control col-sm-9" type="text" value="654897325641">
                                                            <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                                        </div>

                                                        <div class="form-group form-inline">
                                                            <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Moneda: </label>
                                                            <select name="empleadoMec" class="col-sm-9 justify-content-end form-control" id="empleadoMecIn_">
                                                                <option value="Soles">Soles</option>
                                                                <option value="Dolares">Dolares</option>
                                                            </select>
                                                            <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                                        </div>
                                                        
                                                        <div class="form-group form-inline">
                                                            <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Saldo: </label>
                                                            <input class="form-control col-sm-9" type="text" value="15000">
                                                            <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button id="btnSubmit-" form="FormInicioOperativo-" value="Submit" type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                                <td><a href="{{route('contabilidad.detalleCuenta')}}"><button type="button" class="btn btn-warning"><i class="fas fa-info-circle icono-btn-tabla"></i>  </i></button></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection