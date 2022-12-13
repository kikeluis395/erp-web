@extends('tableCanvas')
@section('titulo','Modulo de rebate') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Seguimiento Rebates</h2>

  <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
    <form id="FormFiltrarRecepcion" class="my-3" method="GET" action="{{route('entrega.index')}}" value="search">
      <div class="row">
        <div class="form-group row ml-1 col-6 col-sm-3">
          <label for="filtroNroDoc" class="col-form-label col-12 col-sm-6">DNI/RUC</label>
          <input id="filtroNroDoc" name="nroDoc" type="text" class="form-control col-12 col-sm-6" placeholder="Número de documento">
        </div>
        <div class="form-group row ml-1 col-6 col-md-3">
          <label for="filtroPlaca" class="col-form-label col-12 col-sm-4 col-lg-6">Placa</label>
          <input id="filtroPlaca" name="nroPlaca" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Número de placa" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="form-group row ml-1 col-6 col-md-3">
          <label for="filtroOT" class="col-form-label col-12 col-sm-4 col-lg-6">OT/COT MESON</label>
          <input id="filtroOT" name="nroOT" type="text" class="form-control col-12 col-sm-6 col-lg-6" placeholder="Órden de Trabajo">
        </div>

        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
          <label for="filtroMarca" class="col-form-label col-6 col-lg-5">Marca</label>
          <select name="marca" id="filtroMarca" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
          </select>
        </div>
        <div class="form-group row ml-1 col-12 ml-sm-0 col-sm-6 col-md-3">
          <label for="filtroSeguro" class="col-form-label col-6 col-lg-5">Seguro</label>
          <select name="seguro" id="filtroSeguro" class="form-control col-6 col-lg-7">
            <option value="all">Todos</option>
          </select>
        </div>
      </div>
      <div class="col-12">
        <div class="row justify-content-end">
          <button type="submit" class="btn btn-primary ">Buscar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12">
          <div>
            <h2>Lista de rebates</h2>
          </div>

          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
            Filtrar
          </button>
        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm tableFixHead">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">LOCAL</th>
              <th scope="col">REGISTRADO POR</th>
              <th scope="col">FECHA FACTURA</th>
              <th scope="col">DOC FACTURA</th>
              <th scope="col">DOC CLIENTE</th>
              <th scope="col">CLIENTE</th>
              <th scope="col">GLOSA</th>
              <th scope="col">MONEDA</th>
              <th scope="col">V. VENTA</th>
              <th scope="col">ASIGNAR</th>              
            </tr>
          </thead>
          <tbody>
              @foreach ($rebates as $rebate)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rebate->local->nombre_local }}</td>
                    <td>{{ $rebate->empleado->nombreCompleto() }}</td>
                    <td>{{ $rebate->fecha_registro->format('d/m/Y') }}</td>
                    <td>{{ $rebate->factura }}</td>
                    <td>{{ $rebate->proveedor->num_doc }}</td>
                    <td>{{ $rebate->proveedor->nombre_proveedor }}</td>
                    <td>{{ $rebate->descripcion }}</td>
                    <td>DÓLARES</td>
                    <td>$ {{ $rebate->venta_dolares }}</td>
                    @if ($rebate->fuente && $rebate->fecha_venta)
                    <td>Asignado</td>
                    @else
                    <td>
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#confirmarEntregaModal-{{$loop->iteration}}" data-backdrop="static"><i class="fas fa-edit"></i></button>
                  <!-- Modal -->
                  <div class="modal fade" id="confirmarEntregaModal-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="confirmarEntregaLabel-{{$loop->iteration}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header fondo-sigma">
                          <h5 class="modal-title" id="confirmarEntregaLabel-{{$loop->iteration}}"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                          <form id="FormConfirmarEntrega-{{$loop->iteration}}" method="POST" 

                          value="Submit" autocomplete="off">
                            @csrf
                            <input type="hidden">
                            <div class="form-group form-inline">
                              <label for="fechaEntregaIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Fecha de entrega: </label>
                              <input name="fechaEntrega" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaEntregaIn-{{$loop->iteration}}" autocomplete="off">
                              <div id="errorFechaEntrega-{{$loop->iteration}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="nroFacturaIn-{{$loop->iteration}}" class="col-sm-6 justify-content-end">Número de Factura: </label>
                              <input name="nroFactura" type="text" class="form-control col-sm-6" id="nroFacturaIn-{{$loop->iteration}}" data-validation-error-msg="Debe ingresar el número de factura" data-validation-error-msg-container="#errorNroFactura-{{$loop->iteration}}" placeholder="Ingrese el número de factura" maxlength="32" autocomplete="off">
                              <div id="errorNroFactura-{{$loop->iteration}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button id="btnSubmit-{{$loop->iteration}}" form="FormConfirmarEntrega-{{$loop->iteration}}" value="Submit" type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                    </td>
                    @endif
                  </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/entrega.js')}}"></script>
@endsection