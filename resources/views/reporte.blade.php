@extends('header')
@section('extra-style')
<style type="text/css">
    .flecha-cont{
        width:1000px;/* =hola1 */
        margin:50px auto;
    }
    .flecha{
        width: 0; 
        height: 0; 
        border-top: 20px solid transparent;/* lo que quieras =hola2 */
        border-bottom: 20px solid transparent;/* lo que quieras =hola2 */
        border-left: 20px solid red;/* ancho hola1 */
        float:right;
    }
    .rect{
        margin-top:10px;/* calculado hola2 */
        width:980px;/* hola1 */
        background:red;
        height:20px;/* lo que quieras hola2/2 */
        float:left;
    }

    .rect-delgado{
        margin-top:10px;/* calculado hola2 */
        width:980px;/* hola1 */
        background:black;
        height:5px;/* lo que quieras hola2/2 */
        float:left;
    }

    .cont-indicador{
        width: 15px;
        height: 15px;
        margin-left: -7px;/*lo mismo que w/2 de cont-indicador pero en negativo*/
        display: inline-block;
        margin-bottom: 100px; /*mismo que height de linea*/
        margin-top: 20px;/*mismo que height de rect*/
    }
    .linea{
        height: 100px;
        width: 20%; /* hola/2 */
        background: red;
        margin-left: 40%; /*hola*/
    }
    .circulo{
        height: 100%; /*=hola/2*/
        width: 100%;
        background: red;
        border-radius: 50%;
    }
    .indicador-final{
        margin-right: -7px;/*igual que margin-left de cont-indicador*/
    }
    .recuadro{
        border: solid;
        border-width: 2px;
        display: inline-block;
        padding-right:  35px;
        padding-left:   35px;
        padding-top: 5px;
        padding-bottom: 5px
    }
    .recuadro-dias{
        border: solid;
        border-width: 2px;
        display: inline-block;
        padding-right:  30px;
        padding-left:   30px;
        padding-top: 5px;
        padding-bottom: 5px;
        border-color: black;
        color: white;
        background: grey
    }
</style>
@endsection

@section('titulo','Modulo de reportes - Tiempo de estancia')

@section('header-content')
<div style="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12" style="padding: 0;background-color: #efefef;">
                @include('navbar')
                @if(session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    Error: {{session('error')}}
                </div>
                @endif
                <ul class="nav nav-tabs nav-fill flex-row" style="margin-top: 10px;margin-left: 15px;margin-right: 15px">
                    @if(in_array(Auth::user()->id_rol,[1,2,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='recepcion.index') active @endif" href="{{route('recepcion.index')}}">RECEPCIÓN</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,3,4,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='valuacion.index') active @endif" href="{{route('valuacion.index')}}">VALUACIÓN</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,5,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='repuestos.index') active @endif" href="{{route('repuestos.index')}}">REPUESTOS</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,4,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='reparacion.index') active @endif" href="{{route('reparacion.index')}}">REPARACIÓN</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,6,7]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='tecnicos.index') active @endif" href="{{route('tecnicos.index')}}">TÉCNICOS</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,2,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='entrega.index') active @endif" href="{{route('entrega.index')}}">ENTREGA</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='reporte.index') active @endif" href="{{route('reporte.index')}}">REPORTE</a>
                    </li>
                    @endif

                    @if(in_array(Auth::user()->id_rol,[1,6]))
                    <li class="nav-item">
                    <a class="nav-link @if (Route::currentRouteName()=='tipoDanho.index') active @endif" href="{{route('tipoDanho.index')}}">TIPO DAÑO</a>
                    </li>
                    @endif
                </ul>

                <div style="background: white;padding: 10px;margin-left: 15px;margin-right: 15px;font-family: Calibri;font-size: 1.1em">
                    <form method="GET" action="export">
                        <div class="col-12 row">
                        
                            <label for="fechaInicioReporte" class="col-form-label col-6 col-sm-4 col-lg-3">Fecha de Entrega Inicio</label>
                            <input id="fechaInicioReporte" name="fechaInicioReporte" type="text"  autocomplete="off" class="fecha-inicio form-control col-6 col-sm-4 col-md-2" placeholder="Fecha inicio">

                            <div class="col-sm-4 d-md-none"></div>
                        
                            <label for="fechaFinReporte" class="col-form-label col-6 col-sm-4 col-lg-3">Fecha de Entrega Fin</label>
                            <input id="fechaFinReporte" name="fechaFinReporte" type="text"  autocomplete="off" class="fecha-fin form-control col-6 col-sm-4 col-md-2" placeholder="Fecha fin">
                            <a><button class="btn btn-primary" type="submit">Exportar</button></a>
                        
                        </div>
                    
                    </form>
                    @if($data_presente)
                    <h1 style="text-align: center;">Tiempo Promedio de Estancia</h1>

                    <div class="flecha-cont">
                        <div class="recuadro" style="margin-left: 35%;">TIEMPO DE ESTANCIA</div>
                        <div class="recuadro-dias">
                            @if($tiempo_estancia)
                            {{$tiempo_estancia}} días
                            @else
                            No info
                            @endif
                        </div>
                        
                        <div class="rect-delgado">
                        </div>
                    </div>

                    <div class="flecha-cont" style="margin-bottom: 100px">
                        <div class="recuadro" style="margin-left: 30%;padding-right: 50px;padding-left: 50px">TIEMPO DE TÉRMINO OPERATIVO</div>
                        <div class="recuadro-dias">
                            @if($tiempo_termino_global)
                            {{$tiempo_termino_global}} días
                            @else
                            No info
                            @endif
                        </div>

                        <div class="rect-delgado" style="width: 85%">
                        </div>
                    </div>

                    <div class="flecha-cont">
                        <div class="rect">
                            <div class="cont-indicador">
                                <div class="linea">
                                </div>
                                <div class="circulo">
                                </div>
                            </div>
                            <p class="cont-indicador" style="position: absolute;margin-left: -45px;margin-top: 135px">
                                INGRESO
                            </p>
                            <div class="recuadro-dias" style="display: block;position: absolute;margin-top: -175px;margin-left: 43px">
                                @if($tiempo_valuacion)
                                {{$tiempo_valuacion}} días
                                @else
                                No info
                                @endif
                            </div>

                            <div class="cont-indicador" style="margin-left: 18%">
                                <div class="linea" style="height: 100px">
                                </div>
                                <div class="circulo">
                                </div>
                            </div>
                            <p class="cont-indicador" style="position: absolute;margin-left: -45px;margin-top: 135px">
                                Valuación
                            </p>
                            <div class="recuadro-dias" style="display: block;position: absolute;margin-top: -175px;margin-left: 235px">
                                @if($tiempo_autorizacion)
                                {{$tiempo_autorizacion}} días
                                @else
                                No info
                                @endif
                            </div>


                            <div class="cont-indicador" style="margin-left: 18%">
                                <div class="linea">
                                </div>
                                <div class="circulo">
                                </div>
                            </div>
                            <p class="cont-indicador" style="position: absolute;margin-left: -45px;margin-top: 135px">
                                Autorización
                            </p>
                            <div class="recuadro-dias" style="display: block;position: absolute;margin-top: -175px;margin-left: 425px">
                                @if($tiempo_asignacion)
                                {{$tiempo_asignacion}} días
                                @else
                                No info
                                @endif
                            </div>


                            <div class="cont-indicador" style="margin-left: 18%">
                                <div class="linea">
                                </div>
                                <div class="circulo">
                                </div>
                            </div>
                            <p class="cont-indicador" style="position: absolute;margin-left: -45px;margin-top: 135px">
                                Asignación
                            </p>
                            <div class="recuadro-dias" style="display: block;position: absolute;margin-top: -175px;margin-left: 620px">
                                @if($tiempo_termino_local)
                                {{$tiempo_termino_local}} días
                                @else
                                No info
                                @endif
                            </div>


                            <div class="cont-indicador" style="margin-left: 18%">
                                <div class="linea">
                                </div>
                                <div class="circulo">
                                </div>
                            </div>
                            <p class="cont-indicador" style="position: absolute;margin-left: -35px;margin-top: 135px;">
                                Término Operativo
                            </p>
                            <div class="recuadro-dias" style="display: block;position: absolute;margin-top: -175px;margin-left: 820px">
                                @if($tiempo_entrega_local)
                                {{$tiempo_entrega_local}} días
                                @else
                                No info
                                @endif
                            </div>


                            <div class="cont-indicador indicador-final" style="float: right">
                                <div class="linea">
                                </div>
                                <div class="circulo">
                                </div>
                            </div>
                            <p class="cont-indicador" style="position: absolute;margin-left: 160px;margin-top: 135px">
                                SALIDA
                            </p>
                        </div>

                        <div class="flecha">
                        </div>
                    </div>
                    @else
                    <h1 style="text-align: center;">No hay datos registrados aún</h1>
                    @endif
                </div>

                <div style="padding: 10px;margin-left: 15px;margin-right: 15px;background: white;">
                    <div class="col-12 col-lg-4" style="margin-top:180px">
                        <h3>Evaluación de Performance</h3>
                        <table class="table table-sm table-striped">
                            <tbody>
                                <tr><td>Cumplimiento de F.P.E</td>      <td class="text-right">{{$cumplimiento_fpe}}</td></tr>
                                <tr><td>% Ampliaciones</td>             <td class="text-right">{{$porc_ampliaciones}}</td></tr>
                                <tr><td>% Vehículo con estado HL</td>   <td class="text-right">{{$porc_hl}}</td></tr>
                                <tr><td>% Vehículo con MECColision</td> <td class="text-right">{{$porc_mec_colision}}</td></tr>
                                <tr><td>Pérdidas Totales</td>           <td class="text-right">{{$perdidas_totales}}</td></tr>
                                <tr><td>HorasMEC Facturadas</td>        <td class="text-right">{{$horas_mec}}</td></tr>
                                <tr><td>HorasCAR Facturadas</td>        <td class="text-right">{{$horas_car}}</td></tr>
                                <tr><td>Paños Facturados</td>           <td class="text-right">{{$panhos}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')
    <script src="{{asset('js/autorefresh.js')}}"></script>
@endsection