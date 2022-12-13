// document.querySelector('body').style.display = 'none'

$(function () {
     function message(title = 'Aviso', text = '', preConfirm = () => {}) {
          Swal.fire({
               icon: 'info',
               title,
               text,
               showConfirmButton: true,
               allowOutsideClick: false,
               confirmButtonText: 'Vale',
               preConfirm,
          })
     }
     function removeBody() {
          $('body').children('div').remove()
          $('body').css('display', 'block')
          message('Aviso', 'No tienes acceso a este modulo. Dirigite a la pagina principal', () => {
               window.location.href = `${window.location.origin}/`
          })
     }
     function accessBody(ver = false, editar = false) {
          $('body').css('display', 'block')
          // $('body').show()
          if (ver) $('main button, main input, main select, main textarea').attr('disabled', true)
     }

     const origin = window.location.origin
     const routes = Array.from($('.sb-sidenav-menu-nested a')).reduce(
          (o, v, i) => [...o, { href: v.href.replace(origin, ''), module: v.getAttribute('modulo') }],
          [],
     )

     const path = window.location.pathname
     const excluded = ['/', '/resetPassword']

     if (!excluded.find((v) => v === path)) {
          var ACTUAL_MODULE = routes.find((route) => String(route.href) === String(path))
          if (!ACTUAL_MODULE) removeBody()

          if (ACTUAL_MODULE) {
               var data = { modulo: ACTUAL_MODULE.module, _token: csrf }
               $.ajax({
                    url: `${origin}/profiles/modulo`,
                    type: 'POST',
                    data,
                    success: function (res) {
                         if (res.success) {
                              const PERMISO = res.permiso
                              if (PERMISO) {
                                   const ACCESOS = res.accesos
                                   const { editar: EDITAR, ver: VER } = ACCESOS
                                   accessBody(VER, EDITAR)
                              } else removeBody()
                         }
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                         alert(errorThrown)
                    },
               })
          }
     } else $('body').show()
     // console.log(names)
})
