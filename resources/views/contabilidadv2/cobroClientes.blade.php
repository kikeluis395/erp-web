@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Cobro a Clientes') 

@section('content')

<div style="background: white;padding: 10px">
  <h2 class="ml-3 mt-3 mb-4">Cobro a Clientes - Contabilidad</h2>
  <div class="col-12 mt-2 mt-sm-0">
 </div>

 <div class="row justify-content-start mt-2 ml-4">
      <div class="circ-semaforo-popover" style="background-color: green"></div><span class="semf-pop-info">&gt 10 días</span>
      <div class="circ-semaforo-popover ml-3" style="background-color: yellow"></div><span class="semf-pop-info">&gt 2 días</span>
      <div class="circ-semaforo-popover ml-3" style="background-color: red;"></div><span class="semf-pop-info" > < 2 días</span>
    </div>
  </div>

 <div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12 justify-content-between">
            <div class="form-inline row">
                <h2>Cobros Pendientes</h2>
            
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
              <th scope="col">#</th>
              <th scope="col">#FACTURA</th>
              <th scope="col">NOMBRE</th>
              <th scope="col">RUC/DNI</th>
              <th scope="col">FECHA</th>
              <th scope="col">MONTO (SIN IGV)</th>
              <th scope="col">MARCAR</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row"><div class="circulo-semaforo" style="background-color: red; color: white;">1</div></th>
              <td >65432198</td>
              <td>Renzo</td>
              <td>70007275</td>
              <td>03/01/21</td>
              <td>S/. 1,000</td>
              <td><input type="checkbox" id="cbox1" value="first_checkbox"></td>
            </tr>
            <tr>
              <th scope="row"><div class="circulo-semaforo" style="background-color: yellow;">2</div></th>
              <td >65415654</td>
              <td>Renzo</td>
              <td>70007275</td>
              <td>10/01/21</td>
              <td>S/. 2,000</td>
              <td><input type="checkbox" id="cbox2" value="second_checkbox"></td>
            </tr>
            <tr>
            <tr>
              <th scope="row"><div class="circulo-semaforo" style="background-color: green;">3</div></th>
              <td >65437891</td>
              <td>Renzo</td>
              <td>70007275</td>
              <td>10/01/21</td>
              <td>S/. 2,000</td>
              <td><input type="checkbox" id="cbox2" value="third_checkbox"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div>
</div>

<div class="col-sm-12 p-0">
    <div class="row justify-content-end m-0">
        <button data-toggle="modal" data-target="#modalEscogerCuenta" data-backdrop="static" style=" margin-left:15px" class="btn btn-warning mr-3">Siguiente</button>
            <div class="modal fade" id="modalEscogerCuenta" tabindex="-1" role="dialog" aria-labelledby="confirmarInicioOperativo" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header fondo-sigma">
                            <h5 class="modal-title" id="confirmarInicioOperativo">Escoger Cuenta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                            <form id="FormInicioOperativo" method="GET"  value="Submit" autocomplete="off">
                                @csrf
                                <input type="hidden" name="tipoSubmit" value="inicioOperativo">
                                <input type="hidden" name="idRecepcionOT" value="">
                                <div class="form-group form-inline">
                                    <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Banco: </label>
                                    <select name="empleadoMec" class="col-sm-9 justify-content-end form-control" id="empleadoMecIn_">
                                        <option value="BCP">BCP</option>
                                        <option value="IBK">IBK</option>
                                        <option value="BBVA">BBVA</option>
                                    </select>
                                    <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                    </div>

                                    <div class="form-group form-inline">
                                    <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Cuenta: </label>
                                    <select name="empleadoMec" class="col-sm-9 justify-content-end form-control" id="empleadoMecIn_">
                                        <option value="654897325641">654897325641</option>
                                        <option value="654897325987">654897325987</option>
                                    </select>
                                    <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                    </div>

                                    <div class="form-group form-inline">
                                    <label for="empleadoMecIn" class="col-sm-3 justify-content-end">Operación: </label>
                                    <select name="empleadoMec" class="col-sm-9 justify-content-end form-control" id="empleadoMecIn_">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                    <div id="errorEmpleadoMec" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button id="btnSubmit-" form="FormInicioOperativo-" value="Submit" type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection