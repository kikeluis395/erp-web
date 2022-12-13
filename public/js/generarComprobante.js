$(document).ready(function(){

    $('#tipoOperacion').on('change', function(){
        var tipo = $('#tipoOperacion').val();

        if(tipo === "OC"){
            $('#labelInputOperacion').html('Ingrese OT:');
            $('#divInputOperacion').show();

        } else if(tipo === "VOR"){
            $('#labelInputOperacion').html('Ingrese Cotización:');
            $('#divInputOperacion').show();

        } else if(tipo === "Anticipo"){
            $('#divInputOperacion').hide();

        }
    })

});s