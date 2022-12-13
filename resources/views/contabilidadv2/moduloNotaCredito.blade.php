@extends('contabilidadv2.layoutCont')
@section('titulo','Módulo Nota de Credito') 

@section('content')

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row justify-content-between col-12">
        <h2 class="ml-3 mt-3 mb-0">Módulo Nota de Crédito</h2>
        <div class="justify-content-end">
            <a href="{{url()->previous()}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
        </div>
    </div>
    <p class="ml-3 mt-3 mb-4">Ingrese los datos para continuar con la nota de credito</p>
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">Generar Nota de crédito</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="formGenerarFactura" method="GET" action="" role="form" value="Submit2" autocomplete="off">
                            <div class="row">

                                <div class="form-group row ml-sm-0 col-sm-3">     
                                    <div class="col-12">
                                        <input id="empresa" name="empresa" class="form-control w-100" type="text" value="PLANETA NISSAN" disabled>
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">     
                                    <div class="col-12">
                                        <input id="sucursal" name="sucursal" class="form-control w-100" type="text" value="{{$local}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">     
                                    <div class="col-12">
                                        <input id="cajera" name="cajera" class="form-control w-100" type="text" value="{{$usuario}}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row ml-sm-0 col-sm-3">
                                    <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="fechaEmision">Fecha Emision: </label>
                                    <div class="col-sm-8">
                                        <input id="fechaEmision" name="fechaEmision" class="form-control w-100" type="text" value="{{$fecha_emision}}" readonly>
                                    </div>
                                </div>
                                
                                <div class="card mb-4 ml-3 mr-3" style="width: 100%;">
                                    <div class="card-body">
                                       <h5 class="card-title">Datos de la Nota de CREDITO/DEBITO</h5>
                                        <div class="row">
            
                                            <div class="form-group col-3 mb-4">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="oCRelacionada" id="labelDocumentoSol">DOCUMENTO DE REFERENCIA: </label>
                                                <div class="row ml-1">
                                                    
                                                    <select name="selectDocumentoReferencia" id="selectDocumentoReferencia" class="form-control col-3">
                                                        <option value="F">Factura</option>
                                                        <option value="B">Boleta</option>
                                                    </select>
                                                    <select name="numSerieRef" id="numSerieRef" class="form-control col-3">
                                                        <option value="001">001</option>
                                                        <option value="002">002</option>
                                                        <option value="003">003</option>
                                                        <option value="004">004</option>
                                                        <option value="005">005</option>
                                                    </select>
                                                    
                                                    
                                                    <input placeholder="Num doc" autocomplete="off" id="numDocRef" name="numDocRef" class="form-control col-3 ml-1" type="text" >
                                                    <a class ="col-1"><button id="btnBuscarDataNC" type="button" class="btn btn-info"><i class="fas fa-search"></i></button></a>
                                                    <div id="hintCliente" class="col-12 text-left no-gutters pr-0"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row col-3 ">
                                                <label class="col-12 " for="tipoOperacion">TIPO DE OPERACIÓN: </label>
                                                <input id="tipoOperacion" name="tipoOperacion" class="form-control col-10" type="text" value="Venta" disabled>
                                            </div>
            
                                            <div class="form-group row ml-sm-0 col-3 ">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="tipoVenta">TIPO DE VENTA: </label>
                                                <input   id="tipoVenta" name="tipoVenta" class="form-control col-12" type="text" value="Servicio Taller" disabled>
                                            </div>
            
            
                                            
                                            <div class="form-group row ml-sm-0 col-sm-3">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="monedaSol">MONEDA: </label>
                                                <div class="col-12">
                                                    <input id="moneda" name="moneda" class="form-control w-100" type="text" value="PEN" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row ml-sm-0 col-sm-3">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="tipoCambio">TIPO DE CAMBIO: </label>
                                                <div class="col-12">
                                                    <input id="tipoCambio" name="tipoCambio" class="form-control w-100" type="text" value="3.84" readonly>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group row ml-sm-0 col-sm-3">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="motivoSol">MOTIVO DE EMISIÓN:</label>
                                                <div class="col-12">
                                                    <select name="reason" id="reason" class="form-control w-100" size="0" @if(isset($motivo)) disabled @endif>
                                                        <option value="01">Motivo 01: Anulación de la operación</option>
                                                        <option value="04">Motivo 04: Descuento global</option>
                                                        <option value="05">Motivo 05: Descuento por ítem</option>
                                                        <option value="06">Motivo 06: Devolución total</option>
                                                        <option value="07">Motivo 07: Devolución por item</option>
                                                        <option value="08">Motivo 08: Bonificación</option>
                                                        <option value="09">Motivo 09: Disminución en el valor</option>
                                                    </select>
                                                </div>
                                            </div>
            
                                            
                                            <div class="form-group col-3 mb-4">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="oCRelacionada" id="labelDocumentoSol">DOCUMENTO A EMITIR: </label>
                                                <div class="row ml-3">
                                                    <select name="selectTipoDocumento" id="selectTipoDocumento" class="form-control col-4">
                                                        
                                                        <option value="NC">NC</option>
                                                        <option value="ND">ND</option>
                                                    </select>
                                                    <input placeholder="Num serie" autocomplete="off" id="numSerie" name="numSerie" class="form-control col-3 ml-1" type="text" readonly>
                                                    <input placeholder="Num doc"  autocomplete="off" id="numDoc" name="numDoc" class="form-control col-3 ml-1" type="text" disabled>
            
                                                </div>
                                            </div>

                                            <div class="form-group row ml-sm-0 col-sm-3">
                                                <label class="col-12 col-form-label form-control-label justify-content-end" for="estadoSol">Estado: </label>
                                                <div class="col-12">
                                                    <input id="estadoSol" name="estadoSol" class="form-control w-100" type="text" value="-" disabled>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>                              
                            </div>


                            <div class="card mb-4" style="width: 100%;">
                                <div class="card-body">
                                   <h5 class="card-title">Datos del Cliente</h5>
                                    <div class="row">

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="docCliente">Doc Cliente: </label>
                                                <div class="col-sm-8">
                                                    <input id="docCliente" name="docCliente" class="form-control w-100" type="text"  disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-5">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="nombreCliente">Nombre Cliente: </label>
                                                <div class="col-sm-8">
                                                    <input id="nombreCliente" name="nombreCliente" class="form-control w-100" type="text"  disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="direccionCliente">Dirección Cliente: </label>
                                                <div class="col-sm-8">
                                                    <input id="direccionCliente" name="direccionCliente" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="telefonoCliente">Teléfono Cliente: </label>
                                                <div class="col-sm-8">
                                                    <input id="telefonoCliente" name="telefonoCliente" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="emailCliente">Email Cliente: </label>
                                                <div class="col-sm-8">
                                                    <input id="emailCliente" name="emailCliente" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card" style="width: 100%;" id="card_vehiculo">
                                <div class="card-body">
                                   <h5 class="card-title">Datos del Vehiculo</h5>
                                    <div class="row">

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="docCliente">Placa: </label>
                                                <div class="col-sm-8">
                                                    <input id="placa" name="placa" class="form-control w-100" type="text"  disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="nombreCliente">Marca: </label>
                                                <div class="col-sm-8">
                                                    <input id="marca" name="marca" class="form-control w-100" type="text"  disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="direccionCliente">Modelo: </label>
                                                <div class="col-sm-8">
                                                    <input id="modelo" name="modelo" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="telefonoCliente">Kilometraje: </label>
                                                <div class="col-sm-8">
                                                    <input id="kilometraje" name="kilometraje" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="emailCliente">Vin: </label>
                                                <div class="col-sm-8">
                                                    <input id="vin" name="vin" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="emailCliente">Motor: </label>
                                                <div class="col-sm-8">
                                                    <input id="motor" name="motor" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="emailCliente">Año: </label>
                                                <div class="col-sm-8">
                                                    <input id="ano" name="ano" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group row col-12">
                                                <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="emailCliente">Color: </label>
                                                <div class="col-sm-8">
                                                    <input id="color" name="color" form="formGenerarFactura" class="form-control w-100" type="text" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>


                            <div class="col-3">
                                <div style="display: none" >
                                    <div class="col-sm-8">
                                        <input id="sale_id" name="sale_id" class="form-control w-100" type="text" >
                                    </div>
                                </div>
                                <div style="display: none" >
                                    <div class="col-sm-8">
                                        <input id="id_comprobante_venta" name="id_comprobante_venta" class="form-control w-100" type="text" >
                                    </div>
                                </div>
                                <div style="display: none" >
                                    <div class="col-sm-8">
                                        <input id="id_comprobante_anticipo" name="id_comprobante_anticipo" class="form-control w-100" type="text" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="form-group col-6 ">
                                    <label for="observacionesIn">Observaciones:</label>
                                    <textarea id="observaciones" name="observaciones" type="text" class="form-control col-10 ml-3" id="observacionesIn" placeholder="Ingrese sus observaciones" maxlength="255" rows="3"  autocomplete="off" ></textarea> 
                                  </div>
                            </div>

                            <div style="display: none" >
                                <div class="col-sm-8">
                                    <input id="mycontent" name="mycontent" class="form-control w-100" type="text"  disabled>
                                </div>
                            </div>
                            
                                
                            <div class="row justify-content-end">
                                <!-- @if(!isset($motivo))
                                <button class="btn btn-primary justify-content-end mr-3" form="formGenerarFactura" type="submit" value="Submit2">
                                    Siguiente
                                </button>
                                @endif -->
                               
                              
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <form class="form" id="formRegistrarSol" method="POST" action="{{route('contabilidad.facturacion.store')}}" role="form" value="Submit" autocomplete="off">
        @csrf        
        <div class="table-responsive borde-tabla tableFixHead">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row col-12 justify-content-between">
                        <div>
                            <h2>Detalle</h2>
                        </div>
                    </div>
                </div>                
                <div class="table-cont-single">
                    <table id="tablaDetalleNotaCredito" class="table text-center table-striped table-sm" style="">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 2%;">#</th>
                                <th scope="col" style="width: 8%;">CANTIDAD</th>
                                <th scope="col" style="width: 11%;">CODIGO</th>
                                <th scope="col" style="width: 31%;">DESCRIPCION</th>
                                <th scope="col" style="width: 31%;">C. COSTO</th>
                                <th scope="col" style="width: 31%;">UNIDAD</th>
                                <th scope="col" style="width: 8%;">V. UNIT</th>
                                <th scope="col" style="width: 8%">V. VENTA</th>
                                <th scope="col" style="width: 8%">DESCUENTO</th>
                                <th scope="col" style="width: 8%">SUB TOT.</th>
                                <th scope="col" style="width: 8%;">IMPUESTO</th>
                                <th scope="col" style="width: 8%;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($detalleNotaCreditoDebito))
                            @foreach( $detalleNotaCreditoDebito as $row)
                               
                                <tr>
                                    <th scope="row\">{{$loop->iteration}}</th>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->id}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->cantidad}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->codigo}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->descripcion}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->costo}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->unidad}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->valor_unitario}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->valor_venta}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->descuento}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->sub_total}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->impuesto}} disabled></td>
                                    <td><input style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" class="form-control" value={{$row->total}} disabled></td>
                                        
                                </tr>
                             
                            @endforeach
                        @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm p-3 mt-3">
            
            <div class="row justify-content-between mt-3">
                <div class="form-group col-sm-12 d-none" id="divRebate">
                    <label for="incluirRebate"><input type="checkbox" name="incluirRebate" id="incluirRebate"> Facturar Rebate</label>                    
                </div>
                <div class="form-group col-sm-2">
                    <label for="value_sale">Valor Venta</label>
                    <input type="text" id="value_sale" name="value_sale" class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="descuento_total">Descuento</label>
                    <input type="text" id="total_discont" name="total_discont" class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="subtotalvalorventa_total">Sub Total Valor Venta</label>
                    <input type="text" id="taxable_operations" name="sub_total_valor_venta_total"
                        class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="impuesto_total">Impuesto(18%)</label>
                    <input type="text" id="total_igv" name="impuesto_total" class="form-control" readonly>
                </div>
                <div class="form-group col-sm-2">
                    <label for="total">Total</label>
                    <input type="text" id="total_price" name="total" class="form-control" readonly>
                </div>
            </div>
            <div class="row mt-3 justify-content-end mr-1" id="divSubmit">
                <button class="btn btn-primary justify-content-end mr-3 btn-nota-credito" id="btnSendNCNDSIBI" type="button"  >
                    Generar Nota de credito
                </button>
            </div>
           
        </div>
        
        
    </form>
</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>


</script>
@endsection