function find_modelo(model) {
     return Array.from(modelos).find((v) => String(v.nombre_modelo) === String(model))
}

const option = (text, value, modelo = false) => {
     const ele = document.createElement('option')
     ele.innerHTML = text
     ele.value = value
     // if (modelo && modelo === value) {
     //      ele.setAttribute('selected', true)
     // }
     return ele
}

$(function () {
     if (String(zero).trim() != '' && String(admin).trim() != '') {
          if (zero === '1') {
               if (admin === '1') {
                    Swal.fire({
                         icon: 'info',
                         title: 'Aviso',
                         text: 'Asigna acceso a los asesores de servicio para que programen citas',
                         confirmButtonText: 'Asignar acceso',
                         allowOutsideClick: false,
                         preConfirm: () => {
                              window.location.href = `${window.location.origin}/dealer_config?modal=access`
                         },
                    })
               } else {
                    Swal.fire({
                         icon: 'info',
                         title: 'Aviso',
                         text: 'Debes esperar a que asignen asesores de servicio para agendar nuevas citas',
                         allowOutsideClick: false,
                         confirmButtonText: 'Vale',
                    })
               }
          }
     }
     const toast = (icon = 'success', title = '', text, id) => {
          const inputPlaca = `#PlacaEdit-${id}`
          Swal.fire({
               icon,
               title,
               text,
               preConfirm: () => {
                    $(inputPlaca).val('')
               },
               willClose: () => {
                    $(inputPlaca).val('')
               },
          })
     }

     function searchVehicle(id, val) {
          var fechaIn = $('#fechaCitaIn').val()
          var link_completo = `${window.location.origin}/buscarCitaPlaca/${val}?fechaIn=${fechaIn}`

          $.get(link_completo, {}, function (data, status) {
               if (status == 'success') {
                    if (String(data).trim() != '') {
                         if (data.cita) {
                              const { marca_auto, modelo_auto, placa, cita } = data
                              const { fecha_cita, empleado } = cita
                              var infecha = moment(fecha_cita)
                              var fecha = infecha.format('DD/MM/YY')
                              var hora = infecha.format('LTS')
                              const asesor = String(empleado.usuario[0].username).toUpperCase()
                              toast(
                                   'error',
                                   '',
                                   `El vehículo ${marca_auto} de modelo ${modelo_auto} con placa ${placa} ya tiene una cita reservada para el día ${fecha} a las ${hora} horas con el asesor ${asesor}`,
                                   id,
                              )
                         } else {
                              $(`#marcaAuto-${id}`).val(data.id_marca_auto)
                              if (data.id_marca_auto === 1) {
                                   const fmodel = find_modelo(data.modelo_auto)
                                   if (fmodel) $(`#modeloSelectible-${id}`).val(fmodel.id_modelo)
                              } else {
                                   $(`#modeloSelectible-${id}`).addClass('none')
                                   $(`#modeloTextible-${id}`).addClass('block')
                                   $(`#modeloTextible-${id}`).val(data.modelo_auto)

                                   $(`#modelo_select-${id}`).removeClass('block').addClass('none')
                                   $(`#modelo_text-${id}`).removeClass('none').addClass('block')
                              }
                              if (data.modelo_auto) {
                                   $(`#marcaAuto-${id}`).prop('disabled', true)
                                   $(`#modeloSelectible-${id}`).prop('disabled', true)
                                   $(`#modeloTextible-${id}`).prop('disabled', true)
                              }

                              $(`#numeroClienteInfo-${id}`).val(data.num_doc)
                              $(`#nombreClienteInfo-${id}`).val(data.nombres)
                              $(`#telefonoClienteInfo-${id}`).val(data.celular)
                              $(`#correoClienteInfo-${id}`).val(data.email)
                         }
                    }
               }
          })
     }

     $('.placa_register').each(function () {
          $(this).on('blur', function () {
               if ($(this).val().length === 6) {
                    const id = this.getAttribute('id').replace('PlacaEdit-', '')
                    const val = $(this).val()
                    searchVehicle(id, val)
               }
          })
          $(this).on('keydown', function (e) {
               if ((String(e.key) === 'Enter' || String(e.key) === 'Tab') && $(this).val().length === 6) {
                    const id = this.getAttribute('id').replace('PlacaEdit-', '')
                    const val = $(this).val()
                    searchVehicle(id, val)
               }
          })
     })

     $("[id^='numeroClienteInfo']").change(function () {
          if ($(this).val().length > 6) {
               //consultar datos y llenar los campos del form
               var link_sub = '/buscarCliente/'
               var link_completo = rootURL + link_sub + $(this).val()

               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         $("[id^='nombreClienteInfo']").val(data.nombres)
                         $("[id^='telefonoClienteInfo']").val(data.celular)
                         $("[id^='correoClienteInfo']").val(data.email)
                         // setCliente(data);
                    }
               })
          }
     })

     /* 	$("[id^='infoCita-']").on('hide.bs.modal', function (e) {
		$("[id='PlacaEdit']").val("");
		$("[id='optionMarcaAuto']").text("");
		$("[id='modeloInfo']").val("");

		$("[id='numeroClienteInfo']").val("");
		$("[id='nombreClienteInfo']").val("");
		$("[id='telefonoClienteInfo']").val("");
		$("[id='correoClienteInfo']").val("");
	}); */

     $('#fechaCitaIn').on('change', function () {
          var link_sub = '/citas?fecha='
          var link_completo = rootURL + link_sub + $(this).val()
          window.location.href = link_completo
     })

     // $('#btnExportarCitas').on('click', function () {
     //      $('#exportarCitas').modal('hide')
     // })

     $("[id^='FormExportarCitas']").on('submit', function () {
          $('#exportarCitas').modal('hide')
     })

     // $("[id^='seeDate-']").on('click', function () {
     //      const id = this.getAttribute('id').replace('seeDate-', '')
     //      var esdetalle = document.querySelector(`#modeloSelectible-${id}`)

     //      if (!esdetalle) {

     //      }
     // })

     $('.register_link').on('click', function () {
          const id = this.getAttribute('id').replace('registerDate-', '')
          var esdetalle = document.querySelector(`#modeloSelectible-${id}`)

          if (esdetalle) {
               const valid = Array.from(modelos).filter((v) => String(v.id_marca_auto) === '1')
               $(`#modeloSelectible-${id}`).empty()
               valid.forEach((v) => $(`#modeloSelectible-${id}`).append(option(v.nombre_modelo, v.id_modelo)))
          }
     })

     $('.marca_auto').each(function () {
          $(this).on('change', function () {
               const id = this.getAttribute('id').replace('marcaAuto-', '')

               const _select = $(`#modelo_select-${id}`)
               const _text = $(`#modelo_text-${id}`)

               const showing = (sel, txt) => {
                    _select.addClass(sel ? 'block' : 'none')
                    _select.removeClass(sel ? 'none' : 'block')
                    _text.addClass(txt ? 'block' : 'none')
                    _text.removeClass(txt ? 'none' : 'block')
               }

               let valMarca = String($(`#marcaAuto-${id}`).val())

               const valid = Array.from(modelos).filter((v) => String(v.id_marca_auto) === valMarca)
               var isOnTextible = document.querySelector(`#modeloTextible-${id}`)
               var isOnSelectible = document.querySelector(`#modeloSelectible-${id}`)
               if (isOnTextible) isOnTextible.value = ''
               if (isOnSelectible) isOnSelectible.selectedIndex = '0'

               if (valid.length === 0) {
                    showing(false, true)
               } else {
                    showing(true, false)
                    $(`#modeloSelectible-${id}`).empty()
                    valid.forEach((v) => $(`#modeloSelectible-${id}`).append(option(v.nombre_modelo, v.id_modelo)))
               }
          })
     })

     // $('.marca_auto').on('change', function () {
     //      const id = this.getAttribute('id').replace('marcaAuto-', '')

     //      const _select = $(`#modelo_select-${id}`)
     //      const _text = $(`#modelo_text-${id}`)

     //      const showing = (sel, txt) => {
     //           _select.addClass(sel ? 'block' : 'none')
     //           _select.removeClass(sel ? 'none' : 'block')
     //           _text.addClass(txt ? 'block' : 'none')
     //           _text.removeClass(txt ? 'none' : 'block')
     //      }

     //      let valMarca = String($(`#marcaAuto-${id}`).val())

     //      const valid = Array.from(modelos).filter((v) => String(v.id_marca_auto) === valMarca)
     //      var isOnTextible = document.querySelector(`#modeloTextible-${id}`)
     //      var isOnSelectible = document.querySelector(`#modeloSelectible-${id}`)
     //      if (isOnTextible) isOnTextible.value = ''
     //      if (isOnSelectible) isOnSelectible.selectedIndex = '0'

     //      if (valid.length === 0) {
     //           showing(false, true)
     //      } else {
     //           showing(true, false)
     //           $(`#modeloSelectible-${id}`).empty()
     //           valid.forEach((v) => $(`#modeloSelectible-${id}`).append(option(v.nombre_modelo, v.id_modelo)))
     //      }

     //      // if (valMarca === 'all') {
     //      //      showing(true, false)
     //      // } else if (valMarca === '1') {
     //      //      document.querySelector(`#modeloTextible-${id}`).value = ''
     //      //      showing(true, false)
     //      //      const valid = Array.from(modelos).filter((v) => String(v.id_marca_auto) === valMarca)
     //      //      $(`#modeloSelectible-${id}`).empty()
     //      //      valid.forEach((v) => $(`#modeloSelectible-${id}`).append(option(v.nombre_modelo, v.id_modelo)))
     //      // } else if (valMarca === 'none') {
     //      // } else {
     //      //      var isOnSelectible = document.querySelector(`#modeloSelectible-${id}`)
     //      //      if (isOnSelectible) {
     //      //           isOnSelectible.selectedIndex = '0'
     //      //      }
     //      //      showing(false, true)
     //      // }
     // })

     $("[id^='formEditarCita']").on('submit', function (e) {
          e.preventDefault()
          const data_form = $(this).serializeArray()
          var data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})
          const id = this.getAttribute('data-idformcita')
          console.log(data)
          console.log(id)

          const error_marca = $(`#error-marca-${id}`)
          const error_modelo = $(`#error-modelo-${id}`)
          const error_nombre_modelo = $(`#error-nombre_modelo-${id}`)

          if (data.marca === 'none') error_marca.text('Seleccione marca')
          else {
               error_marca.text('')
               if (data.marca === '1') {
                    if (data.modelo === 'none') error_modelo.text('Seleccione un modelo')
                    error_modelo.text('')
               } else {
                    if (String(data.nombre_modelo).trim() === '') error_nombre_modelo.text('Ingrese modelo')
                    error_nombre_modelo.text('')
               }

               if (
                    error_marca.text().trim() === '' &&
                    error_modelo.text().trim() === '' &&
                    error_nombre_modelo.text().trim() === ''
               ) {
                    const tipo = $(`#tipoIn-${id}`).val()
                    const detalle = $(`#detalleServicioInfo-${id}`).val()
                    const observaciones = $(`#observacionesIn-${id}`).val()
                    const contacto = $(`#nombreClienteInfo-${id}`).val()
                    const telefono = $(`#telefonoClienteInfo-${id}`).val()
                    const correo = $(`#correoClienteInfo-${id}`).val()

                    data = { ...data, tipo, detalle, observaciones, contacto, telefono, correo }

                    $(`#cita-detalle-close-${id}`).prop('disabled', true)
                    $(`#btnEditarCita-${id}`).prop('disabled', true)
                    $(`#btnCancelarCita-${id}`).prop('disabled', true)

                    $.ajax({
                         url: $(this).attr('action'),
                         type: 'POST',
                         data,
                         success: function (data) {
                              window.location.reload()
                         },
                         error: function (jXHR, textStatus, errorThrown) {
                              alert(errorThrown)
                         },
                    })
               }
          }
     })

     const OPCIONES = Object(opciones)
     const HORARIOS = Object.keys(OPCIONES)

     $('.reprogramation').each(function () {
          $(this).on('change', function (e) {
               const ID = this.getAttribute('id').replace('fechaReprogramacion-', '')
               const FECHA_SELECCIONADA = moment(String(e.target.value).split('/').reverse().join('-'))
               const DAY_NAME = FECHA_SELECCIONADA.format('dddd').toUpperCase()

               var ID_HORARIO = null

               HORARIOS.forEach((horario) => {
                    const CONFIG = OPCIONES[horario].CONFIG
                    const { aplica_desde: APLICA_DESDE, aplica_hasta: APLICA_HASTA } = CONFIG
                    var MOMENT_DESDE = null,
                         MOMENT_HASTA = null
                    if (APLICA_DESDE) MOMENT_DESDE = moment(APLICA_DESDE)
                    if (APLICA_HASTA) MOMENT_HASTA = moment(APLICA_HASTA)

                    var DIFF_DESDE = -1,
                         DIFF_HASTA = 1

                    if (MOMENT_DESDE) DIFF_DESDE = FECHA_SELECCIONADA.diff(MOMENT_DESDE, 'days')
                    if (MOMENT_HASTA) DIFF_HASTA = FECHA_SELECCIONADA.diff(MOMENT_HASTA, 'days')
                    else DIFF_HASTA = -9999

                    if (DIFF_DESDE >= 0 && DIFF_HASTA <= 0) {
                         ID_HORARIO = horario                        
                    }
               })

               if (ID_HORARIO) {
                    const NUEVO_HORARIO = OPCIONES[ID_HORARIO]
                    const HORAS = NUEVO_HORARIO[DAY_NAME]
                    if (HORAS) {
                         var HORAS_ARRAY = Array.from(HORAS)
                         const SELECTOR = $(`#horaReprogramacion-${ID}`)
                         SELECTOR.empty()
                         HORAS_ARRAY.forEach((hora) => SELECTOR.append(option(hora, hora)))
                    }
               }
          })
     })
})
