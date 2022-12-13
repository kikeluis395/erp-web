$(function () {
     const toast = (icon = 'success', title = '') => {
          Swal.fire({
               toast: true,
               icon,
               title,
               timer: 1500,
               timerProgressBar: true,
               showConfirmButton: false,
          })
     }

     $("[id^='FormFiltrarRecepcion'], [id^='FormFiltrarRepuestos']").on('submit', function (e) {
          e.preventDefault()
          const path = window.location.pathname
          //OTS-free
          // "nroDoc"
          // "nroPlaca"
          // "nroOT"
          // "nroVIN"

          //COT-talle-free
          // 'nroDoc'
          // 'nroPlaca'
          // 'nroVIN'
          // 'nroCotizacion'
          // 'marca'
          // 'asesor'
          // 'seccion'
          // 'local'

          //COT-meson-free
          // 'nroCotizacion',
          // 'nroNV',
          // 'docCliente'

          var VALIDATE_EXISTS = [],
               fechas = [],
               text = []

          switch (path) {
               case '/consultas/ots':
                    VALIDATE_EXISTS = ['marca', 'asesor', 'local', 'seccion', 'estadoOT', 'filtroTipoOT']
                    fechas = [
                         ['fechaInicioIngreso', 'fechaFinIngreso'],
                         ['fechaInicioEntrega', 'fechaFinEntrega'],
                         ['fechaCierreInicio', 'fechaCierreFin'],
                    ]
                    text = ['nroDoc', 'nroPlaca', 'nroOT', 'nroVIN']

                    break
               case '/consultas/cotizaciones':
                    VALIDATE_EXISTS = ['estadoCotizacionTaller']
                    fechas = [['fechaCreacionIni', 'fechaCreacionFin']]
                    text = ['nroDoc', 'nroPlaca', 'nroVIN', 'nroCotizacion']
                    break
               case '/consultas/cotizacion-meson':
                    VALIDATE_EXISTS = ['estadoCotizacionMeson']
                    fechas = [
                         ['fechaAperturaIni', 'fechaAperturaFin'],
                         ['fechaFacturaIni', 'fechaFacturaFin'],
                         ['fechaCierreIni', 'fechaCierreFin'],
                    ]
                    text = ['nroCotizacion', 'nroNV', 'docCliente']
                    break
               default:
                    break
          }

          const data_form = $(this).serializeArray()
          const data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          const pick_date = VALIDATE_EXISTS.map((v) => String(data[v]).trim() != '').filter((v) => !!v).length > 0
          const filled_text = text.map((v) => String(data[v]).trim() != '').filter((v) => !!v).length > 0

          const fill_date =
               fechas
                    .map((v) => {
                         return v.map((x) => String(data[x]).trim() != '').filter((y) => !!y).length === v.length
                    })
                    .filter((v) => !v).length === fechas.length

          if (pick_date && fill_date && !filled_text) {
               toast('error', 'Completa un rango de fecha al menos')
          } else {
               const ROUTE = $(this).attr('action')
               const DATA = $(this).serialize()
               window.location.href = `${ROUTE}?${DATA}`
          }

          // console.log(pick_date)
     })

     
})
