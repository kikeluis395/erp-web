@extends('contabilidadv2.layoutCont')
@section('titulo','Modulo de contabilidad - Seguimiento Notas Ingreso') 

@section('content')

<div style="background: white;padding: 10px">
    <h2 class="ml-3 mt-3 mb-4">Seguimiento de Notas de Ingreso - Contabilidad</h2>
    <div id="busquedaCollapsable" class="col-12 collapse borde-tabla" style="background: white;margin-top:10px">
        <form id="FormFiltrarNI" class="my-3" method="GET" action="{{route('contabilidad.seguimientoNotasIngreso')}}" value="search">
            <div class="row">
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroNroNI" class="col-form-label col-12 col-sm-6">Nro. Nota Ingreso:</label>
                    <input id="filtroNroNI" name="nroNI" type="text" class="form-control col-12 col-sm-6" placeholder="Número de Nota de Ingreso">
                </div>
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroNroOC" class="col-form-label col-12 col-sm-6">Nro. OC:</label>
                    <input id="filtroNroOC" name="nroOC" type="text" class="form-control col-12 col-sm-6" placeholder="Número de OC">
                </div>
                <div class="form-group row ml-1 col-6 col-sm-3">
                    <label for="filtroRucProveedor" class="col-form-label col-12 col-sm-6">Proveedor:</label>
                    <input id="filtroRucProveedor" name="rucProveedor" type="text" tipo="proveedores" class="typeahead form-control" placeholder="RUC o nombre del proveedor">
                </div>
                
                <div class="form-group row ml-1 col-12 col-sm-6 col-lg-3">
                    <label for="filtroModalidad" class="col-form-label col-6">Estado:</label>
                    <select name="modalidad" id="filtroModalidad" class="form-control col-6">
                        <option value="">Seleccione un estado</option>
                        <option value="No-Facturados">No Facturados</option>
                        <option value="Facturados">Facturados</option>
                    </select>
                </div>

                <div class="form-group row ml-1 col-6 col-sm-3">
                <label for="filtronroFacturaAsociada" class="col-form-label col-12 col-sm-6">Nro. Factura:</label>
                    <input id="filtronroFacturaAsociada" name="nroFacturaAsociada" type="text" class="form-control col-12 col-sm-6" placeholder="# factura asociada">
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

<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="table-responsive borde-tabla tableFixHead">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row col-12 justify-content-between">
                    <div class="form-inline row">
                        <h2>Notas de Ingreso Registradas</h2>           
                        <button class="btn btn-primary mr-4" type="button" data-toggle="collapse" data-target="#busquedaCollapsable" aria-expanded="false" aria-controls="busquedaCollapsable">
                            Filtrar
                        </button>
                    </div>

                    {{-- <form id="FormCrearNI" class="d-flex justify-content-end" method="GET" action="{{route('reingresoRepuestos.index')}}">
                        <button class="btn btn-primary btn-lg" type="submit" >
                            Crear Nota de Ingreso
                        </button>
                    </form> --}}
                    <a href="{{route('reingresoRepuestos.index')}}" class="btn btn-primary">Crear Nota de Ingreso</a>
                </div>
            </div>
      
            <div class="table-cont-single">
                <table class="table text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#N.INGRESO</th>
                            <th scope="col">#OC</th>
                            <th scope="col">RUC</th>
                            <th scope="col">PROVEEDOR</th>
                            <th scope="col">FECHA DE CREACION</th>
                            <th scope="col">COSTO TOTAL</th>
                            <th scope="col">#FACT</th>
                            <th scope="col">VISUALIZAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notasIngreso as $notaIngreso)
                        <tr> 
                            <th scope="row">
                            <a class='id-link' href= "{{route('contabilidad.visualizarNI',['id_nota_ingreso' => $notaIngreso->id_nota_ingreso])}}" target='_blank'>{{$notaIngreso->id_nota_ingreso}}</a>
                            </th>
                            <td>
                            <a class='id-link' href= "{{route('contabilidad.visualizarOC',['id_orden_compra' => $notaIngreso->obtenerOrdenCompraRelacionada()])}}" target='_blank'> {{$notaIngreso->obtenerOrdenCompraRelacionada()}}</a>
                           
                            </td>
                            <td>{{$notaIngreso->obtenerRUCProveedorRelacionado()}}</td>
                            <td>{{$notaIngreso->obtenerNombreProveedorRelacionado()}}</td>
                            <td>{{\Carbon\Carbon::parse($notaIngreso->fecha_registro)->format('d/m/Y')}}</td>
                            <td>{{App\Helper\Helper::obtenerUnidadMonedaCambiar($notaIngreso->obtenerOrdenCompraObjeto()->tipo_moneda)}} {{number_format($notaIngreso->getCostoTotal(),2)}}</td>
                            <td>{{$notaIngreso->obtenerFactura()}}</td>
                            <td><a href="{{route('contabilidad.visualizarNI',['id_nota_ingreso' => $notaIngreso->id_nota_ingreso])}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit icono-btn-tabla"></i>  </i></button></a></td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection