$(function(){
    console.log("works");
    const loadErrorsOfFields = (fields, errors) => {
        fields.forEach(field => {
            if (errors[field]) {
                $("#"+field).removeClass("is-invalid").addClass("is-invalid");
                $("#e_"+field).text(errors[field]);
                $( "#"+field).focus();
            }
        });
    }

    const cleanFields = (fields) => {
        fields.forEach(field => {
            console.log("cleaning field");
            $("#"+field).val("");
        });
    }

    $("#hojaInspeccionForm").on('submit', function (e) {
        e.preventDefault();
        let data = $(this).serialize();
        $form = $(this);
        console.log($form.attr('action'));
        $("#btn_crear_hojainspeccion").prop('disabled', true);
        $("#alert_success").hide();
        $("#alert_error").hide();
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (resp) {
                const fields = [
                    'id_recepcion_ot',
                    'modelo',
                    'ano_modelo',
                    'vin',
                    'color',
                    'destino'
                ];
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");
                if (!resp.passes) {
                    loadErrorsOfFields(fields, resp.errors);
                }else{
                    cleanFields(fields);
                    $("#"+fields[0]).focus();
                    $("#alert_success").show();
                    $("#alert_success p").text("Se registro correctamente");
                }
                $("#btn_crear_hojainspeccion").prop('disabled', false);
            },
            error: function (resp) {
                console.log(resp);
                $("#btn_crear_hojainspeccion").prop('disabled', false);
                $("#alert_error").show();
            }
        });
    });

    $("#editHojaInspeccionForm").on('submit', function(e){
        e.preventDefault();
        let data = $(this).serialize();
        $form = $(this);
        $("#btn_edit_hojainspeccion").prop('disabled', true);
        $("#alert_success").hide();
        $("#alert_error").hide();

        $.ajax({
            url: $form.attr('action'),
            type: 'PUT',
            data: data,
            dataType: 'json',
            success: function (resp) {
                const fields = [
                    'id_recepcion_ot',
                    'modelo',
                    'ano_modelo',
                    'vin',
                    'color',
                    'destino'
                ];
                $(".invalid-feedback").text("");
                $(".form-control").removeClass("is-invalid");
                if (!resp.passes) {
                    loadErrorsOfFields(fields, resp.errors);
                }else{
                    $("#"+fields[0]).focus();
                    $("#alert_success").show();
                    $("#alert_success p").text("Se edito correctamente");
                }
                $("#btn_edit_hojainspeccion").prop('disabled', false);
            },
            error: function (resp) {
                $("#btn_edit_hojainspeccion").prop('disabled', false);
                $("#alert_error").show();
            }
        });
    });
});