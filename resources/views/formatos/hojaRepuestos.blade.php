<style>
    *{
        border-width:0.5px;
        font-family: 'sans-serif';
        font-size: 14px;
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
<div><img src="{{asset('assets/images/logo_planeta.jpg')}}" style="height: 28px;"></div>

<h3 align="center">PEDIDO DE REPUESTO N° {{$infoGeneral->nro_necesidad}}</h3>

<table style="width: 100%;">
    <tr>
        <td>OT</td>    <td>: {{$infoGeneral->nro_ot}}</td>        <td>Sucursal</td>      <td>: {{$infoGeneral->sucursal}}</td>
    </tr>
    <tr>
        <td>Placa</td>   <td>: {{$infoGeneral->placa}}</td>       <td>Asesor Repuestos</td>        <td>: {{$infoGeneral->usuario}}</td>
    </tr>
    <tr>
        <td>Marca</td>   <td>: {{$infoGeneral->marca}}</td>       <td>Asesor de Servicios</td>      <td>: {{$infoGeneral->asesor}}</td>
    </tr>
    <tr>
        <td>Modelo</td>   <td>: {{$infoGeneral->modelo}}</td>       <td>Fecha P.R</td>      <td>: {{$infoGeneral->fecha_pr}}</td>
    </tr>
    <tr>
        <td>Cliente</td>   <td>: {{$infoGeneral->cliente}}</td>    <td>Fecha de Impresion</td>   <td>: {{$infoGeneral->fecha_impresion}}</td>
    </tr>
    <tr>
        <td>Entregado a</td>   <td>: {{$infoGeneral->entregado_a}}</td>    
    </tr>
</table>

<table class="all-bordered" style="width: 100%; margin-top: 20px">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Ubicación</th>
            <th>Stock</th>
            <th>P. Total</th>
            <th>F. Entrega</th>
            {{-- <th>Entregado a</th> --}}
            
            
            
        </tr>
    </thead>
    <tbody>
        @foreach($itemsNecesidadRepuestos as $itemNecesidadRepuestos)
        <tr>
            <td>{{$itemNecesidadRepuestos->getRepuestoNroParte()}}</td>
            <td>{{$itemNecesidadRepuestos->getDescripcionRepuestoTexto()}}</td>
            <td>{{$itemNecesidadRepuestos->getCantidadAprobada()}}</td>
            <td>{{$itemNecesidadRepuestos->repuesto->ubicacion}}</td>
            <td>{{$itemNecesidadRepuestos->stock}}</td>
            <td>{{number_format($itemNecesidadRepuestos->getMontoVentaTotal($itemNecesidadRepuestos->getFechaRegistroCarbon(),false),2)}}</td>
            <td>{{$itemNecesidadRepuestos->fecha_registro_entrega}}</td>
            {{-- <td>{{$itemNecesidadRepuestos->entregado_a}}</td> --}}
   
        </tr>
        @endforeach
    </tbody>
</table>