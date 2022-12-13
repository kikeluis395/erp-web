<style>
    * {
        border-width: 0.5px;
        font-family: 'sans-serif';
        font-size: 14px;
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
<div style="width: 50%"><img src="{{ asset('assets/images/logo_planeta.jpg') }}"
         style="height: 28px;"></div>
<h3 align="center">NOTA DE DEVOLUCIÓN # {{ $correlativo }}</h3>


<table class=""
       style="width: 100%; padding: 0px; margin-bottom: 5px">
    <tr>
        <td style="border:solid; width: 59%;">
            <table style="width: 100%;">
                <tr>
                    <th align="left">1222 PERU S.A.C.</th>
                </tr>
                <tr>
                    <th align="left">Sede: Los Olivos</th>
                </tr>
                <tr>
                    <th align="left">Dir. Fiscal: Los Olivos Alfredo Mendiola 5500</th>
                </tr>
            </table>
        </td>
        <td style="width: 2%;">

        </td>


        <td style="border:solid; width: 39%">
            <table style="width: 100%;">
                {{-- <tr>
                    <th align="left">Fecha de Entrega:
                        {{ \Carbon\Carbon::parse($devoluciones->fecha_devolucion)->format('d/m/Y') }}</th>
                </tr> --}}
                <tr>
                    <th align="left">Fecha de Emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</th>
                </tr>
                <tr>
                    <th align="left">Emisor: {{ $devoluciones->getNombreCompletoUsuarioRegistro() }}</th>
                </tr>
                <tr></tr>
            </table>
        </td>
    </tr>
</table>


<div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class=""
           style="width: 100%; padding: 4px;">

        <tr>
            <td style="width: 50%"><strong>Proveedor: {{ $devoluciones->getNombreProveedor() }}</strong></td>
            <td style="width: 50%"><strong>RUC: {{ $devoluciones->getRUCProveedor() }}</strong></td>
        </tr>
        <tr>
            @php
                $provider = $devoluciones->proveedor;
                $dire = $provider->direccion;
                $dpto = $provider->getDepartamentoText();
                $prov = $provider->getProvinciaText();
                $dist = $provider->getDistritoText();
            @endphp
            <td colspan="2"><strong>Dirección: {{ "$dire / $dist / $prov / $dpto" }} </strong></td>
        </tr>

        {{-- <tr>
            <td style="width: 50%"><strong>Sres. {{ $devoluciones->getNombreProveedor() }}</strong></td>
            <td style="width: 50%"><strong>Contacto: {{ $devoluciones->proveedor->contacto }}</strong></td>
        </tr>
        <tr>
            <td><strong>RUC: {{ $devoluciones->getRUCProveedor() }}</strong></td>
        </tr>
        <tr>
            <td><strong>Dirección: {{ $devoluciones->proveedor->direccion }} </strong></td>
            <td><strong>Telef: {{ $devoluciones->proveedor->telf_contacto }}</strong></td>
        </tr>
        <tr>
            <td><strong>Código Proveedor: {{ $devoluciones->proveedor->id_proveedor }}</strong></td>
            <td><strong>Mail: {{ $devoluciones->proveedor->email_contacto }}</strong></td>
        </tr> --}}
    </table>
</div>

<div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class=""
           style="width: 100%; padding: 4px;">
        <tr>
            <td style="width: 50%"><strong>NC Proveedor: {{ $devoluciones->nro_nota_credito }}</strong></td>
            <td style="width: 50%"><strong>Factura Ref. Proveedor: {{ $devoluciones->doc_referencia }}</strong></td>
        </tr>
        <tr>
            <td style="width: 100%"><strong>Motivo Devolución: {{ $devoluciones->motivo }}</strong></td>
        </tr>
        <tr>
            <td style="width: 50%"><strong>Moneda: {{ $devoluciones->moneda }}</strong></td>
            <td style="width: 50%"><strong>Montos sin IGV</strong></td>
        </tr>

        {{-- <tr>
            <td style="width: 33%"><strong>Moneda: {{ $devoluciones->moneda }}</strong></td>
            <td style="width: 34%"><strong>Montos sin IGV</strong></td>
            <td style="width: 34%"><strong>NC del proveedor: {{ $devoluciones->nro_nota_credito }}</strong></td>
        </tr>
        <tr>
            <td style="width: 34%"><strong>Doc Referencia: {{ $devoluciones->doc_referencia }}</strong></td>
        </tr>
        <tr>
            <table style="width: 100%; padding: 4px">
                <tr>
                    <td style="width: 34%"><strong>Motivo: {{ $devoluciones->motivo }}</strong></td>
                </tr>
            </table>
        </tr> --}}
    </table>


</div>
<div style="width: 100%; border-style: solid; margin-bottom: 10px">
    <table class=""
           style="width: 100%;">
        <thead>
            <tr>
                <th scope="col"
                    style="width: 6%;">#</th>
                <th scope="col"
                    style="width: 10%;">CODIGO</th>
                <th scope="col"
                    style="width: 25%;">DESCRIPCION</th>
                {{-- <th scope="col"
                    style="width: 10%;">UNIDAD</th> --}}
                <th scope="col"
                    style="width: 10%;">CANTIDAD</th>
                <th scope="col"
                    style="width: 13%;">C. UNIT</th>
                <th scope="col"
                    style="width: 13%;">D. UNIT</th>
                <th scope="col"
                    style="width: 13%;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($linea_devolucion as $lineaDevolucion)
                <tr>
                    <th scope="row\">{{ $loop->iteration }}</th>
                    <td align="center">{{ $lineaDevolucion->getCodigoRepuesto() }}</td>
                    <td align="center">{{ $lineaDevolucion->getDescripcionRepuesto() }}</td>
                    {{-- <td style="text-align: right; padding-right: 5px">
                        {{ $lineaDevolucion->repuesto->getNombreUnidadGrupo() }}</td> --}}
                    <td style="text-align: right; padding-right: 5px">{{ $lineaDevolucion->cantidad_devolucion }}
                    </td>
                    <td style="text-align: right; padding-right: 5px">{{ $lineaDevolucion->costo_unitario }}</td>
                    <td style="text-align: right; padding-right: 5px">{{ $lineaDevolucion->descuento_unitario }}</td>
                    <td style="text-align: right; padding-right: 5px">
                        {{ number_format($lineaDevolucion->obtenerTotal(), 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="height: 200px">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>

<table class=""
       style="width: 100%; padding: 0px; margin-bottom: 5px">
    <div style="width: 40%; border-style: solid; margin-bottom: 10px; margin-left: auto">
        <table style="width: 100%">
            <tr>
                <td>SUB TOTAL ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                <td style="text-align: right; padding-right: 5px">
                    {{ number_format($devoluciones->getCostoTotal(), 2) }}
                </td>
            </tr>
            <tr>
                <td>IGV ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                <td style="text-align: right; padding-right: 5px">{{ number_format($montoIGV, 2) }}</td>
            </tr>
            <tr>
                <td>TOTAL ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                <td style="text-align: right; padding-right: 5px">{{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div>
</table>
