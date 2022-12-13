$(function(){

    $("#labelPorcentaje").hide();

    $("#montoClienteSwitch").on('change',function(){
        if(this.checked){
            $("[for='montoClienteSwitch']").text('En porcentaje (%)');
            $("#labelPorcentaje").show();
            $("#costoCliente").prop("placeholder","Ingrese el porcentaje del total para deducible")
        }
        else{
            $("#costoCliente").prop("placeholder","Ingrese el monto sin IGV para deducible");
            $("#labelPorcentaje").hide();
            if($('#tipoMoneda').val()==='SOLES'){
                $("[for='montoClienteSwitch']").text('En S/.');
            }
            if($('#tipoMoneda').val()==='DOLARES'){
                $("[for='montoClienteSwitch']").text('En $');
            }
        }
    });

    $('#tipoMoneda').on('change',function(){
        if($("[for='montoClienteSwitch']").text()!='En porcentaje (%)'){
            if($(this).val()==='SOLES'){
                $("[for='montoClienteSwitch']").text('En S/.');
            }
            else if($(this).val()==='DOLARES'){
                $("[for='montoClienteSwitch']").text('En $');
            }
        }
    })

    $('#FormGenerarLiquidacion').on('submit',function(e){
        e.preventDefault();
        this.submit();
        setTimeout(function(){
            location.reload();
            $('#modalAceptarLiquidacion').modal('hide');
        },1500);
    })

    $('#FormAceptarLiquidacion').on('submit',function(e){
        e.preventDefault();
        this.submit();
        setTimeout(function(){
            location.reload();
            $('#modalAceptarLiquidacion').modal('hide');
        },1500);
    })

    $('#FormReAbrirOT').on('submit',function(e){
        $('#btnReAbrirOT').prop('disabled',true);
    })
});
