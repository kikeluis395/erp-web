function formatDate(date) {
    let fecha = date.split('/'),
        fecha_formateada = new Date(fecha[2], fecha[1], fecha[0])

    return fecha_formateada
}

function controlarInputs(first, second) {
    let fechaIni = $(`#${first}Ini`).val() || false,
        fechaFin = $(`#${second}Fin`).val() || false

    if (fechaIni || fechaFin) {
        $(`#${second}Ini`).prop('disabled', true)
        $(`#${second}Fin`).prop('disabled', true)
    } else {
        $(`#${second}Ini`).prop('disabled', false)
        $(`#${second}Fin`).prop('disabled', false)
    }

    $(`#${first}IniError`).text('')    
}

function submitReporteVentasTaller() {
    let fechaApIni = $('#fechaAperturaIni').val() || false,
        fechaApFin = $('#fechaAperturaFin').val() || false,
        fechaFaIni = $('#fechaFacturaIni').val() || false,
        fechaFaFin = $('#fechaFacturaFin').val() || false

    if (fechaApIni && fechaApFin) {
        fechaApIni = formatDate(fechaApIni)
        fechaApFin = formatDate(fechaApFin)

        if (fechaApIni > fechaApFin) {
            $('#fechaAperturaIniError').text('La fecha de inicio no puede ser mayor a la fecha final')   
            return false         
        }
    } else if (fechaFaIni && fechaFaFin) {
        fechaFaIni = formatDate(fechaFaIni)
        fechaFaFin = formatDate(fechaFaFin)

        if (fechaFaIni > fechaFaFin) {
            $('#fechaFacturaIniError').text('La fecha de inicio no puede ser mayor a la fecha final')   
            return false         
        }
    }

    return true
}