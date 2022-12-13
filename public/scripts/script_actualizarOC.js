$(function () {

   var i = $('table tr').length;

   function init() {

      events();
      empresa_local();
      buscar_proveedor();
      enviar_datos();
      totales_repuesto();
      alert_array();
      alerts();
      buscar_repuesto();
      buscar_vehiculo();
      totales_vehiculos();
      buscar_otroproducto();

   }

   function events() {


      // CAMBIAR SIMBOLO DE MONEDAS
      var texto_moneda = $('#moneda option:selected').text();
      if (texto_moneda == 'SOLES') {
         $('.simbolo_moneda').text('S/.');
      } else {
         $('.simbolo_moneda').text('$');
      }

      $('#moneda').on('change', function () {

         var texto_moneda = $('#moneda option:selected').text();
         if (texto_moneda == 'SOLES') {
            console.log('estamos aqui');
            $('.simbolo_moneda').text('S/.');
         } else {
            console.log('no estamos aqui');

            $('.simbolo_moneda').text('$');
         }

      });

      // DESACTIVAR LA PRIMER OPCION DE LOS DESPLEGABLES (SELECCIONAR)
      $('#almacen option:eq(0)').prop('disabled', true);
      $('#moneda option:eq(0)').prop('disabled', true);
      $('#motivooc option:eq(0)').prop('disabled', true);
      $('#condicion_pago option:eq(0)').prop('disabled', true);
      $('#empresa option:eq(0)').prop('disabled', true);

      // / ********** DATEPICKER *******************/
      $('#fec_emision').datepicker({
         'format': 'dd-mm-yyyy',
         'startDate': '-7d',
         'endDate': '+0d',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es",
         'pickerPosition': 'top-right'
      });

      $('#fec_emision').click(function(){
         var popup =$(this).offset();
         var popupTop = popup.top - 40;
         $('.ui-datepicker').css({
           'top' : popupTop
          });
     });

      var almacenTexto = $('#almacen option:selected').text();
      $('#almacenTexto').val(almacenTexto);

      // GUARDAR NOMBRE DE ALMACEN PARA REDIRIGIR PANTALLAS
      $('#almacen').on('change', function () {
         var almacenTexto = $('#almacen option:selected').text();
         $('#almacenTexto').val(almacenTexto);
      });

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

   // ******************* TRAER LOS LOCALES SEGUN LA EMPRESA SELECCIONADA ***************
   function empresa_local() {

      // $('#empresa').on('change', function () {
      // CUANDO SE AGREGUEN MAS EMPRESAS A LA TABLA LOCAL_EMPRESA, AQUI IRIA EL CODIGO
      // });

      var empresa_id = $('#empresa option:selected').text();

      $.ajax({
         url: route('actualizaEmpresaLocal.data') + '?empresaName=' + empresa_id,
         type: 'GET',
         dataType: 'json',
         success: function (sucursal) {
            var old = $('#sucursal').data('old') != '' ? $('#sucursal').data('old') : '';
            $('#sucursal').empty();
            $('#sucursal').append('<option value="" disabled selected>SELECCIONAR</option>');
            $.each(sucursal, function (index, data) {
               $('#sucursal').append("<option value=' " + data.id_local + " ' " + (old == data.id_local ? 'selected' : '') + ">" + data.nombre_local) + "</option>";
               // $('#sucursal').append('<option value="' + data.id_local + '">' + data.nombre_local + '</option>');
            });
         }
      });

   }

   function buscar_proveedor() {
      var path = route('actualizar_proveedor.data');
      let outerData = [];
      $('#proveedor').typeahead({
         source: function (proveedor, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: proveedor },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.ruc;
                  })
                  )
               },
            });
         },

         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['ruc'] === item);
            html = '';
            html = '<strong>' + outerData[data]['ruc'] + '</strong>' + ' - ' + outerData[data]['nombre'];
            return html;
         },
         updater: function (item) {

            let data = Object.keys(outerData).find(key => outerData[key]['ruc'] === item);
            $('#proveedor_id').val(outerData[data]['provedorID']);
            $('#provN_contacto').val(outerData[data]['nom_contacto']);
            $('#provT_contacto').val(outerData[data]['telf_contacto']);
            $('#provE_contacto').val(outerData[data]['email_contacto']);
            $('#provD_contacto').val(outerData[data]['direccion']);
            $('#provDp_contacto').val(outerData[data]['departamento']);
            $('#provP_contacto').val(outerData[data]['provincia']);
            $('#provDd_contacto').val(outerData[data]['distrito']);
            return item;
         }

      });


   }

   function totales_repuesto() {
      $(document).on('keyup', 'table tr .repuesto', function () {

         // OBTENER EL ID DE LA ACTUAL FILA 
         var id_original = $(this).attr('id');
         var parte = id_original.split('_');
         var elementoID = parte[parte.length - 1];

         var cantidad = $('#cantidad_' + elementoID).val();
         var p_unitario = $('#precio_' + elementoID).val();
         var d_unitario = $('#descuento_' + elementoID).val();

         var costoUnitario = isNaN(p_unitario) || $.trim(p_unitario) === "" ? 0 : parseFloat(p_unitario);
         var descUnitario = isNaN(d_unitario) || $.trim(d_unitario) === "" || $.trim(d_unitario) > parseFloat(costoUnitario - 1) ? 0 : parseFloat(d_unitario);


         var sub_total = cantidad * (costoUnitario - descUnitario);
         var subtotal = isNaN(sub_total) || $.trim(sub_total) === "" ? 0 : parseFloat(sub_total);
         var imp = subtotal * 0.18;
         var impuesto = isNaN(imp) || $.trim(imp) === "" ? 0 : parseFloat(imp);
         var total = subtotal + impuesto;

         $('#subtotal_' + elementoID).val(subtotal.toFixed(2));
         $('#impuesto_' + elementoID).val(impuesto.toFixed(2));
         $('#total_' + elementoID).val(total.toFixed(2));

         // ************** SUMA TOTALES ****************

         var sum_valorVenta = 0;
         var sum_descuento = 0;

         valorVenta_array = new Array();
         $('.subtotal').each(function () {
            valorVenta_array.push($(this).val());
         });

         descuento_array = new Array();
         $('.descuento').each(function () {
            descuento_array.push($(this).val());
         });

         // *********************************************************

         $.each(valorVenta_array, function () {
            valorVenta = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
            sum_valorVenta += valorVenta;
         });

         $.each(descuento_array, function () {
            valorDescuento = isNaN(this) || $.trim(this) === "" || $.trim(this) > parseFloat(costoUnitario - 1) ? 0 : parseFloat(this);
            sum_descuento += valorDescuento;
         });

         // ********************************************************
         if (costoUnitario != '') {
            if ($('#descuento_' + elementoID).val() > parseFloat(costoUnitario - 1)) {
               toastr["warning"]("El descuento debe ser menor que el costo unitario");
               $(this).val('');
            }
         }

         $('#valor_venta').val(sum_valorVenta.toFixed(2));
         $('#descuento_final').val(sum_descuento.toFixed(2));
         $('#subtotal_final').val((sum_valorVenta - sum_descuento).toFixed(2));
         $('#impuesto_total').val((sum_valorVenta * 0.18).toFixed(2));
         $('#total_final').val((sum_valorVenta + (sum_valorVenta * 0.18)).toFixed(2));

      });

   }

   function totales_vehiculos() {
      $(document).on('keyup', 'table tr .vehiculo', function () {

         // OBTENER EL ID DE LA ACTUAL FILA 
         var id_original = $(this).attr('id');
         var parte = id_original.split('_');
         var elementoIDVN = parte[parte.length - 1];

         var p_unitario = $('#cosUnitarioVN_' + elementoIDVN).val();
         var d_unitario = $('#desUnitarioVN_' + elementoIDVN).val();

         var costoUnitario = isNaN(p_unitario) || $.trim(p_unitario) === "" ? 0 : parseFloat(p_unitario);
         var descUnitario = isNaN(d_unitario) || $.trim(d_unitario) === "" || $.trim(d_unitario) > parseFloat(costoUnitario - 1) ? 0 : parseFloat(d_unitario);

         var subtotal = costoUnitario - descUnitario;
         var impuesto = subtotal * 0.18;
         var total = subtotal + impuesto;
         $('#subTotalVN_' + elementoIDVN).val(subtotal.toFixed(2));
         $('#igvVN_' + elementoIDVN).val(impuesto.toFixed(2));
         $('#totalVN_' + elementoIDVN).val(total.toFixed(2));

         // ************** SUMA TOTALES ****************

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
            val = isNaN(this) || $.trim(this) === "" || $.trim(this) > parseFloat(costoUnitario - 1) ? 0 : parseFloat(this);
            sum_descuentoVN += val;
         });

         // ********************************************************
         if (costoUnitario != '') {
            if ($('#desUnitarioVN_' + elementoIDVN).val() > parseFloat(costoUnitario - 1)) {
               toastr["warning"]("El descuento debe ser menor que el costo unitario");
               $(this).val('');
            }
         }

         $('#valor_ventaVN').val(sum_valorVentaVN.toFixed(2));
         $('#descuento_finalVN').val(sum_descuentoVN.toFixed(2));
         $('#subtotal_finalVN').val((sum_valorVentaVN - sum_descuentoVN).toFixed(2));
         $('#impuesto_totalVN').val((sum_valorVentaVN * 0.18).toFixed(2));
         $('#total_finalVN').val((sum_valorVentaVN + (sum_valorVentaVN * 0.18)).toFixed(2));

      });

   }

   function alerts() {
      // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************

      $("#sucursal").on("change", function () {
         if ($("#sucursal-error").text() != "") {
            if ($(this).val().length) {
               $("#sucursal-error").addClass("d-none");
               $("#sucursal").removeClass("is-invalid");
            } else {
               $("#sucursal-error").removeClass("d-none");
               $("#sucursal").addClass("is-invalid");
            }
         }
      });

      $("#almacen").on("change", function () {
         if ($("#almacen-error").text() != "") {
            if ($(this).val().length) {
               $("#almacen-error").addClass("d-none");
               $("#almacen").removeClass("is-invalid");
            } else {
               $("#almacen-error").removeClass("d-none");
               $("#almacen").addClass("is-invalid");
            }
         }
      });

      $("#moneda").on("change", function () {
         if ($("#almacen-error").text() != "") {
            if ($(this).val().length) {
               $("#moneda-error").addClass("d-none");
               $("#moneda").removeClass("is-invalid");
            } else {
               $("#moneda-error").removeClass("d-none");
               $("#moneda").addClass("is-invalid");
            }
         }
      });

      $("#motivooc").on("change", function () {
         if ($("#almacen-error").text() != "") {
            if ($(this).val().length) {
               $("#motivooc-error").addClass("d-none");
               $("#motivooc").removeClass("is-invalid");
            } else {
               $("#motivooc-error").removeClass("d-none");
               $("#motivooc").addClass("is-invalid");
            }
         }
      });

      $("#condicion_pago").on("change", function () {
         if ($("#almacen-error").text() != "") {
            if ($(this).val().length) {
               $("#condicion_pago-error").addClass("d-none");
               $("#condicion_pago").removeClass("is-invalid");
            } else {
               $("#condicion_pago-error").removeClass("d-none");
               $("#condicion_pago").addClass("is-invalid");
            }
         }
      });

      $("#fec_emision").on("change", function () {
         if ($("#almacen-error").text() != "") {
            if ($(this).val().length) {
               $("#fec_emision-error").addClass("d-none");
               $("#fec_emision").removeClass("is-invalid");
            } else {
               $("#fec_emision-error").removeClass("d-none");
               $("#fec_emision").addClass("is-invalid");
            }
         }
      });

      $("#proveedor").on("keyup", function () {
         if ($("#proveedor-error").text() != "") {
            if ($(this).val().length) {
               $("#proveedor-error").addClass("d-none");
               $("#proveedor").removeClass("is-invalid");
            } else {
               $("#proveedor-error").removeClass("d-none");
               $("#proveedor").addClass("is-invalid");
            }
         }
      });

      $("#detalle_motivo").on("keyup", function () {
         if ($("#detalle_motivo-error").text() != "") {
            if ($(this).val().length) {
               $("#detalle_motivo-error").addClass("d-none");
               $("#detalle_motivo").removeClass("is-invalid");
            } else {
               $("#detalle_motivo-error").removeClass("d-none");
               $("#detalle_motivo").addClass("is-invalid");
            }
         }
      });

      $("#observaciones").on("keyup", function () {
         if ($("#observaciones-error").text() != "") {
            if ($(this).val().length) {
               $("#observaciones-error").addClass("d-none");
               $("#observaciones").removeClass("is-invalid");
            } else {
               $("#observaciones-error").removeClass("d-none");
               $("#observaciones").addClass("is-invalid");
            }
         }
      });


   }

   function alert_array() {

      // ************ ALERTAS - OTROS ALMACENES  **************
      $(document).on('keyup', '.repuesto', function () {

         var id = $(this).attr('id');

         $('#' + id).removeClass("is-invalid");
         var texto = $('#' + id).closest('td').find('div').text();
         var clase = $('#' + id).closest('td').find('div');
         var borde = $('#' + id);

         if (texto != "") {
            if ($(this).val().length) {
               clase.addClass('d-none');
               borde.removeClass('is-invalid');
            } else {
               clase.removeClass('d-none');
               borde.addClass('is-invalid');
            }
         }

      });

      // ************ ALERTAS - ALMACEN VEHICULOS NUEVOS **************

      $(document).on('keyup', '.vehiculo', function () {

         var id = $(this).attr('id');

         // $('#' + id).removeClass("is-invalid");
         var texto = $('#' + id).closest('td').find('div').text();
         var clase = $('#' + id).closest('td').find('div');
         var borde = $('#' + id);

         if (texto != "") {
            if ($(this).val().length) {
               clase.addClass('d-none');
               borde.removeClass('is-invalid');
            } else {
               clase.removeClass('d-none');
               borde.addClass('is-invalid');
            }
         }

      });

   }

   function buscar_repuesto() {

      var path = route('actualizar_repuesto.data');

      let outerData = [];
      $('.autocompletado').typeahead({

         source: function (repuesto, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: repuesto },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.cod_repuesto;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['cod_repuesto'] === item);
            html = '';
            html = '<strong>' + outerData[data]['cod_repuesto'] + '</strong>' + ' - ' + outerData[data]['nom_repuesto'];
            return html;
         },
         updater: function (item) {
            // OBTENER EL ID DE LA ACTUAL FILA
            var id_original = this.$element.attr('id');
            var parte = id_original.split('_');
            var elementoID = parte[parte.length - 1];

            let data = Object.keys(outerData).find(key => outerData[key]['cod_repuesto'] === item);
            $('#idRepuesto_' + elementoID).val(outerData[data]['idrepuesto']);
            $('#desRepuesto_' + elementoID).val(outerData[data]['nom_repuesto']);
            $('#stock_' + elementoID).val(outerData[data]['stock']);
            return item;
         },
         minLength: 3,
         items: 5,

      });
   }

   function buscar_vehiculo() {

      var path = route('actualizar_vehiculo.data');

      let outerData = [];
      $('.autocompletado2').typeahead({

         source: function (vehiculo, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: vehiculo },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.modelo;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['modelo'] === item);
            html = '';
            html = '<strong>' + outerData[data]['modelo'] + '</strong>' + ' - ' + outerData[data]['marca'];
            return html;
         },
         updater: function (item) {
            // OBTENER EL ID DE LA ACTUAL FILA
            var id_original = this.$element.attr('id');
            var parte = id_original.split('_');
            var elementoIDVN = parte[parte.length - 1];

            let data = Object.keys(outerData).find(key => outerData[key]['modelo'] === item);
            $('#idVehiculoN_' + elementoIDVN).val(outerData[data]['idvehiculo']);
            return item;
         },
         minLength: 1,
         items: 5,

      });
   }

   function buscar_otroproducto() {

      var path = route('actualizar_producto.data');

      let outerData = [];
      $('.autocompletado3').typeahead({

         source: function (repuesto, result) {
            $.ajax({
               url: path,
               data: { campo_buscar: repuesto, id: $('#almacen').val() },
               dataType: 'json',
               success: function (data) {
                  outerData = data;
                  result($.map(data, function (item) {
                     return item.codigo;
                  })
                  )
               },
            });
         },
         highlighter: function (item) {
            let data = Object.keys(outerData).find(key => outerData[key]['codigo'] === item);
            html = '';
            html = '<strong>' + outerData[data]['codigo'] + '</strong>' + ' - ' + outerData[data]['descripcion'];
            return html;
         },
         updater: function (item) {
            // OBTENER EL ID DE LA ACTUAL FILA
            var id_original = this.$element.attr('id');
            var parte = id_original.split('_');
            var elementoID = parte[parte.length - 1];

            let data = Object.keys(outerData).find(key => outerData[key]['codigo'] === item);
            $('#idRepuesto_' + elementoID).val(outerData[data]['id_producto']);
            $('#desRepuesto_' + elementoID).val(outerData[data]['descripcion']);
            $('#stock_' + elementoID).val(outerData[data]['stock']);
            return item;
         },
         minLength: 1,
         items: 5,

      });
   }

   function enviar_datos() {
      $('#form_actualizaroc').on('submit', function (event) {
         console.log(i);
         event.preventDefault();
         $.ajax({
            url: route('actualizaroc.update'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {


               if (data.errors) {

                  if (data.errors.proveedor) {
                     $('#proveedor-error').removeClass('d-none');
                     $('#proveedor').addClass('is-invalid');
                     $('#proveedor-error').html(data.errors.proveedor[0]);
                  }

                  if (data.errors.proveedorID) {
                     $('#proveedorID-error').removeClass('d-none');
                     $('#proveedor').addClass('is-invalid');
                     $('#proveedorID-error').html(data.errors.proveedorID[0]);
                  }

                  if (data.errors.almacen) {
                     $('#almacen-error').removeClass('d-none');
                     $('#almacen').addClass('is-invalid');
                     $('#almacen-error').html(data.errors.almacen[0]);
                  }

                  if (data.errors.sucursal) {
                     $('#sucursal-error').removeClass('d-none');
                     $('#sucursal').addClass('is-invalid');
                     $('#sucursal-error').html(data.errors.sucursal[0]);
                  }

                  if (data.errors.fec_emision) {
                     $('#fec_emision-error').removeClass('d-none');
                     $('#fec_emision').addClass('is-invalid');
                     $('#fec_emision-error').html(data.errors.fec_emision[0]);
                  }
                  if (data.errors.moneda) {
                     $('#moneda-error').removeClass('d-none');
                     $('#moneda').addClass('is-invalid');
                     $('#moneda-error').html(data.errors.moneda[0]);
                  }
                  if (data.errors.motivooc) {
                     $('#motivooc-error').removeClass('d-none');
                     $('#motivooc').addClass('is-invalid');
                     $('#motivooc-error').html(data.errors.motivooc[0]);
                  }
                  if (data.errors.detalle_motivo) {
                     $('#detalle_motivo-error').removeClass('d-none');
                     $('#detalle_motivo').addClass('is-invalid');
                     $('#detalle_motivo-error').html(data.errors.detalle_motivo[0]);
                  }
                  if (data.errors.condicion_pago) {
                     $('#condicion_pago-error').removeClass('d-none');
                     $('#condicion_pago').addClass('is-invalid');
                     $('#condicion_pago-error').html(data.errors.condicion_pago[0]);
                  }
                  if (data.errors.observaciones) {
                     $('#observaciones-error').removeClass('d-none');
                     $('#observaciones').addClass('is-invalid');
                     $('#observaciones-error').html(data.errors.observaciones[0]);
                  }

                  // ********** VALIDACIONES ARRAY *************

                  for (c = 0; c <= i; c++) {

                     // **************** VALIDACIONES - OTROS ALMACENES *******************

                     if (data.errors["codigo." + [c - 1]]) {
                        $('#codigo-error_' + c).removeClass('d-none');
                        $('#codigo_' + c).addClass('is-invalid');
                        $('#codigo-error_' + c).html(data.errors["codigo.0"][0]);
                     }

                     if (data.errors["id_repuesto." + [c - 1]]) {
                        $('#id_repuesto-error_' + c).removeClass('d-none');
                        $('#idRepuesto_' + c).addClass('is-invalid');
                        $('#id_repuesto-error_' + c).html(data.errors["id_repuesto.0"][0]);
                     }

                     if (data.errors["cantidad." + [c - 1]]) {
                        $('#cantidad-error_' + c).removeClass('d-none');
                        $('#cantidad_' + c).addClass('is-invalid');
                        $('#cantidad-error_' + c).html(data.errors["cantidad.0"][0]);
                     }

                     if (data.errors["costo_unitario." + [c - 1]]) {
                        $('#costo_unitario-error_' + c).removeClass('d-none');
                        $('#precio_' + c).addClass('is-invalid');
                        $('#costo_unitario-error_' + c).html(data.errors["costo_unitario.0"][0]);
                     }

                     if (data.errors["des_unitario." + [c - 1]]) {
                        $('#des_unitario-error_' + c).removeClass('d-none');
                        $('#descuento_' + c).addClass('is-invalid');
                        $('#des_unitario-error_' + c).html(data.errors["des_unitario.0"][0]);
                     }

                     if (data.errors["sub_total." + [c - 1]]) {
                        $('#subtotal-error_' + c).removeClass('d-none');
                        $('#subtotal_' + c).addClass('is-invalid');
                        $('#subtotal-error_' + c).html(data.errors["sub_total.0"][0]);
                     }

                     if (data.errors["total." + [c - 1]]) {
                        $('#total-error_' + c).removeClass('d-none');
                        $('#total_' + c).addClass('is-invalid');
                        $('#total-error_' + c).html(data.errors["total.0"][0]);
                     }

                     if (data.errors["impuesto." + [c - 1]]) {
                        $('#impuesto-error_' + c).removeClass('d-none');
                        $('#impuesto_' + c).addClass('is-invalid');
                        $('#impuesto-error_' + c).html(data.errors["impuesto.0"][0]);
                     }

                     // **************** VALIDACIONES - ALMACEN DE VEHICULOS *******************

                     if (data.errors["idVehiculoN." + [c - 1]]) {
                        $('#idVehiculoN-error_' + c).removeClass('d-none');
                        $('#modelComercialVN_' + c).addClass('is-invalid');
                        $('#idVehiculoN-error_' + c).html(data.errors["idVehiculoN.0"][0]);
                     }

                     if (data.errors["modComercial_vn." + [c - 1]]) {
                        $('#modComercial_vn-error_' + c).removeClass('d-none');
                        $('#modelComercialVN_' + c).addClass('is-invalid');
                        $('#modComercial_vn-error_' + c).html(data.errors["modComercial_vn.0"][0]);
                     }

                     if (data.errors["vin_vn." + [c - 1]]) {
                        $('#vin_vn-error_' + c).removeClass('d-none');
                        $('#vin_' + c).addClass('is-invalid');
                        $('#vin_vn-error_' + c).html(data.errors["vin_vn.0"][0]);
                     }

                     if (data.errors["numMotor_vn." + [c - 1]]) {
                        $('#numMotor_vn-error_' + c).removeClass('d-none');
                        $('#NumMotor_' + c).addClass('is-invalid');
                        $('#numMotor_vn-error_' + c).html(data.errors["numMotor_vn.0"][0]);
                     }

                     if (data.errors["year_vn." + [c - 1]]) {
                        $('#year_vn-error_' + c).removeClass('d-none');
                        $('#yearVN_' + c).addClass('is-invalid');
                        $('#year_vn-error_' + c).html(data.errors["year_vn.0"][0]);
                     }

                     if (data.errors["color_vn." + [c - 1]]) {
                        $('#color_vn-error_' + c).removeClass('d-none');
                        $('#colorVN_' + c).addClass('is-invalid');
                        $('#color_vn-error_' + c).html(data.errors["color_vn.0"][0]);
                     }

                     if (data.errors["cosUnitario_vh." + [c - 1]]) {
                        $('#cosUnitario_vh-error_' + c).removeClass('d-none');
                        $('#cosUnitarioVN_' + c).addClass('is-invalid');
                        $('#cosUnitario_vh-error_' + c).html(data.errors["cosUnitario_vh.0"][0]);
                     }

                     if (data.errors["desUnitario_vn." + [c - 1]]) {
                        $('#desUnitario_vn-error_' + c).removeClass('d-none');
                        $('#desUnitarioVN_' + c).addClass('is-invalid');
                        $('#desUnitario_vn-error_' + c).html(data.errors["desUnitario_vn.0"][0]);
                     }


                  }

               }

               if (data.success) {
                  toastr["success"]("Registro actualizado correctamente");
                  var loc = window.location;
                  window.location = loc.protocol + "/seguimientoOC";
               }

            }
         })


      });
   }





   init();






})