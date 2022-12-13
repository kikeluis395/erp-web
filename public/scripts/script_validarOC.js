$(function () {

    function init() {
 
       events();
       enviar_dato();
    }
 
    function events() {
 
       // CAMBIAR SIMBOLO DE MONEDAS
       var texto_moneda = $('#tipo_moneda').val();
       if (texto_moneda == 'SOLES') {
          $('.simbolo_moneda').text('S/.');
       } else {
          $('.simbolo_moneda').text('$');
       }
 
       // ********************************************************************
       // **************** CALCULO DE TOTALES FINALES **********************
       // ********************************************************************
 
       var sum_valorVenta = 0;
       var sum_descuento = 0;
       // console.log('subtotales');
       valorVenta_array = new Array();
       $('.subtotal').each(function () {
          valorVenta_array.push($(this).val());
       });
 
       descuento_array = new Array();
       $('.descuento').each(function () {
          descuento_array.push($(this).val());
       });
       // ***************************************************************
       $.each(valorVenta_array, function () {
          val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
          sum_valorVenta += val;
       });
 
       $.each(descuento_array, function () {
          val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
          sum_descuento += val;
       });
 
       $('#valor_venta').val(sum_valorVenta.toFixed(2));
       $('#descuento_final').val(sum_descuento.toFixed(2));
       $('#subtotal_final').val((sum_valorVenta - sum_descuento).toFixed(2));
       $('#impuesto_total').val((sum_valorVenta * 0.18).toFixed(2));
       $('#total_final').val((sum_valorVenta + (sum_valorVenta * 0.18)).toFixed(2));
 
 
       // **************************** SUMA TOTALES - VEHICULOS NUEVOS *********************************
 
       var sum_valorVentaVN = 0;
       var sum_descuentoVN = 0;
 
       valorVentaVN_array = new Array();
       $('.subTotal_VN').each(function () {
          valorVentaVN_array.push($(this).val());
       });
 
       descuentoVN_array = new Array();
       $('.desUnitario_VN').each(function () {
          descuentoVN_array.push($(this).val());
       });
       // ------------------------------------
       $.each(valorVentaVN_array, function () {
          val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
          sum_valorVentaVN += val;
       });
 
       $.each(descuentoVN_array, function () {
          val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
          sum_descuentoVN += val;
       });
 
       $('#valor_ventaVN').val(sum_valorVentaVN.toFixed(2));
       $('#descuento_finalVN').val(sum_descuentoVN.toFixed(2));
       $('#subtotal_finalVN').val((sum_valorVentaVN - sum_descuentoVN).toFixed(2));
       $('#impuesto_totalVN').val((sum_valorVentaVN * 0.18).toFixed(2));
       $('#total_finalVN').val((sum_valorVentaVN + (sum_valorVentaVN * 0.18)).toFixed(2));
 
    }
 
    init();
 
 
    function enviar_dato() {
      $('#aprobarOCSeminuevo').on('click', function () {
 
         var id_oc = $('#idOrdenCompra').val();
         var estado = "APROBADO";
         // console.log(id_oc);

         Swal.fire({
            // title: "¿Estas seguro?",
            text: "¿Deseas aprobar esta Orden de Compra?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Si, aprobar",
            cancelButtonText: "No, Cancelar",
            customClass: {
               confirmButton: "btn btn-success  mr-3",
               cancelButton: "btn btn-secondary ",
            },
            buttonsStyling: false,
         }).then((result) => {
            if (result.value) {
               Swal.fire({
                  title: "Aprobado",
                  text: "La orden de compra fue aprobado exitosamente",
                  icon: "success",
                  showConfirmButton: false
               });

               $.ajax({
                  type: "GET",
                  dataType: "json",
                  url: route("contabilidad.visualizarOC.aprobarOC"),
                  data: { 'estado': estado, 'id_oc': id_oc },

                  success: function (data) {
                     toastr.info("Orden de Compra aprobada correctamente.");

                     // descargarPDF = ruta.protocol + "/hojaOrdenCompra?id_orden_compra=" + data.success;
                     descargarPDF = route('hojaOrdenCompraSeminuevo') + '?id_orden_compra=' + data.success,
                        window.open(descargarPDF);

                     setTimeout(function () {
                        var loc = window.location;
                        window.location = loc.protocol + "/seguimientoOC";
                     }, 400);

                  },
               });
            }
         });

      })
 
       $('#aprobarOC').on('click', function () {
 
          var id_oc = $('#idOrdenCompra').val();
          var estado = "APROBADO";
          // console.log(id_oc);
 
          Swal.fire({
             // title: "¿Estas seguro?",
             text: "¿Deseas aprobar esta Orden de Compra?",
             icon: "question",
             showCancelButton: true,
             confirmButtonText: "Si, aprobar",
             cancelButtonText: "No, Cancelar",
             customClass: {
                confirmButton: "btn btn-success  mr-3",
                cancelButton: "btn btn-secondary ",
             },
             buttonsStyling: false,
          }).then((result) => {
             if (result.value) {
                Swal.fire({
                   title: "Aprobado",
                   text: "La orden de compra fue aprobado exitosamente",
                   icon: "success",
                   showConfirmButton: false
                });
 
                $.ajax({
                   type: "GET",
                   dataType: "json",
                   url: route("contabilidad.visualizarOC.aprobarOC"),
                   data: { 'estado': estado, 'id_oc': id_oc },
 
                   success: function (data) {
                      toastr.info("Orden de Compra aprobada correctamente.");
 
                      // descargarPDF = ruta.protocol + "/hojaOrdenCompra?id_orden_compra=" + data.success;
                      descargarPDF = route('hojaOrdenCompra') + '?id_orden_compra=' + data.success,
                         window.open(descargarPDF);
 
                      setTimeout(function () {
                         var loc = window.location;
                         window.location = loc.protocol + "/seguimientoOC";
                      }, 400);
 
                   },
                });
             }
          });
 
       })
 
       $('#rechazarOC').on('click', function () {
 
          var id_oc = $('#idOrdenCompra').val();
          var estado = "RECHAZADO";
 
          Swal.fire({
             text: "¿Deseas rechazar esta Orden de Compra?",
             icon: "question",
             showCancelButton: true,
             confirmButtonText: "Si, rechazar",
             cancelButtonText: "No, Cancelar",
             customClass: {
                confirmButton: "btn btn-danger mr-3",
                cancelButton: "btn btn-secondary ",
             },
             buttonsStyling: false,
          }).then((result) => {
             if (result.value) {
                Swal.fire({
                   title: "Rechazada",
                   text: "La orden de compra fue rechazada exitosamente",
                   icon: "success",
                   showConfirmButton: false
                });
 
                $.ajax({
                   type: "GET",
                   dataType: "json",
                   url: route("contabilidad.visualizarOC.aprobarOC"),
                   data: { 'estado': estado, 'id_oc': id_oc },
 
                   success: function (data) {
                      toastr.info("Orden de Compra rechazada correctamente.");
 
                      setTimeout(function () {
                         var loc = window.location;
                         window.location = loc.protocol + "/seguimientoOC";
                      }, 400);
                   },
                });
             }
          });
 
       })
 
       $('#anularOC').on('click', function () {
 
          var id_oc = $('#idOrdenCompra').val();
          var estado = "ANULADO";
 
          Swal.fire({
             text: "¿Deseas anular esta Orden de Compra?",
             icon: "question",
             showCancelButton: true,
             confirmButtonText: "Si, Anular",
             cancelButtonText: "No, Cancelar",
             customClass: {
                confirmButton: "btn btn-danger mr-3",
                cancelButton: "btn btn-secondary ",
             },
             buttonsStyling: false,
          }).then((result) => {
             if (result.value) {
                Swal.fire({
                   title: "Anulada",
                   text: "La orden de compra fue anulada exitosamente",
                   icon: "success",
                   showConfirmButton: false
                });
 
                $.ajax({
                   type: "GET",
                   dataType: "json",
                   // url: route("contabilidad.visualizarOC.aprobarOC"),
                   data: { 'estado': estado, 'id_oc': id_oc },
 
                   success: function (data) {
                      toastr.info("Orden de Compra anulada correctamente.");
 
                      setTimeout(function () {
                         var loc = window.location;
                         window.location = loc.protocol + "/seguimientoOC";
                      }, 400);
                   },
                });
             }
          });
 
       })
 
 
    }
 
 
 })