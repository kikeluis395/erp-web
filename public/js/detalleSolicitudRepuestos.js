$(function(){
    $("#fechaPedidoIn").datepicker("option","minDate",0);

    $("#fechaPromesaIn").datepicker("option","minDate",0);

    $("#fechaPedidoIn").on('change input',function(){
      let dateString = $(this).val();
      let dateParts = dateString.split("/");
      let dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]); 

      $("#fechaPromesaIn").datepicker("option","minDate",dateObject);
    });
    
    $("[id^='FormEntregaRepuesto-']").find("#fechaEntregaIn").datepicker("option","minDate",0);


    //limpieza de modal al cierre
    $("#agregarRepuestoModal, [id^='confirmarEntregaModal-'], [id^='modificarRepuestoModal-']").on('hide.bs.modal', function (e) {
      $(this).find('input:not([type=hidden])').val( (i,val) => {
        return $(this).find('input:not([type=hidden])')[i].getAttribute('value');
      });
          
      $(this).find('select:not(:disabled):not([type=hidden])').val( (i,val) => {
        return $(this).find('select:not(:disabled):not([type=hidden])')[i].getAttribute('value');
      });

      let numID = $(this).attr('id').split('-').slice(-1)[0];
      $("#cantidadIn").prop('disabled', false);
      $("#cantidadIn-"+numID).prop('disabled', false);
      $("#fechaEntregaField-"+numID).show();
      $("#disponibilidadCont[hidden_start]").hide();
      $("#disponibilidadCont-"+numID+"[hidden_start]").hide();
      $("#importacionCont[hidden_start]").hide();
      $("#importacionCont-"+numID+"[hidden_start]").hide();
      $("#fechasImportacion[hidden_start]").hide();
      $("#fechasImportacion-"+numID+"[hidden_start]").hide();
    });

    // modal de agregado de repuesto
    $("#nroParteIn").on('change', function () {
      let link_sub= rootURL + '/' + 'buscarRepuesto/';
      let codigoRepuesto = $(this).val();
      let link_completo = link_sub + codigoRepuesto;

      $("#cantidadIn").prop('disabled', true);
      $.get(link_completo,{},function(data,status) {
        $("#descripcionIn").val(data ? data.descripcion : "NO EXISTE");
        if(data){
          if(data){
            $("#cantidadIn").prop('disabled', false);
            $("#disponibilidadCont").show();
            let link_sub_stock = rootURL + '/' + 'obtenerStockRepuesto';
            $.ajax({
              url : link_sub_stock,
              type: "GET",
              data: {idLocal: idLocalUsuario, codigoRepuesto: codigoRepuesto},
              success: function (data) {
                if(data.stockVirtual > 0){
                  // $("#disponibilidad").text("REPUESTO DISPONIBLE (" + data + ")");
                  $("#importacionCont").hide();
                  $("#fechasImportacion").hide();
                }
                else{
                  // $("#disponibilidad").text("SOLICITAR REPUESTO");
                  $("#importacionCont").show();
                  $("#fechasImportacion").show();
                }
                $("#cantidadIn").trigger('change');
              },
              error: function (jXHR, textStatus, errorThrown) {
                  alert(errorThrown);
              }
            });
          }
        }
      });
    });

    // modal de modificacion de repuesto
    $("[id^='nroParteIn-']").on('change', function () {
      let numID = $(this).attr('id').replace(/nroParteIn-/,'');
      let link_sub= rootURL + '/' + 'buscarRepuesto/';
      let codigoRepuesto = $(this).val();
      let link_completo = link_sub + codigoRepuesto;
      
      $("#cantidadIn-"+numID).prop('disabled', true);
      $("#fechaEntregaField-"+numID).hide();
      $.get(link_completo,{},function(data,status) {
        $("#descripcionIn-" + numID).val(data ? data.descripcion : "NO EXISTE");
        if(data){
          $("#cantidadIn-"+numID).prop('disabled', false);
          $("#disponibilidadCont-"+numID).show();
          $("#fechaEntregaField-"+numID).show();
          let link_sub_stock = rootURL + '/' + 'obtenerStockRepuesto';
          $.ajax({
            url : link_sub_stock,
            type: "GET",
            data: {idLocal: idLocalUsuario, codigoRepuesto: codigoRepuesto},
            success: function (data) {
              $("#disponibilidadCont-"+numID).attr('value', data.stockVirtual);
              if(data.stockVirtual > 0){
                $("#disponibilidadFisica-"+numID).text(data.stockFisico);
                $("#disponibilidadVirtual-"+numID).text(data.stockVirtual);
                $("#importacionCont-"+numID).hide();
                $("#fechasImportacion-"+numID).hide();
              }
              else{
                $("#disponibilidadFisica-"+numID).text(data.stockFisico);
                $("#disponibilidadVirtual-"+numID).text(data.stockVirtual);
                $("#importacionCont-"+numID).show();
                $("#fechasImportacion-"+numID).show();
              }
              $("#cantidadIn-"+numID).trigger('change');
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
          });
        }
      });
    });
    
    $("[id^='cantidadIn-']").on('change', function () {
      let numID = $(this).attr('id').replace(/cantidadIn-/,'');
      let cantidad = $(this).val();
      let stockDisponible = parseFloat($("#disponibilidadCont-"+numID).attr('value'));

      if(cantidad <= stockDisponible){
        // mostrar mensaje exito
        $("#importacionCont-"+numID).hide();
        $("#fechasImportacion-"+numID).hide();
      }
      else{
        // solicitar pero igual mandarle el stock
        $("#importacionCont-"+numID).show();
        $("#fechasImportacion-"+numID).show();
      }
    })

    $("[id^='importado-']").on('change', function() {
          $.ajax({
              url : rootURL + '/actualizarImportado',
              type: "POST",
              data: {
                _token: $('input[name="_token"]').val(),
                id_item_repuesto: $(this).attr('idItemRepuesto'),
                checked: this.checked
              },
              success: function (data) {
                console.log(data);
                location.reload();
              },
              error: function (jXHR, textStatus, errorThrown) {
                  alert(errorThrown);
              }
          });
      });
});

function validateCero(id) {
  let val = $(`#cantidadIn-${id}`).val()

  if (isNaN(val)) $(`#cantidadIn-${id}`).val(1)

  if (val < 1) $(`#cantidadIn-${id}`).val(1)
}