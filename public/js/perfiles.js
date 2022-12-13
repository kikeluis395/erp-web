$(function () {
     $('[data-toggle="tooltip"]').tooltip()

     $("[id^='deleteUSER']").on('submit', function (e) {
          e.preventDefault()
          Swal.fire({
               icon: 'question',
               title: '¿Seguro que quieres eliminar este usuario?',
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

     function insertUrlParam(key, value) {
          if (history.pushState) {
               let searchParams = new URLSearchParams(window.location.search)
               searchParams.set(key, value)
               let newurl =
                    window.location.protocol +
                    '//' +
                    window.location.host +
                    window.location.pathname +
                    '?' +
                    searchParams.toString()
               window.history.pushState({ path: newurl }, '', newurl)
          }
     }
     function sinVocals(word) {
          word = String(word).toUpperCase()
          const vocals = { Á: 'a', É: 'e', Í: 'i', Ó: 'o', Ú: 'u' }
          Object.keys(vocals).forEach((vocal) => {
               word = word.replace(vocal, vocals[vocal])
          })
          return String(word).toLowerCase()
     }
     $('#myTab .nav-link').on('click', function (e) {
          var tab = this.getAttribute('data-tab')
          insertUrlParam('tab', tab)
     })

     $('.area_rol').each(function () {
          $(this).on('change', function (e) {
               var area = $(this).val()
               insertUrlParam('area', area)

               const container = this.getAttribute('data-container-tabs')

               $(`#${container}`)
                    .children()
                    .each(function () {
                         $(this).removeClass('show').removeClass('active')
                    })

               $(`#${container} a[href="#${container}_${sinVocals(area)}"]`).tab('show')
          })
     })

     const permisos = { ver: 'editar', editar: 'ver' }

     $('.btn-admin, .btn-report').each(function () {
          $(this).on('click', function (e) {
               const id = this.getAttribute('for')
               const label = this.getAttribute('id')

               var [permiso, unique] = String(id).split('-')

               var checked = this.classList.contains('btn-primary')

               if (checked) {
                    $(`#${label}`).removeClass('btn-primary').addClass('btn-outline-primary')
               } else {
                    $(`#${label}`).removeClass('btn-outline-primary').addClass('btn-primary')
                    $(`#label-${permisos[permiso]}-${unique}`)
                         .removeClass('btn-primary')
                         .addClass('btn-outline-primary')
               }
          })
     })
     function reduceLabels(labels) {
          return labels.reduce((o, v) => {
               const id = v.getAttribute('for')
               const classes = v.classList
               var [permiso, unique] = id.split('-')
               unique = unique.replace('R', '').replace('P', '_')
               var res = ''
               if (o[unique]) res += `${o[unique]}_`
               res += `${permiso.charAt(0).toUpperCase()}${classes.contains('btn-primary') ? 1 : 0}`
               o[unique] = res
               return o
          }, {})
     }

     function loadPost(url, data, title = 'Guardando configuracion', metodo = 'POST') {
          Swal.fire({ allowOutsideClick: false, title })
          Swal.showLoading()
          $.ajax({
               url,
               type: metodo,
               data,
               success: function (res) {
                    if (res.success) {
                         // console.log(res)
                         window.location.reload()
                    }
               },
               error: function (jXHR, textStatus, errorThrown) {
                    // console.log(jXHR)
                    // console.log(textStatus)
                    // console.log(errorThrown)
                    alert(errorThrown)
               },
          })
     }

     $('#formModulosRoles').on('submit', function (e) {
          e.preventDefault()
          const label = Array.from($(`.btn-admin`))

          const data = reduceLabels(label)

          var token = $(this).serializeArray()

          data._token = token[0].value

          loadPost($(this).attr('action'), data)
     })

     $('#formSubmodulosReportes').on('submit', function (e) {
          e.preventDefault()
          const label = Array.from($(`.btn-report`))

          const data = reduceLabels(label)
          var token = $(this).serializeArray()

          data._token = token[0].value
          // console.log(data)
          loadPost($(this).attr('action'), data)
     })

     $('#FormCrearUser').on('submit', function (e) {
          e.preventDefault()
          const data_form = $(this).serializeArray()
          var data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          var dni = String(data.dni)
          if (dni.length != 8) $('#errorDNI').text('DNI invalido')
          else $('#errorDNI').text('')

          if (dni.length === 8 && $('#username').val().length > 0) {
               data.username = $('#username').val()
               if (data.id_rol === 'none') $(`#error_userRol`).text('Selecciona un rol')
               else $(`#error_userRol`).text('')

               var addons = Array.from($('#perfiles_creator .rol_addon')).reduce(
                    (o, v, i) => ({ ...o, [`${i}_${v.value}`]: `error_${v.id}` }),
                    {},
               )
               var keys = Object.keys(addons)
               var count_none = 0

               var roles_byProcess = []
               keys.forEach((v) => {
                    if (v.includes('none')) {
                         $(`#${addons[v]}`).text('Selecciona un rol')
                         count_none += 1
                    }
                    roles_byProcess.push(v.split('_')[1])
               })
               roles_byProcess.push(data.id_rol)

               var initial_len = roles_byProcess.length
               var final_len = [...new Set(roles_byProcess)].length

               if (initial_len != final_len) {
                    var roles_cuestionados = [...new Set(roles_byProcess)]
                    Array.from($('#perfiles_creator .rol_addon')).forEach((v) => {
                         const error_container = `#error_${v.id}`

                         if (roles_cuestionados.find((a) => String(a) === String(v.value)))
                              $(`${error_container}`).text('Rol duplicado')
                         else $(`${error_container}`).text('')
                    })
               }

               if (
                    !keys.find((v) => v.includes('none')) &&
                    count_none === 0 &&
                    !keys.find((v) => {
                         var split = v.split('_')
                         if (split.length === 2) return split[1] === data.id_rol
                         return false
                    }) &&
                    data.id_rol != 'none' &&
                    initial_len === final_len
               ) {
                    data.roles_adicionales = keys.reduce((o, v) => [...o, v.split('_')[1]], [])
                    // console.log(data)
                    loadPost($(this).attr('action'), data, 'Creando Usuario')
               }
          }
     })
     $("[id^='FormEditarUser']").on('submit', function (e) {
          e.preventDefault()
          const id = this.getAttribute('id').replace('FormEditarUser-', '')

          const data_form = $(this).serializeArray()
          var data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          var dni = String($(`#userDni-${id}`).val())
          // if (dni.length != 8) $(`#errorDNI-${id}`).text('DNI invalido')
          // else $(`#errorDNI-${id}`).text('')

          if (dni.length > 0 && $(`#username-${id}`).val().length > 0) {
               if (data.id_rol === 'none') $(`#error_userRol-${id}`).text('Selecciona un rol')
               else $(`#error_userRol-${id}`).text('')

               var addons = Array.from($(`#perfiles_${id} .rol_addon`)).reduce(
                    (o, v, i) => ({ ...o, [`${i}_${v.value}`]: `error_${v.id}` }),
                    {},
               )

               var keys = Object.keys(addons)
               var count_none = 0

               var roles_byProcess = []
               keys.forEach((v) => {
                    if (v.includes('none')) {
                         $(`#${addons[v]}`).text('Selecciona un rol')
                         count_none += 1
                    }
                    roles_byProcess.push(v.split('_')[1])
               })
               roles_byProcess.push(data.id_rol)

               var initial_len = roles_byProcess.length
               var final_len = [...new Set(roles_byProcess)].length

               if (initial_len != final_len) {
                    var roles_cuestionados = [...new Set(roles_byProcess)]
                    Array.from($(`#perfiles_${id} .rol_addon`)).forEach((v) => {
                         const error_container = `#error_${v.id}`

                         if (roles_cuestionados.find((a) => String(a) === String(v.value)))
                              $(`${error_container}`).text('Rol duplicado')
                         else $(`${error_container}`).text('')
                    })
               }

               if (
                    !keys.find((v) => v.includes('none')) &&
                    count_none === 0 &&
                    !keys.find((v) => {
                         var split = v.split('_')
                         if (split.length === 2) return split[1] === data.id_rol
                         return false
                    }) &&
                    data.id_rol != 'none' &&
                    initial_len === final_len
               ) {
                    data.roles_adicionales = keys.reduce((o, v) => [...o, v.split('_')[1]], [])
                    if (String(data.password).trim() === '') delete data.password
                    data.habilitado = eval_check(document.querySelector(`.habilitado-${id}`).checked)
                    delete data[`habilitado-${id}`]
                    // console.log(keys)
                    // console.log(data)
                    loadPost($(this).attr('action'), data, 'Guardando Usuario', 'PATCH')
               }
          }
     })

     function wSpecial(word) {
          return String(word).replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '')
     }

     $('.names').on('change', function (e) {
          const names = String($(this).val())
          const flname = String($('.flname').val())

          if (names.trim().length > 0 && flname.trim().length > 0) {
               $('#username').val(wSpecial(''.concat(names.charAt(0)).concat(flname.split(' ')[0]).toLowerCase()))
          } else $('#username').val('')
     })

     $('.flname').on('change', function (e) {
          const flname = String($(this).val())
          const names = String($('.names').val())

          if (names.trim().length > 0 && flname.trim().length > 0) {
               $('#username').val(wSpecial(''.concat(names.charAt(0)).concat(flname.split(' ')[0]).toLowerCase()))
          } else $('#username').val('')
     })

     const option = (text, value) => {
          const ele = document.createElement('option')
          ele.innerHTML = text
          ele.value = value
          return ele
     }

     function already_rols(selects, actual_id) {
          return selects.reduce((o, v) => {
               const value = String(v.value)
               const id = String(v.getAttribute('id'))
               if (id != actual_id) o.push(value)
               return o
          }, [])
     }
     function span(text) {
          var ele = document.createElement('span')
          ele.innerHTML = text
          return ele
     }
     function individual_div(text) {
          var ele = document.createElement('div')
          ele.className = 'col-5 d-flex mx-0 px-1'
          ele.style.flexDirection = 'column'
          return ele
     }

     $('.btn-add-rol').on('click', function () {
          const container_append = this.getAttribute('data-append-id')
          var usuario = this.getAttribute('data-unique')
          var unique = Math.random().toString(36).substr(2, 6)
          var container = $(`#${container_append}`)
          var number_children = Array.from(container.children()).length

          var rol = document.createElement('div')
          rol.className = 'row w-100 mx-0 mb-3'
          rol.id = unique

          var primer_selector = individual_div()
          var segundo_selector = individual_div()

          var area = document.createElement('select')
          area.className = 'form-control area_get'
          area.setAttribute('data-rol-select', `rol_addon_${unique}`)
          area.addEventListener('change', function (e) {
               const val = $(this).val()
               const id = this.getAttribute('data-rol-select')

               var select_sibling = $(`#${id}`)
               select_sibling.empty()
               ;[{ nombre_rol: '-', id_rol: 'none', area: val }]
                    .concat(Array.from(roles))
                    .filter((v) => v.area === val)
                    .map((r) => option(r.nombre_rol, r.id_rol))
                    .forEach((o) => select_sibling.append(o))
          })
          area.append(option('-', 'none'))
          Array.from(areas)
               .map((r) => option(r, r))
               .forEach((o) => area.append(o))

          var select = document.createElement('select')
          select.className = 'form-control rol_get rol_addon'
          select.setAttribute('name', `RA_${number_children + 1}`)
          select.setAttribute('id', `rol_addon_${unique}`)
          select.setAttribute('data-all-selects', `perfiles_${usuario}`)
          select.addEventListener('change', function (e) {
               const val = $(this).val()
               const id = this.getAttribute('id')

               const all_select_id = this.getAttribute('data-all-selects')
               let selects = Array.from($(`#${all_select_id} .rol_get`))
               // console.log(`#${all_select_id} .rol_get`)
               // console.log(selects)
               // let selects = Array.from($('.rol_get'))
               let already = already_rols(selects, id)
               // console.log(already)

               if (already.find((v) => String(v) === String(val))) $(`#error_${id}`).text('Ya seleccionaste este rol')
               else $(`#error_${id}`).text('')
          })
          ;[{ nombre_rol: '-', id_rol: 'none' }]
               // .concat(Array.from(roles))
               .map((r) => option(r.nombre_rol, r.id_rol))
               .forEach((o) => select.append(o))

          var error = document.createElement('div')
          error.className = 'col-12 validation-error-cont text-right no-gutters pr-0'
          error.setAttribute('id', `error_rol_addon_${unique}`)

          var minus = document.createElement('a')
          minus.className = 'col-sm-2 align-items-center d-flex justify-content-end'
          minus.style.textDecoration = 'none'
          minus.setAttribute('href', '#')
          minus.addEventListener('click', function () {
               $(`#${unique}`).remove()
          })

          var icon = document.createElement('i')
          icon.className = 'fas fa-minus'
          minus.append(icon)

          primer_selector.append(span('Area:'))
          primer_selector.append(area)

          segundo_selector.append(span('Rol:'))
          segundo_selector.append(select)

          // rol.append(label)
          rol.append(primer_selector)
          rol.append(segundo_selector)
          rol.append(minus)
          rol.append(error)

          container.append(rol)
     })
     // $('.btn-add-rol').on('click', function () {
     //      var unique = Math.random().toString(36).substr(2, 6)
     //      var container = $('#roles_adicionales')
     //      var number_children = Array.from(container.children()).length

     //      var rol = document.createElement('div')
     //      rol.className = 'form-group d-flex xscroll_none'
     //      rol.id = unique

     //      var label = document.createElement('label')
     //      label.className = 'col-sm-5 justify-content-end'
     //      label.setAttribute('for', `rol_addon_${number_children + 1}`)
     //      label.innerHTML = `ROL SECUNDARIO:`

     //      var select = document.createElement('select')
     //      select.className = 'form-control col-sm-6 rol_get rol_addon'
     //      select.setAttribute('name', `RA_${number_children + 1}`)
     //      select.setAttribute('id', `rol_addon_${unique}`)
     //      select.addEventListener('change', function (e) {
     //           const val = $(this).val()
     //           const id = this.getAttribute('id')
     //           let selects = Array.from($('.rol_get'))
     //           let already = already_rols(selects, id)
     //           console.log(already)
     //           if (already.find((v) => String(v) === String(val))) $(`#error_${id}`).text('Ya seleccionaste este rol')
     //           else $(`#error_${id}`).text('')
     //      })
     //      ;[{ nombre_rol: '-', id_rol: 'none' }]
     //           .concat(Array.from(roles))
     //           .map((r) => option(r.nombre_rol, r.id_rol))
     //           .forEach((o) => select.append(o))

     //      var error = document.createElement('div')
     //      error.className = 'col-12 validation-error-cont text-right no-gutters pr-0'
     //      error.setAttribute('id', `error_rol_addon_${unique}`)

     //      var minus = document.createElement('a')
     //      minus.className = 'col-sm-1 align-items-center d-flex'
     //      minus.style.textDecoration = 'none'
     //      minus.setAttribute('href', '#')
     //      minus.addEventListener('click', function () {
     //           $(`#${unique}`).remove()
     //      })

     //      var icon = document.createElement('i')
     //      icon.className = 'fas fa-minus'
     //      minus.append(icon)

     //      rol.append(label)
     //      rol.append(select)
     //      rol.append(minus)
     //      rol.append(error)

     //      container.append(rol)
     // })

     $('.rol_get').each(function () {
          $(this).on('change', function () {
               const val = $(this).val()
               const id = this.getAttribute('id')
               const all_select_id = this.getAttribute('data-all-selects')

               let selects = Array.from($(`#${all_select_id} .rol_get`))
               // console.log(`#${all_select_id} .rol_get`)
               // console.log(selects)
               let already = already_rols(selects, id)

               // console.log(already)
               if (already.find((v) => String(v) === String(val))) $(`#error_${id}`).text('Ya seleccionaste este rol')
               else $(`#error_${id}`).text('')
          })
     })

     $('.area_get').each(function () {
          $(this).on('change', function () {
               const val = $(this).val()
               const id = this.getAttribute('data-rol-select')

               var select_sibling = $(`#${id}`)
               select_sibling.empty()
               ;[{ nombre_rol: '-', id_rol: 'none', area: val }]
                    .concat(Array.from(roles))
                    .filter((v) => v.area === val)
                    .map((r) => option(r.nombre_rol, r.id_rol))
                    .forEach((o) => select_sibling.append(o))

               // let selects = Array.from($('.rol_get'))
               // let already = already_rols(selects, id)

               // console.log(already)
               // if (already.find((v) => String(v) === String(val))) $(`#error_${id}`).text('Ya seleccionaste este rol')
               // else $(`#error_${id}`).text('')
          })
     })
     $('.loaded_rols').each(function () {
          $(this).on('click', function () {
               const container = this.getAttribute('data-unique')
               $(`#${container}`).remove()
          })
     })
})
