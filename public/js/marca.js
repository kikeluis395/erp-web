$(function () {
     
     const all_options = Array.from($('#filtroModelo').children()).map((v) => ({
          name: v.innerHTML,
          id_marca: v.getAttribute('data-marca'),
          id_modelo: v.getAttribute('value'),
     }))

     const option = (text, value) => {
          const ele = document.createElement('option')
          ele.innerHTML = text
          ele.value = value
          return ele
     }
     const remove_and_put = (ele) => {
          $('#filtroModelo').empty()
          $('#filtroModelo').append(ele)
     }
     const url = new URLSearchParams(window.location.search)
     const marca = url.has('marca')

     $('#modelo_text')

     $('#filtroMarca').on('change', function (e) {
          const _select = $('#modelo_select')
          const _text = $('#modelo_text')

          const showing = (sel, txt) => {
               _select.addClass(sel ? 'block' : 'none')
               _select.removeClass(sel ? 'none' : 'block')
               _text.addClass(txt ? 'block' : 'none')
               _text.removeClass(txt ? 'none' : 'block')
          }

          let valMarca = String($('#filtroMarca').val())
          console.log(valMarca)
          if (valMarca === 'all') {
               showing(true, false)
          } else if (valMarca === '1') {
               document.querySelector('#filtroModeloOtro').setAttribute('value', '')
               showing(true, false)
               const valid = Array.from(all_options).filter((v) => v.id_marca === valMarca)
               $('#filtroModelo').empty()
               valid.forEach((v) => $('#filtroModelo').append(option(v.name, v.id_modelo)))
          } else {
               document.querySelector('#filtroModelo').selectedIndex = '0'
               showing(false, true)
          }
     })
})
