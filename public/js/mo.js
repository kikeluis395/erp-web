$(function () {
     function loadPost(url, data, title = 'Guardando configuracion', metodo = 'POST') {
          Swal.fire({ allowOutsideClick: false, title })
          Swal.showLoading()
          $.ajax({
               url,
               type: metodo,
               data,
               success: function (res) {
                    if (res.success) {
                         window.location.reload()
                    }
               },
               error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown)
               },
          })
     }

     const monedas = {
          S: { name: 'SOLES', symbol: 'S/' },
          D: { name: 'DÓLARES', symbol: '$' },
          C: {
               S: 'D',
               D: 'S',
          },
     }
     function changeMoneda(id, moneda) {
          $(`#${id}.moneda_switch`).siblings('label')[0].innerText = monedas[moneda].name
     }

     $('.moneda_switch').on('change', function (e) {
          let checked = e.target.checked
          let id = this.getAttribute('id')

          var moneda = 'S'
          if (checked) moneda = 'D'

          changeMoneda(id, moneda)
     })

     const personal = {
          P: { tipo: 'PERSONAL PROPIO', bCosto: 'flex', tTercero: 'none', cSection: 'none' },
          T: { tipo: 'PERSONAL TERCERO', bCosto: 'none', tTercero: 'block', cSection: 'flex' },
          C: { P: null, T: true },
          I: { P: 'T', T: 'P' },
     }

     function changePersonal(tipo) {
          $('.tipo_personal').siblings()[0].innerText = personal[tipo].tipo
          $('#costo_mensual').css('display', personal[tipo].bCosto)
          $('.table_section').css('display', personal[tipo].tTercero)
          $('.context_section').css('display', personal[tipo].cSection)
          $('#alert_costos').css('display', personal[tipo].cSection)
          $('.tipo_personal').prop('checked', personal.C[tipo])
          if (document.querySelector('.metodo_costo_in')) $('.metodo_costo_in').css('display', personal[tipo].cSection)
     }

     function alertChangePersonal(onCancel) {
          Swal.fire({
               icon: 'question',
               title: '¿Seguro que quieres cambiar el método de costos?',
               confirmButtonText: 'Aceptar',
               denyButtonText: 'Cancelar',
               showCancelButton: false,
               showDenyButton: true,
               preConfirm: () => {
                    // window.location.reload()
               },
               allowOutsideClick: false,
               preDeny: onCancel,
          })
     }

     $('.tipo_personal').on('change', function (e) {
          let checked = e.target.checked

          var tipo = 'P'
          if (checked) tipo = 'T'

          changePersonal(tipo)
          alertChangePersonal(() => {
               changePersonal(personal.I[tipo])
          })
     })

     const metodos = {
          M: {
               tipo: 'MONEDA',
               bMoneda: 'flex',
               percentage: 'none',
               glose: 'Colocar costo H-H sin igv',
               panho: 'Colocar costo paño sin igv',
          },
          P: {
               tipo: 'PORCENTAJE',
               bMoneda: 'none',
               percentage: 'block',
               glose: 'Colocar % de la H-H que cobrará el tercero',
               panho: 'Colocar % de paño que cobrará el tercero',
          },
     }

     function changeMetodo(metodo) {
          const V = metodos[metodo]
          $('.metodo_costo').siblings()[0].innerText = V.tipo
          $('.in_coin').css('display', V.bMoneda)
          $('.percentaje').css('display', V.percentage)

          if ($('.glose_cost')[0]) $('.glose_cost')[0].innerText = V.glose
          if ($('.glose_panho')[0]) $('.glose_panho')[0].innerText = V.panho
     }

     $('.metodo_costo').on('change', function (e) {
          let checked = e.target.checked

          var metodo = 'M'
          if (checked) metodo = 'P'

          changeMetodo(metodo)
     })

     if (seccion === 'MEC' || seccion === 'DYP') {
          changeMetodo('M')
     }

     const _m = { SOLES: 'SOLES', DÓLARES: 'DOLARES', DOLARES: 'DOLARES' }
     const _t = { 'PERSONAL PROPIO': 'PROPIO', 'PERSONAL TERCERO': 'TERCERO' }

     function evalEmpty(val) {
          if (String(val).trim() === '') return 0
          return val
     }
     function naming(input = []) {
          return input.reduce((o, v) => ({ ...o, [v.getAttribute('name')]: evalEmpty(v.value) }), {})
     }

     $('#formPrecioServicio').on('submit', function (e) {
          e.preventDefault()
          const indata = $(this).serializeArray()
          var incoming = indata.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          var modify_costo = false,
               modify_precio = false,
               invalido = false

          const { precio_valor_venta, valor_costo } = incoming

          if (String(precio_valor_venta).trim() === '') invalido = true

          const precio_moneda = $('#monedaPrecioServicio').siblings('label').text()
          const tipo_personal = $('#tipoPersonal').siblings('label').text()
          const metodo_costo = $('#tipoMetodoCosto').siblings('label').text()
          const costo_moneda = $('#monedaCostoAsociado').siblings('label').text()

          if (_t[tipo_personal] === 'TERCERO') {
               if (String(valor_costo).trim() === '') invalido = true
          }

          if (invalido) {
               Swal.fire({
                    icon: 'info',
                    toast: true,
                    text: 'Completa todos los campos',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
               })
          } else {
               if (precio) {
                    if (Object.keys(precio).length > 0) {
                         const { precio_valor_venta: actual_precio_hh, moneda: actual_precio_moneda } = precio
                         if (
                              String(actual_precio_hh) != String(precio_valor_venta) ||
                              String(actual_precio_moneda) != String(precio_moneda)
                         ) {
                              modify_precio = true
                         }
                    }
               }

               if (costo) {
                    if (Object.keys(costo).length > 0) {
                         const {
                              tipo_personal: actual_tipo_personal,
                              valor_costo: actual_costo,
                              metodo_costo: actual_metodo_costo,
                              moneda: actual_moneda,
                         } = costo

                         if (actual_tipo_personal === 'TERCERO') {
                              if (
                                   String(actual_tipo_personal) != String(_t[tipo_personal]) ||
                                   String(actual_costo) != String(valor_costo) ||
                                   String(actual_metodo_costo) != String(metodo_costo) ||
                                   String(actual_moneda) != String(_m[costo_moneda])
                              ) {
                                   modify_costo = true
                              }
                         } else {
                              if (actual_tipo_personal != _t[tipo_personal]) {
                                   modify_costo = true
                              }
                         }
                    }
               }

               if (precio_exists === '0') modify_precio = true
               if (costo_exists === '0') modify_costo = true

               var data = {
                    modify_precio,
                    modify_costo,
                    precio_valor_venta,
                    moneda_precio: _m[precio_moneda],
                    tipo_personal: _t[tipo_personal],
                    metodo_costo,
                    moneda_costo: _m[costo_moneda],
                    valor_costo,
                    _token: incoming._token,
               }
               loadPost($(this).attr('action'), data)
               console.log(data)
          }
     })

     $('#formStoreMensualidad').on('submit', function (e) {
          e.preventDefault()
          const indata = $(this).serializeArray()
          var incoming = indata.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})
          // var _token = incoming._token

          const texts = Array.from($('.valor_costo'))
          const selects = Array.from($('.moneda_input'))

          // console.log(naming(texts))
          var data = { ...incoming, ...naming(texts), ...naming(selects) }
          // console.log(data)
          loadPost($(this).attr('action'), data)
     })

     $('#formCarroceria').on('submit', function (e) {
          e.preventDefault()
          const indata = $(this).serializeArray()
          var incoming = indata.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          var modify_costo = false,
               modify_precio = false,
               modify_precio_specific = {},
               modify_criterio = false,
               modify_criterio_specific = {},
               invalido = false

          console.log(incoming)

          Object.keys(incoming).forEach((v) => {
               const valor = incoming[v]

               if (v.includes('precio_valor_venta_') || v.includes('moneda_') || v.includes('CRI_')) {
                    if (String(valor).trim() === '') invalido = true
               }
          })

          var tipo_personal = $('#tipoPersonal').siblings('label').text()

          var metodo_costo = $('#tipoMetodoCosto').siblings('label').text()
          var moneda_hh = $('#monedaCostoCarroceria').siblings('label').text()
          var moneda_panhos = $('#monedaCostoPanho').siblings('label').text()

          var costos_asociados = { tipo_personal: _t[tipo_personal] }

          const { costo_PANHOS: valor_costo_hh, costo_HH: valor_costo_panhos } = incoming

          if (_t[tipo_personal] === 'TERCERO') {
               if (String(valor_costo_hh).trim() === '') invalido = true
               if (String(valor_costo_panhos).trim() === '') invalido = true
               costos_asociados = {
                    valor_costo_hh,
                    valor_costo_panhos,
                    tipo_personal: _t[tipo_personal],
                    metodo_costo,
                    moneda_hh: _m[moneda_hh],
                    moneda_panhos: _m[moneda_panhos],
               }
          }

          if (invalido) {
               Swal.fire({
                    icon: 'info',
                    toast: true,
                    text: 'Completa todos los campos',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
               })
          } else {
               if (precio) {
                    if (Object.keys(precio).length > 0) {
                         Object.keys(incoming).forEach((v) => {
                              const actual = precio[v]
                              const valor = incoming[v]

                              // if (v.includes('precio_valor_venta_')) {
                              //      const unique = v.replace('precio_valor_venta_', '')
                              //      if (String(actual) != String(valor)) {
                              //           modify_precio = true
                              //           modify_precio_specific = {
                              //                ...modify_precio_specific,
                              //                [`modify_precio_specific_valor_${unique}`]: valor,
                              //           }
                              //      }
                              // }
                              // if(v.includes('moneda_')){
                              //      const unique = v.replace('moneda_', '')
                              //      if (String(actual) != String(valor)) {
                              //           modify_precio = true
                              //           modify_precio_specific = {
                              //                ...modify_precio_specific,
                              //                [`modify_precio_specific_moneda_${unique}`]: valor,
                              //           }
                              //      }
                              // }
                              const unique = v.replace('precio_valor_venta_', '').replace('moneda_', '')

                              if (v.includes('precio_valor_venta_') || v.includes('moneda_')) {
                                   var actual_precio_val = precio[`precio_valor_venta_${unique}`]

                                   if (v.includes('precio_valor_venta_')) {
                                        var precio_moneda_val = precio[`moneda_${unique}`]
                                        var incoming_moneda_val = incoming[`moneda_${unique}`]

                                        if (String(actual) != String(valor)) {
                                             modify_precio = true

                                             modify_precio_specific = {
                                                  ...modify_precio_specific,
                                                  [`modify_precio_specific_${unique}`]: `${valor}_#M`,
                                             }
                                        } else {
                                             if (String(precio_moneda_val) != String(incoming_moneda_val)) {
                                                  modify_precio = true

                                                  modify_precio_specific = {
                                                       ...modify_precio_specific,
                                                       [`modify_precio_specific_${unique}`]: `${actual}_#M`,
                                                  }
                                             }
                                        }
                                   }
                                   if (v.includes('moneda_')) {
                                        var precio_valor_val = precio[`precio_valor_venta_${unique}`]
                                        var incoming_valor_val = incoming[`precio_valor_venta_${unique}`]

                                        var existe = modify_precio_specific[`modify_precio_specific_${unique}`]
                                        var final = ''

                                        if (String(actual) != String(valor)) {
                                             modify_precio = true

                                             if (!!existe) final = existe.replace('_#M', `_${valor}`)
                                             else final = `${precio_valor_val}_${valor}`

                                             modify_precio_specific = {
                                                  ...modify_precio_specific,
                                                  [`modify_precio_specific_${unique}`]: final,
                                             }
                                        } else {
                                             if (String(precio_valor_val) != String(incoming_valor_val)) {
                                                  modify_precio = true

                                                  if (!!existe) final = existe.replace('_#M', `_${actual}`)
                                                  else final = `${incoming_valor_val}_${actual}`

                                                  modify_precio_specific = {
                                                       ...modify_precio_specific,
                                                       [`modify_precio_specific_${unique}`]: final,
                                                  }
                                             }
                                        }
                                   }
                              }
                         })

                         // const { precio_valor_venta: actual_precio_hh, moneda: actual_precio_moneda } = precio
                         // if (
                         //      String(actual_precio_hh) != String(precio_valor_venta) ||
                         //      String(actual_precio_moneda) != String(precio_moneda)
                         // ) {
                         //      modify_precio = true
                         // }
                    }
               }

               if (costo) {
                    if (Object.keys(costo).length > 0) {
                         // console.log(costo)
                         const {
                              tipo_personal: actual_tipo_personal,
                              valor_costo_hh: actual_costo_hh,
                              valor_costo_panhos: actual_costo_panhos,
                              metodo_costo_hh: actual_metodo_costo_hh,
                              metodo_costo_panhos: actual_metodo_costo_panhos,
                              moneda_hh: actual_moneda_hh,
                              moneda_panhos: actual_moneda_panhos,
                         } = costo

                         const {
                              tipo_personal: income_tipo_personal,
                              valor_costo_hh: income_valor_costo_hh,
                              valor_costo_panhos: income_valor_costo_panhos,
                              metodo_costo: income_metodo_costo,
                              moneda_hh: income_moneda_hh,
                              moneda_panhos: income_moneda_panhos,
                         } = costos_asociados

                         if (actual_tipo_personal === 'TERCERO') {
                              if (
                                   String(actual_tipo_personal) != String(income_tipo_personal) ||
                                   String(actual_costo_panhos) != String(income_valor_costo_panhos) ||
                                   String(actual_metodo_costo_hh) != String(income_metodo_costo) ||
                                   String(actual_metodo_costo_panhos) != String(income_metodo_costo) ||
                                   String(actual_moneda_hh) != String(income_moneda_hh) ||
                                   String(actual_moneda_panhos) != String(income_moneda_panhos)
                              ) {
                                   modify_costo = true
                              }
                         } else {
                              if (actual_tipo_personal != income_tipo_personal) {
                                   modify_costo = true
                              }
                         }
                    }
               }

               if (danhos) {
                    if (Object.keys(danhos).length > 0) {
                         Object.keys(incoming).forEach((v) => {
                              if (v.includes('CRI_')) {
                                   const valor = incoming[v]
                                   const entire = v.replace('CRI_', '').split('_')
                                   if (entire.length >= 3) {
                                        var [seccion, tipo, limite, criterio] = entire
                                        const actual = danhos[seccion][tipo][limite].valor
                                        if (String(actual) != String(valor)) {
                                             modify_criterio = true
                                             modify_criterio_specific = {
                                                  ...modify_criterio_specific,
                                                  [`modify_criterio_specific_${criterio}`]: valor,
                                             }
                                        }
                                   }
                              }
                         })
                    }
               }

               if (precio_exists === '0') modify_precio = true
               if (costo_exists === '0') modify_costo = true
               if (danhos_exists === '0') modify_criterio = true

               var data = {
                    _token: incoming._token,
                    modify_precio,
                    modify_costo,
                    modify_criterio,
                    ...costos_asociados,
                    ...modify_precio_specific,
                    ...modify_criterio_specific,
               }
               loadPost($(this).attr('action'), data)
               console.log(data)
          }
     })

     $('#formPrecioPDI').on('submit', function (e) {
          e.preventDefault()
          const indata = $(this).serializeArray()
          var incoming = indata.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          var modify_precio = false,
               invalido = false,
               modifies = {}

          var count_inexist = 0
          Object.keys(precio).forEach((tipo) => {
               const valor = precio[tipo]
               const { existe } = valor
               if (!existe) count_inexist += 1
          })
          if (count_inexist > 0) modify_precio = true

          var tipos = Array.from(tipes)
          tipos.forEach((tipo) => {
               const valor = incoming[`valor_costo_${tipo}`]
               if (String(valor).trim() === '') invalido = true

               if (count_inexist === 0) {
                    const actual = precio[tipo].data.valor_costo
                    if (String(actual) != String(valor)) {
                         modify_precio = true
                         modifies[`valor_costo_${tipo}`] = valor
                    }
               }
          })

          var monedas = {}
          tipos.forEach((tipo) => {
               const moneda = $(`#monedaPrecio_${tipo}`).siblings('label').text()
               monedas[`moneda_${tipo}`] = moneda
               if (count_inexist === 0) {
                    const actual = precio[tipo].data.moneda
                    if (String(actual) != _m[String(moneda)]) {
                         modify_precio = true
                         modifies[`moneda_${tipo}`] = moneda
                    }
               }
          })

          if (invalido) {
               Swal.fire({
                    icon: 'info',
                    toast: true,
                    text: 'Completa todos los campos',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
               })
          } else {
               var data = {}
               if (count_inexist === 0) {
                    data = { ...modifies, _token: incoming._token, modify_precio }
               } else {
                    data = { ...incoming, ...monedas, modify_precio }
               }
               // var data = {
               //      modify_precio,

               //      _token: incoming._token,
               // }
               loadPost($(this).attr('action'), data)
               console.log(data)
          }
          // const { valor_costo_MEC, valor_costo_CAR, valor_costo_PANHOS, valor_costo_TYP } = incoming
          // const precio_moneda = $('#monedaPrecioServicio').siblings('label').text()
     })

     if (seccion === 'MEC') {
          if (costo_exists) {
               if (costo_exists === '1') {
                    const tipo_personal = String(costo.tipo_personal).charAt(0).toUpperCase()
                    if (tipo_personal === 'T') {
                         const metodo_costo = String(costo.metodo_costo).charAt(0).toUpperCase()
                         const moneda = String(costo.moneda).charAt(0).toUpperCase()
                         changePersonal(tipo_personal)

                         changeMetodo(metodo_costo)
                         document.querySelector('#tipoMetodoCosto').checked = metodo_costo === 'M' ? false : true

                         changeMoneda('monedaCostoAsociado', moneda)
                         document.querySelector('#monedaCostoAsociado').checked = moneda === 'S' ? false : true
                    }
               }
          }
     } else if (seccion === 'DYP') {
          if (costo_exists) {
               if (costo_exists === '1') {
                    const tipo_personal = String(costo.tipo_personal).charAt(0).toUpperCase()
                    changePersonal(tipo_personal)

                    if (tipo_personal === 'T') {
                         const metodo_costo_hh = String(costo.metodo_costo_hh).charAt(0).toUpperCase()

                         changeMetodo(metodo_costo_hh)
                         document.querySelector('#tipoMetodoCosto').checked = metodo_costo_hh === 'M' ? false : true

                         // const metodo_costo_panhos = String(costo.metodo_costo_panhos).charAt(0).toUpperCase()
                         const moneda_hh = String(costo.moneda_hh).charAt(0).toUpperCase()
                         const moneda_panhos = String(costo.moneda_panhos).charAt(0).toUpperCase()

                         changeMoneda('monedaCostoCarroceria', moneda_hh)
                         changeMoneda('monedaCostoPanho', moneda_panhos)

                         document.querySelector('#monedaCostoCarroceria').checked = moneda_hh === 'S' ? false : true
                         document.querySelector('#monedaCostoPanho').checked = moneda_panhos === 'S' ? false : true
                    }
               }
          }
     } else if (seccion === 'PDI') {
          console.log(precio)
          if (Object.keys(precio).length > 0) {
               Object.keys(precio).forEach((tipo) => {
                    const valor = precio[tipo]
                    const { existe, data } = valor
                    if (existe) {
                         const { moneda } = data
                         const letter = String(moneda).charAt(0).toUpperCase()
                         changeMoneda(`monedaPrecio_${tipo}`, letter)
                         document.querySelector(`#monedaPrecio_${tipo}`).checked = letter === 'S' ? false : true
                    }
               })
          }
     }
})
