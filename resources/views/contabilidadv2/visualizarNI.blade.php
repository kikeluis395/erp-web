@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Crear OC') 

@section('content')
<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="col-12 mt-2 mt-sm-0">
        <div class="row justify-content-between">
            <h2 class="ml-3 mt-3 mb-4">Visualizar Nota Ingreso - {{$nota_ingreso->id_nota_ingreso}}</h2>
            <div class="justify-content-end">
                <a href="{{route('contabilidad.seguimientoNotasIngreso')}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
            </div>
        </div>
        <div class="row col-12 px-0 my-3">
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CODIGO NI: </span> 	<span class="col-6   ">{{$nota_ingreso->id_nota_ingreso}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CODIGO OC REL: </span> 	<span class="col-6   ">{{$nota_ingreso->obtenerOrdenCompraRelacionada()}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">GUÍA REMISIÓN: </span> 	<span class="col-6   ">{{$nota_ingreso->guia_remision}}</span>
            </div>
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA DE CREACIÓN: </span>				      <span class="col-6   ">{{$nota_ingreso->getFechaRegistro()}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MONTO TOTAL: </span>			      <span class="col-6   ">{{number_format($nota_ingreso->getCostoTotal(),2)}}</span>
            </div>
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">RUC PROVEEDOR: </span>	  <span class="col-6   ">{{$nota_ingreso->obtenerRUCProveedorRelacionado()}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">NOMBRE PROVEEDOR: </span>			      <span class="col-6   ">{{$nota_ingreso->obtenerNombreProveedorRelacionado()}}</span>
                <br>
                
                <span class="font-weight-bold letra-rotulo-detalle col-5 text-right">FACTURA ASOCIADA: </span>			      <input name="facturaNI" id="facturaNI" class="form-control py-0 px-2 col-4" form="formActualizarFactura" style="height: 30px; font-size: 15px" value="{{$nota_ingreso->factura_asociada}}" > <button class="btn-sm btn-success col-2 ml-2" form="formActualizarFactura" type="submit">Guardar</button>
                <form method="POST" id="formActualizarFactura" action="{{route('contabilidad.visualizarNI.ingresarFactura',['id_nota_ingreso' => $nota_ingreso->id_nota_ingreso])}}" autocomplete="off">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive borde-tabla tableFixHead">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row col-12 justify-content-between">
                    <div>
                        <h2>Detalle de la Nota de Ingreso</h2>
                    </div>
                </div>
            </div>
            <div class="table-cont-single">
                <form id="formDetallesTrabajo" method="POST"  autocomplete="off">
                    @csrf
                    <table id="tablaDetallesTrabajo" class="table text-center table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 6%;">#</th>
                                <th scope="col" style="width: 16%;">CODIGO</th>
                                <th scope="col" style="width: 35%;">DESCRIPCION</th>
                                <th scope="col" style="width: 15%;">UNIDAD</th>
                                <th scope="col" style="width: 8%;">CANTIDAD</th>
                                <th scope="col" style="width: 10%;">C. UNITARIO ({{App\Helper\Helper::obtenerUnidadMonedaCambiar($moneda)}})</th>
                                <th scope="col" style="width: 10%;">TOTAL ({{App\Helper\Helper::obtenerUnidadMonedaCambiar($moneda)}})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $lineas_nota_ingreso as $lineas_nota_ingreso)
                            <tr>
                                <th scope="row\">{{$loop->iteration}}</th>
                                <td><input id="inputNewDetalleTrabajoCodOp-" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value="{{$lineas_nota_ingreso->lineaOrdenCompra->getCodigoRepuesto()}}" disabled></td>
                                <td><input id="inputNewDetalleTrabajoCodOp-" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value="{{$lineas_nota_ingreso->lineaOrdenCompra->getDescripcionRepuesto()}}" disabled></td>
                                <td>
                                    <select id="inputNewDetalleTrabajoDescripcion-" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" class="form-control" disabled>
                                        <option value="" selected>{{$lineas_nota_ingreso->lineaOrdenCompra->repuesto->getNombreUnidadGrupo()}}</option>
                                    </select>
                                </td>
                                <td><input id="inputNewDetalleTrabajoDescripcion-" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" class="form-control" value="{{$lineas_nota_ingreso->cantidad_ingresada}}" disabled></td>
                                <td><input id="inputNewDetalleTrabajoDescripcion-" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;"  class="form-control" value="{{number_format($lineas_nota_ingreso->lineaOrdenCompra->precio,4)}}" disabled></td>
                                <td><input id="inputNewDetalleTrabajoDescripcion-" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto; font-weigth: bold;" class="form-control" value="{{number_format($lineas_nota_ingreso->obtenerTotal(),4)}}" disabled></td>
                            </tr>
                            @endforeach
                            <tr id="trTotal">
                                <th scope="row\"></th>
                                <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box; display: none;"></td>
                                <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box; display: none;"></td>
                                <td><input style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none;"></td>
                                <td><input style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none;"></td>
                                <td><input style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none;"></td>
                                <th><input name="inputTotalDetalleOC" id="inputTotalDetalleOC" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto; font-weigth: bold;" class="form-control" value="{{number_format($nota_ingreso->getCostoTotal(),4)}}" disabled></th>
                                <td><a><button type="button" class="btn btn-warning" style="display: none;"><i class="fas fa-trash icono-btn-tabla"></i>  </i></button></a></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>  
    </div>

    <div class="col-sm-12 p-0 mt-3">
        <div class="row justify-content-center m-0">
            <a href="{{route('hojaNotaIngreso',['id_nota_ingreso' => $nota_ingreso->id_nota_ingreso])}}"><button id="btnGuardarHojaTrabajo" style=" margin-left:15px" class="btn btn-danger">Imprimir</button></a>
        </div>
    </div>


</div>
@endsection
