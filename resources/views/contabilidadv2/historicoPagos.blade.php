@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Histórico de Pagos') 

@section('content')

<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Histórico de Pagos - Contabilidad</h2>
  <div class="col-12 mt-2 mt-sm-0">
 </div>

 <div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12 ">
            <div class="form-inline row">
                <h2>Histórico de Pagos</h2>
            
                <button class="btn btn-primary mr-4" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
                    Filtrar
                </button>
            </div>

        </div>
      </div>
      
      <div class="table-cont-single">
        <table class="table text-center table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#Factura</th>
              <th scope="col">NOMBRE</th>
              <th scope="col">RUC</th>
              <th scope="col">FECHA PAGO</th>
              <th scope="col">MONTO (SIN IGV)</th>
              <th scope="col">BANCO</th>
              <th scope="col">CUENTA CORRIENTE</th>
              <th scope="col"style="width: 5%">VER ASIENTO CONTABLE</th>
            </tr>
          </thead>
          <tbody>
            @foreach($facturas as $factura)
            <tr>
              <th scope="row">{{$factura->nro_factura}}</th>
              <td>{{$factura->getNombreProveedor()}}</td>
              <td>{{$factura->getRUCProveedor()}}</td>
              <td>{{$factura->movimientoBancario->fecha_movimiento}}</td>
              <td>{{$factura->total}}</td>
              <td>{{$factura->movimientoBancario->cuentaAfectada->banco->nombre_banco}}</td>
              <td>{{$factura->movimientoBancario->cuentaAfectada->nro_cuenta}}</td>
              <td>
                
              <button id="btnGenerarSolRepuestos" type="button" class="btn btn-warning" data-toggle="modal" data-target="#generarSolRepuestosModal" data-backdrop="static"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button>
                <!-- Modal -->
                <div class="modal fade" id="generarSolRepuestosModal" tabindex="-1" role="dialog" aria-labelledby="generarSolRepuestosLabel" aria-hidden="true">
                  <div class="modal-dialog " role="document">
                    <div class="modal-content">
                      <div class="modal-header fondo-sigma">
                        <h5 class="modal-title" id="generarSolRepuestosLabel">Detalle Asiento Contable</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" name="idHojaTrabajo" value="">
                          <fieldset id="seccionForm">
                            <div>
                              <table id="tableSolRepuesto" class="table-bordered w-100">
                                <thead>
                                  <th scope="col">#CUENTA</th>
                                  <th scope="col">DEBE</th>
                                  <th scope="col">HABER</th>
                                </thead>
                                <tbody id="tbodySolRepuesto">
                                <tr>
                                    <td>    408101    </td>
                                    <td>   118   </td>
                                    <td></td>
                                    
                                  <tr>
                                    <td>    201010   </td>
                                    <td>         </td>
                                    <td>   100   </td>
                                    
                                  </tr>
                                  <tr>
                                    <td>    201013   </td>
                                    <td>         </td>
                                    <td>    18   </td>
                                    
                                  </tr>
                                  <tr>
                                    <th>  TOTAL  </th>
                                    <th>   118   </th>
                                    <th>   118   </th>
                                    
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </fieldset>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div>
</div>

@endsection