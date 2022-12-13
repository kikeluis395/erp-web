@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Factura Final') 

@section('content')

<div class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="col-12 mt-2 mt-sm-0">
        <div class="row justify-content-between">
            <h2 class="ml-3 mt-3 mb-4">Ingreso de Factura: {{$nFactura}}</h2>
            <div class="justify-content-end">
                <a style="margin-rigth: 15px;" href="{{route('contabilidad.ingresoFacturasInicial')}}"><button type="button" class="btn btn-info mt-4" style="margin-rigth: 15px;">Regresar</button></a>
            </div>
        </div>
        <div class="row col-12 px-0 my-3">
            <div class="row col-sm-6 col-lg-4">
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">PERIODO: </span> 	<span class="col-6   ">{{$periodo}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right"># DE FACTURA: </span> 	<span class="col-6   ">{{$nFactura}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA DE EMISIÓN: </span> 	<span class="col-6   ">{{$fechaEmision}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA DE VENCIMIENTO: </span> 	<span class="col-6   ">{{$fechaVencimiento}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">RUC PROVEEDOR: </span> 	<span class="col-6   ">{{$RUCProv}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">NOMBRE PROVEEDOR: </span> 	<span class="col-6   ">{{$nombreProv}}</span>
            </div>
            <div class="row col-sm-6 col-lg-4">
            <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MONEDA: </span> 	<span class="col-6   ">{{$moneda}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">GLOSA: </span> 	<span class="col-6   ">{{$glosa}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TIPO DE MOVIMIENTO: </span> 	<span class="col-6   ">{{$tipoMovimiento}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FORMA DE PAGO: </span> 	<span class="col-6   ">{{$formaPago}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CLASIFICACION BIEN/SERVICIO: </span> 	<span class="col-6   ">{{$clasificacion}}</span>
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MODALIDAD SERVICIO: </span> 	<span class="col-6   ">{{$modalidadServicio}}</span>
            </div>
            <div class="row col-sm-6 col-lg-4">
                @if($detraccion)
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">DETRACCION: </span> 	<span class="col-6   ">{{$detraccion}}</span>
                <br>
                @endif
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">REGIMEN: </span> 	<span class="col-6   ">{{$regimen}}</span>
                @if($baseImponible)
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">BASE IMPONIBLE </span> 	<span class="col-6   ">{{$baseImponible}}</span>
                @endif
                @if($impuestos)
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">IMPUESTOS(%): </span> 	<span class="col-6   ">{{$impuestos}}</span>
                @endif
                @if($inafecto)
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">INAFECTO: </span> 	<span class="col-6   ">{{$inafecto}}</span>
                @endif
                <br>
                <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TOTAL PROVISIÓN: </span> 	<span class="col-6   ">{{$totalProvision}}</span>            </div>
        </div>
    </div>
    @if ((session('error_msg')))
    <div class="validation-error-cont">{{session('error_msg')}}</div>
    @endif
</div>
<form class="form" role="form" autocomplete="off" action="{{route('contabilidad.crearFactura')}}" method="POST">
@csrf
<div class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <div class="table-responsive borde-tabla tableFixHead">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row col-12 justify-content-between">
          <div>
            <h2>Notas de Ingreso Relacionadas</h2>
          </div>
          <div class="row justify-content-end">           
          </div>
        </div>
      </div>

      <div class="table-cont-single">
          <table id="tablaNotasIngreso" class="table text-center table-striped table-sm">
            <thead>
              <tr>
                <th scope="col" style="width: 10%;">#OC</th>
                <th scope="col" style="width: 15%;"># Nota de Ingreso</th>
                <th scope="col" style="width: 25%;">Nombre Proveedor</th>
                <th scope="col" style="width: 10%;">Fecha</th>
                <th scope="col" style="width: 15%;">Costo Total(Sin IGV)</th>
                <th scope="col" style="width: 15%;">Detalle</th>
                <th scope="col" style="width: 10%;">Facturar</th>
                <!-- <th id="thEditarDetalleTrabajo" scope="col" style="display:none">EDITAR</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach ($listaNotas as $nota_ingreso)
              <tr>
                <td><label style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"> {{$nota_ingreso->nOrden}}</label></td>
                <td><label style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" > {{$nota_ingreso->idNota}}</label></td>
                <td><label style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" > {{$nota_ingreso->proveedor}}</label></td>
                <td><label style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" > {{$nota_ingreso->fecha}}</label></td>
                <td><label style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" > S/. {{$nota_ingreso->monto}}</label></td>
                <td><a href="{{route('contabilidad.visualizarNI',['id_nota_ingreso' => $nota_ingreso->idNota])}}"><button type="button" class="btn btn-warning"><i class="fas fa-info-circle icono-btn-tabla"></i>  </i></button></a></td>
                <td><input type="checkbox" id="cbox1" name="checkbox_facturar_{{$nota_ingreso->idNota}}" ></td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
    </div>
</div>
    <div class="col-sm-12 p-0 mt-3 mr-3">
      <div class="row justify-content-end m-0">
      <button id="btnVerAsientosContables" type="button" class="btn btn-warning" data-toggle="modal" data-target="#generarAsientosContables" data-backdrop="static">Siguiente</button>
        <!-- Modal -->
        <div class="modal fade" id="generarAsientosContables" tabindex="-1" role="dialog" aria-labelledby="generarAsientosContablesLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header fondo-sigma">
                <h5 class="modal-title" id="generarAsientosContablesLabel">Ingresar Asientos Contables</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <fieldset id="seccionForm">
                    <div>
                      <div class="row justify-content-between" style="padding:0 15px 0 15px">
                        <div>
                          Ingrese las filas que necesite:
                        </div>
                        <div>
                          <button id="btnAddAsiento" type="button" class="btn btn-warning mb-2 mt-0">+</button>
                        </div>
                      </div>
                      <table id="tableAsientos" style="display: none;" class="table-bordered table text-center table-striped table-sm">
                        <thead>
                          <th scope="col">#CUENTA</th>
                          <th scope="col">DEBE</th>
                          <th scope="col">HABER</th>
                          <th scope="col">ELIMINAR</th>
                        </thead>
                        <tbody id="tbodyAsientos" >
                          @if(false)
                          <!-- <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                            <td><button id="btnEliminarLineaSolRepuesto" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>
                          </tr> -->
                          @endif
                          <tr id="trTotalAsientos">
                                <th scope="row\" style="text-align: center;">TOTAL</th>
                                <td><input id="inputTotalDebe" style=" display: block; box-sizing: border-box; margin: auto; font-weigth: bold; width: 100%; height: 60%" class="form-control" value="0.00" disabled></td>
                                <td><input id="inputTotalHaber" style=" display: block; box-sizing: border-box; margin: auto; font-weigth: bold; width: 100%; height: 60%" class="form-control" value="0.00" disabled></td>
                                <td><input id="inputTotalHaber" style=" display: none; box-sizing: border-box; margin: auto; font-weigth: bold; width: 1000%; height: 60%" class="form-control" value="0.00" disabled></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </fieldset>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnGuardarFactura" type="submit" style=" margin-left:15px; margin-right: 10px;" class="btn btn-warning">Finalizar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
@endsection
