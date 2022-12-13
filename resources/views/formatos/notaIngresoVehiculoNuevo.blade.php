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
<div><img src="{{ asset('assets/images/logo_planeta.jpg') }}" style="height: 28px;" /></div>

<h3 align="center">NOTA DE INGRESO N° {{ $nota_ingreso->id_nota_ingreso }}</h3>

<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
    <tr>
        <td style="border:solid; width: 59%;">
            <table style="width: 100%;">
                <tr>
                    <th align="left">1222 PERU S.A.C.</th>
                </tr>
                <tr>
                    <th align="left">{{ 'Los olivos' }}</th>
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
                    <th align="left">Fecha de Emisión:
                        {{ \Carbon\Carbon::parse($nota_ingreso->fecha_registro)->format('d/m/Y') }}
        </td>
        </th>
    </tr>
    <tr>
        <th align="left">Fecha de Impresión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</th>
    </tr>
    <tr>
        <th align="left">Emisor: {{ $nota_ingreso->getNombreUsuarioRegistro() }}</th>

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
            <td style="width: 50%"><strong>Sres.
                    {{ $nota_ingreso->obtenerOrdenCompraObjeto()->getNombreProveedor() }}</strong></td>
            <td><strong>RUC: {{ $nota_ingreso->obtenerOrdenCompraObjeto()->getRUCProveedor() }}</strong></td>
        </tr>
        <tr>
            <td><strong>Dirección: {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->direccion }} /
                    {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->ubigeoEjemplo->departamento }} /
                    {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->ubigeoEjemplo->provincia }} /
                    {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->ubigeoEjemplo->distrito }}</strong></td>
            <td><strong>Telef: {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->telf_contacto }}</strong></td>
        </tr>
        <tr>
            <td style="width: 50%"><strong>Contacto:
                    {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->contacto }}</strong></td>
            <td><strong>Mail: {{ $nota_ingreso->obtenerOrdenCompraObjeto()->proveedor->email_contacto }}</strong></td>
        </tr>
    </table>
</div>

<br>

<div style="width: 100%; border-style: solid; margin-bottom: 10px">


    <table class="" style="width: 100%; padding: 4px;">


        <tr>
            <th align="left">#OC:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraRelacionada() }}</td>
            <th align="left">Guía de Remisión:</th>
            <td align="left">{{ $nota_ingreso->guia_remision }}</td>
            <th align="left">Almacen:</th>
            <td align="left">{{ $nota_ingreso->getAlmacen() }}</td>
        </tr>

        <tr>

            <th align="left">Motivo:</th>
            {{-- <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->motivoOC() }}</td> --}}
            <td></td>
            <th align="left">Detalle motivo:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->detalle_motivo }}</td>
        </tr>

        <tr>
            <th align="left">Observaciones:</th>
            <td align="left">{{ $nota_ingreso->observaciones }}</td>
        </tr>
    </table>
</div>
<br>
<div style="width: 100%; border-style: solid; margin-bottom: 10px">


    <table class="" style="width: 100%; padding: 4px;">


        <tr>
            <th align="left">Condición:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->condicion_pago }}</td>
            <th align="left">Moneda:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->tipo_moneda }}</td>
            <th align="left">Montos sin IGV:</th>
            <td></td>
        </tr>

    </table>
</div>




<h4>Detalle Nota de Ingreso</h4>
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class="" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col" style="width: 6%;">#</th>
                <th scope="col" style="width: 16%;">MODELO COMERCIAL</th>
                <th scope="col" style="width: 13%;">C. UNIT.</th>
                <th scope="col" style="width: 13%;">DSCTO. UNIT.</th>
                <th scope="col" style="width: 13%;">C. TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lineas_nota_ingreso as $lineas_nota_ingreso)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td style="text-align: center;">{{ $lineas_nota_ingreso->lineaOrdenCompra->getCodigoRepuesto() }}
                    </td>
                    <td style="text-align: right; padding-right: 5px">
                        {{ $lineas_nota_ingreso->lineaOrdenCompra->precio }}</td>
                    <td style="text-align: right; padding-right: 5px">
                        {{ $lineas_nota_ingreso->lineaOrdenCompra->descuento }}</td>
                    <td style="text-align: right; padding-right: 5px">
                        {{ number_format($lineas_nota_ingreso->obtenerTotal(), 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="height: 5px">&nbsp;</td>
            </tr>


        </tbody>
    </table>


</div>


<table style="width: 100%; border-style: solid; margin-bottom: 10px">
    <tr>
        <th align="left">Modelo Comercial</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->modelo_comercial }}</td>

    </tr>

    <tr>
        <th align="left">Marca</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->marcaAuto->nombre_marca }}</td>
        <th align="left">Tracción</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->traccion }}</td>
    </tr>
    <tr>
        <th align="left">Carrocería</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->carroceria }}</td>
        <th align="left">Num. Ruedas</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->num_ruedas }}</td>
    </tr>
    <tr>
        <th align="left">Tipo</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->tipo }}</td>
        <th align="left">Num. Ejes</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->num_ejes }}</td>
    </tr>
    <tr>
        <th align="left">Color</th>
        <td align="left">{{ $lineas_nota_ingreso->lineaOrdenCompra->color }}</td>
        <th align="left">Dist. entre ejes</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->distancia_entre_ejes }}</td>
    </tr>
    <tr>
        <th align="left">Año modelo</th>
        <td align="left">{{ $lineas_nota_ingreso->lineaOrdenCompra->anio }}</td>
        <th align="left">Num. Puertas</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->num_puertas }}</td>
    </tr>
    <tr>
        <th align="left">Num. Motor</th>
        <td align="left">{{ $lineas_nota_ingreso->lineaOrdenCompra->numero_motor }}</td>
        <th align="left">Num. Asientos</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->num_asientos }}</td>
    </tr>
    <tr>
        <th align="left">Num chasis</th>
        <td align="left">{{ '-' }}</td>
        <th align="left">Cap. Pasajeros</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->cap_pasajeros }}</td>
    </tr>
    <tr>
        <th align="left">VIN</th>
        <td align="left">{{ $lineas_nota_ingreso->lineaOrdenCompra->vin }}</td>
        <th align="left">Peso Bruto</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->peso_bruto }}</td>
    </tr>
    <tr>
        <th align="left">Combustible</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->combustible }}</td>
        <th align="left">Peso neto</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->peso_neto }}</td>
    </tr>
    <tr>
        <th align="left">Potencia</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->potencia }}</td>
        <th align="left">Carga útil</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->carga_util }}</td>
    </tr>
    <tr>
        <th align="left">Num. de Cilindros</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->num_cilindros }}</td>
        <th align="left">Alto</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->alto }}</td>
    </tr>
    <tr>
        <th align="left">Cilindrada</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->cilindrada }}</td>
        <th align="left">Largo</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->largo }}</td>
    </tr>
    <tr>
        <th align="left">Transmisión</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->transmision }}</td>
        <th align="left">Ancho</th>
        <td align="left">{{ $lineas_nota_ingreso->vehiculoNuevo()->ancho }}</td>
    </tr>


</table>

<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
    <div style="width: 40%; border-style: solid; margin-bottom: 10px; margin-left: auto">
        <table style="width: 100%">
            <tr>
                <td>SUB TOTAL: ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                <td style="text-align: right; padding-right: 5px">{{ number_format($nota_ingreso->getCostoTotal(), 2) }}
                </td>
            </tr>
            <tr>
                <td>ISC: ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                {{-- <td style="text-align: right; padding-right: 5px">{{number_format($montoIGV,2)}}</td> --}}
                <td style="text-align: right; padding-right: 5px">
                    {{ number_format($nota_ingreso->getCostoTotal() * 0.1, 2) }}</td>

            </tr>
            <tr>
                <td>IGV: ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                {{-- <td style="text-align: right; padding-right: 5px">{{number_format($montoIGV,2)}}</td> --}}
                <td style="text-align: right; padding-right: 5px">
                    {{ number_format($nota_ingreso->getCostoTotal() * 1.1 * 0.18, 2) }}</td>

            </tr>
            <tr>
                <td>TOTAL: ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                {{-- <td style="text-align: right; padding-right: 5px">{{number_format($total,2)}}</td> --}}
                <td style="text-align: right; padding-right: 5px">
                    {{ number_format($nota_ingreso->getCostoTotal() * 1.1 * 1.18, 2) }}</td>

            </tr>
        </table>
    </div>
</table>


<img src="{{ asset('assets/images/imprimible_ni.png') }}"
     style="width: 100%; margin-top: 50px">
<div style="position: absolute; top:125px; left: 50px; font-family: 'sans-serif'; font-size: 12px;">
    <table style="text-align: center"
           align="center; border-collapse: collapse"
           border="0">
        <tr>
            <td style="width: 158.5px">
                {{-- marca --}}
            </td>
            <td style="width: 158.5px">
                {{-- modelo --}}
            </td>
            <td style="width: 158.5px">
                {{-- vin --}}
            </td>
        </tr>
    </table>
</div>

<div style="position: absolute; bottom:65px; left: 110px; font-family: 'sans-serif'; font-size: 12px;">
    <table style="text-align: center"
           align="center; border-collapse: collapse"
           border="0">
        <tr>
            <td style="width: 230px; text-align: left">&nbsp;</td>
            <td style="width: 230px">
                {{-- nombre del usuario que ingresó la NI en el módulo de “Recepción VN” --}}
            </td>
        </tr>
    </table>
</div>
