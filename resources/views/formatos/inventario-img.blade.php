<img src="{{ asset('assets/images/imprimible_ot.png') }}"
     style="width: 100%; margin-top: 50px">
<div style="position: absolute; top:125px; left: 50px; font-family: 'sans-serif'; font-size: 12px;">
    <table style="text-align: center"
           align="center; border-collapse: collapse"
           border="0">
        <tr>
            <td style="width: 158.5px">{{ $hojaTrabajo->vehiculo->getNombreMarca() }}</td>
            <td style="width: 158.5px">&nbsp;{{ substr($hojaTrabajo->vehiculo->getModelo(), 0, 22) }}</td>
            <td style="width: 158.5px">{{ $hojaTrabajo->getPlacaPartida() }}</td>
        </tr>
    </table>
</div>
