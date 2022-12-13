@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de Visulizar OS') 

@section('content')
<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="col-12 mt-2 mt-sm-0">
        <div class="row justify-content-between">
            <h2 class="ml-3 mt-3 mb-4">Visualizar OS</h2>
            <div class="justify-content-end">
                <a href="{{route('seguimientoServiciosTerceros')}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
            </div>
        </div>
        <div class="row col-12 px-0 my-3">
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CODIGO OS: </span> 	<span class="col-6   ">@if(!isset($orden_servicio)) - @else{{$orden_servicio->id_orden_servicio}} @endif</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">RUC PROVEEDOR: </span> 	<span class="col-6   ">{{$proveedor->num_doc}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TELEFONO CONTACTO: </span> 	<span class="col-6   ">{{$proveedor->telf_contacto}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CONDICION PAGO: </span>
                <span class="col-6">
                    @if(isset($serviciosTerceros))
                    <select name="condicionPago" id="condicionPagoOS" class="form-control py-0 px-2" style="height: 30px; font-size: 15px" form="cambiarEstadoOS">
                        <option value="CONTADO">AL CONTADO</option>
                        <option value="CREDITO-15D">15 DÍAS</option>
                        <option value="CREDITO-30D">30 DÍAS</option>
                        <option value="CREDITO-45D">45 DÍAS</option>
                        <option value="CREDITO-60D">60 DÍAS</option>
                    </select>
                    @else
                    {{$orden_servicio->condicion_pago}}
                    @endif
                </span>

            </div>
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">#OT: </span>				      <span class="col-6   ">{{$id_recepcion_ot}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">PLACA AUTO: </span> 	<span class="col-6   ">{{$placa}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">DIRECCIÓN PROVEEDOR: </span> 	<span class="col-6   ">{{$proveedor->direccion}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">EMAIL CONTACTO: </span> 	<span class="col-6   ">{{$proveedor->email_contacto}}</span>
                
            </div>
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">NOMBRE PROVEEDOR: </span>	  <span class="col-6   ">{{$proveedor->nombre_proveedor}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">NOMBRE CONTACTO: </span> 	<span class="col-6   ">{{$proveedor->contacto}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MONEDA: </span>
                <span class="col-6">
                    @if(isset($serviciosTerceros))
                    <select name="moneda" id="monedaOS" class="form-control py-0 px-2" style="height: 30px; font-size: 15px" form="cambiarEstadoOS" autocomplete="off">
                        <option value="SOLES" >Soles</option>
                        <option value="DOLARES" >Dólares</option>
                    </select>
                    @else
                    {{$orden_servicio->moneda}}
                    @endif
                </span>
                @if(isset($orden_servicio) && $orden_servicio->es_aprobado == 1)
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-5 text-right">FACTURA ASOCIADA: </span>			      <input name="facturaOS" id="facturaOS" class="form-control py-0 px-2 col-4" form="formActualizarFactura" style="height: 30px; font-size: 15px" value="{{$orden_servicio->factura_asociada}}" > <button class="btn-sm btn-success col-2 ml-2" form="formActualizarFactura" type="submit">Guardar</button>
                <form method="POST" id="formActualizarFactura" action="{{route('ordenServicio.ingresarFactura',['id_orden_servicio' => $orden_servicio->id_orden_servicio])}}" autocomplete="off">
                    @csrf
                </form>
                @endif
            </div>
        </div>

        <div class="form-group form-inline col-md-6 form-group-align-top">
        <label for="observacionesIn">Observaciones:</label>
        <textarea name="observaciones" type="text" class="form-control col-10 ml-3" id="observacionesIn" placeholder="Ingrese sus observaciones" maxlength="255" rows="3" form="cambiarEstadoOS" autocomplete="off" @if(!isset($serviciosTerceros)) disabled @endif>@if(isset($orden_servicio)){{$orden_servicio->observaciones}}@endif</textarea> 
        </div>

    </div>

    <div class="table-responsive borde-tabla tableFixHead">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row col-12 justify-content-between">
                    <div>
                        <h2>Detalle del Servicio Tercero</h2>
                    </div>
                </div>
            </div>
            <div class="table-cont-single">
            <form class="form" id="cambiarEstadoOS" method="POST" action="{{route('visualizarServicioTercero.store')}}" role="form" value="Submit" autocomplete="off">
                @csrf
                <input type="hidden" name="estado" value="{{$estado}}">
                @if(isset($lineasOrdenesServicio))<input type="hidden" name="idOrdenServicio" value="{{$orden_servicio->id_orden_servicio}}">@endif
                <table id="tablaDetalleOS" class="table text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 6%;">#</th>
                            <th scope="col" style="width: 16%;">CODIGO</th>
                            <th scope="col" style="width: 44%;">DESCRIPCION</th>
                            <th scope="col" style="width: 44%;">COSTO UNITARIO (SIN IGV)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($serviciosTerceros))
                            @foreach( $serviciosTerceros as $servicioTercero)
                            <tr>
                                <input type="hidden" name="servicioTerceroSolicitado-{{$loop->iteration}}" value="{{$servicioTercero->id_servicio_tercero_solicitado}}">
                                <th scope="row\">{{$loop->iteration}}</th>
                                <td>{{$servicioTercero->getCodigoServicioTercero()}}</td>
                                <td>{{$servicioTercero->getDescripcion()}}</td>
                                <td><input name="costo-{{$loop->iteration}}" class="form-control w-50 mx-auto"></td>
                            </tr>
                            @endforeach
                        @endif
                        @if(isset($lineasOrdenesServicio))
                            @foreach( $lineasOrdenesServicio as $lineaOrdenServicio)
                            <tr>
                                <th scope="row\">{{$loop->iteration}}</th>
                                <td>{{$lineaOrdenServicio->getCodigoServicioTercero()}}</td>
                                <td>{{$lineaOrdenServicio->getDescripcionServicio()}}</td>
                                <td>{{App\Helper\Helper::obtenerUnidadMonedaCambiar($lineaOrdenServicio->ordenServicio->moneda)}} {{$lineaOrdenServicio->valor_costo}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </form>
            </div>
        </div>  
    </div>
    
    <div class="col-sm-12 p-0 mt-3">
        <div class="row justify-content-center m-0">
            @if($estado == 'generado')<button id="btnAprobarOS" form="cambiarEstadoOS" type="submit" value="Submit" style=" margin-left:15px" class="btn btn-danger">Aprobar</button>@endif
            @if($estado == 'sin_generar')<button id="btnGenerarOS" form="cambiarEstadoOS" type="submit" value="Submit" style=" margin-left:15px" class="btn btn-success">Generar</button>@endif
            @if($estado == 'aprobado')<a href="{{route('hojaOrdenServicio',['id_orden_servicio'=>$orden_servicio->id_orden_servicio, 'id_proveedor' => $proveedor->id_proveedor, 'id_recepcion_ot' => $id_recepcion_ot, 'id_hoja_trabajo' => $id_hoja_trabajo])}}"><button id="btnGuardarHojaTrabajo" style=" margin-left:15px" class="btn btn-danger">Imprimir</button></a>@endif
        </div>
    </div>


</div>
@endsection