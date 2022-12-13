<style>
   * {
      border-width: 0.5px;
      font-family: 'sans-serif';
      font-size: 12.5px;
   }

   .all-bordered {
      border-spacing: 0;
      border-collapse: collapse;
   }

   .all-bordered td {
      border: solid;
   }

   .all-bordered th {
      border: solid;
   }
</style>
<div style="width: 50%"><img src="{{asset('assets/images/logo_planeta.jpg')}}" style="height: 28px;"></div>
<h3 align="center">ORDEN DE COMPRA # {{$orden_compra->id_orden_compra}}</h3>


<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
   <tr>
      <td style="border:solid; width: 59%;">
         <table style="width: 100%;">
            <tr>
               <th align="left">1222 PERU S.A.C.</th>
            </tr>
            <tr>
               <th align="left">{{$orden_compra->getNombreLocal()}}</th>
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
               <th align="left">Fecha de Emisión: {{\Carbon\Carbon::parse($orden_compra->fecha_registro)->format('d/m/Y')}}</th>
            </tr>
            <tr>
               <th align="left">Fecha de Aprobación: {{\Carbon\Carbon::now()->format('d/m/Y')}}</th>
            </tr>
            <tr>
               <th align="left">Emisor: {{$nombreUsuario}}</th>
               {{-- <th align="left">DEPAA: {{ $orden_compra->proveedor->ubigeoEjemplo->departamento }}</th> --}}
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
         <td><strong>N° Documento: {{$orden_compra->lineasCompra->first()->doc_cliente}}</strong></td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Transfiriente: {{$orden_compra->getNombreTransfiriente()}}</strong></td>
      </tr>
    
      <tr>
         <td><strong>Dirección: {{$orden_compra->getDireccionTransfiriente()}} </strong></td>
         
      </tr>
      <tr>
         <td><strong>Telefono: {{$orden_compra->getTelefonoTransfiriente()}}</strong></td>
         <td><strong>Correo: {{$orden_compra->getCorreoTransfiriente()}}</strong></td>
      </tr>
   </table>
</div>

<div style="width: 100%; border-style: solid; margin-bottom: 10px">
   <table class="" style="width: 100%; padding: 4px;">
      
      <tr>
         <td style="width: 33%"><strong>Almacen: {{$orden_compra->almacen->valor1}}</strong></td>
         <td style="width: 33%"><strong>Motivo: {{$orden_compra->motivo->valor1}}</strong></td>
         <td style="width: 33%"><strong>Dellate del Motivo: {{$orden_compra->detalle_motivo}}</strong></td>
      </tr>
      <tr>
         <td style="width: 33%"><strong>Observaciones: {{$orden_compra->observaciones}}</strong></td>
      </tr>

   </table>


</div>


<table style="width: 100%; border-style: solid; margin-bottom: 10px">
    

   <tr>
       <th align="left">Placa</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->placa }}</td>
       <th align="left">Color</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->color }}</td>
   </tr>
   <tr>
       <th align="left">VIN</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->vin }}</td>
       <th align="left">Año fabricación</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->anho_fabricacion }}</td>
   </tr>
   <tr>
       <th align="left">Motor</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->motor }}</td>
       <th align="left">Año modelo</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->anho_modelo }}</td>
   </tr>
   <tr>
       <th align="left">Marca</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->modeloAutoSeminuevo->marca->nombre }}</td>
       <th align="left">Combustible</th>
       <td align="left">{{$orden_compra->vehiculoSeminuevo()->combustible }}</td>
   </tr>
   <tr>
       <th align="left">Modelo</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->modeloAutoSeminuevo->nombre }}</td>
       <th align="left">Cilindrada</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->cilindrada }}</td>
   </tr>
   <tr>
       <th align="left">Versión</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->version }}</td>
       <th align="left">Transmisión:</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->transmision }}</td>
   </tr>
   <tr>
       <th align="left">Kilometraje</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->kilometraje }}</td>
       <th align="left">Tracción</th>
       <td align="left">{{ $orden_compra->vehiculoSeminuevo()->traccion }}</td>
   </tr>



</table>



<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
   <div style="width: 40%; border-style: solid; margin-bottom: 10px; margin-left: auto">
      <table style="width: 100%">       
         <tr>
            <td>UNIDAD VALORIZADA EN: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
            {{-- <td style="text-align: right; padding-right: 5px">{{number_format($total,2)}}</td> --}}
            <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('total'),2)}}</td>

         </tr>
      </table>
   </div>
</table>


<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
   <div style=" margin-bottom: 10px; margin-left: auto">
      <table style="width: 100%">       
         <tr>
            <td>  <h5 style="text-decoration: overline;">VB  {{$orden_compra->usuarioRegistro->empleado->nombreCompleto()}}</h5></td>
            <td>  <h5 style="text-decoration: overline;">VB  {{$orden_compra->usuarioAprobador->empleado->nombreCompleto()}}</h5></td>

         </tr>
         
      </table>
   </div>
</table>

<br>
<br>
<br>
<br>
<br>
<div>
   <strong>Condiciones</strong>
   <ul>
      <li>Por el presente documento se aprueba el valor de tasación sujeto a revisión técnica.</li>
      <li>El actual propietario se compromete a cancelar cualquier afectación que hubiese sobre la placa con respecto a: papeletas Lima, papeletas Callao, impuestos vehiculares, garantías mobiliarias órdenes de captura u omisión de declaración ante el SAT que imposibilite su correcta transferencia.</li>
      <li>o	El SOAT de la unidad no deberá tener más de 10 meses de antigüedad.</li>
   </ul>
</div>
   




