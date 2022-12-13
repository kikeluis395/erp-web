@extends('contabilidadv2.sinTypeAhead')
@section('titulo', 'Registrar Solicitud Repuestos')
@section('variables_extras')
    <script>
        var motivosIn = {!! App\Helper\Helper::motivosIn() !!}
        var motivosOut = {!! App\Helper\Helper::motivosOut() !!}
    </script>
@endsection
@section('content')
    @php
    $grid = isset(request()->tipoTransaccion) ? (request()->tipoTransaccion === 'out' ? '4' : '3') : '3';
    @endphp

    <div id="containerMec"
         class="mx-auto"
         style="overflow-y:auto;background: white; padding: 10px 10px 10px 10px">
        <div class="row justify-content-between col-12">
            <h2 class="ml-3 mt-3 mb-0">Movimiento Almacén</h2>
            <div class="justify-content-end">
                @isset(request()->motivoSol)
                    <a href="{{ route('reingresoRepuestos.index') }}"><button type="button"
                                class="btn btn-info mt-4">Cancelar Transacción</button></a>
                @endisset
            </div>
        </div>
        <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la solicitud</p>
        @if (session('noDisponible'))
            <div class="alert alert-danger"
                 role="alert">
                {{ session('noDisponible') }}
            </div>
        @endif

        @if (session('finalizado'))
            <div class="alert alert-success"
                 role="alert">
                @if (isset($rutaDescarga) && $rutaDescarga != '')
                    <a href="{{ $rutaDescarga }}">Descargar</a>
                @endif
                {{ session('finalizado') }}
            </div>
        @endif

        <div class="mb-3 w-100">
            <div class="col-sm-12 px-0">
                <div class="card shadow-sm">
                    <div class="card-header"
                         style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">
                            @if (!isset(request()->motivoSol))
                                Registrar Movimiento Almacén
                            @endif
                            @isset(request()->motivoSol)
                                @switch(request()->motivoSol)
                                    {{-- @case('COMPRAS')
                                        
                                    @break --}}
                                    @case('TALLER')
                                        RE-INGRESO DE TALLER
                                    @break
                                    @case('DEVOLUCION')
                                        DEVOLUCIÓN A PROVEEDOR
                                    @break
                                    @case('CTALLER')
                                        CONSUMO DE TALLER
                                    @break
                                    @default
                                        Registrar Movimiento Almacén
                                        @break
                                    @endswitch
                                @endisset
                                {{-- Registrar Movimiento Almacén
                            {{ isset(request()->tipoTransaccion) ? '- ' . Str::upper(request()->tipoTransaccion) : '' }} --}}
                            </h4>
                        </div>
                        <div class="card-body"
                             style="padding: 27px">

                            <div class="row">
                                @isset($motivo)
                                    {{-- <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="empresaInfo">Empresa: </label>
                                    <div class="col-sm-8">
                                        <input id="empresaInfo"
                                               class="form-control w-100"
                                               type="text"
                                               value="PLANETA NISSAN"
                                               disabled>
                                    </div>
                                </div> --}}

                                    <div class="form-group row ml-sm-0 col-sm-{{ $grid }}">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="sucursalInfo">{{ isset(request()->tipoTransaccion) ? (request()->tipoTransaccion === 'out' ? 'Sede' : 'Sucursal') : 'Sucursal' }}:
                                        </label>
                                        <div class="col-sm-8">
                                            <input id="sucursalInfo"
                                                   class="form-control w-100"
                                                   type="text"
                                                   value="LOS OLIVOS"
                                                   disabled>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="almacenInfo">Almacen: </label>
                                    <div class="col-sm-8">
                                        <input id="almacenInfo"
                                               class="form-control w-100"
                                               type="text"
                                               value="ALMACEN CENTRAL NISSAN"
                                               disabled>
                                    </div>
                                </div> --}}

                                    <div class="form-group row ml-sm-0 col-sm-{{ $grid }}">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="fechaEmision">Fecha Emision: </label>
                                        <div class="col-sm-8">
                                            <input id="fechaEmision"
                                                   name="fechaEmision"
                                                   class="form-control w-100"
                                                   type="text"
                                                   value="{{ $fecha_emision }}"
                                                   disabled>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="fechaMovimiento">
                                    @if ($motivo == 'TALLER') Fecha Re-ingreso: @else Fecha Entrega:
                                        @endif
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="fechaMovimiento"
                                               type="text"
                                               autocomplete="off"
                                               class="datepicker form-control w-100 id="
                                               fechaMovimiento"
                                               placeholder="dd/mm/aaaa"
                                               form="formRegistrarSol"
                                               maxlength="10"
                                               autocomplete="off"
                                               value="{{ $fecha_emision }}">
                                    </div>

                                    
                                </div> --}}
                                    <input name="fechaMovimiento"
                                           type="hidden"
                                           autocomplete="off"
                                           id="fechaMovimiento"
                                           placeholder="dd/mm/aaaa"
                                           form="formRegistrarSol"
                                           maxlength="10"
                                           autocomplete="off"
                                           value="{{ $fecha_emision }}">
                                @endisset

                                <div class="form-group row ml-sm-0 col-sm-3 @if (isset($motivo)) d-none @endif">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="fechaEmision">Tipo de
                                        transacción:
                                    </label>
                                    <div class="ml-3 mt-3">
                                        <label for="tipoTransaccionIn">Entrada</label> <input type="radio"
                                               form="formAsignarOCaNI"
                                               value="in"
                                               class="tipoTransaccion"
                                               name="tipoTransaccion"
                                               id="tipoTransaccionIn"
                                               @if (session('tipoTransaccion')) {{ session('tipoTransaccion') == 'in' ? 'checked' : null }} @else {{ isset(request()->tipoTransaccion) && request()->tipoTransaccion == 'in' ? 'checked' : null }} @endif
                                               class="mr-3">
                                        <label class="ml-3"
                                               for="tipoTransaccionOut">Salida</label> <input type="radio"
                                               value="out"
                                               form="formAsignarOCaNI"
                                               class="tipoTransaccion"
                                               name="tipoTransaccion"
                                               id="tipoTransaccionOut"
                                               @if (session('tipoTransaccion')) {{ session('tipoTransaccion') == 'out' ? 'checked' : null }} @else {{ isset(request()->tipoTransaccion) && request()->tipoTransaccion == 'out' ? 'checked' : null }} @endif>
                                    </div>
                                </div>

                                <input type="hidden"
                                       id="sessionMotivoSol"
                                       form="formAsignarOCaNI"
                                       value="@if (session('motivoSol')) {{ session('motivoSol') }}@elseif(isset($motivo)){{ $motivo }} @endif">

                                <div class="form-group row ml-sm-0 col-sm-{{ $grid }}">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="motivoSol">Motivo:</label>
                                    <div class="col-sm-8">
                                        @if (isset($motivo))
                                            <select form="formAsignarOCaNI"
                                                    name="motivoSol"
                                                    id="motivoSol"
                                                    class="form-control w-100"
                                                    size="0"
                                                    disabled>
                                            </select>
                                        @else
                                            <select form="formAsignarOCaNI"
                                                    name="motivoSol"
                                                    id="motivoSol"
                                                    class="form-control w-100"
                                                    size="0"
                                                    @if (isset($motivo)) disabled @endif>
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                @if (!isset($motivo))
                                    <div class="form-group row ml-sm-0 col-sm-3 d-none"
                                         id="divDocRelacionado">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="oCRelacionada"
                                               id="labelDocumentoSol">OC: </label>
                                        <div class="col-sm-8">
                                            <input id="docRelacionado"
                                                   form="formAsignarOCaNI"
                                                   name="docRelacionado"
                                                   class="form-control w-100"
                                                   type="text"
                                                   @if (isset($documento)) value="{{ $numDocumento }}" readonly @endif>
                                            @if (session('oCNoAprobada'))
                                                <div style="color: red;">{{ session('oCNoAprobada') }}</div>
                                            @endif
                                            @if (session('oCNoExiste'))
                                                <div style="color: red;">{{ session('oCNoExiste') }}</div>
                                            @endif
                                            @if (session('oCAtendida'))
                                                <div style="color: red;">{{ session('oCAtendida') }}</div>
                                            @endif

                                            @if (session('oTNoExiste'))
                                                <div style="color: red;">{{ session('oTNoExiste') }}</div>
                                            @endif
                                            @if (session('oTFacturada'))
                                                <div style="color: red;">{{ session('oTFacturada') }}</div>
                                            @endif
                                            @if (session('oTSinRepuestos'))
                                                <div style="color: red;">{{ session('oTSinRepuestos') }}</div>
                                            @endif
                                            @if (session('oTCerrada'))
                                                <div style="color: red;">{{ session('oTCerrada') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                {{-- @isset($motivo)
                                @endisset --}}

                                <div class="form-group row ml-sm-0 col-sm-{{ $grid }} d-none"
                                     id="divDocProveedorSol">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="docProveedorSol">Doc Proveedor: </label>
                                    <div class="col-sm-8">
                                        <input id="docProveedorSol"
                                               form="formAsignarOCaNI"
                                               name="docProveedorSol"
                                               class="form-control w-100 typeahead"
                                               tipo="proveedores"
                                               type="number"
                                               maxlength="11"
                                               @if (isset($rucProveedor)) value="{{ $rucProveedor }}" @endif
                                               disabled>
                                        @if (session('errorDocProveedor'))
                                            <div style="color: red;">{{ session('errorDocProveedor') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row ml-sm-0 col-sm-{{ $grid }} d-none"
                                     id="divNombreProveedorSol">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="nombreProveedorSol">Nombre Proveedor: </label>
                                    <div class="col-sm-8">
                                        <input id="nombreProveedorSol"
                                               name="nombreProveedorSol"
                                               typeahead_second_field="docProveedorSol"
                                               class="form-control w-100"
                                               type="text"
                                               @if (isset($nombreProveedor)) value="{{ $nombreProveedor }}" @endif
                                               disabled>
                                    </div>
                                </div>

                                @isset($motivo)

                                    @if ($motivo == 'COMPRAS')
                                        <div class="form-group row ml-sm-0 col-sm-3">
                                            <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                   for="estadoSol">Estado: </label>
                                            <div class="col-sm-8">

                                                <input id="estadoSol"
                                                       name="estadoSol"
                                                       class="form-control w-100"
                                                       type="text"
                                                       value="@if (isset($documento)) 
                                                       @if ($documento->es_finalizado)Atentido Total
                                            @elseif($documento->flagTieneNotasIngreso())Atendido Parcial
                                        @elseif($documento->es_aprobado)Aprobado @else Pendiente Aprobación @endif
                                            @endif" disabled>
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="form-group row ml-sm-0 col-sm-3">
                                                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="fechaEntrega">Fecha Entrega: </label>
                                                                    <div class="col-sm-8">
                                                                        <input name="fechaEntrega" type="text" class="datepicker form-control w-100" id="fechaEntrega" placeholder="dd/mm/aaaa" value="{{$fecha_emision}}"
                                maxlength="10" autocomplete="off" @if (!isset($documento) || $motivo != 'COMPRAS') disabled @endif>
                                </div>
                                </div> --}}
                                {{-- <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="monedaSol">Moneda: </label>
                                    <div class="col-sm-8">
                                        <input id="monedaSol" name="monedaSol" class="form-control w-100" type="text" @if (isset($documento))
                                            value="{{$moneda}}" @else value="-" @endif disabled>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row ml-sm-0 col-sm-3">
                                                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="tipoCambioSol">Tipo Cambio: </label>
                                                                    <div class="col-sm-8">
                                                                        <input id="tipoCambioSol" name="tipoCambioSol" class="form-control w-100" type="text" @if (isset($documento)) value="{{$tipoCambio}}"
                                @else value="-" @endif disabled>
                                </div>
                                </div> --}}
                                <div class="form-group row ml-sm-0 col-sm-{{ $grid }}">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                           for="responsableSol">Responsable:
                                    </label>
                                    <div class="col-sm-8">

                                        <input id="responsableSol"
                                               name="responsableSol"
                                               class="form-control w-100"
                                               type="text"
                                               value="{{ Auth::user()->username }}"
                                               disabled>

                                    </div>
                                </div>


                                @if ($motivo == 'COMPRAS')
                                    <div class="form-group row ml-sm-0 col-sm-3">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="guiaRemisionSol">Guía Remisión:
                                        </label>
                                        <div class="col-sm-8">
                                            <input id="guiaRemisionSol"
                                                   name="guiaRemisionSol"
                                                   form="formRegistrarSol"
                                                   class="form-control w-100"
                                                   type="text"
                                                   @if (!isset($documento) || $motivo != 'COMPRAS') disabled value="-" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-sm-0 col-sm-3">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="facturaSol">Factura: </label>
                                        <div class="col-sm-8">
                                            <input id="facturaSol"
                                                   name="facturaSol"
                                                   form="formRegistrarSol"
                                                   class="form-control w-100"
                                                   type="text"
                                                   @if (!isset($documento) || $motivo != 'COMPRAS') disabled value="-" @endif>
                                        </div>
                                    </div>
                                @endif

                                @if ($motivo == 'TALLER')
                                    <div class="card"
                                         style="width: 100%;">
                                        <div class="card-body">
                                            <h5 class="card-title">Datos de la OT</h5>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="form-group row col-12">
                                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                               for="modeloOT">OT: </label>
                                                        <div class="col-sm-8">
                                                            <input id="docRelacionado"
                                                                   form="formAsignarOCaNI"
                                                                   name="docRelacionado"
                                                                   class="form-control w-100"
                                                                   type="text"
                                                                   @if (isset($documento)) value="{{ $numDocumento }}" readonly @endif>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group row col-12">
                                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                               for="placaOT">Placa: </label>
                                                        <div class="col-sm-8">
                                                            <input id="placaOT"
                                                                   class="form-control w-100"
                                                                   type="text"
                                                                   value="{{ $documento->hojaTrabajo->placa_auto }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group row col-12">
                                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                               for="vinOT">Vin: </label>
                                                        <div class="col-sm-8">
                                                            <input id="vinOT"
                                                                   class="form-control w-100"
                                                                   type="text"
                                                                   value="{{ $documento->hojaTrabajo->vehiculo->vin }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group row col-12">
                                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                               for="marcaOT">Marca: </label>
                                                        <div class="col-sm-8">
                                                            <input id="marcaOT"
                                                                   class="form-control w-100"
                                                                   type="text"
                                                                   value="{{ $documento->hojaTrabajo->vehiculo->getNombreMarca() }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group row col-12">
                                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                               for="modeloOT">Modelo: </label>
                                                        <div class="col-sm-8">
                                                            <input id="modeloOT"
                                                                   class="form-control w-100"
                                                                   type="text"
                                                                   value="{{ $documento->hojaTrabajo->vehiculo->modelo }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group row col-12">
                                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                                               for="asesorOT">Asesor de Servicios: </label>
                                                        <div class="col-sm-8">
                                                            <input id="asesorOT"
                                                                   class="form-control w-100"
                                                                   type="text"
                                                                   value="{{ $documento->hojaTrabajo->empleado->nombreCompleto() }}"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="form-group col-6 ">
                                            <h5 for="observacionesIn">Motivo:</h5>
                                            <textarea id="observaciones"
                                                      name="motivo"
                                                      type="text"
                                                      class="form-control col-10 ml-3"
                                                      data-validation="length"
                                                      data-validation-error-msg="Debe especificar el DNI o RUC del cliente"
                                                      data-validation-error-msg-container="#errorMotivo"
                                                      form="formRegistrarSol"
                                                      id="observacionesIn"
                                                      maxlength="255"
                                                      rows="3"
                                                      autocomplete="off"
                                                      required></textarea>
                                            <div id="errorMotivo"
                                                 class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                        </div>
                                    </div>
                                @endif

                                @if ($motivo == 'DEVOLUCION')
                                    <div class="form-group row ml-sm-0 col-sm-4">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="seleccionMonedaSol">Moneda:</label>
                                        <div class="col-sm-8">
                                            <select name="moneda"
                                                    id="seleccionMonedaSol"
                                                    class="form-control w-100"
                                                    form="formRegistrarSol"
                                                    size="0">
                                                <option value="SOLES">Soles</option>
                                                <option value="DOLARES">Dólares</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-sm-0 col-sm-4">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="notaCreditoDev">NC Proveedor: </label>
                                        <div class="col-sm-8">
                                            <input id="notaCreditoDev"
                                                   class="form-control w-100"
                                                   type="text"
                                                   form="formRegistrarSol"
                                                   name="nroNotaCredito"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group row ml-sm-0 col-sm-4">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="almacenInfo">Factura Ref Proveedor: </label>
                                        <div class="col-sm-8">
                                            <input id="almacenInfo"
                                                   class="form-control w-100"
                                                   type="text"
                                                   form="formRegistrarSol"
                                                   name="docReferencia">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="form-group col-6 ">
                                            <h5 for="observacionesIn">Motivo:</h5>
                                            <textarea id="observaciones"
                                                      name="motivo"
                                                      type="text"
                                                      class="form-control col-10 ml-3"
                                                      data-validation="length"
                                                      data-validation-error-msg="Debe especificar el DNI o RUC del cliente"
                                                      data-validation-error-msg-container="#errorMotivo"
                                                      form="formRegistrarSol"
                                                      id="observacionesIn"
                                                      maxlength="255"
                                                      rows="3"
                                                      autocomplete="off"
                                                      required></textarea>
                                            <div id="errorMotivo"
                                                 class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
                                        </div>
                                    </div>
                                @endif

                                @if ($motivo == 'CTALLER')
                                    <div class="form-group row ml-sm-0 col-sm-4">
                                        <label class="col-sm-4 col-form-label form-control-label justify-content-end"
                                               for="usuarioSol">Usuario Solicitante: </label>
                                        <div class="col-sm-8">
                                            <input id="usuarioSol"
                                                   class="form-control w-100"
                                                   type="text"
                                                   form="formRegistrarSol"
                                                   name="usuarioSol"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="form-group col-6 ">
                                            <h5 for="observacionesOut">Observaciones:</h5>
                                            <textarea id="observaciones"
                                                      name="observaciones"
                                                      type="text"
                                                      class="form-control col-10 ml-3"
                                                      {{-- data-validation="length"
                                                      data-validation-error-msg="Debe ingresar observaciones"
                                                      data-validation-error-msg-container="#errorMotivo" --}}
                                                      maxlength="255"
                                                      form="formRegistrarSol"
                                                      id="observacionesOut"
                                                      rows="3"
                                                      autocomplete="off"
                                                      {{-- required --}}></textarea>
                                            {{-- <div id="errorMotivo"
                                                 class="col-12 validation-error-cont text-left no-gutters pr-0"></div> --}}
                                        </div>
                                    </div>
                                @endif

                            @endisset
                        </div>
                        <form class="form"
                              id="formAsignarOCaNI"
                              method="GET"
                              action="{{ route('reingresoRepuestos.index') }}"
                              role="form"
                              value="Submit2"
                              autocomplete="off">
                            <div class="row justify-content-end">
                                @if (!isset($motivo))
                                    <button class="btn btn-primary justify-content-end mr-3"
                                            form="formAsignarOCaNI"
                                            type="submit"
                                            value="Submit2">
                                        Siguiente
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @isset($motivo)
            <form class="form"
                  id="formRegistrarSol"
                  method="POST"
                  action="{{ route('reingresoRepuestos.store') }}"
                  role="form"
                  value="Submit"
                  autocomplete="off">
                @csrf
                @if ($motivo === 'DEVOLUCION')
                    <div class="row justify-content-end mr-4">
                        <div class="alert alert-danger rounded-pill px-5"
                             role="alert"
                             align="center">
                            <h5 style="font-weight:bold"
                                class="mb-0">Ingresar valores sin IGV</h5>
                        </div>
                    </div>
                @endif
                <div class="table-responsive borde-tabla tableFixHead">
                    <div class="table-wrapper">

                        <div class="table-title">
                            <div class="row col-12 justify-content-between">
                                <div>
                                    <h2>Detalle del movimiento</h2>
                                </div>
                                @if (isset($motivo) && ($motivo == 'DEVOLUCION' || $motivo == 'CTALLER'))
                                    <div class="row justify-content-end">
                                        <div>
                                            <button id="btnAddLineaDetalleSol"
                                                    type="button"
                                                    style=" margin-left:15px; width:50px; height:50px;"
                                                    class="btn btn-warning rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-plus"
                                                   style="margin-left: 5.9px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @isset($motivo)
                            <div class="table-cont-single">
                                <table id="tablaDetalleSol"
                                       class="table text-center table-striped table-sm"
                                       @if ($motivo == 'CTALLER') tipo="ctaller" @endif>
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                style="width: 5%;">#</th>
                                            <th scope="col"
                                                style="width: 13%;">CÓDIGO</th>
                                            <th scope="col"
                                                style="width: 25%;">DESCRIPCION</th>
                                            @if (isset($motivo) && $motivo == 'COMPRAS')
                                                <th scope="col"
                                                    style="width: 13%;">STOCK</th>
                                            @endif
                                            @if (isset($motivo) && $motivo == 'TALLER')
                                                <th scope="col"
                                                    style="width: 13%;">UBICACION</th>
                                                <th scope="col"
                                                    style="width: 13%;">CANTIDAD ENTREGADA</th>
                                                <th scope="col"
                                                    style="width: 13%;">CANTIDAD A DEVOLVER</th>

                                            @elseif(isset($motivo) && $motivo == "DEVOLUCION")
                                                <th scope="col"
                                                    style="width: 9%;">STOCK DISPONIBLE</th>
                                                <th scope="col"
                                                    style="width: 9%;">UBICACIÓN REPUESTO</th>
                                                <th scope="col"
                                                    style="width: 9%;">CANTIDAD A DEVOLVER</th>
                                                <th scope="col"
                                                    style="width: 9%;"
                                                    id="tablaCostUnitDev">COSTO UNITARIO</th>
                                                <th scope="col"
                                                    style="width: 9%;"
                                                    id="tablaDescUnitDev">DESCUENTO UNITARIO</th>
                                                <th scope="col"
                                                    style="width: 9%;"
                                                    id="tablaImporteTotDev">IMPORTE TOTAL</th>
                                            @elseif(isset($motivo) && $motivo == "CTALLER")
                                                <th scope="col"
                                                    style="width: 9%;">STOCK ACTUAL</th>
                                                <th scope="col"
                                                    style="width: 9%;">UBICACIÓN</th>
                                                <th scope="col"
                                                    style="width: 9%;">CANTIDAD A ENTREGAR</th>
                                                <th scope="col"
                                                    style="width: 9%;"
                                                    id="tablaCostUnitCTaller">COSTO UNITARIO</th>
                                                <th scope="col"
                                                    style="width: 9%;"
                                                    id="tablaImporteTotCTaller">IMPORTE TOTAL</th>
                                            @else
                                                <th scope="col"
                                                    style="width: 13%;">CANTIDAD</th>
                                            @endif
                                            @if (isset($motivo) && $motivo == 'COMPRAS')
                                                <th scope="col"
                                                    style="width: 13%">C. UNIT @if (false)
                                                        ({{ App\Helper\Helper::obtenerUnidadMonedaCambiar($orden_compra->tipo_moneda) }})
                                                    @endif
                                                </th>
                                            @endif
                                            @if (isset($motivo) && $motivo == 'COMPRAS')
                                                <th scope="col"
                                                    style="width: 13%;">TOTAL @if (false)
                                                        ({{ App\Helper\Helper::obtenerUnidadMonedaCambiar($orden_compra->tipo_moneda) }})
                                                    @endif
                                                </th>
                                            @endif
                                            @if (isset($motivo) && ($motivo == 'DEVOLUCION' || $motivo == 'CTALLER'))
                                                {{-- <th scope="col" style="width: 13%;">PRECIO UNITARIO</th>
                                        <th scope="col" style="width: 13%;">PRECIO TOTAL</th> --}}
                                                <th scope="col"
                                                    style="width: 13%;">ELIMINAR</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($documento))
                                            @foreach ($lineasRepuesto as $lineaRepuesto)
                                                @if ($motivo == 'COMPRAS')
                                                    <tr>
                                                        <th scope="row\">{{ $loop->iteration }}</th>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->getCodigoRepuesto() }}"
                                                                   disabled></td>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->getDescripcionRepuesto() }}"
                                                                   disabled></td>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->repuesto->getStock(Auth::user()->empleado()->first()->id_local) }}"
                                                                   disabled></td>
                                                        <td><input type="number"
                                                                   min="0"
                                                                   max="{{ $lineaRepuesto->obtenerCantidadRestante() }}"
                                                                   id="cant-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                                   name="cant-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                                   style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->obtenerCantidadRestante() }}"></td>
                                                        <td><input id="precio-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                                   name="precio-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                                   value="{{ number_format($lineaRepuesto->precio, 2) }}"
                                                                   style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;"
                                                                   class="form-control"
                                                                   disabled></td>
                                                        <td><input id="total-{{ $lineaRepuesto->id_linea_orden_compra }}"
                                                                   style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto; font-weigth: bold;"
                                                                   class="form-control"
                                                                   value="{{ number_format($lineaRepuesto->obtenerTotalRestante(), 2) }}"
                                                                   disabled></td>
                                                    </tr>
                                                @endif
                                                @if ($motivo == 'TALLER')
                                                    <tr>
                                                        <th scope="row\">{{ $loop->iteration }}</th>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->getCodigoRepuesto() }}"
                                                                   disabled></td>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->getDescripcionRepuesto() }}"
                                                                   disabled></td>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->repuesto->ubicacion }}"
                                                                   disabled></td>
                                                        <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"
                                                                   class="form-control"
                                                                   value="{{ $lineaRepuesto->getCantidadAprobada() }}"
                                                                   disabled></td>
                                                        <td><input type="number"
                                                                   min="0"
                                                                   max="{{ $lineaRepuesto->getCantidadAprobada() }}"
                                                                   id="cant-{{ $lineaRepuesto->id_item_necesidad_repuestos }}"
                                                                   name="cant-{{ $lineaRepuesto->id_item_necesidad_repuestos }}"
                                                                   @if ($lineaRepuesto->repuesto->esLubricante()) step="any" @else step="1" @endif
                                                                   style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;"
                                                                   class="form-control"
                                                                   value="0"></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        <tr id="trTotalSol">
                                            <th scope="row\"></th>
                                            <td><input
                                                       style=" display: block; height: 100%; width: 100%; box-sizing: border-box; display: none;">
                                            </td>
                                            <td><input
                                                       style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none; ">
                                            </td>
                                            <td><input
                                                       style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none; ">
                                            </td>
                                            <td><input
                                                       style=" display: block; height: 100%; width: 50%; box-sizing: border-box; margin: auto; display: none; ">
                                            </td>
                                            @if (isset($motivo) && $motivo == 'COMPRAS')
                                                <td>TOTAL:</td>
                                            @endif
                                            @if (isset($motivo) && $motivo == 'COMPRAS')
                                                <td>
                                                    @if (isset($motivo) && $motivo == 'COMPRAS')<input
                                                               name="inputTotalDetalle"
                                                               id="inputTotalDetalle"
                                                               style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto; font-weigth: bold;"
                                                               class="form-control"
                                                               @if (isset($documento)) value="{{ number_format($documento->getCostoTotalRestante(), 2) }}" @endif
                                                               disabled>@endif
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endisset
                    </div>
                </div>
                @if (isset($motivo) && ($motivo == 'DEVOLUCION' || $motivo == 'CTALLER'))
                    <div class="p-0 mt-3">
                        <div class="p-0 mt-3 mr-5">
                            <div class="row justify-content-end m-0">
                                <span class="font-weight-bold text-right"
                                      style="font-size: 17px; padding-top:1px">SUBTOTAL: </span> <span class="ml-3"
                                      id="simboloSubTotalDev"></span> <span id="SubTotalDev"
                                      style="width: 145px; text-align: right">0.00</span>
                            </div>
                            <div class="row justify-content-end m-0">
                                <span class="font-weight-bold text-right"
                                      style="font-size: 17px; padding-top:1px">IGV: </span> <span class="ml-3"
                                      id="simboloTotalIgvDev"></span> <span id="totalIgvDev"
                                      style="width: 145px; text-align: right">0.00</span>
                            </div>
                            <div class="row justify-content-end m-0">
                                <span class="font-weight-bold text-right"
                                      style="font-size: 17px; padding-top:1px">TOTAL: </span> <span class="ml-3"
                                      id="simboloTotalDev"></span> <span id="totalDev"
                                      style="width: 145px; text-align: right">0.00</span>
                            </div>
                        </div>
                    </div>
                @endif
                @if (isset($motivo))
                    @if (isset($documento))<input id="documentoRelacionado"
                               name="documentoRelacionado"
                               type="hidden"
                               value="{{ $numDocumento }}">@endif
                    <input id="motivoRelacionado"
                           name="motivoRelacionado"
                           type="hidden"
                           value="{{ $motivo }}">
                    <input id="rucProveedorSol"
                           name="rucProveedorSol"
                           type="hidden"
                           @if (isset($rucProveedor)) value="{{ $rucProveedor }}" @endif>
                    <div class="col-sm-12 p-0 mt-3">
                        <div class="row justify-content-end m-0">
                            <button id="btnGuardarHojaTrabajo"
                                    value="Submit"
                                    type="submit"
                                    form="formRegistrarSol"
                                    style=" margin-left:15px"
                                    class="btn btn-success">
                                @isset(request()->motivoSol)
                                    @switch(request()->motivoSol)
                                        @case('COMPRAS')
                                            GENERAR COMPRA
                                        @break
                                        @case('TALLER')
                                            GENERAR REINGRESO
                                        @break
                                        @case('DEVOLUCION')
                                            GENERAR DEVOLUCIÓN
                                        @break
                                        @case('CTALLER')
                                            GENERAR
                                        @break
                                        @default

                                    @endswitch
                                @endisset
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        @endisset


    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>


    </script>
@endsection