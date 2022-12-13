@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Editar OC')

@section('content')

{{-- {{ dd($almacen_repuestos->valor1) }} --}}



<div id="containerMec" class="container-fluid px-4 pt-2 pb-4" style="background: white;">
   <div class="row">
      <div class="col-12 mt-2 d-flex justify-content-between align-items-center">
         <h2 class="mt-3 mb-4">Actualizar Orden de Compra</h2>
         <a href="{{ route('contabilidad.seguimientoOC') }}">
            {!! Form::button('<i class="fas fa-arrow-left mr-2"></i>Regresar', ['class'=>'btn btn-success btn-sm', 'type' => 'button']) !!}
         </a>
      </div>

      <form id="form_actualizaroc" method="post">
         @csrf

         <div class="col-12">
            <div class="card">
               <div class="card-body row mx-0">

                  <div class="col-3">
                     {!! Html::decode(Form::label('empresa', 'Empresa', ['class' => 'font-weight-bold'])) !!}
                     {!! Form::select('empresa', ['' => 'SELECCIONAR'] + $empresa, isset($ordenC) ? $ordenC->id_local_empresa : '', ['class' => 'form-control form-control-sm', 'id' => 'empresa', 'disabled']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('sucursal', 'Sucursal <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                     {!! Form::select('sucursal', $sucursal, isset($ordenC) ? $ordenC->id_local_empresa : '', ['class' => 'form-control form-control-sm', 'id' => 'sucursal', 'data-old' => $ordenC->id_local_empresa]) !!}
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="sucursal-error"></div>
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('almacen', 'Almacen <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                     {!! Form::select('almacen', ['' => 'SELECCIONAR'] + $almacen, isset($ordenC) ? $ordenC->id_almacen : '', ['class' => 'form-control form-control-sm almacen_disabled', 'id' => 'almacen', 'disabled']) !!}
                     {{-- {!! Form::text('almacen','5', ['class' => 'form-control form-control-sm', 'id' => 'almacen', 'readonly']) !!} --}}
                     {!! Form::hidden('almacentext', null, ['id' => 'almacenTexto']) !!}
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="almacen-error"></div>
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('documento', 'Documento', ['class' => 'font-weight-bold'])) !!} <div class="input-group mb-2 mr-sm-2">
                        {!! Form::text('doc_oc', isset($ordenC) ? $ordenC->codigo_orden_compra : '', ['class' => 'form-control form-control-sm', 'readonly']) !!}
                        {!! Form::hidden('id_orden_compra', $ordenC->id_orden_compra, ['id' => 'idOrdenCompra']) !!}
                     </div>
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('fecha', 'Fecha <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                     <div class="input-group">
                        {!! Form::text('fec_emision', isset($ordenC) ? date('d-m-Y', strtotime($ordenC->fecha_registro)) : '', ['class' => 'form-control form-control-sm fecha' , 'id' => 'fec_emision', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                        <div class="input-group-append">
                           <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                     </div>
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fec_emision-error"></div>
                  </div>


                  <div class="col-3">
                     {!! Html::decode(Form::label('moneda', 'Moneda <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                     {!! Form::select('moneda', ['' => 'SELECCIONAR'] + $moneda, isset($ordenC) ? $ordenC->tipo_moneda : '', ['class' => 'form-control form-control-sm', 'id' => 'moneda']) !!}
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="moneda-error"></div>
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('estado', 'Estado', ['class' => 'font-weight-bold'])) !!}
                     {!! Form::text('estado', $estadoN->valor1, ['class' => 'form-control form-control-sm' , 'readonly']) !!}
                  </div>


                  <div class="col-3">
                     {!! Html::decode(Form::label('usuario', 'Usuario Responsable', ['class' => 'font-weight-bold'])) !!}
                     {!! Form::text('usu_responsable',$usuario->username, ['class' => 'form-control form-control-sm' , 'readonly']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('motivo', 'Motivo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::select('motivooc', ['' => 'SELECCIONAR'] + $motivosOC, isset($ordenC) ? $ordenC->id_motivo : '', ['class' => 'form-control form-control-sm', 'id' => 'motivooc']) !!}
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="motivooc-error"></div>
                  </div>

                  <div class="col-6">
                     {!! Html::decode(Form::label('detalle', 'Detalle Motivo', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('detalle_motivo', isset($ordenC) ? $ordenC->detalle_motivo : '', ['class' => 'form-control form-control-sm alfanumerico', 'maxlength' => '50', 'autocomplete' => 'off' ,'id' => 'detalle_motivo']) !!}
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="detalle_motivo-error"></div>
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('condicion', 'Condición de Pago <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::select('condicion_pago', ['' => 'SELECCIONAR', 'CONTADO' => 'CONTADO', 'CREDITO-15D' => 'CREDITO A 15 DIAS', 'CREDITO-30D' => 'CREDITO A 30 DIAS', 'CREDITO-45D' => 'CREDITO A 45 DIAS', 'CREDITO-60D' => 'CREDITO A 60 DIAS'] , isset($ordenC) ? $ordenC->condicion_pago : '', ['class' => 'form-control form-control-sm', 'id' => 'condicion_pago']) !!}
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="condicion_pago-error"></div>
                  </div>

                  <div class="col-3" id="proveedor_typeahead">
                     {!! Html::decode(Form::label('proveedor', 'Proveedor <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!} <div class="input-group">
                        <div class="input-group-prepend">
                           <div class="input-group-text p-0 px-2">RUC</div>
                        </div>
                        {!! Form::text('proveedor', $proveedor->num_doc, ['class' => 'form-control form-control-sm numeros', 'maxlength' => '11','id' => 'proveedor']) !!}
                        {!! Form::hidden('proveedorID', isset($ordenC) ? $ordenC->id_proveedor : '', ['id' => 'proveedor_id']) !!}
                     </div>
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="proveedor-error"></div>
                     <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="proveedorID-error"></div>
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('contacto', 'Contacto', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('contacto', $proveedor->contacto, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provN_contacto']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('telefono', 'Teléfono', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('telefono', $proveedor->telf_contacto, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provT_contacto']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('email', 'Email', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('email', $proveedor->email_contacto, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provE_contacto']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('direccion', $proveedor->direccion, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provD_contacto']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('departamento', 'Departamento', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('departamento', $proveedor->departamento, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provDp_contacto']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('provincia', $proveedor->provincia, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provP_contacto']) !!}
                  </div>

                  <div class="col-3">
                     {!! Html::decode(Form::label('distrito', 'Distrito', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::text('distrito', $proveedor->distrito, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provDd_contacto']) !!}
                  </div>

                  <div class="col-6">
                     {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold mt-1'])) !!}
                     {!! Form::textarea('observaciones', isset($ordenC) ? $ordenC->observaciones : '', ['class' => 'form-control form-control-sm alfanumerico', 'id' => 'observaciones', 'autocomplete' => 'off', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
                  </div>

                  {{-- <div class="col-3">
                  {!! Html::decode(Form::label('factura', 'Factura', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('factura', null, ['class' => 'form-control form-control-sm' , 'readonly']) !!}
               </div> 

               <div class="col-3 d-flex justify-content-end align-items-end">
                  <button type="button" class="btn btn-secondary">Imprimir OC</button>
               </div>  --}}

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
                              <td>{{ $loop->index + 1  }}</td>
                              <td class="vehiculo_typeahead">
                                 <input type="hidden" name="id_lineaoc[]" class="form-control form-control-sm" value="{{ $loc->id_linea_orden_compra }}">
                                 <input type="text" name="modComercial_vn[]" id="modelComercialVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo autocompletado2 alfanumerico" value="{{ $loc->modelo }}" />
                                 <input type="hidden" name="idVehiculoN[]" id="idVehiculoN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo" value="{{ $loc->id_vehiculo_nuevo }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="idVehiculoN-error_{{ $loop->index + 1  }}"></div>
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="modComercial_vn-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td>
                                 <input type="text" name="vin_vn[]" id="vin_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo alfanumerico" value="{{ $loc->vin }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="vin_vn-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td>
                                 <input type="text" name="numMotor_vn[]" id="NumMotor_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo alfanumerico" value="{{ $loc->numero_motor }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="numMotor_vn-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td>
                                 <input type="text" name="year_vn[]" id="yearVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo numeros" value="{{ $loc->anio }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="year_vn-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td>
                                 <input type="text" name="color_vn[]" id="colorVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo alfanumerico" value="{{ $loc->color }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="color_vn-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td>
                                 <input type="text" name="cosUnitario_vh[]" id="cosUnitarioVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo cosUnitarioVN numeros2 decimal" value="{{ $loc->precio }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cosUnitario_vh-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td>
                                 <input type="text" name="desUnitario_vn[]" id="desUnitarioVN_{{ $loop->index + 1  }}" class="form-control form-control-sm desUnitario_VN vehiculo numeros2 decimal desUnitarioVN" value="{{ $loc->descuento }}" />
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="desUnitario_vn-error_{{ $loop->index + 1  }}"></div>
                              </td>
                              <td><input type="text" name="subTotal_vn[]" id="subTotalVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo subTotal_VN" readonly value="{{ $loc->sub_total }}" /></td>
                              <td><input type="text" name="igv_vn[]" id="igvVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo igv_VN" readonly value="{{ $loc->impuesto }}" /></td>
                              <td><input type="text" name="total_vn[]" id="totalVN_{{ $loop->index + 1  }}" class="form-control form-control-sm vehiculo" readonly value="{{ $loc->total }}" /></td>
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
                                 {!! Form::text('valor_venta', null, ['class' => 'form-control form-control-sm' , 'id' => 'valor_ventaVN', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('descuento', 'Descuento', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('descuento_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'descuento_finalVN', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('subtotal_final', 'SubTotal', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('subtotal_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'subtotal_finalVN', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('impuesto_total', 'Impuesto', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('impuesto_total', null, ['class' => 'form-control form-control-sm' , 'id' => 'impuesto_totalVN', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('total_final', 'Total', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append ">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('total_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'total_finalVN', 'readonly']) !!}
                              </div>
                           </div>
                        </div>
                     </div>


                  </div>
                  @else
                  {{-- **************** TABLA PARA ALMACENES, MENOS VEHICULOS NUEVOS ********** --}}
                  <div class="table-cont-single">
                     <table id="tablaDetalleOCT" class="table text-center table-striped table-sm">
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

                              @if ($loc->codigo_repuesto != null )

                              <td>{{ $loop->index + 1  }}</td>
                              <td class="repuesto_typeahead">
                                 <input type="hidden" name="id_lineaoc[]" class="form-control form-control-sm" value="{{ $loc->id_linea_orden_compra }}">
                                 <input type="text" maxlength="6" name="codigo[]" class="form-control form-control-sm repuesto autocompletado alfanumerico" id="codigo_{{ $loop->index + 1  }}" value="{{ $loc->codigo_repuesto }}">
                                 <input type="hidden" name="id_repuesto[]" id="idRepuesto_{{ $loop->index + 1  }}" class="form-control form-control-sm" value="{{ $loc->id_repuesto }}" readonly />
                                 <div class=" text-danger py-0 mb-0 mt-1 d-none font-alert" id="codigo-error_{{ $loop->index + 1  }}">
                                 </div>
                              </td>
                              <td><input type="text" class="form-control form-control-sm" id="desRepuesto_{{ $loop->index + 1  }}" readonly value="{{ $loc->nom_repuesto }}"></td>
                              {{-- <td><input type="text" class="form-control form-control-sm" readonly value="{{ $loc->stock }}"></td> --}}
                              <td><input type="text" class="form-control form-control-sm repuesto" readonly value="0000"></td>
                              <td>
                                 <input type="text" maxlength="6" name="cantidad[]" class="form-control form-control-sm repuesto numeros2 decimal" id="cantidad_{{ $loop->index + 1  }}" value="{{ $loc->cantidad }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cantidad-error_{{ $loop->index + 1  }}">
                              </td>
                              <td>
                                 <input type="text" maxlength="9" name="costo_unitario[]" class="form-control form-control-sm repuesto precio numeros2 decimal" id="precio_{{ $loop->index + 1  }}" value="{{ $loc->precio }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="costo_unitario-error_{{ $loop->index + 1  }}">
                              </td>
                              <td>
                                 <input type="text" maxlength="6" name="des_unitario[]" class="form-control form-control-sm repuesto descuento numeros2 decimal" id="descuento_{{ $loop->index + 1  }}" value="{{ $loc->descuento }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="des_unitario-error_{{ $loop->index + 1  }}">
                              </td>
                              <td>
                                 <input type="text" name="sub_total[]" class="form-control form-control-sm subtotal" readonly id="subtotal_{{ $loop->index + 1  }}" value="{{ $loc->sub_total }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="subtotal-error_{{ $loop->index + 1  }}">

                              </td>
                              <td>
                                 <input type="text" name="impuesto[]" class="form-control form-control-sm " readonly id="impuesto_{{ $loop->index + 1  }}" value="{{ $loc->impuesto }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="impuesto-error_{{ $loop->index + 1  }}">

                              </td>
                              <td>
                                 <input type="text" name="total[]" class="form-control form-control-sm " readonly id="total_{{ $loop->index + 1  }}" value="{{ $loc->total }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="total-error_{{ $loop->index + 1  }}">
                              </td>

                              @else

                              <td>{{ $loop->index + 1  }}</td>
                              <td class="producto_typeahead">
                                 <input type="hidden" name="id_lineaoc[]" class="form-control form-control-sm" value="{{ $loc->id_linea_orden_compra }}">
                                 <input type="text" maxlength="6" name="codigo[]" class="form-control form-control-sm repuesto autocompletado3 alfanumerico" id="codigo_{{ $loop->index + 1  }}" value="{{ $loc->codigo }}">
                                 <input type="hidden" name="id_otro_producto[]" id="idRepuesto_{{ $loop->index + 1  }}" class="form-control form-control-sm" value="{{ $loc->id_otro_producto }}" readonly />
                                 <div class=" text-danger py-0 mb-0 mt-1 d-none font-alert" id="codigo-error_{{ $loop->index + 1  }}">
                                 </div>
                              </td>
                              <td><input type="text" class="form-control form-control-sm" id="desRepuesto_{{ $loop->index + 1  }}" readonly value="{{ $loc->nom_producto }}"></td>
                              {{-- <td><input type="text" class="form-control form-control-sm" readonly value="{{ $loc->stock }}"></td> --}}
                              <td><input type="text" class="form-control form-control-sm repuesto" readonly value="0000"></td>
                              <td>
                                 <input type="text" maxlength="6" name="cantidad[]" class="form-control form-control-sm repuesto numeros2 decimal" id="cantidad_{{ $loop->index + 1  }}" value="{{ $loc->cantidad }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cantidad-error_{{ $loop->index + 1  }}">
                              </td>
                              <td>
                                 <input type="text" maxlength="9" name="costo_unitario[]" class="form-control form-control-sm repuesto precio numeros2 decimal" id="precio_{{ $loop->index + 1  }}" value="{{ $loc->precio }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="costo_unitario-error_{{ $loop->index + 1  }}">
                              </td>
                              <td>
                                 <input type="text" maxlength="6" name="des_unitario[]" class="form-control form-control-sm repuesto descuento numeros2 decimal decimal" id="descuento_{{ $loop->index + 1  }}" value="{{ $loc->descuento }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="des_unitario-error_{{ $loop->index + 1  }}">
                              </td>
                              <td>
                                 <input type="text" name="sub_total[]" class="form-control form-control-sm subtotal" readonly id="subtotal_{{ $loop->index + 1  }}" value="{{ $loc->sub_total }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="subtotal-error_{{ $loop->index + 1  }}">

                              </td>
                              <td>
                                 <input type="text" name="impuesto[]" class="form-control form-control-sm " readonly id="impuesto_{{ $loop->index + 1  }}" value="{{ $loc->impuesto }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="impuesto-error_{{ $loop->index + 1  }}">

                              </td>
                              <td>
                                 <input type="text" name="total[]" class="form-control form-control-sm " readonly id="total_{{ $loop->index + 1  }}" value="{{ $loc->total }}">
                                 <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="total-error_{{ $loop->index + 1  }}">

                              </td>
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
                                 {!! Form::text('valor_venta', null, ['class' => 'form-control form-control-sm' , 'id' => 'valor_venta', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('descuento', 'Descuento', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('descuento_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'descuento_final', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('subtotal_final', 'SubTotal', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('subtotal_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'subtotal_final', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('impuesto_total', 'Impuesto', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('impuesto_total', null, ['class' => 'form-control form-control-sm' , 'id' => 'impuesto_total', 'readonly']) !!}
                              </div>
                           </div>

                           <div class="col-2">
                              {!! Html::decode(Form::label('total_final', 'Total', ['class' => 'font-weight-bold'])) !!}
                              <div class="input-group">
                                 <div class="input-group-append ">
                                    <span class="input-group-text p-0 px-2 simbolo_moneda simbolo_moneda">S/.</span>
                                 </div>
                                 {!! Form::text('total_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'total_final', 'readonly']) !!}
                              </div>
                           </div>
                        </div>
                     </div>


                  </div>
                  @endif




               </div>
            </div>
         </div>




         <div class="col-12 text-center">
            {!! Form::button('<i class="fas fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-success mr-1 px-3', 'type' => 'submit']) !!}

         </div>
      </form>
   </div>


</div>

@endsection

@section('extra-scripts')

<script src="{{asset('scripts/script_actualizarOC.js') }}"></script>
@endsection