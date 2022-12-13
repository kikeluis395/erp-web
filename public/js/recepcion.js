$(function () {
    $("#fechaTrasladoEdit").datepicker("option", "minDate", 0);

    $("#fechaTrasladoIn").datepicker("option", "minDate", 0);

    //limpieza de modal al cierre
    $("#agregarVehiculoModal, [id^='editarRecepcionModal-']").on(
        "hide.bs.modal",
        function (e) {
            $(this)
                .find("input:not(:disabled):not([type=hidden])")
                .val((i, val) => {
                    return $(this)
                        .find("input:not(:disabled):not([type=hidden])")
                        [i].getAttribute("value");
                });

            $(this)
                .find("select:not(:disabled):not([type=hidden])")
                .val((i, val) => {
                    return "";
                });

            $(this)
                .find("textarea:not(:disabled):not([type=hidden])")
                .val((i, val) => {
                    return "";
                });
        }
    );

    $("#ciaSeguroIn").change(function (e) {
        let valSeguro = $("#ciaSeguroIn").val();

        if (valSeguro == 1) {
            $("#divTipoCambioSeguro").addClass("d-none");
        } else {
            $("#divTipoCambioSeguro").removeClass("d-none");
        }
    });
});
