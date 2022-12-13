@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - DetalleCuenta') 

@section('content')

<div style="background: white;padding: 10px">
    <div class="row justify-content-between col-12">
        <h2 class="ml-3 mt-3 mb-0">Cuenta - 654897325641</h2>
        <div class="justify-content-end">
            <a href="{{url()->previous()}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
      </div>
    </div>
 </div>

 <div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12 justify-content-between">
            <div class="form-inline row">
                <h2>Movimientos Asociados</h2>
            </div>

        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col" style="width: 10%;">#</th>
              <th scope="col" style="width: 23%;">PROVEEDOR</th>
              <th scope="col" style="width: 23%;">FECHA</th>
              <th scope="col" style="width: 23%;">MONTO</th>
              <th scope="col" style="width: 19%;">REALIZADO POR</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Pepito SAC</td>
              <td>03/01/2021</td>
              <td>S/. 1,000</td>
              <td>Bruno Espezua</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Pepito SAC</td>
              <td>10/01/2021</td>
              <td>S/. 2,000</td>
              <td>Bruno Espezua</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div>
</div>

@endsection