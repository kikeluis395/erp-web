@extends('otrosproductos.otrosProductos')
@section('titulo','Maestro - Otros Productos y Servicios')

@section('pretable-content')



<div class="row" style="background: white;padding: 10px">
   <div class="col-12 mt-2 mt-sm-0">
      <h2 class="ml-3 mt-3 mb-4">Maestro de Otros Productos y Servicios</h2>
   </div>

   <div class="col-12 collapse" id="filtro_OtrosProductos">
      <div class="card">
         <div class="card-body row">

            <div class="col-12 col-sm-6  col-lg-3 mt-2">
               <label class="font-weight-bold">Código</label>
               <input type="text" class="form-control form-control-sm" name="codoproducto_buscar" id="codoproducto_buscar" placeholder="CÓDIGO" maxlength="14" autocomplete="off">
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mt-2">
               <label class="font-weight-bold">Estado</label>

               <select class="form-control form-control-sm" name="estado_oproducto" id="estado_oproducto">
                  <option value="1">ACTIVO</option>
                  <option>INACTIVO</option>
                  <option hidden value="0" selected>TODOS</option>
               </select>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mt-2">
               <label class="font-weight-bold">Almacén</label>
               <select class="form-control form-control-sm" id="almac_oproducto">
                  @foreach ($almacenes as $almacen)
                  <option value="{{ $almacen->id }}">{{ $almacen->valor1 }}</option>
                  @endforeach
                  <option hidden value="0" selected>TODOS</option>
               </select>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mt-2">
               <label class="font-weight-bold">Resp. Creación</label>
               <select class="form-control form-control-sm" id="rep_oproducto">
                  @foreach ($usuarios as $usu)
                  <option value="{{ $usu->id_usuario }}">{{ $usu->username }}</option>
                  @endforeach
                  <option hidden value="0" selected>TODOS</option>
               </select>
            </div>

            <div class="col-12 mt-2 d-flex justify-content-end">
               <div class="div">
                  <button type="button" class="btn btn-primary" id="filtrar">Buscar</button>
                  <button type="button" class="btn btn-primary" id="reiniciar">Limpiar</button>
               </div>
            </div>
         </div>
      </div>

   </div>

</div>

@endsection

@section('table-content')

<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">

   <div class="table-responsive borde-tabla tableFixHead">
      <div class="table-wrapper">
         <div class="table-title">
            <div class="row col-12 justify-content-between">
               <div>
                  <h2>Otros Productos y Servicios
                     <button type="button" class="btn btn-primary ml-2" data-toggle="collapse" data-target="#filtro_OtrosProductos" aria-expanded="false" aria-controls="filtro_OtrosProductos">Filtrar</button>
                  </h2>
               </div>

               <div>
                  <button id="crear_registro" type="button" style="margin-left:15px" class="btn btn-warning"><i class="fas fa-plus m-0"></i></button>
               </div>
            </div>
         </div>

         <div class="table-cont-single">
            <table id="tablaOProductos" tipo="nuevo" class="table text-center table-striped table-sm">
               <thead>
                  <tr>
                     <th width="3%" scope="col">#</th>
                     <th width="5%" scope="col">ESTADO</th>
                     <th width="5%" scope="col">CÓDIGO</th>
                     <th width="20%" scope="col">DESCRIPCIÓN</th>
                     <th width="20%" scope="col">ALMACEN</th>
                     <th width="10%" scope="col">F. CREACIÓN</th>
                     <th width="8%" scope="col">CREADO POR</th>
                     <th width="10%" scope="col">F. ÚLTIMA EDICIÓN</th>
                     <th width="8%" scope="col">EDITADO POR</th>
                     <th width="11%" scope="col">ACCIONES</th>
                  </tr>
               </thead>
               <tbody class="text-center">

               </tbody>
            </table>
         </div>
      </div>
   </div>

</div>


{{-- ******************* AGREGAR / EDITAR PRODUCTOS *********************** --}}
<div class="modal fade px-0" id="agregarOtroProductoModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header fondo-sigma">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="POST" id="form-otroProducto" action="{{ route('otros_productos.store') }}" }}">
            @csrf
            <div class="modal-body">

               <div class="d-flex justify-content-center">
                  <div class="col-12 col-lg-10">
                     <div class="modal-body col-12 pb-2 pt-4">

                        <div class="row mb-2">
                           <label class="font-weight-bold col-12 col-md-4 px-0">ALMACEN <span class="text-danger font-weight-normal ml-1">*</span></label>
                           <div class="col-12 col-md-8 px-0">
                              <select class="form-control form-control-sm" name="almacen_oproducto" id="almacen_oproducto">
                                 <option value="0">SELECCIONAR</option>
                                 @foreach ($parametros as $parametro)
                                 <option value="{{ $parametro->id }}">{{ $parametro->valor1 }}</option>
                                 @endforeach
                              </select>
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="almacen_oproducto-error"></div>
                           </div>
                        </div>

                        <div class="row mb-2">
                           <label class="font-weight-bold col-12 col-md-4 px-0">CÓDIGO <span class="text-danger font-weight-normal ml-1">*</span></label>
                           <div class="col-12 col-md-8 px-0">
                              <input type="text" name="cod_oproducto" class="form-control form-control-sm alfanumerico" id="cod_oproducto" autocomplete="off" placeholder="CÓDIGO" maxlength="9">
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cod_oproducto-error"></div>
                           </div>
                        </div>

                        <div class="row mb-2">
                           <label class="font-weight-bold col-12 col-md-4 px-0">DESCRIPCIÓN <span class="text-danger font-weight-normal ml-1">*</span></label>
                           <div class="col-12 col-md-8 px-0">
                              <input type="text" name="des_oproducto" class="form-control form-control-sm alfanumerico" id="des_oproducto" autocomplete="off" placeholder="DESCRIPCIÓN" maxlength="50">
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="des_oproducto-error"></div>

                           </div>
                        </div>

                        <div class="row mb-2">
                           <label class="font-weight-bold col-12 col-md-4 px-0">ESTADO <span class="text-danger font-weight-normal ml-1">*</span></label>
                           <div class="col-12 col-md-8 px-0">
                              {{-- <input type="checkbox" checked name="estado_oproducto" class="hola" id="est_oproducto"> --}}
                              <input type="checkbox" name="estado_oproducto" id="est_oproducto" class="toggle-class" data-size="sm" data-onstyle="primary" data-offstyle="danger" data-on="<i class='fas fa-check'></i>" data-off="<i class='fas fa-times'></i>" checked>
                              <label class="ml-1 mt-1" id="nombre_estado">ACTIVO</label>
                              <div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="estado_oproducto-error"></div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
               <input type="hidden" value="Agregar" id="action">
               <input type="hidden" name="osproducto_id" id="osproducto_id">
               <button type="submit" class="btn btn-success action_button"><i class="fas fa-save mr-2"></i>Guardar</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-sign-out-alt mr-2"></i>Cancelar</button>
            </div>
         </form>

      </div>
   </div>
</div>


{{-- ******************* ELIMINAR PRODUCTOS *********************** --}}
<div class="modal fade px-0" id="eliminarOtroProducto" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header fondo-sigma">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p class="text-center mb-0">¿Deseas eliminar este registro?</p>
         </div>
         <div class="modal-footer d-flex justify-content-center">
            <button value="Submit" type="submit" class="btn btn-danger" id="ok_button"><i class="fas fa-trash-alt mr-2"></i>Eliminar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-sign-out-alt mr-2"></i>Cancelar</button>
         </div>


      </div>
   </div>
</div>

@endsection


@section('extra-scripts')
@parent
<script src="{{asset('scripts/otrosproductos.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script> --}}
@endsection