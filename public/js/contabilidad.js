$(document).ready(function () {

   $('#filtroRucProveedor.typeahead').parent('.twitter-typeahead').addClass("col-sm-6");

   $('#tipoOperacion').on('change', function () {

      $('#filtroRucProveedor.typeahead').parent('.twitter-typeahead').addClass("col-sm-6");

      var tipo = $('#tipoOperacion').val();

      if (tipo === "OC") {
         $('#labelInputOperacion').html('Ingrese OT:');
         $('#divInputOperacion').show();

      } else if (tipo === "VOR") {
         $('#labelInputOperacion').html('Ingrese Cotización:');
         $('#divInputOperacion').show();

      } else if (tipo === "Anticipo") {
         $('#divInputOperacion').hide();

      }
   });

   function changeMotivo(tipo) {
      if (tipo === "COMPRAS" || tipo === "REPUESTOS") {
         $('#labelDocumentoSol').html('OC:');
         $("#docRelacionado").prop('disabled', false);
         $("#docProveedorSol").prop('disabled', true)
         $($("#docProveedorSol").parent().children()[0]).css('background-color', '#e9ecef')
         $("#nombreProveedorSol").prop('disabled', true)
         $("#docRelacionado").prop('required', true)
         $("#divDocRelacionado").removeClass('d-none')
         $("#divDocProveedorSol").addClass('d-none')
         $("#divNombreProveedorSol").addClass('d-none')
         $("#docProveedorSol").prop('required', false)

      } else if (tipo === "TALLER") {
         $('#labelDocumentoSol').html('OT:');
         $("#docRelacionado").prop('disabled', false);
         $("#docProveedorSol").prop('disabled', true)
         $($("#docProveedorSol").parent().children()[0]).css('background-color', '#e9ecef')

         $("#nombreProveedorSol").prop('disabled', true)
         $("#divDocRelacionado").removeClass('d-none')
         $("#divDocProveedorSol").addClass('d-none')
         $("#divNombreProveedorSol").addClass('d-none')
         $("#docProveedorSol").prop('required', false)

      } else if (tipo === "DEVOLUCION") {
         $('#labelDocumentoSol').html('OC:');
         $("#docRelacionado").prop('disabled', true)
         $("#docProveedorSol").prop('disabled', false)
         $("#docProveedorSol").prop('required', true)
         $("#docProveedorSol").focus()
         $($("#docProveedorSol").parent().children()[0]).prop('disabled', false)
         $($("#docProveedorSol").parent().children()[0]).css('background-color', 'white')
         $("#nombreProveedorSol").prop('disabled', true)

         $("#divDocRelacionado").addClass('d-none')
         $("#divDocProveedorSol").removeClass('d-none')
         $("#divNombreProveedorSol").removeClass('d-none')

      } else if (tipo === "CTALLER") {
         $("#divDocRelacionado").addClass('d-none')
         $("#divDocProveedorSol").addClass('d-none')
         $("#divNombreProveedorSol").addClass('d-none')
         $("#docProveedorSol").prop('required', false)
         $("#docRelacionado").prop('required', false)
      }
   }

   //Esto es para reingreso de repuestos
   $('#motivoSol').on('change', function () {
      var tipo = $('#motivoSol').val();
      console.log(tipo)
      changeMotivo(tipo)

   });

   $('#motivoSol').trigger("change");

   var newLineaDetalleOCCount = 0;
   function refreshTabla(type) {
      if (newLineaDetalleOCCount > 0) {
         $('#tablaDetalleOC').show();
      }
      else {
         $('#tablaDetalleOC').hide();
      }

      if (type == 'del') {
         $('#tablaDetalleOC').find("[id^='newLineaDetalleOC-']").each(function (i, element) {
            $(element).children('th').text(i + 1);
         });
      }
      capturaEventoInputOC();
      refreshTypeaheads();
   }

   function excluirCeroCont() {
      //var myInput = document.getElementsByTagName('input')[0];
      $(".cantidadcon").keyup(function (e) {
         var key = e.keyCode || e.charCode;

         // si la tecla es un cero y el primer carácter es un cero
         if (key == 48 && this.value[0] == "0") {
            // se eliminan los ceros delanteros
            this.value = this.value.replace(/^0+/, '');
         }
      });
   }

   function addLineaDetalleOC() {
      $('#trTotal').hide();
      let aux = $('#trTotal');
      newLineaDetalleOCCount++;
      let node =
         '<tr id="newLineaDetalleOC-' + newLineaDetalleOCCount + '">' +
         '<th scope="row">' + newLineaDetalleOCCount + '</th>' +
         '<td><input class="typeahead form-control" tipo="repuestos" name="descripcionLineaDetalleOC-' + newLineaDetalleOCCount + '" id="descripcionLineaDetalleOC-' + newLineaDetalleOCCount + '" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" required></td>' +
         '<td><input typeahead_second_field="descripcionLineaDetalleOC-' + newLineaDetalleOCCount + '" id="describeLineaDetalleOC-' + newLineaDetalleOCCount + '" class="form-control cantidadForm" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>' +
         '<td><select name="unidadGrupoOC-' + newLineaDetalleOCCount + '" id="unidadGrupoOC-' + newLineaDetalleOCCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" readonly></select></td>' +
         '<td><input name="cantidadLineaDetalleOC-' + newLineaDetalleOCCount + '" id="cantidadLineaDetalleOC-' + newLineaDetalleOCCount + '" class="form-control cantidadcon" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" required></td>' +
         '<td><input name="cUnitLineaDetalleOC-' + newLineaDetalleOCCount + '" id="cUnitLineaDetalleOC-' + newLineaDetalleOCCount + '" class="form-control cantidadcon" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" required></td>' +
         '<td><input name="totalLineaDetalleOC-' + newLineaDetalleOCCount + '" id="totalLineaDetalleOC-' + newLineaDetalleOCCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" value="0.00" disabled></td>' +
         '<td><button id="btnEliminarLineaDetalleOC-' + newLineaDetalleOCCount + '" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
         '</tr>';
      $('#tablaDetalleOC tr:last').after(node);
      $('#tablaDetalleOC tr:last').after(aux);
      $('#trTotal').show();
      refreshTabla();

      $("[id^='btnEliminarLineaDetalleOC-']").unbind();
      $("[id^='btnEliminarLineaDetalleOC-']").on('click', function () {
         let numID = $(this).attr('id').replace(/btnEliminarLineaDetalleOC-/, '');
         let valorPUnit = $("#cUnitLineaDetalleOC-" + numID).val();
         let valorCantidad = $("#cantidadLineaDetalleOC-" + numID).val();
         $('#inputTotalDetalleOC').val($('#inputTotalDetalleOC').val() - valorPUnit * valorCantidad);
         $("#newLineaDetalleOC-" + numID).remove();
         newLineaDetalleOCCount--;
         refreshTabla('del');
      });

      $("[id^='descripcionLineaDetalleOC-']").on('change', function () {
         let link_sub = rootURL + '/' + 'buscarRepuesto/';
         let link_completo = link_sub + $(this).val();
         let numID = $(this).attr('id').replace(/descripcionLineaDetalleOC-/, '');
         $.get(link_completo, {}, function (data, status) {
            if (data) {
               console.log("#unidadGrupoOC-" + numID);
               if (data.id_unidad_grupo) {
                  $("#unidadGrupoOC-" + numID).append($("<option></option>").attr("value", 0).text(data.nombreUnidadMinima));
                  $("#unidadGrupoOC-" + numID).append($("<option selected></option>").attr("value", 1).text(data.nombreUnidadGrupo));
               }
               else {
                  $("#unidadGrupoOC-" + numID).append($("<option selected></option>").attr("value", 0).text(data.nombreUnidadMinima));
               }
            }
         });
      });

      excluirCeroCont();
   }

   $("#btnAddLineaDetalleOC").on('click', function () {
      addLineaDetalleOC();
      $('#divmensje').hide();
   });

   $("#seleccionMonedaOC").on('change', function () {
      var simbolo = $(this).val() == "SOLES" ? monedaSimboloSoles : monedaSimboloDolares;
      $("#tablaOCTotal").text("TOTAL (" + simbolo + ")");
      $("#tablaOCCUnitario").text("C. UNITARIO (" + simbolo + ")");
   });

   var simbolo = $("#seleccionMonedaOC").val() == "SOLES" ? monedaSimboloSoles : monedaSimboloDolares;
   $("#tablaOCTotal").text("TOTAL (" + simbolo + ")");
   $("#tablaOCCUnitario").text("C. UNITARIO (" + simbolo + ")");

   var newLineaAsientos = 0;
   function refreshTablaAsientos(type) {
      if (newLineaAsientos > 0) {
         $('#tableAsientos').show();
      }
      else {
         $('#tableAsientos').hide();
      }

      if (type == 'del') {
         $('#tableAsientos').find("[id^='newLineaAsientos-']").each(function (i, element) {
            $(element).children('th').text(i + 1);
         });
      }
      capturaEventoAsiento();
   }

   function addLineaAsiento() {
      $('#trTotalAsientos').hide();
      let aux = $('#trTotalAsientos');
      newLineaAsientos++;
      let node =
         '<tr id="newLineaAsientos-' + newLineaAsientos + '">' +
         '<td><input class="form-control" name="cuentaAsientos-' + newLineaAsientos + '" id="cuentaAsientos-' + newLineaAsientos + '" style=" display: block; height: 80%; width: 100%; box-sizing: border-box; margin:auto;"></td>' +
         '<td><input id="montoDebe-' + newLineaAsientos + '" name="montoDebe-' + newLineaAsientos + '" class="form-control" style=" display: block; height: 80%; width: 100%; box-sizing: border-box; margin: auto;"></td>' +
         '<td><input name="montoHaber-' + newLineaAsientos + '" id="montoHaber-' + newLineaAsientos + '" class="form-control" style=" display: block; height: 80%; width: 100%; box-sizing: border-box; margin: auto;"></td>' +
         '<td style="margin: auto;"><button id="btnEliminarAsiento-' + newLineaAsientos + '" type="button" class="btn btn-warning" style="margin: auto;"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
         '</tr>';
      $('#tableAsientos tr:last').after(node);
      $('#tableAsientos tr:last').after(aux);
      $('#trTotalAsientos').show();
      refreshTablaAsientos();

      $("[id^='btnEliminarAsiento-']").unbind();
      $("[id^='btnEliminarAsiento-']").on('click', function () {
         let numID = $(this).attr('id').replace(/btnEliminarAsiento-/, '');
         let valorDebe = $("#montoDebe-" + numID).val();
         let valorHaber = $("#montoHaber-" + numID).val();
         $('#inputTotalDebe').val(($('#inputTotalDebe').val() - valorDebe).toFixed(2));
         $('#inputTotalHaber').val(($('#inputTotalHaber').val() - valorHaber).toFixed(2));
         $("#newLineaAsientos-" + numID).remove();
         newLineaAsientos--;
         refreshTablaAsientos('del');
      });
   }

   $("#btnAddAsiento").on('click', function () {
      addLineaAsiento();
   });


   function computarValoresOC() {
      //console.log($(this).val());
      let id = $(this).attr('id');
      let numID;
      console.log(id);
      if (id.includes("cUnitLineaDetalleOC-")) {
         numID = $(this).attr('id').replace(/cUnitLineaDetalleOC-/, '');
      } else if (id.includes("cantidadLineaDetalleOC-")) {
         numID = $(this).attr('id').replace(/cantidadLineaDetalleOC-/, '');
      }
      let valCantidad = parseFloat($("#cantidadLineaDetalleOC-" + numID).val() == '' ? 0 : $("#cantidadLineaDetalleOC-" + numID).val());
      let valPUnit = parseFloat($("#cUnitLineaDetalleOC-" + numID).val() == '' ? 0 : $("#cUnitLineaDetalleOC-" + numID).val());
      $("#totalLineaDetalleOC-" + numID).val((valCantidad * valPUnit).toFixed(2));

      let suma = 0;
      $("[id^='totalLineaDetalleOC-']").each(function () {
         let aux = parseFloat($(this).val() == '' ? 0 : $(this).val());
         suma = suma + aux;
      });
      $('#inputTotalDetalleOC').val(suma.toFixed(2));
   }

   function capturaEventoInputOC() {
      $("[id^='cUnitLineaDetalleOC-'], [id^='cantidadLineaDetalleOC-']").on('input', computarValoresOC);
   }

   function computarValoresAsientos() {
      //console.log($(this).val());
      let id = $(this).attr('id');
      let numID;
      console.log(id);
      let suma = 0;
      if (id.includes("montoDebe-")) {
         $("[id^='montoDebe-']").each(function () {
            let aux = parseFloat($(this).val() == '' ? 0 : $(this).val());
            suma = suma + aux;
         });
         $('#inputTotalDebe').val(suma.toFixed(2));
      } else if (id.includes("montoHaber-")) {
         $("[id^='montoHaber-']").each(function () {
            let aux = parseFloat($(this).val() == '' ? 0 : $(this).val());
            suma = suma + aux;
         });
         $('#inputTotalHaber').val(suma.toFixed(2));
      }
   }

   function capturaEventoAsiento() {
      $("[id^='montoDebe-'], [id^='montoHaber-']").on('input', computarValoresAsientos);
   }

   function computarValoresNI() {
      let id = $(this).attr('id');
      let valorFila = id.substring(5);
      console.log(valorFila);
      let valorPrecio = parseFloat($('#precio-' + valorFila).val() == '' ? 0 : $('#precio-' + valorFila).val());
      let valorCantidad = parseFloat($(this).val() == '' ? 0 : $(this).val());
      $('#total-' + valorFila).val((valorPrecio * valorCantidad).toFixed(2));

      let suma = 0;
      $("[id^='total-']").each(function () {
         let aux = parseFloat($(this).val() == '' ? 0 : $(this).val());
         suma = suma + aux;
      });
      $('#inputTotalDetalleOCNI').val(suma.toFixed(2));
   }

   $("[id^='cant-']").on('input', computarValoresNI);



   function updateCuentas(codBanco, callback) {
      $('#cuentasIn option:gt(0)').remove(); // remove all options, but not the first 
      $('#cuentasIn').prop('disabled', true);
      if (codBanco) {
         var link_sub = '/obtenerCuentas/';
         var link_completo = rootURL + link_sub + codBanco;
         $.get(link_completo, {}, function (data, status) {
            if (status == 'success') {
               console.log(data);
               $.each(data, function (key, value) {
                  $('#cuentasIn').append($("<option></option>")
                     .attr("value", value.id_cuenta_bancaria).text(value.nro_cuenta));
               });
               $('#cuentasIn').prop('disabled', false);
               if (callback) callback();
            }
         });
      }
   }

   $("#bancosIn").on('change', function () {
      updateCuentas($(this).val(), null)
   });


   $("#formGenerarOC").on('submit', function (e) {
      e.preventDefault();
      $.ajax({
         url: $(this).attr('action'),
         type: "POST",
         data: $(this).serialize(),
         success: function (data) {
            if (data.status == 0) {
               $('#divmensje').html('Debe agregar por lo menos un detalle orden de compra').addClass("alert alert-danger");
            } else {
               window.open(data, '_blank');
               var link_sub = '/seguimientoOC';
               var link_completo = rootURL + link_sub
               window.location.href = link_completo
            }
         },
         error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
         }
      });
   });

   $("#formRegistrarSol").on('submit', function (e) {
      e.preventDefault();
      $.ajax({
         url: $(this).attr('action'),
         type: "POST",
         data: $(this).serialize(),
         success: function (data) {
            if (data.status == 0) {
               $('#divmensje').html('Debe agregar por lo menos un detalle orden de compra').addClass("alert alert-danger");
            } else {
               window.open(data, '_blank');
               var link_sub = '/reingresoRepuestos';
               var link_completo = rootURL + link_sub
               window.location.href = link_completo
            }
         },
         error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
         }
      });
   });

   var newLineaSolRepCount = 0;
   function refreshTablaSolRep(type) {
      if (newLineaSolRepCount > 0) {
         $('#tablaDetalleSol').show();
      }
      else {
         $('#tablaDetalleSol').hide();
      }


      if (type == 'del') {
         $('#tablaDetalleSol').find("[id^='newLineaSolRep-']").each(function (i, element) {
            $(element).children('th').text(i + 1);
         });
      }
      refreshTypeaheads();
      capturaEventoInputSolRep();
   }

   function addLineaSolRep() {
      newLineaSolRepCount++;
      let node =
         '<tr id="newLineaSolRep-' + newLineaSolRepCount + '">' +
         '<th scope="row">' + newLineaSolRepCount + '</th>' +
         '<td><input class="typeahead form-control" tipo="repuestos" name="descripcionLineaSolRep-' + newLineaSolRepCount + '" id="descripcionLineaSolRep-' + newLineaSolRepCount + '" onblur="buscarStock(' + newLineaSolRepCount + ')" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" required></td>' +
         '<td><input typeahead_second_field="descripcionLineaSolRep-' + newLineaSolRepCount + '" id="describeLineaSolRep-' + newLineaSolRepCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>' +
         '<td><input id="stockLineaSolRep-' + newLineaSolRepCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" disabled></td>' +
         '<td><input id="ubiLineaSolRep-' + newLineaSolRepCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" readonly></td>' +
         '<td><input type="number" name="cantidadLineaSolRep-' + newLineaSolRepCount + '" id="cantidadLineaSolRep-' + newLineaSolRepCount + '" oninput="validarStock(event); calcPrecioTotal(' + newLineaSolRepCount + ')" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" required></td>' +
         '<td><input name="costoUniLineaSolRep-' + newLineaSolRepCount + '" id="costoUniLineaSolRep-' + newLineaSolRepCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" required' + ($("#tablaDetalleSol:not([tipo='ctaller'])").length ? '' : ' disabled') + '></td>' +
         ($("#tablaDetalleSol:not([tipo='ctaller'])").length ? '<td><input name="descUniLineaSolRep-' + newLineaSolRepCount + '" id="descUniLineaSolRep-' + newLineaSolRepCount + '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" value="0" required></td>' : '') +
         '<td><input name="totalLineaSolRep-' + newLineaSolRepCount + '" id="totalLineaSolRep-' + newLineaSolRepCount + '" class="form-control" value="0.00" style=" display: block; height: 100%; width: 100%; box-sizing: border-box; margin: auto;" readonly></td>' +

         '<td><button id="btnEliminarLineaSolRep-' + newLineaSolRepCount + '" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
         '</tr>';
      $('#tablaDetalleSol tr:last').after(node);
      refreshTablaSolRep();

      $("[id^='btnEliminarLineaSolRep-']").unbind();
      $("[id^='btnEliminarLineaSolRep-']").on('click', function () {
         let numID = $(this).attr('id').replace(/btnEliminarLineaSolRep-/, '');
         $("#newLineaSolRep-" + numID).remove();
         newLineaSolRepCount--;
         refreshTablaSolRep('del');
      });
   }

   $("#btnAddLineaDetalleSol").on('click', function () {
      addLineaSolRep();
   });

   function computarValoresSolRep() {
      //console.log($(this).val());
      let id = $(this).attr('id');
      let tablaDevoluciones = $("#tablaDetalleSol:not([tipo='ctaller'])").length;
      let numID;
      console.log(id);
      if (id.includes("cantidadLineaSolRep-")) {
         numID = $(this).attr('id').replace(/cantidadLineaSolRep-/, '');
      } else if (id.includes("costoUniLineaSolRep-")) {
         numID = $(this).attr('id').replace(/costoUniLineaSolRep-/, '');
      } else if (id.includes("descUniLineaSolRep-")) {
         numID = $(this).attr('id').replace(/descUniLineaSolRep-/, '');
      }
      let cantidad = parseFloat($("#cantidadLineaSolRep-" + numID).val() == '' ? 0 : $("#cantidadLineaSolRep-" + numID).val());
      let costo = parseFloat($("#costoUniLineaSolRep-" + numID).val() == '' ? 0 : $("#costoUniLineaSolRep-" + numID).val());
      let descuento = parseFloat($("#descUniLineaSolRep-" + numID).val() == '' ? 0 : $("#descUniLineaSolRep-" + numID).val());
      if (tablaDevoluciones) {
         $("#totalLineaSolRep-" + numID).val(((costo - descuento) * cantidad).toFixed(2));
      } else {
         $("#totalLineaSolRep-" + numID).val((costo * cantidad).toFixed(2));
      }


      let suma = 0;
      $("[id^='totalLineaSolRep-']").each(function () {
         let aux = parseFloat($(this).val() == '' ? 0 : $(this).val());
         suma = suma + aux;
      });
      $('#SubTotalDev').text(suma.toFixed(2));
      $('#totalIgvDev').text((suma * 0.18).toFixed(2));
      $('#totalDev').text((suma * 1.18).toFixed(2));
   }

   $("#seleccionMonedaSol").on('change', function () {
      var simbolo = $(this).val() == "SOLES" ? monedaSimboloSoles : monedaSimboloDolares;
      $("#tablaCostUnitDev").text("COSTO UNITARIO (" + simbolo + ")");
      $("#tablaDescUnitDev").text("DESCUENTO UNITARIO (" + simbolo + ")");
      $("#tablaImporteTotDev").text("IMPORTE TOTAL (" + simbolo + ")");
      $("#simboloSubTotalDev").text(" (" + simbolo + ")");
      $("#simboloTotalIgvDev").text(" (" + simbolo + ")");
      $("#simboloTotalDev").text(" (" + simbolo + ")");
      if ($(this).val() == "SOLES") {
         $('#tipoCambioDev').removeAttr("required");
      } else {
         $('#tipoCambioDev').prop("required", true);
      }
   });

   var simbolo = $("#seleccionMonedaSol").val() == "SOLES" ? monedaSimboloSoles : monedaSimboloDolares;
   $("#tablaCostUnitDev").text("COSTO UNITARIO (" + simbolo + ")");
   $("#tablaDescUnitDev").text("DESCUENTO UNITARIO (" + simbolo + ")");
   $("#tablaImporteTotDev").text("IMPORTE TOTAL (" + simbolo + ")");
   $("#simboloSubTotalDev").text(" (" + simbolo + ")");
   $("#simboloTotalIgvDev").text(" (" + simbolo + ")");
   $("#simboloTotalDev").text(" (" + simbolo + ")");

   function capturaEventoInputSolRep() {
      $("[id^='cantidadLineaSolRep-'], [id^='costoUniLineaSolRep-'], [id^='descUniLineaSolRep-']").on('input', computarValoresSolRep);
   }

   $('#tipoTransaccionIn').change(function () {
      listarMotivos(motivosIn)
   })

   $('#tipoTransaccionOut').change(function () {
      listarMotivos(motivosOut)
   })

   if ($("#tipoTransaccionIn").prop('checked')) {
      listarMotivos(motivosIn)
   }

   if ($("#tipoTransaccionOut").prop('checked')) {
      listarMotivos(motivosOut)
   }

   $("#motivoSol").val($("#sessionMotivoSol").val()).change()

   var stock_disponible

   function listarMotivos(motivos) {
      $('#motivoSol').html('')
      motivos.map(item => {
         $('#motivoSol').append(`
            <option value="${item.value}">${item.show}</option>
            `)
      })
      let tipo = $('#motivoSol').val()
      changeMotivo(tipo)
   }

});

function buscarStock(id) {
   let codigo_producto = $(`#descripcionLineaSolRep-${id}`).val()
   let tablaDevoluciones = $("#tablaDetalleSol:not([tipo='ctaller'])").length;
   fetch('./repuestos_stock/' + codigo_producto)
      .then(res => res.json())
      .then(res => {
         console.log(res)
         stock_disponible = parseFloat(res.stock)
         $(`#stockLineaSolRep-${id}`).val(stock_disponible)
         $(`#ubiLineaSolRep-${id}`).val(res.ubicacion)
         $(`#precioUniLineaSolRep-${id}`).val(res.precio_uni)
         if (res.esLubricante) {
            $(`#cantidadLineaSolRep-${id}`).attr("step", "any");
         } else {
            $(`#cantidadLineaSolRep-${id}`).attr("step", 1);
         }
         if (!tablaDevoluciones) { //esto significa que estamos en el caso de: consumo taller
            $(`#costoUniLineaSolRep-${id}`).val(res.costo_uni)
         }
      })

}

function eliminarTaller(id) {
   if (confirm('¿Desea retirar el registro?')) {
      $(`#rowTaller-${id}`).remove()
   }
}

function calcPrecioTotal(id) {
   let cantidad = $(`#cantidadLineaSolRep-${id}`).val()
   let precio = $(`#precioUniLineaSolRep-${id}`).val()
   let total = parseFloat(cantidad) * parseFloat(precio)

   if (!isNaN(total)) {
      $(`#precioTotalLineaSolRep-${id}`).val(total)
   } else {
      $(`#precioTotalLineaSolRep-${id}`).val('')
   }

}

function validarStock(e) {
   console.log(e.target.parentNode)
   let numID = $(`#${e.target.id}`).attr('id').replace(/cantidadLineaSolRep-/, '');
   let stock_disp = $(`#stockLineaSolRep-${numID}`).val();
   let cantidad_solicitada = parseFloat(e.target.value)
   let count_child = e.target.parentNode.childElementCount // Contar los elementos para validar si tiene el span de "Stock no disponible"

   //Elimina "Stock no disponible"
   if (count_child > 1) {
      let parent = e.target.parentNode
      parent.removeChild(parent.lastChild)
   }

   if (cantidad_solicitada > stock_disp) {
      let span = document.createElement('span')
      span.innerText = `Stock No disponible: ${stock_disp}`
      span.style = 'color: red; font-size: 11px';
      e.target.parentNode.appendChild(span)
      e.target.value = ''
   }
}

