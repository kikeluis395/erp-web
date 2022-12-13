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




<br>


<br>
<div style="width: 100%; border-style: solid; margin-bottom: 10px">


    <table class="" style="width: 100%; padding: 4px;">
        <tr>
            <th align="left">#OC:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraRelacionada() }}</td>

            <th align="left">Fecha OC:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->fecha_registro }}</td>
        </tr>

        
        <tr>
            <th align="left">Observaciones:</th>
            <td align="left">{{ $nota_ingreso->observaciones }}</td>
        </tr>

        <tr>
            <th align="left">Condición:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->condicion_pago }}</td>
            <th align="left">Moneda:</th>
            <td align="left">{{ $nota_ingreso->obtenerOrdenCompraObjeto()->tipo_moneda }}</td>
            
           
        </tr>
               
    </table>
</div>




<h4>Detalle Nota de Ingreso</h4>

<table style="width: 100%; border-style: solid; margin-bottom: 10px">
    

    <tr>
        <th align="left">Placa</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->placa }}</td>
        <th align="left">Color</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->color }}</td>
    </tr>
    <tr>
        <th align="left">VIN</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->vin }}</td>
        <th align="left">Año fabricación</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->anho_fabricacion }}</td>
    </tr>
    <tr>
        <th align="left">Motor</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->motor }}</td>
        <th align="left">Año modelo</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->anho_modelo }}</td>
    </tr>
    <tr>
        <th align="left">Marca</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->modeloAutoSeminuevo->marca->nombre }}</td>
        <th align="left">Combustible</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->combustible }}</td>
    </tr>
    <tr>
        <th align="left">Modelo</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->modeloAutoSeminuevo->nombre }}</td>
        <th align="left">Cilindrada</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->cilindrada }}</td>
    </tr>
    <tr>
        <th align="left">Versión</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->version }}</td>
        <th align="left">Transmisión:</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->transmision }}</td>
    </tr>
    <tr>
        <th align="left">Kilometraje</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->kilometraje }}</td>
        <th align="left">Tracción</th>
        <td align="left">{{ $lineas_nota_ingreso->first()->vehiculoSeminuevo()->traccion }}</td>
    </tr>



</table>

<table class="" style="width: 100%; padding: 0px; margin-bottom: 5px">
    <div style="width: 40%; border-style: solid; margin-bottom: 10px; margin-left: auto">
        <table style="width: 100%">
            <tr>
                <td>TOTAL: ({{ App\Helper\Helper::obtenerUnidadMoneda($moneda) }})</td>
                <td style="text-align: right; padding-right: 5px">{{ number_format($nota_ingreso->getCostoTotal(), 2) }}
                </td>
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
