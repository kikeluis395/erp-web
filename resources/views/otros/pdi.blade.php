@extends('repuestos.repuestosCanvas')
@section('titulo','PDI Checklist')

@section('pretable-content')

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row justify-content-between col-12">
        <h2 class="ml-3 mt-3 mb-0">PDI Checklist</h2>
        <div class="justify-content-end">
            <a href="{{url()->previous()}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
        </div>
    </div>
    <p class="ml-3 mt-3 mb-4"></p>
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">FOR - 001 - AUT</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="formGenerarFactura" method="GET" action="{{route('hojaInspeccionVehiculo')}}" role="form"  autocomplete="off">
                            <div class="row">
                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="id_recepcion_ot"> # OT: </label>
                                    <div class="col-sm-8">
                                        <input id="id_recepcion_ot" name="id_recepcion_ot" class="form-control w-100" type="text" >
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="modelo">Modelo: </label>
                                    <div class="col-sm-8">
                                        @if(isset($hojaInspeccion))
                                        <input id="modelo" name="modelo" class="form-control w-100" type="text" value="{{$hojaInspeccion->modelo}}">
                                        @else
                                        <input id="modelo" name="modelo" class="form-control w-100" type="text">
                                        @endIf
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="ano-modelo">Año Modelo: </label>
                                    <div class="col-sm-8">
                                        @if(isset($hojaInspeccion))
                                        <input id="ano-modelo" name="ano-modelo" class="form-control w-100" type="text" value="{{$hojaInspeccion->ano_modelo}}">
                                        @else
                                        <input id="ano-modelo" name="ano-modelo" class="form-control w-100" type="text" >
                                        @endIf
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="vin">VIN: </label>
                                    <div class="col-sm-8">
                                         @if(isset($hojaInspeccion))
                                        <input id="vin" name="vin" class="form-control w-100" type="text" value="{{$hojaInspeccion->vin}}">
                                        @else
                                        <input id="vin" name="vin" class="form-control w-100" type="text" >
                                        @endIf
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="color">Color: </label>
                                    <div class="col-sm-8">
                                        @if(isset($hojaInspeccion))
                                        <input id="color" name="color" class="form-control w-100" type="text" value="{{$hojaInspeccion->color}}">
                                        @else
                                            <input id="color" name="color" class="form-control w-100" type="text" >
                                        @endIf
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="fecha-traslado">Fecha de traslado: </label>
                                    <div class="col-sm-8">
                                        <input id="fecha-traslado" name="fecha-traslado" class="form-control w-100" type="text" disabled>
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="inspector">Inspector: </label>
                                    <div class="col-sm-8">
                                        <input id="inspector" name="inspector" class="form-control w-100" type="text" disabled>
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="destino">Destino: </label>
                                    <div class="col-sm-8">
                                        @if(isset($hojaInspeccion))
                                        <input id="destino" name="destino" class="form-control w-100" type="text" value="{{$hojaInspeccion->destino}}">
                                        @else
                                        <input id="destino" name="destino" class="form-control w-100" type="text" >
                                        @endIf
                                    </div>
                                </div>



                            </div>
                           

                            <!-- div de tabs  -->
                           
                            <div>
                                <ul class="nav nav-tabs flex-column nav-pills">
                                <li class="nav-item">                                
                                    <a class="nav-link"  id="nav-preparacion-pdi-tab" data-toggle="tab" href="#nav-preparacion-pdi" role="tab" aria-controls="nav-preparacion-pdi" aria-selected="true">PREPARACION PDI</a>
                                </li>
                                <li class="nav-item">                                
                                    <a class="nav-link"  id="nav-debajo-del-cofre-motor-apagado-tab" data-toggle="tab" href="#nav-debajo-del-cofre-motor-apagado" role="tab" aria-controls="nav-debajo-del-cofre-motor-apagado" aria-selected="true">1 DEBAJO DEL COFRE: Motor apagado</a> 
                                </li>
                                
                                <li class="nav-item">                                
                                    <a class="nav-link"  id="nav-exterior-tab" data-toggle="tab" href="#nav-exterior" role="tab" aria-controls="nav-exterior" aria-selected="true">2 EXTERIOR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"  id="nav-debajo-del-vehiculo-tab" data-toggle="tab" href="#nav-debajo-del-vehiculo" role="tab" aria-controls="nav-debajo-del-vehiculo" aria-selected="true">3 DEBAJO DEL VEHICULO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"  id="nav-interior-apagado-tab" data-toggle="tab" href="#nav-interior-apagado" role="tab" aria-controls="nav-interior-apagado" aria-selected="true">4 INTERIOR: Motor apagado</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"  id="nav-interior-encendido-tab" data-toggle="tab" href="#nav-interior-encendido" role="tab" aria-controls="nav-interior-encendido" aria-selected="true">5 INTERIOR: Motor encendido</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"  id="nav-debajo-del-cofre-motor-encendido-tab" data-toggle="tab" href="#nav-debajo-del-cofre-motor-encendido" role="tab" aria-controls="nav-debajo-del-cofre-motor-encendido" aria-selected="true">6 DEBAJO DEL COFRE: Motor encendido</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-inspeccion-final-tab" data-toggle="tab" href="#nav-inspeccion-final" role="tab" aria-controls="nav-inspeccion-final" aria-selected="false">7 INSPECCION FINAL</a>
                                </li>
                                
                            </ul>

                            </div>
  
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="nav-preparacion-pdi-tab">                            
                                
                                
                                    <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">PREPARACION PDI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    @if($list_checks[3]==true) 
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[1][savar]" checked ></td>
                                                    @else
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[1][savar]" ></td>
                                                    @endif
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[1][dealer]" ></td>
                                                    <td>(1)Desconectar el fusible</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[2][savar]" ></td>
                                                    <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[2][dealer]"></td>
                                                    <td>(2)Activar la BCM (Computadora del vehiculo)</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade " id="nav-debajo-del-cofre-motor-apagado" role="tabpanel" aria-labelledby="nav-debajo-del-cofre-motor-apagado-tab">
                                    <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">1 DEBAJO DEL COFRE: Motor apagado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                <td style="width: 4%;"><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[3][savar]"><span class="checkmark"></span></div></td>
                                                <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[3][dealer]"></td>
                                                    <td>(1) Revisar nivel de refrigerante</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[4][savar]" ><span class="checkmark" ></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(2) Revisar tensión de la banda impulsora</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[5][savar]"><span class="checkmark"></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(3) Revisar nivel del aceite de motor</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[6][savar]" ><span class="checkmark"></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(4) Revisar condición de la bateria</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[7][savar]"><span class="checkmark"></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(5) Revisar nivel liquido de frenos y embriague</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[8][savar]"><span class="checkmark"></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(6) Revisar nivel del aceite de la dirección hidraulica</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[9][savar]"><span class="checkmark"></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(7) Revisar nivel de liquido de limpiaparabrisas</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[10][savar]"><span class="checkmark"></span></div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(8) Revisar que no exista fuga de liquidos</td>
                                                </tr>



                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-exterior" role="tabpanel" aria-labelledby="nav-exterior-tab">
                                        <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">2 EXTERIOR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                <td style="width: 4%;"><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[11][savar]"></div></td>
                                                <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[11][dealer]"></td>
                                                    <td>(1) Instalacion de gata y herramientas</td>
                                                </tr>
                                                <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[12][savar]"> </div></td>
                                                <td style="width: 4%;"> </td>
                                                    <td>(2) Revision de presion de llanta de repuesto</td>
                                                </tr>

                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[13][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(3) Colocar tapa de remolque dentro del vehiculo</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[14][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(4) Colocar copa de aros dentro del vehiculo</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[15][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(5) Ajustar tuercas de llanta</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[16][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(6) Revisar presion de llantas</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[17][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(7) Revisar operacion del cofre de motor</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[18][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(8) Revisar operacion de la tapa de combustible</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[19][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(9) Revisar operacion de cerraduras y seguros de puerta</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[20][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(10) Revisar operacion de cajuela/puerta trasera</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[21][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(11) Revisar operacion del mecanismo de seguro de niños</td>
                                                </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-debajo-del-vehiculo" role="tabpanel" aria-labelledby="nav-debajo-del-vehiculo-tab">
                                <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">3 DEBAJO DEL VEHICULO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                <td style="width: 4%;"><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[22][savar]"> </div></td>
                                                <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck22" name="listaElementosInspeccion[22][dealer]"> </td>
                                                    <td>(1) Revisar daños y defectos de llantas</td>
                                                </tr>
                                                <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[23][savar]"> </div></td>
                                                <td style="width: 4%;" > </td>
                                                    <td>(2) Revisar fugas de liquido</td>
                                                </tr>

                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[24][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(3) Apretar tornillos/ tuercas de suspensión y tren motriz</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[25][savar]"> </div></td>
                                                    <td style="width: 4%;"> </td>
                                                    <td>(4) Revisar tubo de escape</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[26][savar]"> </div></td>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[26][dealer]"> </td>
                                                    <td>(5) Revisar daños de carroceria</td>
                                                </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-interior-apagado" role="tabpanel" aria-labelledby="nav-interior-apagado-tab">
                                <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">4 INTERIOR: Motor apagado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                <td style="width: 4%;"><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[27][savar]"> </div></td>
                                                <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[27][dealer]"> </td>
                                                    <td>(1) Revisar operacion del asiento</td>
                                                </tr>
                                                <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[28][savar]"> </div></td>
                                                <td style="width: 4%;"></td>
                                                <td>(2) Revisar operación del cinturon de seguridad de asientos</td>
                                                </tr>

                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[29][savar]"> </div></td>
                                                    <td style="width: 4%;"></td>
                                                    <td>(3) Revisar operación del timon</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[30][savar]"> </div></td>
                                                    <td style="width: 4%;"></td>
                                                    <td>(4) Revisar operación de la tapa de la tapa de guantera, consola y encenderlo (Si aplica)</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[31][savar]"> </div></td>
                                                    <td style="width: 4%;"></td>
                                                    <td>(5) Revisar operación de switch de bloqueo de puertas</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[32][savar]"> </div></td>
                                                    <td style="width: 4%;"></td>
                                                    <td>(6) Ajustar hora</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[33][savar]"> </div></td>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[33][dealer]"> </td>
                                                    <td>(7) Verificar sistema de audio (radio, CD, USB)</td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[34][savar]"> </div></td>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[34][dealer]"> </td>
                                                    <td>(8) Verificar funcionamiento del sistema de navegacion (si aplica)</td>
                                                </tr>

                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[35][savar]"> </div></td>
                                                    <td style="width: 4%;"></td>
                                                    <td>(9) Revisar operaciones de espejos retrovisores </td>
                                                </tr>
                                                <tr>
                                                    <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[36][savar]"> </div></td>
                                                    <td style="width: 4%;"></td>
                                                    <td>(10) Revisar operación de sujetador de lentes de sol</td>
                                                </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-interior-encendido" role="tabpanel" aria-labelledby="nav-interior-encendidot-tab">
                                <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="3" style="width: 2%;">5 INTERIOR: Motor encendido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td style="width: 4%;"><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[37][savar]"> </div></td>
                                                <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[37][dealer]"> </td>
                                                <td>(1) Revisar luces de emergencia</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[38][savar]"> </div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[38][savar]"> </td>
                                                <td >(2) Encender el motor y detectar ruidos</td>
                                            </tr>
                                            <tr>
                                            <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[39][savar]" ><span class="checkmark" > </span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[39][dealer]"> </td>
                                                <td >(3) Verificar el arranque de motor c/todas las llaves</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[40][savar]"> </div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[40][dealer]"> </td>
                                                <td>(4) Revisar el tablero de instrumento</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[41][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[41][dealer]"></td>
                                                <td>(5) Revisar luces interiores</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[42][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[42][dealer]"></td>
                                                <td>(6) Revisar luces delanteras</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[43][savar]" ><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[43][savar]"></td>
                                                <td>(7) Revisar luces posteriores</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[44][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[44][dealer]"></td>
                                                <td>(8) Revisar bocina (Claxon)</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[45][savar]" ><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[45][dealer]"></td>
                                                <td>(9) Revisar limpiaparabrisas y lavaparabrisas</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[46][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[46][dealer]"></td>
                                                <td>(10) Revisar operación de controles de timón </td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[47][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[47][savar]"></td>
                                                <td>(11) Revisar operación del aire acondicionado y calefacción</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[48][savar]" ><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[48][dealer]"></td>
                                                <td>(12) Revisar desempañador de cristal posterior</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block," name="listaElementosInspeccion[49][savar]" ><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[49][dealer]"></td>
                                                <td>(13) Revisar operación de sunroof (Si aplica)</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[50][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[50][dealer]"></td>
                                                <td>(14) Revisar operación de ventanillas</td>
                                            </tr>
                                            <tr>
                                                <td><div class="container"><input type="checkbox" style=" display: block,"  name="listaElementosInspeccion[51][savar]"><span class="checkmark"></span></div></td>
                                                <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[51][dealer]"></td>
                                                <td>(15) Revisar camara y sensores</td>
                                            </tr>
                                    </tbody>
                                </table>
                                </div>
                                <div class="tab-pane fade" id="nav-debajo-del-cofre-motor-encendido" role="tabpanel" aria-labelledby="nav-debajo-del-cofre-motor-encendido-tab">
                                <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">6 DEBAJO DEL COFRE DE MOTOR: Motor encendido</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; "  name="listaElementosInspeccion[52][savar]"></td>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[52][dealer]"></td>
                                                    <td>(1) Condición de marcha minima</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[53][savar]" ></td>
                                                    <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[53][dealer]"></td>
                                                    <td>(2) Nivel de aceite en T/A</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[54][savar]" ></td>
                                                    <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[54][dealer]"></td>
                                                    <td>(3) Fuga de gas refrigerante del aire acondicionado</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-inspeccion-final" role="tabpanel" aria-labelledby="nav-inspeccion-final-tab" >
                                <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="3" style="width: 2%;">7 INSPECCION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; "  name="listaElementosInspeccion[55][savar]"></td>
                                                    <td style="width: 4%;"><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1" name="listaElementosInspeccion[55][dealer]"></td>
                                                    <td>(1)Revisar carroceria e imperfecciones de pintura</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; "  name="listaElementosInspeccion[56][savar]"></td>
                                                    <td></td>
                                                    <td>(2)Verificar ajuste y alineación de carroceria</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[57][savar]" ></td>
                                                    <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1"></td>
                                                    <td>(3)Verificación de molduras, emblemas y etiquetas (si aplica)</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" style=" display: block, text-color: green!important; border-color: #78a775 !important; " name="listaElementosInspeccion[58][savar]" ></td>
                                                    <td><input type="checkbox" style=" display: block, background-color: green!important;" id="exampleCheck1"></td>
                                                    <td>(4)Verificar documentos pertinentes de la guantera</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>

                            <!-- END DE TABS -->

                            

                            <div class="row justify-content-end">
                                <!-- @if(!isset($motivo))
                                <button class="btn btn-primary justify-content-end mr-3" form="formGenerarFactura" type="submit" value="Submit2">
                                    Siguiente
                                </button>
                                @endif -->
                                <button class="btn btn-success justify-content-end mr-3 btn-nota-credito" id="btn-nota-credito" type="button" onclick="alert('Imprimiendo PDI')">
                                 Imprimir PDI
                                </button>
                                <button class="btn btn-primary justify-content-end mr-3 btn-nota-credito" id="btn-nota-credito" type="submit" >
                                 Guardar PDI
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </br>
        </br>
    
</div>
<script>



</script>
<style>
.nav {
  overflow-x: auto;
  overflow-y: hidden;
  height: 115px;
}

.nav-item {
  cursor: pointer;
  margin: 15px 10px;
  width: 150px;
  height: 80px;
  box-shadow: 0 4px 6px -6px #222;
}

.nav-link {
  margin:5px 0;
  font-size: 14px;
  text-align: center;
}

.nav-item.selected {
  color: #fff;
  background-color: #007bff;
}

.tab-pane {
    padding-left:33%!important;
}

#seccion-preparacion-pdi {
    display: none;
}
#seccion-debajo-del-cofre-motor-apagado {
    display: none;
}
#seccion-exterior {
    display: none;
}
#seccion-debajo-del-vehiculo{
    display: none;
}
#seccion-interior-motor-encendido {
    display: none;
}
#seccion-interior-motor-apagado {
    display: none;
}
#seccion-debajo-del-cofre-motor-encendido {
    display: none;
}
#seccion-inspeccion-final {
    display: none;
}

.checkbox-teal [type="checkbox"]:checked+label:before {
  border-color: transparent #009688 #009688 transparent;
}

.checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
  border-color: #FF8800;
  background-color: #FF8800;
}

.checkbox-rounded [type="checkbox"][class*='filled-in']+label:after {
  border-radius: 50%;
}

.checkbox-living-coral-filled [type="checkbox"][class*='filled-in']:checked+label:after {
  border-color: #FF6F61;
  background-color: #FF6F61;
}

.checkbox-cerulean-blue-filled [type="checkbox"][class*='filled-in']:checked+label:after {
  border-color: #92aad0;
  background-color: #92aad0;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
    padding: 12px 15px;
    vertical-align: middle;
    text-align: initial!important;
}


</style>
@endsection
