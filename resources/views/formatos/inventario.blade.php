<style>
    *{   
        border-width: 0.5px;
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

    .all-bordered thead td{
        border: none;
    }
    .all-bordered thead th{
        border: none;
    }

    .checked:before {
        font-family: DejaVu Sans;
        font-size: 15px;
        content: "✓";
    }

    .ticked:before {
        font-family: DejaVu Sans;
        font-size: 15px;
        content: "×";
    }

    .cuadro-check{
        text-align: center;
    }

    #tabla_inventario tr td[colspan="4"]{
        border-right-style: none;
    }

    #tabla_inventario td[align="right"]{
        padding-right: 5px;
    }
</style>

<table style="font-size:13px; width:100%">
    <tr>
        <td style="width: 65%;"><img src="{{asset('assets/images/vistas_carro.jpeg')}}" style="width:100%"></td>
        <td style="width: 35%; vertical-align: top">
            <div style="margin-top: 40px; margin-left: 40px; border:solid; width: 120px; padding: 10px;">
                <div><img src="{{asset('assets/images/indicador_combustible.jpeg')}}" style="height: 70px;"></div>
                <strong style="margin-left: 20px">Combustible</strong>
            </div>
        </td>
    </tr>
    <!-- <tr>
        <td>
        </td>
        <td style="border: solid">
        </td>
    </tr> -->
    
    <tr>
        <td colspan="2" style="text-align: top">
            <table id="tabla_inventario" class="all-bordered" style="width: 100%; text-align: top; font-size: 11px">
                <thead>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="width:25px">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="width:25px">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="width:25px">&nbsp;</td>
                        <!-- half -->
                        <!-- <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td> -->
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="width:25px">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="width:25px">&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">CENICERO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(1)}}"></td>
                        <td align="right" style="padding-left: 4px">ENCENDEDOR</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(3)}}"></td>


                        <td style="border-right-style:none">TAPASOLES</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(2)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(2)->rh}}"></td>
                    </tr>
                    <tr>
                        <td colspan="5">MASCARA DE RADIO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(5)}}"></td>
                        <td align="right" style="padding-left: 4px">RADIO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(6)}}"></td>


                        <td colspan="4">PLUMILLAS</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(4)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="7">ANTENA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(8)}}"></td>


                        <td colspan="4">INYECTOR DE LIMPIAP.</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(7)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="5">TARJETA PROPIEDAD</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(10)}}"></td>
                        <td align="right">SOAT</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(11)}}"></td>

                        <td style="border-right-style:none">ESCARPINES</td>
                        <td align="right" style="border-left-style:none">CANT.</td>
                        <td class="cuadro-check">{{$hojaInventario->getHTMLResultByOrden(9)}}</td>
                        <td align="right"></td>
                        <td class="cuadro-check @if($hojaInventario->getHTMLResultByOrden(9)) checked @else tickedd @endif"></td>
                    </tr>
                    <tr>
                        <td colspan="7">CUADERNO DE GARANTÍA</td>
                        <td class="cuadro-check NUEVO"></td>

                        <td style="border-right-style:none">VASOS /COPAS RUEDAS</td>
                        <td align="right" style="border-left-style:none">CANT.</td>
                        <td class="cuadro-check">{{$hojaInventario->getHTMLResultByOrden(12)}}</td>
                        <td align="right"></td>
                        <td class="cuadro-check @if($hojaInventario->getHTMLResultByOrden(12)) checked @else tickedd @endif"></td>
                    </tr>
                    <tr>
                        <td colspan="7">MANUALES MANTENIMIENTO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(13)}}"></td>


                        <td style="border-right-style:none">EMBLEMA</td>
                        <td align="right" style="border-left-style:none">DEL</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(14)}}"></td>
                        <td align="right">POS.</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(15)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="7">SEGURO DE RUEDA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(16)}}"></td>


                        <td colspan="4">TAPA DEP. LIMPIAPARABRISAS</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(17)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="7">CLAXON</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(18)}}"></td>


                        <td colspan="2">TAPA TANQUE COMB.</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(23)}}"></td>
                        <td align="right">ACEITE</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(19)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">LUCES ALTAS</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(20)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(20)->rh}}"></td>


                        <td colspan="4">TAPA DE RADIADOR</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(25)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">LUCES BAJAS/POSICION</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(22)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(22)->rh}}"></td>

                        
                        <td style="border-right-style:none">TAPA DEP. LIQ.</td>
                        <td align="right" style="border-left-style:none">FRENO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(29)}}"></td>
                        <td align="right">EMBRAGUE</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(31)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">NEBLINEROS</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(24)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(24)->rh}}"></td>

                        
                        <td colspan="4">TAPA DE BORNE DE BATERIA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(33)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">LUCES DE FRENO</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(26)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(26)->rh}}"></td>


                        <td colspan="4">LLANTA DE REPUESTO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(35)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">LUZ DE PLACA</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(28)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(28)->rh}}"></td>


                        <td>GATA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(37)}}"></td>
                        <td align="right" colspan="2">PALANCA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(39)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="7">TERCERA LUZ FRENO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(30)}}"></td>


                        <td colspan="4">LLAVE DE RUEDA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(41)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">LUNAS PTA. DEL.</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(32)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(32)->rh}}"></td>


                        <td colspan="4">ESTUCHE DE HERRAMIENTAS</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(45)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">LUNAS PTA. POS.</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(34)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(34)->rh}}"></td>

                        
                        <td colspan="4">VEHICULO PULVERIZADO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(47)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4">ESPEJOS EXTERIORES</td>
                        <td align="right" style="border-left-style:none; padding-right: 5px">LH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(36)->lh}}"></td>
                        <td align="right" style="padding-right: 5px">RH</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(36)->rh}}"></td>


                        <td>ALARMA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(49)}}"></td>
                        <td colspan="2" align="right">CONTROLES</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(51)}}"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-right-style:none">PISOS</td>
                        <td align="right" style="border-left-style:none">CANT.</td>
                        <td class="cuadro-check"></td>
                        <td align="right">JEBE</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(38)}}"></td>
                        <td align="right">ALFOMBRA</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(40)}}"></td>


                        <td colspan="5" style="border-style: none"></td>
                    </tr>
                    <tr>
                        <td style="border-right-style:none" colspan="4">SISTEMA DE AIRE</td>
                        <td align="right" style="text-align:right; border-left-style: none">FORZADO</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(44)}}"></td>
                        <td align="right" style="text-align:right">ACOND.</td>
                        <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(46)}}"></td>
                        
                        <td colspan="5" style="border-style: none"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        
    </tr>
    @if(false)
    <td style="vertical-align: top">
        <table class="all-bordered" style="margin-left: 20px;width: 100%; font-size: 11.5px">
            <thead>
                <tr><th colspan="2" style="height:40px"></th></tr>
                <tr><th colspan="2" style="text-align: center; border:none">ACCESORIOS ADICIONALES</th></tr>
            </thead>
            <tbody>
                <tr><th align="left" style="width: 90%">BOTIQUIN</th>       <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(52)}}">&nbsp;</td></tr>
                <tr><th align="left">EXTINTOR</th>                          <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(53)}}"></td></tr>
                <tr><th align="left">TRIANGULO</th>                         <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(54)}}"></td></tr>
                <tr><th align="left">CABLE BATERIA</th>                     <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(55)}}"></td></tr>
                <tr><th align="left">CABLE REMOLQUE</th>                    <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(56)}}"></td></tr>
                <tr><th align="left">LLAVEROS</th>                          <td class="cuadro-check {{$hojaInventario->getHTMLResultByOrden(57)}}"></td></tr>
            </tbody>
        </table>
    </td>
    @endif
    @if(true)
    <tr>
        <td>
            <table class="all-bordered" style="width: 100%;">
                <thead><tr><td>Observaciones</td></tr></thead>
                <tbody><tr><td style="height: 50px"></td></tr></tbody>
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
    @endif
    <!-- movido a ordenTrabajo.blade -->
    @if(false)
    <tr>
        <td colspan="2">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100%; font-size: 11px">
                        TERMINOS LEGALES:
                        <ul>
                            <li>En caso la facturación sea al crédito, se deberá presentar la documentación solicitada por el área de finanzas.</li>
                            <li>Cuando el cliente no cumpla con pagar la obligación asumida por lo trabajos realizados, el vehículo permanecerá en el Centro de Servicio hasta que se realice el pago correspondiente.</li>
                            <li>Las fechas estimadas de entrega pueden variar dependiendo de la disponibilidad de repuestos y eventuales trabajos adicionales. En ningún caso, el cliente tendrá la potestad de reclamar el pago de indemnización por daños y perjuicios bajo esta circunstancia.</li>
                            <li>Toda reparación será cancelada en caja, antes de la entrega del vehículo. En caso de no retirarlo dentro de los dos (2) días útiles siguientes contados a partir de la fecha de haber recibido notificación de recojo o del presupuesto sin autorización de trabajo, se cobrará treinta (S/30.00) soles diarios por concepto de guardianía.</li>
                            <li>El cliente autoriza expresamente a la Empresa a hacer uso y realizar tratamiento de los datos personales que le proporcione el envío de anuncios u ofertas comerciales, comercialización de productos y servicios, transferencia de datos personales entre las empresas de Motorium Group.</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            @if(true)
            <table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
                <tr style="font-size: 2px">
                    <td style="width: 30%">&nbsp;</td>
                    <td style="width: 5%">&nbsp;</td>
                    <td style="width: 30%">&nbsp;</td>
                    <td style="width: 5%">&nbsp;</td>
                    <td style="width: 30%">&nbsp;</td>
                </tr>
                <tr align="center">
                    <td style="border: solid;">Cliente que deja la unidad</td>
                    <td></td>
                    <td style="border: solid;">Asesor de servicio</td>
                    <td></td>
                    <td style="border: solid;">Cliente que recoje la unidad</td>
                </tr>
                <tr>
                    <td style="border: solid; height: 50px;"></td>
                    <td></td>
                    <td style="border: solid; height: 50px;"></td>
                    <td></td>
                    <td style="border: solid; height: 50px;"></td>
                </tr>
                <tr>
                    <td style="border: solid;  height: 50px;">
                        Nombre:<br>
                        D.N.I:<br>
                        Fecha y hora:<br>
                    </td>
                    <td></td>
                    <td style="border: solid; height: 50px; vertical-align: top; padding-top: 10px">Nombre:</td>
                    <td></td>
                    <td style="border: solid;  height: 50px;">
                        Nombre:<br>
                        D.N.I:<br>
                        Fecha y hora:<br>
                    </td>
                </tr>
            </table>
            @endif
        </td>
    </tr>
    @endif
    
</table>