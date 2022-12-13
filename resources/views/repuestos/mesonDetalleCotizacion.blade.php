@extends('repuestos.repuestosCanvas')
@section('titulo', 'Meson - Crear Cotización')


@section('pretable-content')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css" />
    <div style="background: white;padding: 10px">
        <div class="row justify-content-between col-12 mt-2 mt-sm-0">
            <h2 class="ml-3 mt-3 mb-4">Cotización de repuestos N° {{ $cotizacion->id_cotizacion_meson }}</h2>
            @if (session('errorReabrir'))
                <div class="alert alert-danger"
                     role="alert">
                    {{ session('errorReabrir') }}
                </div>
            @endif
            @if (session('successReabrir'))
                <div class="alert alert-success"
                     role="alert">
                    {{ session('successReabrir') }}
                </div>
            @endif
            <div class="justify-content-end">
                <a href="{{ route('meson.index') }}"><button type="button"
                            class="btn btn-info mt-4">Regresar</button></a>
            </div>
        </div>

        @include('modals.personalInfoUser')

        <form id="FormMesonCotizacion"
              class="my-3"
              method="POST"
              action="{{ route('meson.store') }}"
              autocomplete="off">
            @csrf
            <input type="hidden"
                   name="action"
                   value="edit" />
            <input type="hidden"
                   name="idCotizacionMeson"
                   value="{{ $cotizacion->id_cotizacion_meson }}">
            <div class="row">
                @php
                    $estado_linea = '';
                    if (count($repuestosCotizacion) > 0) {
                        $estado_linea = $repuestosCotizacion[0]->getDisponibilidadRepuestoText();
                    }
                @endphp
                @foreach ($repuestosCotizacion as $lineaRepuesto)
                @endforeach
                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="nroDocIn"
                           class="col-form-label col-12 col-sm-6">{{ config('app.rotulo_documento') }}:</label>
                    @if ($estado_linea == 'ENTREGADO')
                        <input id="nroDocIn"
                               name="nroDoc"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de documento"
                               value="{{ $cotizacion->getNumDoc() }}"
                               readonly>
                    @elseif($estado_meson=='LIQUIDADO - RP' || $estado_meson=='LIQUIDADO')
                        <input id="nroDocIn"
                               name="nroDoc"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de documento"
                               value="{{ $cotizacion->getNumDoc() }}"
                               readonly>
                    @else
                        <input id="nroDocIn"
                               name="nroDoc"
                               type="text"
                               class="form-control col-12 col-sm-6"
                               placeholder="Número de documento"
                               value="{{ $cotizacion->getNumDoc() }}"
                               required>
                    @endif
                </div>

                <input id="modal_tipo_doc"
                       type="hidden"
                       name="modal_tipo_doc"
                       value="{{ $cliente->tipo_doc }}">
                <input id="modal_cliente"
                       type="hidden"
                       name="modal_cliente"
                       value="{{ $cliente->getNombreCompleto() }}">
                <input id="modal_nombres"
                       type="hidden"
                       name="modal_nombres"
                       value="{{ $cliente->nombres }}">
                <input id="modal_apellido_pat"
                       type="hidden"
                       name="modal_apellido_pat"
                       value="{{ $cliente->apellido_pat }}">
                <input id="modal_apellido_mat"
                       type="hidden"
                       name="modal_apellido_mat"
                       value="{{ $cliente->apellido_mat }}">

                {{-- <div class="form-group row ml-1 col-6 col-xl-3">
        <label for="nombreClienteIn" class="col-form-label col-12 col-sm-6">Cliente:</label> --}}
                {{-- @if ($lineaRepuesto->getDisponibilidadRepuestoText() == 'ENTREGADO')
			<input id="nombreClienteIn" type="text" class="form-control col-12 col-sm-6" placeholder="Nombre del cliente" value="{{$cotizacion->getNombreCliente()}}" name="nombreCliente" readonly>
		@elseif($estado_meson=='LIQUIDADO - RP' || $estado_meson=='LIQUIDADO')
		    <input id="nombreClienteIn" type="text" class="form-control col-12 col-sm-6" placeholder="Nombre del cliente" value="{{$cotizacion->getNombreCliente()}}" name="nombreCliente" readonly>
		@else
		    <input id="nombreClienteIn" type="text" class="form-control col-12 col-sm-6" placeholder="Nombre del cliente" value="{{$cotizacion->getNombreCliente()}}" name="nombreCliente">
        @endif --}}
                {{-- <input id="nombreClienteIn" type="text" class="form-control col-12 col-sm-6" placeholder="Nombre del cliente" name="nombreCliente" disabled> --}}
                {{-- </div> --}}

                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="nombreClienteIn"
                           class="col-form-label col-12 col-sm-4">Cliente:</label>
                    <div class="input-group col-12 col-sm-8 px-0">
                        <input id="nombreClienteIn"
                               type="text"
                               class="form-control "
                               placeholder="Nombre del cliente"
                               name="nombreCliente"
                               disabled
                               value="{{ $cotizacion->getNombreCliente() }}">
                        <div class="input-group-append datos_saved_user"
                             id="edit_client_button">
                            <button class="btn btn-outline-secondary"
                                    id="datosNUser"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#datosNuevoCliente"
                                    data-backdrop="static"><i class="fa fa-edit"></i></button>
                        </div>
                    </div>
                </div>


                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="telefonoIn"
                           class="col-form-label col-12 col-sm-6">Teléfono:</label>
                    <input id="telefonoIn"
                           type="text"
                           class="form-control col-12 col-sm-6"
                           placeholder="Teléfono del cliente"
                           value="{{ $cotizacion->getTelefonoCliente() }}"
                           name="telefono">
                </div>

                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="correoIn"
                           class="col-form-label col-12 col-sm-6">Correo:</label>
                    <input id="correoIn"
                           type="text"
                           class="form-control col-12 col-sm-6"
                           placeholder="Correo del cliente"
                           value="{{ $cotizacion->getCorreoCliente() }}"
                           name="correo">
                </div>


                <div class="form-group row ml-1 col-6 col-xl-3">
                    <label for="direccionIn"
                           class="col-form-label col-12 col-sm-6">Dirección:</label>
                    <input id="direccionIn"
                           type="text"
                           class="form-control col-12 col-sm-6"
                           placeholder="Dirección del cliente"
                           name="direccion"
                           value="{{ $cotizacion->direccion_contacto }}"
                           required>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="departamentoIn"
                           class="col-form-label col-6">Departamento: </label>
                    <select name="departamento"
                            id="departamentoIn"
                            class="form-control col-6"
                            data-validation="required"
                            data-validation-depends-on="distrito"
                            data-validation-error-msg=" "
                            required>
                        <option value=""></option>
                        @foreach ($listaDepartamentos as $departamento)
                            <option value="{{ $departamento->codigo_departamento }}"
                                    @if (substr($cotizacion->cod_ubigeo, 0, 2) == $departamento->codigo_departamento) selected @endif>{{ $departamento->departamento }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="provinciaIn"
                           class="col-form-label col-6">Provincia: </label>
                    <select name="provincia"
                            id="provinciaIn"
                            class="form-control col-6"
                            data-validation="required"
                            data-validation-depends-on="departamento"
                            data-validation-error-msg=" "
                            required>
                        <option value=""></option>
                        @foreach ($listaProvincias as $provincia)
                            <option value="{{ $provincia->codigo_provincia }}"
                                    @if (substr($cotizacion->cod_ubigeo, 2, 2) == $provincia->codigo_provincia) selected @endif>{{ $provincia->provincia }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="distritoIn"
                           class="col-form-label col-6">Distrito: </label>
                    <select name="distrito"
                            id="distritoIn"
                            class="form-control col-6"
                            data-validation="required"
                            data-validation-depends-on="provincia"
                            data-validation-error-msg=" "
                            required>
                        <option value=""></option>
                        @foreach ($listaDistritos as $distrito)
                            <option value="{{ $distrito->codigo_distrito }}"
                                    @if (substr($cotizacion->cod_ubigeo, 4, 2) == $distrito->codigo_distrito) selected @endif>{{ $distrito->distrito }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="col-form-label col-6">Fecha de Creación: </label>
                    <label class="col-form-label col-6">{{ $cotizacion->fecha_registro->format('d/m/Y H:i') }}</label>
                </div>
                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="col-form-label col-6">Asesor de Repuesto: </label>
                    <label
                           class="col-form-label col-6">{{ $cotizacion->usuarioRegistro->empleado->nombreCompleto() }}</label>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="modeloTecnicoIn"
                           class="col-form-label col-6">Modelo técnico: </label>
                    <select name="modeloTecnico"
                            id="modeloTecnicoIn"
                            class="form-control col-6">
                        <option value=""></option>
                        @foreach ($listaModelosTecnicos as $modeloTecnico)
                            <option value="{{ $modeloTecnico->id_modelo_tecnico }}"
                                    @if ($cotizacion->id_modelo_tecnico == $modeloTecnico->id_modelo_tecnico) selected @endif>{{ $modeloTecnico->nombre_modelo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label for="monedaIn"
                           class="col-form-label col-6">Moneda: </label>
                    <select name="moneda"
                            id="monedaIn"
                            class="form-control col-6">
                        <option value="SOLES"
                                @if ($cotizacion->moneda == 'SOLES') selected @endif>SOLES</option>
                        <option value="DOLARES"
                                @if ($cotizacion->moneda == 'DOLARES') selected @endif>DÓLARES</option>
                    </select>
                </div>

                <div class="form-group row ml-1 col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="col-form-label col-6">Tipo de cambio: </label>
                    <label class="col-form-label col-6">S/ {{ $cotizacion->tipo_cambio }}</label>
                </div>

                <div class="row justify-content-between col-12">
                    <div class="form-group form-inline col-6 form-group-align-top">
                        <label for="observacionesIn">Observaciones:</label>
                        @if ($estado_linea == 'ENTREGADO')
                            <textarea name="observaciones"
                                      type="text"
                                      class="form-control col-10 ml-3"
                                      id="observacionesIn"
                                      placeholder="Ingrese sus observaciones"
                                      maxlength="255"
                                      rows="3"
                                      form="FormMesonCotizacion"
                                      autocomplete="off"
                                      readonly>{{ $cotizacion->observaciones }}</textarea>
                        @elseif($estado_meson=='LIQUIDADO - RP' || $estado_meson=='LIQUIDADO')
                            <textarea name="observaciones"
                                      type="text"
                                      class="form-control col-10 ml-3"
                                      id="observacionesIn"
                                      placeholder="Ingrese sus observaciones"
                                      maxlength="255"
                                      rows="3"
                                      form="FormMesonCotizacion"
                                      autocomplete="off"
                                      readonly>{{ $cotizacion->observaciones }}</textarea>
                        @else
                            <textarea name="observaciones"
                                      type="text"
                                      class="form-control col-10 ml-3"
                                      id="observacionesIn"
                                      placeholder="Ingrese sus observaciones"
                                      maxlength="255"
                                      rows="3"
                                      form="FormMesonCotizacion"
                                      autocomplete="off">{{ $cotizacion->observaciones }}</textarea>
                        @endif
                    </div>
                    <div class="">
                        <div class="row justify-content-end mr-1 align-items-end">
                            @if (!$cotizacion->esVendido())
                                @if ($cotizacion->getDiscountRequestStatus() != 'SOLICITUD DE DESCUENTO EN PROCESO')
                                    <button type="button"
                                            class="btn btn-success btn-tabla"
                                            data-toggle="modal"
                                            data-target="#modalSolicitarDescuento"
                                            data-backdrop="static"
                                            style="margin-left:15px">
                                        Solicitar descuento
                                    </button>
                                @else
                                    <button id="btnRequestDicountDisable"
                                            onClick="showAlert()"
                                            type="button"
                                            class="btn btn-success"
                                            style="margin-left:15px">Solicitar descuento</button>
                                @endIf
                                <div class="btn-group"
                                     role="group">
                                    <button id="btnGroupDrop1"
                                            type="button"
                                            class="btn btn-warning dropdown-toggle ml-2"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        Imprimir Cotización
                                    </button>
                                    <div class="dropdown-menu"
                                         aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item"
                                           href="{{ route('meson.imprimirCotizacion', ['idCotizacionMeson' => $cotizacion->id_cotizacion_meson, 'dispcode' => 'true']) }}">Con
                                            Código</a>
                                        <a class="dropdown-item"
                                           href="{{ route('meson.imprimirCotizacion', ['idCotizacionMeson' => $cotizacion->id_cotizacion_meson, 'dispcode' => 'false']) }}">Sin
                                            Código</a>
                                    </div>
                                </div>
                            @else
                                <a
                                   href="{{ route('meson.imprimirNotaVenta', ['idCotizacionMeson' => $cotizacion->id_cotizacion_meson]) }}"><button
                                            type="button"
                                            class="btn btn-warning"
                                            style="margin-left:20px">Imprimir Nota de Venta</button></a>
                            @endif
                            @if (isset($listaEliminados) && $listaEliminados)
                                @include('modals.trackingEliminados')
                            @endif
                        </div>
                    </div>
                </div>
                @if ($cotizacion->isVisibleMessageDiscountRequest() != null || $cotizacion->getDiscountRequestStatus() == 'SOLICITUD DE DESCUENTO EN PROCESO')
                    <div class="col-12 text-center">
                        @if ($cotizacion->getDiscountRequestStatus() != null)

                            <div class="{{ $cotizacion->getColorAlertDiscountRequestStatus() }}"
                                 role="alert">
                                {{ $cotizacion->getDiscountRequestStatus() }}
                            </div>
                        @endIf

                @endIf


            </div>
        </form>
    </div>

@endsection


@section('table-content')
    <div class=""
         style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
        @if (session('errorCantidad'))
            <div class="alert alert-danger"
                 role="alert">
                {{ session('errorCantidad') }}
            </div>
        @endif
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 justify-content-between">
                        <div>
                            <h2>Repuestos cotizados</h2>
                        </div>
                        <div>
                            @if (!$cotizacion->esVendido())
                                <button id="btnAgregarRepuestoMeson"
                                        type="button"
                                        style="margin-left:15px"
                                        class="btn btn-warning">+</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="table-cont-single">
                    <table id="tableRepuestosMeson"
                           class="table text-center table-striped table-sm"
                           @if ($cotizacion->esVendido()) tipo="vendido" @endif>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">CÓDIGO</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">DÍAS S/ MOV. </th>
                                <th scope="col">UBICACIÓN</th>
                                <th scope="col">CANT.</th>
                                <th scope="col">MAYOREO</td>
                                <th scope="col">DISPONIBILIDAD</th>

                                <th scope="col">¿ES IMPORTACIÓN?</th>
                                @if ($cotizacion->esVendido() && false)
                                    <th scope="col">F. PEDIDO</th>
                                    <th scope="col">F. PROMESA</th>
                                @endif
                                <th scope="col">P. UNIT.</th>
                                <th scope="col">P. TOTAL</th>
                                <th scope="col"
                                    style="width:120px">DSCTO. MARCA</th>
                                <th scope="col">DSCTO. DEALER</th>
                                <th scope="col">DESCUENTO</th>
                                <th scope="col">MARGEN</th>
                                <th scope="col">P. FINAL</th>
                                @if ($cotizacion->esVendido())
                                    <th scope="col">RESERVAR</th>
                                @endif
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden"
                                   id="tipoDeCambioMeson"
                                   value="{{ $cotizacion->getTipoCambio() }}">
                            @foreach ($repuestosCotizacion as $lineaRepuesto)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $lineaRepuesto->getCodigoRepuesto() }}</td>
                                    <td>{{ $lineaRepuesto->getDescripcionRepuesto() }}</td>
                                    <td>{{ $lineaRepuesto->daysWithoutMovement() }}</td>
                                    <td>{{ $lineaRepuesto->getUbicacionRepuesto() }} </td>
                                    {{-- <td>
                <select class="form-control" readonly>
                  <option value="{{$lineaRepuesto->getItemTransaccion()->id_unidad_grupo}}">{{$lineaRepuesto->getItemTransaccion()->getNombreUnidadGrupo()}}</option>
                </select>
              </td> --}}
                                    <td>{{ $lineaRepuesto->getCantidadGrupo() }}</td>
                                    <td>
                                        @if (!$cotizacion->esVendido())
                                            @if ($lineaRepuesto->repuesto->aplica_mayoreo)
                                                <input type="hidden"
                                                       name="incluyeMayoreo-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       value="0"
                                                       form="FormMesonCotizacion"> <input
                                                       id="incluyeMayoreo-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       name="incluyeMayoreo-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       type="checkbox"
                                                       class="form-control"
                                                       form="FormMesonCotizacion"
                                                       style="width:100px"
                                                       @if ($lineaRepuesto->es_mayoreo == 1) checked @endif>
                                            @else -
                                            @endif
                                        @else
                                            @if ($lineaRepuesto->es_mayoreo) Si @else No @endif
                                        @endif
                                    </td>
                                    <td>{{ $lineaRepuesto->getDisponibilidadRepuestoText() }}</td>

                                    <td>
                                        @if ($lineaRepuesto->es_atendido != 1 && !$lineaRepuesto->hayStock())
                                            <input type="hidden"
                                                   name="importado-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                   value="0"
                                                   form="FormMesonCotizacion"> <input
                                                   id="importado-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                   name="importado-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                   type="checkbox"
                                                   class="form-control"
                                                   form="FormMesonCotizacion"
                                                   style="width:100px"
                                                   @if ($lineaRepuesto->es_importado == 1) checked @endif>
                                        @else -
                                        @endif
                                    </td>
                                    @if ($cotizacion->esVendido() && false)
                                        <td>
                                            @if ($lineaRepuesto->es_atendido === 0 && $lineaRepuesto->fecha_pedido === null)
                                                <input name="fechaPedido-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       autocomplete="off"
                                                       class="datepicker form-control"
                                                       min-date="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"
                                                       placeholder="dd/mm/aaaa"
                                                       data-validation="date"
                                                       data-validation-length="10"
                                                       data-validation-format="dd/mm/yyyy"
                                                   form="FormMesonCotizacion" /> @else
                                                {{ $lineaRepuesto->getFechaPedidoFormat() }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($lineaRepuesto->es_atendido === 0) <input
                                                       name="fechaPromesa-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       autocomplete="off"
                                                       class="datepicker form-control"
                                                       min-date="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"
                                                       placeholder="dd/mm/aaaa"
                                                       data-validation="date"
                                                       data-validation-length="10"
                                                       data-validation-format="dd/mm/yyyy"
                                                       value="{{ $lineaRepuesto->getFechaPromesaFormat() }}"
                                                       form="FormMesonCotizacion" /> @endif
                                        </td>
                                    @endif
                                    <td>{{ App\Helper\Helper::obtenerUnidadMonedaCambiar($cotizacion->getMoneda()) }}
                                        {{ number_format($lineaRepuesto->getMontoUnitarioGrupo($lineaRepuesto->getFechaRegistroCarbon(), true), 2) }}
                                    </td>
                                    <td><span
                                              id="simboloPTotal-{{ $loop->iteration }}">{{ App\Helper\Helper::obtenerUnidadMonedaCambiar($cotizacion->getMoneda()) }}</span>
                                        <span
                                              id="pTotalLinea-{{ $loop->iteration }}">{{ number_format($lineaRepuesto->getMontoTotal($lineaRepuesto->getFechaRegistroCarbon(), true), 2) }}</span>
                                    </td>

                                    <td style="width: 90px!important;">
                                        <span id="descLineaMarca-{{ $loop->iteration }}">
                                            {{ $lineaRepuesto->descuento_marca ?? 0 }} %
                                        </span>

                                    </td>

                                    <td style="width: 70px">
                                        {{ $lineaRepuesto->descuento_unitario ?? 0 }} %
                                    </td>


                                    <td><span
                                              id="simboloDescLinea-{{ $loop->iteration }}">{{ App\Helper\Helper::obtenerUnidadMonedaCambiar($cotizacion->getMoneda()) }}</span>
                                        <span id="descLinea-{{ $loop->iteration }}">
                                            {{ number_format($lineaRepuesto->getApplicableDiscount() * $lineaRepuesto->getCantidadGrupo(), 2) }}</span>
                                    </td>
                                    <td>{{ $lineaRepuesto->unitPercentageMarginGainDealer() }}%</td>
                                    <td><span
                                              id="simboloTotalLinea-{{ $loop->iteration }}">{{ App\Helper\Helper::obtenerUnidadMonedaCambiar($cotizacion->getMoneda()) }}</span>
                                        <span
                                              id="totalLinea-{{ $loop->iteration }}">{{ number_format($lineaRepuesto->getTotalWithDiscount(), 2) }}</span>
                                    </td>
                                    @if ($cotizacion->esVendido())
                                        <td>
                                            @if ($lineaRepuesto->hayStock() && !$lineaRepuesto->es_atendido)
                                                <input id="entregado-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       name="entregado-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                       type="checkbox"
                                                       class="form-control"
                                                       form="FormMesonCotizacion"
                                                       style="width:100px">
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        @if (!$lineaRepuesto->es_atendido)
                                            <form action="{{ route('meson.eliminarRepuesto') }}"
                                                  method="POST"> @csrf <button
                                                        id="btnEliminarLineaRepuesto-{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                        type="submit"
                                                        name="idLinea"
                                                        value="{{ $lineaRepuesto->id_linea_cotizacion_meson }}"
                                                        class="btn btn-warning"><i
                                                       class="fas fa-trash icono-btn-tabla"></i></button></form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="p-0 mt-3">
            <div class="p-0 mt-3 mr-5">
                <div class="row justify-content-end m-0">
                    <span class="font-weight-bold text-right"
                          style="font-size: 17px; padding-top:1px">PRECIO TOTAL: </span> <span class="ml-3"
                          id="simboloPTotalCot"></span> <span id="PTotalCot2"
                          style="width: 145px; text-align: right">{{ $valorSinDescuento }}</span>
                </div>
                <div class="row justify-content-end m-0">
                    <span class="font-weight-bold text-right"
                          style="font-size: 17px; padding-top:1px">DSCTO MARCA: </span> <span class="ml-3"
                          id="simboloTotalDescCot"></span> <span id="totalDescCotMarca"
                          style="width: 145px; text-align: right"
                          value="{{ $totalDiscountBrand }}">{{ $totalDiscountBrand }}</span>
                </div>
                <div class="row justify-content-end m-0">
                    <span class="font-weight-bold text-right"
                          style="font-size: 17px; padding-top:1px">DSCTO DEALER: </span> <span class="ml-3"
                          id="simboloTotalCot"></span> <span id="totalDescCotDealer"
                          style="width: 145px; text-align: right">{{ abs($totaldiscountUnit) }}</span>
                </div>
                @if (false)
                    <div class="row justify-content-end m-0">
                        <span class="font-weight-bold text-right"
                              style="font-size: 17px; padding-top:1px">MARGEN DEALER: </span> <span class="ml-3"
                              id="simboloPTotalCot"></span> <span
                              style="width: 145px; text-align: right">{{ round(($cotizacion->getMarginTotalDealer() / $cotizacion->getValorCotizacionWithBrandDiscount()) * 100, 2) }}%</span>
                    </div>
                @endIf
                <div class="row justify-content-end m-0">
                    <span class="font-weight-bold text-right"
                          style="font-size: 17px; padding-top:1px">PRECIO FINAL: </span> <span class="ml-3"
                          id="simboloTotal"></span> <span id="totalCot2"
                          style="width: 145px; text-align: right">{{ $totalCotizacion }}</span>
                </div>
            </div>
        </div>

        <div class="p-0 mt-3">
            <div class="col-xl-12 p-0 mt-3">
                <div class="row justify-content-between m-0">

                    @if ($estado_linea == 'ENTREGADO')
                        <div style="display: none"><button id="btnGuardarCotizacionMeson"
                                    value="Submit"
                                    type="submit"
                                    form="FormMesonCotizacion"
                                    style="margin-left:15px"
                                    class="btn btn-warning"
                                    disabled>Guardar</button></div>
                    @else
                        <div><button id="btnGuardarCotizacionMeson"
                                    value="Submit"
                                    type="submit"
                                    form="FormMesonCotizacion"
                                    style="margin-left:15px"
                                    class="btn btn-warning">Guardar</button></div>
                    @endif

                    @if (isset($mostrarBoton) && $mostrarBoton)
                        <div><button type="button"
                                    class="btn btn-danger"
                                    style="margin-left:15px"
                                    data-toggle="modal"
                                    data-target="#reabrirCotizacionModal"
                                    data-backdrop="static">Reabrir Cotizacion</button></div>
                    @endif
                    @if (!$cotizacion->esVendido())
                        <div><button type="button"
                                    class="btn btn-danger"
                                    style="margin-left:15px"
                                    data-toggle="modal"
                                    data-target="#cerrarCotizacionModal"
                                    data-backdrop="static">Cerrar Cotizacion</button></div>
                        <div><button type="button"
                                    style="margin-left:15px"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#venderCotizacionModal"
                                    data-backdrop="static">Vender Cotizacion</button></div>
                    @endif
                </div>
            </div>
        </div>
        @if (session('firstTime'))
            <input style="display:none;"
                   name="responseFirstTime"
                   id="responseFirstTime"
                   value={{ session('firstTime') }}>
        @endif
        @if (session('secondTime'))
            <input style="display:none;"
                   name="responseSecondTime"
                   id="responseSecondTime"
                   value={{ session('secondTime') }}>
        @endif

    </div>
    @include('modals.cerrarCotizacionMeson', ['idCotizacion' => $cotizacion->id_cotizacion_meson])
    @include('modals.reabrirCotizacionMeson', ['idCotizacion' => $cotizacion->id_cotizacion_meson])
    @include('modals.venderCotizacionMeson', ['idCotizacion' => $cotizacion->id_cotizacion_meson])
    @include('modals.solicitarDescuentoMeson', ['idCotizacion' => $cotizacion->id_cotizacion_meson])

@endsection

@section('extra-scripts')
    @parent
    <script src="{{ asset('js/meson.js?v=' . time()) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
    <script>
        function showAlert() {

            return Swal.fire(
                '',
                `EXISTE UNA SOLICITUD EN PROCESO. SOLICITAR APROBACIÓN O RECHAZO PARA GENERAR UNA NUEVA SOLICITUD`,
                'error'
            )
        }
        $(document).ready(function() {
            // alert($('#cant_items').val())
            if ($('#cant_items').val() < 1 && $('#id_recepcion_ot').val() != 0) {
                $('#cerrarOTModal').modal('toggle')
            }
            if ($('#cant_items').val() < 1 && $('#id_cotizacion').val() != 0) {
                $('#cerrarCotizacionModal').modal('toggle')
            }
            var session = $('#responseFirstTime').val();
            if (session != null) {
                return Swal.fire(
                    '',
                    session,
                    'success'
                )

            }
        });
    </script>


@endsection
