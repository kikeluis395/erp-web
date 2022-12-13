$(function(){
    var newLineaCompraCount=0;
    function refreshTabla(type) {
        if (newLineaCompraCount>0){
            $('#tableCompras').show();
        }
        else{
            $('#tableCompras').hide();
        }

        if(type=='del'){
            $('#tableCompras').find("[id^='newLineaCompra-']").each(function(i, element) { 
                $(element).children('th').text(i+1);
            });
        }
    }

    function addLineaSolRepuesto() {
        newLineaCompraCount++;
        let node=
            "<tr id='newLineaCompra-" + newLineaCompraCount + "'>" +
                '<th scope="row">' + newLineaCompraCount + "</th>" +
                '<td align="center"><input id="codigoRepuestoIn-' + newLineaCompraCount + '" name="codigoRepuesto-' + newLineaCompraCount + '" type="text" class="form-control" style="width:75px"/></td>' +
                '<td align="center"><input id="descripcionLineaCompraIn-' + newLineaCompraCount + '" name="descripcionLineaCompra-' + newLineaCompraCount + '" type="text" class="form-control" disabled/></td>' +
                '<td align="center"><input name="cantidadLineaCompra-' + newLineaCompraCount + '" type="text" class="form-control" style="width:50px"/></td>' +
                '<td align="center"><input name="precioLineaCompra-' + newLineaCompraCount + '" type="text" class="form-control" style="width:70px"/></td>' +
                '<td><button id="btnEliminarLineaCompra-' + newLineaCompraCount + '" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
            "</tr>";
        $('#tableCompras tr:last').after(node);
        refreshTabla();

        $("[id^='btnEliminarLineaCompra-']").unbind();
        $("[id^='btnEliminarLineaCompra-']").on('click', function () {
            let numID = $(this).attr('id').replace(/btnEliminarLineaCompra-/,'');
            $("#newLineaCompra-" + numID).remove();
            newLineaCompraCount--;
            refreshTabla('del');
        });

        $("[id^='codigoRepuestoIn-']").unbind();
        $("[id^='codigoRepuestoIn-']").on('change', function () {
            let link_sub= rootURL + '/' + 'buscarRepuesto/';
            let link_completo = link_sub + $(this).val();
            let numID = $(this).attr('id').replace(/codigoRepuestoIn-/,'');

            $.get(link_completo,{},function(data,status) {
                $("#descripcionLineaCompraIn-" + numID).val(data ? data.descripcion : "NO EXISTE");
            });
        });
    }

    $("#btnAddLineaCompra").on('click',function(){
        addLineaSolRepuesto();
    });

    $('#containerOTIn').hide();
    $("#tipoIn").on('change', function () {
        if($(this).val() == 'REPUESTOS'){
            $('#containerOTIn').hide();
        }
        else if($(this).val() == 'SERVICIOS TERCEROS'){
            $('#containerOTIn').show();
        }
    });

});