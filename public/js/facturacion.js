var lineasFacturacion = false, facturarDeducible = false, moneda, ccosto, total_anticipos = 0, simbolo, tiene_repuestos_pendientes = false
var deducible = 0
var imprimirTablaByp = false //solo para BYP
var anticipos_a_asociar = []

$('#addRowDetalle').click(function (e) {
    e.preventDefault();

    let cont = $($('#detalleTabla tr').last()[0]).attr('id') ? parseInt($($('#detalleTabla tr').last()[0]).attr('id').split('-')[1]) + 1 : 1
    //console.log(cont)
    $('#detalleTabla').append(`
        <tr id="newRow-${cont}">
            <td>
            <button type="button" class="btn btn-warning" onclick="$('#newRow-${cont}').remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </button>
            </td>
            <td><input id="codigoNew-${cont}" class="form-control"></td>
            <td><input id="descripcionNew-${cont}" class="form-control"></td>
            <td></td>
            <td>
                <select class="form-control" id="unidadNew-${cont}">
                    <option value="NIU">PRODUCTO</option>
                    <option value="ZZ">OTRO</option>
                </select>
            </td>
            <td></td>
            <td><input id="cantidadNew-${cont}" class="form-control"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><input id="pventaNew-${cont}" class="form-control"></td>
        </tr>
        `)
});

$('#btnAsociarAnticipo').click(function (e) {
    e.preventDefault();
    $('#anticiposModal').modal('show')
});

$('#btnAnticiposAsociados').click(function (e) {
    e.preventDefault();
    $('#anticiposAsociadosModal').modal('show')
});

$('#btnGenerarFactura').click(function (e) {
    e.preventDefault()
    let tipoVenta = $('#tipoVenta').val() || false
    let tipoOperacion = $('#tipoOperacion').val() || false

    if (tiene_repuestos_pendientes) {
        $('#formGenerarFactura').submit()
    } else if (tipoOperacion == 'VENTA' && (tipoVenta == 'B&P' || tipoVenta == 'MEC')) {
        $('#facturarModal').modal('show')
    } else {
        $('#formGenerarFactura').submit()
    }

})

$('#confirmarFactura').click(function (e) {
    e.preventDefault()
    $('#formGenerarFactura').submit()
})

$('#buscarDocumento').click(function (e) {
    e.preventDefault()

    let documento = $('#docRelacionado').val() || false,
        tipoVenta = $('#tipoVenta').val() || false

    buscarInformacion(documento, tipoVenta)
})

$('#condicionPago').change(function (e) {
    e.preventDefault();
    let fecha_emision = $('#fechaEmisionFormated').val(),
        condicionPago = parseInt($('#condicionPago').val())

    let fecha_vencimiento = new Date(fecha_emision),
        fecha_vencimiento_nueva = sumarDias(fecha_vencimiento, + condicionPago),
        fecha_final = new Date(fecha_vencimiento_nueva),
        year = fecha_final.getFullYear(),
        month = fecha_final.getMonth() + 1,
        day = fecha_final.getDate()

    month = month.toString().length == 1 ? `0${month}` : month

    $('#fechaVencimiento').val(`${day}/${month}/${year}`)
});

$('#condicionPago').change()

$('#docCliente').blur(function (e) {
    e.preventDefault();
    consultarInformacionModal($('#docCliente').val(), true)
});


$('#docRelacionado').on('keypress', function (e) {
    let length = $('#docRelacionado').val().length
    $('#docRelacionado').next().text('')
    if (e.keyCode >= 48 && e.keyCode <= 57 && length < 5) {

    } else {
        e.preventDefault()
    }
})

$('#formGenerarFactura').submit(function (e) {
    e.preventDefault();
    let tipoVenta = $('#tipoVenta').val()
    let tipoOperacion = $('#tipoOperacion').val()
    let valores = [1, 4, 5]

    /* if (tipoVenta == 'MEC' || tipoVenta == 'B&P' || tipoVenta == 'MESON') {}
    else {
        return Swal.fire(
            '¡Upps!',
            `Este tipo de venta no está disponible aún`,
            'error'
        )
    } */

    let docCliente = $('#docCliente').val() || false
    let nomCliente = $('#nomCliente').val() || false
    let direccionCliente = $('#direccionCliente').val() || false
    let telefonoCliente = $('#telefonoCliente').val() || false
    let emailCliente = $('#emailCliente').val() || false
    let metodoPago = parseInt($('#metodoPago').val()) || false

    let nroOperacion = true
    if (!$('#divNroOperacion').hasClass('d-none')) nroOperacion = $('#nroOperacion').val() || false
    let tipoTarjeta = true
    if (!$('#divTarjeta').hasClass('d-none')) tipoTarjeta = $('#tipoTarjeta').val() || false
    let entidadFinanciera = true
    if (!$('#divEntidadFinanciera').hasClass('d-none')) entidadFinanciera = $('#entidadFinanciera').val() || false

    let rebate = $('#incluirRebate').is(':checked')

    if (telefonoCliente.length < 9) {

        $('#telefonoCliente').focus()

        return Swal.fire(
            '¡Upps!',
            `Un teléfono debe tener 9 dígitos`,
            'error'
        )

    }

    if (rebate) {
        docCliente = true;
        nomCliente = true;
        direccionCliente = true;
        telefonoCliente = true;
        emailCliente = true;
    }

    if (docCliente && nomCliente && direccionCliente && telefonoCliente && emailCliente && metodoPago && nroOperacion) {
        let data = new FormData()

        data.append('tiene_repuestos_pendientes', tiene_repuestos_pendientes);
        data.append('metodoPago', $('#metodoPago').val());
        data.append('tipoTarjeta', $('#tipoTarjeta').val());
        data.append('entidadFinanciera', $('#entidadFinanciera').val());
        data.append('serie', $('#serie').val());
        data.append('documentoRelacionado', $('#docRelacionado').val())
        data.append('motivoRelacionado', $('#motivoSolFact').val())
        data.append('tipoOperacion', $('#tipoOperacion').val())
        data.append('tipoVenta', $('#tipoVenta').val())
        data.append('docCliente', $('#docCliente').val())
        data.append('nomCliente', $('#nomCliente').val())
        data.append('direccionCliente', $('#direccionCliente').val())
        data.append('telefonoCliente', $('#telefonoCliente').val())
        data.append('emailCliente', $('#emailCliente').val())
        data.append('fechaEmision', $('#fechaEmisionFormated').val())
        data.append('observaciones', $('#observaciones').val())
        data.append('condicionPago', $('#condicionPago').val())
        data.append('email', $('#emailCliente').val())
        data.append('telefono', $('#telefonoCliente').val())
        data.append('tipo_cambio', $('#tipoCambioSol').val())
        data.append('departamento', $('#departamentoIn').val())
        data.append('provincia', $('#provinciaIn').val())
        data.append('distrito', $('#distritoIn').val())
        data.append('observaciones_entregado', $('#observaciones_entregado').val())
        data.append('nro_operacion', $('#nroOperacion').val())
        data.append('anticipos_a_asociar', anticipos_a_asociar)
        if (ccosto == 'B&P') {
            data.append('deducible', $('#rbtDeducible').parent().next().text())
            data.append('montoDeducible', $('#montoDeducible').val())
            data.append('seguroOT', $('#seguroOT').val())
            data.append('seguroRUC', $('#seguroRUC').val())
            data.append('seguroRS', $('#seguroRS').val())
            data.append('seguroDir', $('#seguroDir').val())
            data.append('nro_poliza', $('#seguroPoliza').val())
            data.append('nro_siniestro', $('#seguroSiniestro').val())
        }

        if (tipoVenta == 'GARANTIAS' || tipoVenta == 'GENERAL' || tipoOperacion == 'ANTICIPO') {
            data.append('moneda', $('#monedaSol').val())
            data.append('rebate', rebate)
            let cont = $('#detalleTabla').find('tr').length
            let trs = $('#detalleTabla').find('tr')
            let id, codigoNew, descripcionNew, unidadNew, cantidadNew, pventaNew

            data.append('rows', cont)
            for (let i = 0; i < cont; i++) {
                id = $(trs[i]).attr('id').split('-')[1]

                codigoNew = $(`#codigoNew-${id}`).val() || false                
                descripcionNew = $(`#descripcionNew-${id}`).val() || false
                unidadNew = $(`#unidadNew-${id}`).val() || false
                cantidadNew = $(`#cantidadNew-${id}`).val() || false
                pventaNew = $(`#pventaNew-${id}`).val() || false

                if (codigoNew && descripcionNew && unidadNew && cantidadNew && pventaNew) {
                    data.append(`codigoNew-${i + 1}`, codigoNew)
                    data.append(`descripcionNew-${i + 1}`, descripcionNew)
                    data.append(`unidadNew-${i + 1}`, unidadNew)
                    data.append(`cantidadNew-${i + 1}`, cantidadNew)
                    data.append(`pventaNew-${i + 1}`, pventaNew)
                } else {
                    $(`#codigoNew-${id}`).focus()
                    return Swal.fire(
                        '¡Upps!',
                        `Complete los campos del detalle por favor`,
                        'error'
                    )
                }
            }

        }

        $('#btnGenerarFactura').prop('disabled', true)
        var textoAnterior = $('#btnGenerarFactura').text()
        $('#btnGenerarFactura').text('GENERANDO...')

        axios.post('./api/apiFacturaStore', data)
            .then(res => {
                let datos = res.data

                console.log(datos)

                let ruta_comprobante = datos.url
                $('#descargaC').removeClass('d-none')
                $('#descargaC').prop('href', ruta_comprobante)

                let ruta_entrega = datos.ruta_entrega
                if (datos.ruta_entrega.length) {
                    $('#descargaNE').removeClass('d-none')
                    $('#descargaNE').prop('href', ruta_entrega)
                }

                let ruta_constancia = datos.ruta_constancia
                if (datos.ruta_constancia.length) {                        
                    $('#descargaCR').removeClass('d-none')
                    $('#descargaCR').prop('href', ruta_constancia)
                }                            

                setTimeout(() => {
                                        
                    window.open(`${ruta_comprobante}`, '_blank')

                    if (datos.ruta_entrega.length) window.open(`${ruta_entrega}`, '_blank')                    

                    if (datos.ruta_constancia.length) window.open(`${ruta_constancia}`, '_blank')

                }, 3000)
                
                $('#correlativo').val(datos.correlativo)
                $('#btnGenerarFactura').addClass('d-none')
                Swal.fire(
                    'Excelente!',
                    `${datos.message}`,
                    'success'
                )

            }).catch(err => {
                $('#btnGenerarFactura').prop('disabled', false)
                $('#btnGenerarFactura').text(textoAnterior)
                Swal.fire(
                    '¡Upps!',
                    `Ocurrió un error, contacte con soporte`,
                    'error'
                )
            })
    } else {
        mensaje = '<ul>'
        if (!$('#docCliente').val()) mensaje += '<li>Ingrese el documento del cliente</li>'
        if (!$('#nomCliente').val()) mensaje += '<li>Ingrese el nombre del cliente</li>'
        if (!$('#direccionCliente').val()) mensaje += '<li>Ingrese la direccion del cliente</li>'
        if (!$('#telefonoCliente').val()) mensaje += '<li>Ingrese el telefono del cliente</li>'
        if (!$('#emailCliente').val()) mensaje += '<li>Ingrese el correo del cliente</li>'
        if (!$('#metodoPago').val()) mensaje += '<li>Seleccione el método de pago</li>'
        if (!tipoTarjeta) mensaje += '<li>Seleccione un tipo de tarjeta</li>';
        if (!entidadFinanciera) mensaje += '<li>Seleccione una entidad financiera</li>';
        if (!nroOperacion) mensaje += '<li>Ingrese el N° de Operación</li>'        
        mensaje += '</ul>'

        Swal.fire(
            '¡Upps!',
            `${mensaje}`,
            'error'
        )    
        
        
    }

});

$('#metodoPago').change(function(e) {
    e.preventDefault()
    let val = parseInt($(this).val())
    let habilitarOperacion = ['DEPOSITO', 'TRANSFERENCIA', 'TARJETA']
    let habilitarEntidad = ['DEPOSITO', 'TRANSFERENCIA']
    let validadoEntidad = false
    let validadoTarjeta = false
    let validadoOperacion = false

    validadoOperacion = pago_metodos.filter(item => {
        if (item.id_pago_metodo == val) return habilitarOperacion.includes(item.metodo_nombre)
        return false;
    })

    validadoEntidad = pago_metodos.filter(item => {
        if (item.id_pago_metodo == val) return habilitarEntidad.includes(item.metodo_nombre)
        return false;
    })

    validadoTarjeta = pago_metodos.filter(item => {
        if (item.id_pago_metodo == val) return item.metodo_nombre == 'TARJETA'
        return false;
    })
    
    if (validadoEntidad.length) {
        $('#divEntidadFinanciera').removeClass('d-none')
    }else {
        $('#divEntidadFinanciera').addClass('d-none')
        $('#tipoTarjeta').val(null)
    }

    if (validadoTarjeta.length) {
        $('#divTarjeta').removeClass('d-none')
    }else {
        $('#divTarjeta').addClass('d-none')
        $('#entidadFinanciera').val(null)        
    }

    if (validadoOperacion.length) {
        $('#divNroOperacion').removeClass('d-none')
    }else {
        $('#divNroOperacion').addClass('d-none')
    }
    
})

$('#motivoSolFact').change(function (e) {
    e.preventDefault();
    let val = $('#motivoSolFact').val()
    colocarSerie()
    if (val == 'FACTURA') {
        $('#motivoSolFact').next().val('F001')
        $('#btnGenerarFactura').text('GENERAR FACTURA')
        $('#detraccionMsg').removeClass('d-none')
    }
    else if (val == 'BOLETA') {
        $('#motivoSolFact').next().val('B001')
        $('#btnGenerarFactura').text('GENERAR BOLETA')
        $('#detraccionMsg').addClass('d-none')
    }
});

$('#placaFact').blur(function (e) {
    e.preventDefault();
    consultarInformacionModal($('#placaFact').val())
});

$('#rbtDeducible').change(function (e) {
    e.preventDefault()
    let checked = $(this).is(':checked')
    
    if (checked) {
        //console.log(`checked ${checked}`)
        imprimirTabla()
        $('#tipoOperacion').val('VENTA')
        $('#tipoOperacion').prop('disabled', false)
        $('#tipoOperacion').change()
    } else {
        $('#tipoOperacion').val('ANTICIPO')
        $('#tipoOperacion').prop('disabled', true)   
        $('#tipoOperacion').change()     
        $('#detalleTabla').html('')
        $('#detalleTabla').append(imprimirDeducibleHtml(deducible))
    }
})

$('#tipoOperacion').change(function (e) {
    e.preventDefault();
    let tipoOperacion = $('#tipoOperacion').val()

    if (tipoOperacion == 'VENTA') {
        imprimirTabla()
        $('#addRowDetalle').addClass('d-none')
        //$('#divSubmit').addClass('d-none')
        $('#btnAsociarAnticipo').removeClass('d-none')
    }
    else {
        limpiarTabla()
        //$('#addRowDetalle').removeClass('d-none')
        //$('#divSubmit').removeClass('d-none')
        $('#btnAsociarAnticipo').addClass('d-none')

        $('#detalleTabla').append(`
        <tr id="newRow-1">
            <td>
            1
            </td>
            <td><input id="codigoNew-1" class="form-control" value="ANTICIPO" readonly></td>
            <td><input id="descripcionNew-1" class="form-control text-uppercase"></td>
            <td></td>
            <td>
                <select class="form-control d-none" id="unidadNew-1">
                    <option value="NIU">PRODUCTO</option>
                    <option value="ZZ">OTRO</option>
                </select>
            </td>
            <td></td>
            <td><input id="cantidadNew-1" value="1" class="form-control d-none"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><input id="pventaNew-1" class="form-control"></td>
        </tr>
        `)
    }


});

$('#tipoVenta').change(function (e) {
    e.preventDefault()
    limpiarCajas()
    let tipoVenta = $(this).val()
    let url = `api/obtenerSerie/${tipoVenta}`

    axios.get(url).then(res => {
        let data = res.data

        colocarSerie(data.serie)
    })

    if (tipoVenta == 'B&P' || tipoVenta == 'MEC' || tipoVenta == 'MESON') {
        if (tipoVenta == 'MESON') {
            $('#divVehiculo').addClass('d-none')
            $('#lblTipoVenta').text('->NV MESÓN :')
            
        }
        else {
            $('#divVehiculo').removeClass('d-none')
            $('#lblTipoVenta').text('->OT :')
        }
        $('#tipoCambioSol').prop('readonly', true)
        $('#docRelacionado').prop('disabled', false)
        $('#buscarDocumento').prop('disabled', false)
        /* $('#monedaSol').prop('disabled', true) */
        $('#addRowDetalle').addClass('d-none')
        $('#divSubmit').addClass('d-none')
    } else {
        $('#tipoCambioSol').prop('readonly', false)
        $('#lblTipoVenta').text('')
        $('#docRelacionado').val('')
        $('#docRelacionado').prop('disabled', true)
        $('#buscarDocumento').prop('disabled', true)
        /* $('#monedaSol').prop('disabled', false) */
        $('#addRowDetalle').removeClass('d-none')
        $('#divSubmit').removeClass('d-none')
    }

    if (tipoVenta == 'GENERAL') $('#divRebate').removeClass('d-none')
    else $('#divRebate').addClass('d-none')


});

$(document).ready(function () {
    //cargarAnticipos()
});

function cargarAnticipos() {
    $('#anticiposBody').html('')
    let url = './api/listarAnticipos'

    axios.get(url).then(res => {
        let data = res.data

        data.map(item => {
            $('#anticiposBody').append(`
                <tr>
                    <td>${data.tipo_comprobante}</td>
                    <td>${data.serie}</td>
                    <td>${data.nro_comprobante}</td>
                    <td>${data.fecha_emision}</td>
                    <td>${data.total_venta}</td>
                </tr>
            `)
        })
    })
}

function limpiarCajas() {
    limpiarTabla()

    $('#divSeguro').addClass('d-none')
    $('#alertDeducible').addClass('d-none')
    $('#inputAnticipo').addClass('d-none')

    $('#tipoOperacion').prop('disabled', false)
    $('#divDetraccion').addClass('d-none')
    $('#anticipo').val('')
    $('#anticiposAsociadosBody').html('')
    $('#btnAnticiposAsociados').addClass('d-none')
    $('#divReducible').addClass('d-none')
    //$('#divReducible2').addClass('d-none')
    $('#divSubmit').addClass('d-none')
    $('#placaFact').val('')
    $('#placaFact').prop('readonly', false)
    $('#placaVin').val('')
    $('#placaMotor').val('')
    $('#placaAnio').val('')
    $('#placaColor').val('')
    $('#placaMarca').val('')
    $('#placaModelo').val('')
    $('#placaKilometraje').val('')
    $('#monedaSol').val('DOLARES')
    $('#tipoCambioSol').val('')
    $('#tipoOperacion').val('VENTA')
    /* $('#tipoVenta').val('') */
    $('#motivoEmision').val('')
    $('#docCliente').val('')
    $('#nomCliente').val('')
    $('#direccionCliente').val('')
    $('#telefonoCliente').val('')
    $('#emailCliente').val('')
    $('#vventa_total').val('')
    $('#descuento_total').val('')
    $('#subtotalvalorventa_total').val('')
    $('#impuesto_total').val('')
    $('#total').val('')
    $('#deducible').val('')

    $('#detalleRuta').addClass('d-none')
    $('#detalleRepuesto').addClass('d-none')

    $('#descargaC').addClass('d-none')
    $('#descargaC').prop('href', '')
    $('#descargaNE').addClass('d-none')
    $('#descargaNE').prop('href', '')
    $('#descargaCR').addClass('d-none')
    $('#descargaCR').prop('href', '')
    
}

function limpiarTabla() {
    $('#detalleTabla').html('')
}

limpiarTabla()

function imprimirTabla() {
    limpiarTabla()
    var contador = 0
    var simbolo = moneda == 'SOLES' ? 'S/' : '$'
    
    if (lineasFacturacion) {
        lineasFacturacion.map(linea => {
            let valor_unitario = linea.valorUnitario || linea.valor_unitario,
                valor_venta = linea.valorVenta || linea.valor_venta,
                descuento = linea.descuento || linea.descuento,
                sub_total = linea.subtotal || linea.sub_total,
                impuesto = linea.igv || linea.impuesto,
                total = linea.precioVenta || linea.total


            ++contador
            $('#detalleTabla').append(`
            <tr>
                <td>${contador}</td>
                <td>${linea.codigo}</td>
                <td>${linea.descripcion}</td>
                <td>${ccosto || linea.costo}</td>
                <td>${linea.unidad || '-'}</td>
                <td>${simbolo} ${Number(valor_unitario || 0).toFixed(2)}</td>
                <td>${Number(linea.cantidad).toFixed(2)}</td>
                <td>${simbolo} ${Number(valor_venta || 0).toFixed(2)}</td>
                <td>${simbolo} ${Number(descuento || 0).toFixed(2)}</td>
                <td>${simbolo} ${Number(sub_total || 0).toFixed(2)}</td>
                <td>${simbolo} ${Number(impuesto || 0).toFixed(2)}</td>
                <td>${simbolo} ${Number(total || 0).toFixed(2)}</td>
            </tr>
            `)
        })
    }

}

function sumarDias(fecha, dias) {
    fecha.setDate(fecha.getDate() + dias);
    return fecha;
}

function buscarInformacion(documento, tipoVenta) {
    let url, doc_Cliente
    facturarDeducible = false
    limpiarCajas()

    $('#loader').removeClass('d-none');
    $('#dataLoaded').addClass('d-none');

    /* let documento = $('#docRelacionado').val() || false,
        motivoSol = $('#motivoSolFact').val() || false,
        tipoVenta = $('#tipoVenta').val() || false,
        url */

    if (!documento) {
        return $('#docRelacionado').next().text('Seleccione un motivo e ingrese el documento')
    }

    if (tipoVenta == 'MEC' || tipoVenta == 'B&P') url = `./api/consultaInfoOT/${documento}`
    else if (tipoVenta == 'MESON') url = `./api/consultaInfoMeson/${documento}`
    else {
        return Swal.fire(
            '¡Upps!',
            `Este tipo de venta no está disponible aún`,
            'error'
        )
    }

    axios.get(url)
        .then(res => {
            $('#docRelacionado').next().text('')
            let datos = res.data, departamento, provincia, distrito
            //console.log(datos)

            if (datos.status != undefined && datos.status == 'error') {
                $('#loader').addClass('d-none');
                $('#dataLoaded').removeClass('d-none');
                return $('#docRelacionado').next().text(datos.message)

            }

            if (tipoVenta == 'MESON') {
                datos = datos[0]
                lineasFacturacion = datos.items
                moneda = datos.moneda
                simbolo = moneda == 'SOLES' ? 'S/' : '$'

                $('#emailCliente').val(datos.correo)
                $('#telefonoCliente').val(datos.telefono)
                $('#direccionCliente').val(datos.direccion)
                doc_Cliente = datos.doc_cliente
                $('#docCliente').val(doc_Cliente)
                $('#nomCliente').val(datos.nombre)

                $('#monedaSol').val(datos.moneda)
                $('#tipoCambioSol').val(Number(datos.tipo_cambio).toFixed(2))

                $('#vventa_total').val(`${simbolo} ${Number(datos.valorVenta).toFixed(2)}`)
                $('#descuento_total').val(`${simbolo} ${Number(datos.descuento).toFixed(2)}`)
                $('#subtotalvalorventa_total').val(`${simbolo} ${Number(datos.subTotalValorVenta).toFixed(2)}`)
                $('#impuesto_total').val(`${simbolo} ${Number(datos.impuesto).toFixed(2)}`)
                $('#total').val(`${simbolo} ${Number(datos.precioVenta).toFixed(2)}`)
                $('#divSubmit').removeClass('d-none')

                departamento = datos.departamento
                provincia = datos.provincia
                distrito = datos.distrito

                imprimirTabla()
            } else {
                $('#facturarLabel').text('')
                $('#facturarLabel').text(`${datos.vehiculo.placa} - OT:${documento}`)
                lineasFacturacion = datos.lineasFacturacion
                moneda = datos.moneda
                simbolo = moneda == 'SOLES' ? 'S/' : '$'
                ccosto = datos.tipo_ot
                $('#placaFact').val(datos.vehiculo.placa)
                $('#placaVin').val(datos.vehiculo.vin)
                $('#placaMotor').val(datos.vehiculo.motor)
                $('#placaAnio').val(datos.vehiculo.anho_vehiculo)
                $('#placaColor').val(datos.vehiculo.color)
                $('#placaMarca').val(datos.vehiculo.marca)
                $('#placaModelo').val(datos.vehiculo.modelo)
                $('#placaKilometraje').val(datos.vehiculo.kilometraje)
                $('#monedaSol').val(datos.moneda)
                $('#tipoCambioSol').val(Number(datos.tipoCambio).toFixed(2))
                $('#motivoEmision').val(datos.motivoEmision)
                doc_Cliente = datos.cliente.doc_cliente
                $('#docCliente').val(doc_Cliente)
                $('#nomCliente').val(datos.cliente.nomCliente)
                $('#direccionCliente').val(datos.cliente.direccion)
                $('#telefonoCliente').val(datos.cliente.celular)
                $('#emailCliente').val(datos.cliente.email)
                $('#seguroOT').val(datos.documento.id_cia_seguro)
                departamento = datos.cliente.departamento
                provincia = datos.cliente.provincia
                distrito = datos.cliente.distrito

                $('#seguroOT').change()
                $('#vventa_total').val(`${simbolo} ${Number(datos.valorVenta).toFixed(2)}`)
                $('#descuento_total').val(`${simbolo} ${Number(datos.descuento).toFixed(2)}`)
                $('#subtotalvalorventa_total').val(`${simbolo} ${Number(datos.subTotalValorVenta).toFixed(2)}`)
                $('#impuesto_total').val(`${simbolo} ${Number(datos.impuesto).toFixed(2)}`)
                $('#total').val(`${simbolo} ${Number(datos.precioVenta).toFixed(2)}`)
                $('#deducible').val(`${simbolo} ${Number(datos.documento.deducible).toFixed(2)}`)
                deducible = datos.documento.deducible
                $('#montoDeducible').val(datos.documento.deducible)


                if (datos.tipo_ot == 'B&P' && !datos.seguroParticular) {

                    
                    if (!datos.facturarSeguro && datos.deducibleFacturado) {                        
                        $('#rbtDeducible').prop('checked', true)
                        imprimirTablaByp = true
                    }else {
                        $('#rbtDeducible').prop('checked', false)
                        $('#alertDeducible').removeClass('d-none') 
                        facturarDeducible = true                        
                    }
                    //

                    $('#seguroRUC').val(datos.seguro.ruc)
                    $('#seguroRS').val(datos.seguro.razon_social)
                    $('#seguroDir').val(datos.seguro.direccion)
                    $('#seguroDepartamento').val(datos.seguro.departamento)
                    $('#seguroCiudad').val(datos.seguro.provincia)
                    $('#seguroDistrito').val(datos.seguro.distrito)
                    $('#seguroPoliza').val(datos.documento.nro_poliza)
                    $('#seguroSiniestro').val(datos.documento.nro_siniestro)

                    $('#divReducible').removeClass('d-none')
                    //$('#divReducible2').removeClass('d-none')

                    $('#detalleTabla').html('')
                    $('#detalleTabla').append(imprimirDeducibleHtml(deducible))
                }
                else {
                    $('#divReducible').addClass('d-none')
                    //$('#divReducible2').addClass('d-none')
                    imprimirTabla()
                }
                $('#divSubmit').removeClass('d-none')

                
            }


            /* PARA TODOS */
            //console.log(`departamento ${departamento}`)
            $('#departamentoIn').val(departamento)
            $('#departamentoIn').change()

            setTimeout(() => {
                //console.log(`provincia ${provincia}`)
                $('#provinciaIn').val(provincia)
                $('#provinciaIn').change()
            }, 500);
            // $('#provinciaIn').change()

            setTimeout(() => {
                //console.log(`distrito ${distrito}`)
                $('#distritoIn').val(distrito)
                //$('#distritoIn').change()
            }, 800);
            // $('#distritoIn').change()

            $('#tipoVenta').val(datos.seccion)

            if (datos.detraccion) {
                $('#motivoSolFact').change()
                $('#divDetraccion').removeClass('d-none')
            }

            if (doc_Cliente.length < 9) {
                $('#motivoSolFact').val('BOLETA')
                $('#motivoSolFact').change()
            } else if (doc_Cliente.length > 8) {
                $('#motivoSolFact').val('FACTURA')
                $('#motivoSolFact').change()
            }

            if (datos.anticipos_asociados.length) {

                $('#anticiposAsociadosBody').html('')
                $('#btnAnticiposAsociados').removeClass('d-none')
                let anticipos_asociados = datos.anticipos_asociados
                anticipos_asociados.map(item => {

                    $('#anticiposAsociadosBody').append(`
                    <tr>
                        <td>${item.tipo_comprobante}</td>
                        <td>${item.serie}</td>
                        <td>${item.nro_comprobante}</td>
                        <td>${item.fecha_emision}</td>
                        <td>${simbolo} ${item.total_venta}</td>
                    </tr>
                    `)
                })
                total_anticipos += parseFloat(datos.total_anticipos)
                $('#anticipo').val(`${simbolo} ${total_anticipos}`)
                $('#inputAnticipo').removeClass('d-none')
            }
            if (datos.ruta) {
                $('#detalleRuta').removeClass('d-none')
                $('#detalleRuta').prop('href', datos.ruta)
            }

            if (datos.tiene_repuestos_pendientes) {
                tiene_repuestos_pendientes = true
                $('#tipoOperacion').val('ANTICIPO')
                $('#tipoOperacion').change()
                let repuestos_pentiendes = datos.repuestos_pendientes
                $('#detalleRepuesto').removeClass('d-none')
                $('#repuestoPendientesBody').html('')

                repuestos_pentiendes.map(item => {
                    $('#repuestoPendientesBody').append(`
                        <tr>
                            <td>${item.codigo}</td>
                            <td>${item.descripcion}</td>
                            <td>${item.disponibilidad}</td>
                            <td>${item.cantidad}</td>
                            <td>${item.simbolo} ${Number(item.sub_total).toFixed(2)}</td>
                            <td>${item.simbolo} ${Number(item.impuesto).toFixed(2)}</td>
                            <td>${item.simbolo} ${Number(item.total).toFixed(2)}</td>
                        </tr>
                    `)
                })
            } else {
                $('#tipoOperacion').val('VENTA')
            }

            if (facturarDeducible) {
                $('#tipoOperacion').val('ANTICIPO')
                $('#tipoOperacion').prop('disabled', true)
            }
            
            if (imprimirTablaByp) $('#rbtDeducible').change()
            $('#placaFact').prop('readonly', true)
            $('#loader').addClass('d-none');
            $('#dataLoaded').removeClass('d-none');
            setSerie()

        })
        .catch(err => {
            //console.log(err)
            $('#docRelacionado').next().text('El documento ingresado no existe')
            limpiarCajas()

            $('#loader').addClass('d-none');
            $('#dataLoaded').removeClass('d-none');

        })
}

function colocarSerie(serie_val = false) {
    let tipoDocumento = $('#motivoSolFact').val(), serie, serieARetornar

    if (tipoDocumento == 'FACTURA') doc = 'F'
    else doc = 'B'

    if (serie_val) serieARetornar = doc + serie_val
    else {

        let serie_actual = $('#serie').val()
        serie_actual = doc + serie_actual.substr(1)
        serieARetornar = serie_actual
        //console.log(serie_actual)
    }

    $('#serie').val(serieARetornar)
}

function consultarInformacionModal(documento, incluirMeson = false) {
    let url = `./api/cargarPendientesFacturacion/${documento}/${incluirMeson ? `true` : ''}`

    axios.get(url).then(res => {
        if (res.data.length) {
            $('#clienteFacturacionBody').html('')
            res.data.map(item => {
                $('#clienteFacturacionBody').append(`
                <tr>
                    <td align="center">${item.seccion}</td>
                    <td align="center">
                        <a href="${item.ruta}" target="_blank">${item.documento}</a>
                    </td>
                    <td>${item.simbolo} ${item.valorVenta}</td>
                    <td>${item.simbolo} ${item.precioVenta}</td>
                    <td>
                        <button
                        type="button"
                        class="btn btn-warning"
                        onclick="seleccionarDocumento(${item.documento}, '${item.seccion}')">
                            Escoger
                        </button>
                    </td>
                </tr>
                `)
            })
            $('#clienteFacturacionModal').modal('show');
        }

    })
}

function imprimirDeducibleHtml(deducible = 0) {
    let dedu = Number(deducible).toFixed(2)
    let deducible_sin_igv = Number(deducible / 1.18).toFixed(2)
    let deducible_igv = Number(deducible_sin_igv * 0.18).toFixed(2)
    let deducible_html = `
    <tr id="newRow-1">
        <td>1</td>
        <td><input id="codigoNew-1" class="form-control" value="ANTICIPO" readonly></td>        
        <td><input id="descripcionNew-1" class="form-control" value="DEDUCIBLE" readonly></td>
        <td></td>
        <td>
            <select class="form-control" id="unidadNew-1" readonly>            
                <option value="ZZ" selected>UND</option>
            </select>
        </td>
        <td><input input="text" value="${deducible_sin_igv}" class="form-control" readonly></td>
        <td><input id="cantidadNew-1" value="1" class="form-control" readonly></td>
        <td><input input="text" value="${dedu}" class="form-control" readonly></td>
        <td><input input="text" value="0.00" class="form-control" readonly></td>
        <td><input input="text" value="${dedu}" class="form-control" readonly></td>
        <td><input input="text" value="${deducible_igv}" class="form-control" readonly></td>
        <td><input id="pventaNew-1" input="text" value="${dedu}" class="form-control" readonly></td>
    </tr>
    `
    return deducible_html
}

function recalcularAnticipo(id) {
    let val = parseFloat($(id).next().val()),
        id_anticipo = parseInt($(id).val()),
        checked = $(id).is(':checked'),
        index

    if (checked) {
        anticipos_a_asociar.push(id_anticipo)
        total_anticipos += val
    } else {
        index = anticipos_a_asociar.indexOf(id_anticipo)
        anticipos_a_asociar.splice(index, 1)
        total_anticipos -= val
    }
    console.log(anticipos_a_asociar)
    $('#anticipo').val(`${simbolo} ${total_anticipos}`)
}

function seleccionarDocumento(documento, tipoVenta) {
    $('#docRelacionado').val(documento)
    $('#tipoVenta').val(tipoVenta)
    $('#tipoVenta').change()

    buscarInformacion(documento, tipoVenta)

    $('#clienteFacturacionModal').modal('hide')
}

function setSerie() {
    let tipoVenta = $('#tipoVenta').val()
    let url = `api/obtenerSerie/${tipoVenta}`

    axios.get(url).then(res => {
        let data = res.data

        colocarSerie(data.serie)
    })
}