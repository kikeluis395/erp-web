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

     const VEHICULOS = Array.from(vehiculos)
     const PRECIOS = Object(precios)

     var ids = []
     if (seccion === 'NUEVOS') {
          ids = VEHICULOS.reduce((o, v) => [...o, `V${v.id_vehiculo_nuevo}`], [])
     }else if (seccion === 'SEMINUEVOS'){

     }

     console.log(ids)

     $('#formSaveNuevo').on('submit', function (e) {
          e.preventDefault()
          const indata = $(this).serializeArray()
          var incoming = indata.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          incoming.ids = ids

          loadPost($(this).attr('action'), incoming)

          console.log(incoming)
     })

     $('#formSaveSeminuevo').on('submit', function (e) {
          e.preventDefault()

          const indata = $(this).serializeArray()
          var incoming = indata.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          incoming.ids = ids

          // loadPost($(this).attr('action'), incoming)

          console.log(incoming)
     })
})
