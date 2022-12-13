$(function () {

   function init() {

      // ************************** DATATABLES **************************
      // $.fn.dataTable.ext.errMode = 'throw';
      let table = $('#tablaOProductos').DataTable({
         serverSide: true,
         processing: true,
         // pageLength: 15,
         // order: [[2, "asc"]],
         order: [],
         dom:
            'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"><"col-12 col-md-6">>',
         ajax: {
            url: route('otros_productos.data'),
            type: 'GET',
            data: function (d) {
               d.codproducto = $('#codoproducto_buscar').val();
               d.estproducto = $('#estado_oproducto').val();
               d.almproducto = $('#almac_oproducto').val();
               d.resproducto = $('#rep_oproducto').val();
            }
         },
         columns: [
            {
               data: "DT_RowIndex",
               name: "DT_RowIndex",
               orderable: false,
               searchable: false,
            },
            {
               data: "estado",
               orderable: false,
               render: function (data, type, row) {
                  if (row.estado == '1') {
                     return '<span class="text-white">ACTIVO</span>';
                  } else
                     return '<span class="text-white">INACTIVO</span>';
               }
            },
            {
               data: "codigo",
               name: "codigo",
               orderable: false,
            },
            {
               data: "descripcion",
               name: "descripcion",
               orderable: false,
            },
            {
               data: "parametro",
               name: "parametro",
               orderable: false,
            },
            {
               data: "created_at",
               name: "created_at",
               orderable: false,
            },
            {
               data: "usuario_creado",
               name: "usuario_creado",
               orderable: false,
            },
            {
               data: "updated_at",
               name: "updated_at",
               orderable: false,
            },
            {
               data: "usuario_update",
               name: "usuario_update",
               orderable: false,
               render: function (data, type, row) {
                  var valor = row.usuario_update
                  var nuevo_valor = valor.replace('["', '').replace('"]', '');
                  return nuevo_valor
               }
            },
            {
               data: "acciones",
               orderable: false,
               searchable: false,
            },
         ],
         language: {
            url: "js/datatables/datatable-es.json",
         },
         columnDefs: [
            {
               targets: [5],
               render: function (data) {
                  return moment(data).format('DD/MM/YYYY, h:mm A');
               }
            },
            {
               targets: [7],
               render: function (data) {
                  return moment(data).format('DD/MM/YYYY, h:mm A');
               }
            }
         ],
         rowCallback: function (row, data, index) {
            if (data.estado == '1') {
               $(row).find('td:eq(1)').css('background-color', '#2b8a3e');
            } else {
               $(row).find('td:eq(1)').css('background-color', '#e03131');
            }
         },
      });


      $('#filtrar').on('click', function () {
         var cod_producto = $('#codoproducto_buscar').val();
         var est_producto = $('#estado_oproducto').val();
         var alm_producto = $('#almac_oproducto').val();
         var res_producto = $('#rep_oproducto').val();


         if (cod_producto != '' || est_producto != '' || alm_producto != '' || res_producto != '') {
            $('#tablaOProductos').DataTable().draw(true);
         } else {
            // toastr["warning"]("Ingrese datos de búsqueda");
            Swal.fire({
               icon: 'warning',
               title: 'Invalido',
               text: 'Ingresar al menos un campo para filtrar.',
               confirmButtonText: "OK",
               customClass: {
                  confirmButton: "btn btn-success btn-lg px-4",
               },
               buttonsStyling: false,
            });
         }
      });

      $('#reiniciar').on('click', function () {
         $('#codoproducto_buscar').val('');
         $('#estado_oproducto').val('0').trigger('change');
         $('#almac_oproducto').val('0').trigger('change');
         $('#rep_oproducto').val('0').trigger('change');
         $('#tablaOProductos').DataTable().draw(true);
      });


      events();
      crud();
      alerts();
   }

   function events() {

      // *************** CAMBIAR NOMBRE DEL ESTADO *****************
      $(document).on('change', '#est_oproducto', function (e) {
         let test = e.target.checked;
         if (test) {
            $("#nombre_estado").text("ACTIVO");
            $(this).val('1');
         } else {
            $("#nombre_estado").text("INACTIVO");
            $(this).val('0');
         }
      });

      // AUTOFOCUS PARA  MODAL
      $("#agregarOtroProductoModal").on("shown.bs.modal", function () {
         $("#almacen_oproducto").focus();
      });

   }


   function crud() {

      $('#crear_registro').on('click', function () {

         $('.modal-title').text('NUEVO REGISTRO');

         $('.action_button').text('Guardar');
         $('.action_button').prepend('<i class="fas fa-save mr-2">');
         $('.action_button').removeClass('btn-info');
         $('.action_button').addClass('btn-success');
         $('#action').val('Agregar');

         $('#cod_oproducto-error').empty();
         $('#des_oproducto-error').empty();
         $('#almacen_oproducto-error').empty();
         $('#estado_oproducto-error').empty();

         $('#cod_oproducto-error').addClass('d-none');
         $('#des_oproducto-error').addClass('d-none');
         $('#almacen_oproducto-error').addClass('d-none');
         $('#estado_oproducto-error').addClass('d-none');

         $('#cod_oproducto').removeClass('is-invalid');
         $('#des_oproducto').removeClass('is-invalid');
         $('#almacen_oproducto').removeClass('is-invalid');
         $('#estado_oproducto').removeClass('is-invalid');

         $('#cod_oproducto').val('');
         $('#des_oproducto').val('');
         $('#almacen_oproducto').val("0").trigger("change");
         // $('#estado_oproducto').val("1").trigger("change");

         // $('#almacen_oproducto option:eq(0)').prop('disabled', true);
         $(".toggle-class").bootstrapToggle("on");
         $('#agregarOtroProductoModal').modal('show');
      });

      // VERIFICAR SI EXISTE ERRORES
      $('#form-otroProducto').on('submit', function (event) {

         event.preventDefault();
         var action_url = '';
         $form = $(this);

         // Accione para agregar
         if ($('#action').val() == 'Agregar') {
            action_url = route('otros_productos.store');
            // action_url = $form.attr('action');
         }

         // Accione para editar
         if ($('#action').val() == 'Editar') {
            action_url = route('otros_productos.update');
         }

         $.ajax({
            url: action_url,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
               console.log(data)
               if (data.errors) {

                  if (data.errors == "Duplicado") {
                     $('#cod_oproducto-error').removeClass('d-none');
                     $('#cod_oproducto').addClass('is-invalid');
                     $('#cod_oproducto-error').html('Error. Ya existe un item con el mismo codigo');
                  }

                  if (data.errors.cod_oproducto) {
                     $('#cod_oproducto-error').removeClass('d-none');
                     $('#cod_oproducto').addClass('is-invalid');
                     $('#cod_oproducto-error').html(data.errors.cod_oproducto[0]);
                  }

                  if (data.errors.des_oproducto) {
                     $('#des_oproducto-error').removeClass('d-none');
                     $('#des_oproducto').addClass('is-invalid');
                     $('#des_oproducto-error').html(data.errors.des_oproducto[0]);
                  }

                  if (data.errors.almacen_oproducto) {
                     $('#almacen_oproducto-error').removeClass('d-none');
                     $('#almacen_oproducto').addClass('is-invalid');
                     // $('#alm_oproducto').parent().addClass(' has-error-select2');
                     $('#almacen_oproducto-error').html(data.errors.almacen_oproducto[0]);
                  }

                  if (data.errors.estado_oproducto) {
                     $('#estado_oproducto-error').removeClass('d-none');
                     $('#estado_oproducto').addClass('is-invalid');
                     // $('#estado_oproducto').parent().addClass(' has-error-select2');
                     $('#estado_oproducto-error').html(data.errors.estado_oproducto[0]);
                  }
               }

               if (data.success) {
                  if ($('#action').val() == 'Editar') {
                     toastr['info']('Registro actualizado correctamente');
                     // Limpiar errores y campos
                     $('#form-otroProducto')[0].reset();
                     $('#cod_oproducto-error').empty();
                     $('#des_oproducto-error').empty();
                     $('#almacen_oproducto-error').empty();
                     $('#estado_oproducto-error').empty();

                     $('#cod_oproducto-error').addClass('d-none');
                     $('#des_oproducto-error').addClass('d-none');
                     $('#almacen_oproducto-error').addClass('d-none');
                     $('#estado_oproducto-error').addClass('d-none');

                     $('#cod_oproducto').removeClass('is-invalid');
                     $('#des_oproducto').removeClass('is-invalid');
                     $('#almacen_oproducto').removeClass('is-invalid');
                     $('#estado_oproducto').removeClass('is-invalid');

                     $('#cod_oproducto').val('');
                     $('#des_oproducto').val('');
                     $('#almacen_oproducto').val("0").trigger("change");
                     $('#estado_oproducto').val("1").trigger("change");

                     $('#almacen_oproducto option:eq(0)').prop('disabled', true);

                     $('#tablaOProductos').DataTable().ajax.reload();
                     $('#agregarOtroProductoModal').modal('hide');
                  } else {
                     toastr['success']('Registro agregado correctamente');
                     // Limpiar errores y campos
                     $('#form-otroProducto')[0].reset();
                     $('#cod_oproducto-error').empty();
                     $('#des_oproducto-error').empty();
                     $('#almacen_oproducto-error').empty();
                     $('#estado_oproducto-error').empty();

                     $('#cod_oproducto-error').addClass('d-none');
                     $('#des_oproducto-error').addClass('d-none');
                     $('#almacen_oproducto-error').addClass('d-none');
                     $('#estado_oproducto-error').addClass('d-none');

                     $('#cod_oproducto').removeClass('is-invalid');
                     $('#des_oproducto').removeClass('is-invalid');
                     $('#almacen_oproducto').removeClass('is-invalid');
                     $('#estado_oproducto').removeClass('is-invalid');

                     $('#cod_oproducto').val('');
                     $('#des_oproducto').val('');
                     $('#almacen_oproducto').val("0").trigger("change");
                     $('#estado_oproducto').val("1").trigger("change");

                     $('#almacen_oproducto option:eq(0)').prop('disabled', true);

                     $('#tablaOProductos').DataTable().ajax.reload();
                     $('#agregarOtroProductoModal').modal('hide');
                  }
               }
            }
         })
      });


      // ************* LLAMANDO AL EDIT MODAL DESDE AJAX *************
      $(document).on('click', '.edit', function () {
         var id = $(this).attr('id');

         console.log(id);
         $('#cod_oproducto-error').empty();
         $('#des_oproducto-error').empty();
         $('#almacen_oproducto-error').empty();
         $('#estado_oproducto-error').empty();

         $('#cod_oproducto-error').addClass('d-none');
         $('#des_oproducto-error').addClass('d-none');
         $('#almacen_oproducto-error').addClass('d-none');
         $('#estado_oproducto-error').addClass('d-none');

         $('#cod_oproducto').removeClass('is-invalid');
         $('#des_oproducto').removeClass('is-invalid');
         $('#almacen_oproducto').removeClass('is-invalid');
         $('#estado_oproducto').removeClass('is-invalid');

         $('#cod_oproducto').val('');
         $('#des_oproducto').val('');
         $('#almacen_oproducto').val("0").trigger("change");
         $('#estado_oproducto').val("0").trigger("change");

         $('#almacen_oproducto option:eq(0)').prop('disabled', true);


         $.ajax({
            url: '/otros_productos/' + id + '/edit',
            dataType: 'json',
            success: function (data) {
               $('#cod_oproducto').val(data.oproducto.codigo);
               $('#des_oproducto').val(data.oproducto.descripcion);
               $('#almacen_oproducto').val(data.oproducto.id_parametros).trigger('change');
               var estado = data.oproducto.estado;

               if (estado == '1') {
                  $(".toggle-class").bootstrapToggle("on");
               } else {
                  $(".toggle-class").bootstrapToggle("off");
               }


               $('#osproducto_id').val(id);
               $('.modal-title').text('ACTUALIZAR CATEGORIA');
               $('.action_button').text('Actualizar');
               $('.action_button').prepend('<i class="fas fa-sync-alt mr-2"></i>');
               $('.action_button').removeClass('btn-success');
               $('.action_button').addClass('btn btn-info');
               $('#action').val('Editar');
               $('#agregarOtroProductoModal').modal('show');
            }
         });

      });


      // ************* ELIMINAR MODAL DESDE AJAX *************
      var delete_id;
      $(document).on("click", ".delete", function () {
         delete_id = $(this).attr("id");
         $("#eliminarOtroProducto").modal("show");
         $(".modal-title").text("ELIMINAR REGISTRO");
         $("#ok_button").text("Si, Eliminar");
      });

      $("#ok_button").on("click", function () {
         $.ajax({
            url: "/otros_productos/destroy/" + delete_id,
            beforeSend: function () {
               $("#ok_button").text("Eliminando...");

            },
            success: function (data) {
               toastr["error"]("Registro eliminado correctamente");
               setTimeout(function () {
                  $("#eliminarOtroProducto").modal("hide");
                  $("#tablaOProductos").DataTable().ajax.reload();
               }, 400);
            },
         });
      });


   }

   function alerts() {
      // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
      $("#cod_oproducto").on("keyup", function () {
         if ($("#cod_oproducto-error").text() != "") {
            if ($(this).val().length) {
               $("#cod_oproducto-error").addClass("d-none");
               $("#cod_oproducto").removeClass("is-invalid");
            } else {
               $("#cod_oproducto-error").removeClass("d-none");
               $("#cod_oproducto").addClass("is-invalid");
            }
         }
      });

      $("#des_oproducto").on("keyup", function () {
         if ($("#des_oproducto-error").text() != "") {
            if ($(this).val().length) {
               $("#des_oproducto-error").addClass("d-none");
               $("#des_oproducto").removeClass("is-invalid");
            } else {
               $("#des_oproducto-error").removeClass("d-none");
               $("#des_oproducto").addClass("is-invalid");
            }
         }
      });

      $("#almacen_oproducto").on("change", function () {
         if ($("#almacen_oproducto-error").text() != "") {
            if ($(this).val().length) {
               $("#almacen_oproducto-error").addClass("d-none");
               $("#almacen_oproducto").removeClass("is-invalid");
            } else {
               $("#almacen_oproducto-error").removeClass("d-none");
               $("#almacen_oproducto").addClass("is-invalid");
            }
         }
      });

      $("#estado_oproducto").on("change", function () {
         if ($("#estado_oproducto-error").text() != "") {
            if ($(this).val().length) {
               $("#estado_oproducto-error").addClass("d-none");
               $("#estado_oproducto").removeClass("is-invalid");
            } else {
               $("#estado_oproducto-error").removeClass("d-none");
               $("#estado_oproducto").addClass("is-invalid");
            }
         }
      });


   }






   init();





});