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

<table style="font-size:13px; width:100%">
    <tr>
        <td style="width: 48%;">
            @include('formatos.notaEntrega')
        </td>
        <td style="width: 4%">&nbsp;</td>
        <td style="width: 48%">
            @include('formatos.notaEntrega')
        </td>
    </tr>
</table>