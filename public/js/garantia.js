$(function () {
     $("[id^='FormGenerarReporteFacturadas']").on('submit', function (e) {
          $('#modalReporteFacturado').modal('hide')
     })

     $("[id^='FormSeguimientoGarantia-']").on('submit', function (e) {
          e.preventDefault()
          let buttons = Array.from($('.modal.show > div > div > div.modal-footer').children())
          buttons.forEach((v) => v.setAttribute('disabled', true))

          $.ajax({
               url: $(this).attr('action'),
               type: 'POST',
               data: $(this).serialize(),
               success: function (data) {
                    // console.log(data)
                    window.location.href = `${window.location.origin}/garantia`
               },
               error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown)
               },
          })
     })

     $("[id^='rechazadoGarantia-']").on('change', function (e) {
          let names = ['codigo_registro_portal', 'fecha_reproceso_garantia', 'motivo_garantia']

          let divs = Array.from($(this).parent().siblings()).filter((v) => v.localName === 'div')
          let avaib = divs.map((v) => v.children[1]).reduce((o, v) => ({ ...o, [v.getAttribute('name')]: v }), {})

          const motivo_rechazo = avaib['motivo_rechazo']
          motivo_rechazo.parentNode.classList.toggle('none')

          let checked = e.target.checked
          names.forEach((v) => {
               let input = avaib[v]
               if (input) {
                    if (checked) {
                         input.setAttribute('disabled', true)
                         motivo_rechazo.parentNode.classList.remove('none')
                    } else {
                         input.removeAttribute('disabled')
                         motivo_rechazo.parentNode.classList.add('none')
                    }
               }
          })
     })

     const monedas = {
          S: { name: 'Soles', symbol: 'S/' },
          D: { name: 'Dólares', symbol: '$' },
          C: {
               S: 'D',
               D: 'S',
          },
     }

     $("[id^='tipoMoneda-']").on('change', function (e) {
          let checked = e.target.checked

          let labels = Array.from($(this).parent().parent().siblings())
               .filter((v) => v.localName === 'div')
               .map((v) => v.children[0])

          var moneda = 'S'
          if (checked) moneda = 'D'

          $(this).siblings()[0].innerText = monedas[moneda].name

          var dispo = [3, 4, 5]
          dispo.forEach((v) => {
               var input = labels[v]
               if (input)
                    input.innerText = input.innerText.replace(monedas[monedas.C[moneda]].symbol, monedas[moneda].symbol)
          })
     })
})
