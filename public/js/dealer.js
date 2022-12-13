$(function () {
     const search = window.location.search
     const url = new URLSearchParams(search)
     if (url.has('modal')) {
          if (url.get('modal') === 'access') {
               $('#costo_mensual').trigger('click')
          }
     }

     function load_post(url, data, type = 'POST') {
          Swal.fire({ title: 'Guardando' })
          Swal.showLoading()

          $.ajax({
               url,
               type,
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
     $('#FormGuardarAccesos').on('submit', function (e) {
          e.preventDefault()
          const data_form = $(this).serializeArray()
          var data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})
          const _token = data._token

          const checks = Array.from($('.asesor_check'))
          const check_data = checks.reduce((o, v) => ({ ...o, [v.getAttribute('name')]: v.checked }), {})

          const activos = Object.keys(check_data)
               .filter((id) => check_data[id])
               .map((v) => v.replace('ACC-', ''))
          const inactivos = Object.keys(check_data)
               .filter((id) => !check_data[id])
               .map((v) => v.replace('ACC-', ''))

          var _data = { _token, activos, inactivos }

          load_post($(this).attr('action'), _data)
     })

     function hourTime(date) {
          return moment(`2021-01-01 ${date}`).format('HH:mm')
     }

     $('#formPrecioServicio').on('submit', function (e) {
          e.preventDefault()
          const data_form = $(this).serializeArray()
          var incoming = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          const { H_D_IN, H_D_OUT, H_LV_IN, H_LV_OUT, H_S_IN, H_S_OUT, intervalo_citas: INTERVAL } = horario
          var lunes_viernes_in = String(incoming['H_LV_IN'])
          var lunes_viernes_out = String(incoming['H_LV_OUT'])
          var sabado_in = String(incoming['H_S_IN'])
          var sabado_out = String(incoming['H_S_OUT'])
          var domingo_in = String(incoming['H_D_IN'])
          var domingo_out = String(incoming['H_D_OUT'])
          var intervalo_citas = String(incoming['intervalo_citas'])

          if (
               String(H_D_IN) === domingo_in &&
               String(H_D_OUT) === domingo_out &&
               String(H_LV_IN) === lunes_viernes_in &&
               String(H_LV_OUT) === lunes_viernes_out &&
               String(H_S_IN) === sabado_in &&
               String(H_S_OUT) === sabado_out &&
               String(INTERVAL) === intervalo_citas
          ) {
               Swal.fire({
                    icon: 'info',
                    title: 'Aviso',
                    text: `La configuracion que intenga guardar es la ultima guardada. Por favor cambie la configuracion actual para proceder`,
                    confirmButtonText: 'Vale',
               })
          } else {
               var fecha = moment(last_fecha).add(1, 'day').format('DD/MM/YYYY')
               Swal.fire({
                    icon: 'info',
                    title: 'Aviso',
                    text: `La nueva configuracion se aplicara a partir del ${fecha}. ¿Quiere guardar esta configuracion?`,
                    confirmButtonText: 'Confirmar',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                         lunes_viernes_in = hourTime(lunes_viernes_in)
                         lunes_viernes_out = hourTime(lunes_viernes_out)
                         sabado_in = hourTime(sabado_in)
                         sabado_out = hourTime(sabado_out)
                         domingo_in = hourTime(domingo_in)
                         domingo_out = hourTime(domingo_out)

                         var data = {
                              lunes_viernes_in,
                              lunes_viernes_out,
                              sabado_in,
                              sabado_out,
                              domingo_in,
                              domingo_out,
                              intervalo_citas,
                         }
                         const _token = incoming._token
                         data._token = _token
                         load_post($(this).attr('action'), data)
                    },
               })
          }
     })
})
