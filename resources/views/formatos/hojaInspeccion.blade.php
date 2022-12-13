<style>
    .part-1{
        background-image: url("{{asset('assets/images/inspeccion-1.png')}}");
        background-size: contain;
    }
    .section-1{
        position: absolute;
        top: 0px;
        left: 0px;
    }
    .section-2{
        position: absolute;
        top: 0px;
        left:236.5px;
    }
    .section-3{
        position: absolute;
        top: 0px;
        left:473px;
    }
    .section-carga{
        position: absolute;
        top: 445px;
        left:365px;
    }
    .section-carga table {
        font-size: 10px
    }

    .section-mm{
        position: absolute;
        top: 0px;
        left:600px;
    }
    .section-mm td {
        padding: 0px;
        height: 12.5px;
    }
    .section-mm table {
        font-size: 10px
    }
    .selected{
        height: 5px;
        width: 5px;
    }
    td{
        width: 7px;
    }

    td:nth-last-child(4){
        height: 5px;
        width: 5px;
    }

    tr.green td:nth-child(2) div {
        background-color: green;
    }
    tr.yellow td:nth-child(3) div {
        background-color: yellow;
    }
    tr.red td:nth-child(4) div {
        background-color: red;
    }

    .blank {
        height: 2px;
    }
    .blank-fix-18 {
        font-size: 3.5px;
    }
    .blank-fix-50 {
        font-size: 4px;
    }
    .blank-fix-63 {
        font-size: 4px;
    }
    .blank-fix-65 {
        font-size: 3px;
    }
</style>

<div style="font-family: sans-serif; font-size: 14px">
    <h2 align="center">HOJA DE INSPECCION TECNICA</h2>
    <table style="width: 100%">
        <thead>
            <tr>
                <td></td>
                <td style="width: 100px;">&nbsp;</td>
                <td></td>
                <td style="width: 100px;">&nbsp;</td>
                <td></td>
                <td style="width: 100px;">&nbsp;</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="right">N° de OT:</td>  <td style="border-bottom-style: solid" align="center">{{$nroOT}}</td>
                <td align="right">Placa:</td>     <td style="border-bottom-style: solid" align="center">{{$placa}}</td>
                <td align="right">Fecha:</td>     <td style="border-bottom-style: solid" align="center">{{$fecha}}</td>
            </tr>
            <tr>
                <td align="right">Técnico:</td>   <td style="border-bottom-style: solid" align="center">{{$tecnico}}</td>
                <td align="right">Marca:</td>     <td style="border-bottom-style: solid" align="center">{{$marca}}</td>
                <td align="right">Modelo:</td>    <td style="border-bottom-style: solid" align="center">{{$modelo}}</td>
            </tr>
        </tbody>        
    </table>
    <h3 align="center">RESULTADOS DE LA INSPECCION</h3>
</div>

<div style="padding: 0px; margin: 0px; position: relative">
    <img src="{{asset('assets/images/inspeccion-1.png')}}" style="width: 100%;">
    <div class="section-1">
        <table style="font-size: 1.5px">
            <thead>
                <tr>
                    <td style="width:180px; height: 21px">&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr class="{{$listaElementosInspeccion[0]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td class="blank">&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[1]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[2]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[3]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[4]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[5]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[6]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[7]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[8]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[9]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[10]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[11]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[12]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[13]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>

                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[14]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[15]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[16]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank-fix-18"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[17]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[18]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[19]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[20]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[21]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[22]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[23]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[24]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[25]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
            </tbody>
        </table>
    </div>

    <div class="section-2">
        <table style="font-size: 1.5px">
            <thead>
                <tr>
                    <td style="width:180px; height: 21px">&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr class="{{$listaElementosInspeccion[26]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td class="blank">&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[27]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <!-- aqui no va nada -->
                <tr>
                    <td class="selected"></td>
                    <td><div>&nbsp;</div></td>
                    <td><div>&nbsp;</div></td>
                    <td><div>&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <!-- aqui no va nada -->

                <tr class="{{$listaElementosInspeccion[28]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[29]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[30]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[31]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[32]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[33]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[34]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[35]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[36]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>


                <!-- SECCION E -->


                <tr class="{{$listaElementosInspeccion[37]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[38]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[39]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>

                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[40]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <!-- DEJAR VACIO -->
                <tr>
                    <td class="selected"></td>
                    <td><div>&nbsp;</div></td>
                    <td><div>&nbsp;</div></td>
                    <td><div>&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <!-- DEJAR VACIO -->

                <tr class="{{$listaElementosInspeccion[41]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[42]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[43]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[44]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[45]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <!-- DEJARVACIO -->
                <tr>
                    <td class="selected"></td>
                    <td><div>&nbsp;</div></td>
                    <td><div>&nbsp;</div></td>
                    <td><div>&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <!-- VACIO -->

                <tr class="{{$listaElementosInspeccion[46]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[47]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[48]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank-fix-50"><td>&nbsp;</td></tr>

                <!-- SECCION F -->
                <tr class="{{$listaElementosInspeccion[49]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section-carga">
        <table>
            <thead>
                <tr><td style="height: 18px; width: 35px">&nbsp;</td></tr>
            </thead>
            <tbody align="center">
                <tr><td>{{$listaElementosInspeccion[49]->valor}}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="section-3">
        <table style="font-size: 1.5px">
            <thead>
                <tr>
                    <td style="width:180px; height: 21px">&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr class="{{$listaElementosInspeccion[50]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td class="blank">&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[51]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[52]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[53]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                

                <tr class="{{$listaElementosInspeccion[54]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[55]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[56]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[57]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>

                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[58]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[59]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[60]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[61]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank-fix-63"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[62]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[63]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank"><td>&nbsp;</td></tr>
                <tr class="blank-fix-65"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[64]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

                <tr class="{{$listaElementosInspeccion[65]->color}}">
                    <td></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                    <td><div class="selected">&nbsp;</div></td>
                </tr>
                <tr class="blank"><td>&nbsp;</td></tr>

            </tbody>
        </table>
    </div>

    <div class="section-mm">
        <table>
            <thead>
                <tr><td style="height: 18px; width: 35px">&nbsp;</td></tr>
            </thead>
            <tbody align="center">
                <tr><td>{{$listaElementosInspeccion[50]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[51]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[52]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[53]->valor}}</td></tr>
                <tr><td style="height: 85px">&nbsp;</td></tr>
                <tr><td>{{$listaElementosInspeccion[54]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[55]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[56]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[57]->valor}}</td></tr>
                <tr><td style="height: 57px">&nbsp;</td></tr>
                <tr><td>{{$listaElementosInspeccion[58]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[59]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[60]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[61]->valor}}</td></tr>
                <tr><td style="height: 25px">&nbsp;</td></tr>
                <tr><td>{{$listaElementosInspeccion[62]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[63]->valor}}</td></tr>
                <tr><td style="height: 59px">&nbsp;</td></tr>
                <tr><td>{{$listaElementosInspeccion[64]->valor}}</td></tr>
                <tr><td>{{$listaElementosInspeccion[65]->valor}}</td></tr>
            </tbody>
        </table>
    </div>
    <img src="{{asset('assets/images/inspeccion-2.png')}}" style="width: 100%;">
</div>

<div style="font-family: sans-serif; font-size: 14px">
    <h3>Observaciones:</h3>
    <p>{{$observaciones}}</p>

    <table style="width: 100%" style="font-size: 10px">
        <thead>
            <tr>
                <td style="width:10%">&nbsp;</td>
                <td style="width:37%">&nbsp;</td>
                <td style="width:5%">&nbsp;</td>
                <td style="width:37%">&nbsp;</td>
                <td style="width:10%">&nbsp;</td>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td style="height: 150px"></td>
                <td style="vertical-align: bottom;">
                    <table style="width: 75%">
                        <tr><td style="height: 130px; border-bottom-style: solid">&nbsp;</td></tr>
                        <tr><td align="center">Firma del técnico</td></tr>
                    </table>
                </td>
                <td></td>
                <td style="vertical-align: bottom">
                    <table style="width: 75%">
                        <tr><td style="height: 130px; border-bottom-style: solid">&nbsp;</td></tr>
                        <tr><td align="center">Firma del asesor</td></tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>