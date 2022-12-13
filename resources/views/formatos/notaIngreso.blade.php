<style>
    *{
        border-width:0.5px;
        font-family: 'sans-serif';
        font-size: 12.5px;
    }
    .all-bordered{
        border-spacing: 0;
        border-collapse: collapse;
    }

    .all-bordered td{
        border: solid;
    }

    .all-bordered th{
        border: solid;
    }
</style>
<div><img src="{{asset('assets/images/logo_planeta.jpg')}}" style="height: 28px;"/></div>

<h3 align="center">NOTA DE INGRESO N° {{$nota_ingreso->id_nota_ingreso}}</h3>

<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
    <tr>
       <td style="border:solid; width: 59%;">
          <table style="width: 100%;">
             <tr>
                <th align="left">1222 PERU S.A.C.</th>
             </tr>
             <tr>
                <th align="left">{{'Los olivos'}}</th>
             </tr>
             <tr>
                <th align="left">Dir. Entrega: Los Olivos Alfredo Mendiola 5500</th>
             </tr>
          </table>
       </td>
       <td style="width: 2%;">
 
       </td>
 
 
       <td style="border:solid; width: 39%">
          <table style="width: 100%;">
             <tr>
                <th align="left">Fecha de Emisión: {{\Carbon\Carbon::parse($nota_ingreso->fecha_registro)->format('d/m/Y')}}</td>  </th>
             </tr>
             <tr>
                <th align="left">Fecha de Impresión: {{\Carbon\Carbon::now()->format('d/m/Y')}}</th>
             </tr>
             <tr>
                <th align="left">Emisor: {{$nota_ingreso->getNombreUsuarioRegistro()}}</th>
                
             </tr>
          </table>
       </td>
    </tr>
    <tr>
 
    </tr>
 </table>


 <div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class="" style="width: 100%; padding: 4px;">
        <tr>
            <th>Proveedor:</th>        <td>{{$nota_ingreso->obtenerNombreProveedorRelacionado()}}</td> <td>RUC:</td>   <td>{{$nota_ingreso->obtenerRUCProveedorRelacionado()}}</td>       
        </tr>
        
        <tr>
            <th>Dirección:</th>      <td colspan="2">{{$nota_ingreso->getProveedorProveedorRelacionado()->direccion}}</td>     
        </tr>
            
        <tr>
            <th>#OC:</th>      
            <td>{{$nota_ingreso->obtenerOrdenCompraRelacionada()}}</td> 
            <td>Guía de Remisión:</td>   
            <td>{{$nota_ingreso->guia_remision}}</td> 
            <td>Almacen:</td>   
            <td>{{$nota_ingreso->getAlmacen()}}</td> 
        </tr>

 
        
        <tr>
            <td>Observaciones:</td>   
            <td>{{$nota_ingreso->observaciones}}</td> 
        </tr>
    </table>
 </div>




<h4>Detalle Nota de Ingreso</h4>
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class="" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col" style="width: 6%;">#</th>
                <th scope="col" style="width: 16%;">CODIGO</th>
                <th scope="col" style="width: 30%;">DESCRIPCION</th>
                
                <th scope="col" style="width: 10%;">CANTIDAD</th>
                <th scope="col" style="width: 13%;">C. UNITARIO</th>
                <th scope="col" style="width: 13%;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
        @foreach( $lineas_nota_ingreso as $lineas_nota_ingreso)
        <tr>
            <th >{{$loop->iteration}}</th>
            <td style="text-align: center;">{{$lineas_nota_ingreso->lineaOrdenCompra->getCodigoRepuesto()}}</td>
            <td style="text-align: center;">{{$lineas_nota_ingreso->lineaOrdenCompra->getDescripcionRepuesto()}}</td>
            <td style="text-align: right; padding-right: 5px">{{$lineas_nota_ingreso->cantidad_ingresada}}</td>
            <td style="text-align: right; padding-right: 5px">{{$lineas_nota_ingreso->lineaOrdenCompra->precio}}</td>
            <td style="text-align: right; padding-right: 5px">{{number_format($lineas_nota_ingreso->obtenerTotal(),2)}}</td>
        </tr>
        @endforeach
            <tr><td style="height: 200px">&nbsp;</td></tr>
        </tbody>
    </table>

    
</div>


<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
    <div style="width: 40%; border-style: solid; margin-bottom: 10px; margin-left: auto">
       <table style="width: 100%">
          <tr>
             <td>VALOR VENTA: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
             <td style="text-align: right; padding-right: 5px">{{number_format($nota_ingreso->getCostoTotal(),2)}}</td>
          </tr>
          <tr>
             <td>IGV: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
             {{-- <td style="text-align: right; padding-right: 5px">{{number_format($montoIGV,2)}}</td> --}}
             <td style="text-align: right; padding-right: 5px">{{number_format($nota_ingreso->getCostoTotal()*0.18,2)}}</td>
 
          </tr>
          <tr>
             <td>PRECIO VENTA: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
             {{-- <td style="text-align: right; padding-right: 5px">{{number_format($total,2)}}</td> --}}
             <td style="text-align: right; padding-right: 5px">{{number_format($nota_ingreso->getCostoTotal()*1.18,2)}}</td>
 
          </tr>
       </table>
    </div>
 </table>