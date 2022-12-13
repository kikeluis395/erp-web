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
<h3 align="center">ORDEN DE SERVICIO # {{$orden_servicio->id_orden_servicio}}</h3>

<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
        <tr>
            <td style="border:solid; width: 59%;">
                <table style="width: 100%;">
                    <tr>
                        <th align="left">Planeta Motors S.A.</th>
                    </tr>
                    <tr>
                        <th align="left">Centro: POSVENTA</th>
                    </tr>
                    <tr>
                        <th align="left">Dirección: Los Olivos Alfredo Mendiola 5500</th>
                    </tr>
                </table>
            </td>
            <td style="width: 2%;">

            </td>


            <td style="border:solid; width: 39%">
                <table style="width: 100%;">
                    <tr>
                        <th align="left" >Fecha de Emisión: {{\Carbon\Carbon::now()->format('d/m/Y')}}</th>
                    </tr>
                    <tr>
                        <th align="left">Emisor: {{$nombreUsuario}}</th>
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
            <td style="width: 50%"><strong>Sres. {{$proveedor->nombre_proveedor}}</strong></td>    <td style="width: 50%"><strong>Contacto: {{$proveedor->contacto}}</strong></td>  
        </tr>
        <tr>
            <td><strong>RUC: {{$proveedor->num_doc}}</strong></td> 
        </tr>
        <tr>
            <td><strong>Dirección: {{$proveedor->direccion}} </strong></td>      <td><strong>Telef: {{$proveedor->telf_contacto}}</strong></td>   
        </tr>
        <tr>
            <td><strong>Código Proveedor: {{$proveedor->id_proveedor}}</strong></td>      <td><strong>Mail: {{$proveedor->email_contacto}}</strong></td>   
        </tr>
    </table>
</div>

<div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class="" style="width: 100%; padding: 4px;">
        <tr>
            <td style="width: 33%"><strong>Condición: {{$orden_servicio->condicion_pago}}</strong></td>    
            <td style="width: 33%"><strong>Moneda: {{$orden_servicio->moneda}}</strong></td>  
            <td style="width: 34%"><strong>Montos sin IGV</strong></td>  
        </tr>
        <tr>
            <td style="width: 50%"><strong>#OT: {{$id_recepcion_ot}}</strong></td>    
            <td style="width: 50%"><strong>#Placa: {{$placa}}</strong></td>  
        </tr>
        <tr>
            <table style="width: 100%; padding: 4px">
                <tr>
                    <td><strong>Observación: {{$orden_servicio->observaciones}}</strong></td>    
                </tr>
            </table>
        </tr>
    </table>

    
</div>
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
<table class="" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col" style="width: 6%;">#</th>
                <th scope="col" style="width: 16%;">CODIGO</th>
                <th scope="col" style="width: 44%;">DESCRIPCION</th>
                <th scope="col" style="width: 44%;">COSTO</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $lineasOrdenesServicio as $lineaOrdenServicio)
            <tr>
                <th scope="row\">{{$loop->iteration}}</th>
                <td style="text-align: center;">{{$lineaOrdenServicio->getCodigoServicioTercero()}}</td>
                <td style="text-align: center;">{{$lineaOrdenServicio->getDescripcionServicio()}}</td>
                <td style="text-align: center;">{{number_format($lineaOrdenServicio->getCosto($moneda),2)}}</td>
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
                    <td>VALOR VENTA: </td>     <td style="text-align: right; padding-right: 5px">{{number_format($orden_servicio->getCostoTotal($moneda),2)}}</td>
                </tr>
                <tr>
                    <td>IGV: </td>     <td style="text-align: right; padding-right: 5px">{{number_format($orden_servicio->getMontoIGV($moneda),2)}}</td>
                </tr>
                <tr>
                    <td>PRECIO VENTA: </td>     <td style="text-align: right; padding-right: 5px">{{number_format($orden_servicio->getPrecioTotal($moneda),2)}}</td>
                </tr>
        </table>
    </div>
</table>