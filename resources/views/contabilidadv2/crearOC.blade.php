@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Crear OC')

@section('content')

{{-- {{ dd($local_empresa->nombre_empresa) }} --}}
<style>
   .disabled{
      color:white!important;
   }
</style>
<div id="containerMec" class="mx-auto" style="background: white;padding: 15px">
   <div class="row">
      <div class="col-12 mt-2 d-flex justify-content-between align-items-center">
         <h2 class="ml-3 mt-3 mb-4">Generar Orden de Compra</h2>
         <a href="{{ route('contabilidad.seguimientoOC') }}" class="pr-3">
            {!! Form::button('<i class="fas fa-arrow-left mr-2"></i>Regresar', ['class'=>'btn btn-success btn-sm', 'type' => 'button']) !!}
         </a>
      </div>

      {!! Form::open(['route' => 'contabilidad.crearOC.store', 'method' => 'POST' , 'class' => 'col-12', 'id' => 'form_detalleoc']) !!}
      {!! Form::token() !!}

      <div class="col-12">
         <div class="card">
            <div class="card-body row">

               <div class="col-3">
                  {!! Html::decode(Form::label('empresa', 'Empresa', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::select('empresa', ['' => 'SELECCIONAR'] + $empresa, '1', ['class' => 'form-control form-control-sm', 'id' => 'empresa', 'disabled']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('sucursal', 'Sucursal <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::select('sucursal', ['1' => 'LOS OLIVOS'] , null, ['class' => 'form-control form-control-sm', 'id' => 'sucursal']) !!}
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="sucursal-error"></div>
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('almacen', 'Almacen <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::select('almacen', ['' => 'SELECCIONAR'] + $almacenes, null, ['class' => 'form-control form-control-sm', 'id' => 'almacen']) !!}
                  {!! Form::hidden('almacentext', null, ['id' => 'almacenTexto']) !!}
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="almacen-error"></div>
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('documento', 'Documento', ['class' => 'font-weight-bold'])) !!} <div class="input-group mb-2 mr-sm-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text p-0 px-2">OC</div>
                     </div>
                     <div class="input-group-prepend">
                        <div class="input-group-text p-0 px-2">{{ $year }}</div>
                     </div>
                     {!! Form::text('doc_oc', null, ['class' => 'form-control form-control-sm', 'readonly']) !!}
                     {!! Form::hidden('id_oc_nueva', $codigoOC, ['id'=>'oc_nueva', 'readonly']) !!}
                  </div>
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('fecha', 'Fecha <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                  <div class="input-group">
                     {{-- {!! Form::text('fec_emision', null, ['class' => 'form-control form-control-sm' , 'id' => 'fec_emision', 'autocomplete' => 'off', 'placeholder' => 'DD-MM-YYYY']) !!} --}}
                     <input name="fec_emision" type="text" autocomplete="off" class="datepicker form-control col-10" min-date="{{ \Carbon\Carbon::now()->subDays(7)->format('d/m/Y') }}" id='fec_emision' placeholder="dd/mm/aaaa"  maxlength="10" autocomplete="off"/>
                     
                     <div class="input-group-append">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                     </div>
                  </div>
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="fec_emision-error"></div>
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('moneda', 'Moneda <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::select('moneda', ['' => 'SELECCIONAR'] + $moneda, null, ['class' => 'form-control form-control-sm', 'id' => 'moneda']) !!}
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="moneda-error"></div>
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('estado', 'Estado', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::text('estado', null, ['class' => 'form-control form-control-sm' , 'readonly']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('usuario', 'Usuario Responsable', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::text('usu_responsable', $usu_logueado, ['class' => 'form-control form-control-sm' , 'readonly']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('motivo', 'Motivo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::select('motivooc', ['' => 'SELECCIONAR'] + $motivosOC, null, ['class' => 'form-control form-control-sm', 'id' => 'motivooc']) !!}
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="motivooc-error"></div>
               </div>

               <div class="col-6">
                  {!! Html::decode(Form::label('detalle', 'Detalle Motivo', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('detalle_motivo', null, ['class' => 'form-control form-control-sm alfanumerico', 'maxlength' => '50', 'autocomplete' => 'off' ,'id' => 'detalle_motivo']) !!}
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="detalle_motivo-error"></div>

               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('condicion', 'Condición de Pago <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::select('condicion_pago', ['' => 'SELECCIONAR'] + $condiciones, null, ['class' => 'form-control form-control-sm', 'id' => 'condicion_pago']) !!}
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="condicion_pago-error"></div>
               </div>

               <div class="col-3" id="proveedor_typeahead">
                  {!! Html::decode(Form::label('proveedor', 'Proveedor <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!} <div class="input-group">
                     <div class="input-group-prepend">
                        <div class="input-group-text p-0 px-2">RUC</div>
                     </div>
                     {!! Form::text('proveedor', null, ['class' => 'form-control form-control-sm numeros', 'maxlength' => '11','id' => 'proveedor', 'autocomplete' => 'off']) !!}
                     {!! Form::hidden('proveedorID', null, ['id' => 'proveedor_id', 'readonly']) !!}
                  </div>
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="proveedor-error"></div>
                  <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="proveedorID-error"></div>
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('nombre', 'Nombre', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('nombre', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'prov_nombre']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('contacto', 'Contacto', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('contacto', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provN_contacto']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('telefono', 'Teléfono', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('telefono', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provT_contacto']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('email', 'Email', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('email', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provE_contacto']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('direccion', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provD_contacto']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('departamento', 'Departamento', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('departamento', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provDp_contacto']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('provincia', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provP_contacto']) !!}
               </div>

               <div class="col-3">
                  {!! Html::decode(Form::label('distrito', 'Distrito', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('distrito', null, ['class' => 'form-control form-control-sm' , 'readonly', 'id' => 'provDd_contacto']) !!}
               </div>

               <div class="col-6">
                  {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::textarea('observaciones', null, ['class' => 'form-control form-control-sm alfanumerico', 'id' => 'observaciones', 'autocomplete' => 'off', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
               </div>

               {{-- <div class="col-3">
                  {!! Html::decode(Form::label('factura', 'Factura', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('factura', null, ['class' => 'form-control form-control-sm' , 'readonly']) !!}
               </div>

               <div class="col-3 d-flex justify-content-end align-items-end">
                  <button type="button" class="btn btn-secondary">Imprimir OC</button>
               </div> --}}

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
                     <div class="row justify-content-end">
                        <div>
                           <button id="agregarFila" type="button" style=" margin-left:15px" class="btn btn-warning d-none">+</button>
                        </div>
                     </div>
                  </div>
               </div>
               {{-- **************** TABLA PARA ALMACENES, MENOS VEHICULOS NUEVOS ********** --}}
               <div class="table-cont-single">
                  <table id="tablaDetalleOCT" class="table text-center table-striped table-sm d-none">
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
                           <th scope="col" style="width: 5%;">ACCIÓN</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>

               <div class="table-cont-single">
                  <table id="tablaDetalleOCOP" class="table text-center table-striped table-sm d-none">
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
                           <th scope="col" style="width: 5%;">ACCIÓN</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>

               <div class="table-cont-single">
                  <table id="tablaDetalleOCOT" class="table text-center table-striped table-sm d-none">
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
                           <th scope="col" style="width: 5%;">ACCIÓN</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>

               {{-- **************** TABLA PARA ALMACENES DE VEHICULOS NUEVOS ********** --}}
               <div class="table-cont-single">
                  <table id="tablaDetalleOCVN" class="table text-center table-striped table-sm d-none">
                     <thead>
                        <tr>
                           <th scope="col" style="width: 5%">#</th>
                           <th scope="col" style="width: 15%">MODELO COMERCIAL</th>
                           <th scope="col" style="width: 10%">VIN</th>
                           <th scope="col" style="width: 5%">NUM. MOTOR</th>
                           <th scope="col" style="width: 5%">AÑO MODELO</th>
                           <th scope="col" style="width: 5%">AÑO FABRICACIÓN</th>
                           <th scope="col" style="width: 10%">COLOR</th>
                           <th scope="col" style="width: 10%">COSTO UNITARIO</th>
                           <th scope="col" style="width: 10%">DESCUENTO UNITARIO</th>
                           <th scope="col" style="width: 10%">SUB TOTAL</th>
                           <th scope="col" style="width: 10%">IGV</th>
                           <th scope="col" style="width: 10%">TOTAL</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>

               <div class="row d-none" id="footer_totales">
                  <div class="col-12">
                     <div class="row d-flex justify-content-center">
                        <div class="col-2">
                           {!! Html::decode(Form::label('valor_venta', 'Costo Inicial', ['class' => 'font-weight-bold'])) !!}
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
                                 <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                              </div>
                              {!! Form::text('subtotal_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'subtotal_final', 'readonly']) !!}
                           </div>
                        </div>

                        <div class="col-2">
                           {!! Html::decode(Form::label('impuesto_total', 'Impuesto', ['class' => 'font-weight-bold'])) !!}
                           <div class="input-group">
                              <div class="input-group-append">
                                 <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                              </div>
                              {!! Form::text('impuesto_total', null, ['class' => 'form-control form-control-sm' , 'id' => 'impuesto_total', 'readonly']) !!}
                           </div>
                        </div>

                        <div class="col-2">
                           {!! Html::decode(Form::label('total_final', 'Total', ['class' => 'font-weight-bold'])) !!}
                           <div class="input-group">
                              <div class="input-group-append">
                                 <span class="input-group-text p-0 px-2 simbolo_moneda">S/.</span>
                              </div>
                              {!! Form::text('total_final', null, ['class' => 'form-control form-control-sm' , 'id' => 'total_final', 'readonly']) !!}
                           </div>
                        </div>
                     </div>
                  </div>


               </div>

            </div>
         </div>
      </div>


      <div class="col-12 text-center">
         {!! Form::button('Generar', ['class'=>'btn btn-success mr-1 px-3', 'type' => 'submit', 'id' => 'crearOC']) !!}
         {!! Form::close() !!}
      </div>

   </div>

  

</div>
@endsection