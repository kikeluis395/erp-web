$(function () {

   function init() {

      events();
      campos_dinamicos();
      buscar_proveedor();
      totales_repuesto();
      totales_vehiculos();
      enviar_datos();
      empresa_local();
      alerts();
      alert_array();
      otras_validaciones();
      validarIDRepuesto();
   }

   function events() {
      
      $( document ).ready(function() {
         let esVehiculoNuevo = $('#almacen option:selected').text();
         if(esVehiculoNuevo=="ALMACÉN DE VEHICULOS NUEVOS"){
            agregar_fila();
         }
      });

      $('#almacen').on('change', function () {
         $('#tablaDetalleOCT').addClass('d-none');
         $('#tablaDetalleOCVN').addClass('d-none');
         $('#tablaDetalleOCOP').addClass('d-none');
         $('#tablaDetalleOCVN tbody tr').remove();
         $('#tablaDetalleOCT tbody tr').remove();
         $('#tablaDetalleOCOP tbody tr').remove();
         $('#agregarFila').removeClass('d-none');
         $('#footer_totales').addClass('d-none');
         var almacenTexto = $('#almacen option:selected').text();
         $('#almacenTexto').val(almacenTexto);

         i = 2;
      });


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

      // ********** DATEPICKER *******************/
      $('#fec_emision').datepicker({
         'format': 'dd-mm-yyyy',
         'startDate': '-7d',
         'endDate': '+0d',
         'autoclose': true,
         'todayHighlight': true,
         'language': "es"
      });

      // DESACTIVAR LA PRIMER OPCION DE LOS DESPLEGABLES (SELECCIONAR)
      // $('#sucursal option:eq(0)').prop('disabled', true);
      // $('#almacen option:eq(0)').prop('disabled', true);
      // $('#moneda option:eq(0)').prop('disabled', true);
      // $('#motivooc option:eq(0)').prop('disabled', true);
      // $('#condicion_pago option:eq(0)').prop('disabled', true);
      // $('#empresa option:eq(0)').prop('disabled', true);

   }


   var i = $('table tr').length;

   function agregar_fila() {

      var count = $('table tbody tr').length;
      var texto_almacen = $('#almacen option:selected').text();

      var TablaRepuesto = texto_almacen.indexOf('REPUESTO');
      var TablaVehiculo = texto_almacen.indexOf('VEHICULO');
      var TablaOtros = texto_almacen.indexOf('SELECCIONAR');    


      if (TablaRepuesto > 0) {
         html = '<tr>';
         html += '<td>' + [count + 1] + '</td>';
         html += '<input type="hidden" name="id_repuesto[]"  id="idRepuesto_' + i + '" class="form-control form-control-sm" readonly/>';
         html += '<td class="repuesto_typeahead">';
         html += '<input type="text" maxlength="20" name="codigo[]" autocomplete="off" id="repuesto_' + i + '" class="form-control form-control-sm codigo repuesto autocompletado alfanumerico"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="codigo-error_' + i + '"></div>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="id_repuesto-error_' + i + '"></div>';
         html += '</td>';
         html += '<td><input type="text" name="descripcion" id="desRepuesto_' + i + '" class="form-control form-control-sm" readonly/></td>';
         html += '<td><input type="text" name="stock_actual" id="stock_' + i + '" class="form-control form-control-sm repuesto" readonly /></td>';
         html += '<td>';
         html += '<input type="text" maxlength="20" name="cantidad[]" id="cantidad_' + i + '" class="form-control form-control-sm repuesto numeros2 decimal" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cantidad-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="costo_unitario[]" id="precUnitario_' + i + '" class="form-control form-control-sm repuesto precio numeros2 decimal" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="costo_unitario-error_' + i + '"></div>'
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="des_unitario[]" id="desUnitario_' + i + '" class="form-control form-control-sm descuento descuento repuesto numeros2 decimal" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="des_unitario-error_' + i + '"></div>'
         html += '</td>';
         html += '<td><input type="text" name="sub_total[]" id="subtotal_' + i + '" class="form-control form-control-sm subtotal" readonly /></td>';
         html += '<td><input type="text" name="impuesto[]" id="impuesto_' + i + '" class="form-control form-control-sm impuesto" readonly /></td>';
         html += '<td><input type="text" name="total[]" id="total_' + i + '" class="form-control form-control-sm total" readonly /></td>';
         html += '<td><button type="button" name="remove" class="btn btn-warning eliminar"><i class="fas fa-trash icono-btn-tabla"></i></button></td>';
         html += '</tr>';
         $('#tablaDetalleOCT').removeClass('d-none');
         $('#footer_totales').removeClass('d-none');
         $('#tablaDetalleOCT tbody').append(html);
         i++
         buscar_repuesto();
      }

      if (TablaVehiculo > 0) {
         html = '<tr>';
         html += '<td>' + [count + 1] + '</td>';
         html += '<input type="hidden" name="idVehiculoN[]" id="idVehiculoN_' + i + '" class="form-control form-control-sm vehiculo"/>';
         html += '<td class="vehiculo_typeahead">';
         html += '<input type="text" maxlength="20" autocomplete="off" name="modComercial_vn[]" id="modelComercialVN_' + i + '" class="form-control form-control-sm vehiculo autocompletado2 alfanumerico" />';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="idVehiculoN-error_' + i + '"></div>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="modComercial_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="17" name="vin_vn[]" id="vin_' + i + '" class="form-control form-control-sm vehiculo alfanumerico"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="vin_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="numMotor_vn[]" id="NumMotor_' + i + '" class="form-control form-control-sm vehiculo alfanumerico" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="numMotor_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="4" name="year_vn[]" id="yearVN_' + i + '" class="form-control form-control-sm vehiculo numeros" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="year_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="4" name="year_vn_fabrication[]" id="yearVNFabrication_' + i + '" class="form-control form-control-sm vehiculo numeros" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="year_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="color_vn[]" id="colorVN_' + i + '" class="form-control form-control-sm vehiculo alfanumerico" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="color_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<select name="estado_stock[]"  id="estadoEstock_' + i+'" class="form-control form-control-sm" >';
         html += '<option value="FLOOR PLAN">Floor plan</option> <option value="COMODATO">Comodato</option> <option value="RESERVA DEALER">Reserva Dealer</option> </select>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="cosUnitario_vh[]" id="cosUnitarioVN_' + i + '" class="form-control form-control-sm vehiculo cosUnitarioVN numeros2 decimal" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="cosUnitario_vh-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="desUnitario_vn[]" id="desUnitarioVN_' + i + '" class="form-control form-control-sm desUnitario_VN vehiculo numeros2 decimal" autocomplete="off" />';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="desUnitario_vn-error_' + i + '"></div>';
         html += '</td>';
         html += '<td><input type="text" name="subTotal_vn[]" id="subTotalVN_' + i + '" class="form-control form-control-sm vehiculo subTotal_VN" readonly /></td>';
         html += '<td><input type="text" name="isc_vn[]" id="iscVN_' + i + '" class="form-control form-control-sm vehiculo isc_VN" readonly /></td>';
         html += '<td><input type="text" name="igv_vn[]" id="igvVN_' + i + '" class="form-control form-control-sm vehiculo igv_VN" readonly /></td>';
         html += '<td><input type="text" name="total_vn[]" id="totalVN_' + i + '" class="form-control form-control-sm vehiculo" readonly /></td>';
         html += '</tr>';
         $('#tablaDetalleOCVN').removeClass('d-none');
         $('#footer_totales').removeClass('d-none');
         $('#agregarFila').addClass('d-none');
         $('#tablaDetalleOCVN tbody').append(html);
         buscar_vehiculo();
         i++
      }

      if (TablaVehiculo == '-1' && TablaRepuesto == '-1') {
         console.log('okay');
         html = '<tr>';
         html += '<td>' + [count + 1] + '</td>';
         html += '<td class="repuesto_typeahead">';
         html += '<input type="text" maxlength="6" name="codigo[]" id="repuesto_' + i + '" class="form-control form-control-sm codigo repuesto autocompletado alfanumerico"/>';
         html += '<input type="hidden" name="id_repuesto[]" id="idRepuesto_' + i + '" class="form-control form-control-sm" readonly/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="codigo-error_' + i + '"></div>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="id_repuesto-error_' + i + '"></div>';
         html += '</td>';
         html += '<td><input type="text" name="descripcion" id="desRepuesto_' + i + '" class="form-control form-control-sm" readonly/></td>';
         html += '<td><input type="text" name="stock_actual" id="stock_' + i + '" class="form-control form-control-sm repuesto" readonly /></td>';
         html += '<td>';
         html += '<input type="text" maxlength="6" name="cantidad[]" id="cantidad_' + i + '" class="form-control form-control-sm repuesto numeros2 decimal" autocomplete="off"/>';
         html += '<div class="text-danger maxlength="6" py-0 mb-0 mt-1 d-none font-alert" id="cantidad-error_' + i + '"></div>';
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="9" name="costo_unitario[]" id="precUnitario_' + i + '" class="form-control form-control-sm repuesto precio numeros2 decimal" autocomplete="off" />';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="costo_unitario-error_' + i + '"></div>'
         html += '</td>';
         html += '<td>';
         html += '<input type="text" maxlength="6" name="des_unitario[]" id="desUnitario_' + i + '" class="form-control form-control-sm descuento descuento repuesto numeros2 decimal" autocomplete="off"/>';
         html += '<div class="text-danger py-0 mb-0 mt-1 d-none font-alert" id="des_unitario-error_' + i + '"></div>'
         html += '</td>';
         html += '<td><input type="text" name="sub_total[]" id="subtotal_' + i + '" class="form-control form-control-sm subtotal" readonly /></td>';
         html += '<td><input type="text" name="impuesto[]" id="impuesto_' + i + '" class="form-control form-control-sm impuesto" readonly /></td>';
         html += '<td><input type="text" name="total[]" id="total_' + i + '" class="form-control form-control-sm total" readonly /></td>';
         html += '<td><button type="button" name="remove" class="btn btn-warning eliminar"><i class="fas fa-trash icono-btn-tabla"></i></button></td>';
         html += '</tr>';
         $('#tablaDetalleOCOP').removeClass('d-none');
         $('#footer_totales').removeClass('d-none');
         $('#tablaDetalleOCOP tbody').append(html);
         i++
         buscar_otroproducto();
      }



      // } else if (detalleOC > 0) {

      // } else {
      //    $('#tablaDetalleOCVN tbody').append('nepe');
      // }

      // *************** PERMITIR SOLO LETRAS Y NUMEROS *******************
      $(".alfanumerico").bind('keypress', function (event) {
         var regex = new RegExp("^[a-zA-Z0-9 ]+$");
         var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
         }
      });

      $(".numeros").bind('keypress', function (event) {
         var regex = new RegExp("^[0-9]+$");
         var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
         }
      });

      $(".numeros2").bind('keypress', function (event) {
         var regex = new RegExp("^[0-9.]+$");
         var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
         }
      });

      $('.decimal').keypress(function (e) {
         var character = String.fromCharCode(e.keyCode)
         var newValue = this.value + character;
         if (isNaN(newValue) || hasDecimalPlace(newValue, 5)) {
            e.preventDefault();
            return false;
         }
      });


      function hasDecimalPlace(value, x) {
         var pointIndex = value.indexOf('.');
         return pointIndex >= 0 && pointIndex < value.length - x;
      }





   }
   function campos_dinamicos() {

      // ************** AGREGAR CAMPOS DINAMICAMENTE ******************
      $(document).on('click', '#agregarFila', agregar_fila
      );

      // ************** ELIMINAR CAMPOS DINAMICAMENTE ******************
      $(document).on('click', '.eliminar', function () {
         var count = $('table tbody tr').length;

         $(this).parents('tr').remove();

         // Comprobamos si esta vacia la tabla para ocultar la tabla
         if (count == '1') {
            $('#tablaDetalleOCT').addClass('d-none');
            $('#footer_totales').addClass('d-none');
         }

         // ASIGACIN DE INDEX
         $('table tbody tr').each(function (i) {
            $($(this).find('td')[0]).html(i + 1);
            // console.log(i);
         });
         // DISMINUIR CONTADOR PARA VALIDAR EL ARRAY DE FILAS
         i--

      });
   }


   function buscar_proveedor() {
      var path = route('buscar_proveedor.data');

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
            $('#prov_nombre').val(outerData[data]['nombre']);
            return item;
         }

      });


   }

   function buscar_repuesto() {

      var path = route('buscar_repuesto.data');

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

   function buscar_otroproducto() {

      var path = route('buscar_otroproducto.data');

      let outerData = [];
      $('.autocompletado').typeahead({

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

   function buscar_vehiculo() {

      var path = route('buscar_vehiculo.data');

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

   function totales_repuesto() {
      $(document).on('keyup', 'table tr .repuesto', function () {

         // OBTENER EL ID DE LA ACTUAL FILA 
         var id_original = $(this).attr('id');
         var parte = id_original.split('_');
         var elementoID = parte[parte.length - 1];

         var cantidad = $('#cantidad_' + elementoID).val();
         var p_unitario = $('#precUnitario_' + elementoID).val();
         var d_unitario = $('#desUnitario_' + elementoID).val();

         var costoUnitario = isNaN(p_unitario) || $.trim(p_unitario) === "" ? 0 : parseFloat(p_unitario);
         var descUnitario = isNaN(d_unitario) || $.trim(d_unitario) === "" || $.trim(d_unitario) > parseFloat(costoUnitario - 1) ? 0 : parseFloat(d_unitario);

         var sub_total = cantidad * (costoUnitario - descUnitario);
         var subtotal = isNaN(sub_total) || $.trim(sub_total) === "" ? 0 : parseFloat(sub_total);
         var impuesto = subtotal * 0.18;
         var total = subtotal + impuesto;
         // console.log(cantidad);
         $('#subtotal_' + elementoID).val(subtotal.toFixed(4));
         $('#impuesto_' + elementoID).val(impuesto.toFixed(4));
         $('#total_' + elementoID).val(total.toFixed(4));

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
         // ------------------------------------
         $.each(valorVenta_array, function () {
            val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
            sum_valorVenta += val;
         });

         $.each(descuento_array, function () {
            // val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
            val = isNaN(this) || $.trim(this) === "" || $.trim(this) > parseFloat(costoUnitario - 1) ? 0 : parseFloat(this);
            sum_descuento += val;
         });

         if (costoUnitario != '') {
            if ($('#descuento_' + elementoID).val() > parseFloat(costoUnitario - 1)) {
               toastr["warning"]("El descuento debe ser menor que el costo unitario");
               $(this).val('');
            }
         }
         var costo_inicial = sum_valorVenta+sum_descuento;
         var costo_total = costo_inicial - sum_descuento;
         $('#valor_venta').val(costo_inicial.toFixed(4));
         $('#descuento_final').val(sum_descuento.toFixed(4));
         $('#subtotal_final').val((costo_total ).toFixed(4));
         $('#impuesto_total').val(((costo_total) * 0.18).toFixed(4));
         $('#total_final').val((costo_total * 1.18).toFixed(4));


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

         var subtotal = p_unitario - d_unitario;
         var isc = subtotal * 0.10;
         var impuesto = subtotal * 1.10 * 0.18;
         var total =subtotal * 1.10 * 1.18;
         // console.log(cantidad);
         $('#subTotalVN_' + elementoIDVN).val(subtotal.toFixed(4));
         $('#iscVN_' + elementoIDVN).val(isc.toFixed(4));
         $('#igvVN_' + elementoIDVN).val(impuesto.toFixed(4));
         $('#totalVN_' + elementoIDVN).val(total.toFixed(4));

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
            val = isNaN(this) || $.trim(this) === "" ? 0 : parseFloat(this);
            sum_descuentoVN += val;
         });

         $('#valor_venta').val(sum_valorVentaVN.toFixed(4));
         $('#descuento_final').val(sum_descuentoVN.toFixed(4));
         $('#subtotal_final').val((sum_valorVentaVN - sum_descuentoVN).toFixed(4));
         $('#impuesto_total').val((sum_valorVentaVN * 0.18).toFixed(4));
         $('#total_final').val((sum_valorVentaVN + (sum_valorVentaVN * 0.18)).toFixed(4));

      });

   }

   function enviar_datos() {


      $('#form_detalleoc').on('submit', function (event) {
         console.log('enviando');
         event.preventDefault();
         $.ajax({
            url: route('contabilidad.crearOC.store'),
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {

               console.log('recibido',data);
               if (data.errors) {

                  if (data.errors.proveedor) {
                     $('#proveedor-error').removeClass('d-none');
                     $('#proveedor').addClass('is-invalid');
                     $('#proveedor-error').html(data.errors.proveedor[0]);
                  }

                  if (data.errors.proveedorID) {
                     $('#proveedor-error').removeClass('d-none');
                     $('#proveedor').addClass('is-invalid');
                     $('#proveedor-error').html(data.errors.proveedorID[0]);
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
                        $('#codigo-error_' + [c + 1]).removeClass('d-none');
                        $('#repuesto_' + [c + 1]).addClass('is-invalid');
                        $('#codigo-error_' + [c + 1]).html(data.errors["codigo.0"][0]);
                     }

                     if (data.errors["id_repuesto." + [c - 1]]) {
                        $('#id_repuesto-error_' + [c + 1]).removeClass('d-none');
                        $('#idRepuesto_' + [c + 1]).addClass('is-invalid');
                        $('#id_repuesto-error_' + [c + 1]).html(data.errors["id_repuesto.0"][0]);
                     }

                     if (data.errors["cantidad." + [c - 1]]) {
                        $('#cantidad-error_' + [c + 1]).removeClass('d-none');
                        $('#cantidad_' + [c + 1]).addClass('is-invalid');
                        $('#cantidad-error_' + [c + 1]).html(data.errors["cantidad.0"][0]);
                     }

                     if (data.errors["costo_unitario." + [c - 1]]) {
                        $('#costo_unitario-error_' + [c + 1]).removeClass('d-none');
                        $('#precUnitario_' + [c + 1]).addClass('is-invalid');
                        $('#costo_unitario-error_' + [c + 1]).html(data.errors["costo_unitario.0"][0]);
                     }

                     if (data.errors["des_unitario." + [c - 1]]) {
                        $('#des_unitario-error_' + [c + 1]).removeClass('d-none');
                        $('#desUnitario_' + [c + 1]).addClass('is-invalid');
                        $('#des_unitario-error_' + [c + 1]).html(data.errors["des_unitario.0"][0]);
                     }

                     // **************** VALIDACIONES - ALMACEN DE VEHICULOS *******************

                     if (data.errors["idVehiculoN." + [c - 1]]) {
                        $('#idVehiculoN-error_' + [c + 1]).removeClass('d-none');
                        $('#modelComercialVN_' + [c + 1]).addClass('is-invalid');
                        $('#idVehiculoN-error_' + [c + 1]).html(data.errors["idVehiculoN.0"][0]);
                     }

                     if (data.errors["modComercial_vn." + [c - 1]]) {
                        $('#modComercial_vn-error_' + [c + 1]).removeClass('d-none');
                        $('#modelComercialVN_' + [c + 1]).addClass('is-invalid');
                        $('#modComercial_vn-error_' + [c + 1]).html(data.errors["modComercial_vn.0"][0]);
                     }

                     if (data.errors["vin_vn." + [c - 1]]) {
                        $('#vin_vn-error_' + [c + 1]).removeClass('d-none');
                        $('#vin_' + [c + 1]).addClass('is-invalid');
                        $('#vin_vn-error_' + [c + 1]).html(data.errors["vin_vn.0"][0]);
                     }

                     if (data.errors["numMotor_vn." + [c - 1]]) {
                        $('#numMotor_vn-error_' + [c + 1]).removeClass('d-none');
                        $('#NumMotor_' + [c + 1]).addClass('is-invalid');
                        $('#numMotor_vn-error_' + [c + 1]).html(data.errors["numMotor_vn.0"][0]);
                     }

                     if (data.errors["year_vn." + [c - 1]]) {
                        $('#year_vn-error_' + [c + 1]).removeClass('d-none');
                        $('#yearVN_' + [c + 1]).addClass('is-invalid');
                        $('#year_vn-error_' + [c + 1]).html(data.errors["year_vn.0"][0]);
                     }

                     if (data.errors["color_vn." + [c - 1]]) {
                        $('#color_vn-error_' + [c + 1]).removeClass('d-none');
                        $('#colorVN_' + [c + 1]).addClass('is-invalid');
                        $('#color_vn-error_' + [c + 1]).html(data.errors["color_vn.0"][0]);
                     }

                     if (data.errors["cosUnitario_vh." + [c - 1]]) {
                        $('#cosUnitario_vh-error_' + [c + 1]).removeClass('d-none');
                        $('#cosUnitarioVN_' + [c + 1]).addClass('is-invalid');
                        $('#cosUnitario_vh-error_' + [c + 1]).html(data.errors["cosUnitario_vh.0"][0]);
                     }

                     if (data.errors["desUnitario_vn." + [c - 1]]) {
                        $('#desUnitario_vn-error_' + [c + 1]).removeClass('d-none');
                        $('#desUnitarioVN_' + [c + 1]).addClass('is-invalid');
                        $('#desUnitario_vn-error_' + [c + 1]).html(data.errors["desUnitario_vn.0"][0]);
                     }


                  }

               }

               if (data.success) {

                  var oc_nueva = $('#oc_nueva').val();

                  Swal.fire({
                     text: "Orden de Compra Generada N°: " + oc_nueva,
                     icon: "success",
                     showCancelButton: true,
                     confirmButtonText: "Aceptar",
                     showCancelButton: false,
                     // cancelButtonText: "No, Cancelar",
                     customClass: {
                        confirmButton: "btn btn-success  mr-3",
                        // cancelButton: "btn btn-secondary ",

                     },
                     buttonsStyling: false,
                  }).then((result) => {
                     if (result.value) {

                        toastr["success"]("Registro actualizado correctamente");
                        var loc = window.location;
                        window.location = loc.protocol + "/seguimientoOC";
                     }

                  });

               }

            }
         })


      });
   }

   // ******************* TRAER LOS LOCALES SEGUN LA EMPRESA SELECCIONADA ***************
   function empresa_local() {

      // $('#empresa').on('change', function () {
      // CUANDO SE AGREGUEN MAS EMPRESAS A LA TABLA LOCAL_EMPRESA, AQUI IRIA EL CODIGO
      // });

      var empresa_id = $('#empresa option:selected').text();

      $.ajax({
         url: route('empresa_local.data') + '?empresaName=' + empresa_id,
         type: 'GET',
         dataType: 'json',
         success: function (empresa) {
            $('#sucursal').empty();
            // $('#sucursal').append('<option value="" disabled selected hidden>SELECCIONAR</option>');
            $.each(empresa, function (index, data) {
               // $('#sucursal').append("<option value=' " + data.id_local + " ' " + (old == data.id_local ? 'selected' : '') + ">" + data.nombre_local) + "</option>";
               $('#sucursal').append('<option value="' + data.id_local + '">' + data.nombre_local + '</option>');
            });
         }
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

   function otras_validaciones() {

      $(document).on('keyup', '.descuento', function () {

         var id = $(this).attr('id');
         var inicial = parseFloat('0');

         var cosUnitario = $(this).parent().parent().find('.precio').val();

         if (cosUnitario != '') {
            if ($('#' + id).val() > parseFloat(cosUnitario - 1)) {
               toastr["warning"]("El descuento debe ser menor que el costo unitario");
               $(this).val('');
            }
         } else {
            $(this).val('');
            $('#valor_venta').val(inicial.toFixed(4));
            $('#descuento_final').val(inicial.toFixed(4));
            $('#subtotal_final').val(inicial.toFixed(4));
            $('#impuesto_total').val(inicial.toFixed(4));
            $('#total_final').val(inicial.toFixed(4));
         }

      });

      $(document).on('keyup', '.desUnitario_VN', function () {

         var id = $(this).attr('id');
         var inicial = parseFloat('0');

         var cosUnitario = $(this).parent().parent().find('.cosUnitarioVN').val();

         if (cosUnitario != '') {
            if ($('#' + id).val() > parseFloat(cosUnitario - 1)) {
               toastr["warning"]("El descuento debe ser menor que el costo unitario");
               $(this).val('');
               $('#descuento_final').val(inicial.toFixed(4));
            }
         } else {
            $(this).val('');
            $('#valor_venta').val(inicial.toFixed(4));
            $('#descuento_final').val(inicial.toFixed(4));
            $('#subtotal_final').val(inicial.toFixed(4));
            $('#impuesto_total').val(inicial.toFixed(4));
            $('#total_final').val(inicial.toFixed(4));
         }

      });


   }

   function validarIDRepuesto() {

      $(document).on('keyup', '.autocompletado', function () {

         var id = $(this).attr('id');
         var idRepuesto = $(this).parent().parent().find('.idRepuesto').attr('id');

         if ($('#' + id).text() == '') {
            $('#' + idRepuesto).val('');
         }
      });

   }


   init();



});