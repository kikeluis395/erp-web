@extends('contabilidadv2.layoutCont')
@section('titulo', 'Nota de Ingreso Regular')

@section('content')
 

    <div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white; padding: 10px 10px 10px 10px">
        <div class="row justify-content-between col-12">
            <h2 class="ml-3 mt-3 mb-0">Movimiento Almacén</h2>
        
        </div>
        <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la solicitud</p>
        @if (session('noDisponible'))
            <div class="alert alert-danger" role="alert">
                {{ session('noDisponible') }}
            </div>
        @endif

        @if (session('finalizado'))
            <div class="alert alert-success" role="alert">
                @if (isset($rutaDescarga) && $rutaDescarga != '')
                    <a href="{{ $rutaDescarga }}">Descargar</a>
                @endif
                {{ session('finalizado') }}
            </div>
        @endif

        <div class="mb-3 w-100">
            <div class="col-sm-12 px-0">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">
                            
                                Registrar Ingreso
                          
                        </h4>
                    </div>
                    <div class="card-body" style="padding: 27px">

                        <div class="row">
                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="empresa">Empresa: </label>
                                <input id="empresa" name="empresa" class="form-control col-10" type="text"
                                    value="{{ $empresa }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="sucursal">Sucursal: </label>
                                <input id="sucursal" name="sucursal" class="form-control col-10" type="text"
                                    value="{{ $sucursal }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="almacen">Almacen: </label>
                                <input id="almacen" name="almacen" class="form-control col-10" type="text"
                                    value="{{ $almacen }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="documento_oc">Documento: </label>
                                <input id="documento_oc" name="documento_oc" class="form-control col-10" type="text"
                                    value="{{ $documento_oc }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="documento_oc">Fecha creación: </label>
                                <input id="fecha_creacion" name="fecha_creacion" class="form-control col-10" type="text"
                                    value="{{ $fecha_creacion }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="moneda">Moneda: </label>
                                <input id="moneda" name="moneda" class="form-control col-10" type="text"
                                    value="{{ $moneda }}" disabled />
                            </div>


                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="usuario_creador">Usuario creador OC: </label>
                                <input id="usuario_creador" name="usuario_creador" class="form-control col-10" type="text"
                                    value="{{ $usuario_creador }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="motivo">Motivo: </label>
                                <input id="motivo" name="motivo" class="form-control col-10" type="text"
                                    value="{{ $motivo }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="detalle_motivo">Detalle de Motivo: </label>
                                <input id="detalle_motivo" name="detalle_motivo" class="form-control col-10" type="text"
                                    value="{{ $detalle_motivo }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="fecha_creacion">Proveedor: </label>
                                <input id="ruc_proveedor" name="ruc_proveedor" class="form-control col-10" type="text"
                                    value="{{ $ruc_proveedor }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="fecha_creacion">Contacto: </label>
                                <input id="contacto_proveedor" name="contacto_proveedor" class="form-control col-10"
                                    type="text" value="{{ $contacto_proveedor }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="telf_proveedor">Teléfono: </label>
                                <input id="telf_proveedor" name="telf_proveedor" class="form-control col-10" type="text"
                                    value="{{ $telf_proveedor }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="email_contacto_proveedor">Email: </label>
                                <input id="email_contacto_proveedor" name="email_contacto_proveedor"
                                    class="form-control col-10" type="text" value="{{ $email_contacto_proveedor }}"
                                    disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="direccion_proveedor">Dirección: </label>
                                <input id="direccion_proveedor" name="direccion_proveedor" class="form-control col-10"
                                    type="text" value="{{ $direccion_proveedor }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="departamento_proveedor">Departamento: </label>
                                <input id="departamento_proveedor" name="departamento_proveedor" class="form-control col-10"
                                    type="text" value="{{ $departamento_proveedor }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="provincia_proveedor">Provincia: </label>
                                <input id="provincia_proveedor" name="provincia_proveedor" class="form-control col-10"
                                    type="text" value="{{ $provincia_proveedor }}" disabled />
                            </div>

                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="distrito_proveedor">Distrito: </label>
                                <input id="distrito_proveedor" name="distrito_proveedor" class="form-control col-10"
                                    type="text" value="{{ $distrito_proveedor }}" disabled />
                            </div>
           
                            <div class="form-group row col-3 ">
                                <label class="col-12 " for="almacen">Fecha Emision: </label>
                                <input form="formRegistrarIngresoRegular" id="fechaEmision" placeholder="dd/mm/aaaa" autocomplete="off"
                                        data-validation-format="dd/mm/yyyy" data-validation-length="10" name="fechaEmision"
                                        class="datepicker form-control col-10" type="text" value="{{ $fecha_emision }}" @if($edited) disable @endIf/>
                            </div>

                            <div class="form-group row col-6">
                                <div class="col-6">
                                    <label class="col-12 col-form-label form-control-label justify-content-end"
                                    for="guiaRemisionSol">Guía Remisión:
                                </label>
                                <input id="guiaRemisionSol" name="guiaRemisionSol" form="formRegistrarIngresoRegular"
                                        class="form-control col-10" type="text" placeholder="Numero de Guia de remision" value="{{$guiaRemision}}"/>
                                </div>
                                <div class="col-3">
                                    <br>
                                    @if($edited)
                            {{-- esto es para imprimir --}}
                                @if($tipo=="VEHICULO")
                                <div class="form-group row col-12">
                                    <a href="/hojaNotaIngresoVehiculoNuevo?id_nota_ingreso={{$id_nota_ingreso}}"><button type="button" class="btn btn-secondary" data-dismiss="modal">Imprimir</button></a>                            
                                </div>
                                @else
                                <div class="form-group row col-12">
                                    <a href="/hojaNotaIngreso?id_nota_ingreso={{$id_nota_ingreso}}"><button type="button" class="btn btn-secondary" data-dismiss="modal">Imprimir</button></a>                            
                                </div>
                                @endIf
                            @endIf
                                </div>
                                
                                
                            </div>

      

                            <div class="form-group row col-6">
                                <label class="col-12 col-form-label form-control-label justify-content-end"
                                    for="observaciones">Observaciones: </label>
                              
                                    <input id="observaciones" name="observaciones" form="formRegistrarIngresoRegular"
                                        class="form-control col-10 " type="text"   value="{{$observaciones}}"/>
                               
                            </div>

                            
                            
                            <div class="form-group row col-3 d-none">       
                                <input id="id_nota_ingreso" name="id_nota_ingreso" form="formRegistrarIngresoRegular"
                                        class="form-control col-10 " type="text" value="{{$id_nota_ingreso}}" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

       
            <form class="form" id="formRegistrarIngresoRegular" method="POST" action="{{ route('ingresoRegular.store') }}" 
                value="Submit" autocomplete="off">
                @csrf
              
                <div class="table-responsive borde-tabla tableFixHead">
                    <div class="table-wrapper">

                        <div class="table-title">
                            <div class="row col-12 justify-content-between">
                                <div>
                                    <h2>Detalle del movimiento</h2>
                                </div>

                            </div>
                        </div>

                       
                            <div class="table-cont-single">
                                <table id="tablaDetalleSol" class="table text-center table-striped table-sm" @if ($motivo == 'CTALLER') tipo="ctaller" @endif>
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 5%;">#</th>
                                            <th scope="col" style="width: 13%;">CÓDIGO</th>
                                            <th scope="col" style="width: 25%;">DESCRIPCION</th>
                                            <th scope="col" style="width: 13%;">CANTIDAD SOLICITADA</th>
                                            <th scope="col" style="width: 13%;">CANTIDAD INGRESADA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!$edited)
                                        @foreach ($lineasRepuesto as $lineaRepuesto)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td><input
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                        class="form-control" value="{{ $lineaRepuesto->getCodigoRepuesto() }}"
                                                        disabled />
                                                </td>

                                                <td><input
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                        class="form-control"
                                                        value="{{ $lineaRepuesto->getDescripcionRepuesto() }}" disabled />
                                                </td>

                                                <td><input
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                        class="form-control" value="{{ $lineaRepuesto->cantidad }}" disabled />
                                                </td>

                                                <td><input type="number" min="0"
                                                        max="{{ $lineaRepuesto->obtenerCantidadRestante() }}"
                                                        id="cant-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                        name="cant-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;"
                                                        class="form-control"
                                                        value="{{ $lineaRepuesto->obtenerCantidadRestante() }}" /></td>                                              
                                            </tr>
                                        @endforeach
                                        @else
                                            @foreach ($lineasNotaIngreso as $lineaNotaIngreso)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td><input
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                        class="form-control" value="{{ $lineaNotaIngreso->lineaOrdenCompra->getCodigoRepuesto() }}"
                                                        disabled />
                                                </td>

                                                <td><input
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                        class="form-control"
                                                        value="{{ $lineaNotaIngreso->lineaOrdenCompra->getDescripcionRepuesto() }}" disabled />
                                                </td>

                                                <td><input
                                                        style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                        class="form-control" value="{{ $lineaNotaIngreso->lineaOrdenCompra->cantidad }}" disabled />
                                                </td>

                                                <td><input
                                                    style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                    class="form-control" value="{{ $lineaNotaIngreso->cantidad_ingresada }}" disabled />
                                                </td>

                                               
                                            </tr>
                                            @endforeach
                                        @endiF
                                    </tbody>
                                </table>
                            </div>
                        
                    </div>
                </div>

                
                @if($edited)
                <div class="col-sm-12 p-0 mt-3">
                    <div class="row justify-content-end m-0">
                        <button id="btnGuardarIngresoRegular" value="Submit" type="submit" formaction="{{route('ingresoRegular.update')}}" form="formRegistrarIngresoRegular"
                            style=" margin-left:15px" class="btn btn-success">
                            Actualizar
                        </button>
                    </div>
                </div>
                @else
                <div class="col-sm-12 p-0 mt-3">
                    <div class="row justify-content-end m-0">
                        <button id="btnGuardarIngresoRegular" value="Submit" type="submit" form="formRegistrarIngresoRegular"
                            style=" margin-left:15px" class="btn btn-success">
                            GENERAR COMPRA
                        </button>
                    </div>
                </div>
                @endIf
            </form>
        


    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>


    </script>
@endsection
