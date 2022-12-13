<div><img src="{{asset('assets/images/logo_planeta.jpg')}}" style="height: 28px;"></div>

<h3 align="center">ORDEN DE SALIDA #{{$id_entregado_reparacion}}</h3>

<div style="width: 100%; ">
    <table class="" style="width: 100%; padding: 4px;">
        <tr style="margin-bottom: 2px;">
            <td style="width: 55%; font-size:10.5px;"><strong style="font-size:10px;">FECHA: </strong> {{\Carbon\Carbon::now()->format('d/m/Y')}}</td>    <td style="width: 45%; font-size:10.5px;"><strong style="font-size:10px;">OT: </strong>{{$recepcion_ot->id_recepcion_ot}}</td>  
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">DOC. CLIENTE: </strong>{{$hoja_trabajo->doc_cliente}}</td>    <td style="font-size:10.5px;"><strong style="font-size:10px;">TIPO OT: </strong>{{$recepcion_ot->getNombreTipoOT()}}</td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">CLIENTE: </strong>{{$hoja_trabajo->getNombreCliente()}}</td> <td style="font-size:10.5px;"><strong style="font-size:10px;">VIN: </strong>{{$vehiculo->vin}}</td>
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">FACTURA: </strong>{{$recepcion_ot->entregas->first()->nro_factura}}</td>    <td style="font-size:10.5px;"><strong style="font-size:10px;">MOTOR: </strong>{{$vehiculo->motor}}</td>  
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">PLACA: </strong>{{$vehiculo->placa}}</td>       <td style="font-size:10.5px;"><strong style="font-size:10px;">KILOMETRAJE: </strong>{{$recepcion_ot->kilometraje}}</td>    
        </tr>
        <tr style="margin-bottom: 2px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">MARCA: </strong>{{$vehiculo->getNombreMarca()}}</td> <td style="font-size:10.5px;"><strong style="font-size:10px;">COLOR: </strong>{{$vehiculo->color}}</td> 
        </tr>
        <tr style="margin-bottom: 20px;">
            <td style="font-size:10.5px;"><strong style="font-size:10px;">MODELO: </strong>{{$vehiculo->modelo}}</td><td style="font-size:10.5px;"><strong style="font-size:10px;">HORA SALIDA: </strong>{{\Carbon\Carbon::now()->format('H:i:s')}}</td>   
        </tr>
    </table>
</div>
<p style="font-size:10.5px">OBSERVACIONES: {{ $recepcion_ot->entregas->first()->observaciones }}</p>