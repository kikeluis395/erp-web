@include('formatos.headerConstancia', ['pagina' => 3])
<br>
<table style="width: 100%">
    <tr>
        <td style="text-align: right">
            @php
                $now = \Carbon\Carbon::now();
                $day = $now->day;
                $month = $now->month;
                $year = $now->year;
            @endphp
            Ate, {{ $day }} de {{ \App\Helper\Helper::getFullNameMonth($month) }} del {{ $year }}
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding-top: 20px">
            EMPRESA
        </td>
    </tr>
    <tr>
        <td style="padding-top: 50px">En señal de conformidad:</td>
    </tr>
</table>

<table style="width: 330px; border-top: 1px solid black; margin-top: 90px">
    <tr>
        <td>Nombre: {{ $cliente }}</td>
    </tr>
    <tr>
        <td>E-mail: {{ $correo }}</td>
    </tr>
    <tr>
        <td>Telefono Celular: {{ $telefono }}</td>
    </tr>
    <tr>
        <td>Fecha: {{ $fecha }}</td>
    </tr>
</table>
@include('formatos.footerConstancia')