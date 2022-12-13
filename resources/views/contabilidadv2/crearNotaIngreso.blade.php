@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Crear Nota Ingreso') 

@section('content')

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row justify-content-between col-12">
        <h2 class="ml-3 mt-3 mb-0">Crear Nota Ingreso - Contabilidad</h2>
        <div class="justify-content-end">
            <a href="{{url()->previous()}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
        </div>
    </div>
    <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la creación</p>
    <div class="container py-3">
        <div class="row">
            <div class="mx-auto col-sm-6">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">Registrar Nota de Ingreso</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="formAsignarOCaNI" method="GET" action="{{route('contabilidad.crearNotaIngreso')}}" role="form" value="Submit2" autocomplete="off">
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="fechaRecepcionNI">Fecha Recepcion: </label>
                                <div class="col-sm-8">
                                    <input id="fechaRecepcionNI" name="fechaRecepcionNI" class="form-control w-100" type="text" value="{{$fecha_recepcion}}" disabled>
                                </div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="oCRelacionada">OC Relacionada: </label>
                                <div class="col-sm-8">
                                    @if(!isset($orden_compra))<input id="oCRelacionada" name="oCRelacionada" class="form-control w-100" type="text" value="">@endif
                                    @if(isset($orden_compra))<input id="OcYaRelacionada" name="OcYaRelacionada" class="form-control w-100" type="text" value="{{$orden_compra->id_orden_compra}}" disabled>@endif
                                    @if(session('oCNoAprobada'))
                                        <div style="color: red;">{{session('oCNoAprobada')}}</div>
                                    @endif
                                    @if(session('oCNoExiste'))
                                        <div style="color: red;">{{session('oCNoExiste')}}</div>
                                    @endif
                                    @if(session('oCAtendida'))
                                        <div style="color: red;">{{session('oCAtendida')}}</div>
                                    @endif
                                    @if($rutaDescarga)
                                        <div>Descarga lista, has click <a href="{{$rutaDescarga}}" target="_blank">aqui</a></div>
                                    @endif
                                    
                                </div>
                            </div>
                            @if(isset($orden_compra))
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="guiaRemision">Guía de Remisión: </label>
                                <div class="col-sm-8">
                                <input form="formCrearNotaIngreso" id="guiaRemision" name="guiaRemision" class="form-control w-100" type="text" >
                                </div>
                            </div>
                            <div class="form-group form-inline row">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="facturaNI">Factura: </label>
                                <div class="col-sm-8">
                                <input form="formCrearNotaIngreso" id="facturaNI" name="facturaNI" class="form-control w-100" type="text" >
                                </div>
                            </div>
                            @endif
                            <div class="form-group form-inline row mb-0">
                                <label class="col-sm-4 col-form-label form-control-label justify-content-end"></label>
                                @if(!isset($orden_compra))
                                <div class="col-sm-8 row justify-content-end">
                                    <button class="btn btn-primary justify-content-end" form="formAsignarOCaNI" type="submit" value="Submit2">
                                        Siguiente
                                    </button>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($orden_compra))
    <form class="form" id="formCrearNotaIngreso" method="POST" action="{{route('contabilidad.crearNotaIngreso.store')}}" role="form" value="Submit" autocomplete="off">
        @csrf
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 justify-content-between">
                        <div>
                            <h2>Detalle de la Orden de Compra Ingresada</h2>
                        </div>
                    </div>
                </div>                
                <div class="table-cont-single">
                    <table id="tablaDetalleOCNI" class="table text-center table-striped table-sm" style="">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;">#</th>
                                <th scope="col" style="width: 50%;">DESCRIPCION</th>
                                <th scope="col" style="width: 15%;">UNIDAD</th>
                                <th scope="col" style="width: 8%;">CANTIDAD</th>
                                <th scope="col" style="width: 10%">C. UNIT ({{App\Helper\Helper::obtenerUnidadMonedaCambiar($orden_compra->tipo_moneda)}})</th>
                                <th scope="col" style="width: 10%;">TOTAL ({{App\Helper\Helper::obtenerUnidadMonedaCambiar($orden_compra->tipo_moneda)}})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $lineas_compra as $linea_compra)
                                <tr>
                                    <th scope="row\">{{$loop->iteration}}</th>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value="{{$linea_compra->getDescripcionRepuesto()}}" disabled></td>
                                    <td>
                                    <select id="unidad-{{$linea_compra->id_linea_orden_compra}}" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" class="form-control" disabled>
                                        <option value="" selected>{{$linea_compra->repuesto->getNombreUnidadGrupo()}}</option>
                                    </select>
                                    </td>
                                    <td><input type="number" min="0" max="{{$linea_compra->obtenerCantidadRestante()}}" id="cant-{{$linea_compra->id_linea_orden_compra}}" name="cant-{{$linea_compra->id_linea_orden_compra}}" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" class="form-control" value="{{$linea_compra->obtenerCantidadRestante()}}"></td>
                                    <td><input id="precio-{{$linea_compra->id_linea_orden_compra}}" name="precio-{{$linea_compra->id_linea_orden_compra}}" value="{{number_format($linea_compra->precio,2)}}" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" class="form-control" disabled></td>
                                    <td><input id="total-{{$linea_compra->id_linea_orden_compra}}" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto; font-weigth: bold;" class="form-control" value="{{number_format($linea_compra->obtenerTotalRestante(),2)}}" disabled></td>

                                </tr>
                            @endforeach
                            <tr id="trTotalNI">
                                <th scope="row\"></th>
                                <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box; display: none;"></td>
                                <td><input style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none; "></td>
                                <td><input style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none; "></td>
                                <td><input style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none; "></td>
                                <td><input name="inputTotalDetalleOCNI" id="inputTotalDetalleOCNI" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto; font-weigth: bold;" class="form-control" value="{{number_format($orden_compra->getCostoTotalRestante(),2)}}" disabled></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <input id="ocRelacionada" name="ocRelacionada" type="hidden" value="{{$orden_compra->id_orden_compra}}"> 
        <div class="col-sm-12 p-0 mt-3">
            <div class="row justify-content-end m-0">
                <button id="btnGuardarHojaTrabajo" value="Submit" type="submit" form="formCrearNotaIngreso" style=" margin-left:15px" class="btn btn-success">Generar</button>
            </div>
        </div>
    </form>
    @endif
</div>

@endsection