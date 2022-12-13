$(function(){
    var observacionesIni = $( "#observacionesIn" ).val();
    var tipoOTIni = $( "#tipoOTin" ).val();
    var monedaIni = $("#monedaHT").val();
    var seguroIni = $("#seguroSelect").val();
    var contactoIni = $('#contacto').val();
    var telfContactoIni = $('#telfContacto').val();
    var emailContactoIni = $('#correoContacto').val();
    var numColsDetalleTrabajo = $("#tablaDetallesTrabajo").find("thead tr").children().length;
    
    function setModoEdicion(nuevoModoEdicion, departamento){
        if(nuevoModoEdicion){
            $("[id^='btnEditarDetalleTrabajo']").text('Cancelar');
            $("#btnAgregarDetalleTrabajo").on('click', function () {
                addDetalleTrabajoTable(departamento);
            });
            $("#btnAgregarDetalleTrabajo").show();
            $("#btnGuardarHojaTrabajo").show();

            // $("#thEditarDetalleTrabajo").show();
            // $("[id^='tdEditarDetalleTrabajo-']").show();

            $("#thEliminarDetalleTrabajo").show();
            $("[id^='tdEliminarDetalleTrabajo-']").show();
            $("[id^='btnEliminarDetalleTrabajo-']").on('click', function () {
                let numID = $(this).attr('id').replace(/btnEliminarDetalleTrabajo-/,'');
                // MODAL DE CONFIRMACION
                // BORRADO DE DETALLE DE TRABAJO
                $("#tdDetalleTrabajo-" + numID).remove();
            });

            $( "#observacionesIn" ).attr( "disabled", false );
        }
        else{
            $("[id^='btnEditarDetalleTrabajo']").text('Editar Trabajo');
            $("#btnAgregarDetalleTrabajo").hide();
            $("#btnAgregarDetalleTrabajo").unbind();
            $("#btnGuardarHojaTrabajo").hide();
            
            $("[id^='newDetalleTrabajo-']").remove();

            // $("#thEditarDetalleTrabajo").hide();
            // $("[id^='tdEditarDetalleTrabajo-']").hide();

            $("[id^='tdEliminarDetalleTrabajo-']").hide();
            $("#thEliminarDetalleTrabajo").hide();
            $("[id^='btnEliminarDetalleTrabajo-']").unbind();
            $( "#observacionesIn" ).val(observacionesIni);
            $( "#observacionesIn" ).attr( "disabled", true );

            newDetalleTrabajoCount=0;
        }
        modoEdicion=nuevoModoEdicion;
    }

    function addDetalleTrabajoTable(departamento){
        let tipoTypeahead = (departamento == "DyP" ? "operacionesDYP" : "operacionesMEC");
        newDetalleTrabajoCount++;
        let node=
            "<tr id='newDetalleTrabajo-" + newDetalleTrabajoCount + "'>" +
                "<th scope=\"row\"></th>" +
                '<td><input form="formDetallesTrabajo" tipo="'+tipoTypeahead+'" id="inputNewDetalleTrabajoCodOp-' + newDetalleTrabajoCount + '" class="form-control typeahead" autocomplete="off" name="newDetalleTrabajoCodOp-' + newDetalleTrabajoCount + '" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" data-validation="required" data-validation-error-msg=" "></td>' +
                /*'<td><select class="selector2" tipo="'+tipoTypeahead+'" >'+
                    '<option value="">--Seleccionar Repuesto--</option>'+
                '</select></td>'+*/
                '<td><input typeahead_second_field="inputNewDetalleTrabajoCodOp-'+newDetalleTrabajoCount+'"  id="inputNewDetalleTrabajoDescripcion-' + newDetalleTrabajoCount + '" name="inputNewDetalleTrabajoDescripcion-' + newDetalleTrabajoCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>'+
                '<td class="form-group form-inline justify-content-center mb-0">' +
                '<label id="unidadDetalleTrabajoPre-'   + newDetalleTrabajoCount + '"></label>' +
                '<input id="inputNewDetalleTrabajoValor-' + newDetalleTrabajoCount + '" form="formDetallesTrabajo" name="newDetalleTrabajoValor-' + newDetalleTrabajoCount + '" data-validation="required number" data-validation-allowing="float" class="form-control" style="width: 60px; margin: 0px 5px; text-align: center;" data-validation-error-msg=" " readonly>' +
                '<label id="unidadDetalleTrabajoPost-'  + newDetalleTrabajoCount + '"></label>' +
                "</td>" +
                (numColsDetalleTrabajo > 5 ? "<td colspan=\"" + (numColsDetalleTrabajo-5 ) + "\"></th>" : "") +
                // "<td id=\"\"><button id=\"\" type=\"button\" class=\"btn btn-warning\"><i class=\"fas fa-trash icono-btn-tabla\"></i></button></td>" +
                "<td id=\"\"><button id=\"btnEliminarNewDetalleTrabajo-" + newDetalleTrabajoCount + "\" type=\"button\" class=\"btn btn-warning\"><i class=\"fas fa-trash icono-btn-tabla\"></i></button></td>" +
            "</tr>";
        $('#tablaDetallesTrabajo tr:last').after(node);
        refreshTypeaheads();
        refreshSelect2();

        $("#inputNewDetalleTrabajoCodOp-" + newDetalleTrabajoCount).on('input change typeahead:select',function() {
            var numID = $(this).attr('id').replace(/inputNewDetalleTrabajoCodOp-/,'');
            
            var arrayTiposTrabajoLibre = ["GLOBAL-HORAS-CARR","GLOBAL-HORAS-MEC","GLOBAL-PANHOS"]

            if ( $(this).val().length < 3 ) {
                $("#unidadDetalleTrabajoPre-"  + numID).text("");
                $("#inputNewDetalleTrabajoDescripcion-" + numID).val("INVALIDO");
                $("#unidadDetalleTrabajoPost-" + numID).text("");
                $("#inputNewDetalleTrabajoValor-"+ numID).val('');
                $("#inputNewDetalleTrabajoValor-"+ numID).prop('readonly', true);
                return;
            }

            var subruta = "";
            switch (departamento){
                case 'DyP':
                    subruta = "buscarOperacionTrabajoDyP";
                    break;
                case 'Mec':
                    subruta = "buscarOperacionTrabajoMec";
                    break;
            }
            var link_sub= rootURL + '/' + subruta + '/';
            var link_completo = link_sub + $(this).val();
            $.get(link_completo,{},function(data,status) {
                if(data){
                    if(data.posicion == "PRE"){
                        $("#unidadDetalleTrabajoPre-"  + numID).text(data.unidad);
                        $("#unidadDetalleTrabajoPost-" + numID).text("");
                    }
                    else if(data.posicion == "POST"){
                        $("#unidadDetalleTrabajoPre-"  + numID).text("");
                        $("#unidadDetalleTrabajoPost-" + numID).text( data.unidad );
                    }

                    if(arrayTiposTrabajoLibre.includes(data.tipo_trabajo)){
                        $("#inputNewDetalleTrabajoDescripcion-" + numID).prop('disabled', false);
                        $("#inputNewDetalleTrabajoDescripcion-" + numID).val('');
                    } else{
                        $("#inputNewDetalleTrabajoDescripcion-" + numID).val(data.descripcion);
                        $("#inputNewDetalleTrabajoDescripcion-" + numID).prop('disabled', true);
                    }
                    
                    $("#inputNewDetalleTrabajoValor-"+ numID).prop('readonly', false);

                }
                else{
                    $("#unidadDetalleTrabajoPre-"  + numID).text("");
                    $("#inputNewDetalleTrabajoDescripcion-" + numID).val("NO EXISTE");
                    $("#inputNewDetalleTrabajoValor-"+ numID).val('');
                    $("#inputNewDetalleTrabajoValor-"+ numID).prop('readonly', true);
                    $("#unidadDetalleTrabajoPost-" + numID).text("");
                    $("#inputNewDetalleTrabajoDescripcion-" + numID).prop('disabled', true);
                }
            })
        })

        $("[id^='btnEliminarNewDetalleTrabajo-']").unbind();
        $("[id^='btnEliminarNewDetalleTrabajo-']").on('click', function () {
            let numID = $(this).attr('id').replace(/btnEliminarNewDetalleTrabajo-/,'');
            $("#newDetalleTrabajo-" + numID).remove();
        });
    }

    var modoEdicion= $('#btnAgregarDetalleTrabajo').length ? true : false;
    var newDetalleTrabajoCount=0;
    var departamento = ""
    if ($("#containerDyP").length){
        departamento="DyP";
    }
    else if($("#containerMec").length){
        departamento="Mec";
    }

    setModoEdicion(modoEdicion, departamento);
    if(modoEdicion){
        addDetalleTrabajoTable(departamento);
        //addServicioTerceroTable();
    }
        

    $("[id^='btnEditarDetalleTrabajo']").on('click',function(){
        setModoEdicion(!modoEdicion, departamento);
    });


    var newLineaSolRepuestoCount=0;
    function refreshTabla(type) {
        if (newLineaSolRepuestoCount>0){
            $('#tableSolRepuesto').show();
        }
        else{
            $('#tableSolRepuesto').hide();
        }

        if(type=='del'){
            $('#tableSolRepuesto').find("[id^='newLineaSolRespuesto-']").each(function(i, element) { 
                $(element).children('th').text(i+1);
            });
        }
    }
    
    function addLineaSolRepuesto() {
        newLineaSolRepuestoCount++;
        let node=
            "<tr id='newLineaSolRespuesto-" + newLineaSolRepuestoCount + "'>" +
                "<th scope=\"row\">" + newLineaSolRepuestoCount + "</th>" +
                "<td><input name=\"descripcionLineaSolRepuesto-" + newLineaSolRepuestoCount + "\" type=\"text\" class=\"form-control\" required/></td>" + 
                "<td><input name=\"cantidadLineaSolRepuesto-" + newLineaSolRepuestoCount + "\" type=\"text\" class=\"form-control cantidadForm\" style=\"width:75px\" required/></td>" +
                "<td><button id=\"btnEliminarLineaSolRepuesto-" + newLineaSolRepuestoCount + "\" type=\"button\" class=\"btn btn-warning\"><i class=\"fas fa-trash icono-btn-tabla\"></i></button></td>" +
            "</tr>";
        $('#tableSolRepuesto tr:last').after(node);
        refreshTabla();

        $("[id^='btnEliminarLineaSolRepuesto-']").unbind();
        $("[id^='btnEliminarLineaSolRepuesto-']").on('click', function () {
            let numID = $(this).attr('id').replace(/btnEliminarLineaSolRepuesto-/,'');
            $("#newLineaSolRespuesto-" + numID).remove();
            newLineaSolRepuestoCount--;
            refreshTabla('del');
        });
        excluirCero();
    }


    function excluirCero(){
        //var myInput = document.getElementsByTagName('input')[0];
        $(".cantidadForm").keyup(function(e) {
          var key = e.keyCode || e.charCode;
          
          // si la tecla es un cero y el primer carácter es un cero
          if (key == 48 && this.value[0] == "0") {
            // se eliminan los ceros delanteros
            this.value = this.value.replace(/^0+/, '');
          }
        });
    }

    $("#btnAddLineaSolRepuesto").on('click',function(){
        addLineaSolRepuesto();
    });

    $('#btnGuardarHojaTrabajo').on('click', function (e) {
        // se limpian todos los campos que esten vacios
        $("[id^='newDetalleTrabajo-']").each(function () {
            let codigoIngresado = $(this).find("[id^='inputNewDetalleTrabajoCodOp-']").first().val().trim();
            let valorIngresado = $(this).find("[name^='newDetalleTrabajoValor-']").first().val().trim();
            if(codigoIngresado=="" && valorIngresado=="")
                $(this).remove();
        });
        //Para servicios terceros
        $("[id^='newLineaServicioTercero-']").each(function () {
            let codigoServicioTercero = $(this).find("[id^='codigoLineaServicioTercero-']").first().val().trim();
            if(codigoServicioTercero=="")
                $(this).remove();
        });
        
        // en caso no haya ningun campo por agregar y las observaciones no se hayan modificado, se evitara el envio del formulario
        let observaciones = $("#observacionesIn").val();
        let tipoOT = $("#tipoOTin").val();
        let monedaPost = $("#monedaHT").val();
        let seguroPost = $("#seguroSelect").val();
        let contacto = $('#contacto').val();
        let telfContacto = $('#telfContacto').val();
        let emailContacto = $('#correoContacto').val();
        if($("[id^='newDetalleTrabajo-']").length == 0 && $("[id^='newLineaServicioTercero-']").length == 0 && $("[id^='actualizarPVP-']").length == 0 &&
         $("[id^='actualizarProveedor-']").length == 0 && observaciones==observacionesIni  && $("[id^='inputActualizarDetalleTrabajoValor-']").length == 0 &&
         contacto==contactoIni && telfContacto == telfContactoIni && emailContacto == emailContactoIni &&
         tipoOT==tipoOTIni && monedaIni == monedaPost && seguroIni == seguroPost){
            e.preventDefault();
        }
        else{
            $(".typeahead.tt-hint").attr("data-validation","");
            $(".typeahead.tt-hint").prop("data-validation","");
            $("#formDetallesTrabajo").submit();
        }
    });

    $("[id^='btnEliminarDetalleTrabajo-']").on('click', function () {
        let numID = $(this).attr('id').replace(/btnEliminarDetalleTrabajo-/,'');
        let urlForm = $(this).closest('[id^="formEliminarDetalleTrabajo"]').attr('actionForm');
        $.ajax({
            url : urlForm,
            type: "POST",
            data: $('[name="_token"]').first().serialize() + "&" + "_method=DELETE",
            success: function (data) {
				location.reload();
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });

    

    var newServicioTerceroCount=0;
    function refreshTabla2(type) {
        if (newServicioTerceroCount>0){
            $('#tablaServiciosTerceros').show();
        }
        else{
            $('#tablaServiciosTerceros').hide();
        }

        if(type=='del'){
            $('#tablaServiciosTerceros').find("[id^='newLineaServicioTercero-']").each(function(i, element) { 
                $(element).children('th').text(i+1);
            });
        }
        refreshTypeaheads();
    }

    function addServicioTerceroTable() {
        newServicioTerceroCount++;
        let esCotizacion = $('#tablaServiciosTerceros').attr('esCotizacion');
        if(esCotizacion == "true"){
            esCotizacion = 1; 
        } else {
            esCotizacion = 0;
        }
        console.log(esCotizacion);
        let node=
            '<tr id="newLineaServicioTercero-' + newServicioTerceroCount + '">' +
                '<th scope="row">' + newServicioTerceroCount + '</th>' +
                '<td><input form="formDetallesTrabajo" class="typeahead form-control" tipo="serviciosTerceros" name="codigoLineaServicioTercero-' + newServicioTerceroCount + '" id="codigoLineaServicioTercero-' + newServicioTerceroCount + '" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;"></td>' +
                '<td><input typeahead_second_field="codigoLineaServicioTercero-' + newServicioTerceroCount + '" id="descripcionLineaServicioTercero-' + newServicioTerceroCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>' +
                (esCotizacion ? ('<td><input form="formDetallesTrabajo" name="numDocLineaServicioTercero-' + newServicioTerceroCount + '" id="numDocLineaServicioTercero-' + newServicioTerceroCount + '" class="form-control typeahead" tipo="proveedores" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" disabled></td>') : ('<td><input form="formDetallesTrabajo" name="numDocLineaServicioTercero-' + newServicioTerceroCount + '" id="numDocLineaServicioTercero-' + newServicioTerceroCount + '" class="form-control typeahead" tipo="proveedores" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;"></td>')) +
                (esCotizacion ? ('') : ('<td><input name="-' + newServicioTerceroCount + '" id="-' + newServicioTerceroCount + '" class="form-control"  style=" type="hidden" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" disabled></td>')) +
                (!esCotizacion ? ('<td><input id="pvp-' + newServicioTerceroCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>') : ('')) +
                '<td><input id="descuento-' + newServicioTerceroCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>' +
                '<td><button id="btnEliminarLineaServicioTercero-' + newServicioTerceroCount + '" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
            '</tr>';
        $('#tablaServiciosTerceros tr:last').after(node);
        refreshTabla2();

        $("[id^='btnEliminarLineaServicioTercero-']").unbind();
        $("[id^='btnEliminarLineaServicioTercero-']").on('click', function () {
            let numID = $(this).attr('id').replace(/btnEliminarLineaServicioTercero-/,'');
            $("#newLineaServicioTercero-" + numID).remove();
            newServicioTerceroCount--;
            refreshTabla2('del');
        });
    }

    $("#btnAgregarServicioTercero").on('click',function(){
        addServicioTerceroTable();
    });

    if(modoEdicion){
        addServicioTerceroTable();
    }
});
