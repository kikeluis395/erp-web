@extends('tableCanvas')
@if(isset($id_recepcion_ot))
  @section('titulo',"Detalle de Compras N° $id_recepcion_ot")
@else
  @section('titulo',"Modulo de recepcion - Registro")
@endif

@section('pretable-content')
@endsection

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 15px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12 justify-content-between">
          <div>
            <h2>Detalle de Compras</h2>
          </div>
          <div>
            <button id="btnGuardarCompra" value="Submit" type="submit" form="formDetallesCompra" style="margin-left:15px" class="btn btn-warning">Guardar</button>
          </div>
        </div>
      </div>

      <div class="table-cont-single">
        <form id="formDetallesCompra" method="POST" action="{{route('contabilidad.detalleCompras.store')}}" autocomplete="off">
          @csrf
          <div class="row justify-content-between col-12" style="padding:0 15px 0 15px">
            <div>
              Ingrese los elementos de la compra:
            </div>
            <div>
              <button id="btnAddLineaCompra" type="button" class="btn btn-warning">+</button>
            </div>
          </div>
          <table class="col-12 table text-center table-striped table-sm" id="tableCompras" style="display:none">
            <thead>
              <th scope="col">#</th>
              <th scope="col">CODIGO</th>
              <th scope="col">DESCRIPCION</th>
              <th scope="col">CANT.</th>
              <th scope="col">C. UNIT.</th>
              <th scope="col">ELIMINAR</th>
            </thead>
            <tbody id="tbodySolRepuesto">
              @if(false)
              <!-- <tr>
                <td>1</td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><button id="btnEliminarLineaSolRepuesto" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>
              </tr> -->
              @endif
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/compras.js?v='.time())}}"></script>
@endsection