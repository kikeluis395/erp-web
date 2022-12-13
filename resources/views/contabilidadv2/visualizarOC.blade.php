@extends('contabilidadv2.layoutCont')
@section('titulo', 'Modulo de contabilidad - Validar OC')

@section('content')

    {{-- {{ dd($proveedor) }} --}}
    {{-- <ul>
   @foreach ($lineaCompra as $item)
   <li>{{ $item->id_orden_compra }}</li>
@endforeach
</ul> --}}



    <div id="containerMec" style="background: white;padding: 30px">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="ml-3 my-3 mb-0">Validar Orden de Compra</h3>
                <a href="{{ route('contabilidad.seguimientoOC') }}">
                    {!! Form::button('<i class="fas fa-arrow-left mr-2"></i>Regresar', ['class' => 'btn btn-success btn-sm', 'type' => 'button']) !!}
                </a>
            </div>


            <form method="get" id="form_estadoOC">
                {!! Form::token() !!}

                <div class="col-12">
                    <div class="card">
                        <div class="card-body row">

                            <div class="col-3">
                                {!! Html::decode(Form::label('empresa', 'Empresa', ['class' => 'font-weight-bold'])) !!}
                                {!! Form::text('empresa', $empresa->nombre_empresa, ['class' => 'form-control form-control-sm', 'id' => 'empresa', 'readonly']) !!}
                            </div>


                            <div class="col-3">
                                {!! Html::decode(Form::label('sucursal', 'Sucursal', ['class' => 'font-weight-bold'])) !!}
                                {!! Form::text('sucursal', $empresa->nombre_local, ['class' => 'form-control form-control-sm', 'id' => 'empresa', 'readonly']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('almacen', 'Almacen', ['class' => 'font-weight-bold'])) !!}
                                {!! Form::text('almacen', $almacen->valor1, ['class' => 'form-control form-control-sm', 'id' => 'almacen', 'readonly']) !!}
                            </div>


                            <div class="col-3">
                                {!! Html::decode(Form::label('documento', 'Documento', ['class' => 'font-weight-bold'])) !!} <div class="input-group mb-2 mr-sm-2">
                                    {!! Form::text('doc_oc', $ordenC->codigo_orden_compra, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                                    {!! Form::hidden('id_oc', $ordenC->id_orden_compra, ['id' => 'idOrdenCompra']) !!}
                                </div>
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('fecha', 'Fecha', ['class' => 'font-weight-bold'])) !!}
                                <div class="input-group">
                                    {!! Form::text('fec_emision', date('d-m-Y', strtotime($ordenC->fecha_registro)), ['class' => 'form-control form-control-sm', 'readonly']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('moneda', 'Moneda ', ['class' => 'font-weight-bold'])) !!}
                                {!! Form::text('moneda', $ordenC->tipo_moneda, ['class' => 'form-control form-control-sm', 'id' => 'tipo_moneda', 'readonly']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('estado', 'Estado', ['class' => 'font-weight-bold'])) !!}
                                {!! Form::text('estado', $estado->valor1, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('usuario', 'Usuario Responsable', ['class' => 'font-weight-bold'])) !!}
                                {!! Form::text('usu_responsable', $usuario->username, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                            </div>


                            <div class="col-3">
                                {!! Html::decode(Form::label('motivo', 'Motivo', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('motivo', $motivo->valor1, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                            </div>



                            <div class="col-6">
                                {!! Html::decode(Form::label('detalle', 'Detalle Motivo', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('detalle_motivo', $ordenC->detalle_motivo, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                            </div>


                            <div class="col-3">
                                {!! Html::decode(Form::label('condicion', 'Condición de Pago', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('condicion_pago', $condicionPago->pago, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('proveedor', 'Proveedor', ['class' => 'font-weight-bold mt-1'])) !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text p-0 px-2">RUC</div>
                                    </div>
                                    {!! Form::text('proveedor', $proveedor->num_doc, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('contacto', 'Contacto', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('contacto', $proveedor->contacto, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provN_contacto']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('telefono', 'Teléfono', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('telefono', $proveedor->telf_contacto, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provT_contacto']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('email', 'Email', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('email', $proveedor->email_contacto, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provE_contacto']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('direccion', $proveedor->direccion, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provD_contacto']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('departamento', 'Departamento', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('departamento', $proveedor->departamento, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provDp_contacto']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('provincia', $proveedor->provincia, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provP_contacto']) !!}
                            </div>

                            <div class="col-3">
                                {!! Html::decode(Form::label('distrito', 'Distrito', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::text('distrito', $proveedor->distrito, ['class' => 'form-control form-control-sm', 'readonly', 'id' => 'provDd_contacto']) !!}
                            </div>

                            <div class="col-6">
                                {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold mt-1'])) !!}
                                {!! Form::textarea('observaciones', $ordenC->observaciones, ['class' => 'form-control form-control-sm', 'rows' => '2', 'style' => 'resize:none', 'readonly']) !!}
                            </div>

                            <div class="col-6">
                                <form id="formActualizarOC" method="POST" action="{{ route('contabilidad.updateOC') }}">
                                    <div class="row">

                                
                                        <div class="col-6">
                                            {!! Html::decode(Form::label('factura', 'Factura', ['class' => 'font-weight-bold mt-1'])) !!}
                                            {!! Form::text('factura', $ordenC->factura_proveedor, ['class' => 'form-control form-control-sm', 'id' => 'provDd_factura']) !!}
                                        </div>
                                        <div class="col-3">
                                            <br>
                                            <button id="btnGuardarIngresoRegular" value="Submit" type="submit"
                                                formaction="{{ route('contabilidad.updateOC') }}"
                                                style=" margin-left:15px" class="btn btn-success">
                                                Actualizar
                                            </button>
                                        </div>

                                        <div class="col-3">
                                            <br>
                                            @if ($estadoN->valor1 == 'APROBADO')
                                                <div class="col-12 d-flex justify-content-end align-items-end">
                                                    <a class="btn btn-secondary" type="button"
                                                        href="{{ route('hojaOrdenCompra', ['id_orden_compra' => $ordenC->id_orden_compra]) }}">Imprimir
                                                        OC</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </form>
                            </div>






                        </div>
                    </div>
                </div>


                <div class="col-12 mt-3">
                    <div class="table-responsive tableFixHead">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row col-12 justify-content-between">
                                    <div>
                                        <h2>Detalle de la Orden de Compra</h2>
                                    </div>

                                </div>
                            </div>


                            @if (strpos($almacen_repuestos->valor1, 'VEHICULO'))
                                {{-- **************** TABLA PARA ALMACENES DE VEHICULOS NUEVOS ********** --}}
                                <div class="table-cont-single">
                                    <table id="tablaDetalleOCVN" class="table text-center table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%">#</th>
                                                <th scope="col" style="width: 15%">MODELO COMERCIAL</th>
                                                <th scope="col" style="width: 10%">VIN</th>
                                                <th scope="col" style="width: 5%">NUM. MOTOR</th>
                                                <th scope="col" style="width: 5%">AÑO</th>
                                                <th scope="col" style="width: 10%">COLOR</th>
                                                <th scope="col" style="width: 10%">COSTO UNITARIO</th>
                                                <th scope="col" style="width: 10%">DESCUENTO UNITARIO</th>
                                                <th scope="col" style="width: 10%">SUB TOTAL</th>
                                                <th scope="col" style="width: 10%">IGV</th>
                                                <th scope="col" style="width: 10%">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lineaOCompra as $loc)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><input type="text" class="form-control form-control-sm" readonly
                                                            value="{{ $loc->modelo }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm" readonly
                                                            value="{{ $loc->vin }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm" readonly
                                                            value="{{ $loc->numero_motor }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm" readonly
                                                            value="{{ $loc->anio }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm" readonly
                                                            value="{{ $loc->color }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm" readonly
                                                            value="{{ $loc->precio }}"></td>
                                                    <td><input type="text"
                                                            class="form-control form-control-sm desUnitario_VN" readonly
                                                            value="{{ $loc->descuento }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm subTotal_VN"
                                                            readonly value="{{ $loc->sub_total }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm " readonly
                                                            value="{{ $loc->impuesto }}"></td>
                                                    <td><input type="text" class="form-control form-control-sm " readonly
                                                            value="{{ $loc->total }}"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row" id="footer_totales">
                                    <div class="col-12">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-2">
                                                {!! Html::decode(Form::label('valor_venta', 'Valor Venta', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda ">S/.</span>
                                                    </div>
                                                    {!! Form::text('valor_venta', null, ['class' => 'form-control form-control-sm', 'id' => 'valor_ventaVN', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('descuento', 'Descuento', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('descuento_final', null, ['class' => 'form-control form-control-sm', 'id' => 'descuento_finalVN', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('subtotal_final', 'SubTotal', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('subtotal_final', null, ['class' => 'form-control form-control-sm', 'id' => 'subtotal_finalVN', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('impuesto_total', 'Impuesto', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('impuesto_total', null, ['class' => 'form-control form-control-sm', 'id' => 'impuesto_totalVN', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('total_final', 'Total', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append ">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('total_final', null, ['class' => 'form-control form-control-sm', 'id' => 'total_finalVN', 'readonly']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @else
                                {{-- **************** TABLA PARA ALMACENES, MENOS VEHICULOS NUEVOS ********** --}}
                                <div class="table-cont-single">
                                    <table id="tablaDetalleOCT" class="table text-center table-striped table-sm ">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">#</th>
                                                <th scope="col" style="width: 10%;">CODIGO</th>
                                                <th scope="col" style="width: 20%;">DESCRIPCION</th>
                                                <th scope="col" style="width: 5%;">STOCK ACTUAL</th>
                                                <th scope="col" style="width: 5%;">CANTIDAD</th>
                                                <th scope="col" style="width: 10%;">COSTO UNITARIO</th>
                                                <th scope="col" style="width: 10%;">DESCUENTO UNITARIO</th>
                                                <th scope="col" style="width: 10%;">SUB TOTAL</th>
                                                <th scope="col" style="width: 10%;">IMPUESTO</th>
                                                <th scope="col" style="width: 10%;">TOTAL</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lineaOCompra as $loc)
                                                <tr>

                                                    @if ($loc->codigo_repuesto != null)
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->codigo_repuesto }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->nom_repuesto }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="0000"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->cantidad }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->precio }}"></td>
                                                        <td><input type="text"
                                                                class="form-control form-control-sm descuento" readonly
                                                                value="{{ $loc->descuento }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm subtotal"
                                                                readonly value="{{ $loc->sub_total }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm impuesto"
                                                                readonly value="{{ $loc->impuesto }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm total"
                                                                readonly value="{{ $loc->total }}"></td>
                                                    @else
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->codigo }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->nom_producto }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="0000"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->cantidad }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm" readonly
                                                                value="{{ $loc->precio }}"></td>
                                                        <td><input type="text"
                                                                class="form-control form-control-sm descuento" readonly
                                                                value="{{ $loc->descuento }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm subtotal"
                                                                readonly value="{{ $loc->sub_total }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm impuesto"
                                                                readonly value="{{ $loc->impuesto }}"></td>
                                                        <td><input type="text" class="form-control form-control-sm total"
                                                                readonly value="{{ $loc->total }}"></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row" id="footer_totales">
                                    <div class="col-12">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-2">
                                                {!! Html::decode(Form::label('valor_venta', 'Valor Venta', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('valor_venta', null, ['class' => 'form-control form-control-sm', 'id' => 'valor_venta', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('descuento', 'Descuento', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('descuento_final', null, ['class' => 'form-control form-control-sm', 'id' => 'descuento_final', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('subtotal_final', 'SubTotal', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('subtotal_final', null, ['class' => 'form-control form-control-sm', 'id' => 'subtotal_final', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('impuesto_total', 'Impuesto', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('impuesto_total', null, ['class' => 'form-control form-control-sm', 'id' => 'impuesto_total', 'readonly']) !!}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                {!! Html::decode(Form::label('total_final', 'Total', ['class' => 'font-weight-bold'])) !!}
                                                <div class="input-group">
                                                    <div class="input-group-append ">
                                                        <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                                    </div>
                                                    {!! Form::text('total_final', null, ['class' => 'form-control form-control-sm', 'id' => 'total_final', 'readonly']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @endif


                        </div>
                    </div>
                </div>

                
                <div class="col-12 text-center mt-3">
                    @if ($estadoN->valor1 == 'APROBADO')
                        {!! Form::button('<i class="fas fa-times mr-2"></i>ANULAR', ['class' => 'btn btn-danger mr-1', 'type' => 'button', 'name' => 'button', 'id' => 'anularOC']) !!}
                    @else
                        {!! Form::button('<i class="fas fa-check mr-2"></i>APROBAR', ['class' => 'btn btn-success mr-1', 'type' => 'button', 'name' => 'button', 'id' => 'aprobarOC']) !!}

                        {!! Form::button('<i class="fas fa-times mr-2"></i>RECHAZAR', ['class' => 'btn btn-danger mr-1', 'type' => 'button', 'name' => 'button', 'id' => 'rechazarOC']) !!}
                    @endif
                </div>
            </form>





        </div>


    </div>


@endsection


@section('extra-scripts')

    <script src="{{ asset('scripts/script_validarOC.js') }}"></script>
@endsection
