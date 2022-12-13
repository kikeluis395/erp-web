$(function () {
     function eval_check(val) {
          if (val) return '1'
          return '0'
     }
     $("[id^='deleteSTD-']").on('submit', function (e) {
          e.preventDefault()
          Swal.fire({
               icon: 'question',
               title: '¿Seguro que quieres eliminar este Servicio?',
               confirmButtonText: 'Confirmar',
               cancelButtonText: 'Cerrar',
               showCancelButton: true,
               preConfirm: () => {
                    Swal.fire({})
                    Swal.showLoading()
                    $.ajax({
                         url: $(this).attr('action'),
                         method: 'DELETE',
                         data: $(this).serialize(),
                         success: function (data) {
                              if (data) {
                                   if (data.success) {
                                        Swal.fire({
                                             icon: 'success',
                                             title: 'Se elimino exitosamente',
                                             timer: 800,
                                             timerProgressBar: true,
                                             allowOutsideClick: false,
                                             showConfirmButton: false,
                                             willClose: () => window.location.reload(),
                                        })
                                   }
                              }
                         },
                         error: function (jXHR, textStatus, errorThrown) {
                              Swal.hideLoading()
                              Swal.fire({ icon: 'info', title: 'Sucedio un error al eliminar' })
                              //   alert(errorThrown)
                         },
                    })
               },
          })
     })
     $("[id^='estadoIn-']").on('change', function (e) {
          const id = $(this).attr('id').replace('estadoIn-', '')
          var checked = e.target.checked
          $(`#estadoSTD-${id}`).text(checked ? 'ACTIVO' : 'INACTIVO')
     })
     $("[id^='FormEditarST-']").on('submit', function (e) {
          e.preventDefault()
          const id = $(this).attr('id').replace('FormEditarST-', '')
          $(`#close-${id}`).prop('disabled', true)
          $(`#save-${id}`).prop('disabled', true)

          var estados = $(`#estados-${id} input`)
          var marcas = $(`#marcas-${id} input`)
          var ventas = $(`#ventasIn-${id}`)
          var data = $(this).serializeArray()
          data = Array.from(data).reduce((o, v) => ({ ...o, [v.name]: v.value }), {})
          estados = { estado: eval_check(estados[0].checked) }
          marcas = Array.from(marcas).reduce((o, v) => ({ ...o, [v.getAttribute('value')]: eval_check(v.checked) }), {})
          marcas = { marcas }
          ventas = { aplicacion_ventas: eval_check(ventas[0].checked) }

          data = {
               ...data,
               ...estados,
               ...marcas,
               ...ventas,
          }
          console.log(data)
          $.ajax({
               url: $(this).attr('action'),
               data,
               method: 'PATCH',
               success: function (data) {
                    if (data) {
                         Swal.fire({
                              icon: 'success',
                              title: 'Se guardo con exito',
                              timer: 800,
                              timerProgressBar: true,
                              allowOutsideClick: false,
                              showConfirmButton: false,
                              willClose: () => window.location.reload(),
                         })
                    }
               },
               error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown)
               },
          })
     })

     $('#FormCrearST').on('submit', function (e) {
          e.preventDefault()
          $(`#closeREG`).prop('disabled', true)
          $(`#saveREG`).prop('disabled', true)
          var marcas = $(`#marcas input`)
          var ventas = $(`#ventasIn`)

          var data = $(this).serializeArray()
          data = Array.from(data).reduce((o, v) => ({ ...o, [v.name]: v.value }), {})
          marcas = Array.from(marcas).reduce((o, v) => ({ ...o, [v.getAttribute('value')]: eval_check(v.checked) }), {})
          marcas = { marcas }
          ventas = { aplicacion_ventas: eval_check(ventas[0].checked) }

          data = { ...data, ...marcas, ...ventas }
          $.ajax({
               url: $(this).attr('action'),
               data,
               method: 'POST',
               success: function (data) {
                    if (data) {
                         Swal.fire({
                              icon: 'success',
                              title: 'Registro Exitoso',
                              timer: 800,
                              timerProgressBar: true,
                              allowOutsideClick: false,
                              showConfirmButton: false,
                              willClose: () => window.location.reload(),
                         })
                    }
               },
               error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown)
               },
          })
     })

     const codes = { 1: 'SI', 0: 'NO' }
     $('.ventas_apli').each(function () {
          $(this).on('change', function (e) {
               var checked = e.target.checked
               const label = this.getAttribute('data-label')
               $(`#${label}`).text(codes[eval_check(checked)])
          })
     })

     function setModoEdicion(nuevoModoEdicion) {
          if (nuevoModoEdicion) {
               $('#btnEditarServiciosTerceros').text('Cancelar')
               $('#btnAgregarServicioTercero').on('click', function () {
                    addServicioTerceroTable()
               })
               $('#btnAgregarServicioTercero').show()
               $('#btnGuardarServiciosTerceros').show()

               // $("#thEditarServicioTercero").show();
               // $("[id^='tdEditarServicioTercero-']").show();

               $('#thEliminarServicioTercero').show()
               $("[id^='tdEliminarServicioTercero-']").show()
               $("[id^='btnEliminarServicioTercero-']").on('click', function () {
                    let numID = $(this)
                         .attr('id')
                         .replace(/btnEliminarServicioTercero-/, '')
                    let rutaDel = $(this).attr('data-r-delete')
                    let token = $('#_token').val()
                    // MODAL DE CONFIRMACION

                    Swal.fire({
                         title: '¿Desea eliminar este servicio?',
                         showDenyButton: true,
                         showCancelButton: false,
                         confirmButtonText: `Si`,
                         denyButtonText: `Cancelar`,
                    }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                         if (result.isConfirmed) {
                              $.ajax({
                                   url: rutaDel,
                                   data: { _method: 'DELETE', _token: token },
                                   type: 'POST',
                                   dataType: 'json',
                                   success: function (json) {
                                        $('#tdServicioTercero-' + numID).remove()
                                   },
                                   error: function (xhr, status) {
                                        //alert('Disculpe, existió un problema');
                                   },
                              })
                         }
                    })
               })
          } else {
               $('#btnEditarServiciosTerceros').text('Editar Servicios Terceros')
               $('#btnAgregarServicioTercero').hide()
               $('#btnAgregarServicioTercero').unbind()
               $('#btnGuardarServiciosTerceros').hide()

               $("[id^='newServicioTercero-']").remove()

               // $("#thEditarServicioTercero").hide();
               // $("[id^='tdEditarServicioTercero-']").hide();

               $("[id^='tdEliminarServicioTercero-']").hide()
               $('#thEliminarServicioTercero').hide()
               $("[id^='btnEliminarServicioTercero-']").unbind()

               newServicioTerceroCount = 0
          }
          modoEdicion = nuevoModoEdicion
     }

     function addServicioTerceroTable() {
          newServicioTerceroCount++
          let marcas = $('.marcas')
          inpts_marcas = ''
          marcas.each(function () {
               inpts_marcas +=
                    '<input type="checkbox" name=marcas-' +
                    newServicioTerceroCount +
                    '[] value="' +
                    $(this).attr('value') +
                    '">' +
                    $(this).attr('attr-name') +
                    '</input>'
          })
          let node =
               "<tr id='newServicioTercero-" +
               newServicioTerceroCount +
               "'>" +
               '<th scope="row"></th>' +
               '<td></td><td><input class="form-control" id="inputNewCodServicioTercero-' +
               newServicioTerceroCount +
               '" name="newCodServicioTercero-' +
               newServicioTerceroCount +
               '" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" required></td>' +
               '<td><input class="form-control" id="inputNewServicioTerceroDescripcion-' +
               newServicioTerceroCount +
               '" name="newDescripcionServicioTercero-' +
               newServicioTerceroCount +
               '" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" required></td>' +
               '<td>' +
               '<select id="inputNewServicioTerceroMoneda-' +
               newServicioTerceroCount +
               '" name="newMonedaServicioTercero-' +
               newServicioTerceroCount +
               '" class="form-control" style=" display: block; height: 100%; width: 100%; box-sizing: border-box;" size="0" required>' +
               '<option value="SOLES">Soles</option>' +
               '<option value="DOLARES">Dólares</option>' +
               '</select>' +
               '</td>' +
               '<td class="form-group form-inline justify-content-center"><input type="number" required class="form-control" id="inputNewServicioTerceroPVP-' +
               newServicioTerceroCount +
               '" name="newServicioTerceroPVP-' +
               newServicioTerceroCount +
               '" style=" display: block; height: 100%; width: 70px; box-sizing: border-box;"></td>' +
               '<td>' +
               inpts_marcas +
               '</td>' +
               '<td></td><td id=""><button id="btnEliminarNewServicioTercero-' +
               newServicioTerceroCount +
               '" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
               '</tr>'
          // $('#tablaServiciosTerceros tr:first').after(node);
          /*  $([document.documentElement, document.body]).animate({
             scrollTop: $("#tablaServiciosTerceros tr:last").offset().top
         }, 500); */

          $("[id^='btnEliminarNewServicioTercero-']").unbind()
          $("[id^='btnEliminarNewServicioTercero-']").on('click', function () {
               let numID = $(this)
                    .attr('id')
                    .replace(/btnEliminarNewServicioTercero-/, '')
               $('#newServicioTercero-' + numID).remove()
          })
     }

     var modoEdicion = false
     var newServicioTerceroCount = 0

     setModoEdicion(modoEdicion)

     $('#btnEditarServiciosTerceros').on('click', function () {
          setModoEdicion(!modoEdicion)
     })
})

function editST(ruta) {
     $('#FormEditarST')[0].reset()
     $.ajax({
          url: ruta,
          dataType: 'json',
          success: function (json) {
               $('#idServicio-Update').val(json.servicio.id_servicio_tercero)
               $('#codigo-Update').val(json.servicio.codigo_servicio_tercero)
               $('#descripcion-Update').val(json.servicio.descripcion)
               $('#precio-Update').val(json.servicio.pvp)
               $('#moneda-Update').val(json.servicio.moneda).change()
               let checked = json.servicio.estado == 1 ? true : false
               $('#estado-Update').prop('checked', checked)
               $('#FormEditarST').attr('action', json.ruta)

               if (json.servicio.servicios_terceros_solicitados.length >= 1) {
                    $('#codigo-Update').attr('readonly', '')
               } else {
                    $('#codigo-Update').removeAttr('readonly')
               }

               $('.marcas').prop('checked', false)
               $('.marcas').each(function () {
                    el = $(this)
                    marcasServicio = json.servicio.marcas_que_aplican
                    $.each(marcasServicio, function (key, value) {
                         console.log(value.marca_id)
                         if (el.attr('value') == value.marca_id) {
                              el.prop('checked', true)
                         }
                    })
               })
          },
          error: function (xhr, status) {
               //alert('Disculpe, existió un problema');
          },
     })
}

function updateST(btn) {
     $('#FormEditarST').submit()
}

function createST(btn) {
     alert()
     $('#FormCrearST').submit()
}

//permitir solo numeros, letras y -/
$('input.validable').bind('keypress', function (event) {
     var regex = new RegExp('^[a-zA-Z0-9 /-]+$')
     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode)
     if (!regex.test(key)) {
          event.preventDefault()
          return false
     }
})
