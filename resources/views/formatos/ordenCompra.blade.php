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
               <th align="left">Fecha de Impresión: {{\Carbon\Carbon::now()->format('d/m/Y')}}</th>
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
         <td style="width: 50%"><strong>Sres. {{$orden_compra->getNombreProveedor()}}</strong></td>
         <td style="width: 50%"><strong>Contacto: {{$orden_compra->proveedor->contacto}}</strong></td>
      </tr>
      <tr>
         <td><strong>RUC: {{$orden_compra->getRUCProveedor()}}</strong></td>
      </tr>
      <tr>
         <td><strong>Dirección: {{$orden_compra->proveedor->direccion}} / {{ $orden_compra->proveedor->ubigeoEjemplo->departamento }} / {{ $orden_compra->proveedor->ubigeoEjemplo->provincia }} / {{ $orden_compra->proveedor->ubigeoEjemplo->distrito }}</strong></td>
         <td><strong>Telef: {{$orden_compra->proveedor->telf_contacto}}</strong></td>
      </tr>
      <tr>

         <td><strong>Mail: {{$orden_compra->proveedor->email_contacto}}</strong></td>
      </tr>
   </table>
</div>

<div style="width: 100%; border-style: solid; margin-bottom: 10px">
   <table class="" style="width: 100%; padding: 4px;">
      <tr>
         <td style="width: 100%"><strong>Factura Proveedor: {{$orden_compra->factura_proveedor}}</strong></td>
      </tr>
      <tr>
         <td style="width: 33%"><strong>Condición: {{$orden_compra->condicion_pago}}</strong></td>
         <td style="width: 33%"><strong>Moneda: {{$orden_compra->tipo_moneda}}</strong></td>
         <td style="width: 34%"><strong>Montos sin IGV: {{$orden_compra->lineasCompra->sum('sub_total')}}</strong></td>
      </tr>
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


@if (strpos($orden_compra->almacen->valor1, 'VEHICULO'))
<div style="width: 100%; height: 10%; ;border-style: solid">
   <table class="" style="width: 100%;">
      <thead style="border-bottom: solid 1px black">
         <tr>
            <th scope="col" style="width: 10%;">#</th>
            <th scope="col" style="width: 10%;">MODELO COMERCIAL</th>
            <th scope="col" style="width: 14%;">CANTIDAD</th>
            <th scope="col" style="width: 14%;">C. UNIT</th>
            <th scope="col" style="width: 14%;">DSCTO. UNIT</th>
            <th scope="col" style="width: 14%;">C. TOTAL</th>
         </tr>
      </thead>
      <tbody style="padding-top: 5%">
         @foreach( $lineas_compra as $linea_compra)
         <tr>
            <th scope="row\">{{$loop->iteration}}</th>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->vehiculoNuevo->modelo}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format('1',2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->precio,2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->descuento,2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->sub_total,2)}}</td>
         </tr>
         @endforeach
         <tr>
            <td style="height: 200px">&nbsp;</td>
         </tr>
      </tbody>
   </table>
</div>
<div style="width: 100%; border-style: solid;  position: relative; top: 0px">
   <table class="" style="width: 100%; padding: 4px 50px;">
      <tr>
         <td style="width: 50%"><strong>Modelo Comercial:</strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->modelo_comercial}}</td>
         <td style="width: 50%"><strong>Marca:</strong> </td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->marcaAuto->nombre_marca}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Carroceria: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->carroceria}}</td>
         <td style="width: 50%"><strong>Tracción: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->traccion}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Num. Ruedas: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->num_ruedas}}</td>
         <td style="width: 50%"><strong>Tipo: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->tipo}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Num. Ejes: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->num_ejes}}</td>
         <td style="width: 50%"><strong>Color: </strong></td>
         <td style="width: 50%">{{$linea_compra->color}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Dist. entre ejes: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->distancia_entre_ejes}}</td>
         <td style="width: 50%"><strong>Año Modelo: </strong></td>
         <td style="width: 50%">{{$linea_compra->anio}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Num. Puertas: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->num_puertas}}</td>
         <td style="width: 50%"><strong>Num. Motor: </strong></td>
         <td style="width: 50%">{{$linea_compra->numero_motor}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Num. Asientos: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->num_asientos}}</td>
         <td style="width: 50%"><strong>Cap. Pasajeros: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->cap_pasajeros}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>VIN: </strong></td>
         <td style="width: 50%">{{$linea_compra->vin}}</td>
         <td style="width: 50%"><strong>Peso Bruto: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->peso_bruto}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Combustible: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->combustible}}</td>
         <td style="width: 50%"><strong>Peso Neto: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->peso_neto}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Potencia: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->potencia}}</td>
         <td style="width: 50%"><strong>Carga útil: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->carga_util}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Num. Cilindros: </strong></td>
         <td style="width: 50%">{{ $linea_compra->vehiculoNuevo->num_cilindros }}</td>
         <td style="width: 50%"><strong>Alto: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->alto}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Cilindrada: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->cilindrada}}</td>
         <td style="width: 50%"><strong>Largo: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->largo}}</td>
      </tr>
      <tr>
         <td style="width: 50%"><strong>Trasmisión: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->transmision}}</td>
         <td style="width: 50%"><strong>Ancho: </strong></td>
         <td style="width: 50%">{{$linea_compra->vehiculoNuevo->ancho}}</td>
      </tr>

   </table>
</div>




@endif

@if (strpos($orden_compra->almacen->valor1, 'CONSUMIBLE'))
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
   <table class="" style="width: 100%;">
      <thead>
         <tr>
            <th scope="col" style="width: 10%;">#</th>
            <th scope="col" style="width: 10%;">CODIGO</th>
            <th scope="col" style="width: 20%;">DESCRIPCION</th>
            <th scope="col" style="width: 14%;">CANTIDAD</th>
            <th scope="col" style="width: 14%;">C. UNIT</th>
            <th scope="col" style="width: 14%;">DSCTO. UNIT</th>
            <th scope="col" style="width: 14%;">C. TOTAL</th>
         </tr>
      </thead>
      <tbody>
         @foreach( $lineas_compra as $linea_compra)
         <tr>
            <th scope="row\">{{$loop->iteration}}</th>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->otroProductoServicio->id_otro_producto_servicio}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->otroProductoServicio->descripcion}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->cantidad}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->precio,2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->descuento}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->sub_total,2)}}</td>
         </tr>
         @endforeach
         <tr>
            <td style="height: 200px">&nbsp;</td>
         </tr>
      </tbody>
   </table>
</div>
@endif

@if (strpos($orden_compra->almacen->valor1, 'ACTIVO'))
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
   <table class="" style="width: 100%;">
      <thead>
         <tr>
            <th scope="col" style="width: 10%;">#</th>
            <th scope="col" style="width: 10%;">CODIGO</th>
            <th scope="col" style="width: 20%;">DESCRIPCION</th>
            <th scope="col" style="width: 14%;">CANTIDAD</th>
            <th scope="col" style="width: 14%;">C. UNIT</th>
            <th scope="col" style="width: 14%;">DSCTO. UNIT</th>
            <th scope="col" style="width: 14%;">C. TOTAL</th>
         </tr>
      </thead>
      <tbody>
         @foreach( $lineas_compra as $linea_compra)
         <tr>
            <th scope="row\">{{$loop->iteration}}</th>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->otroProductoServicio->id_otro_producto_servicio}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->otroProductoServicio->descripcion}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->cantidad}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->precio,2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->descuento}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->sub_total,2)}}</td>
         </tr>
         @endforeach
         <tr>
            <td style="height: 200px">&nbsp;</td>
         </tr>
      </tbody>
   </table>
</div>
@endif

@if (strpos($orden_compra->almacen->valor1, 'HERRAMIENTA'))
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
   <table class="" style="width: 100%;">
      <thead>
         <tr>
            <th scope="col" style="width: 10%;">#</th>
            <th scope="col" style="width: 10%;">CODIGO</th>
            <th scope="col" style="width: 20%;">DESCRIPCION</th>
            <th scope="col" style="width: 14%;">CANTIDAD</th>
            <th scope="col" style="width: 14%;">C. UNIT</th>
            <th scope="col" style="width: 14%;">DSCTO. UNIT</th>
            <th scope="col" style="width: 14%;">C. TOTAL</th>
         </tr>
      </thead>
      <tbody>
         @foreach( $lineas_compra as $linea_compra)
         <tr>
            <th scope="row\">{{$loop->iteration}}</th>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->otroProductoServicio->id_otro_producto_servicio}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->otroProductoServicio->descripcion}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->cantidad}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->precio,2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->descuento}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->sub_total,2)}}</td>
         </tr>
         @endforeach
         <tr>
            <td style="height: 200px">&nbsp;</td>
         </tr>
      </tbody>
   </table>
</div>
@endif

@if (strpos($orden_compra->almacen->valor1, 'REPUESTO'))
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
   <table class="" style="width: 100%;">
      <thead>
         <tr>
            <th scope="col" style="width: 10%;">#</th>
            <th scope="col" style="width: 10%;">CODIGO</th>
            <th scope="col" style="width: 20%;">DESCRIPCION</th>
            <th scope="col" style="width: 14%;">CANTIDAD</th>
            <th scope="col" style="width: 14%;">C. UNIT</th>
            <th scope="col" style="width: 14%;">DSCTO. UNIT</th>
            <th scope="col" style="width: 14%;">C. TOTAL</th>
         </tr>
      </thead>
      <tbody>
         @foreach( $lineas_compra as $linea_compra)
         <tr>
            <th scope="row\">{{$loop->iteration}}</th>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->repuesto->codigo_repuesto}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->repuesto->descripcion}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->cantidad}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->precio,2)}}</td>
            <td style="text-align: center; padding-right: 5px">{{$linea_compra->descuento}}</td>
            <td style="text-align: center; padding-right: 5px">{{number_format($linea_compra->sub_total,2)}}</td>
         </tr>
         @endforeach
         <tr>
            <td style="height: 200px">&nbsp;</td>
         </tr>
      </tbody>
   </table>
</div>
@endif

<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
   <div style="width: 40%; border-style: solid; margin-bottom: 10px; margin-left: auto">
      <table style="width: 100%">
         @if (strpos($orden_compra->almacen->valor1, 'VEHICULO'))
         <tr>
            <td>VALOR VENTA: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
            <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('sub_total'),2)}}</td>
         </tr>
         <tr>
            <td>ISC: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
            {{-- <td style="text-align: right; padding-right: 5px">{{number_format($montoIGV,2)}}</td> --}}
            <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('sub_total')*0.1,2)}}</td>
         </tr>
         <tr>
            <td>IGV: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
            {{-- <td style="text-align: right; padding-right: 5px">{{number_format($montoIGV,2)}}</td> --}}
            <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('sub_total')* 1.1 * 0.18,2)}}</td>
         </tr>
         <tr>
            <td>PRECIO VENTA: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
            {{-- <td style="text-align: right; padding-right: 5px">{{number_format($total,2)}}</td> --}}
            <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('sub_total')*1.1*1.18,2)}}</td>

         </tr>

         @else
            <tr>
               <td>VALOR VENTA: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
               <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('sub_total'),2)}}</td>
            </tr>
            <tr>
               <td>IGV: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
               {{-- <td style="text-align: right; padding-right: 5px">{{number_format($montoIGV,2)}}</td> --}}
               <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('impuesto'),2)}}</td>

            </tr>
            <tr>
               <td>PRECIO VENTA: ({{App\Helper\Helper::obtenerUnidadMoneda($moneda)}})</td>
               {{-- <td style="text-align: right; padding-right: 5px">{{number_format($total,2)}}</td> --}}
               <td style="text-align: right; padding-right: 5px">{{number_format($orden_compra->lineasCompra->sum('total'),2)}}</td>

            </tr>
         @endIf
      </table>
   </div>
</table>