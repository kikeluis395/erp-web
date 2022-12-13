<style>
    html {
        margin-top: 0px
    }

</style>

<table style="width: 100%; font-size:10.5px; border-spacing: 0; border-collapse: collapse;">
    <tr>
        <td colspan="2"
            style="font-size:10px; height:25px; vertical-align: top; padding-top: 10px">
            {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td align="left"
            style="width: 50%; padding-bottom: 10px">
            <div><img src="{{ asset('assets/images/logo_planeta.jpg') }}"
                     style="height: 28px;"></div>
        </td>
        <th align="center"
            style="width: 50%">
            <div style="margin-left: 63.5%; border-style: solid; padding: 15px; width:125px; padding: 0">
                <div style="font-size: 12px">ORDEN DE TRABAJO</div>
                <div style="font-size: 20px">{{ $hojaTrabajo->id_recepcion_ot }}</div>
            </div>
        </th>
    </tr>

    <tr>
        <td style="border:solid">
            <table style="width: 100%;">
                <tr>
                    <th align="left"
                        style="width: 10%;">Placa:</th>
                    <td style="font-size: 15px"><b>{{ $hojaTrabajo->getPlacaPartida() }}</b></td>

                    <th align="left"
                        style="width: 18%;">Año Fabri.:</th>
                    <td>{{ $hojaTrabajo->vehiculo->anho_vehiculo }}</td>
                </tr>

                <tr>
                    <th align="left">Motor:</th>
                    <td>{{ $hojaTrabajo->vehiculo->motor }}</td>
                    <th align="left">Año Mod.:</th>
                    <td>{{ $hojaTrabajo->vehiculo->getAnhoModelo() }}</td>
                </tr>

                <tr>
                    <th align="left">Chasis</th>
                    <td>{{ $hojaTrabajo->vehiculo->vin }}</td>

                    <th align="left">KM Recor.:</th>
                    <td>{{ $hojaTrabajo->recepcionOT->kilometraje }} KM</td>
                </tr>
            </table>
        </td>

        <td style="border:solid">
            <table style="width: 100%;">
                <tr>
                    <th align="left"
                        style="width: 10%;">Propietario</th>
                    <td colspan="3">{{ $hojaTrabajo->cliente->getNombreCompleto() }}</td>
                </tr>

                <tr>
                    <th align="left">Documento</th>
                    <td>{{ $hojaTrabajo->getNumDocCliente() }}</td>
                </tr>

                <tr>
                    <th align="left">Dirección</th>
                    <td colspan="3">{{ $hojaTrabajo->getDireccionCliente() }}</td>
                </tr>

                <tr>
                    <th align="left">Correo</th>
                    <td colspan="3">{{ $hojaTrabajo->cliente->getCorreoClienteSplit() }}</td>

                    <th align="right">Telefono</th>
                    <td>{{ $hojaTrabajo->getTelefonoCliente() }}</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="border:solid">
            <table style="width: 100%;">
                <tr>
                    <th align="left"
                        style="width: 5%">Marca</th>
                    <td>{{ $hojaTrabajo->vehiculo->getNombreMarca() }}</td>
                </tr>

                <tr>
                    <th align="left">Modelo</th>
                    <td>{{ $hojaTrabajo->vehiculo->getNombreModeloTecnico() }}</td>
                </tr>

                <tr>
                    <th align="left">Color</th>
                    <td>{{ $hojaTrabajo->vehiculo->color }}</td>
                </tr>
            </table>
        </td>

        <td style="border:solid">
            <table style="width: 100%;">
                <tr>
                    <th align="left"
                        style="width: 5%;">Facturar a</th>
                    @if ($datosRecepcionOT->factura_para == null)
                        <td colspan="3">{{ $hojaTrabajo->contacto }}</td>
                    @else
                        <td colspan="3">{{ $datosRecepcionOT->factura_para }}</td>
                    @endif
                </tr>

                <tr>
                    <th align="left">Documento</th>
                    @if ($datosRecepcionOT->num_doc == null)
                        <td>{{ $hojaTrabajo->doc_cliente }}</td>
                    @else
                        <td>{{ $datosRecepcionOT->num_doc }}</td>
                    @endif
                </tr>

                <tr>
                    <th align="left">Dirección</th>
                    @if ($datosRecepcionOT->direccion == null)
                        <td colspan="3"></td>
                    @else
                        <td colspan="3">{{ $datosRecepcionOT->direccion }}</td>
                    @endif
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="border:solid">
            <table style="width: 100%;">
                <tr>
                    <th align="left"
                        style="width: 15.5%;">Tipo O.T.</th>
                    <td>{{ $hojaTrabajo->recepcionOT->tipoOT->nombre_tipo_ot }}</td>
                </tr>

                <tr>
                    <th align="left">Asesor</th>
                    <td style="font-size: 10px"><b>{{ $hojaTrabajo->empleado->nombreCompleto() }}</b></td>
                </tr>

                <tr>
                    <th align="left">Teléfono</th>
                    <td style="font-size: 10px"><b>{{ $hojaTrabajo->empleado->telefono_contacto }}</b></td>
                </tr>

                <tr>
                    <th align="left">Correo</th>
                    <td style="font-size: 10px"><b>{{ $hojaTrabajo->empleado->email }}</b></td>
                </tr>

                <tr>
                    <th align="left">Fec. Ing.</th>
                    <td>{{ \Carbon\Carbon::parse($hojaTrabajo->fecha_registro)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <th align="left">Hor. Ing.</th>
                    <td>{{ \Carbon\Carbon::parse($hojaTrabajo->fecha_registro)->format('H:i A') }}</td>
                </tr>
            </table>
        </td>

        <td style="border:solid">
            <table style="width: 100%;">
                <tr>
                    <th align="left"
                        style="width: 17%;">Contacto</th>
                    @if ($hojaTrabajo->contacto == null)
                        <td colspan="3">{{ $hojaTrabajo->getNombreCliente() }}</td>
                    @else
                        <td colspan="3">{{ $hojaTrabajo->contacto }}</td>
                    @endif
                </tr>

                <tr>
                    <th align="left">Telefono</th>
                    @if ($hojaTrabajo->telefono_contacto == null)
                        <td>{{ $hojaTrabajo->getTelefonoCliente() }}</td>
                    @else
                        <td>{{ $hojaTrabajo->telefono_contacto }}</td>
                    @endif
                </tr>

                <tr>
                    <th align="left">Correo</th>
                    @if ($hojaTrabajo->email_contacto == null)
                        <td colspan="3">{{ $hojaTrabajo->getCorreoCliente() }}</td>
                    @else
                        <td colspan="3">{{ $hojaTrabajo->email_contacto }}</td>
                    @endif
                </tr>

                @if ($hojaTrabajo->tipo_trabajo == 'DYP')
                    <tr>
                        <td colspan="4"
                            align="center"
                            bgcolor="666666"
                            style="vertical-align: top;">
                            <font color="#FFFFFF"><strong></strong></font>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4"
                            align="center"
                            style="height: 5px; color: white; vertical-align: top;">
                            <font><strong></strong></font>
                        </td>
                    </tr>

                    <tr>
                        <th align="left"
                            style="width: 17%;">Cia. Segr.</th>
                        <td>{{ $hojaTrabajo->recepcionOT->getNombreCiaSeguro() }}</td>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<style>
    * {
        font-family: 'sans-serif';
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

<table class="all-bordered"
       style="width: 100%; font-size:13px; margin-top: 20px; border: solid">
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>DESCRIPCIÓN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listaDetallesTrabajo as $detalleTrabajo)
            <tr>
                <td>{{ $detalleTrabajo->operacionTrabajo->cod_operacion_trabajo }}</td>
                <td>{{ $detalleTrabajo->getNombreDetalleTrabajo() }}</td>
            </tr>
        @endforeach
        @foreach ($listaServiciosTerceros as $servicioTercero)
            <tr>
                <td>{{ $servicioTercero->getCodigoServicioTercero() }}</td>
                <td>{{ $servicioTercero->getDescripcion() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table style="margin-top: 50px; font-size:13px; border: solid">
    <tr>
        <th style="padding: 20px">Observaciones</th>
        <td style="padding: 20px">
            @if ($hojaTrabajo->observaciones)
                {{ $hojaTrabajo->observaciones }}
            @else
                SIN OBSERVACIONES
            @endif
        </td>
    </tr>
</table>

<footer>
    <table style="margin-top: 50px; font-size:13px; width:100%; height: ">
        @if (true)
            <tr>
                <td colspan="2">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 100%; font-size: 10px">
                                TERMINOS LEGALES:
                                <ul style="text-align: justify">
                                    <li>En caso la facturación sea al crédito, se deberá presentar la documentación
                                        solicitada por el área de finanzas.</li>
                                    <li>Cuando el cliente no cumpla con pagar la obligación asumida por lo trabajos
                                        realizados, el vehículo permanecerá en el Centro de Servicio hasta que se
                                        realice el pago correspondiente.</li>
                                    <li>Las fechas estimadas de entrega pueden variar dependiendo de la disponibilidad
                                        de repuestos y eventuales trabajos adicionales. En ningún caso, el cliente
                                        tendrá la potestad de reclamar el pago de indemnización por daños y perjuicios
                                        bajo esta circunstancia.</li>
                                    <li>Toda reparación será cancelada en caja, antes de la entrega del vehículo. En
                                        caso de no retirarlo dentro de los dos (2) días útiles siguientes contados a
                                        partir de la fecha de haber recibido notificación de recojo o del presupuesto
                                        sin autorización de trabajo, se cobrará treinta (S/30.00) soles diarios por
                                        concepto de guardianía.</li>
                                    <li>El cliente autoriza expresamente a la Empresa a hacer uso y realizar tratamiento
                                        de los datos personales que le proporcione el envío de anuncios u ofertas
                                        comerciales, comercialización de productos y servicios, transferencia de datos
                                        personales entre las empresas del grupo.</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    @if (true)
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
                                <td style="border: solid; height: 50px; vertical-align: top; padding-top: 10px">Nombre:
                                </td>
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
</footer>
