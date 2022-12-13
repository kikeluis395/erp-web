<table>
    <thead>
        <tr>
            <!-- A1 --> <th></th>
            <!-- B1 --> <th></th>
            <!-- C1 --> <th></th>
            <!-- D1 --> <th></th>
            <!-- E1 --> <th>RECEPCIÓN</th>
            <!-- F1 --> <th></th>
            <!-- G1 --> <th></th>
            <!-- H1 --> <th></th>
            <!-- I1 --> <th></th>
            <!-- J1 --> <th></th>
            <!-- K1 --> <th></th>
            <!-- L1 --> <th></th>
            <!-- M1 --> <th></th>
            <!-- N1 --> <th></th>
            <!-- O1 --> <th></th>
            <!-- P1 --> <th>VALUACIÓN Y APROBACIÓN</th>
            <!-- Q1 --> <th></th>
            <!-- R1 --> <th></th>
            <!-- S1 --> <th></th>
            <!-- T1 --> <th></th>
            <!-- U1 --> <th></th>
            <!-- V1 --> <th></th>
            <!-- W1 --> <th></th>
            <!-- X1 --><th></th>
            <!-- Y1 --><th></th>
            <!-- Z1 --><th></th>
            <!-- AA1 --><th>REPUESTOS</th>
            <!-- AB1 --><th></th>
            <!-- AC1 --><th></th>
            <!-- AD1 --><th></th>
            <!-- AE1 --><th></th>
            <!-- AF1 --><th></th>
            <!-- AG1 --><th>REPARACIÓN</th>
            <!-- AH1 --><th></th>
            <!-- AI1 --><th></th>
            <!-- AJ1 --><th></th>
            <!-- AK1 --><th></th>
            <!-- AL1 --><th></th>
            <!-- AM1 --><th>C.C</th>
            <!-- AN1 --><th></th>
            <!-- AO1 --><th>ENTREGA</th>
            <!-- AP1 --><th></th>
            <!-- AQ1 --><th></th>
            <!-- AR1 --><th>Días Laborales</th>
            <!-- AS1 --><th></th>
            <!-- AT1 --><th></th>
            <!-- AU1 --><th></th>
            <!-- AV1 --><th></th>
            <!-- AW1 --><th></th>
            <!-- AX1 --><th></th>
            <!-- AY1 --><th>Días Calendario</th>
            <!-- AZ1 --><th></th>
            <!-- BA1 --><th></th>
            <!-- BB1 --><th></th>
            <!-- BC1 --><th></th>
            <!-- BD1 --><th></th>
            <!-- BE1 --><th></th>
            <!-- BF1 --><th></th>
        </tr>
        <tr>
            <!-- A2 --> <th>ESTADO</th>
            <!-- B2 --> <th>CUMPLIMIENTO FECHA PROMESA DE ENTREGA</th>
            <!-- C2 --> <th>TIPO DE DAÑO</th>
            <!-- D2 --> <th>DÍAS DE ESPERA</th>
            <!-- E2 --> <th>OT</th>
            <!-- F2 --> <th>PLACA</th>
            <!-- G2 --> <th>FECHA INGRESO</th>
            <!-- H2 --> <th>ASESOR DE SERVICIO</th>
            <!-- I2 --> <th>MARCA</th>
            <!-- J2 --> <th>MODELO</th>
            <!-- K2 --> <th>CLIENTE</th>
            <!-- L2 --> <th>TELÉFONO</th>
            <!-- M2 --> <th>E-MAIL</th>
            <!-- N2 --> <th>CIA SEGUROS</th>
            <!-- O2 --> <th>FECHA TRASLADO (si aplica)</th>
            <!-- P2 --> <th>FECHA INICIO DE VALUACIÓN</th>
            <!-- Q2 --> <th>FECHA APROBACIÓN SEGURO</th>
            <!-- R2 --> <th>FECHA APROBACIÓN CLIENTE</th>
            <!-- S2 --> <th>FECHA INICIO DE VALUACIÓN (AMPLIACIÓN)</th>
            <!-- T2 --> <th>FECHA APROBACIÓN SEGURO (AMPLIACIÓN)</th>
            <!-- U2 --> <th>FECHA APROBACIÓN CLIENTE (AMPLIACIÓN)</th>
            <!-- V2 --> <th>MO APROBADA (USD) + IGV</th>
            <!-- W2 --> <th>REPUESTOS APROBADOS (USD) + IGV</th>
            <!-- X2 --> <th>HH MEC APROBADAS</th>
            <!-- Y2 --> <th>HH CAR APROBADAS</th>
            <!-- Z2 --> <th>PAÑOS APROBADOS</th>
            <!-- AA2 --><th>CANTIDAD REPUESTOS EN STOCK</th>
            <!-- AB2 --><th>FECHA DE PEDIDO REPUESTO EN STOCK</th>
            <!-- AC2 --><th>FECHA DE LLEGADA REPUESTO EN STOCK</th>
            <!-- AD2 --><th>CANTIDAD REPUESTOS EN IMPORTACIÓN</th>
            <!-- AE2 --><th>FECHA DE PEDIDO REPUESTO EN IMPORTACIÓN</th>
            <!-- AF2 --><th>FECHA DE LLEGADA REPUESTO EN IMPORTACIÓN</th>
            <!-- AG2 --><th>FECHA INICIO OPERATIVO</th>
            <!-- AH2 --><th>FECHA PROMESA DE ENTREGA</th>
            <!-- AI2 --><th>FECHA DE REPROGRAMACIÓN 1</th>
            <!-- AJ2 --><th>COMENTARIOS REPROGRAMACIÓN 1</th>
            <!-- AK2 --><th>FECHA DE REPROGRAMACIÓN 2</th>
            <!-- AL2 --><th>COMENTARIOS REPROGRAMACIÓN 2</th>
            <!-- AM2 --><th>FECHA FIN CONTROL DE CALIDAD</th>
            <!-- AN2 --><th>FECHA DE TRASLADO (si aplica)</th>
            <!-- AO2 --><th>FECHA ENTREGA</th>
            <!-- AP2 --><th></th>
            <!-- AQ2 --><th>Días del pedido en importación</th>
            <!-- AR2 --><th>Tiempo de Estancia</th>
            <!-- AS2 --><th>Tiempo de Término Operativo</th>
            <!-- AT2 --><th>Tiempo de Reparación</th>
            <!-- AU2 --><th>Espera de Asignación</th>
            <!-- AV2 --><th>Espera de Ampliación</th>
            <!-- AW2 --><th>Tiempo de Aprobación</th>
            <!-- AX2 --><th>Tiempo de Valuación</th>
            <!-- AY2 --><th>Tiempo de Estancia</th>
            <!-- AZ2 --><th>Tiempo de Término Operativo</th>
            <!-- BA2 --><th>Tiempo de Reparación</th>
            <!-- BB2 --><th>Espera de Asignación</th>
            <!-- BC2 --><th>Espera de Ampliación</th>
            <!-- BD2 --><th>Tiempo de Aprobación</th>
            <!-- BE2 --><th>Tiempo de Valuación</th>
            <!-- BF2 --><th>Cumplimiento Fecha Promesa</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recepciones as $recepcion_ot)
        <tr>
            <!-- A2  <th>ESTADO</th>--> <td>@if($recepcion_ot->estadoActual()!=[]){{$recepcion_ot->estadoActual()[0]->nombre_estado_reparacion_interno == 'entregado_hotline' ? 'ENTREGADO-HL' : $recepcion_ot->estadoActual()[0]->nombre_estado_reparacion}}@else-@endif</td>
            <!-- B2  <th>CUMPLIMIENTO FECHA PROMESA DE ENTREGA</th>--> <td>{{$recepcion_ot->cumplimientoFechaEntrega()}}</td>
            <!-- C2  <th>TIPO DE DAÑO</th>--> <td>{{$recepcion_ot->tipoDanhoTemp()}}</td>
            <!-- D2  <th>DÍAS DE ESPERA</th>--> <td>{{$recepcion_ot->cantDiasSemaforo()}}</td>
            <!-- E2  <th>OT</th>--> <td>{{$recepcion_ot->getNroOT()}}</td>
            <!-- F2  <th>PLACA</th>--> <td>{{$recepcion_ot->hojaTrabajo->placa_auto}}</td>
            <!-- G2  <th>FECHA INGRESO</th>--> <td>{{$recepcion_ot->hojaTrabajo->getFechaRecepcionFormat('d/m/Y H:i')}}</td>
            <!-- H2  <th>ASESOR DE SERVICIO</th>--> <td>{{$recepcion_ot->asesorServicio()}}</td>
            <!-- I2  <th>MARCA</th>--> <td>{{$recepcion_ot->hojaTrabajo->vehiculo->getNombreMarca()}}</td>
            <!-- J2  <th>MODELO</th>--> <td>{{$recepcion_ot->hojaTrabajo->getModeloVehiculo()}}</td>
            <!-- K2  <th>CLIENTE</th>--> <td>{{$recepcion_ot->hojaTrabajo->getNombreCliente()}}</td>
            <!-- L2  <th>TELÉFONO</th>--> <td>{{$recepcion_ot->hojaTrabajo->getTelefonoCliente()}}</td>
            <!-- M2  <th>E-MAIL</th>--> <td>{{$recepcion_ot->hojaTrabajo->getCorreoCliente()}}</td>
            <!-- N2  <th>CIA SEGUROS</th>--> <td>{{$recepcion_ot->getNombreCiaSeguro()}}</td>
            <!-- O2  <th>FECHA TRASLADO (si aplica)</th>--> <td>{{$recepcion_ot->fechaTrasladoCarbon()}}</td>
            <!-- P2  <th>FECHA INICIO DE VALUACIÓN</th>--> <td>{{$recepcion_ot->fechaValuacionCarbon()}}</td>
            <!-- Q2  <th>FECHA APROBACIÓN SEGURO</th>--> <td>{{$recepcion_ot->fechaAprobacionSeguro()}}</td>
            <!-- R2  <th>FECHA APROBACIÓN CLIENTE</th>--> <td>{{$recepcion_ot->fechaAprobacionCliente()}}</td>
            <!-- S2  <th>FECHA INICIO DE VALUACIÓN (AMPLIACIÓN)</th>--> <td>{{$recepcion_ot->fechaValuacionAmpliacionCarbon()}}</td>
            <!-- T2  <th>FECHA APROBACIÓN SEGURO (AMPLIACIÓN)</th>--> <td>{{$recepcion_ot->fechaAprobacionSeguroAmpliacion()}}</td>
            <!-- U2  <th>FECHA APROBACIÓN CLIENTE (AMPLIACIÓN)</th>--> <td>{{$recepcion_ot->fechaAprobacionClienteAmpliacion()}}</td>
            <!-- V2  <th>MO APROBADA (USD) + IGV</th>--> <td>{{$recepcion_ot->moAprobada()}}</td>
            <!-- W2  <th>REPUESTOS APROBADOS (USD) + IGV</th>--> <td>{{$recepcion_ot->repuestosAprobados()}}</td>
            <!-- X2  <th>HH MEC APROBADAS</th>--> <td>{{$recepcion_ot->hhMecAprobados()}}</td>
            <!-- Y2  <th>HH CAR APROBADAS</th>--> <td>{{$recepcion_ot->hhCarrAprobados()}}</td>
            <!-- Z2  <th>PAÑOS APROBADOS</th>--> <td>{{$recepcion_ot->panhosAprobados()}}</td>
            <!-- AA2 <th>CANTIDAD REPUESTOS EN STOCK</th> --><td>{{$recepcion_ot->nroRepuestosStock()}}</td>
            <!-- AB2 <th>FECHA DE PEDIDO REPUESTO EN STOCK</th> --><td>{{$recepcion_ot->fechaPedidoRptoStock()}}</td>
            <!-- AC2 <th>FECHA DE LLEGADA REPUESTO EN STOCK</th> --><td>{{$recepcion_ot->fechaLlegadaRptoStock()}}</td>
            <!-- AD2 <th>CANTIDAD REPUESTOS EN IMPORTACIÓN</th> --><td>{{$recepcion_ot->nroRepuestosHotline()}}</td>
            <!-- AE2 <th>FECHA DE PEDIDO REPUESTO EN IMPORTACIÓN</th> --><td>{{$recepcion_ot->fechaPedidoRptoImportacion()}}</td>
            <!-- AF2 <th>FECHA DE LLEGADA REPUESTO EN IMPORTACIÓN</th --><td>{{$recepcion_ot->fechaLlegadaRptoImportacion()}}</td>
            <!-- AG2 <th>FECHA INICIO OPERATIVO</th> --><td>{{$recepcion_ot->fechaInicioOperativo()}}</td>
            <!-- AH2 <th>FECHA PROMESA DE ENTREGA</th> --><td>{{$recepcion_ot->fechaPromesaEntregaCarbon()}}</td>
            <!-- AI2 <th>FECHA DE REPROGRAMACIÓN 1</th> --><td>{{$recepcion_ot->fechaReprogramacion1Carbon()}}</td>
            <!-- AJ2 <th>COMENTARIOS REPROGRAMACIÓN 1</th> --><td>{{$recepcion_ot->comentariosReprogramacion1()}}</td>
            <!-- AK2 <th>FECHA DE REPROGRAMACIÓN 2</th> --><td>{{$recepcion_ot->fechaReprogramacion2Carbon()}}</td>
            <!-- AL2 <th>COMENTARIOS REPROGRAMACIÓN 2</th> --><td>{{$recepcion_ot->comentariosReprogramacion2()}}</td>
            <!-- AM2 <th>FECHA FIN CONTROL DE CALIDAD</th> --><td>{{$recepcion_ot->fechaTerminoOperativo()}}</td>
            <!-- AN2 <th>FECHA DE TRASLADO (si aplica)</th> --><td>{{$recepcion_ot->fechaTrasladoCC()}}</td>
            <!-- AO2 <th>FECHA ENTREGA</th> --><td>{{$recepcion_ot->fechaEntregado()}}</td>
            <!-- AP2 <th></th> -->
            <!-- AQ2 <th>Días del pedido en importación</th> -->
            <!-- AR2 <th>Tiempo de Estancia</th> -->
            <!-- AS2 <th>Tiempo de Término Operativo</th> -->
            <!-- AT2 <th>Tiempo de Reparación</th> -->
            <!-- AU2 <th>Espera de Asignación</th> -->
            <!-- AV2 <th>Espera de Ampliación</th> -->
            <!-- AW2 <th>Tiempo de Aprobación</th> -->
            <!-- AX2 <th>Tiempo de Valuación</th> -->
            <!-- AY2 <th>Tiempo de Estancia</th> -->
            <!-- AZ2 <th>Tiempo de Término Operativo</th> -->
            <!-- BA2 <th>Tiempo de Reparación</th> -->
            <!-- BB2 <th>Espera de Asignación</th> -->
            <!-- BC2 <th>Espera de Ampliación</th> -->
            <!-- BD2 <th>Tiempo de Aprobación</th> -->
            <!-- BE2 <th>Tiempo de Valuación</th> -->
            <!-- BF2 <th>Cumplimiento Fecha Promesa</th> -->
        </tr>
    @endforeach
    </tbody>
</table>
