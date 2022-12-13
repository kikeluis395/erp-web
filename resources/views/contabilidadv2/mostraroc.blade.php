@extends('contabilidadv2.layoutCont')

@section('titulo','Modulo de contabilidad - Mostrar OC')


@section('content')

{{-- {{ dd($empresa) }} --}}

<div class="row m-0" style="background: white;padding: 10px">
   <div class="col-12 col-lg-6 text-center text-lg-left">
      <h2 class="ml-3 mt-3 mb-4">Seguimiento de Ordenes de Compra</h2>
   </div>
   <div class="col-12 col-lg-6 text-right mb-3 d-flex justify-content-lg-end align-items-lg-center">
      <div class="row">
         <a href="{{ route('contabilidad.crearOC') }}">
            {!! Form::button('<i class="fas fa-plus mr-2"></i>Registrar OC Regular', ['class'=>'btn btn-success btn-sm', 'type' => 'button']) !!}
         </a>
      <span class="ml-4"></span>
         <a href="{{ route('contabilidad.crearOCVehiculoNuevo') }}">
            {!! Form::button('<i class="fas fa-plus mr-2"></i>Registrar OC Vehiculo Nuevo', ['class'=>'btn btn-success btn-sm', 'type' => 'button']) !!}
         </a>
      </div>

      <span class="ml-4"></span>
         <a href="{{ route('vehiculo_seminuevo.crear_oc') }}">
            {!! Form::button('<i class="fas fa-plus mr-2"></i>Registrar OC Vehiculo Semi Nuevo', ['class'=>'btn btn-success btn-sm', 'type' => 'button']) !!}
         </a>
      </div>
      
   </div>


   <div class="col-12" id="filtro_ordeCompra">
      <div class="card">
         <div class="card-body row">

            <div class="col-12 col-md-4 col-lg-3">
               {!! Html::decode(Form::label('empresa', 'Empresa', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::select('empresa', ['0' => 'TODOS'] + $empresa, '1', ['class' => 'form-control form-control-sm', 'id' => 'empresa', 'disabled']) !!}
            </div>

            <div class="col-12 col-md-4 col-lg-3">
               {!! Html::decode(Form::label('sucursal', 'Sucursal', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::select('sucursal', ['0' => 'TODOS'] , null, ['class' => 'form-control form-control-sm', 'id' => 'sucursal_buscar']) !!}
            </div>

            <div class="col-12 col-md-4 col-lg-3">
               {!! Html::decode(Form::label('almacen', 'Almacen', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::select('almacen', ['0' => 'TODOS'] + $almacenes, null, ['class' => 'form-control form-control-sm', 'id' => 'almacen_buscar']) !!}
            </div>

            <div class="col-12 col-md-4 col-lg-3">
               {!! Html::decode(Form::label('estado', 'Estado ', ['class' => 'font-weight-bold mt-2'])) !!}
               {!! Form::select('estado', ['0' => 'TODOS'] + $estados, null, ['class' => 'form-control form-control-sm', 'id' => 'estado_buscar']) !!}
            </div>

            <div class="col-12 col-md-4 col-lg-3">
               {!! Html::decode(Form::label('documento', 'Documento OC', ['class' => 'font-weight-bold mt-2', 'maxlength'=> '6'])) !!} <div class="input-group mb-2 mr-sm-2">
                  {!! Form::text('doc_oc', null, ['class' => 'form-control form-control-sm', 'id' => 'dococ_buscar']) !!}
               </div>
            </div>

            <div class="col-12  col-md-4 col-lg-3" id="proveedor_typeahead">
               {!! Html::decode(Form::label('proveedor', 'Proveedor', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="input-group">
                  <div class="input-group-prepend">
                     <div class="input-group-text p-0 px-2">RUC</div>
                  </div>
                  {!! Form::text('proveedor', null, ['class' => 'form-control form-control-sm numeros', 'maxlength' => '11','id' => 'proveedor_buscar']) !!}
                  {!! Form::hidden('proveedorID', null, ['id' => 'proveedorID']) !!}
               </div>
            </div>

            <div class="col-12 col-lg-6">
               {!! Html::decode(Form::label('fecha', 'Fecha', ['class' => 'font-weight-bold mt-2'])) !!}
               <div class="row">
                  <div class="input-group col-12 col-md-6">
                     {!! Form::text('fec_inicial', null, ['class' => 'form-control form-control-sm fecha' , 'id' => 'fec_inicial', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'FECHA INICIAL']) !!}
                     <div class="input-group-append">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                     </div>
                  </div>
                  <div class="input-group col-12 col-md-6 mt-3 mt-md-0">
                     {!! Form::text('fec_final', null, ['class' => 'form-control form-control-sm fecha' , 'id' => 'fec_final', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'FECHA FINAL']) !!}
                     <div class="input-group-append">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                     </div>
                  </div>

                  {{-- <div class="col-12 col-md-4 col-lg-3">
                     {!! Html::decode(Form::label('documento_ni', 'Documento NI', ['class' => 'font-weight-bold mt-2', 'maxlength'=> '6'])) !!} <div class="input-group mb-2 mr-sm-2">
                        {!! Form::text('doc_ni', null, ['class' => 'form-control form-control-sm', 'id' => 'docni_buscar']) !!}
                     </div>
                  </div> --}}

                  {{-- <div class=""><span class="px-3"> - </span></div> --}}


               </div>
            </div>

            <div class="col-12 mt-2 d-flex justify-content-center justify-content-lg-end mt-3">
               <div class="div">
                  <button type="button" class="btn btn-primary px-3" id="filtrar">Filtrar</button>
                  <button type="button" class="btn btn-primary" id="reiniciar">Limpiar</button>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="col-12 mt-2 d-none" id="SectionDatatables">
      <div class="" style="background: white;">

         <table id="tablaOrdenCompra" tipo="nuevo" class="table table-sm table-bordered text-nowrap w-120">
            <thead>
               <tr class="text-left text-white" style="background-color: #435d7d">
                  <th colspan="15" ">
                     <h4>Ordenes de Compra Registradas</h4>
                  </th>
               </tr>
               <tr class=" text-center">
                  <th width="5%" scope="col">#</th>
                  <th width="5%" scope="col">SEDE</th>
                  <th width="10%" scope="col">ALMACEN</th>
                  <th width="10%" scope="col">MOTIVO</th>
                  <th width="5%" scope="col">FEC. CREACIÓN</th>
                  <th width="5%" scope="col">ORDEN DE COMPRA</th>
                  <th class="5% " scope="col">ID PROVEEDOR</th>
                  <th width="10%" scope="col">RUC PROVEEDOR</th>
                  <th width="5%" scope="col">NOMBRE PROVEEDOR</th>
                  <th width="5%" scope="col">FACTURA PROVEEDOR</th>
                  <th width="5%" scope="col">ESTADO</th>
                  <th width="5%" scope="col">MONEDA</th>
                  <th width="5%" scope="col">SUBTOTAL</th>
                  <th width="15%" scope="col">ACCIONES   </th>
                  <th width="10%" scope="col">NOTA INGRESO  </th>
                  

               </tr>
            </thead>
            <tbody class="text-center">

            </tbody>
         </table>


      </div>
   </div>

</div>



@endsection

@section('extra-scripts')
@parent
<script src="{{asset('scripts/script_mostrarOC.js') }}"></script>
@endsection