$(function(){

    var newOCCount=1;
    $("#detraccionSwitch").on('change',function(){
        if(this.checked){
            $("[for='detraccionSwitch']").text('Sí esta afecto');
            $(".detraccionSwitch").show();
            $('#totalDetraccion').show();
            calcDetraccion();
        }
        else{
            $("[for='detraccionSwitch']").text('No esta afecto');
            $(".detraccionSwitch").hide();
            $('#totalDetraccion').hide();
            $("#detraccion").prop('value','');
        }
    });

    $('#totalDetraccion').hide();
    $(".detraccionSwitch").hide();

    function addOCInput(){
        newOCCount++;
        console.log(newOCCount);
        let node= "<div class='form-group form-inline row' id='newOC-"+newOCCount+"'>" +
                    "<label class=\"col-sm-4 col-form-label form-control-label justify-content-end\"></label>"+
                        "<div class=\"col-sm-6 mb-2\">"+
                            "<input class=\"form-control w-100\" data-validation=\"required\" data-validation-error-msg=\"Debe ingresar un numero de OC\" data-validation-error-msg-container=\"#errorNumeroOC-" + newOCCount + "\" name=\"OC-"+newOCCount+"\" type=\"text\" value>"+
                        "</div>"+
                        "<div class=\"col-sm-2 mb-2\"><button id=\"btnEliminarNewOC-" + newOCCount + "\" type=\"button\" class=\"btn btn-warning\"><i class=\"fas fa-trash icono-btn-tabla\"></i></button></div>"+
                        "<div id=\"errorNumeroOC-"+ newOCCount +"\" class=\"col-8 validation-error-cont text-left no-gutters pr-0 justify-content-end ml-auto\"></div>" +
                    "</div>";
        $('#OCInputContainer').append(node);

        $("[id^='btnEliminarNewOC-']").on('click', function () {
            let numID = $(this).attr('id').replace(/btnEliminarNewOC-/,'');
            $("#newOC-" + numID).remove();
        });
    }

    function calcTotalProvision(){
        $baseImponible = parseFloat($('#baseImponibleInput').val()==''? 0 : $('#baseImponibleInput').val());
        $impuestos = parseFloat($('#impuestosInput').val()==''? 0 : $('#impuestosInput').val());
        $inafecto = parseFloat($('#inafectoInput').val()==''? 0 : $('#inafectoInput').val());
        $('#totalProvision').prop('value',$baseImponible+$impuestos+$inafecto);
        $("#detraccionSwitch").each(function(){
            if (this.checked) calcDetraccion();
        });
    }

    $("[id^='btnEliminarNewOC-']").on('click', function () {
        let numID = $(this).attr('id').replace(/btnEliminarNewOC-/,'');
        $("#newOC-" + numID).remove();
    });
    
    $('#btnAddLineaOCRelacionada').on('click',function(){
        addOCInput();
    });

    if ($('#tipoRegimen').val()==='Afecto'){
        $('#baseImponible').show();
        $('#impuestos').show();
        $('#inafecto').hide();
    }

    $('#tipoRegimen').on('change',function(){
        if($(this).val()==='Afecto'){
            $('#baseImponible').show();
            $('#impuestos').show();
            $('#inafecto').hide();
            $('#inafectoInput').prop('value','');
            calcTotalProvision();
        }
        else if ($(this).val()==='Afecto/Inafecto'){
            $('#baseImponible').show();
            $('#impuestos').show();
            $('#inafecto').show();
            calcTotalProvision();
        } else if($(this).val()==='Inafecto'){
            $('#baseImponible').hide();
            $('#impuestos').hide();
            $('#inafecto').show();
            $('#baseImponibleInput').prop('value','');
            $('#impuestosInput').prop('value','');
            calcTotalProvision();
        }
    });

    $('#baseImponibleInput').on('change',function(){
        $('#impuestosInput').prop('value',parseFloat($(this).val())*18/100);
        calcTotalProvision();
    });

    $('#inafectoInput').on('change',function(){
        calcTotalProvision();
    });

    function calcDetraccion(){
        $NumeroOpcion =  $('#tipo_detraccion').val()
        $porcentaje = $('#opcion-'+ $NumeroOpcion).attr('porcentaje');
        $detraccion = parseFloat($('#totalProvision').val())*$porcentaje/100;
        $('#detraccion').prop('value',$detraccion);
    }

    $('#tipo_detraccion').on('change',function(){
        calcDetraccion();
    })
});