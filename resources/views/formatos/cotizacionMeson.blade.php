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
<h3 align="center">COTIZACIÓN DE REPUESTOS N° {{$cotizacion->id_cotizacion_meson}}</h3>

<h4>Datos Cliente</h4>

<table style="width: 100%;">
    <tr>
        <td style="width: 25%;">N° DOCUMENTO:</td>        
        <td>{{$cotizacion->getNumDoc()}}</td>

        <td>Fecha Creación Cotización:</td> 
        <td>{{\Carbon\Carbon::parse($cotizacion->fecha_registro)->format('d/m/Y')}}</td>
        
    </tr>

    <tr>

        <td style="width: 25%;">Cliente:</td>    
        <td style="width: 25%;">{{$cotizacion->getNombreCliente()}}</td> 

        <td style="width: 25%;">Asesor de repuestos:</td>    
        <td style="width: 25%;">{{$cotizacion->getNombrevendedor()}}</td> 
   
    </tr>

    <tr>
        <td>Teléfono:</td>      
        <td>{{$cotizacion->getTelefonoCliente()}}</td>

        <td>Teléfono:</td>      
        <td>{{$cotizacion->cliente->celular}}</td>

    </tr>

    <tr>
       
        <td>Correo:</td>   
        <td>{{$cotizacion->getCorreoCliente()}}</td>

        <td>Correo:</td>   
        <td>{{$cotizacion->cliente->email}}</td>
    </tr>
  
    <tr>
        <td>Dirección:</td>   
        <td>@if($cotizacion->cliente){{$cotizacion->cliente->getDireccionCliente()}} @endif</td> 
        
        <td>Distrito/Prov./Dep.:</td>      
        <td>@if($cotizacion->cliente && $cotizacion->cliente->ubigeo){{$cotizacion->cliente->getDistritoText()}}/{{$cotizacion->cliente->getProvinciaText()}}/{{$cotizacion->cliente->getDepartamentoText()}} @endif</td>
    
    </tr>

    <tr>
        <td>Observaciones</td>      
        <td>{{$cotizacion->observaciones}}</td> 
    </tr>

</table>

<h4>Detalle Cotización</h4>
<div style="width: 100%; border-style: solid; margin-bottom: 10px; ">
    <table class="" style="width: 100%;">
        <thead>
            <tr>
                <th style="font-size: 13px;">N°</th>
                @if($showCode)
                <th style="font-size: 13px;">Código</th>
                @endif
                <th style="font-size: 13px;">Descripción</th>
                <th style="font-size: 13px;">Disponibilidad</th>
                <th style="font-size: 13px;">Ubicacion</th>
                <th style="font-size: 13px;">Cantidad</th>
                <th style="font-size: 13px;">P. Unit.</th>
                <th style="font-size: 13px;">P. Regular.</th>
                <th style="font-size: 13px;">Descuento</th>
                <th style="font-size: 13px;">P. Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lineasCotizacion as $lineaCotizacion)
            <tr>
                <td style="text-align: center; font-size: 12px;">{{$loop->iteration}}</td>
                @if($showCode)
                <td style="font-size: 12px;">{{$lineaCotizacion->getCodigoRepuesto()}}</td>
                @endif
                <td style="font-size: 12px;">{{$lineaCotizacion->getDescripcionRepuesto()}}</td>
                <td style="text-align: center; font-size: 12px;">{{$lineaCotizacion->getDisponibilidadNotaVenta()}}</td>
                
                <td style="text-align: center; font-size: 12px;">{{$lineaCotizacion->getUbicacionRepuesto()}}</td>
                <td style="text-align: center; font-size: 12px;">{{$lineaCotizacion->getCantidadGrupo()}}</td>
                <td style="text-align: center;  font-size: 12px;">{{number_format($lineaCotizacion->getMontoUnitarioGrupo($lineaCotizacion->getFechaRegistroCarbon(),true), 2)}}</td>
                <td style="text-align: center;  font-size: 12px;">{{number_format($lineaCotizacion->getMontoTotal($lineaCotizacion->getFechaRegistroCarbon(),true), 2)}}</td>
                
                <td style="text-align: center;  font-size: 12px;">{{number_format(($lineaCotizacion->getApplicableDiscount())*$lineaCotizacion->getCantidadGrupo(), 2)}}</td>
                <td style="text-align: center;  padding-right: 5px; font-size: 12px;">{{number_format($lineaCotizacion->getTotalWithDiscount(), 2)}}</td>
            </tr>
            @endforeach
            <tr><td style="height: 200px">&nbsp;</td></tr>
        </tbody>
    </table>

   
    <table style="width: 100%;">
        <tr>
            <td style="width: 75%">&nbsp;</td>
            <td>Subtotal {{$simboloMoneda}}:</td>  <td style="text-align: right; padding-right: 5px">{{ round( ($cotizacion->getValueDiscountedQuote2Approved()/1.18), 2)}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>I.G.V {{$simboloMoneda}}:</td>     <td style="text-align: right; padding-right: 5px">{{ round( ($cotizacion->getValueDiscountedQuote2Approved()/1.18*0.18), 2)}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Total {{$simboloMoneda}}:</td>     <td style="text-align: right; padding-right: 5px">{{round($cotizacion->getValueDiscountedQuote2Approved(), 2)}}</td>
    </table>

    <h5>La validez de la cotización es hasta el día {{ $cotizacion->fecha_registro->addDays(7)->format('d/m/Y') }}</h5>
    <img src="{{asset('assets/images/glosa_bancos.png')}}" style="width: 100%;">
</div>


